<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\PopulateTenantID;
use Illuminate\Database\Eloquent\Model;

class PolicySubType extends Model
{
    use BelongsToTenant, PopulateTenantID;

    protected $table = 'policy_sub_types';

    protected $fillable = ['name', 'policy_type_id'];

    public function policyType()
    {
        return $this->belongsTo(PolicyType::class);
    }

    public function policies()
    {
        return $this->hasMany(Policy::class, 'policy_sub_type_id');
    }
}
