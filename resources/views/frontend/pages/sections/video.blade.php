@php
    $layout = $section->layout ?? 'image_left';
@endphp

<section class="py-5">

    <div class="container">

        @if ($layout === 'full')
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @include('frontend.pages.sections.partials.content')
                    @include('frontend.pages.sections.partials.video')
                </div>
            </div>
        @else
            <div class="row align-items-center g-5">
                @if ($layout === 'image_left')
                    <div class="col-lg-5">
                        @include('frontend.pages.sections.partials.video')
                    </div>
                @endif
                <div class="col-lg-7">
                    @include('frontend.pages.sections.partials.content')
                </div>
                @if ($layout === 'image_right')
                    <div class="col-lg-5">
                        @include('frontend.pages.sections.partials.video')
                    </div>
                @endif
            </div>
        @endif
    </div>

</section>
