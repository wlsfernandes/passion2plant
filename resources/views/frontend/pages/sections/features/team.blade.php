@php
    use Illuminate\Support\Str;
    $cleanStyle = $section->style;
    if ($section->background_image_url) {
        // Remove background-related styles
        $cleanStyle = preg_replace('/background[^;]+;?/i', '', $cleanStyle);
    }
@endphp
<section class="team__section overhid" style="{{ $section->style }}">
    <div class="container">
        @include('frontend.pages.sections.partials.content')
        <div class="row g-4">
            @foreach ($sectors as $sector)
                @if ($sector->teams->count())
                    {{-- Sector Title --}}
                    <div class="col-12 sector-title">
                        <div class="text-center mb-3 wow fadeInUp" data-wow-duration="2s">
                            <div class="fw-bold fs-4">
                                {{ $sector->name }}
                            </div>
                        </div>
                    </div>
                    @foreach ($sector->teams as $team)
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 wow fadeInUp"
                            data-wow-duration="{{ 3 + ($loop->index % 3) * 2 }}s">

                            <div class="blog__items h-100 position-relative">

                                {{-- Full Card Click --}}
                                <a href="{{ route('team.profile', $team->slug) }}" class="stretched-link"></a>

                                {{-- Image --}}
                                <div class="thumb">
                                    <img src="{{ route('admin.images.preview', ['model' => 'teams', 'id' => $team->id]) }}"
                                        alt="{{ $team->name }}" class="img-fluid w-100" loading="lazy"
                                        style="object-position: top;">
                                </div>

                                {{-- Content --}}
                                <div class="content text-center p-3">
                                    <h6 class="mb-1">{!! $team->name !!}</h6>

                                    @if ($team->role)
                                        <span class="team-role-badge">
                                            {!! $team->role !!}
                                        </span>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach
                @endif
            @endforeach

        </div>
    </div>
</section>
