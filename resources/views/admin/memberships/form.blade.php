@extends('admin.layouts.master')

@section('title', isset($membership) ? 'Edit Membership' : 'Create Membership')

@section('content')
    <div class="card border border-primary">
        <div class="card-header">
            <h5>
                <i class="uil-heart"></i>
                {{ isset($membership) ? 'Edit Membership' : 'Create Membership' }}
            </h5>
        </div>

        <div class="card-body">
            <x-alert />

            {{-- Helper / Instructions --}}
            <div class="bg-info bg-opacity-10 text-info small p-3 rounded mb-4">
                <span class="text-primary fw-semibold">How memberships work:</span><br>
                • Donations are displayed publicly on the website.<br>
                • Titles and descriptions must be provided in <strong>English</strong> and <strong>Spanish</strong>.<br>
                • You may define a suggested amount (optional).<br>
                • Use the <span class="text-success">Publish switch</span> to control visibility.
            </div>

            <hr>

            <form method="POST"
                action="{{ isset($membership) ? route('memberships.update', $membership) : route('memberships.store') }}">
                @csrf
                @if (isset($membership))
                    @method('PUT')
                @endif

                {{-- Publish --}}
                <div class="form-check form-switch form-switch-lg mb-4">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published"
                        {{ old('is_published', $membership->is_published ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">
                        Publish this membership on the website
                    </label>
                </div>

                {{-- Title EN --}}
                <div class="mb-3">
                    <label class="form-label">Title (English)</label>
                    <input type="text" name="title_en" class="form-control"
                        value="{{ old('title_en', $membership->title_en ?? '') }}" required>
                </div>

                {{-- Title ES --}}
                <div class="mb-3">
                    <label class="form-label">Title (Spanish)</label>
                    <input type="text" name="title_es" class="form-control"
                        value="{{ old('title_es', $membership->title_es ?? '') }}" required>
                </div>

                <hr>

                {{-- Description EN --}}
                <div class="mb-3">
                    <label class="form-label">Description (English)</label>
                    <textarea class="form-control ckeditor" id="description_en" name="description_en" rows="4"
                        placeholder="Membership description in English...">{{ old('description_en', $membership->description_en ?? '') }}</textarea>
                </div>

                {{-- Description ES --}}
                <div class="mb-3">
                    <label class="form-label">Description (Spanish)</label>
                    <textarea class="form-control ckeditor" id="description_es" name="description_es" rows="4"
                        placeholder="Descripción de la donación en español...">{{ old('description_es', $membership->description_es ?? '') }}</textarea>
                </div>

                <hr>

                {{-- Suggested Amount --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Suggested Amount</label>
                        <input type="number" step="0.01" name="amount" class="form-control"
                            value="{{ old('amount', $membership->amount ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Currency</label>
                        <input type="text" name="currency" class="form-control"
                            value="{{ old('currency', $membership->currency ?? 'USD') }}">
                    </div>
                </div>

                <hr>

                {{-- Image manager --}}
                @if (isset($membership))
                    <div class="mb-4">
                        <label class="form-label">Membership Image</label><br>

                        <a href="{{ route('admin.images.edit', ['model' => 'memberships', 'id' => $membership->id]) }}"
                            class="btn btn-outline-primary btn-sm">
                            <i class="uil-image"></i> Upload / Change Image
                        </a>

                        @if ($membership->image_url)
                            <a href="{{ route('admin.images.preview', ['model' => 'memberships', 'id' => $membership->id]) }}"
                                target="_blank" class="btn btn-outline-secondary btn-sm ms-2">
                                <i class="uil-eye"></i> Preview
                            </a>
                        @endif
                    </div>
                @else
                    <div class="alert alert-warning small">
                        Image upload will be available after creating the membership.
                    </div>
                @endif

                <hr>

                {{-- Actions --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('memberships.index') }}" class="btn btn-secondary">
                        <i class="uil-arrow-left"></i> Back
                    </a>

                    <button type="submit" class="btn btn-primary">
                        <i class="uil-save"></i>
                        {{ isset($membership) ? 'Update Membership' : 'Create Membership' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
