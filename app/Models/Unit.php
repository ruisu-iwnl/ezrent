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

    /**
     * Get the relevant lease for a unit at a given date
     * Returns the lease if it's active or scheduled for the future
     * Lease remains active on the end_date
     */
    public function getRelevantLease($testDate = null)
    {
        $referenceDate = $testDate ?: now();
        
        return $this->leases()
            ->where(function($query) use ($referenceDate) {
                $query->where(function($q) use ($referenceDate) {
                    $q->where('start_date', '<=', $referenceDate->toDateString())
                      ->where(function($qq) use ($referenceDate) {
                          $qq->whereNull('end_date')
                             ->orWhere('end_date', '>=', $referenceDate->toDateString());
                      });
                })
                ->orWhere('start_date', '>', $referenceDate->toDateString());
            })
            ->first();
    }

    /**
     * Update unit status based on active leases (respects test date)
     */
    public function updateStatusFromLease($testDate = null)
    {
        if ($this->status === 'maintenance') {
            return false;
        }
        
        $relevantLease = $this->getRelevantLease($testDate);
        $newStatus = $relevantLease ? 'occupied' : 'vacant';
        
        if ($this->status !== $newStatus) {
            $this->update(['status' => $newStatus]);
            return true; 
        }
        
        return false; 
    }

    /**
     * Handle expired leases - set tenants to former status
     * Tenants remain active on expiration date and become former the day after
     */
    public function handleExpiredLeases($testDate = null)
    {
        $referenceDate = $testDate ?: now();
        
        $expiredLeases = $this->leases()
            ->where('end_date', '<', $referenceDate->copy()->subDay()->toDateString())
            ->whereHas('tenant', function($query) {
                $query->where('status', '!=', 'former');
            })
            ->get();
            
        foreach ($expiredLeases as $lease) {
            $lease->tenant->update(['status' => 'former']);
        }
        
        return $expiredLeases->count();
    }

    /**
     * Get current lease status for this unit
     */
    public function getCurrentLeaseStatus($testDate = null)
    {
        $referenceDate = $testDate ?: now();
        
        $activeLease = $this->leases()
            ->where(function($query) use ($referenceDate) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', $referenceDate->toDateString());
            })
            ->first();
            
        if (!$activeLease) {
            return 'no_lease';
        }
        
        return $activeLease->getLeaseStatus($testDate);
    }

    /**
     * Check if unit has expiring lease
     */
    public function hasExpiringLease($days = 30, $testDate = null)
    {
        $referenceDate = $testDate ?: now();
        
        return $this->leases()
            ->where(function($query) use ($referenceDate) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', $referenceDate->toDateString());
            })
            ->where('end_date', '<=', $referenceDate->copy()->addDays($days))
            ->whereNotNull('end_date')
            ->exists();
    }
}
