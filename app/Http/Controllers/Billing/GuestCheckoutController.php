<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class GuestCheckoutController extends Controller
{
    /**
     * Handle the request to create a checkout session.
     */
    public function create(Request $request): Response|RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'plan' => 'required|string',
        ]);

        Stripe::setApiKey(config('cashier.secret'));

        $user = User::find(1);

        $user->newSubscription('default', 'price_basic_monthly')
            ->checkout(
                [
                    'cancel_url' => route('landing'),
                    'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
                 ]
            );

        $session = Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [[
                'price' => 'price_1RVk3kCsDGyYZtWskJypkyu3',
                'quantity' => 1,
            ]],
            'customer_email' => $request->email,
            'cancel_url' => route('landing'),
            'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
        ]);

        return Inertia::location($session->url);
    }

    public function success(Request $request): InertiaResponse
    {
        $request->validate([
            'session_id' => 'required|string',
        ]);

        Stripe::setApiKey(config('cashier.secret'));

        $session = Session::retrieve(request('session_id'));

        $user = User::find(1);

        return Inertia::render('Public/Onboarding/Checkout/Success', [
            'planType' => 'starter',
            'businessName' => 'Test Business',
            'firstName' => $user->first_name,
            'phoneNumber' => '0400000000',
        ]);
    }
} 