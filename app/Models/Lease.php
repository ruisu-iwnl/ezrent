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
}
