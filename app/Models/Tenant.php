<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'date_of_birth',
        'address',
        'valid_id_path',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lease()
    {
        return $this->hasOne(Lease::class);
    }
}
