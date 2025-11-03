<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * Class SaveTenantID
 */
trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope('tenant', function (Builder $query) {
            if (auth()->hasUser() && ! auth()->user()->hasRole(User::SUPER_ADMIN)) {
                $query->where('tenant_id', auth()->user()->tenant_id);
            }
        });
    }
}
