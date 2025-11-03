<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user() && ! Auth::user()->hasRole(User::ADMIN)) {
            return $next($request);
        }
        $allowedRoutes = [
            'filament.admin.pages.subscription',
            'filament.admin.pages.payment-gateway',
            'filament.admin.auth.login',
            'filament.admin.auth.logout',
            'filament.admin.pages.dashboard',
            'filament.admin.auth.profile',
            'filament.admin.auth.register',
            'filament.admin.auth.password-reset.reset',
            'filament.admin.auth.password-reset.request',
        ];

        if (in_array(Route::currentRouteName(), $allowedRoutes)) {
            return $next($request);
        }

        $subscription = Subscription::with('plan')->where('is_active', Subscription::ACTIVE)
            ->where('user_id', Auth::id())
            ->first();

        if (! $subscription) {
            notify(__('Choose a plan to continue'), 'warning');

            return redirect()->route('filament.admin.pages.subscription');
        }

        if ($subscription->isExpired()) {
            notify(__('Your subscription has expired please renew it'), 'warning');

            return redirect()->route('filament.admin.pages.subscription');
        }

        return $next($request);
    }
}
