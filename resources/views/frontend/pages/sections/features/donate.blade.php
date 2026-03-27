@php
    use Illuminate\Support\Str;
    $isSingle = $donations->count() === 1;
@endphp

<section class="blog__section section__bg pt-130 pb-130 overhid">
    <div class="container">
        @include('frontend.pages.sections.partials.content')
        <div class="row g-4">
            @forelse($donations as $donation)
                <div class="{{ $isSingle ? 'col-md-6 col-lg-4 mx-auto' : 'col-xxl-4 col-xl-4 col-lg-4 col-md-6' }} wow fadeInUp"
                    data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                    <div class="blog__items h-100 d-flex flex-column">

                        {{-- Image --}}
                        <div class="thumb">
                            <a href="{{ route('donations.checkout', $donation) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'donations', 'id' => $donation->id]) }}"
                                    alt="{{ $donation->title }}" loading="lazy">
                            </a>
                        </div>

                        {{-- Content --}}
                        <div class="content d-flex flex-column flex-grow-1">

                            <h5>
                                <a href="{{ route('donations.checkout', $donation) }}">
                                    {{ html_entity_decode(strip_tags($donation->title)) }}
                                </a>
                            </h5>

                            @if ($donation->suggested_amount)
                                <span class="badge bg-soft-success text-success mb-2">
                                    Suggested: ${{ number_format($donation->suggested_amount, 0) }}
                                </span>
                            @endif

                            <p>
                                {{ Str::limit(strip_tags($donation->description), 120) }}
                            </p>

                            {{-- Button --}}
                            <div class="mt-auto">
                                <a href="{{ route('donations.checkout', $donation) }}"
                                    class="btn btn-sm btn-outline-success mt-2">
                                    Give Now
                                </a>
                            </div>

                        </div>

                    </div>
                </div>

            @empty
                <div class="col-12 text-center text-muted">
                    @lang('pages.no_services_available')
                </div>
            @endforelse

        </div>
    </div>
</section>
