@extends('admin.layouts.master')

@section('title', 'Menus')

@section('content')

    <div class="card border border-primary">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="uil uil-bars"></i> Menu Manager
            </h5>

            <a href="{{ route('menus.create') }}" class="btn btn-primary btn-sm">
                <i class="uil uil-plus"></i> Add Menu
            </a>
        </div>

        <div class="card-body">

            <x-alert />

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th>Title EN</th>
                            <th>Title ES</th>
                            <th>Link</th>
                            <th width="80">Order</th>
                            <th width="140">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($menus as $menu)
                            {{-- Main Menu --}}
                            <tr class="table-primary">
                                <td>{{ $menu->id }}</td>

                                <td>
                                    <strong>{{ $menu->title_en }}</strong>
                                </td>

                                <td>{{ $menu->title_es }}</td>

                                <td>{{ $menu->link }}</td>

                                <td>{{ $menu->order }}</td>

                                <td class="text-center">

                                    <a href="{{ route('menus.edit', $menu) }}" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('menus.destroy', $menu) }}" method="POST"
                                        style="display:inline-block" onsubmit="return confirm('Delete this menu?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>

                                    </form>

                                </td>
                            </tr>

                            {{-- Submenus --}}
                            @foreach ($menu->children as $child)
                                <tr>
                                    <td>{{ $child->id }}</td>

                                    <td>
                                        <span class="ms-4 text-muted">
                                            └ {{ $child->title_en }}
                                        </span>
                                    </td>

                                    <td>{{ $child->title_es }}</td>

                                    <td>{{ $child->link }}</td>

                                    <td>{{ $child->order }}</td>

                                    <td class="text-center">

                                        <a href="{{ route('menus.edit', $child) }}" class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('menus.destroy', $child) }}" method="POST"
                                            style="display:inline-block" onsubmit="return confirm('Delete this menu?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-danger">
                                                Delete
                                            </button>

                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
