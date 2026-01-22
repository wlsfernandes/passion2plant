@extends('frontend.layouts.app')

@section('title', 'Our Team')

@section('content')

  <!-- Team Section Here -->
  <section class="team__section pt-130 pb-130 overhid">
    <div class="container">

      @foreach ($sectors as $sector)
        @php
          $sectorTeams = $teams->filter(fn($team) => $team->sectors->contains($sector->id));
        @endphp

        @if ($sectorTeams->count())
          {{-- Sector title --}}
          <div class="mb-5">
            <h2 class="heading-gradient-green-black text-center">
              {{ $sector->name }}
            </h2>
          </div>

          <div class="row g-4 mb-60">

            @foreach ($sectorTeams as $team)
              <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 wow fadeInUp"
                data-wow-duration="{{ 3 + ($loop->index % 4) * 2 }}s">

                <div class="team__items position-relative">

                  {{-- Full card link --}}
                  <a href="{{ route('team.profile', $team->slug) }}" class="stretched-link"
                    aria-label="{{ $team->name }}"></a>

                  {{-- Image --}}
                  <div class="team__thumb">
                    <img src="{{ route('admin.images.preview', ['model' => 'teams', 'id' => $team->id]) }}"
                      alt="{{ $team->name }}" loading="lazy">
                  </div>

                  {{-- Content --}}
                  <div class="team__content">
                    <h6>{{ $team->name }}</h6>

                    @if ($team->role)
                      <span class="team-role-badge" title="{{ $team->role }}">
                        {{ $team->role }}
                      </span>
                    @endif
                  </div>

                </div>
              </div>
            @endforeach

          </div>
        @endif
      @endforeach

    </div>
  </section>
  <!-- Team Section End -->

@endsection
