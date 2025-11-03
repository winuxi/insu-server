<?php

namespace App\Filament\SuperAdmin\Pages;

use App\Enums\NavigationGroup;
use App\Models\SuperAdminSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Pages\Page;

class GoogleReCaptchaSetting extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-viewfinder-circle';

    protected static string $view = 'filament.super-admin.pages.google-re-captcha-setting';

    public static function getNavigationGroup(): string
    {
        return NavigationGroup::SYSTEM_SETTINGS->label();
    }

    protected static ?int $navigationSort = 109;

    protected static ?string $title = 'Google ReCaptcha';

    public ?array $data;

    public function mount(): void
    {
        $settings = SuperAdminSetting::toBase()->pluck('value', 'key')->toArray();

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(SuperAdminSetting::class)
            ->schema([
                Section::make()
                    ->schema([
                        ToggleButtons::make('google_recaptcha_enabled')
                            ->required()
                            ->label(__('messages.google_recaptcha.enable'))
                            ->colors([
                                1 => 'success',
                                0 => 'danger',
                            ])
                            ->grouped()
                            ->options([
                                1 => __('messages.google_recaptcha.enabled'),
                                0 => __('messages.google_recaptcha.disabled'),
                            ])
                            ->columnSpanFull(),

                        TextInput::make('google_recaptcha_site_key')
                            ->visible(fn ($get) => $get('google_recaptcha_enabled') == 1)
                            ->placeholder(__('messages.google_recaptcha.site_key'))
                            ->required()
                            ->label(__('messages.google_recaptcha.site_key')),

                        TextInput::make('google_recaptcha_secret_key')
                            ->visible(fn ($get) => $get('google_recaptcha_enabled') == 1)
                            ->placeholder(__('messages.google_recaptcha.secret_key'))
                            ->required()
                            ->label(__('messages.google_recaptcha.secret_key')),
                    ])->columns(2),
            ])->live()->statePath('data')->columns(2);
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('Save'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            SuperAdminSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        notify(__('messages.google_recaptcha.updated_successfully'));

        $this->redirect(static::getUrl());
    }
}
