<?php

namespace App\Filament\Pages\Auth;

use AbanoubNassem\FilamentGRecaptchaField\Forms\Components\GRecaptcha;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions;
use Filament\Forms\Set;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Livewire\Features\SupportRedirects\Redirector;
use Vormkracht10\TwoFactorAuth\Http\Livewire\Auth\Login as TwoFactorLogin;
use Vormkracht10\TwoFactorAuth\Http\Responses\LoginResponse;

class CustomLogin extends TwoFactorLogin
{
    /**
     * @var view-string
     */
    protected static string $view = 'filament.auth.login';

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent()
                            ->label(__('messages.mails.email_address'))
                            ->validationAttribute(__('messages.mails.email_address'))
                            ->placeholder(__('messages.mails.email_address')),

                        $this->getPasswordFormComponent()
                            ->label(__('messages.user.password'))
                            ->validationAttribute(__('messages.user.password'))
                            ->placeholder(__('messages.user.password'))
                            ->hint(
                                filament()->hasPasswordReset()
                                    ? new HtmlString(Blade::render(
                                        '<a href="'.filament()->getRequestPasswordResetUrl().'" class="text-[#6219a6] font-semibold">'.__('auth.forgot_password.text').'</a>'
                                    ))
                                    : null
                            )

                            ->extraAttributes(['class' => 'password-field']),
                        GRecaptcha::make('captcha')->visible(function () {
                            return (! empty(googleReCaptchaCredentials()['key']) && ! empty(googleReCaptchaCredentials()['secret'])) ? true : false;
                        }),
                        $this->getRememberFormComponent()
                            ->label(__('auth.remember_me')),
                        Actions::make([
                            Actions\Action::make('superadmin')
                                ->label(__('Super Admin'))
                                ->color('warning')
                                ->action(function (Set $set) {
                                    $set('email', 'superadmin@gmail.com');
                                    $set('password', 123456);
                                    $this->loginWithFortify();
                                }),

                            Actions\Action::make('admin')
                                ->label(__('Admin'))
                                ->color('success')
                                ->action(function (Set $set) {
                                    $set('email', 'admin@gmail.com');
                                    $set('password', 123456);
                                    $this->loginWithFortify();
                                }),
                        ])->fullWidth()->alignment(Alignment::Center)->hidden(true),
                        Actions::make([
                            Actions\Action::make('agent')
                                ->label(__('Agent'))
                                ->color('info')
                                ->action(function (Set $set) {
                                    $set('email', 'agent@gmail.com');
                                    $set('password', 123456);
                                    $this->loginWithFortify();
                                }),

                            Actions\Action::make('customer')
                                ->label(__('Customer'))
                                ->color('warning')
                                ->action(function (Set $set) {
                                    $set('email', 'customer@gmail.com');
                                    $set('password', 123456);
                                    $this->loginWithFortify();
                                }),
                        ])->fullWidth()->alignment(Alignment::Center)->hidden(true),
                    ])
                    ->statePath('data'),
            ),

        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction()
                ->extraAttributes(['class' => 'w-full flex items-center justify-center space-x-3 form-submit'])
                ->label(__('auth.sign_in')),
        ];
    }

    public function loginWithFortify(): LoginResponse|Redirector|Response|null
    {
        session()->put('panel', Filament::getCurrentPanel()?->getId() ?? null);

        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $notificationBody = __('filament-panels::pages/auth/login.notifications.throttled.body', [
                'seconds' => $exception->secondsUntilAvailable,
                'minutes' => ceil($exception->secondsUntilAvailable / 60),
            ]);

            Notification::make()
                ->title(__('filament-panels::pages/auth/login.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(is_array($notificationBody) ? null : $notificationBody)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        if (isset($data['email']) && ! empty($data['email']) && isOwnerEmailVerificationEnabled()) {
            $user = User::whereEmail($data['email'])->first();
            if ($user) {
                if ($user->email_verified_at == null) {
                    Notification::make()
                        ->title(__('messages.common.email_not_verified'))
                        ->danger()
                        ->send();

                    return null;
                }
            }
        }

        $request = request()->merge($data);

        if (! $this->validateCredentials($this->getCredentialsFromFormData($data))) {
            $this->throwFailureValidationException();
        }

        return $this->loginPipeline($request)->then(function (Request $request) use ($data) {
            if (! Filament::auth()->attempt($this->getCredentialsFromFormData($data), $data['remember'] ?? false)) {
                $this->throwFailureValidationException();
            }

            $user = Filament::auth()->user();

            if (! Filament::getCurrentPanel()) {
                Filament::auth()->logout();

                throw new \Exception('Current panel is not set.');
            }

            if (
                ($user instanceof FilamentUser) &&
                (! $user->canAccessPanel(Filament::getCurrentPanel()))
            ) {
                Filament::auth()->logout();

                $this->throwFailureValidationException();
            }

            session()->regenerate();

            return app(LoginResponse::class);
        });
    }
}
