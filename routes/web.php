<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware('locale')->get('/', [HomeController::class, 'index'])->name('home');

Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');

Route::get('/terms-conditions', [HomeController::class, 'termsAndConditions'])->name('terms.conditions');

Route::get('/to-payment/{plan}', [HomeController::class, 'redirectToPayment'])->name('to.payment');

Route::get('/auth', function () {
    if (! auth()->check()) {
        return redirect()->route('filament.admin.auth.login');
    }
    if (auth()->user()->hasRole(User::SUPER_ADMIN)) {
        return redirect()->route('filament.super-admin.pages.dashboard');
    } elseif (auth()->user()->hasRole(User::ADMIN)) {
        return redirect()->route('filament.admin.pages.dashboard');
    } elseif (auth()->user()->hasRole(User::AGENT)) {
        return redirect()->route('filament.agent.pages.dashboard');
    } elseif (auth()->user()->hasRole(User::CUSTOMER)) {
        return redirect()->route('filament.customer.pages.dashboard');
    }
})->name('auth');

Route::middleware('auth', 'role:admin')->group(function () {

    Route::get('insurance-pdf/{id}', function ($id) {
        $record = App\Models\Insurance::find($id);
        $pdf = Barryvdh\DomPDF\Facade\Pdf::loadView('pdfs.insurance', ['insurance' => $record]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, insuranceCustomerPrefix($record->id).'.pdf');
    })->name('insurance.pdf');

    Route::get('claim-pdf/{id}', function ($id) {
        $record = App\Models\Claim::find($id);
        $pdf = Barryvdh\DomPDF\Facade\Pdf::loadView('pdfs.claim', ['claim' => $record]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $record->claim_number.'.pdf');
    })->name('claim.pdf');

    Route::get('stripe/success', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');

    Route::get('stripe/failed', [PaymentController::class, 'stripeFailed'])->name('stripe.failed');

    Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');

    Route::get('paypal/failed', [PaymentController::class, 'paypalFailed'])->name('paypal.failed');
});
require __DIR__.'/auth.php';
