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
            <div class="service__items h-100">

              <div class="content">

                <span class="badge bg-light text-dark mb-2">
                  {{ $item->title }}
                </span>

                @if ($item->description)
                  <small class="text-muted">
                    {{ \Illuminate\Support\Str::limit(strip_tags($item->description), 120) }}
                  </small>
                @endif

                <a href="{{ $item->external_link }}" class="btns mt-3" target="_blank" rel="noopener">
                  Visit Resource
                </a>
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
