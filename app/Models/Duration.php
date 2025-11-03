<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\PopulateTenantID;
use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    use BelongsToTenant ,PopulateTenantID;

    protected $table = 'durations';

    protected $fillable = [
        'duration_terms',
        'duration_in_months',
        'tenant_id',
    ];
}
