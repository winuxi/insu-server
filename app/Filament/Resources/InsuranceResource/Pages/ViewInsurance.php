<?php

namespace App\Filament\Resources\InsuranceResource\Pages;

use App\Filament\Resources\InsuranceResource;
use App\Livewire\Insurance\Document;
use App\Livewire\Insurance\Installment;
use App\Livewire\Insurance\Insured;
use App\Livewire\Insurance\Nominee;
use App\Livewire\Insurance\Payment;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Ysfkaya\FilamentPhoneInput\Infolists\PhoneEntry;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class ViewInsurance extends ViewRecord
{
    protected static string $resource = InsuranceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->hiddenLabel()
                ->outlined()
                ->color('success')
                ->tooltip(__('messages.insurance.download_insurance'))
                ->icon('heroicon-o-printer')
                ->url(route('insurance.pdf', ['id' => $this->record->id])),
            Action::make('back')
                ->label(__('messages.common.back'))
                ->outlined()
                ->url(static::getResource()::getUrl()),
        ];
    }

    public function getTitle(): string
    {
        return __('messages.insurance.view_insurance_title');
    }

    public function infolist(Infolist $infolist): Infolist
    {
        $prefix = insuranceCustomerPrefix($this->record?->id); // Prefix is dynamic
        $overview =
        Tabs\Tab::make($prefix) // Tab label is dynamic
            ->schema([
                Section::make($prefix) // Section title is dynamic
                    ->schema([
                        TextEntry::make('customer.id')
                            ->label(__('messages.insurance.customer_id'))
                            ->formatStateUsing(fn ($state) => invoiceCustomerPrefix($state)),
                        TextEntry::make('customer.name')
                            ->label(__('messages.customer.name')), // Reusing from customer
                        TextEntry::make('customer.email')
                            ->label(__('messages.customer.email')), // Reusing from customer
                        PhoneEntry::make('customer.phone')
                            ->label(__('messages.customer.phone_number')) // Reusing from customer
                            ->displayFormat(PhoneInputNumberType::INTERNATIONAL),
                        TextEntry::make('customer.companyDetails.company_name')
                            ->label(__('messages.customer.company_name')), // Reusing from customer
                        TextEntry::make('customer.companyDetails.dob')
                            ->label(__('messages.customer.dob')), // Reusing from customer
                        TextEntry::make('customer.companyDetails.age')
                            ->label(__('messages.customer.age')), // Reusing from customer
                        TextEntry::make('customer.gender')
                            ->formatStateUsing(fn ($state) => User::GENDERS[$state]) // Assuming GENDERS are not for direct display or already localized if they are
                            ->label(__('messages.customer.gender')), // Reusing from customer
                        TextEntry::make('customer.companyDetails.marital_status')
                            ->formatStateUsing(fn ($state) => User::MARITAL_STATUS[$state] ?? __('messages.common.unknown')) // Localize 'Unknown' if needed
                            ->label(__('messages.customer.marital_status')), // Reusing from customer
                        TextEntry::make('customer.companyDetails.blood_group')
                            ->label(__('messages.customer.blood_group')), // Reusing from customer
                        TextEntry::make('customer.companyDetails.height')
                            ->label(__('messages.customer.height')), // Reusing from customer
                        TextEntry::make('customer.companyDetails.weight')
                            ->label(__('messages.customer.weight')), // Reusing from customer
                        TextEntry::make('customer.companyDetails.tax_no')
                            ->label(__('messages.customer.tax_number')), // Reusing from customer
                        TextEntry::make('customer.addresses.0.address')
                            ->label(__('messages.customer.address')), // Reusing from customer
                    ])->columns(4),
            ]);

        $installment = Tabs\Tab::make(__('messages.insurance.installment'))
            ->schema([
                Livewire::make(Installment::class, ['id' => $this->record->id, 'customer_id' => $this->record->customer_id]),
            ])->columns(1);

        $insured =
            Tabs\Tab::make(__('messages.insurance.insured'))
                ->schema([
                    Livewire::make(Insured::class, ['id' => $this->record->id]),
                ])
                ->columns(1);

        $nominee =
            Tabs\Tab::make(__('messages.insurance.nominee'))
                ->schema([
                    Livewire::make(Nominee::class, ['id' => $this->record->id]),
                ])
                ->columns(1);

        $document = Tabs\Tab::make(__('messages.insurance.document'))
            ->schema([
                Livewire::make(Document::class, ['id' => $this->record->id]),
            ])
            ->columns(1);

        $payment = Tabs\Tab::make(__('messages.insurance.payment'))
            ->schema([
                Livewire::make(Payment::class, ['id' => $this->record->id]),
            ])
            ->columns(1);

        return $infolist
            ->schema([
                Tabs::make('Tabs') // Internal name, no need to localize
                    ->tabs([$overview, $installment, $insured, $nominee, $document, $payment])->contained(false)->persistTabInQueryString(),
            ])->columns(1);
    }
}
