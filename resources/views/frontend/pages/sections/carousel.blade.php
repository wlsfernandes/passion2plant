@php
    $view = match ($section->carousel_type) {
        'team' => 'frontend.pages.sections.carousel.team',
        'services' => 'frontend.pages.sections.carousel.services',
        'blog' => 'frontend.pages.sections.carousel.blog',
        'donate' => 'frontend.pages.sections.carousel.donate',
        'event' => 'frontend.pages.sections.carousel.event',
        /* partials */
        'testimonial' => 'frontend.partials.testimonial',
        'partners' => 'frontend.partials.partners',
        'contact' => 'frontend.partials.contact',
        default => null,
    };
@endphp

@if ($view && view()->exists($view))
    @include($view, ['section' => $section])
@endif
