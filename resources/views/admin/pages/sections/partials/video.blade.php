<div class="card border mb-4">

    <div class="card-header bg-light fw-semibold">
        Video Section
    </div>
    <div class="card-body">
        @isset($section)
            @if ($section->image_url)
                <div class="gallery-card card shadow-sm text-center" style="width:140px;">

                    <div class="p-2">

                        <img src="{{ route('admin.images.preview', [
                            'model' => 'sections',
                            'id' => $section->id,
                        ]) }}"
                            class="img-thumbnail" style="max-width:120px;">

                    </div>

                    <div class="card-body p-2">

                        <button type="button" class="btn btn-sm btn-danger w-100 delete-image"
                            data-url="{{ route('pages.sections.image.destroy', [$page, $section]) }}">

                            <i class="uil uil-trash"></i> Delete

                        </button>

                    </div>

                </div>
            @endif
        @endisset
        <div class="row mb-3">

            <div class="col-md-12">
                <label class="form-label">Image Type</label>

                <select name="image_type" class="form-select">

                    <option value="hero" {{ old('image_type', $type ?? 'hero') === 'hero' ? 'selected' : '' }}>
                        Hero Banner — 1920×600
                    </option>
                    <option value="gallery" {{ old('image_type', $type ?? '') === 'gallery' ? 'selected' : '' }}>
                        Gallery — 1200×1200
                    </option>
                    <option value="video" {{ old('image_type', $type ?? '') === 'video' ? 'selected' : '' }}>
                        Video Thumbnail — 1200×800
                    </option>
                    <option value="content" {{ old('image_type', $type ?? '') === 'content' ? 'selected' : '' }}>
                        Content — 800×800
                    </option>
                    <option value="video" {{ old('image_type', $type ?? '') === 'video' ? 'selected' : '' }}>
                        Video Thumbnail — 1200×800
                    </option>
                    <option value="cta" {{ old('image_type', $type ?? '') === 'cta' ? 'selected' : '' }}>
                        Call to Action — 900×600
                    </option>
                    <option value="card" {{ old('image_type', $type ?? '') === 'card' ? 'selected' : '' }}>
                        Card — 600×400
                    </option>
                    <option value="original_fit"
                        {{ old('image_type', $type ?? '') === 'original_fit' ? 'selected' : '' }}>
                        Original Fit
                    </option>

                </select>
                <small class="text-muted d-block mt-1">
                    Add a cover image to your Video Section. Recommended size: 1200×800 pixels.
                </small>
            </div>

        </div>


        {{-- Upload Image --}}
        <div class="mb-2">
            <label class="form-label">Upload New Cover Image</label>

            <input type="file" name="image_url" class="form-control" accept="image/*">
        </div>

        <div class="mb-2">
            <label class="form-label">Video URL</label>
            <input type="url" name="link_image" class="form-control"
                value="{{ old('link_image', $section->link_image ?? '') }}" placeholder="https://example.com">
            <small class="text-muted d-block mt-1">
                Enter the URL of the video you want to embed. Supported platforms include YouTube, Vimeo.
            </small>
        </div>

        <hr class="my-4">

        {{-- Additional Videos --}}
        @isset($section)
            @if ($section->videos->count())
                <div class="mb-4">
                    <label class="form-label d-block">Additional Videos</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach ($section->videos as $video)
                            <div class="gallery-card card shadow-sm text-center" style="width:160px;">

                                <div class="p-2">
                                    <img src="{{ route('admin.images.preview', [
                                        'model' => 'section_videos',
                                        'id' => $video->id,
                                    ]) }}"
                                        class="img-thumbnail" style="max-width:140px;">

                                    @if ($video->video_url)
                                        <div class="small text-muted mt-1 text-truncate">
                                            {{ $video->video_url }}
                                        </div>
                                    @endif
                                </div>

                                <div class="card-body p-2">
                                    <button type="button" class="btn btn-sm btn-danger w-100 delete-image"
                                        data-url="{{ route('pages.sections.videos.destroy', [$page, $section, $video]) }}">
                                        <i class="uil uil-trash"></i> Delete
                                    </button>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endisset

        <div class="mb-2">
            <label class="form-label d-block">Add More Videos</label>
            <small class="text-muted d-block mb-2">
                Add a cover image and video URL for each additional video.
            </small>

            <div id="video-repeater"></div>

            <button type="button" class="btn btn-sm btn-outline-primary" id="add-video-row">
                <i class="uil uil-plus"></i> Add Another Video
            </button>
        </div>

    </div>

</div>

<template id="video-row-template">
    <div class="row g-2 align-items-start mb-2 video-row">
        <div class="col-md-6">
            <input type="file" name="video_images[]" class="form-control" accept="image/*">
        </div>
        <div class="col-md-5">
            <input type="url" name="video_links[]" class="form-control" placeholder="https://example.com">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-danger w-100 remove-video-row" title="Remove">
                <i class="uil uil-trash"></i>
            </button>
        </div>
    </div>
</template>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const repeater = document.getElementById('video-repeater');
        const template = document.getElementById('video-row-template');
        const addBtn = document.getElementById('add-video-row');

        addBtn.addEventListener('click', function() {
            repeater.appendChild(template.content.cloneNode(true));
        });

        repeater.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-video-row');
            if (removeBtn) {
                removeBtn.closest('.video-row').remove();
            }
        });
    });
</script>