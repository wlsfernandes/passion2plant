@php
    use Illuminate\Support\Str;

    $count = $featuredBlogs->count();
    $isCentered = $count <= 2;
@endphp

<section class="blog__section pt-130 pb-130 overhid mb-50" style="{{ $section->style }}">
    <div class="container">
        @include('frontend.pages.sections.partials.content')

        <div class="row g-4 {{ $isCentered ? 'justify-content-center' : '' }}">
            @foreach ($featuredBlogs as $blog)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-12 wow fadeInUp"
                    data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                    <div class="blog__items">

                        <div class="thumb">
                            <a href="{{ route('blogs.display', $blog->slug) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'blogs', 'id' => $blog->id]) }}"
                                    alt="">
                            </a>
                        </div>

                        <div class="content">
                            <p>
                            <div class="cms_content">
                                <a href="{{ route('blogs.display', $blog->slug) }}">
                                    {!! $blog->getTitle() !!}
                                </a>
                            </div>
                            </p>
                            <p>
                            <div class="cms_content">
                                {!! $blog->limitText($blog->getContent(), 120) !!}
                            </div>
                            </p>

                            <a href="{{ route('blogs.display', $blog->slug) }}"
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
