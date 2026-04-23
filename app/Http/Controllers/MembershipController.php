<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use App\Models\MembershipApplication;
use App\Services\Membership\MembershipApplicationUpdater;
use App\Services\Membership\NewMembershipApplication;
use App\Services\Membership\NormalizerData;
use App\Services\SystemLogger;
use Exception;
use Illuminate\Http\Request;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Price;
use Stripe\Product;
use Stripe\Stripe;

class MembershipController extends BaseController
{
    /**
     * Show membership information page
     */
    public function information(Membership $membership)
    {
        return view('frontend.memberships.information', compact('membership'));
    }

    public function welcomeMember(Request $request)
    {

        $sessionId = $request->get('session_id');

        $application = MembershipApplication::where(
            'checkout_session_id',
            $sessionId
        )->first();
        if (! $application) {
            return redirect()->url('/')->with('error', 'Session not found.');
        }

        return view('frontend.memberships.welcome', [
            'application' => $application,
            'member' => $application->member,
        ]);
    }

    /* redirect to stripewebhookController */
    public function startCheckout(Request $request, Membership $membership)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric|min:0',
            'interval' => 'required|in:monthly,annual',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'interval' => 'required|in:monthly,annual',
        ]);

        $data = NormalizerData::normalizeMembershipInput($request);

        $application = NewMembershipApplication::create($data);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $product = Product::create([
                'name' => 'Annual Membership',
                'description' => 'This is a yearly payment. You will not be charged monthly.',
            ]);

            $price = Price::create([
                'unit_amount' => (int) round($data['amount'] * 100),
                'currency' => 'usd',
                'recurring' => [
                    'interval' => $data['interval'],
                ],
                'product' => $product->id,
            ]);

            $session = CheckoutSession::create([
                'mode' => 'subscription',
                'line_items' => [
                    [
                        'price' => $price->id,
                        'quantity' => 1,
                    ],
                ],
                'customer_email' => $data['email'],
                'subscription_data' => [
                    'metadata' => [
                        'type' => 'membership',
                        'application_id' => $application->id,
                        'interval' => 'annual',
                    ],
                ],
                'metadata' => [
                        'type' => 'membership',
                        'application_id' => $application->id,
                        'interval' => 'annual',
                    ],
                    
                'success_url' => route('welcome-member').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => url()->previous(),
            ]);
        } catch (\Exception $e) {
            SystemLogger::log(
                'membership checkout failed',
                'error',
                'membership.checkout',
                ['error' => $e->getMessage()]
            );

            return back()->with('error', 'Unable to start checkout.');
        }

        MembershipApplicationUpdater::markAsStarted(
            $application,
            $session->id
        );

        return redirect()->away($session->url);
    }

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

            'amount' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],

            'image_url' => ['nullable', 'string'],

            'is_published' => ['required', 'boolean'],
        ]);
    }

    /**
     * Display a listing of memberships.
     */
    public function index()
    {
        $memberships = Membership::orderBy('id')->get();

        return view('admin.memberships.index', compact('memberships'));
    }

    public function indexPublic()
    {
        $memberships = Membership::where('is_published', true)
            ->orderBy('id')
            ->get();

        return view('frontend.memberships.index', compact('memberships'));
    }

    /**
     * Show the checkout page for a specific membership.
     */
    public function checkout(Request $request, Membership $membership)
    {
        return view('frontend.memberships.checkout', [
            'membership' => $membership,
            'amount' => $request->get('amount', $membership->amount),
        ]);
    }

    /**
     * Show the form for creating a new membership.
     */
    public function create()
    {
        return view('admin.memberships.form');
    }

    /**
     * Store a newly created membership.
     */
    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        try {
            $membership = Membership::create($data);

            SystemLogger::log(
                'Membership created',
                'info',
                'memberships.store',
                [
                    'membership_id' => $membership->id,
                    'title' => $membership->title,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('memberships.index')
                ->with('success', 'Membership created successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Membership creation failed',
                'error',
                'memberships.store',
                [
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to create membership.');
        }
    }

    /**
     * Show the form for editing the specified membership.
     */
    public function edit(Membership $membership)
    {
        return view('admin.memberships.form', compact('membership'));
    }

    /**
     * Update the specified membership.
     */
    public function update(Request $request, Membership $membership)
    {
        $data = $this->validatedData($request);

        try {
            $membership->update($data);

            SystemLogger::log(
                'Membership updated',
                'info',
                'memberships.update',
                [
                    'membership_id' => $membership->id,
                    'title' => $membership->title,
                    'email' => $request->email,
                ]
            );

            return redirect()
                ->route('memberships.index')
                ->with('success', 'Membership updated successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Membership update failed',
                'error',
                'memberships.update',
                [
                    'membership_id' => $membership->id,
                    'exception' => $e->getMessage(),
                    'email' => $request->email,
                ]
            );

            return back()
                ->withInput()
                ->with('error', 'Failed to update membership.');
        }
    }

    /**
     * Remove the specified membership.
     */
    public function destroy(Membership $membership)
    {
        try {
            // Cleanup image if exists

            $membership->delete();

            SystemLogger::log(
                'Membership deleted',
                'warning',
                'memberships.delete',
                [
                    'membership_id' => $membership->id,
                    'email' => request()->email,
                ]
            );

            return redirect()
                ->route('memberships.index')
                ->with('success', 'Membership deleted successfully.');

        } catch (Exception $e) {
            SystemLogger::log(
                'Membership deletion failed',
                'error',
                'memberships.delete',
                [
                    'membership_id' => $membership->id,
                    'exception' => $e->getMessage(),
                    'email' => request()->email,
                ]
            );

            return back()
                ->with('error', 'Failed to delete membership.');
        }
    }
}
