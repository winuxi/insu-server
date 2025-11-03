<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\PopulateTenantID;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use BelongsToTenant,PopulateTenantID;

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
        'tenant_id',
    ];
}
