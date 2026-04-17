<div class="blog__items h-100 d-flex flex-column">

    {{-- Image --}}
    <div class="thumb">
        <a href="{{ route('services.display', $service->slug) }}">
            <img src="{{ route('admin.images.preview', ['model' => 'services', 'id' => $service->id]) }}"
                alt="{{ strip_tags($service->getTitle()) }}" loading="lazy" style="object-position: top;">
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
            {!! \Illuminate\Support\Str::limit(strip_tags($service->getContent()), 120) !!}
        </div>

        {{-- Button --}}
        <div class="mt-auto">
            <a href="{{ route('services.display', $service->slug) }}" class="btn btn-sm btn-outline-success mt-2">
                @lang('pages.read_more')
            </a>
        </div>

    </div>
</div>
