@extends('frontend.layouts.app')

@section('title', $page->title . ' | Passion2Plant')

@section('content')
    @if ($page->banners->count())
        @include('frontend.partials.banner', ['banners' => $page->banners])
    @endif
    @foreach ($page->sections as $section)
        @if ($section->type === 'promo')
            @include('frontend.pages.sections.promo', ['section' => $section])
        @elseif ($section->type === 'cta')
            @include('frontend.pages.sections.cta', ['section' => $section])
        @elseif ($section->type === 'content')
            @include('frontend.pages.sections.content', ['section' => $section])
        @elseif ($section->type === 'feature')
            @include('frontend.pages.sections.feature', ['section' => $section])
        @elseif ($section->type === 'gallery')
            @include('frontend.pages.sections.gallery', ['section' => $section])
        @elseif ($section->type === 'video')
            @include('frontend.pages.sections.video', ['section' => $section])
        @endif
    @endforeach
@endsection
