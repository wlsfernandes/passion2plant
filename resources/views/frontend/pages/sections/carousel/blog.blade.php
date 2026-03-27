<section class="blog__section pt-130 pb-130 overhid">
    <div class="container">
        @include('frontend.pages.sections.partials.content')
        <div class="row g-4">
            @foreach ($featuredBlogs as $blog)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp">
                    <div class="blog__items">

                        <div class="thumb">
                            <a href="{{ route('blogs.display', $blog->slug) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'blogs', 'id' => $blog->id]) }}"
                                    alt="">
                            </a>
                        </div>
                        <div class="content">
                            <h5>
                                <a href="{{ route('blogs.display', $blog->slug) }}">
                                    {{ $blog->getTitle() }}
                                </a>
                            </h5>
                            <p>
                                {{ $blog->limitText($blog->getContent(), 120) }}
                            </p>
                            <a href="{{ route('blogs.display', $blog->slug) }}" class="btns">
                                @lang('pages.read_more')
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
