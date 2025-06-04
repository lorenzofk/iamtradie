<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class BillingController extends Controller
{
    /**
     * Display the billing page with real subscription and invoice data.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();
        $subscription = $user->subscription();

        $subscriptionData = null;

        if ($subscription) {
            $stripeSub = $subscription->asStripeSubscription();
            $item = $stripeSub->items->data[0] ?? null;
            $plan = $item->price ?? null;

            $subscriptionData = [
                'status' => $subscription->stripe_status,
                'canceled_at' => $stripeSub->cancel_at,
                'cancel_at_period_end' => $stripeSub->cancel_at_period_end,
                'current_period_end' => isset($stripeSub->current_period_end)
                    ? date('Y-m-d', $stripeSub->current_period_end)
                    : null,
                'plan' => [
                    'nickname' => $plan->nickname,  
                    'amount' => $plan->unit_amount,
                    'interval' => $plan->recurring->interval,
                ],
            ];
        }

        // Get invoices
        $invoices = collect($user->invoices())->map(function ($invoice) {
            return [
                'id' => $invoice->id,
                'amount_paid' => $invoice->amount_paid,
                'status' => $invoice->status,
                'created' => date('Y-m-d', $invoice->created),
                'hosted_invoice_url' => $invoice->hosted_invoice_url,
                'invoice_pdf' => $invoice->invoice_pdf,
            ];
        })->toArray();

        return Inertia::render('Billing/index', [
            'subscription' => $subscriptionData,
            'invoices' => $invoices,
        ]);
    }

    /**
     * Cancel the user's subscription at period end.
     */
    public function cancel(Request $request): RedirectResponse
    {
        $user = $request->user();
        $subscription = $user->subscription();

        if ($subscription && $subscription->active() && !$subscription->canceled()) {
            $subscription->cancel();
        }

        return back();
    }

    /**
     * Resume a cancelled subscription.
     */
    public function resume(Request $request): RedirectResponse
    {
        $user = $request->user();
        $subscription = $user->subscription();

        if ($subscription && $subscription->onGracePeriod()) {
            $subscription->resume();
        }

        return back();
    }

    /**
     * Redirect to the Stripe billing portal.
     */
    public function manage(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        return $user->redirectToBillingPortal(route('billing.index'));
    }

    /**
     * Subscribe the user to the pro plan (example, adjust price id as needed).
     */
    public function subscription(Request $request): RedirectResponse
    {
        $user = $request->user();
        $priceId = 'price_1RVk3kCsDGyYZtWskJypkyu3';

        $checkout = $user->newSubscription('default', $priceId)
            ->checkout([
                'client_reference_id' => $user->id,
                'success_url' => route('billing.index'),
                'cancel_url' => route('billing.index'),
            ]);

        return redirect()->away($checkout->url);
    }
}