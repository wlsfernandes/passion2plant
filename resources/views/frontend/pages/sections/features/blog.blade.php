@php
    use Illuminate\Support\Str;
@endphp
<section class="blog__section overhid">
    <div class="container">
        @include('frontend.pages.sections.partials.content')
        <div class="row g-4">

            @forelse($blogs as $blog)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 wow fadeInUp"
                    data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                    <div class="blog__items">

                        <div class="thumb">
                            <a href="{{ route('blogs.display', $blog->slug) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'blogs', 'id' => $blog->id]) }}"
                                    alt="{{ $blog->getTitle() }}" loading="lazy">
                            </a>
                        </div>

                        <div class="content">
                            <h5>
                                <a href="{{ route('blogs.display', $blog->slug) }}">
                                    {{ $blog->getTitle() }}
                                </a>
                            </h5>

                            <p>
                                {{ Str::limit(strip_tags($blog->getContent()), 140) }}
                            </p>

                            <a href="{{ route('blogs.display', $blog->slug) }}"
                                class="btn btn-sm btn-outline-success mt-2">
                                @lang('pages.read_more')
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    @lang('pages.no_blogs_available')
                </div>
            @endforelse
        </div>

    </div>
</section>
