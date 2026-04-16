<section class="footer__section"
    @if (!empty($footer)) style="background-image: url('{{ route('admin.images.preview', ['model' => 'footer', 'id' => $footer->id]) }}'); background-size: cover; background-position: center;" @endif>
    <div class="container">
        <div class="footer__top pt-65 pb-65">
            <div class="row g-5">

                {{-- COLUMN 1: LOGO + TEXT + SOCIAL --}}
                <div class="col-xxl-9 col-xl-9 col-lg-8 col-md-6 col-sm-12 wow fadeInUp">
                    <div class="footer__widget">
                        {{-- LOGO (FROM SETTINGS) --}}
                        <div class="widget__head mb-4">
                            <a href="{{ url('/') }}" class="logo site-logo">
                                <img src="{{ route('admin.images.preview', ['model' => 'settings', 'id' => $settings->id]) }}"
                                    alt="{{ $settings->site_name ?? config('app.name') }}" style="max-height:80px;">
                            </a>
                        </div>
                        {{-- SUBTITLE --}}
                        <p>
                        <div class="cms-html">
                            {!! $footer->title_es ?? '' !!}
                        </div>
                        </p>
                        <p>
                        <div class="cms-html">
                            {!! $footer->subtitle_es ?? '' !!}
                        </div>
                        </p>
                        {{-- SOCIAL --}}
                        <ul class="social__icon footer__social  mb-3">
                            @foreach ($socialLinks as $social)
                                <li>
                                    <a href="{{ $social->url }}" target="_blank" rel="noopener"
                                        aria-label="{{ $social->label }}">
                                        <i class="{{ $social->icon }}"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                </div>

                {{-- COLUMN 2: MENU --}}
                <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                    <div class="footer__widget">

                        <div class="widget__head mb-4">
                            <h5>@lang('pages.explore')</h5>
                            <div class="witr_bar_main">
                                <div class="witr_bar_inner witr_bar_innerc"></div>
                            </div>
                        </div>

                        <ul class="list">
                            @foreach ($footerMenu as $item)
                                @if (!empty($item->link))
                                    <li>
                                        <a href="{{ $item->link }}">
                                            <i class="fa-solid fa-chevron-right"></i>
                                            {{ $item->title }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                    </div>
                </div>

            </div>
        </div>

        {{-- FOOTER BOTTOM --}}
        <div class="footer__bottom pt-65 pb-65">
            <p class="center">
                © {{ date('Y') }} {{ $settings->site_name ?? config('app.name') }}
            </p>
        </div>

    </div>
</section>
