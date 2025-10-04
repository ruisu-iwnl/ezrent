<?php

namespace App\Services;

use App\Models\Lease;
use Carbon\Carbon;

class LeaseStatusService
{
    public function getLeaseStatusSummary($allLeases, $testDate = null)
    {
        $referenceDate = $testDate ?: now();
        $currentYear = $referenceDate->year;
        $currentMonth = $referenceDate->month;
        
        $overdueLeases = $this->getOverdueLeases($allLeases, $currentYear, $currentMonth, $referenceDate, $testDate);
        $expiredLeases = $this->getExpiredLeases($allLeases, $testDate);
        $expiringSoonLeases = $this->getExpiringSoonLeases($allLeases, $testDate);
        $activeLeases = $this->getActiveLeases($allLeases, $testDate);
        
        return [
            'overdueLeases' => $overdueLeases,
            'overdueAmount' => $overdueLeases->sum(function($lease) use ($currentYear, $currentMonth) {
                return $lease->getRemainingAmountForMonth($currentYear, $currentMonth);
            }),
            'overdueCount' => $overdueLeases->count(),
            'overdueDetails' => $this->getOverdueDetails($overdueLeases, $currentYear, $currentMonth, $referenceDate),
            'expiredLeases' => $expiredLeases,
            'expiredCount' => $expiredLeases->count(),
            'expiringSoonLeases' => $expiringSoonLeases,
            'expiringSoonCount' => $expiringSoonLeases->count(),
            'expiringDetails' => $this->getExpiringDetails($expiringSoonLeases, $testDate),
            'activeLeases' => $activeLeases,
            'activeCount' => $activeLeases->count(),
        ];
    }
    
    public function getRentDueLeases($allLeases, $testDate = null)
    {
        return $allLeases->filter(function($lease) use ($testDate) {
            return $lease->getRentDueStatus($testDate) === 'due';
        });
    }
    
    private function getOverdueLeases($allLeases, $currentYear, $currentMonth, $referenceDate, $testDate)
    {
        return $allLeases->filter(function($lease) use ($currentYear, $currentMonth, $referenceDate, $testDate) {
            if ($lease->getLeaseStatus($testDate) !== 'active') return false;

            $remainingAmount = $lease->getRemainingAmountForMonth($currentYear, $currentMonth);
            if ($remainingAmount <= 0) return false; 
            
            $monthStart = $referenceDate->copy()->startOfMonth();
            $gracePeriodEnd = $monthStart->copy()->addDays(5);
            
            return $referenceDate->greaterThan($gracePeriodEnd);
        });
    }
    
    private function getExpiredLeases($allLeases, $testDate)
    {
        return $allLeases->filter(function($lease) use ($testDate) {
            return $lease->isExpired($testDate);
        });
    }
    
    private function getExpiringSoonLeases($allLeases, $testDate)
    {
        return $allLeases->filter(function($lease) use ($testDate) {
            return $lease->isExpiringSoon(30, $testDate);
        });
    }
    
    private function getActiveLeases($allLeases, $testDate)
    {
        return $allLeases->filter(function($lease) use ($testDate) {
            return $lease->getLeaseStatus($testDate) === 'active';
        });
    }
    
    private function getOverdueDetails($overdueLeases, $currentYear, $currentMonth, $referenceDate)
    {
        return $overdueLeases->map(function($lease) use ($currentYear, $currentMonth, $referenceDate) {
            $remainingAmount = $lease->getRemainingAmountForMonth($currentYear, $currentMonth);
            $monthStart = $referenceDate->copy()->startOfMonth();
            $gracePeriodEnd = $monthStart->copy()->addDays(5);
            $daysOverdue = $referenceDate->diffInDays($gracePeriodEnd);
            
            return [
                'lease' => $lease,
                'amount' => $remainingAmount,
                'days_overdue' => $daysOverdue
            ];
        });
    }
    
    private function getExpiringDetails($expiringSoonLeases, $testDate)
    {
        return $expiringSoonLeases->map(function($lease) use ($testDate) {
            return [
                'lease' => $lease,
                'days_until_expiration' => $lease->getDaysUntilExpiration($testDate),
                'expiration_date' => $lease->end_date->format('M j, Y')
            ];
        })->sortBy('days_until_expiration');
    }
}
