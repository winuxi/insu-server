<?php

namespace App\Filament\Resources\ClaimResource\Pages;

use App\Filament\Resources\ClaimResource;
use App\Livewire\Claim\Document;
use App\Models\Claim;
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

class ViewClaim extends ViewRecord
{
    protected static string $resource = ClaimResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->hiddenLabel()
                ->outlined()
                ->color('success')
                ->tooltip(__('messages.claim.download_claim'))
                ->icon('heroicon-o-printer')
                ->url(route('claim.pdf', ['id' => $this->record->id])),
            Action::make('back')
                ->label(__('messages.common.back'))
                ->outlined()
                ->url(static::getResource()::getUrl()),
        ];
    }

    public function getTitle(): string
    {
        return __('messages.claim.view_claim_title'); // Assuming you add 'view_claim_title'
    }

    public function infolist(Infolist $infolist): Infolist
    {
        $prefix = $this->record?->claim_number ?? claimNumberPrefix(isClean: true).$this->record->id;
        $overview = Tabs\Tab::make($prefix) // Prefix is dynamic, localization might be complex or not needed here
            ->schema([
                Section::make($prefix) // Prefix is dynamic
                    ->schema([
                        TextEntry::make('customer.name')
                            ->label(__('messages.claim.customer')),
                        TextEntry::make('insurance.policy.title')
                            ->label(__('messages.claim.insurance')),
                        TextEntry::make('claim_date')
                            ->date()
                            ->label(__('messages.claim.claim_date')),
                        TextEntry::make('status')
                            ->label(__('messages.claim.status'))
                            ->formatStateUsing(fn ($state) => Claim::STATUS[$state])
                            ->badge()
                            ->color(fn ($state) => Claim::statusColor($state)),
                        TextEntry::make('reason')
                            ->label(__('messages.claim.reason')),
                        TextEntry::make('note')
                            ->label(__('messages.claim.note')),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->label(__('messages.claim.created_at')),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->label(__('messages.claim.updated_at')),
                    ])->columns(4),
            ]);

        $policyHolder = Tabs\Tab::make(__('messages.claim.policy_holder'))
            ->schema([
                Section::make(__('messages.claim.policy_holder_details'))
                    ->schema([
                        TextEntry::make('customer.id')
                            ->label(__('messages.claim.customer_id'))
                            ->formatStateUsing(fn ($state) => invoiceCustomerPrefix($state)),
                        TextEntry::make('customer.name')
                            ->label(__('messages.claim.name')),
                        TextEntry::make('customer.email')
                            ->label(__('messages.claim.email')),
                        PhoneEntry::make('customer.phone')
                            ->displayFormat(PhoneInputNumberType::INTERNATIONAL)
                            ->label(__('messages.claim.phone')),
                        TextEntry::make('customer.companyDetails.company_name')
                            ->label(__('messages.claim.company_name')),
                        TextEntry::make('customer.companyDetails.dob')
                            ->label(__('messages.claim.dob')),
                        TextEntry::make('customer.companyDetails.age')
                            ->label(__('messages.claim.age')),
                        TextEntry::make('customer.gender')
                            ->formatStateUsing(fn ($state) => User::GENDERS[$state])
                            ->label(__('messages.claim.gender')),
                        TextEntry::make('customer.companyDetails.marital_status')
                            ->formatStateUsing(fn ($state) => User::MARITAL_STATUS[$state] ?? 'Unknown') // 'Unknown' could be localized
                            ->label(__('messages.claim.marital_status')),
                        TextEntry::make('customer.companyDetails.blood_group')
                            ->label(__('messages.claim.blood_group')),
                        TextEntry::make('customer.companyDetails.height')
                            ->label(__('messages.claim.height')),
                        TextEntry::make('customer.companyDetails.weight')
                            ->label(__('messages.claim.weight')),
                        TextEntry::make('customer.companyDetails.tax_no')
                            ->label(__('messages.claim.tax_number')),
                        TextEntry::make('customer.addresses.0.address')
                            ->label(__('messages.claim.address')),
                    ])->columns(4),
            ]);

        $document = Tabs\Tab::make(__('messages.claim.document'))
            ->schema([
                Livewire::make(Document::class, ['id' => $this->record->id]),
            ])
            ->columns(1);

        return $infolist
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([$overview, $policyHolder, $document])->contained(false),
            ])->columns(1);
    }
}
