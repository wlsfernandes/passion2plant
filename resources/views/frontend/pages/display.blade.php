@extends('frontend.layouts.app')

@section('title', $page->title)

@section('content')
@section('content')
  <section class="breadcumd__banner overhid">
    <div class="container">
      <div class="breadcumd__wrapper">
        <h2 class="left__content">
          @lang('pages.learning_resources')
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
            @lang('pages.learning_resources')
          </li>
        </ul>
      </div>
    </div>
  </section>
  <!-- Page Details Section -->
  <section class="details__section event__section overhid pt-130 pb-130">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-12">
          <div class="details__items">
            <div class="details__content">
              <h2 class="heading-gradient-green-black">
                {{ $page->title }}
              </h2>
            </div>
            {{-- Page Image --}}
            @if ($page->image_url)
              <div class="details__thumb">
                <img
                  src="{{ route('admin.images.preview', [
                      'model' => 'pages',
                      'id' => $page->id,
                  ]) }}"
                  alt="{{ $page->title }}">
              </div>
            @endif

            {{-- Page Content --}}
            <div class="details__content">
              <div class="page__content">
                {!! $page->content !!}
              </div>
            </div>

            {{-- Optional navigation (future-ready) --}}
            {{--
            <div class="prev__next__btns d-flex align-items-center justify-content-between mt-50">
              <a href="#" class="prev__btn d-flex align-items-center">
                <div class="icon">
                  <i class="fa-solid fa-arrow-left"></i>
                </div>
                <span class="text">Previous</span>
              </a>
              <a href="#" class="next__btn d-flex align-items-center">
                <span class="text">Next</span>
                <div class="icon"><i class="fa-solid fa-arrow-right"></i></div>
              </a>
            </div>
            --}}

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Page Details Section End -->
@endsection
