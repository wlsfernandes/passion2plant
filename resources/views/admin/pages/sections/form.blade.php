@extends('admin.layouts.master')

@section('title', isset($section) ? 'Edit Page Section' : 'Add Page Section')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="uil uil-layers"></i>
                {{ isset($section) ? 'Edit Section' : 'Create Section' }}
            </h5>
            <small class="text-muted">
                Page: {{ $page->title }}
            </small>
        </div>

        <div class="card-body">
            <x-alert />

            <form method="POST"
                action="{{ isset($section) ? route('pages.sections.update', [$page, $section]) : route('pages.sections.store', $page) }}"
                enctype="multipart/form-data">

                @csrf
                @isset($section)
                    @method('PUT')
                @endisset

                {{-- Sort Order --}}
                {{-- Order & Publish --}}
                <div class="row mb-4">
                    <div class="col-md-2">
                        <label class="form-label d-block">Published</label>
                        <input type="hidden" name="is_published" value="0">

                        <div class="square-switch mt-2">
                            <input type="checkbox" id="is_published" name="is_published" switch="bool" value="1"
                                {{ old('is_published', $section->is_published ?? true) ? 'checked' : '' }}>
                            <label for="is_published" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control"
                            value="{{ old('sort_order', $section->sort_order ?? 0) }}">
                        <small class="text-muted">
                            Lower numbers appear first.
                        </small>
                    </div>


                </div>

                <hr>


                {{-- Image --}}
                <div class="mb-4">
                    <label class="form-label">Section Image</label>

                    @isset($section)
                        @if ($section->image_url)
                            <div class="mb-2">
                                <img src="{{ route('admin.images.preview', ['model' => 'sections', 'id' => $section->id]) }}"
                                    class="img-thumbnail" style="max-width:200px;">
                            </div>
                        @endif
                    @endisset

                    <input type="file" name="image_url" class="form-control" accept="image/*">

                    <small class="text-muted">
                        Optional. Recommended width ≥ 1200px.
                    </small>
                </div>

                <hr>

                {{-- English --}}
                <h6 class="mb-3">English Content</h6>

                <div class="mb-3">
                    <label class="form-label">Title (EN)</label>
                    <input type="text" name="title_en" class="form-control"
                        value="{{ old('title_en', $section->title_en ?? '') }}">
                </div>

                <textarea name="content_en" id="content_en" class="form-control section-editor" rows="6"
                    placeholder="Write the section content in English...">{{ old('content_en', $section->content_en ?? '') }}</textarea>

                <small class="text-muted">
                    You can use basic formatting (paragraphs, lists).
                </small>

                <hr>

                {{-- Spanish --}}
                <h6 class="mb-3">Spanish Content</h6>

                <div class="mb-3">
                    <label class="form-label">Title (ES)</label>
                    <input type="text" name="title_es" class="form-control"
                        value="{{ old('title_es', $section->title_es ?? '') }}">
                </div>

                <textarea name="content_es" id="content_es" class="form-control section-editor" rows="6"
                    placeholder="Escriba el contenido de la sección en Español...">{{ old('content_es', $section->content_es ?? '') }}</textarea>


                <hr>
                {{-- Actions --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('pages.sections.index', $page) }}" class="btn btn-light">
                        <i class="uil uil-arrow-left"></i> Back
                    </a>

                    <button class="btn btn-primary">
                        <i class="uil uil-save"></i>
                        {{ isset($section) ? 'Update Section' : 'Create Section' }}
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('/assets/admin/libs/ckeditor/ckeditor.min.js') }}"></script>
    <script>
        function createSimpleEditor(selector) {
            ClassicEditor.create(document.querySelector(selector), {
                removePlugins: [
                    'Image', 'ImageToolbar', 'ImageCaption', 'ImageStyle', 'ImageUpload', 'MediaEmbed'
                ],
                toolbar: [
                    'heading', '|', 'bold', 'italic', 'link',
                    'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo'
                ]
            }).catch(console.error);
        }

        createSimpleEditor('#content_en');
        createSimpleEditor('#content_es');
    </script>
@endsection
