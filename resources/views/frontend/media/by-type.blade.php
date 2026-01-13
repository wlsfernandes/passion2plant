@extends('frontend.layouts.app')

@section('title', $type->name)

@section('content')

  <section class="service__section pt-130 pb-130">
    <div class="container">

      {{-- Header --}}
      <div class="row mb-50">
        <div class="col-lg-8 mx-auto text-center">
          <h2>{{ $type->name }}</h2>

          @if ($type->description)
            <p class="text-muted mt-3">
              {{ $type->description }}
            </p>
          @endif
        </div>
      </div>

      {{-- Media Items --}}
      <div class="col-lg-4 col-md-6">
        <div class="service__items h-100 d-flex flex-column">

          <div class="content d-flex flex-column h-100">

            {{-- Media Type Badge --}}
            <span class="badge bg-light text-dark mb-2 align-self-start">
              {{ $type->name }}
            </span>

            {{-- Title (wraps naturally) --}}
            <h5 class="media-title">
              {{ $type->title }}
            </h5>

            {{-- Description (optional) --}}
            @if ($type->description)
              <p class="text-muted">
                {{ $type->description }}
              </p>
            @endif

            {{-- Action pinned to bottom --}}
            <div class="mt-auto pt-3 text-center">
              <a href="{{ $type->external_link }}" class="btns" target="_blank" rel="noopener">
                Visit Resource
              </a>
            </div>

          </div>

        </div>
      </div>


    </div>
  </section>

@endsection
