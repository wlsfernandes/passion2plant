@php
    use Illuminate\Support\Str;

    $count = $donations->count();
    $useCarousel = $count >= 3;
@endphp

<section class="blog__section section__bg pt-130 pb-130 overhid" style="{{ $section->style }}">
    <div class="container">

        @include('frontend.pages.sections.partials.content')

        @if ($useCarousel)
            {{-- =========================
                CAROUSEL MODE (3+ items)
            ========================== --}}
            <div class="swiper donate__wrapper">
                <div class="swiper-wrapper">

                    @foreach ($donations as $donation)
                        <div class="swiper-slide wow fadeInUp" data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                            @include('frontend.pages.sections.carousel.cards.donation', [
                                'donation' => $donation,
                            ])

                        </div>
                    @endforeach

                </div>

                <div class="swiper-dot text-center pt-5">
                    <div class="dot"></div>
                </div>
            </div>
        @else
            {{-- =========================
                GRID MODE (1–2 items)
            ========================== --}}
            <div class="row g-4 justify-content-center">

                @forelse($featuredDonations as $donation)
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-12 wow fadeInUp"
                        data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                        @include('frontend.pages.sections.carousel.cards.donation', [
                            'donation' => $donation,
                        ])

                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        @lang('pages.no_donations_available')
                    </div>
                @endforelse

            </div>
        @endif

    </div>
</section>
