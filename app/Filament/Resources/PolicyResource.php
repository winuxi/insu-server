<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolicyResource\Pages;
use App\Models\Duration;
use App\Models\Policy;
use App\Models\PolicySubType;
use App\Models\User;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table; // Added Auth facade
use Illuminate\Support\Facades\Auth;

class PolicyResource extends Resource
{
    protected static ?string $model = Policy::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::BUSINESS_MANAGEMENT->label();
    }

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make(__('messages.policy.policy_information'))
                        ->schema([
                            TextInput::make('title')
                                ->label(__('messages.policy.title'))
                                ->placeholder(__('messages.policy.enter_policy_title'))
                                ->required()
                                ->maxLength(255),
                            Select::make('policy_type_id')
                                ->label(__('messages.policy.policy_type'))
                                ->relationship('policyType', 'name')
                                ->preload()
                                ->native(false)
                                ->searchable()
                                ->live()
                                ->required()
                                ->placeholder(__('messages.policy.select_policy_type'))
                                ->afterStateUpdated(fn ($set) => $set('policy_sub_type_id', null)),
                            Select::make('policy_sub_type_id')
                                ->label(__('messages.policy.policy_sub_type'))
                                ->options(function ($get, $set) {
                                    $policyTypeId = $get('policy_type_id');

                                    $policyType = PolicySubType::where('policy_type_id', $policyTypeId)
                                        ->pluck('name', 'id');

                                    $set('policySubType', $policyType);

                                    return $get('policySubType');
                                })
                                ->disabled(fn ($get) => empty($get('policy_type_id')))
                                ->live()
                                ->required()
                                ->preload()
                                ->native(false)
                                ->searchable()
                                ->placeholder(__('messages.policy.select_policy_type')), // Reusing placeholder
                            Group::make([
                                Select::make('coverage_type')
                                    ->label(__('messages.policy.coverage_type'))
                                    ->options(Policy::COVERAGE_TYPES) // Assuming these are internal or already localized if displayed
                                    ->native(false)
                                    ->searchable(),
                                TextInput::make('total_insured_person')
                                    ->label(__('messages.policy.total_insured_person'))
                                    ->placeholder(__('messages.policy.enter_total_insured_person'))
                                    ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                                    ->numeric(),
                            ])->columns(2),
                            Select::make('liability_risk')
                                ->label(__('messages.policy.liability_risk'))
                                ->options(Policy::LIABILITY_RISKS) // Assuming these are internal or already localized if displayed
                                ->required()
                                ->native(false)
                                ->searchable(),
                            TextInput::make('sum_assured')
                                ->label(__('messages.policy.sum_assured'))
                                ->numeric()
                                ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                                ->required()
                                ->placeholder(__('messages.policy.enter_sum_assured')),
                            Select::make('policy_document_type_id')
                                ->label(__('messages.policy.policy_document_type'))
                                ->relationship('documentType', 'name')
                                ->preload()
                                ->required()
                                ->native(false)
                                ->searchable(),
                            Select::make('claim_document_type_id')
                                ->label(__('messages.policy.claim_document_type'))
                                ->relationship('documentType', 'name')
                                ->preload()
                                ->native(false)
                                ->required()
                                ->searchable(),
                            Select::make('tax_id')
                                ->label(__('messages.policy.tax'))
                                ->relationship('tax', 'tax')
                                ->preload()
                                ->native(false)
                                ->required()
                                ->searchable(),
                        ])->columns(2),
                    Wizard\Step::make(__('messages.policy.policy_pricing'))
                        ->schema([
                            Repeater::make('pricing')
                                ->hint(function () {
                                    return new \Illuminate\Support\HtmlString(
                                        '
                                        <div class="flex items-start gap-2 p-3 bg-blue-50 ring-1 ring-info-900 rounded-lg">
                                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div class="text-sm">
                                                <p class="text-blue-800 mt-1"><strong>'.__('messages.insurance_payment.form.hint.info').'</strong> : '.__('messages.policy.hint_info').'</p>
                                            </div>
                                        </div>
                                        '
                                    );
                                })
                                ->hintColor('info')
                                ->relationship('policyPricings')
                                ->hiddenLabel()
                                ->itemLabel(fn (array $state): ?string => isset($state['duration_terms']) ? "{$state['duration_terms']}" : null
                                )
                                ->collapsed(false)
                                ->cloneable(false)
                                ->afterStateHydrated(static function (Repeater $component, ?array $state, $operation): void {
                                    $duration = array_map(function ($item) {
                                        $item['duration_id'] = $item['id'];

                                        return $item;
                                    }, Duration::all()->toArray());

                                    if ($operation !== 'create') {
                                        $durationsById = collect($duration)->keyBy('duration_id')->toArray();
                                        $merged = [];
                                        $usedDurationIds = [];

                                        foreach ($state as $uuid => $record) {
                                            $durationData = $durationsById[$record['duration_id']] ?? [];
                                            $merged[$uuid] = array_merge($durationData, $record);
                                            $usedDurationIds[] = $record['duration_id'];
                                        }

                                        $unusedDurations = array_filter($duration, function ($d) use ($usedDurationIds) {
                                            return ! in_array($d['duration_id'], $usedDurationIds);
                                        });

                                        foreach ($unusedDurations as $newDuration) {
                                            $uuid = $component->generateUuid();
                                            $merged[$uuid] = $newDuration;
                                        }
                                    } else {
                                        $merged = [];
                                        foreach ($duration as $durationItem) {
                                            $uuid = $component->generateUuid();
                                            $merged[$uuid] = $durationItem;
                                        }
                                    }

                                    $component->state($merged);
                                })
                                ->schema([
                                    Group::make()
                                        ->schema([
                                            Grid::make(12)
                                                ->schema([
                                                    Toggle::make('is_selected')
                                                        ->label(__('messages.policy.toggle_label'))
                                                        ->helperText(__('messages.policy.toggle_helper'))
                                                        ->live(false)
                                                        ->dehydrated(false)
                                                        ->onColor('success')
                                                        ->offColor('gray')
                                                        ->columnSpan(12)
                                                        ->afterStateHydrated(function (Toggle $component, $state, $get) {
                                                            // Auto-enable toggle if price/amount exists when editing
                                                            $price = $get('price');
                                                            if (! empty($price) && $price > 0) {
                                                                $component->state(true);
                                                            }
                                                        })
                                                        ->default(function ($get) {
                                                            // Set default based on existing price
                                                            $price = $get('price');

                                                            return ! empty($price) && $price > 0;
                                                        }),

                                                    Hidden::make('duration_id'),

                                                    // Duration Information Card
                                                    Card::make()
                                                        ->schema([
                                                            Placeholder::make('duration_info')
                                                                ->hiddenLabel()
                                                                ->dehydrated(false)
                                                                ->content(function ($get) {
                                                                    $terms = $get('duration_terms') ?? 'N/A';
                                                                    $months = $get('duration_in_months') ?? 'N/A';

                                                                    return new \Illuminate\Support\HtmlString(
                                                                        '<div class="space-y-3 sm:space-y-4">
                                                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 sm:gap-4">
                                                                                <span class="text-sm font-medium text-gray-700 dark:text-gray-400">'.__('messages.duration.duration_terms').':</span>
                                                                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-200">'.$terms.'</span>
                                                                            </div>
                                                                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 sm:gap-4">
                                                                                <span class="text-sm font-medium text-gray-700 dark:text-gray-400">'.__('messages.duration.duration_in_months').':</span>
                                                                                <span class="text-sm font-semibold text-gray-900 dark:text-gray-200">'.$months.'</span>
                                                                            </div>
                                                                        </div>'
                                                                    );
                                                                }),
                                                        ])
                                                        ->columnSpan(6)
                                                        ->extraAttributes([
                                                            'class' => 'bg-gray-50 border-gray-200',
                                                        ]),

                                                    // Pricing Input with Enhanced Design
                                                    Card::make()
                                                        ->schema([
                                                            TextInput::make('price')
                                                                ->label(__('messages.insurance_payment.form.amount'))
                                                                ->placeholder(__('messages.insurance_payment.form.amount'))
                                                                ->required(fn ($get) => $get('is_selected') == true)
                                                                ->numeric()
                                                                ->minValue(0)
                                                                ->step(0.01)
                                                                ->prefix('$')
                                                                ->extraInputAttributes([
                                                                    'oninput' => "this.value = this.value.replace(/[e\-]/gi, '')",
                                                                    'class' => 'text-lg font-semibold',
                                                                ])
                                                                ->rules(['regex:/^\d+(\.\d{1,2})?$/'])
                                                                ->validationMessages([
                                                                    'regex' => 'Please enter a valid price (e.g., 99.99)',
                                                                ]),
                                                        ])
                                                        ->disabled(fn ($get) => $get('is_selected') != true)
                                                        ->columnSpan(6)
                                                        ->extraAttributes([
                                                            'class' => 'bg-green-50 border-green-200',
                                                        ]),

                                                    // Hidden fields for readonly data
                                                    Hidden::make('duration_terms'),
                                                    Hidden::make('duration_in_months'),
                                                ]),
                                        ])
                                        ->extraAttributes(function ($get) {
                                            $isSelected = $get('is_selected');

                                            return [
                                                'class' => $isSelected
                                                    ? 'border-green-300 bg-green-50/30 transition-all duration-200'
                                                    : 'border-gray-200 bg-gray-50/50 opacity-75 transition-all duration-200',
                                            ];
                                        }),
                                ])
                                ->addable(false)
                                ->deletable(false)
                                ->reorderable(false)
                                ->defaultItems(0)
                                ->saveRelationshipsUsing(function (\Illuminate\Database\Eloquent\Model $record, array $state) {
                                    // Filter only selected durations with price > 0
                                    $filtered = collect($state)->filter(function ($item) {
                                        return ! empty($item['price']) && $item['price'] > 0 && ! empty($item['is_selected']);
                                    });
                                    try {
                                        $record->policyPricings()->delete();
                                    } catch (\Exception $e) {
                                        Notification::make()
                                            ->title(__('messages.policy.notification_delete_failed'))
                                            ->body(__('messages.policy.notification_update_success'))
                                            ->danger()
                                            ->send();

                                        return;
                                    }

                                    foreach ($filtered as $item) {
                                        $record->policyPricings()->create([
                                            'duration_id' => $item['duration_id'],
                                            'price' => $item['price'],
                                        ]);
                                    }
                                }),
                        ])->live(),
                    Wizard\Step::make(__('messages.policy.policy_terms'))
                        ->schema([
                            RichEditor::make('description')
                                ->label(__('messages.policy.policy_description'))
                                ->placeholder(__('messages.policy.enter_policy_description'))
                                ->maxLength(65535)
                                ->required(),
                            RichEditor::make('term')
                                ->label(__('messages.policy.policy_terms'))
                                ->placeholder(__('messages.policy.enter_policy_terms'))
                                ->maxLength(65535)
                                ->required(),
                        ]),
                ])->persistStepInQueryString(),
            ])->columns(1);
    }

    public static function getModelLabel(): string
    {
        return __('messages.policy.policy');
    }

    public static function getPluralModelLabel(): string
    {
        return __('messages.policy.policies');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                if (Auth::user()->hasRole(User::ADMIN)) {
                    return $query->where('user_id', Auth::id());
                }

                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('messages.policy.title'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('policyType.name')
                    ->label(__('messages.policy.policy_type'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('policySubType.name')
                    ->label(__('messages.policy.policy_sub_type'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('coverage_type')
                    ->label(__('messages.policy.coverage_type'))
                    ->searchable()
                    ->formatStateUsing(fn ($state) => self::$model::COVERAGE_TYPES[$state]) // Assuming internal or localized
                    ->sortable(),
                Tables\Columns\TextColumn::make('liability_risk')
                    ->label(__('messages.policy.liability_risk'))
                    ->formatStateUsing(fn ($state) => self::$model::LIABILITY_RISKS[$state]) // Assuming internal or localized
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sum_assured')
                    ->label(__('messages.policy.sum_assured'))
                    ->prefix(currencySymbol()) // Dynamic
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100])
            ->recordUrl(null)
            ->filters([
                //
            ])
            ->actionsColumnLabel(__('messages.user.actions'))
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton()
                    ->successNotificationTitle(__('messages.policy.policy_deleted_successfully')),
            ])
            ->paginated([10, 25, 50, 100])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPolicies::route('/'),
            'create' => Pages\CreatePolicy::route('/create'),
            'edit' => Pages\EditPolicy::route('/{record}/edit'),
        ];
    }
}
