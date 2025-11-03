<?php

namespace App\Filament\Resources\PolicyResource\Pages;

use App\Filament\Resources\PolicyResource;
use App\Models\Policy;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth; // Added Auth facade

class EditPolicy extends EditRecord
{
    protected static string $resource = PolicyResource::class;

    public function mount(int|string $record): void
    {
        $policy = Policy::find($record);
        if ($policy->user_id != Auth::id()) {
            abort(403);
        }
        parent::mount($record);
    }

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
        return __('messages.policy.edit_policy_title');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('messages.policy.policy_updated_successfully');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl();
    }
}
