@php
    use Illuminate\Support\Str;

    $count = $featuredDonations->count();
    $isCentered = $count <= 2;
@endphp

<section class="blog__section section__bg pt-130 pb-130 overhid" style="{{ $section->style }}">
    <div class="container">

        @include('frontend.pages.sections.partials.content')

        <div class="row g-4 {{ $isCentered ? 'justify-content-center' : '' }}">

            @forelse($featuredDonations as $donation)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-12 wow fadeInUp"
                    data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                    <div class="blog__items h-100 d-flex flex-column">

                        {{-- Image --}}
                        <div class="thumb">
                            <a href="{{ route('donations.checkout', $donation) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'donations', 'id' => $donation->id]) }}"
                                    alt="{{ $donation->title }}" loading="lazy" style="object-position: top">
                            </a>
                        </div>

                        {{-- Content --}}
                        <div class="content d-flex flex-column flex-grow-1">

                            <p>
                            <div class="cms_content">
                                <a href="{{ route('donations.checkout', $donation) }}">
                                    {!! strip_tags($donation->title) !!}
                                </a>
                            </div>
                            </p>

                            @if ($donation->suggested_amount)
                                <span class="badge bg-soft-success text-success mb-2">
                                    Suggested: ${{ number_format($donation->suggested_amount, 0) }}
                                </span>
                            @endif

                            <p>
                            <div class="cms_content">
                                {!! Str::limit(strip_tags($donation->description), 120) !!}
                            </div>
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
