@php
    use Illuminate\Support\Str;
    $isSingle = $positions->count() === 1;
@endphp

<section class="blog__section pt-130 pb-130 overhid mb-50" style="{{ $section->style ?? '' }}">
    <div class="container">
        @include('frontend.pages.sections.partials.content')

        <div class="row g-4">

            @forelse($positions as $position)
                <div
                    class="{{ $isSingle ? 'col-md-6 col-lg-4 mx-auto' : 'col-xxl-4 col-xl-4 col-lg-4 col-md-6' }} wow fadeInUp">

                    <div class="blog__items">

                        {{-- Image --}}
                        <div class="thumb">
                            <a href="{{ route('positions.display', $position->slug) }}">
                                <img src="{{ route('admin.images.preview', ['model' => 'positions', 'id' => $position->id]) }}"
                                    alt="{{ $position->getTitle() }}" loading="lazy">
                            </a>
                        </div>

                        {{-- Content --}}
                        <div class="content">

                            <h5>
                                <a href="{{ route('positions.display', $position->slug) }}">
                                    {!! $position->getTitle() !!}
                                </a>
                            </h5>

                            <p>
                                {!! Str::limit($position->getContent(), 120) !!}
                            </p>

                            <a href="{{ route('positions.display', $position->slug) }}"
                                class="btn btn-sm btn-outline-success mt-2">
                                @lang('pages.view_position')
                            </a>

                        </div>

                    </div>
                </div>

            @empty
                <div class="col-12 text-center text-muted">
                    @lang('pages.no_open_positions')
                </div>
            @endforelse

        </div>
    </div>
</section>
