<?php

namespace App\Filament\Resources\ClaimResource\Pages;

use App\Filament\Resources\ClaimResource;
use App\Models\Claim;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClaims extends ManageRecords
{
    protected static string $resource = ClaimResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->createAnother(false)
                ->before(function ($data, $action) { // Added $action parameter
                    if (Claim::where('claim_number', $data['claim_number'])->exists()) {
                        notify(__('messages.claim.claim_number_already_exist'), 'danger');
                        $action->halt(); // Use $action->halt()
                    }
                })
                ->successNotificationTitle(__('messages.claim.claim_created_successfully'))
                ->modelLabel(__('messages.claim.new_claim'))
                ->label(__('messages.claim.new_claim')),
        ];
    }

    public function getTitle(): string
    {
        return __('messages.claim.manage_claims_title');
    }
}
