<!--Team Section Here-->
<section class="team__section pt-130 pb-130 overhid" style="{{ $section->style }}">
    <div class="container">
        @include('frontend.pages.sections.partials.content')

        <div class="swiper team__wrapper">
            <div class="swiper-wrapper">

                @foreach ($featuredTeams as $team)
                    <div class="swiper-slide">
                        <div class="team__items position-relative">
                            <a href="{{ route('team.profile', strip_tags($team->slug)) }}" class="stretched-link"></a>

                            <div class="team__thumb">
                                <img src="{{ route('admin.images.preview', ['model' => 'teams', 'id' => $team->id]) }}"
                                    alt="{!! strip_tags($team->name) !!}" loading="lazy"
                                    onerror="this.src='/images/default-avatar.png';">
                            </div>

                            <div class="team__content">
                                <div class="cms-html">{!! $team->name !!}</div>

                                <div class="team__meta d-flex justify-content-center flex-wrap gap-2 mt-3">
                                    @foreach ($team->sectors as $sector)
                                        <span class="badge bg-light text-dark px-3 py-2 mt-1">
                                            {!! $sector->name !!}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Optional dots -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
<!--Team Section End-->
