@if (!empty($aboutSections['header']))
  <section class="section__bg legacy-section">
    <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
      <h1 class="heading-gradient-green-black">{{ $aboutSections['header']->{'title_' . app()->getLocale()} ?? '' }}</h1>
      <h5>{{ $aboutSections['header']->{'subtitle_' . app()->getLocale()} ?? '' }}</h5>
      <div class="legacy-content">
        {!! $aboutSections['header']->{'content_' . app()->getLocale()} ?? '' !!}
      </div>
    </div>
  </section>
@endif
@if (!empty($aboutSections['new_way']))
  <section class="team__details overhid section-spacing">
    <div class="container">
      <div class="row g-5">
        <div class="col-xxl-5 col-xl-5 col-lg-8">
          <div class="team__left">
            <div class="details__thumb">
              <!-- <img class="img-fluid w-75 mx-auto d-block" -->
              <img
                src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['new_way']->id]) }}"alt="about__image">
            </div>
          </div>
        </div>
        <div class="col-xxl-7 col-xl-7 col-lg-10">
          <div class="about__header heading-gradient-green-black">
            <h2 class="heading-gradient-green-black">
              {{ $aboutSections['new_way']->{'title_' . app()->getLocale()} ?? '' }}</h2>
          </div>
          <div class="details__cont" style="margin-top: 20px;">
            <h5>
              {{ $aboutSections['new_way']->{'subtitle_' . app()->getLocale()} ?? '' }}
            </h5>
            <p style="margin-top: 20px;">
              {!! $aboutSections['new_way']->{'content_' . app()->getLocale()} ?? '' !!}
            </p>
          </div>
        </div>

      </div>
    </div>
  </section>
@endif
@if (!empty($aboutSections['who_we_are']))
  <section class="team__details overhid section-spacing">
    <div class="container">
      <div class="row g-5">
        <div class="col-xxl-7 col-xl-7 col-lg-10">
          <div class="about__header heading-gradient-green-black">
            <h2 class="heading-gradient-green-black">
              {{ $aboutSections['who_we_are']->{'title_' . app()->getLocale()} ?? '' }}</h2>
          </div>
          <div class="details__cont" style="margin-top: 20px;">
            <p style="margin-top: 20px;">
              {!! $aboutSections['who_we_are']->{'content_' . app()->getLocale()} ?? '' !!}
            </p>
          </div>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-8">
          <div class="team__left">
            <div class="details__thumb">
              <!-- <img class="img-fluid w-75 mx-auto d-block" -->
              <img
                src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['who_we_are']->id]) }}"
                alt="about__image">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif
@if (!empty($aboutSections['values']))
  <section class="about__section pt-130 pb-130 overhid">
    <div class="container">
      <div class="row g-4 align-items-center justify-content-between">
        <div class="col-xxl-6 col-xl-6 col-lg-6 wow fadeInLeft" data-wow-duration="3s">
          <div class="about__thumb">
            <img src="assets/img/about/about1.jpg" alt="about__image">
            <div class="video__content">
              <div class="video video-pulse">
                <a class="video-btn" href="https://www.youtube.com/watch?v=gR4BiOBJfEc"><i
                    class="fa-solid fa-play"></i></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-6 col-xl-6 col-lg-6 wow fadeInRight" data-wow-duration="5s">
          <div class="about__content">
            <div class="about__header">
              <h6>
                {{ $aboutSections['values']->{'title_' . app()->getLocale()} ?? '' }}
              </h6>
            </div>
            <div class="check__list mt-4">
              <div class="list d-flex style__gap mb-4">
                <div class="check__icon">
                  <i class="fa-solid fa-check"></i>
                </div>
                @php
                  $content = $aboutSections['values']->{'content_' . app()->getLocale()} ?? '';
                  $paragraphs = preg_split('/<\/p>\s*<p>/', trim(strip_tags($content, '<p>')));
                @endphp

                @foreach ($paragraphs as $paragraph)
                  <div class="check__content">
                    <p>{!! $paragraph !!}</p>
                  </div>
                @endforeach

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif


