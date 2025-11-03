<?php

namespace App\Livewire\Insurance;

use App\Models\InsuranceNominee as NomineeModel;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Nominee extends Component implements HasForms, HasTable
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
            ->heading(__('messages.insurance_nominee.nominees_heading'))
            ->query(NomineeModel::query()->where('insurance_id', $this->insuranceId))
            ->headerActions([
                CreateAction::make()
                    ->model(NomineeModel::class)
                    ->createAnother(false)
                    ->form($this->createForm())
                    ->visible(function () {
                        if (Auth::user()->hasRole(User::ADMIN)) {
                            return true;
                        } elseif (Auth::user()->hasRole(User::AGENT) && Auth::user()->hasTenantPermission('create_nominee')) {
                            return true;
                        }
                    })
                    ->successNotificationTitle(__('messages.insurance_nominee.notification.created_successfully'))
                    ->modalHeading(__('messages.insurance_nominee.modal.new_nominee_heading'))
                    ->label(__('messages.insurance_nominee.button.add_nominee')),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100])
            ->columns([
                TextColumn::make('name')
                    ->label(__('messages.insurance_nominee.table.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('dob')
                    ->label(__('messages.insurance_nominee.table.dob'))
                    ->date()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('percentage')
                    ->label(__('messages.insurance_nominee.table.percentage'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('relation')
                    ->label(__('messages.insurance_nominee.table.relation'))
                    ->sortable()
                    ->searchable(),
            ])
            ->actionsColumnLabel(__('messages.insurance_nominee.table.actions'))
            ->actions([
                DeleteAction::make()
                    ->action(function ($record) {
                        $record->delete();

                        return notify(__('messages.insurance_nominee.notification.deleted_successfully'));
                    })
                    ->visible(function () {
                        if (Auth::user()->hasRole(User::ADMIN)) {
                            return true;
                        } elseif (Auth::user()->hasRole(User::AGENT) && Auth::user()->hasTenantPermission('delete_nominee')) {
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
                    ->label(__('messages.insurance_nominee.form.name'))
                    ->placeholder(__('messages.insurance_nominee.form.placeholder.name'))
                    ->required()
                    ->maxLength(255),
                DatePicker::make('dob')
                    ->label(__('messages.insurance_nominee.form.dob'))
                    ->placeholder(__('messages.insurance_nominee.form.placeholder.dob'))
                    ->required()
                    ->native(false)
                    ->maxDate(today()->subDay()),
                TextInput::make('percentage')
                    ->label(__('messages.insurance_nominee.form.percentage'))
                    ->placeholder(__('messages.insurance_nominee.form.placeholder.percentage'))
                    ->numeric()
                    ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                    ->required(),
                TextInput::make('relation')
                    ->label(__('messages.insurance_nominee.form.relation'))
                    ->placeholder(__('messages.insurance_nominee.form.placeholder.relation'))
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
