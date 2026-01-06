<!--Team Section Here-->
<section class="team__section pt-130 pb-130 overhid">
    <div class="container">

        <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
            <h6>@lang('pages.our_team')</h6>
            <div class="witr_bar_main">
                <div class="witr_bar_inner witr_bar_innerc center"></div>
                <h3>@lang('pages.our_team_description')</h3>
            </div>
        </div>

        <div class="row g-4">

            @foreach($teams as $team)
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 wow fadeInUp"
                     data-wow-duration="{{ 3 + ($loop->index * 2) }}s">

                    <div class="team__items">
  <a
                            href="{{ route('team.profile', $team->slug) }}"
                            class="stretched-link"
                            aria-label="{{ $team->name }}"
                        ></a>

                        <div class="team__thumb">
                            <img
                                src="{{ route('admin.images.preview', ['model' => 'teams', 'id' => $team->id]) }}"
                                alt="{{ $team->name }}"
                                loading="lazy"
                            >
                        </div>

                        <div class="team__content">

                            <h6>
                                    {{ $team->name }}
                            </h6>

                            {{-- REPLACEMENT FOR SOCIAL ICONS --}}
                            <div class="team__meta d-flex justify-content-center mt-2">
                                <span class="badge bg-light text-dark px-3 py-2">
                                    {{ \App\Models\Team::SECTORS[$team->sector] ?? ucfirst($team->sector) }}
                                </span>
                            </div>

                        </div>
                    </div>

                </div>
            @endforeach

        </div>
    </div>
</section>
<!--Team Section End-->
