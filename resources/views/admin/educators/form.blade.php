@extends('admin.layouts.master')

@section('title', isset($educator) ? 'Edit Educator' : 'Create Educator')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="fas fa-handshake"></i>
                {{ isset($educator) ? 'Edit Educator' : 'Create Educator' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper block --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How to manage logo educators:</span><br>
                • Add a <span class="text-dark"> name</span> for internal reference (optional).<br>
                • Upload the <span class="text-dark"> logo</span> using the image icon on the list page.<br>
                • Provide an <span class="text-dark">external link</span> to redirect users to the partner’s website.<br>
                • Use the <span class="text-success">Publish switch</span> to control visibility on the public site.
            </div>

            <hr />

            <form method="POST"
                action="{{ isset($educator) ? route('educators.update', $educator) : route('educators.store') }}">
                @csrf
                @isset($educator)
                    @method('PUT')
                @endisset

                {{-- =======================
                Publish Controls
                ======================== --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $educator->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this on the website
                    </label>
                </div>

                <hr>

                {{-- =======================
                Educator Name
                ======================== --}}
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Educator name (optional)"
                        value="{{ old('name', $educator->name ?? '') }}">
                    <small class="text-muted">
                        Used for internal identification only.
                    </small>
                </div>

                {{-- =======================
                External Link
                ======================== --}}
                <div class="mb-3">
                    <input type="url" name="external_link" class="form-control" placeholder="https://-website.com"
                        value="{{ old('external_link', $educator->external_link ?? '') }}">
                    <small class="text-muted">
                        Users will be redirected to this link when clicking the logo.
                    </small>
                </div>

                <hr>

                {{-- =======================
                Actions
                ======================== --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('educators.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($educator) ? 'Update Educator' : 'Create Educator' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
