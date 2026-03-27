@php
    $isSingle = $books->count() === 1;
@endphp

<section class="blog__section section__bg pt-130 pb-130 overhid">

    <div class="container">
        @include('frontend.pages.sections.partials.content')
        <div class="row g-4">

            @forelse ($books as $book)
                <div class="{{ $isSingle ? 'col-md-6 col-lg-4 mx-auto' : 'col-xxl-3 col-xl-3 col-lg-4 col-md-6' }} wow fadeInUp"
                    data-wow-duration="{{ 2 + ($loop->index % 3) }}s">

                    <div class="blog__items h-100 d-flex flex-column text-center">

                        {{-- Clickable card --}}
                        <a href="{{ $book->external_link }}" target="_blank" rel="noopener"
                            class="text-decoration-none text-dark d-flex flex-column h-100">

                            {{-- Cover --}}
                            <div class="thumb">
                                @if ($book->image_url)
                                    <img src="{{ route('admin.images.preview', [
                                        'model' => 'book-recommendations',
                                        'id' => $book->id,
                                    ]) }}"
                                        alt="{{ $book->title }}" loading="lazy">
                                @else
                                    <div class="d-flex align-items-center justify-content-center"
                                        style="height: 200px;">
                                        <i class="uil uil-book-open" style="font-size: 40px;"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Title --}}
                            <div class="content mt-3">
                                <h6 class="mb-0">
                                    {{ html_entity_decode(strip_tags($book->title)) }}
                                </h6>
                            </div>

                        </a>

                    </div>
                </div>

            @empty
                <div class="col-12 text-center text-muted">
                    @lang('pages.no_books_available')
                </div>
            @endforelse

        </div>
    </div>
</section>
