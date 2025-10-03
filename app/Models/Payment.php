<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'lease_id',
        'amount',
        'paid_at',
        'method',
        'reference',
        'receipt_path',
        'notes',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
