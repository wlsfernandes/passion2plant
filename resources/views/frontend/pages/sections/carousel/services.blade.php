@php
    use Illuminate\Support\Str;

    $count = $services->count();
    $useCarousel = $count >= 3;
@endphp

<!-- Service Section Here -->
<section class="service__section section__bg pt-130 pb-130 overhid" style="{{ $section->style ?? '' }}">
    <div class="container">

        @include('frontend.pages.sections.partials.content')

        @if ($useCarousel)
            {{-- CAROUSEL MODE (3+ items) --}}
            <div class="swiper donate__wrapper">
                <div class="swiper-wrapper">

                    @foreach ($services as $service)
                        <div class="swiper-slide wow fadeInUp" data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                            @include('frontend.pages.sections.carousel.cards.service', [
                                'service' => $service,
                            ])

                        </div>
                    @endforeach

                </div>

                <div class="swiper-dot text-center pt-5">
                    <div class="dot"></div>
                </div>
            </div>
        @else
            {{-- GRID MODE (1–2 items) --}}
            <div class="row g-4 justify-content-center">

                @forelse($featuredServices as $service)
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-12 wow fadeInUp"
                        data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                        @include('frontend.pages.sections.carousel.cards.service', ['service' => $service])

                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        @lang('pages.no_services_available')
                    </div>
                @endforelse

            </div>
        @endif

    </div>
</section>
<!-- Service Section End -->
