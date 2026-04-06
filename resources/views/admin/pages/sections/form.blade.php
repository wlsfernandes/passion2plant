@extends('admin.layouts.master')

@section('title', isset($section) ? 'Edit Page Section' : 'Add Page Section')

@section('content')

    @php
        $type = old('type', $section->type ?? request('type', 'content'));
    @endphp

    <div class="card border border-primary">

        <div class="card-header">
            @switch($type)
                @case('content')
                    <img src="{{ asset('assets/admin/images/icons/content.png') }}" alt="Content Icon" width="96">
                @break

                @case('cta')
                    <img src="{{ asset('assets/admin/images/icons/cta.png') }}" alt="CTA Icon" width="96">
                @break

                @case('promo')
                    <img src="{{ asset('assets/admin/images/icons/promo.png') }}" alt="Promo Icon" width="96">
                @break

                @case('gallery')
                    <img src="{{ asset('assets/admin/images/icons/gallery.png') }}" alt="Gallery Icon" width="96">
                @break

                @case('hero')
                    <img src="{{ asset('assets/admin/images/icons/header.png') }}" alt="Banner Icon" width="96">
                @break

                @case('video')
                    <img src="{{ asset('assets/admin/images/icons/video.png') }}" alt="Video Icon" width="96">
                @break

                @default
            @endswitch
            <h5 class="mb-0">
                <i class="uil uil-layers"></i>
                {{ isset($section) ? 'Edit Section ' . ucfirst($type) : 'Create Section' . ' ' . ucfirst($type) }}
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
                <input type="hidden" name="type" value="{{ $type }}">
                @include('admin.pages.sections.types.settings', ['type' => $type])

                <div class="card border border-secondary mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">🎨 Section Styling</h5>
                        <small class="text-muted">Control spacing, colors, and background</small>
                    </div>

                    <div class="card-body">

                        {{-- SPACING --}}
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="form-label">Margin Top (px)</label>
                                <input type="number" name="margin_top" class="form-control"
                                    value="{{ old('margin_top', $section->margin_top ?? 0) }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Margin Bottom (px)</label>
                                <input type="number" name="margin_bottom" class="form-control"
                                    value="{{ old('margin_bottom', $section->margin_bottom ?? 0) }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Padding Top (px)</label>
                                <input type="number" name="padding_top" class="form-control"
                                    value="{{ old('padding_top', $section->padding_top ?? 0) }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Padding Bottom (px)</label>
                                <input type="number" name="padding_bottom" class="form-control"
                                    value="{{ old('padding_bottom', $section->padding_bottom ?? 0) }}">
                            </div>
                        </div>

                        {{-- COLORS --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Background Color</label>
                                <input type="color" name="background_color" class="form-control form-control-color"
                                    value="{{ old('background_color', $section->background_color ?? '#ffffff') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Text Color</label>
                                <input type="color" name="text_color" class="form-control form-control-color"
                                    value="{{ old('text_color', $section->text_color ?? '#000000') }}">
                            </div>
                        </div>

                        {{-- BACKGROUND IMAGE --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Background Image</label>

                            {{-- Preview --}}
                            @if (!empty($section->background_image_url))
                                <div class="mb-2">
                                    <img src="{{ route('admin.images.previewField', [
                                        'model' => 'sections',
                                        'id' => $section->id,
                                        'field' => 'background_image_url',
                                    ]) }}"
                                        alt="Background Image" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            @endif

                            {{-- File Upload --}}
                            <input type="file" name="background_image" class="form-control">

                            {{-- Keep existing value --}}
                            <input type="hidden" name="background_image"
                                value="{{ old('background_image_url', $section->background_image_url ?? '') }}">

                            <small class="text-muted">
                                Upload a new image to replace the current one.
                            </small>
                        </div>

                        {{-- LAYOUT --}}
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">Container Type</label>
                                <select name="container" class="form-select">
                                    <option value="container"
                                        {{ old('container', $section->container ?? 'container') == 'container' ? 'selected' : '' }}>
                                        Boxed (container)
                                    </option>
                                    <option value="container-fluid"
                                        {{ old('container', $section->container ?? '') == 'container-fluid' ? 'selected' : '' }}>
                                        Full Width (container-fluid)
                                    </option>
                                </select>
                            </div>


                        </div>

                    </div>
                </div>

                @if ($type === 'promo')
                    @include('admin.pages.sections.partials.button')
                    @include('admin.pages.sections.types.content')
                    @include('admin.pages.sections.partials.image')
                @endif

                @if ($type === 'content')
                    @include('admin.pages.sections.types.content')
                    @include('admin.pages.sections.partials.image')
                    @include('admin.pages.sections.partials.image-layout')
                @endif

                @if ($type === 'cta')
                    @include('admin.pages.sections.partials.button')
                    @include('admin.pages.sections.types.content')
                    @include('admin.pages.sections.partials.image')
                    @include('admin.pages.sections.partials.image-layout')
                @endif
                @if ($type === 'feature')
                    @include('admin.pages.sections.types.content')
                    @include('admin.pages.sections.types.feature')
                @endif
                @if ($type === 'carousel')
                    @include('admin.pages.sections.types.content')
                    @include('admin.pages.sections.types.carousel')
                @endif
                @if ($type === 'gallery')
                    @include('admin.pages.sections.types.content')
                    @include('admin.pages.sections.partials.multiple-images')
                @endif

                @if ($type === 'video')
                    @include('admin.pages.sections.partials.button')
                    @include('admin.pages.sections.types.content')
                    @include('admin.pages.sections.partials.image')
                    @include('admin.pages.sections.partials.image-layout')
                @endif





                @include('admin.pages.sections.partials.actions')

            </form>

        </div>
    </div>

@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.delete-image').forEach(function(button) {

                button.addEventListener('click', function(e) {

                    e.preventDefault();

                    if (!confirm('Delete this image?')) {
                        return;
                    }

                    const url = this.getAttribute('data-url');

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                _method: 'DELETE'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {

                            if (data.success) {
                                this.closest('.gallery-card').remove();
                            } else {
                                alert('Failed to delete image');
                            }

                        })
                        .catch(function(error) {
                            console.error(error);
                            alert('Server error');
                        });

                });

            });

        });
    </script>
@endsection
