<?php

namespace App\Filament\Resources\PolicySubTypeResource\Pages;

use App\Filament\Resources\PolicySubTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePolicySubTypes extends ManageRecords
{
    protected static string $resource = PolicySubTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('sm')
                ->createAnother(false)
                ->successNotificationTitle(__('messages.policy_sub_type.policy_sub_type_created_successfully'))
                ->label(__('messages.policy_sub_type.new_policy_sub_type'))
                ->modalHeading(__('messages.policy_sub_type.new_policy_sub_type')),
        ];
    }

    public function getTitle(): string
    {
        return __('messages.policy_sub_type.manage_policy_sub_types_title');
    }
}
