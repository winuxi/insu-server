<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_addresses';

    protected $fillable = [
        'user_id',
        'address',
        'country',
        'state',
        'city',
        'zip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
