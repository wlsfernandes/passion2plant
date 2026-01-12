@extends('admin.layouts.master')

@section('title', 'Projects')

@section('content')
  <div class="card border border-primary">
    <div class="card-header d-flex justify-content-between">
      <h5>
        <i class="uil-briefcase"></i> Projects
      </h5>
      <a href="{{ route('projects.create') }}" class="btn btn-success">
        <i class="uil-plus"></i> Add Project
      </a>
    </div>

    <div class="card-body">
      <x-alert />

      <table class="table table-bordered datatable-buttons">
        <thead>
          <tr>
            <th>Title</th>
            <th>Period</th>
            <th>Images</th>
            <th>Published</th>
            <th width="140">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($projects as $project)
            @php
              $coverImage = $project->images->first();
            @endphp

            <tr>
              {{-- Title (localized) --}}
              <td>
                <strong>{{ $project->title }}</strong>
              </td>

              {{-- Period --}}
              <td>
                @if ($project->start_date || $project->end_date)
                  <small class="text-muted">
                    {{ $project->start_date ? $project->start_date->format('M d, Y') : '—' }}
                    →
                    {{ $project->end_date ? $project->end_date->format('M d, Y') : '—' }}
                  </small>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>

              {{-- Gallery preview (cover image) --}}
              <td class="align-middle text-center">
                <a href="{{ route('projects.images.index', $project) }}" class="btn btn-outline-primary btn-sm"
                  title="View project images">
                  <i class="uil uil-images"></i>
                </a>

                <div class="small text-muted mt-1">
                  {{ $project->images->count() }}
                  image{{ $project->images->count() === 1 ? '' : 's' }}
                </div>
              </td>

              {{-- Publish toggle --}}
              <td class="text-center">
                <form method="POST"
                  action="{{ route('admin.publish.toggle', [
                      'model' => 'projects',
                      'id' => $project->id,
                  ]) }}">
                  @csrf
                  @method('PATCH')

                  <button type="submit"
                    class="badge border-0 {{ $project->is_published ? 'bg-success' : 'bg-secondary' }}">
                    {{ $project->is_published ? __('Yes') : __('No') }}
                  </button>
                </form>
              </td>

              {{-- Actions --}}
              <td>
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-warning">
                  <i class="uil-pen"></i>
                </a>

                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete this project?')">
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
