<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Resources\ClaimResource;
use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\InsuranceResource;
use App\Filament\Resources\PaymentResource;
use App\Filament\Widgets\PaymentChart;
use App\Filament\Widgets\StatsOverview;
use App\Http\Middleware\MultiTenantMiddleware;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
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

class AgentPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('agent')
            ->path('agent')
            ->spa()
            ->colors([
                'primary' => Color::Pink,
                'gray' => Color::Gray,
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn () => Auth::user()?->name)
                    ->icon(fn () => Auth::user()?->profile),
            ])
            ->favicon(appFavicon())
            ->brandName(appNameByAdmin())
            ->renderHook(PanelsRenderHook::GLOBAL_SEARCH_AFTER, fn () => view('layout.theme-settings'))
            ->brandLogo(fn () => view('logo', ['panelId' => 'agent']))
            ->discoverResources(in: app_path('Filament/Agent/Resources'), for: 'App\\Filament\\Agent\\Resources')
            ->discoverPages(in: app_path('Filament/Agent/Pages'), for: 'App\\Filament\\Agent\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->plugin(TwoFactorAuthPlugin::make())
            ->plugin(\Hasnayeen\Themes\ThemesPlugin::make())
            ->breadcrumbs(false)
            ->maxContentWidth(MaxWidth::Full)
            ->font('Poppins')
            ->brandLogoHeight('3rem')
            ->discoverWidgets(in: app_path('Filament/Agent/Widgets'), for: 'App\\Filament\\Agent\\Widgets')
            ->resources([
                CustomerResource::class,
                InsuranceResource::class,
                ClaimResource::class,
                PaymentResource::class,
            ])
            ->widgets([
                StatsOverview::class,
                PaymentChart::class,
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
                RoleMiddleware::class.':agent',
                // MultiTenantMiddleware::class,
            ]);
    }
}
