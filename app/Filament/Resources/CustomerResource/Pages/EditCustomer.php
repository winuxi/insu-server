<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

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
        return __('messages.customer.edit_customer_title');
    }

    public function mutateFormDataBeforeFill(array $data): array
    {
        $user = User::with(['addresses', 'companyDetails'])->find($data['id']);

        return array_merge(
            $data,
            $user->addresses->first()?->toArray() ?? [],
            $user->companyDetails->first()?->toArray() ?? []
        );
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $userFields = ['name', 'email', 'phone', 'gender', 'password'];
        $addressFields = ['address', 'country', 'state', 'city', 'zip'];
        $companyFields = ['company_name', 'tax_no', 'dob', 'age', 'marital_status', 'blood_group', 'height', 'weight', 'note'];

        $record->update(Arr::only($data, $userFields));

        $record->addresses()->updateOrCreate(
            ['user_id' => $record->id],
            Arr::only($data, $addressFields)
        );

        $record->companyDetails()->updateOrCreate(
            ['user_id' => $record->id],
            Arr::only($data, $companyFields)
        );

        return $record;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('messages.customer.customer_updated_successfully');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl();
    }
}
