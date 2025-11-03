<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsurancePayment extends Model
{
    protected $table = 'insurance_payments';

    protected $fillable = [
        'insurance_id',
        'amount',
        'date',
        'status',
        'installment_id',
    ];

    const PAID = 1;

    const PENDING = 2;

    const IN_REVIEW = 3;

    const STATUSES = [
        self::PAID => 'Paid',
        self::PENDING => 'Pending',
        self::IN_REVIEW => 'In Review',
    ];

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }

    public static function statusColor($status): string
    {
        return match ($status) {
            self::PAID => 'success',
            self::PENDING => 'warning',
            self::IN_REVIEW => 'info',
            default => 'secondary',
        };
    }

    public function installment()
    {
        return $this->belongsTo(Installment::class, 'installment_id');
    }
}
