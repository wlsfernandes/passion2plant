@extends('frontend.layouts.app')

@section('title', __('pages.media'))

@section('content')

  @php
    use Illuminate\Support\Str;
  @endphp

  <section class="service__section section__bg pt-130 pb-130 overhid">
    <div class="container">
      <div class="row g-4">

        @forelse ($mediaTypes as $type)
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp"
            data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

            <div class="service__items center">

              {{-- Image --}}
              <div class="thumb">
                <a href="{{ route('media.byType', $type->slug) }}">
                  @if ($type->image_url)
                    <img
                      src="{{ route('admin.images.preview', [
                          'model' => 'media-types',
                          'id' => $type->id,
                      ]) }}"
                      alt="{{ $type->name }}" loading="lazy">
                  @else
                    <div class="d-flex align-items-center justify-content-center"
                      style="height:220px;background:#f5f5f5;">
                      <i class="uil uil-play-circle text-muted font-size-40"></i>
                    </div>
                  @endif
                </a>
              </div>

              {{-- Content --}}
              <div class="content">
                <h5>
                  <a href="{{ route('media.byType', $type->slug) }}">
                    {{ $type->name }}
                  </a>
                </h5>

                @if ($type->description)
                  <p>
                    {{ Str::limit(strip_tags($type->description), 120) }}
                  </p>
                @endif

                <a href="{{ route('media.byType', $type->slug) }}" class="btns">
                  @lang('pages.explore')
                </a>
              </div>

            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted">
            @lang('pages.no_media_available')
          </div>
        @endforelse

      </div>
    </div>
  </section>

@endsection
