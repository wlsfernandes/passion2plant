@php
    use Illuminate\Support\Str;
    $isSingle = $services->count() === 1;
@endphp

<section class="blog__section pt-130 pb-130 overhid mb-50" style="{{ $section->style ?? '' }}">
    <div class="container">

        @include('frontend.pages.sections.partials.content')

        <div class="row g-4">
            @forelse($services as $service)
                <div
                    class="{{ $isSingle ? 'col-md-6 col-lg-4 mx-auto' : 'col-xxl-4 col-xl-4 col-lg-4 col-md-6' }} wow fadeInUp">

                    <div class="blog__items">

                        {{-- Image --}}
                        <div class="thumb">
                            <a href="{{ route('services.display', $service->slug) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'services', 'id' => $service->id]) }}"
                                    loading="lazy">
                            </a>
                        </div>

                        {{-- Content --}}
                        <div class="content">

                            {{-- Title (SAFE) --}}
                            <div class="cms-html">
                                <a href="{{ route('services.display', $service->slug) }}">
                                    {{ $service->getTitle() }}
                                </a>
                            </div>

                            {{-- Content (SAFE TRUNCATION) --}}
                            <div class="cms-html">
                                {{ Str::limit(strip_tags($service->getContent()), 120) }}
                            </div>

                            <a href="{{ route('services.display', $service->slug) }}"
                                class="btn btn-sm btn-outline-success mt-2">
                                @lang('pages.read_more')
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
