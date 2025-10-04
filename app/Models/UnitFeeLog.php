<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitFeeLog extends Model
{
    protected $fillable = [
        'unit_id',
        'lease_id',
        'logged_by',
        'category',
        'description',
        'amount',
        'incurred_at',
        'attachment_path',
    ];

    protected $casts = [
        'incurred_at' => 'date',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }

    public function logger()
    {
        return $this->belongsTo(User::class, 'logged_by');
    }
}
