<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use App\Services\SystemLogger;
use App\Helpers\S3;
use Exception;

class DonationController extends BaseController
{
    /**
     * Validation rules
     * (Project standard: before store/update)
     */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'title_en' => ['required', 'string', 'max:255'],
            'title_es' => ['required', 'string', 'max:255'],

            'description_en' => ['nullable', 'string'],
            'description_es' => ['nullable', 'string'],

            'suggested_amount' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],

            'image_url' => ['nullable', 'string'],

            'is_published' => ['required', 'boolean'],
        ]);
    }

    /**
     * Display a listing of donations.
     */
    public function index()
    {
        $donations = Donation::orderBy('id')->get();

        return view('admin.donations.index', compact('donations'));
    }

    /**
     * Show the form for creating a new donation.
     */
    public function create()
    {
        return view('admin.donations.form');
    }

    /**
     * Store a newly created donation.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        try {
            $donation = Donation::create($data);

            SystemLogger::log(
                'Donation created',
                'info',
                'donations.store',
                [
                    'donation_id' => $donation->id,
                    'title' => $donation->title,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('donations.index')
                ->with('success', 'Donation created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Donation creation failed',
                'error',
                'donations.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create donation.');
        }
    }

    /**
     * Show the form for editing the specified donation.
     */
    public function edit(Donation $donation)
    {
        return view('admin.donations.form', compact('donation'));
    }

    /**
     * Update the specified donation.
     */
    public function update(Request $request, Donation $donation)
    {
        $data = $this->validatedData($request);

        try {
            $donation->update($data);

            SystemLogger::log(
                'Donation updated',
                'info',
                'donations.update',
                [
                    'donation_id' => $donation->id,
                    'title' => $donation->title,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('donations.index')
                ->with('success', 'Donation updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Donation update failed',
                'error',
                'donations.update',
                [
                    'donation_id' => $donation->id,
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update donation.');
        }
    }

    /**
     * Remove the specified donation.
     */
    public function destroy(Donation $donation)
    {
        try {
            // Cleanup image if exists
            if (!empty($donation->image_url)) {
                S3::delete($donation->image_url);
            }

            $donation->delete();

            SystemLogger::log(
                'Donation deleted',
                'warning',
                'donations.delete',
                [
                    'donation_id' => $donation->id,
                    'email' => request()->email,
                ]
            );

            return redirect()
                ->route('donations.index')
                ->with('success', 'Donation deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Donation deletion failed',
                'error',
                'donations.delete',
                [
                    'donation_id' => $donation->id,
                    'exception' => $e->getMessage(),
                    'email' => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete donation.');
        }
    }
}
