@php
    $view = match ($section->feature_type) {
        'blog' => 'frontend.pages.sections.features.blog',
        'book' => 'frontend.pages.sections.features.book',
        'event' => 'frontend.pages.sections.features.event',
        'position' => 'frontend.pages.sections.features.position',
        'resource' => 'frontend.pages.sections.features.resource',
        'service' => 'frontend.pages.sections.features.service',
        'team' => 'frontend.pages.sections.features.team',
        'contact' => 'frontend.pages.sections.features.contact',
        default => null,
    };
@endphp

@if ($view && view()->exists($view))
    @include($view, ['section' => $section])
@endif
