<!-- Header Top Here -->
<div class="header__top overhid">
    <div class="container">
        <div class="top__wrap d-flex align-items-center justify-content-between">
            <div class="logo"><a href="{{ url('/') }}" class="logo site-logo"><img
                        src="{{ route('admin.images.preview', ['model' => 'settings', 'id' => $settings->id]) }}"
                        alt="{{ $settings->site_name ?? 'Passion2Plant' }}"></a></div>

            <ul class="info d-flex align-items-center">
                @if (!empty($settings->address))
                    <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <span>{{ $settings->address }}</span>
                    </li>
                @endif

                @if (!empty($settings->contact_phone))
                    <li>
                        <i class="fa-solid fa-phone-volume"></i>
                        <a href="tel:{{ preg_replace('/\s+/', '', $settings->contact_phone) }}">
                            {{ $settings->contact_phone }}
                        </a>
                    </li>
                @endif

                @if (!empty($settings->contact_email))
                    <li>
                        <i class="fa-solid fa-paper-plane"></i>
                        <a href="mailto:{{ $settings->contact_email }}">
                            {{ $settings->contact_email }}
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ url('/lang/en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">
                        <img src="{{ asset('/assets/admin/images/flags/us.jpg') }}" alt="user-image" class="me-1"
                            height="16">
                        <span class="align-middle"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/lang/es') }}" class="{{ app()->getLocale() === 'es' ? 'active' : '' }}">
                        <img src="{{ asset('/assets/admin/images/flags/spain.jpg') }}" alt="user-image" class="me-1"
                            height="16"> <span class="align-middle"></span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Header Top End -->

<!-- Header Here -->
<header class="header-section">
    <div class="container">
        <div class="header-wrapper">

            {{-- Logo + Language --}}
            <div class="logo-menu">



                {{-- Logo (static for now, easy to replace later) --}}
                <a href="{{ url('/') }}" class="logo site-logo"><img
                        src="{{ route('admin.images.preview', ['model' => 'settings', 'id' => $settings->id]) }}"
                        alt="{{ $settings->site_name ?? config('app.name') }}"></a>
            </div>

            {{-- Main Menu --}}
            <ul class="main-menu">
                <li><a href="{{ url('/') }}">{{ __('menu.home') }}</a></li>

                <ul class="main-menu">

                    <li>
                        <a href="#">
                            {{ __('menu.about') }}
                            <i class="fas fa-chevron-down"></i>
                        </a>

                        <ul class="sub-menu">
                            <li>
                                <a href="{{ route('about.index.public') }}">
                                    {{ __('menu.who_we_are') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('blogs.index.public') }}">
                                    {{ __('menu.blog') }}
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('events.index.public') }}">
                                    {{ __('menu.events') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('teams.index.public') }}">
                                    {{ __('menu.our_team') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('media.index.public') }}">
                                    {{ __('menu.media') }}
                                </a>
                            </li>
                            <li><a href="#">{{ __('menu.opportunities') }}</a></li>
                            <li>
                                <a href="{{ url('/info/why-learn-with-us') }}">
                                   {{ __('menu.why_learn') }}
                                </a>
                            </li>
                        </ul>

                    </li>
                </ul>
                {{-- COHORTS --}}
                <li class="has-submenu">
                    <a href="#">
                        {{ __('menu.cohorts') }}
                        <i class="fas fa-chevron-down"></i>
                    </a>

                    <ul class="sub-menu">
                        @foreach ($projects as $project)
                            <li>
                                <a href="{{ route('projects.display', $project->slug) }}">
                                    {{ $project->title }}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{ url('/info/pulpit-fellows') }}">
                                Pulpit Fellows
                            </a>
                        </li>

                    </ul>
                </li>
                {{-- PARTNERSHIPS --}}
                <li class="has-submenu">
                    <a href="#">
                        {{ __('menu.partnerships') }}
                        <i class="fas fa-chevron-down"></i>
                    </a>

                    <ul class="sub-menu">
                        @foreach ($collaborators as $collaborator)
                            <li>
                                <a href="{{ route('collaborators.display', $collaborator->slug) }}">
                                    {{ $collaborator->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="{{ route('services.index.public') }}">{{ __('menu.services') }}</a></li>

                <li class="has-submenu">
                    <a href="{{ route('resources.index.public') }}">
                        {{ __('menu.resources') }}
                        <i class="fas fa-chevron-down"></i>
                    </a>

                    <ul class="sub-menu">
                        {{-- All Resources --}}
                        <li>
                            <a href="{{ route('resources.index.public') }}">
                                {{ __('menu.resources') }}
                            </a>
                        </li>

                        {{-- Book Recommendations --}}
                        <li>
                            <a href="{{ route('book-recommendations.index.public') }}">
                                {{ __('menu.recommended_books') }}
                            </a>
                        </li>
                    </ul>
                </li>

                <li><a href="{{ route('donation.index.public') }}">{{ __('menu.donate') }}</a></li>

                <li><a href="{{ route('stores.index.public') }}">{{ __('menu.store') }}</a></li>
                {{-- Learn More (nested submenu) 
                <li class="has-submenu">
                    <a href="#">
                        {{ __('menu.learn_more') }}
                        <i class="fas fa-chevron-down"></i>
                    </a>

                    <ul class="sub-menu">
                        @foreach ($pages as $page)
                            <li>
                                <a href="{{ route('pages.display', $page->slug) }}">
                                    {{ $page->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li> --}}
                <li><a href="{{ route('contact') }}">{{ __('menu.contact') }}</a></li>
                @php
                    $cart = session('cart', []);
                    $cartCount = collect($cart)->sum('quantity');
                @endphp

                <li class="nav-item cart-nav-item">
                    <a href="{{ route('cart.index') }}" class="cart-link">
                        <span class="cart-icon">
                            <svg class="cart-svg" xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                            </svg>


                            @if ($cartCount > 0)
                                <span class="cart-count-badge">{{ $cartCount }}</span>
                            @endif
                        </span>
                    </a>
                </li>

                <li class="nav-signin"><a href="{{ url('/login') }}">{{ __('menu.sign_in') }}</a></li>

            </ul>

            {{-- Right Menu Icons --}}
            <div class="menu__right__components d-flex align-items-center">
                <div class="menu__components">
                    <a href="#0" class="search-trigger search-icon">
                        <i class="fa-solid fa-search"></i>
                    </a>
                    <i id="openButton" class="fa-solid fa-bars"></i>
                </div>

                <div class="header-bar d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

        </div>
    </div>
</header>

<!-- Header End -->

<!-- Sidebar area start here -->
<div id="targetElement" class="side_bar slideInRight side_bar_hidden">
    <div class="logo mb-30">
        <img src="{{ route('admin.images.preview', ['model' => 'settings', 'id' => $settings->id]) }}"
            alt="{{ $settings->site_name ?? config('app.name') }}" height="80" loading="lazy" width="auto">
    </div>
    <p class="text-justify">@lang('pages.passion_description')</p>
    <ul class="info py-4 mt-65 bor__top bor__bottom">
        <li><i class="fa-solid fa-paper-plane"></i> <a href="#0">passion2plant@gmail.com</a></li>
        <li><i class="fa-solid fa-location-dot"></i> <a href="#0">P.O. Box 580527, Kissimmee, FL 34758</a>
        </li>

    </ul>
    <ul class="social__icon mt-65">
        <li>
            <a href="https://www.facebook.com/Passion2Plant" target="_blank" rel="noopener"><i
                    class="fa-brands fa-facebook-f"></i></a>
        </li>
        <li>
            <a href="https://www.instagram.com/passion2plant/" target="_blank" rel="noopener"><i
                    class="fa-brands fa-instagram"></i></a>
        </li>
        <li>
            <a href="https://www.threads.com/@passion2plant" target="_blank" rel="noopener" aria-label="Threads"
                class="threads-icon">

                <i class="fa-brands fa-threads"></i>
            </a>
        </li>


    </ul>
    <button id="closeButton" class="text-white"><i class="fa-solid fa-xmark"></i></button>
</div>
<!-- Sidebar area end here -->

<!-- fullscreen search bar area start here
<div class="search-wrap">
    <div class="search-inner">
        <i class="fas fa-times search-close" id="search-close"></i>
        <div class="search-cell">
            <form method="get">
                <div class="search-field-holder">
                    <input type="search" class="main-search-input" placeholder="Search...">
                </div>
            </form>
        </div>
    </div>
</div>
fullscreen search bar area end here -->
