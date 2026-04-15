@extends('admin.layouts.master')

@section('title', 'Footer')

@section('content')

    <div class="card border">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="uil uil-window-section"></i> Footer
            </h5>
        </div>

        <div class="card-body p-2">

            <x-alert />

            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Image</th>
                            <th>Content</th>
                            <th class="text-end" style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="align-middle text-center">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    @if ($footer->image_url)
                                        <a href="{{ route('admin.images.preview', ['model' => 'footer', 'id' => $footer->id]) }}"
                                            target="_blank" title="View image">
                                            <img src="{{ route('admin.images.preview', ['model' => 'footer', 'id' => $footer->id]) }}"
                                                alt="Footer image" class="rounded-circle mb-1"
                                                style="width:80px;height:80px;object-fit:cover;">
                                        </a>
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                                            style="width:80px;height:80px;">
                                            <i class="uil uil-image text-muted font-size-24"></i>
                                        </div>
                                    @endif

                                    {{-- Edit / Upload --}}
                                    <a href="{{ route('admin.images.edit', ['model' => 'footer', 'id' => $footer->id]) }}"
                                        class="text-primary small" title="Upload / Change image">
                                        <i class="uil uil-edit"></i> Edit
                                    </a>
                                </div>
                            </td>
                            <td>
                                {{ strip_tags(Str::limit($footer->title_en ?? 'No footer content', 120)) }}
                            </td>

                            <td class="text-end">
                                <a href="{{ route('footer.edit', $footer->id ?? 1) }}" class="btn btn-sm btn-primary">
                                    <i class="uil uil-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
