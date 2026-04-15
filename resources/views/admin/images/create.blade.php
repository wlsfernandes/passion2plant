<div class="card border border-primary mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="uil uil-image-upload"></i>
            Add Image
        </h5>

        <span class="badge bg-primary">
            {{ strtoupper($modelKey ?? 'IMAGE') }}
        </span>
    </div>

    <div class="card-body">
        <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
            <strong>Image upload guidelines</strong><br>
            • Your image will be automatically converted to <strong>WebP</strong> and optimized for faster loading.<br>
            • Choose an <strong>Image Type</strong> below. This tells the system whether to <strong>crop</strong> or
            <strong>fit</strong> the image depending on the layout.<br>
            • For cropped images, keep important content centered.
        </div>

        {{-- Hidden field to save selected/uploaded path later --}}
        <input type="hidden" name="image_url" id="selected_image_url" value="{{ old('image_url') }}">

        {{-- Image Type --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">
                Image Type <span class="text-danger">*</span>
            </label>

            <select name="image_type" id="image_type_selector" class="form-select">
                <option value="section"
                    {{ old('image_type', $defaultType ?? 'section') === 'section' ? 'selected' : '' }}>
                    Section (Crop) — 800 × 800
                </option>

                <option value="banner" {{ old('image_type', $defaultType ?? '') === 'banner' ? 'selected' : '' }}>
                    Banner (Crop) — 1920 × 600
                </option>

                <option value="blog_social"
                    {{ old('image_type', $defaultType ?? '') === 'blog_social' ? 'selected' : '' }}>
                    Blog / Social (Crop) — 1200 × 630
                </option>

                <option value="event_header"
                    {{ old('image_type', $defaultType ?? '') === 'event_header' ? 'selected' : '' }}>
                    Event Header (Crop) — 1200 × 500
                </option>

                <option value="card" {{ old('image_type', $defaultType ?? '') === 'card' ? 'selected' : '' }}>
                    Card (Crop) — 900 × 600
                </option>

                <option value="square" {{ old('image_type', $defaultType ?? '') === 'square' ? 'selected' : '' }}>
                    Square / Avatar (Crop) — 800 × 800
                </option>

                <option value="logo" {{ old('image_type', $defaultType ?? '') === 'logo' ? 'selected' : '' }}>
                    Logo (No Crop) — Max 400 × 120
                </option>

                <option value="original_fit"
                    {{ old('image_type', $defaultType ?? '') === 'original_fit' ? 'selected' : '' }}>
                    Original Fit (No Crop) — Max 1600px
                </option>
            </select>

            <small class="text-muted d-block mt-1">
                <strong>Crop</strong> types keep layout consistent. <strong>Original Fit</strong> keeps the full image
                visible.
            </small>
        </div>

        {{-- Explanation --}}
        @php
            $selectedType = old('image_type', $defaultType ?? 'section');
        @endphp

        <div class="bg-light border rounded p-3 mb-4 small">
            <div class="fw-semibold mb-2">
                What will happen to your image?
            </div>

            @if ($selectedType === 'banner')
                • We will create a <strong>1920×600</strong> banner and crop to a wide layout.<br>
                • Keep text and faces centered.
            @elseif ($selectedType === 'blog_social')
                • We will create a <strong>1200×630</strong> image and crop to a social-friendly ratio.<br>
                • Great for blog and sharing images.
            @elseif ($selectedType === 'event_header')
                • We will create a <strong>1200×500</strong> header and crop to fit event layouts.<br>
                • Best with horizontal images.
            @elseif ($selectedType === 'card')
                • We will create a <strong>900×600</strong> image and crop for card consistency.<br>
                • Great for content blocks and cards.
            @elseif ($selectedType === 'square' || $selectedType === 'section')
                • We will create an <strong>800×800</strong> image and crop to a square format.<br>
                • Best for sections and compact layouts.
            @elseif ($selectedType === 'logo')
                • We will create a <strong>400×120</strong> image and keep the full image visible.<br>
                • Transparent background is recommended.
            @else
                • We will keep the whole image visible and resize up to <strong>1600px</strong>.<br>
                • Best when you do not want cropping.
            @endif

            <div class="mt-2 text-muted">
                Tip: if the image looks too cut, use a wider image or keep the main subject centered.
            </div>
        </div>

        {{-- File input --}}
        <div class="mb-3">
            <label class="form-label fw-semibold">
                Select Image
            </label>

            <input type="file" name="image_file_temp" id="image_file_temp" class="form-control" accept="image/*">

            <small class="text-muted">
                Allowed: JPG, PNG, WebP. Max 5MB.
            </small>
        </div>

        {{-- Preview placeholder --}}
        <div class="mb-3" id="selected-image-preview-wrapper" style="display: none;">
            <label class="form-label fw-semibold d-block">Selected Image</label>

            <img id="selected-image-preview" src="" alt="Selected image preview" class="img-thumbnail"
                style="max-height: 220px;">

            <div class="mt-2">
                <button type="button" class="btn btn-sm btn-outline-danger" id="remove-selected-image">
                    Remove Image
                </button>
            </div>
        </div>

        <div class="alert alert-secondary mb-0">
            You are creating a new record. The image area is ready, and in the next step we will connect this to upload
            or reuse images from the media library.
        </div>
    </div>
</div>
@if (isset($media) && $media->count())
    <hr class="my-4">

    <div class="mt-4">
        <h5 class="mb-3">
            <i class="uil uil-images"></i>
            Media Library
        </h5>

        <p class="text-muted small">
            Select an existing image from your media library.
        </p>

        <div class="row">
            @foreach ($media as $item)
                <div class="col-md-2 col-sm-3 col-6 mb-3">
                    <div class="card h-100 text-center p-2 shadow-sm">
                        <img src="{{ Storage::disk($item->disk)->url($item->path) }}"
                            alt="{{ $item->original_name ?? 'Media image' }}" class="img-fluid rounded mb-2"
                            style="height:100px; object-fit:cover; cursor:pointer;"
                            onclick="selectMediaImage('{{ $item->path }}', '{{ Storage::disk($item->disk)->url($item->path) }}')">

                        <button type="button" class="btn btn-sm btn-outline-primary"
                            onclick="selectMediaImage('{{ $item->path }}', '{{ Storage::disk($item->disk)->url($item->path) }}')">
                            Use
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
@push('scripts')
    <script>
        function selectMediaImage(path, url) {
            document.getElementById('selected_image_url').value = path;

            document.getElementById('selected-image-preview').src = url;
            document.getElementById('selected-image-preview-wrapper').style.display = 'block';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const removeButton = document.getElementById('remove-selected-image');

            if (removeButton) {
                removeButton.addEventListener('click', function() {
                    document.getElementById('selected_image_url').value = '';
                    document.getElementById('selected-image-preview').src = '';
                    document.getElementById('selected-image-preview-wrapper').style.display = 'none';
                });
            }
        });
    </script>
@endpush
