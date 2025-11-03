<?php

namespace App\Providers\Filament;

use App\Enums\NavigationGroup;
use App\Filament\Pages\Auth\CustomEditProfile;
use App\Filament\Pages\Auth\CustomLogin;
use App\Filament\Pages\Auth\CustomRegister;
use App\Filament\Pages\Auth\CustomRequestPasswordReset;
use App\Filament\Pages\Auth\CustomResetPassword;
use App\Filament\SuperAdmin\Resources\SubscriptionResource;
use App\Http\Middleware\CheckSubscription;
use App\Http\Middleware\MultiTenantMiddleware;
use App\Models\User;
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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('')
            ->spa()
            ->favicon(appFavicon())
            ->brandName(appName())
            ->brandLogo(fn () => view('logo', ['panelId' => 'admin']) ?? asset('logo.png'))
            ->darkModeBrandLogo(fn () => view('dark-logo', ['panelId' => 'admin']) ?? asset('logo.png'))
            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn () => Auth::user()?->name)
                    ->icon(fn () => Auth::user()?->profile),
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label(fn () => __('messages.subscription.subscription'))
                    ->icon('heroicon-o-star')
                    ->url(fn () => route('filament.admin.pages.subscription'))
                    ->hidden(fn () => Auth::check() && ! Auth::user()->role->name == User::ADMIN),
            ])
            ->colors([
                'primary' => Color::Purple,
                'gray' => Color::Gray,
                'danger' => Color::Rose,
                'custom' => Color::hex('#6219a6'),
            ])
            ->renderHook(PanelsRenderHook::GLOBAL_SEARCH_AFTER, fn () => view('layout.theme-settings'))
            ->renderHook(PanelsRenderHook::USER_MENU_PROFILE_AFTER, fn () => Blade::render("@livewire('change-password')"))
            ->breadcrumbs(false)
            ->maxContentWidth(MaxWidth::Full)
            ->font('Poppins')
            ->brandLogoHeight('3rem')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([])
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
                CheckSubscription::class,
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
            ])
            ->navigationGroups([
                NavigationGroup::HOME->value,
                NavigationGroup::BUSINESS_MANAGEMENT->value,
                NavigationGroup::SYSTEM_CONFIGURATION->value,
                NavigationGroup::SYSTEM_SETTINGS->value,
            ])
            ->resources([
                SubscriptionResource::class,
                config('filament-logger.activity_resource'),
            ])
            ->authMiddleware([
                Authenticate::class,
                RoleMiddleware::class.':admin',
                // MultiTenantMiddleware::class,
            ])
            ->passwordReset(requestAction: CustomRequestPasswordReset::class, resetAction: CustomResetPassword::class)
            ->profile(CustomEditProfile::class, isSimple: false)
            ->login(CustomLogin::class)
            ->registration(CustomRegister::class)
            ->plugin(\Hasnayeen\Themes\ThemesPlugin::make())
            ->plugin(TwoFactorAuthPlugin::make());
    }
}