@if (!empty($aboutSections['problem']))
  <section class="team__details overhid section-spacing">
    <div class="container">
      <div class="row g-5">
        <div class="col-xxl-5 col-xl-5 col-lg-8">
          <div class="team__left">
            <div class="details__thumb">
              <!-- <img class="img-fluid w-75 mx-auto d-block" -->
              <img
                src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['problem']->id]) }}"alt="about__image">
            </div>
          </div>
        </div>
        <div class="col-xxl-7 col-xl-7 col-lg-10">
          <div class="about__header heading-gradient-green-black">
            <h2 class="heading-gradient-green-black">
              {{ $aboutSections['problem']->{'title_' . app()->getLocale()} ?? '' }}</h2>
          </div>
          <div class="details__cont" style="margin-top: 20px;">
            <h5>
              {{ $aboutSections['problem']->{'subtitle_' . app()->getLocale()} ?? '' }}
            </h5>
            <p style="margin-top: 20px;">
              {!! $aboutSections['problem']->{'content_' . app()->getLocale()} ?? '' !!}
            </p>
          </div>
        </div>

      </div>
    </div>
  </section>
@endif
@if (!empty($aboutSections['values']))
  <section class="team__details overhid section-spacing">
    <div class="container">
      <div class="row g-5">
        <div class="col-xxl-7 col-xl-7 col-lg-10">
          <div class="about__header heading-gradient-green-black">
            <h2 class="heading-gradient-green-black">
              {{ $aboutSections['values']->{'title_' . app()->getLocale()} ?? '' }}</h2>
          </div>
          <div class="details__cont" style="margin-top: 20px;">
            <p style="margin-top: 20px;">
              {!! $aboutSections['values']->{'content_' . app()->getLocale()} ?? '' !!}
            </p>
          </div>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-8">
          <div class="team__left">
            <div class="details__thumb">
              <!-- <img class="img-fluid w-75 mx-auto d-block" -->
              <img
                src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['values']->id]) }}"
                alt="about__image">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif
@if (!empty($aboutSections['legacy']))
  <section class="team__details overhid section-spacing">
    <div class="container">
      <div class="row g-5">
        <div class="col-xxl-5 col-xl-5 col-lg-8">
          <div class="team__left">
            <div class="details__thumb">
              <!-- <img class="img-fluid w-75 mx-auto d-block" -->
              <img
                src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['legacy']->id]) }}"alt="about__image">
            </div>
          </div>
        </div>
        <div class="col-xxl-7 col-xl-7 col-lg-10">
          <div class="about__header heading-gradient-green-black">
            <h2 class="heading-gradient-green-black">
              {{ $aboutSections['legacy']->{'title_' . app()->getLocale()} ?? '' }}</h2>
          </div>
          <div class="details__cont" style="margin-top: 20px;">
            <h5>
              {{ $aboutSections['legacy']->{'subtitle_' . app()->getLocale()} ?? '' }}
            </h5>
            <p style="margin-top: 20px;">
              {!! $aboutSections['legacy']->{'content_' . app()->getLocale()} ?? '' !!}
            </p>
          </div>
        </div>

      </div>
    </div>
  </section>
@endif

@if (!empty($aboutSections['approach']))
  <section class="team__details overhid section-spacing">
    <div class="container">
      <div class="row g-5">
        <div class="col-xxl-7 col-xl-7 col-lg-10">
          <div class="about__header heading-gradient-green-black">
            <h2 class="heading-gradient-green-black">
              {{ $aboutSections['approach']->{'title_' . app()->getLocale()} ?? '' }}</h2>
          </div>
          <div class="details__cont" style="margin-top: 20px;">
            <p style="margin-top: 20px;">
              {!! $aboutSections['approach']->{'content_' . app()->getLocale()} ?? '' !!}
            </p>
          </div>
        </div>
        <div class="col-xxl-5 col-xl-5 col-lg-8">
          <div class="team__left">
            <div class="details__thumb">
              <!-- <img class="img-fluid w-75 mx-auto d-block" -->
              <img
                src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['approach']->id]) }}"
                alt="about__image">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif
