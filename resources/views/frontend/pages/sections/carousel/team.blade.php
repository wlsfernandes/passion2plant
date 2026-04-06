<!--Team Section Here-->
<section class="team__section overhid pt-130 pb-130" style="{{ $section->style }}">
    <div class="container">

        @include('frontend.pages.sections.partials.content')

        <div class="swiper testimonial__wrapper">
            <div class="swiper-wrapper">

                @foreach ($featuredTeams as $team)
                    <div class="swiper-slide">
                        <div class="testi__items">

                            <div class="testi__wrap">
                                <div class="testi__thumb">
                                    <img src="{{ route('admin.images.preview', ['model' => 'teams', 'id' => $team->id]) }}"
                                        alt="{!! strip_tags($team->name) !!}" loading="lazy"
                                        onerror="this.src='/images/default-avatar.png';">
                                </div>

                                <div class="content">
                                    <h6 class="cms-html">
                                        {!! $team->name !!}
                                    </h6>

                                    <span>
                                        @foreach ($team->sectors as $sector)
                                            {!! $sector->name !!}{{ !$loop->last ? ',' : '' }}
                                        @endforeach
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>

            <!-- dots (already styled in your theme) -->
            <div class="swiper-dot text-center pt-5">
                <div class="dot"></div>
            </div>
        </div>

    </div>
</section>
<!--Team Section End-->
