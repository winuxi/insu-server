<?php

namespace App\Filament\Resources\AgentResource\Pages;

use App\Filament\Resources\AgentResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class CreateAgent extends CreateRecord
{
    protected static string $resource = AgentResource::class;

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
        return __('messages.agent.create_agent_title');
    }

    protected function handleRecordCreation(array $input): Model
    {
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'gender' => $input['gender'],
            'password' => Hash::make($input['password']),
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
            'note' => $input['note'],
        ]);

        $user->assignRole(User::AGENT);

        $user->sendEmailVerificationNotification();

        return $user;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('messages.agent.agent_created_successfully');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl();
    }
}
