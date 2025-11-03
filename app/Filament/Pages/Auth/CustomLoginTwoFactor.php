<?php

namespace App\Filament\Pages\Auth;

use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Contracts\HasForms;
use Vormkracht10\TwoFactorAuth\Http\Livewire\Auth\LoginTwoFactor;

class CustomLoginTwoFactor extends LoginTwoFactor implements HasActions, HasForms
{
    protected static string $view = 'filament.auth.login-two-factor';
}
