<!--About Section Here-->
<section class="about__section pt-130 pb-130 overhid">
    <div class="container">
        <div class="row g-4 align-items-center justify-content-between">
            <div class="col-xxl-6 col-xl-6 col-lg-6 wow fadeInLeft" data-wow-duration="3s">
                <div class="about__thumb">
                    <img src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['vision']->id]) }}"
                        alt="about__image">
                    <div class="small__about__one">
                        <img src="{{ asset('assets/frontend/img/about/b4.jpg') }}" alt="about__img">
                    </div>
                    <div class="small__about">
                        <img src="{{ asset('assets/frontend/img/about/b3.jpg') }}" alt="about__img">
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 wow fadeInRight" data-wow-duration="5s">
                <div class="about__content">
                    <div class="about__header">
                        <h6>
                            @lang('home.about_us')
                        </h6>
                    </div>
                    <h2 class="mb-4">
                        {{ $aboutSections['vision']->{'title_' . app()->getLocale()} ?? '' }}

                    </h2>
                    <h4>
                        {!! $aboutSections['vision']->{'subtitle_' . app()->getLocale()} ?? '' !!}
                    </h4>
                    <p style="margin-top: 20px;">
                        {!! $aboutSections['vision']->{'content_' . app()->getLocale()} ?? '' !!}
                    </p>
                    <!--  <div class="profile__item d-flex align-items-center mt-5">
                        <div class="profile d-flex align-items-center">
                            <div class="profile__thumb">
                                <img src="{{ asset('assets/frontend/img/about/profile/Dra.ElizabethRios.webp') }}" alt="profile__image">
                            </div>
                            <div class="text">
                                <p>Passion2Plant</p>
                                <h6>Dr. Elizabeth Rios</h6>
                            </div>
                        </div>
                        <a href="#" class="cmn--btn">@lang('home.read_more')</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
<!--Team Details Section Here
<section class="team__details overhid">
  <div class="container">
      <div class="row g-5">
          <div class="col-xxl-7 col-xl-7 col-lg-10">
              <div class="about__header heading-gradient-green-black">
                <h2 class="heading-gradient-green-black">{{ $aboutSections['who_we_are']->{'title_' . app()->getLocale()} ?? '' }}</h2>      </div>
            <div class="details__cont" style="margin-top: 20px;">
              <h5>
                 {{ $aboutSections['who_we_are']->{'subtitle_' . app()->getLocale()} ?? '' }}
              </h5>
               <p style="margin-top: 20px;">
                        {!! $aboutSections['who_we_are']->{'content_' . app()->getLocale()} ?? '' !!}
                    </p>
            </div>
          </div>
          <div class="col-xxl-5 col-xl-5 col-lg-8">
              <div class="team__left">
                  <div class="details__thumb">
                      <img src="{{ route('admin.images.preview', ['model' => 'about', 'id' => $aboutSections['who_we_are']->id]) }}" alt="about__image">
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>  -->
<!--Team Details Section End-->
<!--About Section End-->
