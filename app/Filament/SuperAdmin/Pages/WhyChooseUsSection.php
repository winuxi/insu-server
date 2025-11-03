<?php

namespace App\Filament\SuperAdmin\Pages;

use App\Enums\NavigationGroup;
use App\Models\SuperAdminSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;

class WhyChooseUsSection extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.super-admin.pages.why-choose-us-section';

    public static function getNavigationGroup(): ?string
    {
        return NavigationGroup::CMS->label();
    }

    protected static ?int $navigationSort = 104;

    public static function getNavigationLabel(): string
    {
        return __('messages.why_choose_us.title');
    }

    public function getTitle(): string
    {
        return __('messages.why_choose_us.title');
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
                Section::make(__('messages.why_choose_us.why_choose_us_title_1'))
                    ->collapsible()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('why_choose_us_image_1')
                                    ->label(__('messages.why_choose_us.why_choose_us_image_1'))
                                    ->placeholder(__('messages.why_choose_us.why_choose_us_image_1'))
                                    ->disk(config('app.media_disk'))
                                    ->image()
                                    ->collection(SuperAdminSetting::WHY_CHOOSE_US_IMAGE_1)
                                    ->columnSpan(1),

                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('why_choose_us_title_1')
                                            ->label(__('messages.why_choose_us.why_choose_us_title_1'))
                                            ->placeholder(__('messages.why_choose_us.why_choose_us_title_1')),

                                        Textarea::make('why_choose_us_description_1')
                                            ->label(__('messages.why_choose_us.why_choose_us_description_1'))
                                            ->placeholder(__('messages.why_choose_us.why_choose_us_description_1')),
                                    ])
                                    ->columnSpan(3),
                            ]),
                    ]),

                Section::make(__('messages.why_choose_us.why_choose_us_title_2'))
                    ->collapsible()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('why_choose_us_image_2')
                                    ->label(__('messages.why_choose_us.why_choose_us_image_2'))
                                    ->placeholder(__('messages.why_choose_us.why_choose_us_image_2'))
                                    ->disk(config('app.media_disk'))
                                    ->image()
                                    ->collection(SuperAdminSetting::WHY_CHOOSE_US_IMAGE_2)
                                    ->columnSpan(1),

                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('why_choose_us_title_2')
                                            ->label(__('messages.why_choose_us.why_choose_us_title_2'))
                                            ->placeholder(__('messages.why_choose_us.why_choose_us_title_2')),

                                        Textarea::make('why_choose_us_description_2')
                                            ->label(__('messages.why_choose_us.why_choose_us_description_2'))
                                            ->placeholder(__('messages.why_choose_us.why_choose_us_description_2')),
                                    ])
                                    ->columnSpan(3),
                            ]),
                    ]),

                Section::make(__('messages.why_choose_us.why_choose_us_title_3'))
                    ->collapsible()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('why_choose_us_image_3')
                                    ->label(__('messages.why_choose_us.why_choose_us_image_3'))
                                    ->placeholder(__('messages.why_choose_us.why_choose_us_image_3'))
                                    ->disk(config('app.media_disk'))
                                    ->image()
                                    ->collection(SuperAdminSetting::WHY_CHOOSE_US_IMAGE_3)
                                    ->columnSpan(1),

                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('why_choose_us_title_3')
                                            ->label(__('messages.why_choose_us.why_choose_us_title_3'))
                                            ->placeholder(__('messages.why_choose_us.why_choose_us_title_3')),

                                        Textarea::make('why_choose_us_description_3')
                                            ->label(__('messages.why_choose_us.why_choose_us_description_3'))
                                            ->placeholder(__('messages.why_choose_us.why_choose_us_description_3')),
                                    ])
                                    ->columnSpan(3),
                            ]),
                    ]),

                Section::make(__('messages.why_choose_us.why_choose_us_title_4'))
                    ->collapsible()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('why_choose_us_image_4')
                                    ->label(__('messages.why_choose_us.why_choose_us_image_4'))
                                    ->placeholder(__('messages.why_choose_us.why_choose_us_image_4'))
                                    ->disk(config('app.media_disk'))
                                    ->image()
                                    ->collection(SuperAdminSetting::WHY_CHOOSE_US_IMAGE_4)
                                    ->columnSpan(1),

                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('why_choose_us_title_4')
                                            ->label(__('messages.why_choose_us.why_choose_us_title_4'))
                                            ->placeholder(__('messages.why_choose_us.why_choose_us_title_4')),

                                        Textarea::make('why_choose_us_description_4')
                                            ->label(__('messages.why_choose_us.why_choose_us_description_4'))
                                            ->placeholder(__('messages.why_choose_us.why_choose_us_description_4')),
                                    ])
                                    ->columnSpan(3),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('messages.common.save'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            SuperAdminSetting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        notify(__('messages.why_choose_us.why_choose_us_updated_successfully'));

        $this->redirect(static::getUrl());
    }
}
