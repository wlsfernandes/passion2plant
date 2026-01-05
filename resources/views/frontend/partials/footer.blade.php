<!--Footer Section Here-->
<section class="footer__section">
    <div class="container">
        <div class="footer__top pt-65 pb-65">
            <div class="row g-5">
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="2s">
                    <div class="footer__widget">
                        <div class="widget__head mb-4">
                          <a href="{{ url('/') }}" class="logo site-logo"><img src="{{ route('admin.images.preview', ['model' => 'settings', 'id' => $settings->id]) }}" alt="{{ $settings->site_name ?? config('app.name') }}"></a>
                        </div>
                        <p class="mb-4">
                            {{ $settings->footer_text ?? ''}}
                        </p>
                       <ul class="social__icon">
    @foreach($socialLinks as $social)
        <li>
            <a href="{{ $social->url }}"
               target="_blank"
               rel="noopener"
               aria-label="{{ $social->label() }}">
                <i class="{{ $social->icon() }}"></i>
            </a>
        </li>
    @endforeach
</ul>

                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="4s">
                    <div class="footer__widget">
                        <div class="widget__head mb-4">
                            <h5>{{__('explore')}}</h5>
                            <div class="witr_bar_main">
                                <div class="witr_bar_inner witr_bar_innerc">
                                </div>
                            </div>
                        </div>
                        <ul class="list">
                            <li>
                                <a href="">
                                    <i class="fa-solid fa-chevron-right"></i>
                                    {{__('about')}}
                                </a>
                            </li>
                            
                            <li>
                                <a href="">
                                    <i class="fa-solid fa-chevron-right"></i>
                                   {{__('blog')}}
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fa-solid fa-chevron-right"></i>
                                   {{__('services')}}
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fa-solid fa-chevron-right"></i>
                                   {{__('contact_us')}}
                                </a>
                            </li>
                           
                        </ul>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 wow fadeInUp" data-wow-duration="8s">
                    <div class="footer__widget">
                        <div class="widget__head mb-4">
                            <h5> @lang('footer.newsletter')</h5>
                        </div>
                        <p>
                            @lang('footer.newsletter_text')
                        </p>
                        <div class="footer__newsletter mt-5">
                            <input type="email" name="EMAIL" placeholder="@lang('footer.email_placeholder')" required="">
                            <button value="submit"> <i class="fa fa-location-arrow"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <div class="footer__bottom pt-65 pb-65"><p class="center" id="footerCopyright">Copyright © <span id="currentYear"></span><a href="#0" class="gym"> Passion2Plant</a>. Designed By <a href="https://devpromaster.com" class="theme" target="_blank" rel="noopener"> DevProMaster</a>
    </p>
</div>

    </div>
</section>
<!--Footer Section End-->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const yearEl = document.getElementById('currentYear');
        if (yearEl) {
            yearEl.textContent = new Date().getFullYear();
        }
    });
</script>
@endpush
