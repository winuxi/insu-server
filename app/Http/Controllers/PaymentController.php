<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function stripeSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
        $stripeKey = stripeCredentials()['secret'];
        Stripe::setApiKey($stripeKey);
        $sessionData = Session::retrieve($sessionId);

        if ($sessionData->status == 'complete') {
            $userId = $sessionData->metadata->user_id;
            $planId = $sessionData->metadata->plan_id;
            $plan = Plan::find($planId);

            Subscription::where('user_id', $userId)->where('is_active', Subscription::ACTIVE)->update(['is_active' => Subscription::INACTIVE]);

            Subscription::create([
                'user_id' => $userId,
                'plan_id' => $planId,
                'amount' => $plan->amount,
                'payment_method' => 'stripe',
                'transaction_id' => $sessionData->payment_intent,
                'payment_status' => Subscription::PAID,
                'is_active' => Subscription::ACTIVE,
                'tenant_id' => auth()->user()->tenant_id,
                'meta' => json_encode($sessionData->metadata),
                'start_date' => now(),
                'end_date' => $plan['interval'] == 1 ? now()->addMonths(1) : now()->addYears(1),
            ]);

            notify('Stripe Payment successful!', 'success');

            return redirect()->route('filament.admin.pages.subscription');
        } else {
            notify('Something went wrong!', 'danger');

            return redirect()->route('filament.admin.pages.subscription');
        }
    }

    public function stripeFailed()
    {
        notify('Stripe Payment failed!', 'danger');

        return redirect()->route('filament.admin.pages.subscription');
    }

    public function paypalSuccess(Request $request)
    {
        $requests = $request->all();
        $token = $requests['token'];
        $input = array_merge($requests, session('paypal_input'));

        Subscription::where('user_id', auth()->id())->where('is_active', Subscription::ACTIVE)->update(['is_active' => Subscription::INACTIVE]);

        Subscription::create([
            'user_id' => auth()->id(),
            'plan_id' => $input['id'],
            'amount' => $input['amount'],
            'payment_method' => 'paypal',
            'transaction_id' => $token,
            'payment_status' => Subscription::PAID,
            'is_active' => Subscription::ACTIVE,
            'tenant_id' => auth()->user()->tenant_id,
            'meta' => json_encode($input) ?? null,
            'start_date' => now(),
            'end_date' => $input['interval'] == 1 ? now()->addMonths(1) : now()->addYears(1),
        ]);

        notify('PayPal Payment successful!', 'success');

        return redirect()->route('filament.admin.pages.subscription');
    }

    public function paypalFailed()
    {
        notify('PayPal Payment failed!', 'danger');
    }
}
