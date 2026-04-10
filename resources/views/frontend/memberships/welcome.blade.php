@extends('frontend.layouts.app')

@section('title', __('pages.memberships') . ' | Passion2Plant')

@section('content')
    @extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <section class="pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="card shadow-sm border-0 text-center p-4">

                        {{-- ✅ Success Icon --}}
                        <div class="mb-4">
                            <i class="fa-solid fa-circle-check text-success" style="font-size: 60px;"></i>
                        </div>

                        {{-- ✅ Title --}}
                        <h2 class="mb-3">
                            Welcome, {{ $application->first_name ?? 'Member' }}!
                        </h2>

                        {{-- ✅ Message --}}
                        <p class="mb-4 text-muted">
                            Thank you for becoming part of our community.
                            Your membership has been successfully started.
                        </p>

                        {{-- ✅ Details --}}
                        <div class="mb-4 text-start">

                            <p class="mb-1">
                                <strong>Email:</strong>
                                {{ $application->email }}
                            </p>

                            @if (!empty($application->amount))
                                <p class="mb-1">
                                    <strong>Contribution:</strong>
                                    ${{ number_format($application->amount, 2) }}
                                    / {{ $application->interval === 'annual' ? 'year' : 'month' }}
                                </p>
                            @endif

                        </div>

                        {{-- ✅ CTA --}}
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="{{ url('/') }}" class="btn btn-success">
                                Go to Home
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@endsection
