<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\PopulateTenantID;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use BelongsToTenant,PopulateTenantID;

    protected $table = 'taxes';

    protected $fillable = ['tax', 'tax_rate', 'tenant_id'];

    public function policies()
    {
        return $this->hasMany(Policy::class, 'tax_id');
    }
}
