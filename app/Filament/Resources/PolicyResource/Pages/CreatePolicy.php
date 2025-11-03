<?php

namespace App\Filament\Resources\PolicyResource\Pages;

use App\Filament\Resources\PolicyResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // Added Auth facade

class CreatePolicy extends CreateRecord
{
    protected static string $resource = PolicyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('messages.common.back'))
                ->outlined()
                ->url(static::getResource()::getUrl()),
        ];
    }

    public function getTitle(): string
    {
        return __('messages.policy.create_policy_title');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $data['user_id'] = Auth::id();

        return parent::handleRecordCreation($data);
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('messages.policy.policy_created_successfully');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl();
    }
}
