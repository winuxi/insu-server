<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\EditProfile;

class CustomEditProfile extends EditProfile
{
    public static function getLabel(): string
    {
        return __('messages.user.profile_details');
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        Section::make(__('messages.user.user_information'))
                            ->columns(4)
                            ->schema([
                                Group::make([
                                    SpatieMediaLibraryFileUpload::make('profile')
                                        ->label(__('messages.user.profile').':')
                                        ->validationAttribute(__('messages.user.profile'))
                                        ->disk(config('app.media_disk'))
                                        ->collection(User::PROFILE)
                                        ->image()
                                        ->imagePreviewHeight(150)
                                        ->imageEditor('cropper')
                                        ->required(),
                                ]),
                                Group::make([
                                    TextInput::make('name')
                                        ->label(__('messages.common.name').':')
                                        ->placeholder(__('messages.common.name'))
                                        ->validationAttribute(__('messages.common.name'))
                                        ->required()
                                        ->maxLength(255)
                                        ->autofocus(),
                                    TextInput::make('email')
                                        ->label(__('messages.user.email').':')
                                        ->placeholder(__('messages.user.email'))
                                        ->validationAttribute(__('messages.user.email'))
                                        ->email()
                                        ->required()
                                        ->maxLength(255)
                                        ->unique(ignoreRecord: true),
                                ])->columnSpan(3)->columns(1),
                            ]),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data'),
            ),
        ];
    }

    // protected function beforeSave()
    // {
    //     $user = auth()->user();
    //     if (isDefaultRecord($user)) {
    //         Notification::make()
    //             ->danger()
    //             ->title(__('messages.common.action_is_not_allowed'))
    //             ->send();
    //         $this->halt();
    //     }
    // }

    protected function getRedirectUrl(): ?string
    {
        return self::getUrl();
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('messages.user.user_updated_successfully');
    }
}
