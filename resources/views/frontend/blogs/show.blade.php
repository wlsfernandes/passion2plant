@extends('frontend.layouts.app')

@section('title', html_entity_decode(strip_tags($blog->getTitle())) . ' | Passion2Plant')

@section('content')
    <section class="details__section pt-130 pb-130 overhid" style="{{ $section->style ?? '' }}">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-10">
                    <div class="details__items">

                        <div class="details__thumb mb-4">
                            <img src="{{ route('admin.images.preview', ['model' => 'blogs', 'id' => $blog->id]) }}"
                                alt="{{ $blog->getTitle() }}">
                        </div>
                        <div class="cms_html">
                            {!! $blog->getTitle() !!}
                            <div class="cms-html">
                                {!! $blog->getContent() !!}
                            </div>
                        </div>

                        @if ($blog->video_embed_url || $blog->hasDirectVideoFile())
                            <div class="my-4">
                                <div class="ratio ratio-16x9">
                                    @if ($blog->video_embed_url)
                                        <iframe src="{{ $blog->video_embed_url }}"
                                            title="{{ strip_tags($blog->getTitle()) }}"
                                            allow="autoplay; fullscreen; picture-in-picture" allowfullscreen>
                                        </iframe>
                                    @else
                                        <video controls preload="metadata">
                                            <source src="{{ $blog->video_url }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">

                            {{-- Download file --}}
                            @if ($blog->hasDownloadFile())
                                <a href="{{ route('admin.files.download', [
                                    'model' => 'blogs',
                                    'id' => $blog->id,
                                    'lang' => app()->getLocale(),
                                ]) }}"
                                    class="cmn--btn" target="_blank">
                                    @lang('pages.download_file')
                                </a>
                            @endif

                            {{-- External link --}}
                            @if (!empty($blog->external_link))
                                <a href="{{ $blog->external_link }}" class="cmn--btn cmn--btn-outline" target="_blank"
                                    rel="noopener noreferrer">
                                    <i class="uil uil-external-link-alt"></i>
                                    {{ $blog->external_link_button_text ?? __('pages.apply_now') }}
                                </a>
                            @endif

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
