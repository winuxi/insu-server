<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\SubscriptionResource\Pages;
use App\Models\Subscription;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::BUSINESS_MANAGEMENT->label();
    }

    public static function getModelLabel(): string
    {
        return __('messages.subscription.subscription');
    }

    public static function getPluralModelLabel(): string
    {
        if (Auth::user()->hasRole(User::SUPER_ADMIN)) {
            return __('messages.subscription.subscriptions');
        } else {
            return __('messages.subscription.transactions');
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                if (Auth::user()->hasRole(User::SUPER_ADMIN)) {
                    return $query->withOutGlobalScopes();
                }

                return $query;
            })
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('messages.subscription.user'))
                    ->searchable()
                    ->hidden(Auth::user()->hasRole(User::ADMIN))
                    ->sortable(),
                TextColumn::make('plan.title')
                    ->label(__('messages.subscription.plan'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label(__('messages.subscription.amount'))
                    ->prefix(currencySymbol())
                    ->searchable()
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->label(__('messages.subscription.payment_method'))
                    ->formatStateUsing(fn ($state) => Str::ucfirst($state))
                    ->color(fn ($state) => Subscription::paymentMethodColor($state))
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->label(__('messages.subscription.payment_status'))
                    ->formatStateUsing(fn ($state) => Subscription::PAYMENT_STATUS[$state]) // Assuming internal or localized if displayed
                    ->color(fn ($state) => Subscription::paymentStatusColor($state))
                    ->badge()
                    ->visible(Auth::user()->hasRole(User::ADMIN))
                    ->searchable()
                    ->sortable(),
                ViewColumn::make('payment_status')->view('filament.tables.columns.status-switcher')->hidden(Auth::user()->hasRole(User::ADMIN)),
                TextColumn::make('is_active')
                    ->label(__('messages.subscription.active'))
                    ->formatStateUsing(function ($state) {
                        return Subscription::STATUSES[$state]; // Assuming internal or localized if displayed
                    })
                    ->color(fn ($state) => Subscription::statusColor($state))
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label(__('messages.subscription.start_date'))
                    ->date()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label(__('messages.subscription.end_date'))
                    ->searchable()
                    ->date()
                    ->sortable(),
            ])
            ->recordAction(null)
            ->actionsColumnLabel(function () {
                if (Auth::user()->hasRole(User::SUPER_ADMIN)) {
                    return __('messages.user.actions');
                }

                return null;
            })
            ->paginated([10, 25, 50, 100])
            ->actions([
                EditAction::make()
                    ->form([
                        DatePicker::make('start_date')
                            ->native()
                            ->minDate(today())
                            ->label(__('messages.subscription.start_date')),
                        DatePicker::make('end_date')
                            ->native()
                            ->minDate(today())
                            ->label(__('messages.subscription.end_date')),
                    ])
                    ->modalWidth('sm')
                    ->iconButton()
                    ->successNotificationTitle(__('messages.subscription.subscription_updated_successfully'))
                    ->visible(Auth::user()->hasRole(User::SUPER_ADMIN)),
                DeleteAction::make()
                    ->visible(Auth::user()->hasRole(User::SUPER_ADMIN))
                    ->iconButton()
                    ->successNotificationTitle(__('messages.subscription.subscription_deleted_successfully')),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSubscriptions::route('/'),
        ];
    }
}
