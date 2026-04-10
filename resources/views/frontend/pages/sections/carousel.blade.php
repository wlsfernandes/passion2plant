@php
    $view = match ($section->carousel_type) {
        'team' => 'frontend.pages.sections.carousel.team',
        'services' => 'frontend.pages.sections.carousel.services',
        'blog' => 'frontend.pages.sections.carousel.blog',
        'donate' => 'frontend.pages.sections.carousel.donate',
        'membership' => 'frontend.pages.sections.carousel.membership',
        'event' => 'frontend.pages.sections.carousel.event',
        /* partials */
        'testimonial' => 'frontend.pages.sections.carousel.testimonial',
        'partners' => 'frontend.pages.sections.carousel.partners',
        'educators' => 'frontend.pages.sections.carousel.educators',
        default => null,
    };
@endphp

@if ($view && view()->exists($view))
    @include($view, ['section' => $section])
@endif
