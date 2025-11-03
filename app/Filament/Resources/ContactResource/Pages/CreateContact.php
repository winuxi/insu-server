<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;

    protected static bool $canCreateAnother = false;

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
        return __('messages.contact.create_contact_title');
    }

    protected function getRedirectUrl(): string
    {
        return ContactResource::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('messages.contact.contact_created_successfully');
    }
}
