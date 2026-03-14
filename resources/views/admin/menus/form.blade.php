@extends('admin.layouts.master')

@section('title', isset($menu->id) ? 'Edit Menu Item' : 'Create Menu Item')

@section('content')

    <div class="card border border-primary">

        <div class="card-header">
            <h5 class="mb-0">
                <i class="uil uil-bars"></i>
                {{ isset($menu->id) ? 'Edit Menu Item' : 'Create Menu Item' }}
            </h5>
        </div>

        <div class="card-body">

            <x-alert />

            <form method="POST" action="{{ isset($menu->id) ? route('menus.update', $menu) : route('menus.store') }}">

                @csrf

                @if (isset($menu->id))
                    @method('PUT')
                @endif

                <div class="row">

                    {{-- Title EN --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Title (English) <span class="text-danger">*</span>
                        </label>

                        <input type="text" name="title_en" class="form-control"
                            value="{{ old('title_en', $menu->title_en) }}" required>
                    </div>


                    {{-- Title ES --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Title (Spanish)
                        </label>

                        <input type="text" name="title_es" class="form-control"
                            value="{{ old('title_es', $menu->title_es) }}">
                    </div>


                    {{-- Link --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Link / URL
                        </label>

                        <input type="text" name="link" class="form-control"
                            placeholder="/about-us or https://example.com" value="{{ old('link', $menu->link) }}">
                    </div>


                    {{-- Order --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">
                            Order
                        </label>

                        <input type="number" name="order" class="form-control"
                            value="{{ old('order', $menu->order ?? 0) }}">
                    </div>


                    {{-- Parent Menu --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">
                            Parent Menu
                        </label>

                        <select name="parent_id" class="form-select">

                            <option value="">
                                Main Menu
                            </option>

                            @foreach ($parents as $id => $title)
                                <option value="{{ $id }}"
                                    {{ old('parent_id', $menu->parent_id) == $id ? 'selected' : '' }}>
                                    {{ $title }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                </div>


                {{-- Buttons --}}
                <div class="mt-3">

                    <button type="submit" class="btn btn-primary">

                        {{ isset($menu->id) ? 'Update Menu' : 'Create Menu' }}

                    </button>

                    <a href="{{ route('menus.index') }}" class="btn btn-secondary">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

@endsection
