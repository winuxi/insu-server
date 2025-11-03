<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // Added Auth Facade
use Illuminate\Support\Facades\Hash;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected static bool $canCreateAnother = false;

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
        return __('messages.customer.create_customer_title');
    }

    protected function handleRecordCreation(array $input): Model
    {
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'gender' => $input['gender'],
            'password' => Hash::make($input['password']),
            'created_by_id' => Auth::id(),
        ]);

        $user->addresses()->create([
            'address' => $input['address'],
            'country' => $input['country'],
            'state' => $input['state'],
            'city' => $input['city'],
            'zip' => $input['zip'],
        ]);

        $user->companyDetails()->create([
            'company_name' => $input['company_name'],
            'tax_no' => $input['tax_no'],
            'dob' => $input['dob'],
            'age' => $input['age'],
            'marital_status' => $input['marital_status'],
            'blood_group' => $input['blood_group'],
            'height' => $input['height'],
            'weight' => $input['weight'],
            'note' => $input['note'],
        ]);

        $user->assignRole(User::CUSTOMER);

        $user->sendEmailVerificationNotification();

        return $user;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('messages.customer.customer_created_successfully');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl();
    }
}
