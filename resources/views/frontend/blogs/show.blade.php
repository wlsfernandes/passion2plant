@extends('frontend.layouts.app')

@section('title', $blog->getTitle())

@section('content')
    <section class="details__section pt-130 pb-130 overhid">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-lg-10">
                    <div class="details__items">

                        <div class="details__thumb mb-4">
                            <img src="{{ route('admin.images.preview', ['model' => 'blogs', 'id' => $blog->id]) }}"
                                alt="{{ $blog->getTitle() }}">
                        </div>

                        <div class="details__content">
                            <h2>{{ $blog->getTitle() }}</h2>

                            {!! $blog->getContent() !!}
                        </div>
@if($blog->hasDownloadFile())
    <a href="{{ route('admin.files.download', [
            'model' => 'blogs',
            'id'    => $blog->id,
            'lang'  => app()->getLocale(),
        ]) }}"
       class="cmn--btn mt-4" target="_blank">
        @lang('pages.download_file')
    </a>
@endif
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection