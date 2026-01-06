@php
    use Illuminate\Support\Str;
    $locale = app()->getLocale();
@endphp

<!--Testimonial Section Here-->
<section class="testimonial__section overhid pt-130 pb-130">
    <div class="container">

        <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
            <h6>@lang('pages.testimonial')</h6>
            <h3>@lang('pages.testimonial_description')</h3>
        </div>

        <div class="swiper testimonial__wrapper">
            <div class="swiper-wrapper">

                @foreach($testimonials as $testimonial)
                    <div class="swiper-slide">
                        <div class="testi__items">
                            <div class="testi__wrap">
                                <div class="testi__thumb">
                                    <img
                                        src="{{ route('admin.images.preview', ['model' => 'testimonials', 'id' => $testimonial->id]) }}"
                                        alt="{{ $testimonial->name }}"
                                        loading="lazy"
                                    >
                                </div>

                                <div class="content">
                                    <h6>{{ $testimonial->name }}</h6>
                                    <span>{{ Str::limit($testimonial->role, 30) }}</span>
                                </div>
                            </div>

                            <p>
                                {{ Str::limit(
                                    strip_tags($locale === 'es'
                                        ? $testimonial->content_es
                                        : $testimonial->content_en),
                                    140
                                ) }}
                            </p>

                            <ul>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                                <li><i class="fas fa-star"></i></li>
                            </ul>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="swiper-dot text-center pt-5">
                <div class="dot"></div>
            </div>
        </div>

    </div>
</section>
<!--Testimonial Section End-->
