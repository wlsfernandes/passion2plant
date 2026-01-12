@extends('frontend.layouts.app')
@section('title', 'Passion2Plant - ' . $project->title)
@section('content')

  <!-- Project Details Section -->
  <section class="details__section event__section overhid pt-130 pb-130">
    <div class="container">
      <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
        <h6>@lang('pages.cohorts')</h6>
        <h3>@lang('pages.cohorts_description')</h3>
      </div>
      <div class="row g-4">
        <div class="col-lg-12">

          <div class="details__items">

            {{-- Project Title --}}
            <div class="details__content mb-40">
              <h3>{{ $project->title }}</h3>
              {{-- Optional Dates --}}
              @if ($project->start_date || $project->end_date)
                <div>
                  <p class="text-muted">
                    @if ($project->start_date)
                      <strong>Start:</strong> {{ $project->start_date->format('F Y') }}
                    @endif
                    @if ($project->end_date)
                      &nbsp;|&nbsp;
                      <strong>End:</strong> {{ $project->end_date->format('F Y') }}
                    @endif
                  </p>
                </div>
              @endif
            </div>

            {{-- Project Description --}}
            <div class="details__content mb-20">
              {!! $project->description !!}
            </div>

            {{-- Project Images --}}
            @if ($project->images->count())
              @php $count = $project->images->count(); @endphp

              <div class="img__item mt-40">
                <div class="row g-3 justify-content-center">

                  @foreach ($project->images as $image)
                    <div
                      class="
                        {{ $count === 1 ? 'col-lg-6 col-md-8 text-center' : '' }}
                        {{ $count === 2 ? 'col-md-6' : '' }}
                        {{ $count >= 3 ? 'col-lg-4 col-md-6' : '' }}
                      ">

                      <div class="project-image-wrapper">
                        <img
                          src="{{ route('admin.images.preview', [
                              'model' => 'project-images',
                              'id' => $image->id,
                          ]) }}"
                          alt="{{ $project->title }}" loading="lazy">
                      </div>

                    </div>
                  @endforeach

                </div>
              </div>
            @endif


            <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">

              @if (!empty($project->external_link))
                <a href="{{ $project->external_link }}" class="cmn--btn cmn--btn-outline" target="_blank"
                  rel="noopener noreferrer">
                  <i class="uil uil-external-link-alt"></i>
                  @lang('pages.apply_now')
                </a>
              @endif

            </div>
          </div>

        </div>
      </div>
    </div>
  </section>
  <!-- Project Details Section End -->

@endsection
