<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\PopulateTenantID;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use BelongsToTenant,PopulateTenantID;

    protected $table = 'insurances';

    protected $fillable = [
        'customer_id',
        'agent_id',
        'policy_id',
        'policy_pricing_id',
        'agent_commission',
        'start_date',
        'status',
        'note',
        'tenant_id',
    ];

    const STATUS_INACTIVE = 0;

    const STATUS_ACTIVE = 1;

    const IN_REVIEW = 2;

    const STATUSES = [
        self::STATUS_ACTIVE => 'Confirm',
        self::STATUS_INACTIVE => 'Expired',
        self::IN_REVIEW => 'In Review',
    ];

    public static function statusColor($status): string
    {
        return match ($status) {
            self::STATUS_ACTIVE => 'success',
            self::STATUS_INACTIVE => 'danger',
            self::IN_REVIEW => 'info',
        };
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class, 'policy_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function policyPricing()
    {
        return $this->belongsTo(PolicyPricing::class, 'policy_pricing_id');
    }

    public function insureds()
    {
        return $this->hasMany(InsuranceInsured::class, 'insurance_id');
    }

    public function nominees()
    {
        return $this->hasMany(InsuranceNominee::class, 'insurance_id');
    }

    public function documents()
    {
        return $this->hasMany(InsuranceDocument::class, 'insurance_id');
    }

    public function payments()
    {
        return $this->hasMany(InsurancePayment::class, 'insurance_id');
    }

    public function claims()
    {
        return $this->hasMany(Claim::class, 'insurance_id');
    }

    public function installments()
    {
        return $this->hasMany(Installment::class, 'insurance_id');
    }
}
