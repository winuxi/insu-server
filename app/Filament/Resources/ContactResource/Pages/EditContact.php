<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditContact extends EditRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('messages.common.back'))
                ->outlined()
                ->url(ContactResource::getUrl('index')),
        ];
    }

    public function getTitle(): string
    {
        return __('messages.contact.edit_contact_title');
    }

    protected function getRedirectUrl(): string
    {
        return ContactResource::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string // Changed from getCreatedNotificationTitle
    {
        return __('messages.contact.contact_updated_successfully');
    }
}
