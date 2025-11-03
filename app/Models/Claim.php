<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use App\Traits\PopulateTenantID;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use BelongsToTenant,PopulateTenantID;

    protected $table = 'claims';

    protected $fillable = [
        'claim_number',
        'claim_date',
        'customer_id',
        'insurance_id',
        'status',
        'reason',
        'note',
    ];

    const ACKNOWLEDGED = 1;

    const APPROVED = 2;

    const CLOSED = 3;

    const REJECTED = 4;

    const SUBMITTED = 5;

    const UNDER_REVIEW = 6;

    const STATUS = [
        self::ACKNOWLEDGED => 'Acknowledged',
        self::APPROVED => 'Approved',
        self::CLOSED => 'Closed',
        self::REJECTED => 'Rejected',
        self::SUBMITTED => 'Submitted',
        self::UNDER_REVIEW => 'Under Review',
    ];

    public static function statusColor($status): string
    {
        return match ($status) {
            self::APPROVED, self::ACKNOWLEDGED => 'success',
            self::UNDER_REVIEW => 'warning',
            self::REJECTED,self::CLOSED => 'danger',
            self::SUBMITTED => 'info',
            default => 'secondary',
        };
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }

    public function documents()
    {
        return $this->hasMany(ClaimDocument::class, 'claim_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
