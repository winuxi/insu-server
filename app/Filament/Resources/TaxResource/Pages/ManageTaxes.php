<?php

namespace App\Filament\Resources\TaxResource\Pages;

use App\Filament\Resources\TaxResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTaxes extends ManageRecords
{
    protected static string $resource = TaxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('sm')
                ->createAnother(false)
                ->successNotificationTitle(__('messages.tax.tax_created_successfully'))
                ->label(__('messages.tax.new_tax'))
                ->modalHeading(__('messages.tax.new_tax')),
        ];
    }

    public function getTitle(): string
    {
        return __('messages.tax.manage_taxes_title');
    }
}
