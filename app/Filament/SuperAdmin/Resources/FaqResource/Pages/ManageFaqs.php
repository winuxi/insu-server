<?php

namespace App\Filament\SuperAdmin\Resources\FaqResource\Pages;

use App\Filament\SuperAdmin\Resources\FaqResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFaqs extends ManageRecords
{
    protected static string $resource = FaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('messages.faq.add_faq'))
                ->successNotificationTitle(__('messages.faq.created_successfully'))
                ->createAnother(false),
        ];
    }
}
