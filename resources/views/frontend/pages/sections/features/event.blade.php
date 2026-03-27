@php
    use Illuminate\Support\Str;
@endphp
<section class="event__section pt-130 pb-130 overhid">
    <div class="container">
        @include('frontend.pages.sections.partials.content')
        <div class="row g-4">
            @forelse($events as $event)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp"
                    data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                    <div class="event__items">

                        <div class="thumb">
                            <a href="{{ route('events.display', $event->slug) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'events', 'id' => $event->id]) }}"
                                    alt="{{ $event->getTitle() }}" loading="lazy">
                            </a>
                        </div>

                        <div class="content">
                            <h5>
                                <a href="{{ route('events.display', $event->slug) }}">
                                    {{ $event->getTitle() }}
                                </a>
                            </h5>

                            <small class="text-muted d-block mb-2">
                                {{ $event->event_date?->format('F d, Y') }}
                            </small>

                            <p>
                            <div class="cms-html" id="cms-html">
                                {!! $event->getContent() !!}
                            </div>
                            </p>

                            <a href="{{ route('events.display', $event->slug) }}" class="btns">
                                @lang('pages.read_more')
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    @lang('pages.no_events_available')
                </div>
            @endforelse
        </div>

    </div>
</section>
