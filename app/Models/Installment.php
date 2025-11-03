<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $table = 'insurance_installments';

    protected $fillable = [
        'insurance_id',
        'customer_id',
        'order_no',
        'start_date',
        'start_date',
        'amount',
        'policy_id',
    ];

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class, 'policy_id');
    }

    public function payments()
    {
        return $this->hasMany(InsurancePayment::class, 'installment_id');
    }
}
