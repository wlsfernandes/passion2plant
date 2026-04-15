<div class="card border mb-3">

    {{-- HEADER --}}
    <div class="card-header bg-light fw-semibold py-2">
        Section Settings
    </div>

    <div class="card-body">

        {{-- =====================
            BASIC SETTINGS
        ====================== --}}
        <div class="row">


            <div class="col-md-2"><label class="form-label mb-1">Published</label>

                <input type="hidden" name="is_published" value="0">

                <div class="square-switch">
                    <input type="checkbox" id="is_published" name="is_published" switch="bool" value="1"
                        {{ old('is_published', $section->is_published ?? true) ? 'checked' : '' }}>
                    <label for="is_published" data-on-label="Yes" data-off-label="No"></label>
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label mb-1">Sort</label>
                <input type="number" name="sort_order" class="form-control form-control-sm"
                    value="{{ old('sort_order', $section->sort_order ?? 0) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label mb-1">Section Layout</label>
                <select name="layout" class="form-select form-select-sm">
                    <option value="image_left"
                        {{ old('layout', $section->layout ?? 'image_left') === 'image_left' ? 'selected' : '' }}>
                        Show Section Image Left Side
                    </option>
                    <option value="image_right"
                        {{ old('layout', $section->layout ?? 'image_left') === 'image_right' ? 'selected' : '' }}>
                        Show Section Image Right Side
                    </option>
                    <option value="full"
                        {{ old('layout', $section->layout ?? 'image_left') === 'full' ? 'selected' : '' }}>
                        Show Section Full Width (No Image)
                    </option>
                </select>
            </div>
            {{-- Container --}}
            <div class="col-md-4">
                <label class="form-label mb-1">Container</label>
                <select name="container" class="form-select form-select-sm">
                    <option value="container"
                        {{ old('container', $section->container ?? 'container') == 'container' ? 'selected' : '' }}>
                        Boxed
                    </option>
                    <option value="container-fluid"
                        {{ old('container', $section->container ?? '') == 'container-fluid' ? 'selected' : '' }}>
                        Full Width
                    </option>
                </select>
            </div>

        </div>

        {{-- =====================
            LAYOUT + COLOR
        ====================== --}}
        <div class="row g-2 align-items-end mb-2">

            {{-- Background --}}
            <div class="col-md-4">
                <label class="form-label mb-1">Select Section Background Color:</label>
                <input type="color" name="background_color" class="form-control form-control-color"
                    value="{{ old('background_color', $section->background_color ?? '#ffffff') }}">
            </div>
            {{-- Layout --}}

            {{-- MT --}}
            <div class="col-md-2">
                <label class="form-label mb-1">Margin Top:</label>
                <input type="number" name="margin_top" class="form-control form-control-sm"
                    value="{{ old('margin_top', $section->margin_top ?? 0) }}">
            </div>

            {{-- MB --}}
            <div class="col-md-2">
                <label class="form-label mb-1">Margin Bottom:</label>
                <input type="number" name="margin_bottom" class="form-control form-control-sm"
                    value="{{ old('margin_bottom', $section->margin_bottom ?? 0) }}">
            </div>

            {{-- PT --}}
            <div class="col-md-2">
                <label class="form-label mb-1">Padding Top:</label>
                <input type="number" name="padding_top" class="form-control form-control-sm"
                    value="{{ old('padding_top', $section->padding_top ?? 0) }}">
            </div>

            {{-- PB --}}
            <div class="col-md-2">
                <label class="form-label mb-1">Padding Bottom:</label>
                <input type="number" name="padding_bottom" class="form-control form-control-sm"
                    value="{{ old('padding_bottom', $section->padding_bottom ?? 0) }}">
            </div>

        </div>

        {{-- =====================
            SPACING (INLINE)
        ====================== --}}


        {{-- =====================
            BACKGROUND IMAGE
        ====================== --}}
        <div class="mb-2">

            <label class="form-label fw-semibold mb-1">Section Background Image</label>

            @isset($section)
                @if (!empty($section->background_image_url))
                    <div class="mb-2 d-flex align-items-center gap-2">
                        <img src="{{ route('admin.images.previewField', [
                            'model' => 'sections',
                            'id' => $section->id,
                            'field' => 'background_image_url',
                        ]) }}"
                            class="rounded" style="height:60px; object-fit:cover;">

                        <button type="button" class="btn btn-sm btn-outline-danger"
                            onclick="deleteBackgroundImage({{ $section->id }})">
                            Remove
                        </button>
                    </div>
                @endif
            @endisset

            <input type="file" name="background_image" class="form-control form-control-sm">

        </div>

    </div>
</div>
