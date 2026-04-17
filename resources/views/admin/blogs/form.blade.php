@extends('admin.layouts.master')

@section('title', isset($blog) ? 'Edit Blog' : 'Create Blog')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="uil-file-alt"></i>
                {{ isset($blog) ? 'Edit Blog' : 'Create Blog' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How to create or edit a blog post:</span><br>
                • Write the <span class="text-dark">English title</span> carefully — it is used to generate the public
                URL.<br>
                • Use the <span class="text-success">Publish switch</span> to control when the blog is visible on the
                website.<br>
                • Publish dates control <span class="text-warning">visibility</span>, not the creation date.<br>
                • Content supports <span class="text-info">basic formatting</span> (bold, lists, links).<br>
                • You can unpublish a blog at any time without deleting it.
            </div>

            <hr />

            <form method="POST" action="{{ isset($blog) ? route('blogs.update', $blog) : route('blogs.store') }}">
                @csrf
                @if (isset($blog))
                    @method('PUT')
                @endif

                {{-- =======================
                Publish Controls
                ======================== --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $blog->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this blog on the website
                    </label>
                </div>

                <div class="row">
                    <div class="col-md-2 mb-3">
                        <input type="date" name="publish_start_at" class="form-control"
                            value="{{ old('publish_start_at', optional($blog->publish_start_at ?? null)->toDateString()) }}">
                        <small class="text-muted">
                            Blog becomes visible on the website.
                        </small>
                    </div>

                    <div class="col-md-2 mb-3">
                        <input type="date" name="publish_end_at" class="form-control"
                            value="{{ old('publish_end_at', optional($blog->publish_end_at ?? null)->toDateString()) }}">
                        <small class="text-muted">
                            Blog is hidden after this date.
                        </small>
                    </div>
                    <div class="col-md-8 mb-3">
                        <input type="url" name="external_link" class="form-control" placeholder="https://example.com"
                            value="{{ old('external_link', $blog->external_link ?? '') }}">
                        <small class="text-muted">
                            Optional external page with more information.
                        </small>
                    </div>
                </div>
                <hr>


                {{-- =======================
                Content
                ======================== --}}
                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label">Title (EN)</label>
                        <textarea name="title_en" class="form-control ckeditor-title" rows="3">{{ old('title_en', $blog->title_en ?? '') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Title (ES)</label>
                        <textarea name="title_es" class="form-control ckeditor-title" rows="3">{{ old('title_es', $blog->title_es ?? '') }}</textarea>

                    </div>

                </div>

                <hr>
                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label">Content (EN)</label>
                        <textarea name="content_en" class="form-control ckeditor" rows="3">{{ old('content_en', $blog->content_en ?? '') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Content (ES)</label>
                        <textarea name="content_es" class="form-control ckeditor" rows="3">{{ old('content_es', $blog->content_es ?? '') }}</textarea>

                    </div>

                </div>


                {{-- =======================
                Actions
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('blogs.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($blog) ? 'Update Blog' : 'Create Blog' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
