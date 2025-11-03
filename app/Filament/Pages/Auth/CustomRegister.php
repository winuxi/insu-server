<?php

namespace App\Filament\Pages\Auth;

use AbanoubNassem\FilamentGRecaptchaField\Forms\Components\GRecaptcha;
use App\Models\MultiTenant;
use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Events\Auth\Registered;
use Filament\Http\Responses\Auth\RegistrationResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register;

class CustomRegister extends Register
{
    /**
     * @var view-string
     */
    protected static string $view = 'filament.auth.register';

    /**
     * @return array<int | string, string | Form>
     */
    public function mount(): void
    {
        if (! isRegistrationPageEnabled()) {
            abort(403);
        }
        parent::mount();
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent()
                            ->label(__('messages.user.name').':')
                            ->placeholder(__('messages.user.name')),

                        $this->getEmailFormComponent()
                            ->label(__('messages.mails.email_address').':')
                            ->placeholder(__('messages.mails.email_address')),

                        $this->getPasswordFormComponent()
                            ->label(__('messages.user.password').':')
                            ->placeholder(__('messages.user.password'))
                            ->extraAttributes(['class' => 'password-field']),

                        $this->getPasswordConfirmationFormComponent()
                            ->label(__('messages.user.confirm_password').':')
                            ->placeholder(__('messages.user.confirm_password'))
                            ->extraAttributes(['class' => 'password-field']),

                        GRecaptcha::make('captcha')->visible(function () {
                            return (! empty(googleReCaptchaCredentials()['key']) && ! empty(googleReCaptchaCredentials()['secret'])) ? true : false;
                        })->validationAttribute('Google ReCaptcha'),
                    ])
                    ->statePath('data'),
            )->extraAttributes(['class' => 'mb-5']),
        ];

    }

    protected function getFormActions(): array
    {
        return [
            $this->getRegisterFormAction()
                ->extraAttributes(['class' => 'w-full flex items-center justify-center space-x-3 form-submit mt-5'])
                ->label(__('auth.register')),
        ];
    }

    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $user = $this->wrapInDatabaseTransaction(function () {

            $data = $this->form->getState();

            $data = $this->mutateFormDataBeforeRegister($data);

            $user = $this->handleRegistration($data);

            $user->assignRole(User::ADMIN);

            $tenant = MultiTenant::create([
                'tenant_username' => $data['name'],
            ]);

            $user->update([
                'tenant_id' => $tenant->id,
            ]);

            $this->form->model($user)->saveRelationships();

            return $user;
        });

        event(new Registered($user));

        $user->sendEmailVerificationNotification();
        Notification::make()
            ->success()
            ->title(__('messages.common.email_varification'))
            ->send();

        return app(RegistrationResponse::class);
    }
}
