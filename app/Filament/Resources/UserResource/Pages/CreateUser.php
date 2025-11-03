<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

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
        return __('messages.user.create_user_title');
    }

    protected function afterCreate(): void
    {
        $this->record->sendEmailVerificationNotification();

        $tenantId = $this->record->tenant_id;

        if (Auth::user()->hasRole(User::SUPER_ADMIN)) {
            $this->record->assignRole(User::ADMIN);
            Role::query()->create(['name' => User::CUSTOMER, 'tenant_id' => $tenantId, 'guard_name' => 'web']);
            Role::query()->create(['name' => User::AGENT, 'tenant_id' => $tenantId, 'guard_name' => 'web']);
        }
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('messages.user.user_created_successfully');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl();
    }
}
