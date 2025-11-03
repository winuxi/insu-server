<?php

namespace App\Filament\Resources\DurationResource\Pages;

use App\Filament\Resources\DurationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDurations extends ManageRecords
{
    protected static string $resource = DurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->modalWidth('sm')
                ->createAnother(false)
                ->successNotificationTitle(__('messages.duration.duration_created_successfully'))
                ->label(__('messages.duration.new_duration'))
                ->modalHeading(__('messages.duration.new_duration')),
        ];
    }

    public function getTitle(): string
    {
        return __('messages.duration.manage_durations_title');
    }
}
