<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plans';

    const MONTHLY = 1;

    const YEARLY = 2;

    const INTERVALS = [
        self::MONTHLY => 'Monthly',
        self::YEARLY => 'Yearly',
    ];

    public static function intervalColor($interval)
    {
        return match ($interval) {
            self::MONTHLY => 'success',
            self::YEARLY => 'danger',
        };
    }

    protected $fillable = [
        'title',
        'interval',
        'amount',
        'user_limit',
        'customer_limit',
        'agent_limit',
        'is_show_history',
        'is_popular',
        'short_description',
    ];
}
