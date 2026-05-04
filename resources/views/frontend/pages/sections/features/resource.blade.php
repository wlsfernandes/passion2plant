@php
    $isSingle = $resources->count() === 1;
@endphp

<section class="blog__section pt-130 pb-130" style="{{ $section->style ?? '' }}">
    <div class="container">
        @include('frontend.pages.sections.partials.content')

        <div class="row g-4">
            @forelse ($resources as $resource)
                <div
                    class="{{ $isSingle ? 'col-md-6 col-lg-4 mx-auto' : 'col-xxl-4 col-xl-4 col-lg-4 col-md-6' }} wow fadeInUp">
                    <div class="blog__items h-100 d-flex flex-column">

                        @if ($resource->image_url)
                            <div class="thumb">
                                <img src="{{ route('admin.images.preview', ['model' => 'resources', 'id' => $resource->id]) }}"
                                    alt="{{ html_entity_decode(strip_tags($resource->title)) }}" loading="lazy">
                            </div>
                        @endif

                        <div class="content d-flex flex-column flex-grow-1">
                            @if ($resource->title)
                                <div class="cms-html mb-3">
                                    {!! $resource->title !!}
                                </div>
                            @endif

                            @if ($resource->description)
                                <div class="cms-html mb-3">
                                    {!! $resource->description !!}
                                </div>
                            @endif

                            <div class="mt-auto d-flex flex-wrap gap-2">
                                @if ($resource->file_url)
                                    <a href="{{ route('admin.files.download', [
                                        'model' => 'resources',
                                        'id' => $resource->id,
                                        'lang' => app()->getLocale(),
                                    ]) }}"
                                        class="btn btn-sm btn-outline-success" target="_blank">
                                        <i class="uil uil-file-download"></i>
                                        @lang('pages.download_file')
                                    </a>
                                @endif

                                @if ($resource->external_link)
                                    <a href="{{ $resource->external_link }}" class="btn btn-sm btn-outline-secondary"
                                        target="_blank" rel="noopener">
                                        <i class="uil uil-external-link-alt"></i>
                                        @lang('pages.visit_resource')
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    @lang('pages.no_resources_available')
                </div>
            @endforelse
        </div>
    </div>
</section>
