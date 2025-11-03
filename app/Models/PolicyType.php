<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\PopulateTenantID;
use Illuminate\Database\Eloquent\Model;

class PolicyType extends Model
{
    use BelongsToTenant,PopulateTenantID;

    protected $table = 'policy_types';

    protected $fillable = [
        'name',
        'tenant_id',
    ];

    public function policies()
    {
        return $this->hasMany(Policy::class, 'policy_type_id');
    }
}
