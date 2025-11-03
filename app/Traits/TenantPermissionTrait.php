<?php

namespace App\Traits;

use App\Models\Role;

trait TenantPermissionTrait
{
    /**
     * Check if user has role within their tenant
     */
    public function hasTenantRole(string $role): bool
    {
        return $this->roles()
            ->first()
            ->where('name', $role)
            ->where('tenant_id', $this->tenant_id)
            ->exists();
    }

    /**
     * Check if user has permission within their tenant
     */
    public function hasTenantPermission(string $permission): bool
    {
        // Get permission ID
        $permissionId = \Spatie\Permission\Models\Permission::where('name', $permission)->value('id');

        if (! $permissionId) {
            return false;
        }

        // Get user's tenant roles
        $userTenantRoleIds = $this->roles()
            ->first()
            ->where('tenant_id', $this->tenant_id)
            ->pluck('id');

        if ($userTenantRoleIds->isEmpty()) {
            return false;
        }

        // Check role_has_permissions table with tenant_id
        return \DB::table('role_has_permissions')
            ->whereIn('role_id', $userTenantRoleIds)
            ->where('permission_id', $permissionId)
            ->where('tenant_id', $this->tenant_id)
            ->exists();
    }

    /**
     * Check multiple permissions within tenant (OR logic)
     */
    public function hasTenantPermissionAny(array $permissions): bool
    {
        if (empty($permissions)) {
            return false;
        }

        // Get permission IDs
        $permissionIds = \Spatie\Permission\Models\Permission::whereIn('name', $permissions)->pluck('id');

        if ($permissionIds->isEmpty()) {
            return false;
        }

        // Get user's tenant roles
        $userTenantRoleIds = $this->roles()
            ->first()
            ->where('tenant_id', $this->tenant_id)
            ->pluck('id');

        if ($userTenantRoleIds->isEmpty()) {
            return false;
        }

        // Check if any permission exists in role_has_permissions with tenant_id
        return \DB::table('role_has_permissions')
            ->whereIn('role_id', $userTenantRoleIds)
            ->whereIn('permission_id', $permissionIds)
            ->where('tenant_id', $this->tenant_id)
            ->exists();
    }

    /**
     * Check multiple permissions within tenant (AND logic)
     */
    public function hasTenantPermissionAll(array $permissions): bool
    {
        if (empty($permissions)) {
            return false;
        }

        // Get permission IDs
        $permissionIds = \Spatie\Permission\Models\Permission::whereIn('name', $permissions)->pluck('id');

        if ($permissionIds->count() !== count($permissions)) {
            return false; // Some permissions don't exist
        }

        // Get user's tenant roles
        $userTenantRoleIds = $this->roles()
            ->first()
            ->where('tenant_id', $this->tenant_id)
            ->pluck('id');

        if ($userTenantRoleIds->isEmpty()) {
            return false;
        }

        // Check if all permissions exist in role_has_permissions with tenant_id
        $existingPermissionIds = \DB::table('role_has_permissions')
            ->whereIn('role_id', $userTenantRoleIds)
            ->whereIn('permission_id', $permissionIds)
            ->where('tenant_id', $this->tenant_id)
            ->pluck('permission_id')
            ->unique();

        return $existingPermissionIds->count() === $permissionIds->count();
    }
}
