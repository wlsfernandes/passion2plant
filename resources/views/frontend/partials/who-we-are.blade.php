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
