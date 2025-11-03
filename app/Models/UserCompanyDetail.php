<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCompanyDetail extends Model
{
    protected $table = 'user_company_details';

    protected $fillable = [
        'user_id',
        'company_name',
        'tax_no',
        'dob',
        'age',
        'marital_status',
        'blood_group',
        'height',
        'weight',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
