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

class PaymentSetting extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function getNavigationGroup(): string
    {
        return NavigationGroup::SYSTEM_SETTINGS->label();
    }

    protected static ?int $navigationSort = 108;

    protected static ?string $title = 'Payment';

    protected static string $view = 'filament.super-admin.pages.payment-setting';

    public static function getNavigationLabel(): string
    {
        return __('messages.payment_setting.navigation_label');
    }

    public function getTitle(): string
    {
        return __('messages.payment_setting.title');
    }

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
                Section::make(__('messages.payment_setting.manual_payment'))
                    ->collapsible()
                    ->schema([
                        ToggleButtons::make('is_manual_enabled')
                            ->label(__('messages.payment_setting.enable_manual'))
                            ->colors([
                                1 => 'success',
                                0 => 'danger',
                            ])
                            ->grouped()
                            ->options([
                                1 => __('messages.payment_setting.enabled'),
                                0 => __('messages.payment_setting.disabled'),
                            ])
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),
                Section::make(__('messages.payment_setting.stripe_payment'))
                    ->collapsible()
                    ->schema([
                        ToggleButtons::make('stripe_enabled')
                            ->label(__('messages.payment_setting.enable_stripe'))
                            ->required()
                            ->colors([
                                1 => 'success',
                                0 => 'danger',
                            ])
                            ->grouped()
                            ->options([
                                1 => __('messages.payment_setting.enabled'),
                                0 => __('messages.payment_setting.disabled'),
                            ])
                            ->hiddenLabel()
                            ->columnSpanFull()
                            ->hiddenLabel(),
                        TextInput::make('stripe_key')
                            ->required()
                            ->visible(fn ($get) => $get('stripe_enabled') == 1)
                            ->placeholder(__('messages.payment_setting.stripe_key'))
                            ->label(__('messages.payment_setting.stripe_key')),
                        TextInput::make('stripe_secret')
                            ->required()
                            ->placeholder(__('messages.payment_setting.stripe_secret'))
                            ->visible(fn ($get) => $get('stripe_enabled') == 1)
                            ->label(__('messages.payment_setting.stripe_secret')),
                    ])->columns(2),
                Section::make(__('messages.payment_setting.paypal_payment'))
                    ->collapsible()
                    ->schema([
                        ToggleButtons::make('paypal_enabled')
                            ->label(__('messages.payment_setting.enable_paypal'))
                            ->required()
                            ->colors([
                                1 => 'success',
                                0 => 'danger',
                            ])
                            ->grouped()
                            ->options([
                                1 => __('messages.payment_setting.enabled'),
                                0 => __('messages.payment_setting.disabled'),
                            ]),
                        ToggleButtons::make('paypal_mode')
                            ->required()
                            ->visible(fn ($get) => $get('paypal_enabled') == 1)
                            ->colors([
                                'sandbox' => 'warning',
                                'live' => 'success',
                            ])
                            ->label(__('messages.payment_setting.paypal_mode'))
                            ->options([
                                'sandbox' => __('messages.payment_setting.sandbox'),
                                'live' => __('messages.payment_setting.live'),
                            ])
                            ->inline()
                            ->columns(2)
                            ->label(__('messages.payment_setting.paypal_mode')),
                        TextInput::make('paypal_client')
                            ->visible(fn ($get) => $get('paypal_enabled') == 1)
                            ->required()
                            ->placeholder(__('messages.payment_setting.paypal_client'))
                            ->label(__('messages.payment_setting.paypal_client')),
                        TextInput::make('paypal_secret')
                            ->visible(fn ($get) => $get('paypal_enabled') == 1)
                            ->required()
                            ->placeholder(__('messages.payment_setting.paypal_secret'))
                            ->label(__('messages.payment_setting.paypal_secret')),

                    ])->columns(2),
            ])->live()->statePath('data')->columns(3);
    }

    public function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('messages.payment_setting.save'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();
        if (! empty($data['paypal_enabled'])) {
            if (empty($data['paypal_client'])) {
                notify(__('messages.payment_setting.please_add_paypal_client'), 'danger');
                $this->redirect(static::getUrl());

                return;
            }
            if (empty($data['paypal_secret'])) {
                notify(__('messages.payment_setting.please_add_paypal_secret'), 'danger');
                $this->redirect(static::getUrl());

                return;
            }
        }

        if (! empty($data['stripe_enabled'])) {
            if (empty($data['stripe_key'])) {
                $this->addError('stripe_key', __('messages.payment_setting.please_add_stripe_key'));
                notify(__('messages.payment_setting.please_add_stripe_key'), 'danger');
                $this->redirect(static::getUrl());

                return;
            }
            if (empty($data['stripe_secret'])) {
                $this->addError('stripe_secret', __('messages.payment_setting.please_add_stripe_secret'));
                notify(__('messages.payment_setting.please_add_stripe_secret'), 'danger');
                $this->redirect(static::getUrl());

                return;
            }
        }

        foreach ($data as $key => $value) {
            if (! is_null($value)) {
                SuperAdminSetting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        notify(__('messages.payment_setting.updated_successfully'));

        $this->redirect(static::getUrl());
    }
}
