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
                                <img src="{{ route('admin.images.preview', [
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



                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Page Details --}}

    @foreach ($page->sections as $index => $section)
        @php
            // Even index → image left | Odd index → image right
            $imageLeft = $index % 2 === 0;
        @endphp

        <section class="team__details overhid section-spacing">
            <div class="container">
                <div class="row g-5 align-items-center">

                    {{-- IMAGE LEFT --}}
                    @if ($imageLeft)
                        <div class="col-xxl-5 col-xl-5 col-lg-8">
                            @if ($section->image_url)
                                <div class="details__thumb text-center">
                                    <img src="{{ route('admin.images.preview', [
                                        'model' => 'sections',
                                        'id' => $section->id,
                                    ]) }}"
                                        alt="{{ $section->title }}" class="img-fluid">
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- TEXT (always beside the image) --}}
                    <div class="col-xxl-7 col-xl-7 col-lg-10">
                        <div class="about__header heading-gradient-green-black">
                            <h2 class="heading-gradient-green-black wow fadeInUp">
                                {{ $section->title }}
                            </h2>
                        </div>

                        <div class="details__cont mt-3">
                            {!! $section->content !!}
                        </div>
                    </div>

                    {{-- IMAGE RIGHT --}}
                    @if (!$imageLeft)
                        <div class="col-xxl-5 col-xl-5 col-lg-8">
                            @if ($section->image_url)
                                <div class="details__thumb text-center">
                                    <img src="{{ route('admin.images.preview', [
                                        'model' => 'sections',
                                        'id' => $section->id,
                                    ]) }}"
                                        alt="{{ $section->title }}" class="img-fluid">
                                </div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>
        </section>
    @endforeach

@endsection
