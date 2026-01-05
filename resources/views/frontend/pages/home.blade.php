{{-- resources/views/frontend/pages/home.blade.php --}}
@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')

    @include('frontend.partials.banner')
    @include('frontend.partials.about')

  

    <!--Service Section Here-->
    <section class="service__section section__bg pt-130 pb-130 overhid">
        <div class="container">
            <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
                <h6>services</h6>
                <h2>Preserving The Earth For Future Generations</h2>
            </div>
            <div class="row g-4">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="3s">
                    <div class="service__items center">
                        <div class="thumb">
                            <a href="service-details.html">
                                <img src="{{ asset('assets/frontend/img/service/s5.jpg') }}" alt="service__image">
                            </a>
                        </div>
                        <div class="content">
                            <h5>
                                <a href="service-details.html">
                                    Carbon Offsetting
                                </a>
                            </h5>
                            <p>
                                Agriculture is the art and science of cultivating the soil cultivating cultivating growing
                                crops.
                            </p>
                            <a href="service-details.html" class="btns">read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="5s">
                    <div class="service__items center">
                        <div class="thumb">
                            <a href="service-details.html">
                                <img src="{{ asset('assets/frontend/img/service/s6.jpg') }}" alt="service__image">
                            </a>
                        </div>
                        <div class="content">
                            <h5>
                                <a href="service-details.html">
                                    Energy Consulting
                                </a>
                            </h5>
                            <p>
                                Agriculture is the art and science of cultivating the soil cultivating cultivating growing
                                crops.
                            </p>
                            <a href="service-details.html" class="btns">read more</a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp" data-wow-duration="7s">
                    <div class="service__items center">
                        <div class="thumb">
                            <a href="service-details.html">
                                <img src="{{ asset('assets/frontend/img/service/s7.jpg') }}" alt="service__image">
                            </a>
                        </div>
                        <div class="content">
                            <h5>
                                <a href="service-details.html">
                                    Climate Adaptation
                                </a>
                            </h5>
                            <p>
                                Agriculture is the art and science of cultivating the soil cultivating cultivating growing
                                crops.
                            </p>
                            <a href="service-details.html" class="btns">read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Service Section End-->

    <!--Work Section Here-->
    <section class="work__section pt-130 pb-130 overhid">
        <div class="container">
            <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
                <h6>HOW WE WORK</h6>
                <h2>We Work Together For Bettering Tomorrow</h2>
            </div>
            <div class="row g-4">
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
                    <div class="work__items">
                        <div class="work__icon mb-2 d-flex align-items-center justify-content-between">
                            <img src="{{ asset('assets/frontend/img/work/icon1.png') }}" alt="work__img">
                            <span>01</span>
                        </div>
                        <div class="work__content">
                            <h5 class="mb-2">
                                <a href="#0">
                                    Community trees
                                </a>
                            </h5>
                            <p>
                                A tree plantation forest plantation plantation forest plantation is a forest planted.
                            </p>
                            <a class="arrow__button" href="#0"><i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
                    <div class="work__items">
                        <div class="work__icon mb-2 d-flex align-items-center justify-content-between">
                            <img src="{{ asset('assets/frontend/img/work/icon2.png') }}" alt="work__img">
                            <span>02</span>
                        </div>
                        <div class="work__content">
                            <h5 class="mb-2">
                                <a href="#0">
                                    Individuals
                                </a>
                            </h5>
                            <p>
                                A tree plantation forest plantation plantation forest plantation is a forest planted.
                            </p>
                            <a class="arrow__button" href="#0"><i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
                    <div class="work__items">
                        <div class="work__icon mb-2 d-flex align-items-center justify-content-between">
                            <img src="{{ asset('assets/frontend/img/work/icon3.png') }}" alt="work__img">
                            <span>03</span>
                        </div>
                        <div class="work__content">
                            <h5 class="mb-2">
                                <a href="#0">
                                    Companies
                                </a>
                            </h5>
                            <p>
                                A tree plantation forest plantation plantation forest plantation is a forest planted.
                            </p>
                            <a class="arrow__button" href="#0"><i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
                    <div class="work__items">
                        <div class="work__icon mb-2 d-flex align-items-center justify-content-between">
                            <img src="{{ asset('assets/frontend/img/work/icon4.png') }}" alt="work__img">
                            <span>04</span>
                        </div>
                        <div class="work__content">
                            <h5 class="mb-2">
                                <a href="#0">
                                    Education
                                </a>
                            </h5>
                            <p>
                                A tree plantation forest plantation plantation forest plantation is a forest planted.
                            </p>
                            <a class="arrow__button" href="#0"><i class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Work Section End-->

    <!--Counter Section Here-->
    <section class="counter__section pt-130 pb-130 overhid">
        <div class="container">
            <div class="main-counter-wrapper">
                <div class="counter-items odometer-item wow fadeInDown" data-wow-delay="0.1s">
                    <div class="counter-content">
                        <div class="cont d-flex align-items-center">
                            <h2 class="odometer" data-odometer-final="200">
                                0
                            </h2>
                            <span>+</span>
                        </div>
                        <p>
                            Team member
                        </p>
                    </div>
                </div>
                <div class="counter-items odometer-item wow fadeInDown" data-wow-delay="0.4s">
                    <div class="counter-content">
                        <div class="cont d-flex align-items-center">
                            <h2 class="odometer" data-odometer-final="15">
                                0
                            </h2>
                            <span>+</span>
                        </div>
                        <p>
                            Complete project
                        </p>
                    </div>
                </div>
                <div class="counter-items odometer-item wow fadeInDown" data-wow-delay="0.6s">
                    <div class="counter-content">
                        <div class="cont d-flex align-items-center">
                            <h2 class="odometer" data-odometer-final="20">
                                0
                            </h2>
                            <span>+</span>
                        </div>
                        <p>
                            Winning award
                        </p>
                    </div>
                </div>
                <div class="counter-items odometer-item wow fadeInDown" data-wow-delay="0.9s">
                    <div class="counter-content">
                        <div class="cont d-flex align-items-center">
                            <h2 class="odometer" data-odometer-final="25">
                                0
                            </h2>
                            <span>+</span>
                        </div>
                        <p>
                            Verified Property
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Counter Section End-->

    <!--Donate Section Here-->
    <section class="donate__section pt-130 pb-130">
        <div class="container">
            <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
                <h6>OPEN DONATION</h6>
                <h2>
                    Fundraising Causes Need
                    For Future
                </h2>
            </div>
            <div class="swiper donate__wrapper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="donate__items">
                            <div class="donate__thumb">
                                <img src="{{ asset('assets/frontend/img/donate/d1.jpg') }}" alt="donate__image">
                            </div>
                            <div class="donate__content">
                                <h5>
                                    <a href="donate-details.html">
                                        Need Help for poor village People
                                    </a>
                                </h5>
                                <p>
                                    A tree plantation forest plantation plantation forest timber plantation or tree farm is
                                    a forest planted for high production.
                                </p>
                                <div class="main-progress mt-4">
                                    <div class="progress-container">
                                        <span class="main-scale main-scle"></span>
                                    </div>
                                    <div class="donate__item d-flex align-items-center justify-content-between">
                                        <span class="status-label">Goal: $8500</span>
                                        <span class="status-value">Raised: $5000</span>
                                    </div>
                                </div>
                                <a href="donate-details.html" class="cmn--btn mt-4">donate now</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="donate__items">
                            <div class="donate__thumb">
                                <img src="{{ asset('assets/frontend/img/donate/d2.jpg') }}" alt="donate__image">
                            </div>
                            <div class="donate__content">
                                <h5>
                                    <a href="donate-details.html">
                                        Save Donate for Ecofine forest house
                                    </a>
                                </h5>
                                <p>
                                    A tree plantation forest plantation plantation forest timber plantation or tree farm is
                                    a forest planted for high production.
                                </p>
                                <div class="main-progress mt-4">
                                    <div class="progress-container">
                                        <span class="main-scale main-scle2"></span>
                                    </div>
                                    <div class="donate__item d-flex align-items-center justify-content-between">
                                        <span class="status-label">Goal: $2450</span>
                                        <span class="status-value">Raised: $2100</span>
                                    </div>
                                </div>
                                <a href="donate-details.html" class="cmn--btn mt-4">donate now</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="donate__items">
                            <div class="donate__thumb">
                                <img src="{{ asset('assets/frontend/img/donate/d3.jpg') }}" alt="donate__image">
                            </div>
                            <div class="donate__content">
                                <h5>
                                    <a href="donate-details.html">
                                        Need help Donate for pet & Doctor
                                    </a>
                                </h5>
                                <p>
                                    A tree plantation forest plantation plantation forest timber plantation or tree farm is
                                    a forest planted for high production.
                                </p>
                                <div class="main-progress mt-4">
                                    <div class="progress-container">
                                        <span class="main-scale main-scle3"></span>
                                    </div>
                                    <div class="donate__item d-flex align-items-center justify-content-between">
                                        <span class="status-label">Goal: $15000</span>
                                        <span class="status-value">Raised: $7500</span>
                                    </div>
                                </div>
                                <a href="donate-details.html" class="cmn--btn mt-4">donate now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-dot text-center pt-5">
                    <div class="dot"></div>
                </div>
            </div>
        </div>
    </section>
    <!--Donate Section End-->

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

    <!--Team Section Here-->
    <section class="team__section pt-130 pb-130 overhid">
        <div class="container">
            <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
                <h6> our team</h6>
                <div class="witr_bar_main">
                    <div class="witr_bar_inner witr_bar_innerc center">
                    </div>
                    <h3>Our Dedicateds</h3>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 wow fadeInUp" data-wow-duration="3s">
                    <div class="team__items">
                        <div class="team__thumb">
                            <img src="{{ asset('assets/frontend/img/team/t1.jpg') }}" alt="team__image">
                        </div>
                        <div class="team__content">
                            <h6>
                                <a href="team-details.html">
                                    James Liam
                                </a>
                            </h6>
                            <p>worker</p>
                            <ul class="social__icon d-flex align-items-center justify-content-center">
                                <li>
                                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 wow fadeInUp" data-wow-duration="5s">
                    <div class="team__items">
                        <div class="team__thumb">
                            <img src="{{ asset('assets/frontend/img/team/t2.jpg') }}" alt="team__image">
                        </div>
                        <div class="team__content">
                            <h6>
                                <a href="team-details.html">
                                    rock Sophia
                                </a>
                            </h6>
                            <p>worker</p>
                            <ul class="social__icon d-flex align-items-center justify-content-center">
                                <li>
                                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 wow fadeInUp" data-wow-duration="7s">
                    <div class="team__items">
                        <div class="team__thumb">
                            <img src="{{ asset('assets/frontend/img/team/t3.jpg') }}" alt="team__image">
                        </div>
                        <div class="team__content">
                            <h6>
                                <a href="team-details.html">
                                    Jack Jayden
                                </a>
                            </h6>
                            <p>worker</p>
                            <ul class="social__icon d-flex align-items-center justify-content-center">
                                <li>
                                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 wow fadeInUp" data-wow-duration="9s">
                    <div class="team__items">
                        <div class="team__thumb">
                            <img src="{{ asset('assets/frontend/img/team/t4.jpg') }}" alt="team__image">
                        </div>
                        <div class="team__content">
                            <h6>
                                <a href="team-details.html">
                                    ava Emma
                                </a>
                            </h6>
                            <p>worker</p>
                            <ul class="social__icon d-flex align-items-center justify-content-center">
                                <li>
                                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Team Section End-->

    <!--Process Section Here-->
    <section class="process__section section__bg overhid pt-130 pb-130">
        <div class="container">
            <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
                <h6>Work Process</h6>
                <div class="witr_bar_main">
                    <div class="witr_bar_inner witr_bar_innerc center">
                    </div>
                    <h3>Steps In The Agriculture Process</h3>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="2s">
                    <div class="process__items">
                        <div class="process__thumb">
                            <img src="{{ asset('assets/frontend/img/process/p1.jpg') }}" alt="process__image">
                        </div>
                        <div class="process__content center">
                            <h6>
                                Planning
                            </h6>
                            <p>
                                Agriculture is the art and science of cultivating the soil growing.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="4s">
                    <div class="process__items">
                        <div class="process__thumb">
                            <img src="{{ asset('assets/frontend/img/process/p2.jpg') }}" alt="process__image">
                        </div>
                        <div class="process__content center">
                            <h6>
                                Growing
                            </h6>
                            <p>
                                Agriculture is the art and science of cultivating the soil growing.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="6s">
                    <div class="process__items">
                        <div class="process__thumb">
                            <img src="{{ asset('assets/frontend/img/process/p3.jpg') }}" alt="process__image">
                        </div>
                        <div class="process__content center">
                            <h6>
                                Harvesting
                            </h6>
                            <p>
                                Agriculture is the art and science of cultivating the soil growing.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 wow fadeInUp" data-wow-duration="8s">
                    <div class="process__items">
                        <div class="process__thumb">
                            <img src="{{ asset('assets/frontend/img/process/p4.jpg') }}" alt="process__image">
                        </div>
                        <div class="process__content center">
                            <h6>
                                Processing
                            </h6>
                            <p>
                                Agriculture is the art and science of cultivating the soil growing.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Process Section End-->

    <!--Testimonial Section Here-->
    <section class="testimonial__section overhid pt-130 pb-130">
        <div class="container">
            <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
                <h6>testimonial</h6>
                <h3>What's client says</h3>
            </div>
            <div class="swiper testimonial__wrapper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testi__items">
                            <div class="testi__wrap">
                                <div class="testi__thumb">
                                    <img src="{{ asset('assets/frontend/img/testimonial/client1.jpg') }}" alt="testi__image">
                                </div>
                                <div class="content">
                                    <h6>
                                        James Lucas
                                    </h6>
                                    <span>client</span>
                                </div>
                            </div>
                            <p>
                                Large clean and spacious facility that has all the necessary equipment for their fitness
                                routine.
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
                    <div class="swiper-slide">
                        <div class="testi__items">
                            <div class="testi__wrap">
                                <div class="testi__thumb">
                                    <img src="{{ asset('assets/frontend/img/testimonial/client2.jpg') }}" alt="testi__image">
                                </div>
                                <div class="content">
                                    <h6>
                                        Ava Amelia
                                    </h6>
                                    <span>client</span>
                                </div>
                            </div>
                            <p>
                                Large clean and spacious facility that has all the necessary equipment for their fitness
                                routine.
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
                    <div class="swiper-slide">
                        <div class="testi__items">
                            <div class="testi__wrap">
                                <div class="testi__thumb">
                                    <img src="{{ asset('assets/frontend/img/testimonial/client3.jpg') }}" alt="testi__image">
                                </div>
                                <div class="content">
                                    <h6>
                                        James Henry
                                    </h6>
                                    <span>client</span>
                                </div>
                            </div>
                            <p>
                                Large clean and spacious facility that has all the necessary equipment for their fitness
                                routine.
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
                </div>
                <div class="swiper-dot text-center pt-5">
                    <div class="dot"></div>
                </div>
            </div>
        </div>
    </section>
    <!--Testimonial Section End-->

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
                                        <input type="text" name="email" id="email" placeholder=" Your Email...">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form__clt">
                                        <input type="text" name="number" id="number" placeholder="Phone Number...">
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

    <!--Blog Section Here-->
    <section class="blog__section overhid pt-130 pb-130">
        <div class="container">
            <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
                <h6>latest news</h6>
                <div class="witr_bar_main">
                    <div class="witr_bar_inner witr_bar_innerc center">
                    </div>
                    <h3>Latest News From Blog</h3>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-xl-4 col-md-6 wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".5s">
                    <div class="blog__items">
                        <div class="blog__thumb">
                            <img src="{{ asset('assets/frontend/img/blog/blog1.jpg') }}" alt="blog__image">
                            <div class="content">
                                <h5>Go green and reduce your carbon footprint</h5>
                                <div class="info">
                                    <strong>By:</strong>
                                    <a href="#0">Admin</a>
                                    <span class="px-1">|</span>
                                    <span>20 Aug 2023</span>
                                </div>
                            </div>
                        </div>
                        <div class="content__up">
                            <h5>
                                <a href="blog-details.html">
                                    Go green and reduce your carbon footprint
                                </a>
                            </h5>
                            <p>
                                Agriculture is the art and science of cultivating the soil, growing crops and raising
                                livestock. It includes the preparation of plant and animal products for people.
                            </p>
                            <a href="blog-details.html" class="cmn--btn">News Details <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 wow fadeInLeft" data-wow-duration="1.7s" data-wow-delay=".7s">
                    <div class="blog__items">
                        <div class="blog__thumb">
                            <img src="{{ asset('assets/frontend/img/blog/blog2.jpg') }}" alt="blog__image">
                            <div class="content">
                                <h5>Make a statement support of the eco</h5>
                                <div class="info">
                                    <strong>By:</strong>
                                    <a href="#0">Admin</a>
                                    <span class="px-1">|</span>
                                    <span>20 Aug 2023</span>
                                </div>
                            </div>
                        </div>
                        <div class="content__up">
                            <h5>
                                <a href="blog-details.html">
                                    Make a statement support of the eco
                                </a>
                            </h5>
                            <p>
                                Agriculture is the art and science of cultivating the soil, growing crops and raising
                                livestock. It includes the preparation of plant and animal products for people.
                            </p>
                            <a href="blog-details.html" class="cmn--btn">News Details <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 wow fadeInLeft" data-wow-duration="1.9s" data-wow-delay=".9s">
                    <div class="blog__items">
                        <div class="blog__thumb">
                            <img src="{{ asset('assets/frontend/img/blog/blog3.jpg') }}" alt="blog__image">
                            <div class="content">
                                <h5>Affordable targeted media for every one</h5>
                                <div class="info">
                                    <strong>By:</strong>
                                    <a href="#0">Admin</a>
                                    <span class="px-1">|</span>
                                    <span>20 Aug 2023</span>
                                </div>
                            </div>
                        </div>
                        <div class="content__up">
                            <h5>
                                <a href="blog-details.html">
                                    Affordable targeted media for every one
                                </a>
                            </h5>
                            <p>
                                Agriculture is the art and science of cultivating the soil, growing crops and raising
                                livestock. It includes the preparation of plant and animal products for people.
                            </p>
                            <a href="blog-details.html" class="cmn--btn">News Details <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Blog Section End-->
@endsection