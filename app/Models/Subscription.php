<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use BelongsToTenant;

    protected $table = 'subscriptions';

    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'payment_method',
        'transaction_id',
        'payment_status',
        'is_active',
        'meta',
        'start_date',
        'end_date',
        'tenant_id',
    ];

    const ACTIVE = 1;

    const INACTIVE = 0;

    const STATUSES = [
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Inactive',
    ];

    const PAID = 1;

    const IN_REVIEW = 2;

    const PENDING = 3;

    const FAILED = 4;

    const CANCELLED = 5;

    const PAYMENT_STATUS = [
        self::PAID => 'Paid',
        self::IN_REVIEW => 'In Review',
        self::PENDING => 'Pending',
        self::FAILED => 'Failed',
        self::CANCELLED => 'Cancelled',
    ];

    public static function paymentMethodColor($method): string
    {
        return match ($method) {
            'stripe' => 'success',
            'paypal' => 'warning',
            default => 'info',
        };
    }

    public static function paymentStatusColor($status): string
    {
        return match ($status) {
            self::PAID => 'success',
            self::IN_REVIEW => 'warning',
            self::PENDING => 'info',
            self::FAILED => 'danger',
            self::CANCELLED => 'danger',
        };
    }

    public static function statusColor($status): string
    {
        return match ($status) {
            self::ACTIVE => 'success',
            self::INACTIVE => 'danger',
        };
    }

    public function isExpired(): bool
    {
        $now = Carbon::now();

        if ($this->end_date > $now) {
            return false;
        }

        return true;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
