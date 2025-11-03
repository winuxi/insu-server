<?php

namespace App\Livewire\Insurance;

use App\Models\InsuranceInsured as InsuredModel;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Insured extends Component implements HasForms, HasTable
{
    use \Filament\Forms\Concerns\InteractsWithForms,
        \Filament\Tables\Concerns\InteractsWithTable;

    public $insuranceId;

    public function mount($id)
    {
        $this->insuranceId = $id;
    }

    public function table(Table $table): Table
    {

        return $table
            ->heading(__('messages.insurance_insured.insured_heading'))
            ->query(InsuredModel::query()->where('insurance_id', $this->insuranceId))
            ->headerActions([CreateAction::make()
                ->model(InsuredModel::class)
                ->createAnother(false)
                ->form($this->createForm())
                ->visible(function () {
                    if (Auth::user()->hasRole(User::ADMIN)) {
                        return true;
                    } elseif (Auth::user()->hasRole(User::AGENT) && Auth::user()->hasTenantPermission('create_insured_detail')) {
                        return true;
                    }
                })
                ->successNotificationTitle(__('messages.insurance_insured.notification.created_successfully'))
                ->modalHeading(__('messages.insurance_insured.modal.new_insured_heading'))
                ->label(__('messages.insurance_insured.button.add_insured')),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100])
            ->columns([
                TextColumn::make('name')
                    ->label(__('messages.insurance_insured.table.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('dob')
                    ->label(__('messages.insurance_insured.table.dob'))
                    ->date()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('age')
                    ->label(__('messages.insurance_insured.table.age'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('gender')
                    ->label(__('messages.insurance_insured.table.gender'))
                    ->formatStateUsing(fn ($state) => User::GENDERS[$state])
                    ->sortable()
                    ->searchable(),
                TextColumn::make('blood_group')
                    ->label(__('messages.insurance_insured.table.blood_group'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('height')
                    ->label(__('messages.insurance_insured.table.height'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('weight')
                    ->label(__('messages.insurance_insured.table.weight'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('relation')
                    ->label(__('messages.insurance_insured.table.relation'))
                    ->sortable()
                    ->searchable(),
            ])
            ->actionsColumnLabel(__('messages.insurance_insured.table.actions'))
            ->actions([
                DeleteAction::make()
                    ->action(function (InsuredModel $record) {
                        $record->delete();

                        return notify(__('messages.insurance_insured.notification.deleted_successfully'));
                    })
                    ->visible(function () {
                        if (Auth::user()->hasRole(User::ADMIN)) {
                            return true;
                        } elseif (Auth::user()->hasRole(User::AGENT) && Auth::user()->hasTenantPermission('delete_insured_detail')) {
                            return true;
                        }
                    })
                    ->iconButton(),
            ]);
    }

    public function createForm()
    {
        return [
            Group::make([
                Hidden::make('insurance_id')
                    ->default($this->insuranceId),
                TextInput::make('name')
                    ->label(__('messages.insurance_insured.form.name'))
                    ->placeholder(__('messages.insurance_insured.form.placeholder.name'))
                    ->required()
                    ->maxLength(255),
                DatePicker::make('dob')
                    ->label(__('messages.insurance_insured.form.dob'))
                    ->placeholder(__('messages.insurance_insured.form.placeholder.dob'))
                    ->required()
                    ->native(false)
                    ->maxDate(today()->subDay()),
                TextInput::make('age')
                    ->label(__('messages.insurance_insured.form.age'))
                    ->placeholder(__('messages.insurance_insured.form.placeholder.age'))
                    ->numeric()
                    ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                    ->required(),
                Select::make('gender')
                    ->label(__('messages.insurance_insured.form.gender'))
                    ->options(User::GENDERS)
                    ->required()
                    ->native(false),
                TextInput::make('blood_group')
                    ->label(__('messages.insurance_insured.form.blood_group'))
                    ->placeholder(__('messages.insurance_insured.form.placeholder.blood_group'))
                    ->extraAlpineAttributes(['oninput' => "this.value = this.value.replace(/[^A-Za-z+-]/g, '')"])
                    ->required()
                    ->maxLength(15),
                TextInput::make('height')
                    ->label(__('messages.insurance_insured.form.height'))
                    ->placeholder(__('messages.insurance_insured.form.placeholder.height'))
                    ->required()
                    ->maxLength(10),
                TextInput::make('weight')
                    ->label(__('messages.insurance_insured.form.weight'))
                    ->placeholder(__('messages.insurance_insured.form.placeholder.weight'))
                    ->required()
                    ->maxLength(10),
                TextInput::make('relation')
                    ->label(__('messages.insurance_insured.form.relation'))
                    ->placeholder(__('messages.insurance_insured.form.placeholder.relation'))
                    ->required()
                    ->maxLength(50),
            ])
                ->columns(2),
        ];
    }

    public function render()
    {
        return <<<'HTML'
        <div>
          {{ $this->table }}
        </div>
        HTML;
    }
}
