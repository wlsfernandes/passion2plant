@if ($section->image_url)
    <div class="section-video text-center position-relative">

        <a href="#" data-bs-toggle="modal" data-bs-target="#videoModal">
            <img src="{{ route('admin.images.preview', [
                'model' => 'sections',
                'id' => $section->id,
            ]) }}"
                class="img-fluid rounded shadow-sm w-100">

            <span class="video-play-icon">
                <i class="fas fa-play"></i>
            </span>
        </a>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <!-- ✅ Close button -->
                <button type="button"
                    class="position-absolute top-0 end-0 m-3 z-3 d-flex align-items-center justify-content-center"
                    data-bs-dismiss="modal" aria-label="Close"
                    style="
                    width: 40px;
                    height: 40px;
                    background-color: #dc3545;
                    border: none;
                    border-radius: 50%;
                    color: #fff;
                    font-size: 20px;
                    font-weight: bold;
                ">
                    &times;
                </button>

                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9">
                        <iframe id="videoIframe" src="{{ $section->embed_url }}" allow="autoplay; fullscreen"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endif
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoIframe');

            modal.addEventListener('hidden.bs.modal', function() {
                // Stop video by resetting src
                iframe.src = iframe.src;
            });
        });
    </script>
@endpush
