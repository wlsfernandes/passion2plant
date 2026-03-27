@php
    use Illuminate\Support\Str;
    $isSingle = $donations->count() === 1;
@endphp

<section class="service__section section__bg pt-130 pb-130 overhid">
    <div class="container">
        @include('frontend.pages.sections.partials.content')
        <div class="row g-4">
            @forelse($donations as $donation)
                <div class="{{ $isSingle ? 'col-12 d-flex justify-content-center' : 'col-xxl-4 col-xl-4 col-lg-4 col-md-6' }} wow fadeInUp"
                    data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                    <div class="service__items center {{ $isSingle ? 'mx-auto' : '' }}"
                        style="{{ $isSingle ? 'max-width:400px;' : '' }}">

                        {{-- Image --}}
                        <div class="thumb">
                            <img src="{{ route('admin.images.preview', ['model' => 'donations', 'id' => $donation->id]) }}"
                                alt="{{ $donation->title }}" loading="lazy">
                        </div>

                        {{-- Content --}}
                        <div class="content">

                            <h5 class="mb-1">
                                <a href="{{ route('donations.checkout', $donation) }}"
                                    class="text-decoration-none text-dark">
                                    {{ $donation->title }}
                                </a>
                            </h5>

                            @if ($donation->suggested_amount)
                                <span class="badge bg-soft-success text-success mb-2">
                                    Suggested: ${{ number_format($donation->suggested_amount, 0) }}
                                </span>
                            @endif

                            <p class="mt-2">
                                {{ Str::limit(strip_tags($donation->description), 120) }}
                            </p>

                            <a href="{{ route('donations.checkout', $donation) }}"
                                class="btn btn-sm btn-outline-success mt-2">
                                Give Now
                            </a>

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
