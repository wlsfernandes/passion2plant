<!-- Partners / Clients Section -->
<section class="partners__section pt-130 pb-130" style="{{ $section->style ?? '' }}">
    <div class="container">
        @include('frontend.pages.sections.partials.content')
        <div class="partners__grid">
            @foreach ($educatorLogos as $educator)
                <div class="partner__item">

                    @if ($educator->external_link)
                        <a href="{{ $educator->external_link }}" target="_blank" rel="noopener noreferrer"
                            class="partner-link">
                    @endif

                    <img src="{{ route('admin.images.preview', ['model' => 'educators', 'id' => $educator->id]) }}"
                        alt="{{ $educator->name }}" loading="lazy">

                    @if ($educator->external_link)
                        </a>
                    @endif

                </div>
            @endforeach

        </div>

    </div>
</section>
<!-- Partners / Clients Section End -->
