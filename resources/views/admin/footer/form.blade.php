@extends('admin.layouts.master')

@section('title')
    Footer Settings
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card border border-primary">
                <div class="card-header bg-transparent border-primary">
                    <h5 class="my-0 text-primary">
                        <i class="uil-window"></i> Footer Settings
                    </h5>
                </div>

                <div class="card-body">

                    <x-alert />

                    <form action="{{ route('footer.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            {{-- TITLE EN --}}
                            <div class="row g-4">

                                <div class="col-md-6">
                                    <label class="form-label">Title (EN)</label>
                                    <textarea name="title_en" class="form-control ckeditor-title" rows="3">{{ old('title_en', $footer->title_en ?? '') }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Title (ES)</label>
                                    <textarea name="title_es" class="form-control ckeditor-title" rows="3">{{ old('title_es', $footer->title_es ?? '') }}</textarea>

                                </div>

                            </div>


                            {{-- SUBTITLE EN --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Subtitle (English)</label>
                                <textarea name="subtitle_en" class="form-control ckeditor" rows="3">{{ old('subtitle_en', $footer->subtitle_en ?? '') }}</textarea>
                            </div>

                            {{-- SUBTITLE ES --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Subtitle (Spanish)</label>
                                <textarea name="subtitle_es" class="form-control ckeditor" rows="3">{{ old('subtitle_es', $footer->subtitle_es ?? '') }}</textarea>
                            </div>

                            {{-- IMAGE --}}
                            <div class="col-md-12 mb-4">
                                <label class="form-label">Footer Image</label>

                                <input type="file" name="image_url" class="form-control">

                                {{-- Preview --}}
                                @if (isset($footer) && $footer->image_url)
                                    <div class="mb-4 text-center">
                                        <div class="mb-2 fw-semibold">Current image</div>
                                        <img src="{{ route('admin.images.preview', ['model' => 'footer', 'id' => $footer->id]) }}"
                                            class="img-thumbnail mb-3" style="max-height: 220px;" alt="Current image">
                                    </div>
                                @endif
                            </div>

                        </div>

                        {{-- ACTIONS --}}
                        <div class="d-flex justify-content-end">

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                {{ isset($footer) ? 'Update Footer' : 'Save Footer' }}
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
