<section class="donate__section pt-130 pb-130" style="{{ $section->style ?? '' }}">
    <div class="container">

        @include('frontend.pages.sections.partials.content')

        <div class="swiper donate__wrapper">
            <div class="swiper-wrapper">

                @foreach ($featuredTeams as $team)
                    <div class="swiper-slide">
                        <div class="donate__items">

                            {{-- Image --}}
                            <div class="donate__thumb">
                                <img src="{{ route('admin.images.preview', ['model' => 'teams', 'id' => $team->id]) }}"
                                    alt="{!! $team->name !!}" loading="lazy">
                            </div>

                            {{-- Content --}}
                            <div class="donate__content text-center">

                                <h5 class="mb-2">
                                    <a href="{{ route('team.profile', $team->slug) }}">
                                        {!! $team->display_name !!}
                                    </a>
                                </h5>

                                {{-- Roles / Sectors --}}
                                <div class="d-flex justify-content-center flex-wrap gap-2 mt-2">
                                    @foreach ($team->sectors as $sector)
                                        <span class="badge bg-light text-dark px-3 py-2">
                                            {!! $sector->name !!}
                                        </span>
                                    @endforeach
                                </div>

                            </div>

                        </div>
                    </div>
                @endforeach

            </div>

            <div class="swiper-dot text-center pt-5">
                <div class="dot"></div>
            </div>
        </div>

    </div>
</section>
