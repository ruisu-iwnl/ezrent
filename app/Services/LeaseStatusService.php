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
        
        $tenants = \App\Models\Tenant::with(['lease'])->get();
        
        $overdueLeases = $this->getOverdueLeases($allLeases, $currentYear, $currentMonth, $referenceDate, $testDate);
        $activeCount = $this->getActiveTenantCount($tenants);
        $expiredCount = $this->getExpiredTenantCount($tenants);
        $expiringSoonCount = $this->getExpiringSoonTenantCount($tenants, $testDate);
        $expiringDetails = $this->getExpiringTenantDetails($tenants, $testDate);
        
        return [
            'overdueLeases' => $overdueLeases,
            'overdueAmount' => $overdueLeases->sum(function($lease) use ($currentYear, $currentMonth) {
                return $lease->getRemainingAmountForMonth($currentYear, $currentMonth);
            }),
            'overdueCount' => $overdueLeases->count(),
            'overdueDetails' => $this->getOverdueDetails($overdueLeases, $currentYear, $currentMonth, $referenceDate),
            'activeCount' => $activeCount,
            'expiredCount' => $expiredCount,
            'expiringSoonCount' => $expiringSoonCount,
            'expiringDetails' => $expiringDetails,
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
    
    /**
     * Count active tenants
     */
    private function getActiveTenantCount($tenants)
    {
        return $tenants->where('status', 'active')->count();
    }
    
    /**
     * Count expired tenants (inactive or former)
     */
    private function getExpiredTenantCount($tenants)
    {
        return $tenants->whereIn('status', ['inactive', 'former'])->count();
    }
    
    /**
     * Count active tenants whose lease expires within 15 days
     */
    private function getExpiringSoonTenantCount($tenants, $testDate = null)
    {
        $referenceDate = $testDate ?: now();
        
        return $tenants->filter(function($tenant) use ($referenceDate) {
            // Only count active tenants
            if ($tenant->status !== 'active') {
                return false;
            }
            
            // Check if they have a lease that expires within 15 days
            if (!$tenant->lease || !$tenant->lease->end_date) {
                return false;
            }
            
            $daysUntilExpiration = $referenceDate->diffInDays($tenant->lease->end_date, false);
            return $daysUntilExpiration >= 0 && $daysUntilExpiration <= 15;
        })->count();
    }
    
    /**
     * Get details of active tenants whose lease expires within 15 days
     */
    private function getExpiringTenantDetails($tenants, $testDate = null)
    {
        $referenceDate = $testDate ?: now();
        
        return $tenants->filter(function($tenant) use ($referenceDate) {
            // Only active tenants
            if ($tenant->status !== 'active') {
                return false;
            }
            
            // Check if they have a lease that expires within 15 days
            if (!$tenant->lease || !$tenant->lease->end_date) {
                return false;
            }
            
            $daysUntilExpiration = $referenceDate->diffInDays($tenant->lease->end_date, false);
            return $daysUntilExpiration >= 0 && $daysUntilExpiration <= 15;
        })->map(function($tenant) use ($referenceDate) {
            return [
                'tenant' => $tenant,
                'lease' => $tenant->lease,
                'days_until_expiration' => round($referenceDate->diffInDays($tenant->lease->end_date, false)),
                'expiration_date' => $tenant->lease->end_date->format('M j, Y')
            ];
        })->sortBy('days_until_expiration');
    }
}
