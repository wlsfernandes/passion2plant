<!-- Partners / Clients Section -->
<section class="partners__section pt-130 pb-130">
    <div class="container">
        @include('frontend.pages.sections.partials.content')
        <div class="partners__grid">
            @foreach ($partnerLogos as $partner)
                <div class="partner__item">

                    @if ($partner->external_link)
                        <a href="{{ $partner->external_link }}" target="_blank" rel="noopener noreferrer">
                    @endif

                    <img src="{{ route('admin.images.preview', ['model' => 'partners', 'id' => $partner->id]) }}"
                        alt="{{ $partner->name }}" loading="lazy">

                    @if ($partner->external_link)
                        </a>
                    @endif

                </div>
            @endforeach

        </div>

    </div>
</section>
<!-- Partners / Clients Section End -->
