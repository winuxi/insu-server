<?php

namespace App\Livewire\Insurance;

use App\Models\Installment as InstallmentModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class Installment extends Component implements HasForms, HasTable
{
    use InteractsWithForms ,InteractsWithTable;

    public $id;

    public $customer_id;

    public function mount($id, $customer_id)
    {
        $this->id = $id;
        $this->customer_id = $customer_id;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                InstallmentModel::query()
                    ->where('insurance_id', $this->id)
                    ->where('customer_id', $this->customer_id)
            )
            ->columns([
                TextColumn::make('order_no')
                    ->label(__('messages.insurance_installment.table.order_no')),
                TextColumn::make('amount')
                    ->label(__('messages.insurance_installment.table.amount')),
                TextColumn::make('start_date')
                    ->label(__('messages.insurance_installment.table.start_date'))
                    ->date(),
                TextColumn::make('policy.title')
                    ->label(__('messages.insurance_installment.table.policy')),
            ])
            ->paginated([10, 25, 50, 100]);
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
