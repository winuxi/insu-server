<?php

namespace App\Livewire\Insurance;

use App\Models\Installment;
use App\Models\InsurancePayment as PaymentModel;
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

class Payment extends Component implements HasForms, HasTable
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
            ->heading(__('messages.insurance_payment.payments_heading'))
            ->query(PaymentModel::query()->where('insurance_id', $this->insuranceId))
            ->headerActions([
                CreateAction::make()
                    ->modalWidth('sm')
                    ->model(PaymentModel::class)
                    ->createAnother(false)
                    ->form($this->createForm())
                    ->successNotificationTitle(__('messages.insurance_payment.notification.created_successfully'))
                    ->modalHeading(__('messages.insurance_payment.modal.new_payment_heading'))
                    ->label(__('messages.insurance_payment.button.add_payment')),
            ])
            ->defaultSort('id', 'desc')
            ->paginated([10, 25, 50, 100])
            ->columns([
                TextColumn::make('date')
                    ->label(__('messages.insurance_payment.table.payment_date'))
                    ->date()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amount')
                    ->label(__('messages.insurance_payment.table.amount'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label(__('messages.insurance_payment.table.status'))
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => PaymentModel::statusColor($state))
                    ->formatStateUsing(fn ($state) => PaymentModel::STATUSES[$state])
                    ->searchable(),
                TextColumn::make('installment_id')
                    ->label(__('messages.insurance_payment.table.installment'))
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn ($state) => Installment::find($state)->order_no.' - '.currencySymbol().Installment::find($state)->amount),
            ])
            ->actionsColumnLabel(__('messages.insurance_payment.table.actions'))
            ->actions([
                DeleteAction::make()
                    ->action(function ($record) {
                        $record->delete();

                        return notify(__('messages.insurance_payment.notification.deleted_successfully'));
                    })
                    ->iconButton(),
            ]);
    }

    public function createForm()
    {
        $usedInstallmentIds = PaymentModel::pluck('installment_id')
            ->where('status', '!=', PaymentModel::PAID)
            ->filter() // removes nulls
            ->unique() // (optional) ensures no duplicates
            ->values() // resets the array keys
            ->toArray();

        $installmentList = Installment::where('insurance_id', $this->insuranceId)
            ->whereNotIn('id', $usedInstallmentIds)
            ->get()
            ->mapWithKeys(fn ($i) => [
                $i->id => $i->order_no.' - '.currencySymbol().$i->amount,
            ])
            ->toArray();

        $default = key($installmentList);

        return [
            Group::make([
                Hidden::make('insurance_id')
                    ->default($this->insuranceId),
                DatePicker::make('date')
                    ->label(__('messages.insurance_payment.form.payment_date'))
                    ->required()
                    ->default(today())
                    ->native(false)
                    ->maxDate(today()),
                TextInput::make('amount')
                    ->label(__('messages.insurance_payment.form.amount'))
                    ->numeric()
                    ->extraInputAttributes(['oninput' => "this.value = this.value.replace(/[e\-]/gi, '')"])
                    ->default($default ? Installment::find($default)->amount : null)
                    ->readOnly(Auth::user()->hasRole(User::CUSTOMER) || Auth::user()->hasRole(User::AGENT) ? true : false)
                    ->placeholder(__('messages.insurance_payment.form.placeholder.amount'))
                    ->required(),
                Select::make('status')
                    ->label(__('messages.insurance_payment.form.status'))
                    ->options(fn () => Auth::user()->hasRole(User::CUSTOMER) ? [PaymentModel::PENDING => PaymentModel::STATUSES[PaymentModel::PENDING]] : PaymentModel::STATUSES)
                    ->default(fn () => Auth::user()->hasRole(User::CUSTOMER) ? PaymentModel::PENDING : null)
                    ->disableOptionWhen(fn ($value) => Auth::user()->hasRole(User::CUSTOMER) ? $value != PaymentModel::PENDING : false)
                    ->native(false)
                    ->required(),
                Select::make('installment_id')
                    ->label(__('messages.insurance_payment.form.installment'))
                    ->options($installmentList)
                    ->native(false)
                    ->placeholder(__('messages.insurance_payment.form.placeholder.installment'))
                    ->disabled(empty($installmentList))
                    ->hint(function () use ($installmentList, $default) {
                        return new \Illuminate\Support\HtmlString(
                            '<div><strong>'.__('messages.insurance_payment.form.hint.info').':</strong> '.($installmentList[$default] ?? __('messages.insurance_payment.form.hint.na')).' '.__('messages.insurance_payment.form.hint.to_pay').'</div>'
                        );
                    })
                    ->hintColor('info')
                    ->default($default)
                    ->disableOptionWhen(fn (string $value) => $value != $default)
                    ->required(),
            ])
                ->columns(1),
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
