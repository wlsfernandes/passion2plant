@extends('frontend.layouts.app')

@section('title', 'Services')

@section('content')

  <!--Breadcumd Section Here-->
  <section class="breadcumd__banner overhid">
    <div class="container">
      <div class="breadcumd__wrapper">
        <h2 class="left__content">
          @lang('pages.our_services')
        </h2>
        <ul class="right__content">
          <li>
            <a href="index.html">
              <i class="fa-solid fa-house"></i>
              @lang('pages.home')
            </a>
          </li>
          <li>
            <i class="fa-solid fa-chevron-right"></i>
          </li>
          <li>
            @lang('pages.services')
          </li>
        </ul>
      </div>
    </div>
  </section>
  <!--Breadcumd Section End-->
  @php
    use Illuminate\Support\Str;
  @endphp

  <section class="service__section section__bg pt-130 pb-130 overhid">
    <div class="container">
      <div class="row g-4">

        @forelse($services as $service)
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp"
            data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

            <div class="service__items center">

              {{-- Image --}}
              <div class="thumb">
                <a href="{{ route('services.display', $service->slug) }}">
                  <img src="{{ route('admin.images.preview', ['model' => 'services', 'id' => $service->id]) }}"
                    alt="{{ $service->getTitle() }}" loading="lazy">
                </a>
              </div>

              {{-- Content --}}
              <div class="content">
                <h5>
                  <a href="{{ route('services.display', $service->slug) }}">
                    {{ $service->getTitle() }}
                  </a>
                </h5>

                <p>
                  {{ Str::limit(strip_tags($service->getDescription()), 120) }}
                </p>

                <a href="{{ route('services.display', $service->slug) }}" class="btns">
                  @lang('pages.read_more')
                </a>
              </div>

            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted">
            @lang('pages.no_services_available')
          </div>
        @endforelse

      </div>
    </div>
  </section>

@endsection
