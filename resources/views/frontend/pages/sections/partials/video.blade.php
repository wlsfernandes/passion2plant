@php
    $videoItems = collect();

    if ($section->image_url) {
        $videoItems->push(
            (object) [
                'model' => 'sections',
                'id' => $section->id,
                'embed' => $section->embed_url,
            ],
        );
    }

    foreach ($section->videos as $video) {
        $videoItems->push(
            (object) [
                'model' => 'section_videos',
                'id' => $video->id,
                'embed' => $video->embed_url,
            ],
        );
    }

    // Up to 3 per line, wrapping (and centering) any extra videos on the next line.
    $videoCols = min($videoItems->count(), 3) ?: 1;
    $videoColClass = intdiv(12, $videoCols);
@endphp

@if ($videoItems->count())
    <div class="row g-3 justify-content-center">
        @foreach ($videoItems as $item)
            <div class="col-12 col-md-{{ $videoColClass }}">
                <div class="section-video text-center mb-3">

                    <div class="video-wrapper position-relative" onclick="playVideo(this, '{{ $item->embed }}')">

                        {{-- Cover Image --}}
                        <img src="{{ route('admin.images.preview', [
                            'model' => $item->model,
                            'id' => $item->id,
                        ]) }}"
                            class="img-fluid rounded shadow-sm w-100 video-cover">

                        {{-- Play Button --}}
                        <span class="video-play-icon">
                            <i class="fas fa-play"></i>
                        </span>

                    </div>

                </div>
            </div>
        @endforeach
    </div>
@endif
@push('scripts')
    <script>
        function playVideo(element, url) {
            element.innerHTML = `
            <div class="ratio ratio-16x9">
                <iframe src="${url}?autoplay=1"
                    allow="autoplay; fullscreen"
                    allowfullscreen>
                </iframe>
            </div>
        `;
        }
    </script>
@endpush
