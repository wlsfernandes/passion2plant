@extends('admin.layouts.master')

@section('title', 'Theme Colors')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="fas fa-palette"></i> Theme Colors
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <i class="fas fa-info-circle"></i>
                <strong>Custom theme is disabled by default.</strong>
                When disabled, the website uses its original built-in colors.
                Enable the custom theme only when you want to apply the colors below.
                <ul class="mb-0 mt-2">
                    <li><strong>Primary</strong> — main brand color used throughout the site (buttons, headings, links).
                    </li>
                    <li><strong>Secondary</strong> — stored and available for future components; not yet widely used.</li>
                    <li><strong>Accent</strong> — highlights such as star ratings.</li>
                    <li><strong>Dark</strong> — headings and dark-text areas.</li>
                    <li><strong>Light</strong> — light background sections.</li>
                    <li><strong>Body</strong> — main page background.</li>
                </ul>
            </div>

            <form method="POST" action="{{ route('theme-settings.update') }}">
                @csrf
                @method('PUT')

                {{-- Enable Toggle --}}
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input type="hidden" name="is_enabled" value="0">
                        <input class="form-check-input" type="checkbox" name="is_enabled" id="is_enabled" value="1"
                            {{ old('is_enabled', $themeSetting->is_enabled) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_enabled">
                            Enable custom theme
                        </label>
                    </div>
                    <small class="text-muted">
                        When off, the website uses its original colors and this configuration has no effect.
                    </small>
                </div>

                <hr>

                <h6 class="text-primary mb-3">
                    <i class="fas fa-circle-dot"></i> Color Configuration
                </h6>

                @php
                    $colors = [
                        [
                            'field' => 'primary_color',
                            'label' => 'Primary Color',
                            'hint' => 'Main brand color — buttons, headings, links.',
                        ],
                        [
                            'field' => 'secondary_color',
                            'label' => 'Secondary Color',
                            'hint' => 'Available for selected future components.',
                        ],
                        [
                            'field' => 'accent_color',
                            'label' => 'Accent Color',
                            'hint' => 'Highlights such as star ratings.',
                        ],
                        ['field' => 'dark_color', 'label' => 'Dark Color', 'hint' => 'Headings and dark-text areas.'],
                        [
                            'field' => 'light_color',
                            'label' => 'Light / Section Color',
                            'hint' => 'Light background sections.',
                        ],
                        [
                            'field' => 'body_color',
                            'label' => 'Body / Background Color',
                            'hint' => 'Main page background.',
                        ],
                    ];
                @endphp

                <div class="row">
                    @foreach ($colors as $color)
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="{{ $color['field'] }}">{{ $color['label'] }}</label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color p-1"
                                    id="{{ $color['field'] }}_picker"
                                    value="{{ old($color['field'], $themeSetting->{$color['field']}) }}"
                                    title="Pick a color"
                                    oninput="document.getElementById('{{ $color['field'] }}').value = this.value.toUpperCase()">
                                <input type="text" class="form-control font-monospace text-uppercase"
                                    id="{{ $color['field'] }}" name="{{ $color['field'] }}"
                                    value="{{ old($color['field'], $themeSetting->{$color['field']}) }}" maxlength="7"
                                    placeholder="#000000"
                                    oninput="if(/^#[0-9A-Fa-f]{6}$/.test(this.value)) document.getElementById('{{ $color['field'] }}_picker').value = this.value">
                            </div>
                            @error($color['field'])
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">{{ $color['hint'] }}</small>
                        </div>
                    @endforeach
                </div>

                <hr>

                <h6 class="text-primary mb-3">
                    <i class="fas fa-bars"></i> Header Navigation
                </h6>

                <div class="mb-3">
                    <label class="form-label" for="header_text_mode">Header navigation text</label>
                    <select name="header_text_mode" id="header_text_mode" class="form-select" style="max-width: 280px;">
                        <option value="light"
                            {{ old('header_text_mode', $themeSetting->header_text_mode ?? 'light') === 'light' ? 'selected' : '' }}>
                            Light text (white)
                        </option>
                        <option value="dark"
                            {{ old('header_text_mode', $themeSetting->header_text_mode ?? 'light') === 'dark' ? 'selected' : '' }}>
                            Dark text
                        </option>
                    </select>
                    @error('header_text_mode')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        Choose the option that provides the clearest contrast with the header background.
                    </small>
                </div>

                <hr>

                <h6 class="text-primary mb-3">
                    <i class="fas fa-font"></i> Typography
                </h6>

                <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-3">
                    <i class="fas fa-info-circle"></i>
                    Font overrides apply when the custom theme is enabled.
                    Choosing <strong>Default</strong> preserves the current built-in font for that role.
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="body_font">Body text font</label>
                        <select name="body_font" id="body_font" class="form-select">
                            <option value="default"
                                {{ old('body_font', $themeSetting->body_font ?? 'default') === 'default' ? 'selected' : '' }}>
                                Default (Montserrat)
                            </option>
                            <option value="source-sans-3"
                                {{ old('body_font', $themeSetting->body_font ?? 'default') === 'source-sans-3' ? 'selected' : '' }}>
                                Source Sans 3
                            </option>
                            <option value="dm-serif-display"
                                {{ old('heading_font', $themeSetting->heading_font ?? 'default') === 'dm-serif-display' ? 'selected' : '' }}>
                                DM Serif Display
                            </option>
                        </select>
                        @error('body_font')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Applies to body text and paragraphs.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="heading_font">Heading font</label>
                        <select name="heading_font" id="heading_font" class="form-select">
                            <option value="default"
                                {{ old('heading_font', $themeSetting->heading_font ?? 'default') === 'default' ? 'selected' : '' }}>
                                Default (Inter)
                            </option>
                            <option value="montserrat"
                                {{ old('heading_font', $themeSetting->heading_font ?? 'default') === 'montserrat' ? 'selected' : '' }}>
                                Montserrat
                            </option>
                            <option value="dm-serif-display"
                                {{ old('heading_font', $themeSetting->heading_font ?? 'default') === 'dm-serif-display' ? 'selected' : '' }}>
                                DM Serif Display
                            </option>
                        </select>
                        @error('heading_font')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Applies to h1–h6 headings.</small>
                    </div>
                </div>

                <div class="text-end mt-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i> Save Theme
                    </button>
                </div>
            </form>

            <hr>

            {{-- Reset --}}
            <form method="POST" action="{{ route('theme-settings.reset') }}">
                @csrf
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <small class="text-muted">
                        Reset will restore the original default colors and fonts, and <strong>disable</strong> the custom
                        theme.
                    </small>
                    <button type="submit" class="btn btn-outline-secondary btn-sm"
                        onclick="return confirm('Reset theme colors and fonts to original defaults and disable custom theme?')">
                        <i class="fas fa-undo"></i> Reset to Original Colors
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
