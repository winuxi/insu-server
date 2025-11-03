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

class HeroSection extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.super-admin.pages.hero-section';

    public static function getNavigationGroup(): ?string
    {
        return NavigationGroup::CMS->label();
    }

    protected static ?int $navigationSort = 100;

    protected static ?string $title = null;

    public static function getNavigationLabel(): string
    {
        return __('messages.hero_section.title');
    }

    public function getTitle(): string
    {
        return __('messages.hero_section.title');
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
                Section::make()
                    ->schema([
                        TextInput::make('tag_line')
                            ->label(__('messages.hero_section.tag_line'))
                            ->placeholder(__('messages.hero_section.tag_line'))
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('hero_section_title')
                            ->label(__('messages.hero_section.hero_section_title'))
                            ->placeholder(__('messages.hero_section.hero_section_title'))
                            ->maxLength(255)
                            ->required(),
                        Textarea::make('hero_section_short_description')
                            ->label(__('messages.hero_section.hero_section_short_description'))
                            ->placeholder(__('messages.hero_section.hero_section_short_description'))
                            ->rows(3)
                            ->maxLength(255)
                            ->required(),
                        SpatieMediaLibraryFileUpload::make('hero_section_image')
                            ->label(__('messages.hero_section.hero_section_image'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->placeholder(__('messages.hero_section.hero_section_image'))
                            ->collection(SuperAdminSetting::HERO_SECTION_IMAGE)
                            ->required(),
                    ])->columns(2),
            ])->statePath('data');
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('messages.hero_section.save'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            SuperAdminSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        notify(__('messages.hero_section.updated_successfully'));

        $this->redirect(static::getUrl());
    }
}
