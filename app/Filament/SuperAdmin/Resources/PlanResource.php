<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\PlanResource\Pages;
use App\Models\Plan;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::BUSINESS_MANAGEMENT->label();
    }

    public static function getModelLabel(): string
    {
        return __('messages.plans.title');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->label(__('messages.plans.plan_title'))
                            ->placeholder(__('messages.plans.plan_title'))
                            ->maxLength(255)
                            ->required(),
                        Select::make('interval')
                            ->label(__('messages.plans.interval'))
                            ->options(self::$model::INTERVALS)
                            ->placeholder(__('messages.plans.interval'))
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('amount')
                            ->label(__('messages.plans.amount'))
                            ->placeholder(__('messages.plans.amount'))
                            ->numeric()
                            ->minValue(0)
                            ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                            ->required(),
                        TextInput::make('user_limit')
                            ->label(__('messages.plans.user_limit'))
                            ->placeholder(__('messages.plans.user_limit'))
                            ->numeric()
                            ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                            ->required(),
                        TextInput::make('customer_limit')
                            ->label(__('messages.plans.customer_limit'))
                            ->placeholder(__('messages.plans.customer_limit'))
                            ->numeric()
                            ->minValue(0)
                            ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                            ->required(),
                        TextInput::make('agent_limit')
                            ->label(__('messages.plans.agent_limit'))
                            ->placeholder(__('messages.plans.agent_limit'))
                            ->numeric()
                            ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                            ->minValue(0)
                            ->required(),
                        Textarea::make('short_description')
                            ->label(__('messages.plans.short_description'))
                            ->placeholder(__('messages.plans.short_description'))
                            ->maxLength(255)
                            ->required(),
                        Toggle::make('is_show_history')
                            ->label(__('messages.plans.is_show_history'))
                            ->inlineLabel()
                            ->live()
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('messages.plans.plan_title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('interval')
                    ->label(__('messages.plans.interval'))
                    ->searchable()
                    ->badge()
                    ->formatStateUsing(fn ($state) => self::$model::INTERVALS[$state])
                    ->color(fn ($state) => self::$model::intervalColor($state))
                    ->sortable(),
                TextColumn::make('amount')
                    ->label(__('messages.plans.amount'))
                    ->prefix(currencySymbol())
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user_limit')
                    ->label(__('messages.plans.user_limit'))
                    ->searchable()
                    ->badge()
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('customer_limit')
                    ->label(__('messages.plans.customer_limit'))
                    ->searchable()
                    ->badge()
                    ->alignCenter()
                    ->sortable(),
                TextColumn::make('agent_limit')
                    ->label(__('messages.plans.agent_limit'))
                    ->searchable()
                    ->badge()
                    ->alignCenter()
                    ->sortable(),
                ViewColumn::make('is_popular')
                    ->label(__('messages.plans.most_popular'))
                    ->alignCenter()
                    ->view('tables.columns.plan.is-popular'),
            ])
            ->recordUrl(null)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->successNotificationTitle(__('messages.plans.plan_deleted_successfully')),
            ])
            ->paginated([10, 25, 50, 100])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }
}
