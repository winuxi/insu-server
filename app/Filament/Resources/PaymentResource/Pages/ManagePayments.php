<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePayments extends ManageRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('sm')
                ->createAnother(false)
                ->successNotificationTitle(__('messages.insurance_payment.notification.created_successfully'))
                ->label(__('messages.insurance_payment.button.add_payment'))
                ->modalHeading(__('messages.insurance_payment.modal.new_payment_heading')),
        ];
    }

    public function getTitle(): string
    {
        return __('messages.payment.manage_payments_title');
    }
}
