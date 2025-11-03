<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceInsured extends Model
{
    protected $table = 'insurance_insureds';

    protected $fillable = [
        'name',
        'insurance_id',
        'dob',
        'age',
        'gender',
        'blood_group',
        'height',
        'weight',
        'relation',
    ];

    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }
}
