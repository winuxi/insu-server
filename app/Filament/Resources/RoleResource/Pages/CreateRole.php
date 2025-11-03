<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use App\Models\Role;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission; // Added Auth facade

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected static bool $canCreateAnother = false;

    public ?array $permissions;

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
        return __('messages.role.create_role_title');
    }

    protected function beforeCreate(): void
    {
        if (Role::where('name', $this->data['name'])->where('tenant_id', Auth::user()->tenant_id)->exists()) {
            notify(__('messages.role.role_already_exists'), 'danger');

            $this->halt();
        }
    }

    protected function handleRecordCreation(array $data): Role
    {
        $tenantId = Auth::user()->tenant_id;

        $allowedPermissionNames = collect($data['permissions'])
            ->filter(fn ($allowed) => $allowed)
            ->keys()
            ->toArray();

        if (empty($allowedPermissionNames)) {
            Notification::make()
                ->danger()
                ->title('Please select at least one permission.')
                ->send();
            $this->halt();
        }

        $role = Role::query()->create([
            'name' => $data['name'],
            'guard_name' => 'web',
            'tenant_id' => $tenantId,
        ]);

        $permissions = collect($allowedPermissionNames)->map(function ($name) {
            return Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        });

        $permissionIds = $permissions->pluck('id');

        foreach ($permissionIds as $permissionId) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $role->id,
                'permission_id' => $permissionId,
                'tenant_id' => $tenantId,
            ]);
        }

        return $role;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('messages.role.role_and_permissions_created_successfully');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
