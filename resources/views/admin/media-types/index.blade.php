@extends('admin.layouts.master')

@section('title', 'Media Types')

@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
        <i class="uil uil-list-ul"></i> Media Types
      </h5>

      <a href="{{ route('media-types.create') }}" class="btn btn-success">
        <i class="uil uil-plus"></i> Add Media Type
      </a>
    </div>

    <div class="card-body">
      <x-alert />

      <table class="table table-bordered datatable-buttons">
        <thead>
          <tr>
            <th>Name</th>
            <th>Slug</th>
            <th>Status</th>
            <th width="140">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($mediaTypes as $mediaType)
            <tr>
              {{-- Name --}}
              <td>
                <strong>{{ $mediaType->name }}</strong>
              </td>

              {{-- Slug --}}
              <td>
                <code>{{ $mediaType->slug }}</code>
              </td>

              {{-- Active --}}
              <td class="text-center">
                <span class="badge {{ $mediaType->is_active ? 'bg-success' : 'bg-secondary' }}">
                  {{ $mediaType->is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>

              {{-- Actions --}}
              <td>
                <a href="{{ route('media-types.edit', $mediaType) }}" class="btn btn-sm btn-warning">
                  <i class="uil uil-pen"></i>
                </a>

                <form action="{{ route('media-types.destroy', $mediaType) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this media type?')">
                  @csrf
                  @method('DELETE')

                  <button class="btn btn-sm btn-danger">
                    <i class="uil uil-trash"></i>
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
