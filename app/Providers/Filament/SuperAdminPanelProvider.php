<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Resources\UserResource;
use App\Filament\Widgets\PaymentChart;
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
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Spatie\Permission\Middleware\RoleMiddleware;
use Vormkracht10\TwoFactorAuth\TwoFactorAuthPlugin;

class SuperAdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('super-admin')
            ->path('super-admin')
            ->spa()
            ->colors([
                'primary' => Color::hex('#FF0000'),
                'gray' => Color::Gray,
                'danger' => Color::Rose,
            ])
            ->favicon(appFavicon())
            ->brandLogo(fn () => view('logo', ['panelId' => 'super-admin']))
            ->darkModeBrandLogo(fn () => view('dark-logo', ['panelId' => 'super-admin']))
            ->brandName(appName())
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn () => Auth::user()?->name)
                    ->icon(fn () => Auth::user()?->profile),
            ])
            ->renderHook(PanelsRenderHook::USER_MENU_PROFILE_AFTER, fn () => Blade::render("@livewire('change-password')"))
            ->breadcrumbs(false)
            ->maxContentWidth(MaxWidth::Full)
            ->font('Poppins')
            ->brandLogoHeight('3rem')
            ->discoverResources(in: app_path('Filament/SuperAdmin/Resources'), for: 'App\\Filament\\SuperAdmin\\Resources')
            ->discoverPages(in: app_path('Filament/SuperAdmin/Pages'), for: 'App\\Filament\\SuperAdmin\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->renderHook(PanelsRenderHook::GLOBAL_SEARCH_AFTER, fn () => view('layout.theme-settings'))
            ->plugin(
                \Hasnayeen\Themes\ThemesPlugin::make()
            )
            ->plugin(TwoFactorAuthPlugin::make())
            ->resources([
                UserResource::class,
            ])
            ->discoverWidgets(in: app_path('Filament/SuperAdmin/Widgets'), for: 'App\\Filament\\SuperAdmin\\Widgets')
            ->widgets([
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
                RoleMiddleware::class.':super-admin',
                // MultiTenantMiddleware::class,
            ]);
    }
}
