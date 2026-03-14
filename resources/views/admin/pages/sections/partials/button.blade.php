<div class="card border mb-4">

    <div class="card-header bg-light fw-semibold">
        Buttons
    </div>

    <div class="card-body">

        <div class="row g-4">

            <div class="col-md-6">
                <label class="form-label">Button Text</label>

                <input type="text" name="button_text" class="form-control"
                    value="{{ old('button_text', $section->button_text ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Button Link</label>

                <input type="url" name="external_link" class="form-control"
                    value="{{ old('external_link', $section->external_link ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Button Position</label>

                <select name="button_position" class="form-select">

                    <option value="left"
                        {{ old('button_position', $section->button_position ?? 'left') === 'left' ? 'selected' : '' }}>
                        Left
                    </option>

                    <option value="center"
                        {{ old('button_position', $section->button_position ?? '') === 'center' ? 'selected' : '' }}>
                        Center
                    </option>

                    <option value="right"
                        {{ old('button_position', $section->button_position ?? '') === 'right' ? 'selected' : '' }}>
                        Right
                    </option>

                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Button Color</label>

                <select name="button_color" class="form-select">

                    <option value="primary"
                        {{ old('button_color', $section->button_color ?? 'primary') === 'primary' ? 'selected' : '' }}>
                        Primary
                    </option>

                    <option value="secondary"
                        {{ old('button_color', $section->button_color ?? '') === 'secondary' ? 'selected' : '' }}>
                        Secondary
                    </option>

                    <option value="success"
                        {{ old('button_color', $section->button_color ?? '') === 'success' ? 'selected' : '' }}>
                        Success
                    </option>

                    <option value="danger"
                        {{ old('button_color', $section->button_color ?? '') === 'danger' ? 'selected' : '' }}>
                        Danger
                    </option>

                    <option value="dark"
                        {{ old('button_color', $section->button_color ?? '') === 'dark' ? 'selected' : '' }}>
                        Dark
                    </option>

                </select>
            </div>

        </div>

    </div>

</div>
