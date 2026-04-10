@php
    use Illuminate\Support\Str;

    $cleanStyle = $section->style;

    if ($section->background_image_url) {
        // Remove background-related styles
        $cleanStyle = preg_replace('/background[^;]+;?/i', '', $cleanStyle);
    }
@endphp

<section class="team__section overhid" style="{{ $cleanStyle }}">
    <div class="container">

        {{-- Section Content --}}
        @include('frontend.pages.sections.partials.content')

        <div class="row g-4">

            @foreach ($sectors as $sector)
                @if ($sector->teams->count())
                    {{-- Sector Title --}}
                    <div class="col-12 sector-title">
                        <div class="text-center mb-4 wow fadeInUp" data-wow-duration="1.5s">
                            <div class="fw-bold fs-3">
                                {{ strip_tags($sector->name) }}
                            </div>
                        </div>
                    </div>

                    {{-- Teams --}}
                    @foreach ($sector->teams as $team)
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 wow fadeInUp"
                            data-wow-duration="{{ 1.5 + ($loop->index % 3) * 0.5 }}s">

                            <div class="blog__items h-100 position-relative">

                                {{-- Full Card Click --}}
                                <a href="{{ route('team.profile', $team->slug) }}" class="stretched-link"></a>

                                {{-- Image --}}
                                <div class="thumb overflow-hidden">
                                    <img src="{{ route('admin.images.preview', ['model' => 'teams', 'id' => $team->id]) }}"
                                        alt="{{ strip_tags($team->name) }}" class="img-fluid w-100" loading="lazy"
                                        style="object-fit: cover; height: 260px; object-position: top;">
                                </div>

                                {{-- Content --}}
                                <div class="content text-center p-3">

                                    {{-- Name (clean, no HTML) --}}
                                    <h6 class="mb-1">
                                        {{ Str::limit(strip_tags($team->name), 60) }}
                                    </h6>

                                    {{-- Role (optional, clean) --}}
                                    @if ($team->role)
                                        <span class="team-role-badge">
                                            {{ strip_tags($team->role) }}
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
