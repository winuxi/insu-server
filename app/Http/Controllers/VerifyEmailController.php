<?php

namespace App\Http\Controllers;

use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function verify(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            Notification::make()
                ->success()
                ->title(__('messages.common.email_varification'))
                ->send();

            return redirect()->route('auth');
        }

        if ($user->markEmailAsVerified()) {
            Notification::make()
                ->success()
                ->title(__('messages.common.email_varification'))
                ->send();

            return redirect()->route('auth');
        }

        Notification::make()
            ->danger()
            ->title(__('Failed to verify email!'))
            ->send();

        return redirect()->route('auth');
    }
}
