<section class="banner__section overhid">
    <div class="swiper banner__slider">
        <div class="swiper-wrapper">
            @foreach($banners as $banner)
                        <div class="swiper-slide">

                            {{-- Background image --}}
                            <div class="banner__image" style="background-image: url('{{ route('admin.images.preview', ['model' => 'banners','id' => $banner->id]) }}');">
                            </div>

                            <div class="container">
                                <div class="row">
                                    <div class="col-xxl-7 col-lg-7">
                                        <div class="banner__content">

                                            <h3 data-animation="fadeInUp" data-delay="1.3s">
                                                {{ $banner->{'title_' . app()->getLocale()} ?? $banner->title_en }}
                                            </h3>

                                            @if($banner->{'subtitle_' . app()->getLocale()} ?? $banner->subtitle_en)
                                                <h2 data-animation="fadeInUp" data-delay="1.6s" style="margin-top:25px;">
                                                    {{ $banner->{'subtitle_' . app()->getLocale()} ?? $banner->subtitle_en }}
                                                </h2>
                                            @endif

                                            @if($banner->link)
                                                <div class="banner__button d-flex align-items-center flex-wrap">
                                                    <a href="{{ $banner->link }}"
                                                        target="{{ $banner->open_in_new_tab ? '_blank' : '_self' }}"
                                                        data-animation="fadeInUp" data-delay="1.9s" class="cmn--btn">
                                                        <span>{{ __('Read more') }}</span>
                                                    </a>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
            @endforeach

        </div>

        {{-- Slider arrows --}}
        <div class="arry__button">
            <button class="arry__prev banner__arry-prev">
                <i class="fa-solid fa-angle-up"></i>
            </button>
            <br>
            <button class="arry__next banner__arry-next">
                <i class="fa-solid fa-angle-down"></i>
            </button>
        </div>
    </div>
</section>