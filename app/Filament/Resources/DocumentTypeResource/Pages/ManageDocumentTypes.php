<?php

namespace App\Filament\Resources\DocumentTypeResource\Pages;

use App\Filament\Resources\DocumentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDocumentTypes extends ManageRecords
{
    protected static string $resource = DocumentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('sm')
                ->createAnother(false)
                ->successNotificationTitle(__('messages.document_type.document_type_created_successfully'))
                ->label(__('messages.document_type.new_document_type'))
                ->modalHeading(__('messages.document_type.new_document_type')),
        ];
    }

    public function getTitle(): string
    {
        return __('messages.document_type.manage_document_types_title');
    }
}
