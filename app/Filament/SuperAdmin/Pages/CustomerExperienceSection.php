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

class CustomerExperienceSection extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-face-smile';

    protected static string $view = 'filament.super-admin.pages.customer-experience-section';

    public static function getNavigationGroup(): ?string
    {
        return NavigationGroup::CMS->label();
    }

    protected static ?int $navigationSort = 103;

    public ?array $data;

    public static function getNavigationLabel(): string
    {
        return __('messages.setting.customer_experience_section');
    }

    public function getTitle(): string
    {
        return __('messages.setting.customer_experience_section');
    }

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
                        SpatieMediaLibraryFileUpload::make('customer_main_image')
                            ->label(__('messages.setting.customer_main_image'))
                            ->placeholder(__('messages.setting.customer_main_image_placeholder'))
                            ->disk(config('app.media_disk'))
                            ->image()
                            ->collection(SuperAdminSetting::CUSTOMER_MAIN_IMAGE)
                            ->columnSpan(1),
                    ]),

                // Section One
                Section::make(__('messages.setting.section_one'))
                    ->collapsible()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('customer_experience_image_1')
                                    ->label(__('messages.setting.customer_experience_image_1'))
                                    ->placeholder(__('messages.setting.customer_experience_image_1_placeholder'))
                                    ->disk(config('app.media_disk'))
                                    ->image()
                                    ->collection(SuperAdminSetting::CUSTOMER_IMAGE_1)
                                    ->columnSpan(1),

                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('customer_experience_title_1')
                                            ->label(__('messages.setting.customer_experience_title_1'))
                                            ->placeholder(__('messages.setting.customer_experience_title_1_placeholder')),

                                        Textarea::make('customer_experience_description_1')
                                            ->label(__('messages.setting.customer_experience_description_1'))
                                            ->placeholder(__('messages.setting.customer_experience_description_1_placeholder')),
                                    ])
                                    ->columnSpan(3),
                            ]),
                    ]),

                // Section Two
                Section::make(__('messages.setting.section_two'))
                    ->collapsible()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('customer_experience_image_2')
                                    ->label(__('messages.setting.customer_experience_image_2'))
                                    ->placeholder(__('messages.setting.customer_experience_image_2_placeholder'))
                                    ->disk(config('app.media_disk'))
                                    ->image()
                                    ->collection(SuperAdminSetting::CUSTOMER_IMAGE_2)
                                    ->columnSpan(1),

                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('customer_experience_title_2')
                                            ->label(__('messages.setting.customer_experience_title_2'))
                                            ->placeholder(__('messages.setting.customer_experience_title_2_placeholder')),

                                        Textarea::make('customer_experience_description_2')
                                            ->label(__('messages.setting.customer_experience_description_2'))
                                            ->placeholder(__('messages.setting.customer_experience_description_2_placeholder')),
                                    ])
                                    ->columnSpan(3),
                            ]),
                    ]),

                // Section Three
                Section::make(__('messages.setting.section_three'))
                    ->collapsible()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('customer_experience_image_3')
                                    ->label(__('messages.setting.customer_experience_image_3'))
                                    ->placeholder(__('messages.setting.customer_experience_image_3_placeholder'))
                                    ->disk(config('app.media_disk'))
                                    ->image()
                                    ->collection(SuperAdminSetting::CUSTOMER_IMAGE_3)
                                    ->columnSpan(1),

                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('customer_experience_title_3')
                                            ->label(__('messages.setting.customer_experience_title_3'))
                                            ->placeholder(__('messages.setting.customer_experience_title_3_placeholder')),

                                        Textarea::make('customer_experience_description_3')
                                            ->label(__('messages.setting.customer_experience_description_3'))
                                            ->placeholder(__('messages.setting.customer_experience_description_3_placeholder')),
                                    ])
                                    ->columnSpan(3),
                            ]),
                    ]),

                // Section Four
                Section::make(__('messages.setting.section_four'))
                    ->collapsible()
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('customer_experience_image_4')
                                    ->label(__('messages.setting.customer_experience_image_4'))
                                    ->placeholder(__('messages.setting.customer_experience_image_4_placeholder'))
                                    ->disk(config('app.media_disk'))
                                    ->image()
                                    ->collection(SuperAdminSetting::CUSTOMER_IMAGE_4)
                                    ->columnSpan(1),

                                Grid::make(1)
                                    ->schema([
                                        TextInput::make('customer_experience_title_4')
                                            ->label(__('messages.setting.customer_experience_title_4'))
                                            ->placeholder(__('messages.setting.customer_experience_title_4_placeholder')),

                                        Textarea::make('customer_experience_description_4')
                                            ->label(__('messages.setting.customer_experience_description_4'))
                                            ->placeholder(__('messages.setting.customer_experience_description_4_placeholder')),
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
                ->label(__('messages.setting.save'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            SuperAdminSetting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        notify(__('messages.setting.customer_experience_updated_successfully'));

        $this->redirect(static::getUrl());
    }
}
