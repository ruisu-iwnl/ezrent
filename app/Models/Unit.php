<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'admin_id',
        'code',
        'description',
        'status',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function leases()
    {
        return $this->hasMany(Lease::class);
    }

    public function feeLogs()
    {
        return $this->hasMany(UnitFeeLog::class);
    }
}
