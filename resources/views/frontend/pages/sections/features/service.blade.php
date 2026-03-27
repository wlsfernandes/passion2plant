    @php use Illuminate\Support\Str; @endphp
    <section class="details__section pt-130 pb-130 overhid">
        <div class="container">
            @include('frontend.pages.sections.partials.content')
            <div class="row justify-content-center g-4">
                @forelse($services as $service)
                    <div class="col-12 col-sm-6 col-lg-4 d-flex">
                        <div class="details__items text-center w-100 d-flex flex-column">
                            <div class="details__thumb mb-3">
                                <a href="{{ route('services.display', $service->slug) }}">
                                    <img src="{{ route('admin.images.preview', ['model' => 'services', 'id' => $service->id]) }}"
                                        alt="{{ $service->getTitle() }}" class="img-fluid w-100" loading="lazy">
                                </a>
                            </div>
                            <div class="details__content px-3 d-flex flex-column flex-grow-1">

                                <h5 class="mb-2">
                                    <a href="{{ route('services.display', $service->slug) }}">
                                        {{ $service->getTitle() }}
                                    </a>
                                </h5>

                                <p class="flex-grow-1">
                                    {{ Str::limit(strip_tags($service->getDescription()), 120) }}
                                </p>

                                <a href="{{ route('services.display', $service->slug) }}" class="cmn--btn mt-3">
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
