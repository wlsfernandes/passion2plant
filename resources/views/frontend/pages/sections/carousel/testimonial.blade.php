@php
    use Illuminate\Support\Str;
    $locale = app()->getLocale();
@endphp
<!--Testimonial Section Here-->
<section class="testimonial__section overhid pt-130 pb-130"
    style="{{ $section->background_image_url ? '' : $section->style }}">
    <div class="container">
        @include('frontend.pages.sections.partials.content')
        <div class="swiper testimonial__wrapper">
            <div class="swiper-wrapper">
                @foreach ($featuredTestimonials as $testimonial)
                    {{ dd($section) }}
                    <div class="swiper-slide"
                        style="background-image: url('{{ route('admin.images.preview', ['model' => 'sections', 'id' => $section->id]) }}');background-size: cover;background-position: center;
                    background-repeat: no-repeat;padding: 40px;border-radius: 12px;"
                        @endif>
                        <div class="testi__items">
                            <!-- Image -->
                            <div class="testi__thumb text-center mb-3">
                                <img src="{{ route('admin.images.preview', ['model' => 'testimonials', 'id' => $testimonial->id]) }}"
                                    alt="{{ $testimonial->name }}" class="rounded-circle shadow"
                                    style="width:140px;height:140px;object-fit:cover;" loading="lazy">
                            </div>

                            <!-- Name + Role -->
                            <div class="text-center mb-4">
                                <div class="cms-html">{!! $testimonial->name !!}</div>
                                <div class="cms-html">{!! $testimonial->role !!}</div>
                            </div>

                            <!-- Content -->
                            <div class="cms-html">
                                {!! $testimonial->content !!}
                            </div>

                            <!-- Stars -->
                            <ul class="testimonial-stars mt-4">
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
            <div class="swiper-dot text-center">
                <div class="dot"></div>
            </div>
        </div>
    </div>
</section>
<!--Testimonial Section End-->
