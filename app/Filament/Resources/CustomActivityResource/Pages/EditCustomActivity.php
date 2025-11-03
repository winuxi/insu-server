<?php

namespace App\Filament\Resources\CustomActivityResource\Pages;

use App\Filament\Resources\CustomActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomActivity extends EditRecord
{
    protected static string $resource = CustomActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
