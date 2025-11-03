<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceNominee extends Model
{
    protected $table = 'insurance_nominees';

    protected $fillable = [
        'name',
        'dob',
        'percentage',
        'relation',
        'insurance_id',
    ];

    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }
}
