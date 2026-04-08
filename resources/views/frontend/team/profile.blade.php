{{-- resources/views/frontend/pages/home.blade.php --}}
@extends('frontend.layouts.app')

@section('title', 'Our Team')

@section('content')

    <section class="team__details pt-130 overhid" style="margin-bottom: 130px; {{ $section->style ?? '' }}">
        <div class="container">
            <div class="row g-5">

                {{-- LEFT: IMAGE --}}
                <div class="col-xxl-5 col-xl-5 col-lg-8">
                    <div class="team__left">
                        <div class="details__thumb">
                            <img src="{{ route('admin.images.preview', ['model' => 'teams', 'id' => $team->id]) }}">
                        </div>
                    </div>
                </div>

                {{-- RIGHT: MAIN CONTENT --}}
                <div class="col-xxl-7 col-xl-7 col-lg-10">
                    <div class="details__cont">

                        <div class="cms-html">{!! $team->name !!}</div>

                        <span>
                            <div class="cms-html"> {!! $team->role !!}</div>

                        </span>

                        <p class="mt-4">
                        <div class="cms-html" id="cms-html">
                            {!! app()->getLocale() === 'es' ? $team->content_es : $team->content_en !!}
                        </div>
                        </p>

                    </div>
                </div>

            </div>

        </div>
    </section>

@endsection
