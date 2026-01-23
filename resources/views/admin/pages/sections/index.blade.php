@extends('admin.layouts.master')

@section('title', 'Page Sections')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">
                    <i class="uil uil-layers"></i>
                    Sections for Page
                </h5>
                <small class="text-muted">
                    {{ $page->title }}
                </small>
            </div>

            <a href="{{ route('pages.sections.create', $page) }}" class="btn btn-success">
                <i class="uil uil-plus"></i> Add Section
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th width="60">Order</th>
                        <th>Title (EN)</th>
                        <th>External Link</th>
                        <th width="120">Published</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sections as $section)
                        <tr>
                            <td class="align-middle text-center">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    @if ($section->image_url)
                                        <a href="{{ route('admin.images.preview', ['model' => 'sections', 'id' => $section->id]) }}"
                                            target="_blank" title="View image">
                                            <img src="{{ route('admin.images.preview', ['model' => 'sections', 'id' => $section->id]) }}"
                                                alt="Page image" class="rounded-circle mb-1"
                                                style="width:80px;height:80px;object-fit:cover;">
                                        </a>
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                                            style="width:80px;height:80px;">
                                            <i class="uil uil-image text-muted font-size-24"></i>
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('pages.sections.edit', [$page, $section]) }}" class="text-primary small"
                                    title="Upload / Change image">
                                    <i class="uil uil-edit"></i> Edit
                                </a>
                            </td>
                            <td class="text-center">
                                {{ $section->sort_order ?? '—' }}
                            </td>

                            <td>
                                {{ $section->title_en ?? '—' }}
                            </td>

                            <td>
                                @if ($section->external_link)
                                    <i class="fa-solid fa-link text-primary"></i>
                                    <a href="{{ $section->external_link ?? '#' }}" target="_blank">
                                        Click here</a>
                                @else
                                    <i class="fa-solid fa-link-slash text-secondary"></i>
                                    <span class="text-muted">No link</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <span class="badge {{ $section->is_published ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $section->is_published ? 'Yes' : 'No' }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('pages.sections.edit', [$page, $section]) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="uil uil-pen"></i>
                                </a>

                                <form action="{{ route('pages.sections.destroy', [$page, $section]) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Delete this section?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="uil uil-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                No sections created yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
