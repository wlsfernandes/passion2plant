@php
    $view = match ($section->feature_type) {
        'blog' => 'frontend.pages.sections.features.blog',
        'team' => 'frontend.pages.sections.features.team',
        'services' => 'frontend.pages.sections.features.service',
        'event' => 'frontend.pages.sections.features.event',
        default => null,
    };
@endphp

@if ($view && view()->exists($view))
    @include($view, ['section' => $section])
@endif
