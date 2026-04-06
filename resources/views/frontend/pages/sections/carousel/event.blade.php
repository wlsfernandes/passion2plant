@php
    use Illuminate\Support\Str;
@endphp

<section class="event__section pt-130 pb-130 overhid" style="{{ $section->style }}">
    <div class="container">
        @include('frontend.pages.sections.partials.content')
        <div class="row g-4">
            @foreach ($featuredEvents as $event)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp">
                    <div class="blog__items">

                        <div class="thumb">
                            <a href="{{ route('events.display', $event->slug) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'events', 'id' => $event->id]) }}"
                                    alt="{!! $event->getTitle() !!}">
                            </a>
                        </div>

                        <div class="content">
                            <h5>
                                <a href="{{ route('events.display', $event->slug) }}">
                                    {!! $event->getTitle() !!}
                                </a>
                            </h5>

                            <small class="text-muted d-block mb-2">
                                {{ $event->event_date?->format('F d, Y') }}
                            </small>

                            <p>
                                {!! $event->limitText($event->getContent(), 120) !!}
                            </p>

                            <a href="{{ route('events.display', $event->slug) }}"
                                class="btn btn-sm btn-outline-success mt-2">
                                @lang('pages.read_more')
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
