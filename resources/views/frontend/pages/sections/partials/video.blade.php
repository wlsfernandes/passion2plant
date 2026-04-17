@if ($section->image_url)
    <div class="section-video text-center">

        <div class="video-wrapper position-relative" onclick="playVideo(this, '{{ $section->embed_url }}')">

            {{-- Cover Image --}}
            <img src="{{ route('admin.images.preview', [
                'model' => 'sections',
                'id' => $section->id,
            ]) }}"
                class="img-fluid rounded shadow-sm w-100 video-cover">

            {{-- Play Button --}}
            <span class="video-play-icon">
                <i class="fas fa-play"></i>
            </span>

        </div>

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
