<?php

namespace App\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
use Livewire\Component;

class ChangePassword extends Component implements HasForms
{
    use InteractsWithForms;

    public $current_password;

    public $new_password;

    public $confirm_password;

    protected $rules = [
        'current_password' => 'required|string',
        'new_password' => 'required|string|min:8',
        'confirm_password' => 'required|string|min:8|same:new_password',
    ];

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('current_password')
                    ->label(__('messages.user.change_password'))
                    ->revealable()
                    ->password()
                    ->required()
                    ->placeholder(__('messages.user.change_password')),

                TextInput::make('new_password')
                    ->label(__('messages.user.new_password'))
                    ->revealable()
                    ->password()
                    ->required()
                    ->minLength(6)
                    ->placeholder(__('messages.user.new_password')),

                TextInput::make('confirm_password')
                    ->label(__('messages.user.confirm_password'))
                    ->revealable()
                    ->password()
                    ->required()
                    ->minLength(6)
                    ->placeholder(__('messages.user.confirm_password')),
            ]);
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();

        if (! Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', __('validation.current_password'));

            return;
        }

        if ($this->new_password != $this->confirm_password) {
            $this->addError('confirm_password', __('validation.confirmed', [
                'attribute' => __('messages.user.confirm_password'),
            ]));

            return;
        }

        if ($this->new_password == $this->current_password) {
            $this->addError('new_password', 'The new password cannot be the same as the current password');

            return;
        }

        $user->password = Hash::make($this->new_password);
        $user->save();

        Session::forget('password_hash_web');
        Auth::login($user);

        Notification::make()
            ->title(__('Password Updated successfully'))
            ->success()
            ->send();
        $this->dispatch('close-modal', id: 'change-password-modal');
        $this->reset(['current_password', 'new_password', 'confirm_password']);
    }

    #[On('close-modal')]
    public function resetFormData()
    {
        $this->resetValidation();
        $this->reset();
    }

    public function render()
    {
        return view('livewire.change-password');
    }
}
