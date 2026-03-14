<div class="card border mb-4">

    <div class="card-header bg-light fw-semibold">
        Section Content
    </div>

    <div class="card-body">

        <div class="row g-4">

            <div class="col-md-6">
                <label class="form-label">Title (EN)</label>
                <textarea name="title_en" class="form-control ckeditor-title" rows="3">{{ old('title_en', $section->title_en ?? '') }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label">Title (ES)</label>
                <textarea name="title_es" class="form-control ckeditor-title" rows="3">{{ old('title_es', $section->title_es ?? '') }}</textarea>
            </div>

        </div>

        <div class="mt-4">
            <label class="form-label">Content (EN)</label>
            <textarea name="content_en" class="form-control ckeditor" rows="6">{{ old('content_en', $section->content_en ?? '') }}</textarea>
        </div>

        <div class="mt-3">
            <label class="form-label">Content (ES)</label>
            <textarea name="content_es" class="form-control ckeditor" rows="6">{{ old('content_es', $section->content_es ?? '') }}</textarea>
        </div>

    </div>
</div>
