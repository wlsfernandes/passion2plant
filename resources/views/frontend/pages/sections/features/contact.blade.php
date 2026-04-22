<!-- Contact Section -->
<div class="contact__info__section pt-130 pb-130 section__bg overhid">

    <div class="container">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="row justify-content-center mb-4">
                <div class="col-lg-6">
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif
        @include('frontend.pages.sections.partials.content')
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Card Wrapper --}}
                <div class="p-4 p-md-5 bg-white rounded-4 shadow-sm">

                    {{-- Title --}}
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf

                        {{-- Honeypot --}}
                        <input type="text" name="website" style="display:none">
                        <input type="text" name="company" style="display:none">
                        <div class="row g-4">

                            {{-- Name --}}
                            <div class="col-12">
                                <input type="text" name="name" id="name" class="form-control form-control-lg"
                                    placeholder="@lang('pages.your_name')">
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <input type="email" name="email" id="email" class="form-control form-control-lg"
                                    placeholder="@lang('pages.your_email')">
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6">
                                <input type="text" name="number" id="number" class="form-control form-control-lg"
                                    placeholder="@lang('pages.your_phone')">
                            </div>

                            {{-- Message --}}
                            <div class="col-12">
                                <textarea name="message" id="message" rows="5" class="form-control form-control-lg"
                                    placeholder="@lang('pages.your_message')"></textarea>
                            </div>

                            {{-- Button --}}
                            <div class="col-12 text-center">
                                <button type="submit" class="cmn--btn">
                                    <i class="fa-solid fa-paper-plane me-2"></i>
                                    @lang('pages.send')
                                </button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>

    </div>
</div>
<!-- Contact Section End -->
