<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\CreateSessionCheckoutRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Illuminate\Support\Facades\Log;

class GuestCheckoutController extends Controller
{
    /**
     * Handle the request to create a checkout session.
     */
    public function create(CreateSessionCheckoutRequest $request): Response|RedirectResponse
    {
        Log::info('Creating checkout session');

        $data = $request->validated();
        $userData = $data['user'];
        $settingsData = $data['settings'];

        try {
            $user = User::create([
                ...$userData,
                'password' => Hash::make('password'),
                'quotes_used' => 0,
                'quotes_limit' => 100,
            ]);

            $user->settings()->create($settingsData);

            Log::info('User created', ['user' => $user]);
        } catch (Exception $e) {
            Log::error('Failed to create user', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to create user');
        }

        try {
            $subscription = $user->newSubscription('default', 'price_1RVk3kCsDGyYZtWskJypkyu3')
                ->checkout([
                    'client_reference_id' => $user->id,
                    'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('landing'),
                ]);

            Log::info('Subscription created', ['subscription' => $subscription]);

            return Inertia::location($subscription->url);
        } catch (Exception $e) {
            $user->delete();

            Log::error('Failed to create subscription', ['error' => $e->getMessage(), 'user' => $user]);

            return redirect()->back()->with('error', 'Failed to create checkout session');
        }
    }

    public function success(Request $request): InertiaResponse
    {
        $request->validate([
            'session_id' => 'required|string',
        ]);

        Stripe::setApiKey(config('cashier.secret'));

        $session = Session::retrieve($request->get('session_id'));

        $user = User::findOrFail($session->client_reference_id);

        return Inertia::render('Public/Onboarding/Checkout/Success', [
            'planType' => 'starter',
            'businessName' => $user->settings->business_name ?? '',
            'firstName' => $user->first_name,
            'phoneNumber' => $user->settings->agent_sms_number ?? '',
        ]);
    }
} 