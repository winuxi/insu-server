<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Models\Role;
use App\Models\User;
use Filament\Forms\Components\Checkbox;
// use Spatie\Permission\Models\Role;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth; // Added Auth facade
use Spatie\Permission\Models\Permission;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function getNavigationGroup(): ?string
    {
        return \App\Enums\NavigationGroup::SYSTEM_CONFIGURATION->label();
    }

    public static function getModelLabel(): string
    {
        return __('messages.role.role');
    }

    protected static ?int $navigationSort = 12;

    public static function getGroupedPermissions(): array
    {
        return Permission::all()
            ->groupBy(function ($permission) {
                $groupName = explode('_', $permission->name)[1] ?? 'general'; // Default to 'general'

                return ucfirst(str_replace('_', ' ', $groupName)).' '.__('messages.role.management_suffix'); // Localize " Management"
            })
            ->map(function ($group) {
                return $group->mapWithKeys(function ($permission) {
                    return [
                        "permissions.{$permission->name}" => Checkbox::make("permissions.{$permission->name}")
                            ->label(ucwords(str_replace('_', ' ', $permission->name))),
                    ];
                })->toArray();
            })
            ->toArray();
    }

    public static function form(Form $form): Form
    {
        $groupedPermissions = self::getGroupedPermissions();

        return $form
            ->schema([
                Section::make(__('messages.role.create_role_and_permissions'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('messages.role.role_title'))
                            ->placeholder(__('messages.role.enter_role_title'))
                            ->disabled(function ($record, $operation) {
                                if ($operation === 'edit') {
                                    return $record->name === User::ADMIN || $record->name === User::CUSTOMER || $record->name === User::AGENT || $record->name === User::SUPER_ADMIN;
                                }
                            })
                            ->maxLength(255)
                            // ->unique('roles', 'name', ignoreRecord: true)
                            ->required(),
                        Grid::make(3)
                            ->schema(
                                collect($groupedPermissions)->map(function ($permissions, $group) {
                                    // Group name is already localized from getGroupedPermissions()
                                    return Fieldset::make($group)
                                        ->schema(array_values($permissions));
                                })->toArray()
                            ),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('name', '!=', User::ADMIN)->where('tenant_id', Auth::user()->tenant_id))
            ->columns([
                TextColumn::make('name')->sortable()->searchable()->label(__('messages.role.role_title')),
            ])
            ->filters([
                //
            ])
            ->actionsColumnLabel(__('messages.user.actions')) // Reusing from user or common
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton()
                    ->hidden(fn (Role $record): bool => $record->name === User::ADMIN || $record->name === User::CUSTOMER || $record->name === User::AGENT || $record->name === User::SUPER_ADMIN)
                    ->action(function (Role $record) {
                        if ($record->name === User::ADMIN || $record->name === User::CUSTOMER || $record->name === User::AGENT || $record->name === User::SUPER_ADMIN) {
                            return notify(__('messages.role.cannot_delete_role'), 'warning');
                        }

                        $record->delete();

                        return notify(__('messages.role.role_and_permissions_deleted_successfully'));
                    }),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
