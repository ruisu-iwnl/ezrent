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
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lease()
    {
        return $this->hasOne(Lease::class);
    }

    /**
     * Check if tenant is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if tenant is inactive
     */
    public function isInactive()
    {
        return $this->status === 'inactive';
    }

    /**
     * Check if tenant is former
     */
    public function isFormer()
    {
        return $this->status === 'former';
    }

    /**
     * Get status badge class for UI
     */
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'inactive' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
            'former' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
        };
    }
}
