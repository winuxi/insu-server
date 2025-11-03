<?php

namespace App\Filament\SuperAdmin\Resources\PlanResource\Pages;

use App\Filament\SuperAdmin\Resources\PlanResource;
use App\Models\Plan;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlans extends ListRecords
{
    protected static string $resource = PlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function changeIsPopular(Plan $record): void
    {
        Plan::where('id', '!=', $record->id)->update(['is_popular' => false]);

        $record->is_popular = ! $record->is_popular;
        $record->save();

        notify('messages.plans.default_popular_status_updated_successfully');
    }
}
