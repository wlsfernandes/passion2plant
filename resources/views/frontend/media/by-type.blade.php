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
      <div class="row g-4">

        @forelse ($media as $item)
          <div class="col-lg-4 col-md-6">
            <div class="service__items h-100 d-flex flex-column">

              <div class="content d-flex flex-column h-100">

                {{-- Title --}}
                <div class="media-meta text-muted small mb-3">
                  <i class="uil uil-link"></i>
                  {{ parse_url($item->external_link, PHP_URL_HOST) }}
                </div>

                {{-- Description --}}
                @if ($item->description)
                  <p class="text-muted">
                    {{ $item->description }}
                  </p>
                @endif

                {{-- Button pinned to bottom --}}
                <div class="mt-auto pt-3">
                  <a href="{{ $item->external_link }}" class="btns" target="_blank" rel="noopener">
                    Visit Resource
                  </a>
                </div>

              </div>

            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted">
            No resources available yet.
          </div>
        @endforelse

      </div>

    </div>
  </section>

@endsection
