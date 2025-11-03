<?php

namespace App\Filament\SuperAdmin\Pages;

use App\Enums\NavigationGroup;
use App\Models\SuperAdminSetting as Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class SuperAdminSetting extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function getNavigationGroup(): string
    {
        return NavigationGroup::SYSTEM_SETTINGS->label();
    }

    protected static ?int $navigationSort = 107;

    protected static string $view = 'filament.super-admin.pages.super-admin-setting';

    public static function getNavigationLabel(): string
    {
        return __('messages.super_admin_setting.navigation_label');
    }

    public function getTitle(): string
    {
        return __('messages.super_admin_setting.title');
    }

    public ?array $data;

    public function mount(): void
    {
        Setting::firstOrCreate(['key' => 'app_name'], ['value' => config('app.name')]);

        $settings = Setting::toBase()->pluck('value', 'key')->toArray();

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(Setting::with('media')->where('key', 'app_name')?->first())
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('app_name')
                            ->label(__('messages.super_admin_setting.app_name'))
                            ->placeholder(__('messages.super_admin_setting.app_name_placeholder'))
                            ->required()
                            ->columnSpanFull(),

                        SpatieMediaLibraryFileUpload::make(Setting::LOGO)
                            ->label(__('messages.super_admin_setting.logo'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->collection(Setting::LOGO)
                            ->required(),

                        SpatieMediaLibraryFileUpload::make(Setting::FAVICON)
                            ->label(__('messages.super_admin_setting.favicon'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->collection(Setting::FAVICON)
                            ->required(),

                        SpatieMediaLibraryFileUpload::make(Setting::LIGHT_LOGO)
                            ->label(__('messages.super_admin_setting.light_logo'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->collection(Setting::LIGHT_LOGO)
                            ->required(),

                        SpatieMediaLibraryFileUpload::make(Setting::LANDING_LOGO)
                            ->label(__('messages.super_admin_setting.landing_logo'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->collection(Setting::LANDING_LOGO)
                            ->required(),
                        SpatieMediaLibraryFileUpload::make(Setting::AUTH_BG_IMAGE)
                            ->label(__('messages.super_admin_setting.auth_bg_image'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->collection(Setting::AUTH_BG_IMAGE)
                            ->required(),
                        Grid::make()
                            ->schema([
                                Toggle::make('owner_email_verification')
                                    ->label(__('messages.super_admin_setting.enable_email_verification'))
                                    ->live()
                                    ->required(),

                                Toggle::make('registration_page')
                                    ->label(__('messages.super_admin_setting.enable_registration_page'))
                                    ->live()
                                    ->required(),

                                Toggle::make('landing_page')
                                    ->label(__('messages.super_admin_setting.enable_landing_page'))
                                    ->live()
                                    ->required(),
                            ])
                            ->columns(1)
                            ->columnSpanFull(),
                    ])
                    ->columns(5),
            ])
            ->statePath('data');
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('messages.super_admin_setting.save'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        notify(__('messages.super_admin_setting.updated_successfully'));

        $this->redirect(static::getUrl());
    }
}
