<?php

namespace App\Http\Responses;

use App\Models\User;
use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user) {
            $role = $user->roles()->first();
            if ($role && $role->name === User::SUPER_ADMIN) {
                return redirect()->route('filament.super-admin.pages.dashboard');
            } elseif ($role && $role->name === User::ADMIN) {
                return redirect()->route('filament.admin.pages.dashboard');
            } elseif ($role && $role->name === User::AGENT) {
                return redirect()->route('filament.agent.pages.dashboard');
            } elseif ($role && $role->name === User::CUSTOMER) {
                return redirect()->route('filament.customer.pages.dashboard');
            }
            session()->flush();

            notify('User does not have the right roles!', 'danger');

            return redirect()->route('filament.admin.auth.login');
        }
    }
}
