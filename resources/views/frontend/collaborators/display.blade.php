@extends('frontend.layouts.app')
@section('title', 'Passion2Plant - ' . $collaborator->title)
@section('content')


    <section class="breadcumd__banner overhid"
        style="background-image: url('{{ $bannerImage }}'); background-size: cover; background-position: center;">

        <div class="container">
            <div class="breadcumd__wrapper">
                <h2 class="left__content">
                    @lang('pages.partnerships')
                </h2>

                <ul class="right__content">
                    <li>
                        <a href="{{ url('/') }}">
                            <i class="fa-solid fa-house"></i>
                            @lang('pages.home')
                        </a>
                    </li>

                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>

                    <li>
                        @lang('pages.partnerships')
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Collaborator Details Section -->
    <section class="details__section event__section overhid pt-130 pb-130">
        <div class="container">
            <div class="title__content center wow fadeInUp" data-wow-duration="1.3s">
                <h3>{{ $collaborator->title }}</h3>
            </div>
            <div class="row">
                <div class="col-lg-12">

                    <div class="details__items">

                        {{-- Project Title --}}
                        <div class="details__content mb-40">
                            <h3></h3>
                            {{-- Optional Dates --}}

                        </div>

                        {{-- Project Description --}}
                        <div class="details__content mb-20">
                            {!! $collaborator->description !!}
                        </div>

                        {{-- Partner Icons --}}
                        @if ($collaborator->images->count())
                            <div class="partner-icons mt-40">
                                <div class="row g-3 justify-content-center align-items-center">

                                    @foreach ($collaborator->images as $image)
                                        <div class="col-6 col-sm-4 col-md-3 col-lg-2 d-flex justify-content-center">

                                            <a class="partner-icon" href="{{ $collaborator->external_link ?: '#0' }}"
                                                @if (!empty($collaborator->external_link)) target="_blank" rel="noopener noreferrer" @endif
                                                aria-label="{{ $collaborator->title }}">

                                                <img src="{{ route('admin.images.preview', ['model' => 'collaborator-images', 'id' => $image->id]) }}"
                                                    alt="{{ $collaborator->title }}" loading="lazy">
                                            </a>

                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endif



                        <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">

                            @if (!empty($collaborator->external_link))
                                <a href="{{ $collaborator->external_link }}" class="cmn--btn cmn--btn-outline"
                                    target="_blank" rel="noopener noreferrer">
                                    <i class="uil uil-external-link-alt"></i>
                                    @lang('pages.apply_now')
                                </a>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Project Details Section End -->

@endsection
