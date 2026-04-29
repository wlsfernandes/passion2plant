@extends('admin.layouts.master')

@section('title', 'Media')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="uil uil-play-circle"></i> Media Library
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            @if (isset($media) && $media->count())
                <div class="mt-5">
                    <div class="row">
                        @foreach ($media as $item)
                            <div class="col-md-2 mb-3">
                                <div class="card h-100 text-center p-2">

                                    <img src="{{ Storage::disk($item->disk)->url($item->path) }}" class="img-fluid mb-2"
                                        style="height:100px; object-fit:cover; cursor:pointer;"
                                        onclick="selectImage('{{ $item->path }}')">

                                    <div class="d-grid gap-2">
                                        {{-- }}  <button type="button" class="btn btn-sm btn-outline-primary"
                                            onclick="selectImage('{{ $item->path }}')">
                                            Use
                                        </button> --}}

                                        <a href="{{ route('admin.media.download', $item->id) }}"
                                            class="btn btn-sm btn-outline-success">
                                            Download
                                        </a>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-4">
                        {{ $media->links() }}
                    </div>
                </div>
            @else
                <p class="text-muted">No media found.</p>
            @endif
        </div>
    </div>
@endsection
