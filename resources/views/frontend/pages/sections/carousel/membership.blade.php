@php
    use Illuminate\Support\Str;

    $count = $featuredMemberships->count();
    $isCentered = $count <= 2;
@endphp

<section class="blog__section section__bg pt-130 pb-130 overhid" style="{{ $section->style }}">
    <div class="container">

        @include('frontend.pages.sections.partials.content')

        <div class="row g-4 {{ $isCentered ? 'justify-content-center' : '' }}">

            @forelse($featuredMemberships as $membership)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-12 wow fadeInUp"
                    data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                    <div class="blog__items h-100 d-flex flex-column">

                        {{-- Image --}}
                        <div class="thumb">
                            <a href="{{ route('memberships.information', $membership) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'memberships', 'id' => $membership->id]) }}"
                                    alt="{{ strip_tags($membership->title) }}" loading="lazy"
                                    style="object-position: top;">
                            </a>
                        </div>

                        {{-- Content --}}
                        <div class="content d-flex flex-column flex-grow-1">

                            {{-- Title --}}
                            <div class="cms_content mb-2">
                                <a href="{{ route('memberships.information', $membership) }}">
                                    {!! strip_tags($membership->title) !!}
                                </a>
                            </div>

                            {{-- Amount --}}
                            @if ($membership->amount)
                                <span class="badge bg-soft-success text-success mb-2">
                                    ${{ number_format($membership->amount, 0) }}
                                </span>
                            @endif

                            {{-- Description --}}
                            <div class="cms_content mb-3">
                                {!! Str::limit(strip_tags($membership->description), 120) !!}
                            </div>

                            {{-- Button --}}
                            <div class="mt-auto">
                                <a href="{{ route('memberships.information', $membership) }}"
                                    class="btn btn-sm btn-outline-success mt-2">
                                    Become a Member Now
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
