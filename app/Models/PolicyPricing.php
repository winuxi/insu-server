<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class PolicyPricing extends Model
{
    use BelongsToTenant;

    protected $table = 'policy_pricings';

    protected $fillable = [
        'policy_id',
        'duration_id',
        'price',
    ];

    public function policy()
    {
        return $this->belongsTo(Policy::class, 'policy_id');
    }

    public function duration()
    {
        return $this->belongsTo(Duration::class, 'duration_id');
    }

    public function insurances()
    {
        return $this->hasMany(Insurance::class, 'policy_pricing_id');
    }
}
