<?php

namespace App\Filament\SuperAdmin\Resources\TestimonialResource\Pages;

use App\Filament\SuperAdmin\Resources\TestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTestimonials extends ManageRecords
{
    protected static string $resource = TestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label(__('messages.testimonial.add_testimonial'))->createAnother(false)->successNotificationTitle(__('messages.testimonial.created_successfully')),
        ];
    }
}
