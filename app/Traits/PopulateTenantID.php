<?php

namespace App\Traits;

use App\Models\MultiTenant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class SaveTenantID
 */
trait PopulateTenantID
{
    protected static function bootPopulateTenantID()
    {
        static::saving(function ($model) {
            if (Auth::check() && Auth::user()->hasRole(User::SUPER_ADMIN)) {
                $tenant = MultiTenant::create([
                    'tenant_username' => $model->name ?? '',
                ]);
                if (empty($model->tenant_id)) {
                    $model->tenant_id = $tenant->id;
                }
            } elseif (Auth::check() && ! empty(Auth::user()->tenant_id)) {
                $model->tenant_id = Auth::user()->tenant_id;
            }
        });
    }
}
