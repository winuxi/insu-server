<?php

namespace App\Filament\SuperAdmin\Pages;

use App\Enums\NavigationGroup;
use App\Models\SuperAdminSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;

class FooterSection extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-bars-3-bottom-right';

    protected static string $view = 'filament.super-admin.pages.footer-section';

    public static function getNavigationGroup(): ?string
    {
        return NavigationGroup::CMS->label();
    }

    protected static ?int $navigationSort = 107;

    protected static ?string $title = 'Footer Section';

    public static function getNavigationLabel(): string
    {
        return __('messages.footer_section.navigation_label');
    }

    public function getTitle(): string
    {
        return __('messages.footer_section.title');
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
            ->schema([
                Section::make(__('messages.footer_section.footer_links'))
                    ->collapsible()
                    ->schema([
                        TextInput::make('twitter_link')
                            ->url()
                            ->required()
                            ->placeholder(__('messages.footer_section.twitter_placeholder'))
                            ->label(__('messages.footer_section.twitter_link')),
                        TextInput::make('linkedin_link')
                            ->url()
                            ->required()
                            ->placeholder(__('messages.footer_section.linkedin_placeholder'))
                            ->label(__('messages.footer_section.linkedin_link')),
                        TextInput::make('facebook_link')
                            ->url()
                            ->required()
                            ->placeholder(__('messages.footer_section.facebook_placeholder'))
                            ->label(__('messages.footer_section.facebook_link')),
                    ]),
                Section::make(__('messages.footer_section.privacy_terms_section'))
                    ->collapsible()
                    ->schema([
                        RichEditor::make('privacy_policy')
                            ->placeholder(__('messages.footer_section.privacy_policy'))
                            ->required()
                            ->label(__('messages.footer_section.privacy_policy')),
                        RichEditor::make('terms_and_conditions')
                            ->placeholder(__('messages.footer_section.terms_and_conditions'))
                            ->required()
                            ->label(__('messages.footer_section.terms_and_conditions')),
                    ]),
            ])
            ->statePath('data');
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('messages.footer_section.save'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            SuperAdminSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        notify(__('messages.footer_section.updated_successfully'));

        $this->redirect(static::getUrl());
    }
}
