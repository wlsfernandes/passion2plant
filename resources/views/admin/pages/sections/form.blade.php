@extends('admin.layouts.master')

@section('title', isset($section) ? 'Edit Page Section' : 'Add Page Section')

@section('content')

    @php
        $type = old('type', $section->type ?? request('type', 'content'));
    @endphp

    <div class="card border border-primary">

        <div class="card-header">
            @switch($type)
                @case('content')
                    <img src="{{ asset('assets/admin/images/icons/content.png') }}" alt="Content Icon" width="96">
                @break

                @case('cta')
                    <img src="{{ asset('assets/admin/images/icons/cta.png') }}" alt="CTA Icon" width="96">
                @break

                @case('promo')
                    <img src="{{ asset('assets/admin/images/icons/promo.png') }}" alt="Promo Icon" width="96">
                @break

                @case('gallery')
                    <img src="{{ asset('assets/admin/images/icons/gallery.png') }}" alt="Gallery Icon" width="96">
                @break

                @case('hero')
                    <img src="{{ asset('assets/admin/images/icons/header.png') }}" alt="Banner Icon" width="96">
                @break

                @case('video')
                    <img src="{{ asset('assets/admin/images/icons/video.png') }}" alt="Video Icon" width="96">
                @break

                @default
            @endswitch
            <h5 class="mb-0">
                <i class="uil uil-layers"></i>
                {{ isset($section) ? 'Edit Section ' . ucfirst($type) : 'Create Section' . ' ' . ucfirst($type) }}
            </h5>
            <small class="text-muted">
                Page: {{ $page->title }}
            </small>
        </div>

        <div class="card-body">

            <x-alert />

            <form method="POST"
                action="{{ isset($section) ? route('pages.sections.update', [$page, $section]) : route('pages.sections.store', $page) }}"
                enctype="multipart/form-data">
                @csrf
                @isset($section)
                    @method('PUT')
                @endisset
                <input type="hidden" name="type" value="{{ $type }}">
                @include('admin.pages.sections.types.settings', ['type' => $type])


                @if ($type === 'promo')
                    @include('admin.pages.sections.partials.button')
                    @include('admin.pages.sections.types.content')
                @endif

                @if ($type === 'content')
                    @include('admin.pages.sections.types.content')
                @endif

                @if ($type === 'cta')
                    @include('admin.pages.sections.partials.button')
                    @include('admin.pages.sections.types.content')
                @endif
                @if ($type === 'feature')
                    @include('admin.pages.sections.types.feature')
                    @include('admin.pages.sections.types.content')
                @endif
                @if ($type === 'carousel')
                    @include('admin.pages.sections.types.carousel')
                    @include('admin.pages.sections.types.content')
                @endif
                @if ($type === 'gallery')
                    @include('admin.pages.sections.partials.multiple-images')
                    @include('admin.pages.sections.types.content')
                @endif

                @if ($type === 'video')
                    @include('admin.pages.sections.partials.video')
                    @include('admin.pages.sections.partials.button')
                    @include('admin.pages.sections.types.content')
                @endif

                @include('admin.pages.sections.partials.actions')

            </form>

        </div>
    </div>

@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.delete-image').forEach(function(button) {

                button.addEventListener('click', function(e) {

                    e.preventDefault();

                    if (!confirm('Delete this image?')) {
                        return;
                    }

                    const url = this.getAttribute('data-url');

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                _method: 'DELETE'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {

                            if (data.success) {
                                this.closest('.gallery-card').remove();
                            } else {
                                alert('Failed to delete image');
                            }

                        })
                        .catch(function(error) {
                            console.error(error);
                            alert('Server error');
                        });

                });

            });

        });

        function deleteBackgroundImage(sectionId) {
            if (!confirm('Are you sure you want to delete this image?')) return;

            fetch(`/sections/${sectionId}/delete-background-image`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // remove image from UI
                        document.getElementById('bg-image-container').remove();

                        alert('Image deleted successfully');
                    } else {
                        alert(data.message || 'Error deleting image');
                    }
                })
                .catch(error => {
                    console.error(error);
                    alert('Something went wrong');
                });
        }
        /* save link to multiple images */
        document.addEventListener("DOMContentLoaded", function() {

            // Open modal
            document.querySelectorAll('.edit-link-btn').forEach(btn => {
                btn.addEventListener('click', function() {

                    let link = this.dataset.link || '';

                    document.getElementById('image_id').value = this.dataset.id;

                    let typeSelect = document.getElementById('link_type');
                    let input = document.getElementById('link_input');
                    let label = document.getElementById('link_label');

                    // 🔥 Detect type
                    if (link.includes(window.location.origin)) {

                        typeSelect.value = 'internal';

                        let path = link.replace(window.location.origin + '/', '');

                        input.value = '/' + path;

                        label.innerText = 'Internal Link';
                        input.placeholder = '/about-us';

                    } else {

                        typeSelect.value = 'external';

                        input.value = link;

                        label.innerText = 'External Link';
                        input.placeholder = 'https://example.com';
                    }

                    let modal = new bootstrap.Modal(document.getElementById('linkModal'));
                    modal.show();
                });
            });
            document.getElementById('link_type').addEventListener('change', function() {

                let isInternal = this.value === 'internal';

                let input = document.getElementById('link_input');
                let label = document.getElementById('link_label');

                if (isInternal) {
                    label.innerText = 'Internal Link';
                    input.placeholder = '/about-us';
                } else {
                    label.innerText = 'External Link';
                    input.placeholder = 'https://example.com';
                }

            });
            // Save link
            document.getElementById('saveLinkBtn').addEventListener('click', function() {

                let id = document.getElementById('image_id').value;
                let type = document.getElementById('link_type').value;

                let value = document.getElementById('link_input').value.trim();

                console.log('TYPE:', type);
                console.log('INPUT:', value);

                let link = null; // 🔥 default = remove link

                if (value !== '') {

                    if (type === 'internal') {

                        value = value.replace(window.location.origin, '');
                        value = value.replace(/^\/+/, '');

                        link = window.location.origin + '/' + value;

                    } else {
                        link = value;
                    }
                }

                console.log('FINAL LINK:', link);

                fetch(`/admin/section-images/${id}/link`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            external_link: link, // 🔥 can be null now
                            link_type: type
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) location.reload();
                    });

            });

        });
    </script>
@endsection
