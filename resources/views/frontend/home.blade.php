{{-- resources/views/frontend/pages/home.blade.php --}}
@extends('frontend.layouts.app')

@section('title', 'Home | Passion2Plant')

@section('content')

    @include('frontend.partials.banner')
    @include('frontend.partials.about')
    @include('frontend.partials.testimonial')
    @include('frontend.partials.team-carousel')
    @include('frontend.partials.partners')
    @include('frontend.partials.services-carousel')
    @include('frontend.partials.blog-carousel')
    @include('frontend.partials.donate-carousel')
    @include('frontend.partials.event-carousel')
    <!--Involve Section Here-->
    <section class="involve__section pt-130 pb-130 overhid">
        <div class="container">
            <div class="row G-4">
                <div class="col-lg-12">
                    <div class="involve__items center">
                        <h6>
                            GET INVOLVED NOW
                        </h6>
                        <h2>
                            We Have The Power Today To
                            Change Tomorrow
                        </h2>
                        <a href="#0" class="cmn--btn mt-4">
                            join with us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Involve Section End-->
    @include('frontend.partials.testimonial')

    <!--Contact Info Section Here-->
    <div class="contact__info__section pt-130 pb-130 section__bg overhid">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-7">
                    <div class="contact__right">
                        <div class="info__header">
                            <h6>have Question?</h6>
                            <div class="witr_bar_main">
                                <div class="witr_bar_inner witr_bar_innerc">
                                </div>
                            </div>
                            <h3>
                                Send us a Massage
                            </h3>
                        </div>
                        <form action="contact.php" id="contact-form" method="POST">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="form__clt">
                                        <input type="text" name="name" id="name" placeholder="Your Name...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form__clt">
                                        <input type="text" name="email" id="email"
                                            placeholder=" Your Email...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form__clt">
                                        <input type="text" name="number" id="number"
                                            placeholder="Phone Number...">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form__clt__big">
                                        <textarea name="message" id="message" placeholder="Message..."></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <button type="submit" class="cmn--btn">
                                        <i class="fa-solid fa-paper-plane"></i> get in touch
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="left__info">
                        <div class="left__header">
                            <h3>Contact Information</h3>
                            <p>
                                Large clean and spacious facility that has all the necessary equipment for their fitness
                                routine for their fitness routine.
                            </p>
                        </div>
                        <div class="info__wrap d-flex align-items-center mt-5">
                            <div class="icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="content">
                                <h6>
                                    Hotline
                                </h6>
                                <p>
                                    +47 232 001
                                </p>
                            </div>
                        </div>
                        <div class="info__wrap d-flex align-items-center mt-4">
                            <div class="icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="content">
                                <h6>
                                    Our Location
                                </h6>
                                <p>
                                    Inner Circular Rose Valley Park.
                                </p>
                            </div>
                        </div>
                        <div class="info__wrap d-flex align-items-center mt-4">
                            <div class="icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="content">
                                <h6>
                                    email
                                </h6>
                                <p>
                                    example@example.com
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Contact Info Section End-->

   
@endsection
