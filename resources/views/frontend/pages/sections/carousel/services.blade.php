@php
    use Illuminate\Support\Str;

    $count = $featuredServices->count();
    $isCentered = $count <= 2;
@endphp

<!-- Service Section Here -->
<section class="service__section section__bg pt-130 pb-130 overhid" style="{{ $section->style }}">
    <div class="container">

        @include('frontend.pages.sections.partials.content')

        <div class="row g-4 {{ $isCentered ? 'justify-content-center' : '' }}">

            @forelse($featuredServices as $service)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-12 wow fadeInUp"
                    data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                    <div class="blog__items h-100 d-flex flex-column">

                        {{-- Image --}}
                        <div class="thumb">
                            <a href="{{ route('services.display', $service->slug) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'services', 'id' => $service->id]) }}"
                                    alt="{{ strip_tags($service->getTitle()) }}" loading="lazy"
                                    style="object-position: top;">
                            </a>
                        </div>

                        {{-- Content --}}
                        <div class="content d-flex flex-column flex-grow-1">

                            {{-- Title --}}
                            <div class="cms_content mb-2">
                                <a href="{{ route('services.display', $service->slug) }}">
                                    {!! strip_tags($service->getTitle()) !!}
                                </a>
                            </div>

                            {{-- Description --}}
                            <div class="cms_content mb-3">
                                {!! Str::limit(strip_tags($service->getContent()), 120) !!}
                            </div>

                            {{-- Button --}}
                            <div class="mt-auto">
                                <a href="{{ route('services.display', $service->slug) }}"
                                    class="btn btn-sm btn-outline-success mt-2">
                                    @lang('pages.read_more')
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
<!-- Service Section End -->
