<?php

namespace App\Filament\Resources\CustomActivityResource\Pages;

use App\Filament\Resources\CustomActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomActivities extends ListRecords
{
    protected static string $resource = CustomActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
