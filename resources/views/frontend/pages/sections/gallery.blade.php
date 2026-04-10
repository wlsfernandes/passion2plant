<section class="team__section pt-130 pb-130 overhid" style="{{ $section->style }}">
    <div class="container">

        <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
            <div class="cms-html mb-4">
                {!! $section->getTitle() !!}
            </div>

            <div class="witr_bar_main">
                <div class="witr_bar_inner witr_bar_innerc center"></div>

                <div class="cms-html mb-4">
                    {!! $section->getContent() !!}
                </div>
            </div>
        </div>

        {{-- 🔥 GALLERY CAROUSEL --}}
        <div id="galleryCarousel{{ $section->id }}" class="carousel slide gallery-carousel" data-bs-ride="carousel">

            {{-- MAIN --}}
            <div class="carousel-inner">
                @foreach ($section->images as $index => $image)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="gallery-main">

                            @if ($image->external_link)
                                <a href="{{ $image->external_link }}" target="_blank">
                            @endif

                            <img src="{{ route('admin.images.preview', [
                                'model' => 'section_images',
                                'id' => $image->id,
                            ]) }}"
                                alt="Gallery Image">

                            @if ($image->external_link)
                                </a>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>

            {{-- CONTROLS --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel{{ $section->id }}"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel{{ $section->id }}"
                data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>

            {{-- 🔥 THUMBNAILS --}}
            <div class="gallery-thumbs d-flex justify-content-center flex-wrap mt-4">
                @foreach ($section->images as $index => $image)
                    <button type="button" data-bs-target="#galleryCarousel{{ $section->id }}"
                        data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}">

                        <img src="{{ route('admin.images.preview', [
                            'model' => 'section_images',
                            'id' => $image->id,
                        ]) }}"
                            alt="Thumb">

                    </button>
                @endforeach
            </div>

        </div>

    </div>
</section>
