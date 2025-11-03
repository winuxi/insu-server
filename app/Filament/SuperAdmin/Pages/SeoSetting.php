<?php

namespace App\Filament\SuperAdmin\Pages;

use App\Enums\NavigationGroup;
use App\Models\SuperAdminSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;

class SeoSetting extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';

    public static function getNavigationGroup(): string
    {
        return NavigationGroup::SYSTEM_SETTINGS->label();
    }

    protected static ?int $navigationSort = 109;

    public static function getNavigationLabel(): string
    {
        return __('messages.seo_settings.title');
    }

    public function getTitle(): string
    {
        return __('messages.seo_settings.title');
    }

    protected static string $view = 'filament.super-admin.pages.seo-setting';

    public ?array $data;

    public function mount(): void
    {
        $settings = SuperAdminSetting::toBase()->pluck('value', 'key')->toArray();

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(SuperAdminSetting::with('media')->where('key', 'app_name')?->first())
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('meta_title')
                            ->required()
                            ->placeholder(__('messages.seo_settings.meta_title_placeholder'))
                            ->label(__('messages.seo_settings.meta_title')),

                        TextInput::make('meta_keyword')
                            ->required()
                            ->placeholder(__('messages.seo_settings.meta_keyword_placeholder'))
                            ->label(__('messages.seo_settings.meta_keyword')),

                        Textarea::make('meta_description')
                            ->required()
                            ->placeholder(__('messages.seo_settings.meta_description_placeholder'))
                            ->label(__('messages.seo_settings.meta_description'))
                            ->rows(3),

                        SpatieMediaLibraryFileUpload::make(SuperAdminSetting::META_IMAGE)
                            ->label(__('messages.seo_settings.meta_image'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->collection(SuperAdminSetting::META_IMAGE)
                            ->required(),
                    ])->columns(2),
            ])->statePath('data')->columns(2);
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

        notify(__('messages.seo_settings.updated_successfully'));

        $this->redirect(static::getUrl());
    }
}
