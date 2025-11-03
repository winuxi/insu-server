<?php

namespace App\Providers\Filament;

use App\Filament\Resources\ClaimResource;
use App\Filament\Resources\InsuranceResource;
use App\Filament\Resources\PaymentResource;
use App\Filament\Widgets\PaymentChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Spatie\Permission\Middleware\RoleMiddleware;
use Vormkracht10\TwoFactorAuth\TwoFactorAuthPlugin;

class CustomerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('customer')
            ->path('customer')
            ->spa()
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn () => Auth::user()?->name)
                    ->icon(fn () => Auth::user()?->profile),
            ])
            ->favicon(appFavicon())
            ->brandName(appNameByAdmin())
            ->renderHook(PanelsRenderHook::GLOBAL_SEARCH_AFTER, fn () => view('layout.theme-settings'))
            ->plugin(\Hasnayeen\Themes\ThemesPlugin::make())
            ->brandLogo(fn () => view('logo', ['panelId' => 'customer']))
            ->discoverResources(in: app_path('Filament/Customer/Resources'), for: 'App\\Filament\\Customer\\Resources')
            ->discoverPages(in: app_path('Filament/Customer/Pages'), for: 'App\\Filament\\Customer\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->plugin(TwoFactorAuthPlugin::make())
            ->breadcrumbs(false)
            ->maxContentWidth(MaxWidth::Full)
            ->font('Poppins')
            ->brandLogoHeight('3rem')
            ->plugin(TwoFactorAuthPlugin::make())
            ->discoverWidgets(in: app_path('Filament/Customer/Widgets'), for: 'App\\Filament\\Customer\\Widgets')
            ->widgets([
                PaymentChart::class,
            ])
            ->resources([
                InsuranceResource::class,
                ClaimResource::class,
                PaymentResource::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                RoleMiddleware::class.':customer',
            ]);
    }
}
