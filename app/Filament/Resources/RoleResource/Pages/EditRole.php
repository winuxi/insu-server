<?php

namespace App\Filament\Resources\RoleResource\Pages;

use App\Filament\Resources\RoleResource;
use App\Models\Role;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission; // Added Auth facade

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    public array $permissions;

    // public function mount($record): void
    // {
    //     $roleName = Role::find($record)?->name;
    //     if ($roleName == User::ADMIN || $roleName === User::CUSTOMER || $roleName === User::AGENT) {
    //         abort(403, 'Unauthorized action.');
    //     }
    //     parent::mount($record);
    // }

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
        return __('messages.role.edit_role_title');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $role = Role::query()->find($data['id']);

        if ($role) {
            $rolePermissions = $role->permissions->pluck('name')->toArray();

            $permissionsData = [];
            foreach ($rolePermissions as $permission) {
                $permissionsData[$permission] = true;
            }

            $data['permissions'] = $permissionsData;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $permissions = [];

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

        if (isset($data['permissions'])) {
            foreach ($data['permissions'] as $key => $value) {
                if ($value === true) {
                    $permissions[] = $key;
                }
            }

            $this->permissions = $permissions;

            unset($data['permissions']);
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        if (isset($this->permissions)) {
            // Remove old permissions for this tenant
            DB::table('role_has_permissions')
                ->where('role_id', $record->id)
                ->where('tenant_id', Auth::user()->tenant_id)
                ->delete();

            // Re-add new ones with tenant context
            $permissionIds = Permission::whereIn('name', $this->permissions)->pluck('id');

            foreach ($permissionIds as $permissionId) {
                DB::table('role_has_permissions')->insert([
                    'role_id' => $record->id,
                    'permission_id' => $permissionId,
                    'tenant_id' => Auth::user()->tenant_id,
                ]);
            }
        }

        return $record;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('messages.role.role_and_permissions_updated_successfully');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
