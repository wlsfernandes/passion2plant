@extends('admin.layouts.master')

@section('title', 'Media Library')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="uil uil-images"></i> Media Library
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Search + Filters --}}
            <form method="GET" action="{{ route('media.index') }}" class="mb-4">
                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-md-4">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control"
                            placeholder="Search by title or filename..." value="{{ request('search') }}">
                    </div>

                    {{-- Folder --}}
                    <div class="col-md-2">
                        <label class="form-label">Folder</label>
                        <select name="folder" class="form-select">
                            <option value="">All</option>
                            @foreach ($folders as $folder)
                                <option value="{{ $folder }}" {{ request('folder') == $folder ? 'selected' : '' }}>
                                    {{ ucfirst($folder) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Extension --}}
                    <div class="col-md-2">
                        <label class="form-label">Extension</label>
                        <select name="extension" class="form-select">
                            <option value="">All</option>
                            @foreach ($extensions as $extension)
                                <option value="{{ $extension }}"
                                    {{ request('extension') == $extension ? 'selected' : '' }}>
                                    {{ strtoupper($extension) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="uil uil-search"></i> Filter
                        </button>

                        <a href="{{ route('media.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>

            {{-- Media Grid --}}
            @if (isset($media) && $media->count())
                <div class="row">
                    @foreach ($media as $item)
                        <div class="col-md-3 mb-4">
                            <div class="card h-100 shadow-sm">

                                {{-- Preview --}}
                                <div class="card h-100">
                                    <div
                                        style="
                                      height: 220px;
                                      background: #f8f9fa;
                                      display: flex;
                                      align-items: flex-start;
                                      justify-content: center;
                                      overflow: hidden;
                                      padding: 10px;
                                  ">
                                        <img src="{{ Storage::disk($item->disk)->url($item->path) }}" alt="Media Preview"
                                            style="
                                              max-width: 100%;
                                              max-height: 100%;
                                              width: auto;
                                              height: auto;
                                              object-fit: contain;
                                              object-position: top center;
                                              cursor: pointer;
                                          "
                                            onclick="window.open('{{ Storage::disk($item->disk)->url($item->path) }}', '_blank')">
                                    </div>
                                </div>
                                <div class="card-body">

                                    {{-- Title --}}
                                    <h6 class="fw-bold mb-2">
                                        {{ $item->title ?: $item->original_name }}
                                    </h6>

                                    {{-- File Info --}}
                                    <small class="text-muted d-block">
                                        <strong>File:</strong> {{ $item->original_name }}
                                    </small>

                                    <small class="text-muted d-block">
                                        <strong>Size:</strong>
                                        {{ number_format($item->size / 1024 / 1024, 2) }} MB
                                    </small>

                                    <small class="text-muted d-block">
                                        <strong>Type:</strong> {{ strtoupper($item->extension) }}
                                    </small>

                                    <small class="text-muted d-block">
                                        <strong>Folder:</strong> {{ $item->folder ?: '—' }}
                                    </small>

                                    <small class="text-muted d-block">
                                        <strong>Uploaded:</strong>
                                        {{ $item->created_at?->format('M d, Y') }}
                                    </small>

                                </div>

                                {{-- Actions --}}
                                <div class="card-footer bg-white border-top-0">
                                    <div class="d-grid gap-2">

                                        {{-- Copy URL --}}
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="copyToClipboard('{{ Storage::disk($item->disk)->url($item->path) }}')">
                                            <i class="uil uil-copy"></i> Copy URL
                                        </button>

                                        {{-- Download --}}
                                        <a href="{{ route('media.download', $item->id) }}"
                                            class="btn btn-sm btn-outline-success">
                                            <i class="uil uil-download-alt"></i> Download
                                        </a>

                                        {{-- Delete 
                                        <form action="{{ route('media.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this file?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                                <i class="uil uil-trash"></i> Delete
                                            </button>
                                        </form>
                                        --}}
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $media->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-muted mb-0">
                        No media found.
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text)
                .then(() => {
                    alert('File URL copied successfully!');
                })
                .catch(err => {
                    console.error(err);
                    alert('Failed to copy URL.');
                });
        }
    </script>
@endsection
