<section class="team__section pt-130 pb-130 overhid" style="{{ $section->style }}">
    <div class="container">

        @include('frontend.pages.sections.partials.content')

        <div class="swiper team__wrapper">
            <div class="swiper-wrapper">

                @foreach ($featuredTeams as $team)
                    <div class="swiper-slide wow fadeInUp" data-wow-duration="{{ 3 + $loop->index * 2 }}s">

                        <div class="team__items position-relative">
                            <a href="{{ route('team.profile', strip_tags($team->slug)) }}" class="stretched-link"></a>

                            <div class="team__thumb">
                                <img src="{{ route('admin.images.preview', ['model' => 'teams', 'id' => $team->id]) }}"
                                    alt="{!! $team->name !!}" loading="lazy">
                            </div>

                            <div class="team__content">
                                <div class="cms-html">{!! $team->name !!}</div>

                                <div class="team__meta d-flex justify-content-center flex-wrap gap-5 mt-3">
                                    @foreach ($team->sectors as $sector)
                                        <span class="badge bg-light text-dark px-3 py-2 mt-2">
                                            {!! $sector->name !!}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>

    </div>
</section>
@push('scripts')
    <script>
        const teamSwiper = new Swiper('.team__wrapper', {
            loop: true,
            spaceBetween: 30,
            slidesPerView: 3,

            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },

            pagination: {
                el: '.team__wrapper .dot',
                clickable: true,
            },

            breakpoints: {
                0: {
                    slidesPerView: 1
                },
                576: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                992: {
                    slidesPerView: 3
                }
            }
        });
    </script>
@endpush('scripts')
