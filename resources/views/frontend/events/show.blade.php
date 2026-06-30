@extends('frontend.layouts.app')

@section('title', html_entity_decode(strip_tags($event->getTitle())) . ' | Passion2Plant')

@section('content')
    <section class="details__section pt-130 pb-130 overhid" style="{{ $section->style ?? '' }}">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-10">
                    <div class="details__items">

                        <div class="details__thumb mb-4">
                            <img src="{{ route('admin.images.preview', ['model' => 'events', 'id' => $event->id]) }}"
                                alt="{{ $event->getTitle() }}">
                        </div>

                        <div class="details__content">
                            <div class="cms-html">{!! $event->getTitle() !!}</div>

                            {{--   <p class="text-muted mb-4">
                                {{ $event->event_date?->format('F d, Y') }}
                            </p> --}}
                            <div class="cms-html" id="cms-html">{!! $event->getContent() !!}</div>
                        </div>

                        @if ($event->video_embed_url || $event->hasDirectVideoFile())
                            <div class="my-4">
                                <div class="ratio ratio-16x9">
                                    @if ($event->video_embed_url)
                                        <iframe src="{{ $event->video_embed_url }}"
                                            title="{{ strip_tags($event->getTitle()) }}"
                                            allow="autoplay; fullscreen; picture-in-picture" allowfullscreen>
                                        </iframe>
                                    @else
                                        <video controls preload="metadata">
                                            <source src="{{ $event->video_url }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($event->hasDownloadFile())
                            <a href="{{ route('admin.files.download', [
                                'model' => 'events',
                                'id' => $event->id,
                                'lang' => app()->getLocale(),
                            ]) }}"
                                class="cmn--btn mt-4" target="_blank">
                                @lang('pages.download_file')
                            </a>
                        @endif


                        @if (!empty($event->external_link))
                            <a href="{{ $event->external_link }}" class="cmn--btn cmn--btn-outline" target="_blank"
                                rel="noopener noreferrer">
                                <i class="uil uil-external-link-alt"></i>
                                {{ $event->external_link_button_text ?? __('pages.apply_now') }}
                            </a>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
