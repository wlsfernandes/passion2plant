@extends('admin.layouts.master')

@section('title', 'Members')

@section('css')
    <link href="{{ asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card border border-primary">

        {{-- HEADER --}}
        <div class="card-header d-flex justify-content-between">
            <h5>
                <i class="uil-users-alt"></i> Members
            </h5>

        </div>

        {{-- BODY --}}
        <div class="card-body">
            <x-alert />

            <table class="table table-bordered datatable-buttons">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Membership</th>
                        <th>Status</th>
                        <th>Recurring</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($members as $member)
                        <tr>

                            {{-- Avatar / Placeholder --}}
                            <td class="text-center">
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                    style="width:60px;height:60px;">
                                    <i class="uil uil-user text-muted font-size-20"></i>
                                </div>
                            </td>

                            {{-- Name --}}
                            <td>
                                <strong>
                                    {{ $member->first_name }} {{ $member->last_name }}
                                </strong>
                                <br>
                                <small class="text-muted">
                                    {{ $member->city ?? '' }} {{ $member->state ?? '' }}
                                </small>
                            </td>

                            {{-- Email --}}
                            <td>
                                {{ $member->email }}
                            </td>

                            {{-- Membership Period --}}
                            <td>
                                <small>
                                    Start:
                                    {{ $member->membership_start_date ? \Carbon\Carbon::parse($member->membership_start_date)->format('M d, Y') : '-' }}
                                    <br>
                                    End:
                                    {{ $member->membership_end_date ? \Carbon\Carbon::parse($member->membership_end_date)->format('M d, Y') : '-' }}
                                </small>
                            </td>

                            {{-- Active Status --}}
                            <td class="text-center">


                                <button type="submit"
                                    class="badge border-0 {{ $member->active_status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $member->active_status ? 'Active' : 'Inactive' }}
                                </button>
                            </td>

                            {{-- Recurring --}}
                            <td class="text-center">
                                <span class="badge {{ $member->is_recurring ? 'bg-info' : 'bg-light text-dark' }}">
                                    {{ $member->is_recurring ? 'Yes' : 'No' }}
                                </span>
                            </td>

                            {{-- Actions --}}


                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
