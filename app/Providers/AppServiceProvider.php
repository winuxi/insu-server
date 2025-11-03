<?php

namespace App\Providers;

use BezhanSalleh\FilamentLanguageSwitch\Enums\Placement;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse;
use Laravel\Fortify\Events\TwoFactorAuthenticationChallenged;
use Laravel\Fortify\Events\TwoFactorAuthenticationEnabled;
use Vormkracht10\TwoFactorAuth\Http\Responses\LoginResponse;
use Vormkracht10\TwoFactorAuth\Listeners\SendTwoFactorCodeListener;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );

        $this->app->singleton(
            LogoutResponse::class,
            \App\Http\Responses\LogoutResponse::class
        );

        $this->app->extend(TwoFactorLoginResponse::class, function () {
            return new \App\Http\Responses\TwoFactorLoginResponse;
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        // Two factor (package)
        Event::listen([
            TwoFactorAuthenticationChallenged::class,
            TwoFactorAuthenticationEnabled::class,
        ], SendTwoFactorCodeListener::class);

        // language switcher (package)
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales([
                    'ar', // Arabic
                    'da', // Danish
                    'nl', // Dutch
                    'en', // English
                    'fr', // French
                    'de', // German
                    'it', // Italian
                    'ja', // Japanese
                    'pl', // Polish
                    'pt', // Portuguese
                    'ru', // Russian
                    'es', // Spanish
                ])
                ->flags([
                    'ar' => asset('images/flags/arabic.svg'),
                    'da' => asset('images/flags/danish.webp'),
                    'nl' => asset('images/flags/dutch.webp'),
                    'ja' => asset('images/flags/japanese.webp'),
                    'en' => asset('images/flags/english.png'),
                    'fr' => asset('images/flags/france.png'),
                    'de' => asset('images/flags/german.png'),
                    'es' => asset('images/flags/spain.png'),
                    'pt' => asset('images/flags/portuguese.png'),
                    'it' => asset('images/flags/italian.png'),
                    'ru' => asset('images/flags/russian.png'),
                    'pl' => asset('images/flags/polish.png'),
                ])
                ->outsidePanelPlacement(Placement::TopRight)
                ->visible(outsidePanels: true)
                ->outsidePanelRoutes([
                    'filament.admin.auth.login',
                    'filament.admin.auth.register',
                    'filament.admin.auth.password-reset',
                ]);
        });

        // set timezone
        Config::set('app.timezone', timezone());
        date_default_timezone_set(timezone());
        Date::setTestNow(Carbon::now(timezone()));
    }
}
