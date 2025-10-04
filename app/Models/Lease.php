<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    protected $fillable = [
        'tenant_id',
        'unit_id',
        'start_date',
        'end_date',
        'monthly_rent',
        'security_deposit',
        'document_path',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if rent is paid for a specific month/year
     */
    public function isRentPaidForMonth($year = null, $month = null)
    {
        $year = $year ?? now()->year;
        $month = $month ?? now()->month;
        
        $totalPaid = $this->payments()
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->sum('amount');
            
        return $totalPaid >= $this->monthly_rent;
    }

    /**
     * Get total amount paid for a specific month/year
     */
    public function getTotalPaidForMonth($year = null, $month = null)
    {
        $year = $year ?? now()->year;
        $month = $month ?? now()->month;
        
        return $this->payments()
            ->whereYear('paid_at', $year)
            ->whereMonth('paid_at', $month)
            ->sum('amount');
    }

    /**
     * Get remaining amount due for a specific month/year
     */
    public function getRemainingAmountForMonth($year = null, $month = null)
    {
        $year = $year ?? now()->year;
        $month = $month ?? now()->month;
        
        $totalPaid = $this->getTotalPaidForMonth($year, $month);
        $remaining = $this->monthly_rent - $totalPaid;
        
        return max(0, $remaining); // Don't return negative amounts
    }

    /**
     * Get rent due status for current month
     */
    public function getRentDueStatus($testDate = null)
    {
        if ($testDate) {
            $currentYear = $testDate->year;
            $currentMonth = $testDate->month;
        } else {
            $currentYear = now()->year;
            $currentMonth = now()->month;
        }
        
        if ($this->isRentPaidForMonth($currentYear, $currentMonth)) {
            return 'paid';
        }
        
        return 'due';
    }

    /**
     * Development helper: Check rent status for any month
     */
    public function getRentDueStatusForMonth($year, $month)
    {
        if ($this->isRentPaidForMonth($year, $month)) {
            return 'paid';
        }
        
        return 'due';
    }

    /**
     * Check if lease is expired based on test date or current date
     * Lease expires the day AFTER the end_date (so it's still active on end_date)
     */
    public function isExpired($testDate = null)
    {
        $referenceDate = $testDate ?: now();
        return $this->end_date && $this->end_date->lt($referenceDate->toDateString());
    }

    /**
     * Check if lease is expiring soon (within specified days)
     */
    public function isExpiringSoon($days = 30, $testDate = null)
    {
        $referenceDate = $testDate ?: now();
        
        // Only check if lease is currently active
        if ($this->getLeaseStatus($testDate) !== 'active') {
            return false;
        }
        
        return $this->end_date && 
               $this->end_date->diffInDays($referenceDate) <= $days && 
               $this->end_date->gte($referenceDate);
    }

    /**
     * Get days until expiration (negative if expired)
     */
    public function getDaysUntilExpiration($testDate = null)
    {
        $referenceDate = $testDate ?: now();
        if (!$this->end_date) return null;
        
        return round($referenceDate->diffInDays($this->end_date, false));
    }

    /**
     * Get lease status based on test date or current date
     * Lease remains active on the end_date and expires the day after
     */
    public function getLeaseStatus($testDate = null)
    {
        $referenceDate = $testDate ?: now();
        
        if ($this->start_date && $this->end_date) {
            if ($referenceDate->gte($this->start_date) && $referenceDate->lte($this->end_date)) {
                return 'active';
            } elseif ($referenceDate->gt($this->end_date)) {
                return 'expired';
            } else {
                return 'future'; 
            }
        } elseif ($this->start_date && !$this->end_date) {
            
            if ($referenceDate->gte($this->start_date)) {
                return 'active';
            } else {
                return 'future';
            }
        }
        
        return 'invalid'; 
    }
}
