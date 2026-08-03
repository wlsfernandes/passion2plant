@if ($themeSettings?->is_enabled)
@php
    $resolvedBodyFont    = App\Models\ThemeSetting::BODY_FONTS[$themeSettings->body_font]    ?? null;
    $resolvedHeadingFont = App\Models\ThemeSetting::HEADING_FONTS[$themeSettings->heading_font] ?? null;
@endphp
@if ($resolvedBodyFont || $resolvedHeadingFont)
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Montserrat:wght@400;500;600;700&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
@endif
<style id="dynamic-site-theme">
    :root {
        --brand-primary:   {{ $themeSettings->primary_color }};
        --brand-secondary: {{ $themeSettings->secondary_color }};
        --brand-accent:    {{ $themeSettings->accent_color }};
        --brand-dark:      {{ $themeSettings->dark_color }};
        --brand-light:     {{ $themeSettings->light_color }};
        --brand-body:      {{ $themeSettings->body_color }};

        /* Compatibility — maps brand variables onto existing site variables */
        --theme-color:   var(--brand-primary);
        --black-color:   var(--brand-dark);
        --title-color:   var(--brand-dark);
        --section-color: var(--brand-light);
        --body:          var(--brand-body);
        --ratting-color: var(--brand-accent);

        @if ($themeSettings->header_text_mode === 'dark')
            --header-menu-text-color: var(--brand-dark);
        @else
            --header-menu-text-color: var(--white-color);
        @endif

        @if ($resolvedBodyFont)
            --theme-body-font: {!! $resolvedBodyFont !!};
        @endif

        @if ($resolvedHeadingFont)
            --theme-heading-font: {!! $resolvedHeadingFont !!};
        @endif
    }
</style>
@endif
