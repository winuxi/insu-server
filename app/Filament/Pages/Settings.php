<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth; // Added Auth facade
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $view = 'filament.pages.settings';

    protected static ?int $navigationSort = 100;

    // protected static ?string $title = 'General Settings'; // Will be handled by getTitle()
    // protected static ?string $navigationLabel = 'Settings'; // Will be handled by getNavigationLabel()

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::SYSTEM_SETTINGS->label();
    }

    public ?array $data;

    public static function getNavigationLabel(): string
    {
        return __('messages.setting.settings');
    }

    public function getTitle(): string
    {
        return __('messages.setting.general_settings');
    }

    public function mount(): void
    {
        Setting::firstOrCreate(['key' => 'app_name'], ['value' => config('app.name')], ['tenant_id' => Auth::user()->tenant_id]);

        $settings = Setting::where('tenant_id', Auth::user()->tenant_id)->toBase()->pluck('value', 'key')->toArray();

        $this->form->fill($settings);
    }

    public function getTimeZone(): array
    {
        $timezoneArr = json_decode(file_get_contents(public_path('timezone.json')), true);
        $timezones = [];

        foreach ($timezoneArr as $utcData) {
            foreach ($utcData['utc'] as $item) {
                $timezones[$item] = $item;
            }
        }

        return $timezones;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('app_name')
                            ->label(__('messages.setting.name'))
                            ->placeholder(__('messages.setting.enter_app_name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('messages.setting.email'))
                            ->placeholder(__('messages.setting.enter_app_email'))
                            ->email()
                            ->required()
                            ->maxLength(255),
                        PhoneInput::make('phone')
                            ->label(__('messages.setting.phone'))
                            ->required()
                            ->rules(['required', 'phone:AUTO'])
                            ->validationMessages([
                                'phone' => __('messages.user.invalid_phone_number'), // Reusing user's message
                            ]),
                        Textarea::make('address')
                            ->label(__('messages.setting.address'))
                            ->placeholder(__('messages.setting.enter_address'))
                            ->required(),
                        Select::make('currency_icon')
                            ->label(__('messages.setting.currency_icon'))
                            ->options(currencies())
                            ->optionsLimit(count(currencies()))
                            ->searchable()
                            ->required()
                            ->native(false),
                        Select::make('timezone')
                            ->label(__('messages.setting.timezone'))
                            ->searchable()
                            ->options(self::getTimeZone())
                            ->optionsLimit(count(self::getTimeZone()))
                            ->default(timezone())
                            ->native(false)
                            ->required(),
                        TextInput::make('invoice_customer_prefix')
                            ->label(__('messages.setting.invoice_customer_prefix'))
                            ->placeholder(__('messages.setting.enter_invoice_customer_prefix'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('agent_number_prefix')
                            ->label(__('messages.setting.agent_number_prefix'))
                            ->placeholder(__('messages.setting.enter_agent_number_prefix'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('insurance_customer_prefix')
                            ->label(__('messages.setting.insurance_customer_prefix'))
                            ->placeholder(__('messages.setting.enter_insurance_customer_prefix'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('claim_number_prefix')
                            ->label(__('messages.setting.claim_number_prefix'))
                            ->placeholder(__('messages.setting.enter_claim_number_prefix'))
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),
            ])->statePath('data');
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('messages.common.save')) // Using common save
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value], ['tenant_id' => Auth::user()->tenant_id]);
        }

        notify(__('messages.setting.settings_updated_successfully'));

        $this->redirect(static::getUrl());
    }
}
