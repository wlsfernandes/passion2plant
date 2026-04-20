@extends('frontend.layouts.app')

@section('title', __('pages.memberships') . ' | Passion2Plant')

@section('content')
    <!-- Membership Information Section -->
    <div class="contact__info__section pt-130 pb-130 section__bg overhid">

        <div class="container">

            <x-alert />
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="p-4 p-md-5 bg-white rounded-4 shadow-sm">

                        {{-- Membership Title --}}
                        <div class="text-center mb-4">
                            <h3 class="fw-bold">
                                {{ html_entity_decode(strip_tags($membership->title)) }}
                            </h3>
                        </div>

                        <form action="{{ route('memberships.startCheckout', $membership) }}" method="POST">
                            @csrf

                            {{-- Honeypot --}}
                            <input type="text" name="website" style="display:none">

                            <div class="row g-4">

                                {{-- Amount (readonly) --}}
                                <div class="col-12 d-flex justify-content-center">
                                    <div class="alert alert-info text-center p-4" style="max-width: 420px; width: 100%;">

                                        <div class="mb-3">
                                            <i class="fa-solid fa-info-circle me-2"></i>
                                            <strong>Annual Billing</strong>
                                        </div>

                                        <div class="mb-3">
                                            You will be charged <strong>once per year</strong>.<br>
                                            <span class="text-muted">No monthly charges.</span>
                                        </div>

                                        <div class="mb-2">
                                            <input type="text" class="form-control form-control-lg text-center fw-bold"
                                                value="${{ number_format($membership->amount, 2) }} / year" readonly>
                                        </div>

                                        <small class="text-muted">
                                            <i class="fa-solid fa-lock me-2"></i> Secure payment
                                        </small>

                                        <input type="hidden" name="amount" value="{{ $membership->amount }}">
                                        <input type="hidden" name="interval" value="annual">

                                    </div>
                                </div>
                                {{-- Interval Monthly and Annual Billing Type - This section is commented out as the interval is now normalized to 'annual' by default in the NormalizerData service. If you want to allow users to choose between monthly and annual billing, you can uncomment this section and ensure that the 'interval' field is properly handled in the backend. --}}
                                {{--
                                <div class="col-6">
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="interval" id="monthly"
                                                value="monthly"
                                                {{ old('interval', 'monthly') === 'monthly' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="monthly">
                                                Monthly
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="interval" id="annual"
                                                value="annual" {{ old('interval') === 'annual' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="annual">
                                                Annual
                                            </label>
                                        </div>

                                    </div>
                                </div> --}}

                                {{-- First Name --}}
                                <div class="col-md-6">
                                    <input type="text" name="first_name" class="form-control form-control-lg"
                                        placeholder="First Name" value="{{ old('first_name') }}" required>
                                </div>

                                {{-- Last Name --}}
                                <div class="col-md-6">
                                    <input type="text" name="last_name" class="form-control form-control-lg"
                                        placeholder="Last Name" value="{{ old('last_name') }}" required>
                                </div>

                                {{-- Email --}}
                                <div class="col-12">
                                    <input type="email" name="email" class="form-control form-control-lg"
                                        placeholder="Email" value="{{ old('email') }}" required>
                                </div>

                                {{-- Phone --}}
                                <div class="col-12">
                                    <input type="text" name="phone" class="form-control form-control-lg"
                                        placeholder="Phone" value="{{ old('phone') }}">
                                </div>

                                {{-- Address --}}
                                <div class="col-12">
                                    <input type="text" name="address" class="form-control form-control-lg"
                                        placeholder="Address" value="{{ old('address') }}">
                                </div>

                                {{-- City --}}
                                <div class="col-md-6">
                                    <input type="text" name="city" class="form-control form-control-lg"
                                        placeholder="City" value="{{ old('city') }}">
                                </div>

                                {{-- State --}}
                                <div class="col-md-6">
                                    <input type="text" name="state" class="form-control form-control-lg"
                                        placeholder="State" value="{{ old('state') }}">
                                </div>

                                {{-- Postal Code --}}
                                <div class="col-md-6">
                                    <input type="text" name="postal_code" class="form-control form-control-lg"
                                        placeholder="Postal Code" value="{{ old('postal_code') }}">
                                </div>

                                {{-- Country --}}
                                <div class="col-md-6">
                                    <input type="text" name="country" class="form-control form-control-lg"
                                        placeholder="Country" value="{{ old('country') }}">
                                </div>

                                {{-- Button --}}
                                <div class="col-12 text-center mt-4">
                                    <button type="submit" class="cmn--btn">
                                        <i class="fa-solid fa-credit-card me-2"></i>
                                        Continue to Payment
                                    </button>
                                </div>

                            </div>
                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- Membership Information Section End -->
@endsection
