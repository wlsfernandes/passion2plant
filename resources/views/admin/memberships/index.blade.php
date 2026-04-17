@extends('admin.layouts.master')

@section('title', 'Memberships')

@section('content')
    <div class="card border border-primary">
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="uil-heart"></i> Memberships
            </h5>
            <a href="{{ route('memberships.create') }}" class="btn btn-success">
                <i class="uil-plus"></i> Add Membership
            </a>
        </div>

        <div class="card-body">
            <x-alert />

            <table class="table table-bordered datatable-buttons">
                <thead>
                    <tr>
                        <th></th>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Published</th>
                        <th width="140">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($memberships as $membership)
                        <tr>
                            <td class="d-flex justify-content-center align-items-center">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    @if ($membership->image_url)
                                        <a href="{{ route('admin.images.preview', ['model' => 'memberships', 'id' => $membership->id]) }}"
                                            target="_blank" title="View image">
                                            <img src="{{ route('admin.images.preview', ['model' => 'memberships', 'id' => $membership->id]) }}"
                                                alt="Membership image" class="rounded-circle mb-1"
                                                style="width:80px;height:80px;object-fit:cover;">
                                        </a>
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-1"
                                            style="width:80px;height:80px;">
                                            <i class="uil uil-image text-muted font-size-24"></i>
                                        </div>
                                    @endif
                                    {{-- Edit / Upload action --}}
                                    <a href="{{ route('admin.images.edit', ['model' => 'memberships', 'id' => $membership->id]) }}"
                                        class="text-primary small" title="Upload / Change image">
                                        <i class="uil uil-edit"></i> Edit
                                    </a>
                                </div>
                            </td>
                            {{-- Title (auto-localized via model accessor) --}}
                            <td>
                                <strong>{{ $membership->title }}</strong>
                            </td>

                            {{-- Suggested Amount --}}
                            <td>
                                @if ($membership->amount)
                                    {{ number_format($membership->amount, 2) }}
                                    <small class="text-muted">{{ $membership->currency }}</small>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>




                            {{-- Publish toggle --}}
                            <td class="text-center">
                                <form method="POST"
                                    action="{{ route('admin.publish.toggle', [
                                        'model' => Str::snake(class_basename($membership)),
                                        'id' => $membership->id,
                                    ]) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="badge border-0 {{ $membership->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $membership->is_published ? __('Yes') : __('No') }}
                                    </button>
                                </form>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <a href="{{ route('memberships.edit', $membership) }}" class="btn btn-sm btn-warning">
                                    <i class="uil-pen"></i>
                                </a>

                                <form action="{{ route('memberships.destroy', $membership) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Delete this membership?')">
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
