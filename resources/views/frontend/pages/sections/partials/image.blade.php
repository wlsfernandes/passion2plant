<div class="col-lg-5">

    @if ($section->image_url)
        <div class="section-image text-center">

            <img src="{{ route('admin.images.preview', [
                'model' => 'sections',
                'id' => $section->id,
            ]) }}"
                alt="{{ $section->title ?? 'Section image' }}" class="img-fluid rounded shadow-sm w-100">

        </div>
    @endif

</div>
