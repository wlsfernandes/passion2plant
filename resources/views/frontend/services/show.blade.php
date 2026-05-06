@extends('frontend.layouts.app')

@section('title', html_entity_decode(strip_tags($service->getTitle())) . ' | Passion2Plant')

@section('content')
    <section class="details__section overhid pt-130 pb-130" style="{{ $section->style ?? '' }}">
        <div class="container">
            <div class="row g-4">

                {{-- SIDEBAR --}}
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <div class="sidebar__right">

                        {{-- Services list --}}
                        <div class="sidebar__widget mb-5">
                            <ul class="service__list">

                                <li class="mb-3">
                                    <a href="{{ url('/our-services') }}">
                                        <span>@lang('pages.all_services')</span>
                                        <i class="fa fa-chevron-right"></i>
                                    </a>
                                </li>

                                @foreach ($services as $item)
                                    <li class="mb-3 {{ $item->id === $service->id ? 'active' : '' }}">
                                        <a href="{{ route('services.display', $item->slug) }}">
                                            <span>{{ html_entity_decode(strip_tags($item->getTitle()), ENT_QUOTES, 'UTF-8') }}</span>
                                            <i class="fa fa-chevron-right"></i>
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>

                        {{-- Help box (static for now) --}}
                        <div class="sidebar__widget">
                            <div class="service__helping">
                                <div class="thumb">
                                    <img src="{{ asset('assets/frontend/img/service/details-img-1.jpg') }}" alt="service">
                                </div>
                                <div class="helping__content">
                                    <h4>@lang('pages.need_help')</h4>
                                    <p>@lang('pages.contact_us_description')</p>

                                    <a href="{{ url('/contact') }}" class="cmn--btn mt-4">
                                        @lang('pages.contact_us')
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- MAIN CONTENT --}}
                <div class="col-xxl-8 col-xl-8 col-lg-8">
                    <div class="details__items service__details">

                        {{-- Main image --}}
                        <div class="details__thumb">
                            <img src="{{ route('admin.images.preview', ['model' => 'services', 'id' => $service->id]) }}"
                                alt="{{ html_entity_decode($service->getTitle()) }}" class="img-fluid w-100" loading="lazy">
                        </div>

                        {{-- Content --}}
                        <div class="details__content">
                            <h3>{{ html_entity_decode(strip_tags($service->getTitle()), ENT_QUOTES, 'UTF-8') }}</h3>

                            <div class="cms-html">
                                {!! $service->getContent() !!}
                            </div>
                        </div>
                        {{-- External link (optional) --}}
                        @if ($service->external_link)
                            <a href="{{ $service->external_link }}" target="_blank" class="cmn--btn mt-4">
                                @lang('pages.learn_more')
                            </a>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
