@extends('admin.layouts.master')

@section('title', 'Banners')
@section('css')
  <link href="{{ asset('/assets/admin/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between">
      <h5>
        <i class="uil-megaphone"></i> Banners
      </h5>
      <a href="{{ route('banners.create') }}" class="btn btn-success">
        <i class="uil-plus"></i> Add Banner
      </a>
    </div>

    <div class="card-body">
      <x-alert />

      <table class="table table-bordered datatable-buttons">
        <thead>
          <tr>
            <th></th>
            <th>Title (EN)</th>
            <th>Link</th>
            <th>Published</th>
            <th>Publication Window</th>
            <th>Order</th>
            <th width="140">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($banners as $banner)
            <tr>
              {{-- Image --}}
              <td class="d-flex justify-content-center align-items-center">
                <div class="d-flex flex-column align-items-center justify-content-center">
                  @if ($banner->image_url)
                    <a href="{{ route('admin.images.preview', ['model' => 'banners', 'id' => $banner->id]) }}"
                      target="_blank" title="View image">
                      <img src="{{ route('admin.images.preview', ['model' => 'banners', 'id' => $banner->id]) }}"
                        alt="Banner image" class="rounded-circle mb-1" style="width:80px;height:80px;object-fit:cover;">
                    </a>
                  @else
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                      style="width:80px;height:80px;">
                      <i class="uil uil-image text-muted font-size-24"></i>
                    </div>
                  @endif

                  <a href="{{ route('admin.images.edit', ['model' => 'banners', 'id' => $banner->id]) }}"
                    class="text-primary small" title="Upload / Change image">
                    <i class="uil uil-edit"></i> Edit
                  </a>
                </div>
              </td>

              <td>
                <strong>{{ $banner->title_en }}</strong>

                @if ($banner->subtitle_en)
                  <br>
                  <small class="text-muted">
                    {{ Str::limit($banner->subtitle_en, 60) }}
                  </small>
                @endif
              </td>

              {{-- External link --}}
              <td>
                @if ($banner->link)
                  <a href="{{ $banner->link }}" target="{{ $banner->open_in_new_tab ? '_blank' : '_self' }}"
                    class="text-primary">
                    {{ Str::limit($banner->link, 40) }}
                  </a>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>

              {{-- Publish toggle (generic controller) --}}
              <td class="text-center">
                <form method="POST"
                  action="{{ route('admin.publish.toggle', [
                      'model' => Str::snake(class_basename($banner)),
                      'id' => $banner->id,
                  ]) }}">
                  @csrf
                  @method('PATCH')

                  <button type="submit"
                    class="badge border-0 {{ $banner->is_published ? 'bg-success' : 'bg-secondary' }}">
                    {{ $banner->is_published ? __('Yes') : __('No') }}
                  </button>
                </form>
              </td>

              {{-- Publication window --}}
              <td>
                <small>
                  From:
                  {{ $banner->publish_start_at?->format('M d, Y') ?? '-' }}<br>
                  To:
                  {{ $banner->publish_end_at?->format('M d, Y') ?? '-' }}
                </small>
              </td>

              {{-- Sort order --}}
              <td class="text-center">
                {{ $banner->sort_order }}
              </td>

              {{-- Actions --}}
              <td>
                <a href="{{ route('banners.edit', $banner) }}" class="btn btn-sm btn-warning">
                  <i class="uil-pen"></i>
                </a>

                <form action="{{ route('banners.destroy', $banner) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this banner?')">
                  @csrf
                  @method('DELETE')

                  <button class="btn btn-sm btn-danger">
                    <i class="uil-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
@section('script')
  <script src="{{ asset('/assets/admin/libs/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('/assets/admin/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('/assets/admin/libs/pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('/assets/admin/js/pages/datatables.init.js') }}"></script>
@endsection
