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

class FeatureSection extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static string $view = 'filament.super-admin.pages.feature-section';

    public static function getNavigationGroup(): ?string
    {
        return NavigationGroup::CMS->label();
    }

    protected static ?int $navigationSort = 102;

    protected static ?string $title = null;

    public static function getNavigationLabel(): string
    {
        return __('messages.feature_section.title');
    }

    public function getTitle(): string
    {
        return __('messages.feature_section.title');
    }

    public ?array $data;

    public function mount(): void
    {
        SuperAdminSetting::firstOrCreate(['key' => 'app_name'], ['value' => config('app.name')]);

        $settings = SuperAdminSetting::toBase()->pluck('value', 'key')->toArray();

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(SuperAdminSetting::with('media')->where('key', 'app_name')?->first())
            ->schema([
                Section::make(__('messages.feature_section.feature_one'))
                    ->collapsible()
                    ->schema([
                        TextInput::make('feature_title_1')
                            ->label(__('messages.feature_section.feature_title_1'))
                            ->placeholder(__('messages.feature_section.feature_title_1')),
                        Textarea::make('feature_description_1')
                            ->label(__('messages.feature_section.feature_description_1'))
                            ->placeholder(__('messages.feature_section.feature_description_1')),
                        SpatieMediaLibraryFileUpload::make('feature_image_1')
                            ->label(__('messages.feature_section.feature_image_1'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->placeholder(__('messages.feature_section.feature_image_1'))
                            ->collection(SuperAdminSetting::FEATURE_IMAGE_1),
                    ]),
                Section::make(__('messages.feature_section.feature_two'))
                    ->collapsible()
                    ->schema([
                        TextInput::make('feature_title_2')
                            ->label(__('messages.feature_section.feature_title_2'))
                            ->placeholder(__('messages.feature_section.feature_title_2')),
                        Textarea::make('feature_description_2')
                            ->label(__('messages.feature_section.feature_description_2'))
                            ->placeholder(__('messages.feature_section.feature_description_2')),
                        SpatieMediaLibraryFileUpload::make('feature_image_2')
                            ->label(__('messages.feature_section.feature_image_2'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->placeholder(__('messages.feature_section.feature_image_2'))
                            ->collection(SuperAdminSetting::FEATURE_IMAGE_2),
                    ]),
                Section::make(__('messages.feature_section.feature_three'))
                    ->collapsible()
                    ->schema([
                        TextInput::make('feature_title_3')
                            ->label(__('messages.feature_section.feature_title_3'))
                            ->placeholder(__('messages.feature_section.feature_title_3')),
                        Textarea::make('feature_description_3')
                            ->label(__('messages.feature_section.feature_description_3'))
                            ->placeholder(__('messages.feature_section.feature_description_3')),
                        SpatieMediaLibraryFileUpload::make('feature_image_3')
                            ->label(__('messages.feature_section.feature_image_3'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->placeholder(__('messages.feature_section.feature_image_3'))
                            ->collection(SuperAdminSetting::FEATURE_IMAGE_3),
                    ]),
                Section::make(__('messages.feature_section.feature_four'))
                    ->collapsible()
                    ->schema([
                        TextInput::make('feature_title_4')
                            ->label(__('messages.feature_section.feature_title_4'))
                            ->placeholder(__('messages.feature_section.feature_title_4')),
                        Textarea::make('feature_description_4')
                            ->label(__('messages.feature_section.feature_description_4'))
                            ->placeholder(__('messages.feature_section.feature_description_4')),
                        SpatieMediaLibraryFileUpload::make('feature_image_4')
                            ->label(__('messages.feature_section.feature_image_4'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->placeholder(__('messages.feature_section.feature_image_4'))
                            ->collection(SuperAdminSetting::FEATURE_IMAGE_4),
                    ]),
                Section::make(__('messages.feature_section.feature_five'))
                    ->collapsible()
                    ->schema([
                        TextInput::make('feature_title_5')
                            ->label(__('messages.feature_section.feature_title_5'))
                            ->placeholder(__('messages.feature_section.feature_title_5')),
                        Textarea::make('feature_description_5')
                            ->label(__('messages.feature_section.feature_description_5'))
                            ->placeholder(__('messages.feature_section.feature_description_5')),
                        SpatieMediaLibraryFileUpload::make('feature_image_5')
                            ->label(__('messages.feature_section.feature_image_5'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->placeholder(__('messages.feature_section.feature_image_5'))
                            ->collection(SuperAdminSetting::FEATURE_IMAGE_5),
                    ]),
                Section::make(__('messages.feature_section.feature_six'))
                    ->collapsible()
                    ->schema([
                        TextInput::make('feature_title_6')
                            ->label(__('messages.feature_section.feature_title_6'))
                            ->placeholder(__('messages.feature_section.feature_title_6')),
                        Textarea::make('feature_description_6')
                            ->label(__('messages.feature_section.feature_description_6'))
                            ->placeholder(__('messages.feature_section.feature_description_6')),
                        SpatieMediaLibraryFileUpload::make('feature_image_6')
                            ->label(__('messages.feature_section.feature_image_6'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->placeholder(__('messages.feature_section.feature_image_6'))
                            ->collection(SuperAdminSetting::FEATURE_IMAGE_6),
                    ]),
            ])->statePath('data');
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('messages.feature_section.save'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            SuperAdminSetting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        notify(__('messages.feature_section.updated_successfully'));

        $this->redirect(static::getUrl());
    }
}
