<?php

namespace App\Filament\Resources\PolicyTypeResource\Pages;

use App\Filament\Resources\PolicyTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePolicyTypes extends ManageRecords
{
    protected static string $resource = PolicyTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('sm')
                ->createAnother(false)
                ->successNotificationTitle(__('messages.policy_type.policy_type_created_successfully'))
                ->label(__('messages.policy_type.new_policy_type'))
                ->modalHeading(__('messages.policy_type.new_policy_type')),
        ];
    }

    public function getTitle(): string
    {
        return __('messages.policy_type.manage_policy_types_title');
    }
}
