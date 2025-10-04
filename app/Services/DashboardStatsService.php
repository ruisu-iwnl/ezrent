<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Lease;
use App\Models\UnitFeeLog;
use Carbon\Carbon;

class DashboardStatsService
{
    public function calculateMonthlyStats($payments, $allLeases, $expenses, $testDate = null)
    {
        $referenceDate = $testDate ?: now();
        $currentYear = $referenceDate->year;
        $currentMonth = $referenceDate->month;
        
        $previousMonth = $referenceDate->copy()->subMonth();
        $previousYear = $previousMonth->year;
        $previousMonthNumber = $previousMonth->month;
        
        $totalMonthlyRevenue = $this->calculateMonthlyRevenue($payments, $currentYear, $currentMonth);
        $previousMonthRevenue = $this->calculateMonthlyRevenue($payments, $previousYear, $previousMonthNumber);
        $revenueDifference = $totalMonthlyRevenue - $previousMonthRevenue;
        $revenueComparison = $revenueDifference >= 0 ? '+' : '';
        $revenueComparisonText = $revenueComparison . '₱' . number_format(abs($revenueDifference), 2) . ' vs last month';
        
        $outstandingPayments = $this->calculateOutstandingPayments($allLeases, $currentYear, $currentMonth, $testDate);
        $previousMonthOutstanding = $this->calculateOutstandingPayments($allLeases, $previousYear, $previousMonthNumber, $testDate);
        $outstandingDifference = $outstandingPayments - $previousMonthOutstanding;
        $outstandingComparison = $outstandingDifference >= 0 ? '+' : '';
        $outstandingComparisonText = $outstandingComparison . '₱' . number_format(abs($outstandingDifference), 2) . ' vs last month';
        
        $monthlyTarget = $this->calculateMonthlyTarget($allLeases, $testDate);
        $targetPercentage = $monthlyTarget > 0 ? round(($totalMonthlyRevenue / $monthlyTarget) * 100) : 0;
        
        $expenseStats = $this->calculateExpenseStats($expenses, $currentYear, $currentMonth);
        
        return [
            'totalMonthlyRevenue' => $totalMonthlyRevenue,
            'previousMonthRevenue' => $previousMonthRevenue,
            'revenueComparisonText' => $revenueComparisonText,
            'outstandingPayments' => $outstandingPayments,
            'outstandingComparisonText' => $outstandingComparisonText,
            'monthlyTarget' => $monthlyTarget,
            'targetPercentage' => $targetPercentage,
            'monthlyExpenses' => $expenseStats['monthlyExpenses'],
            'expensesByCategory' => $expenseStats['expensesByCategory'],
            'expensesComparisonText' => $expenseStats['expensesComparisonText'],
            'expensesBudget' => $expenseStats['expensesBudget'],
            'expensesBudgetPercentage' => $expenseStats['expensesBudgetPercentage'],
        ];
    }
    
    private function calculateMonthlyRevenue($payments, $year, $month)
    {
        return $payments->filter(function($payment) use ($year, $month) {
            return $payment->paid_at->year === $year && $payment->paid_at->month === $month;
        })->sum('amount');
    }
    
    private function calculateOutstandingPayments($allLeases, $currentYear, $currentMonth, $testDate)
    {
        return $allLeases->filter(function($lease) use ($testDate, $currentYear, $currentMonth) {

            return $lease->tenant->status === 'active';
        })->sum(function($lease) use ($currentYear, $currentMonth) {

            return $lease->getRemainingAmountForMonth($currentYear, $currentMonth);
        });
    }
    
    private function calculateMonthlyTarget($allLeases, $testDate)
    {
        return $allLeases->filter(function($lease) use ($testDate) {
            return $lease->getLeaseStatus($testDate) === 'active';
        })->sum('monthly_rent');
    }
    
    private function calculateExpenseStats($expenses, $currentYear, $currentMonth)
    {
        $expensesYear = $currentYear;
        $expensesMonth = $currentMonth;
        
        $monthlyExpenses = $expenses->filter(function($expense) use ($expensesYear, $expensesMonth) {
            return $expense->incurred_at && 
                   $expense->incurred_at->year === $expensesYear && 
                   $expense->incurred_at->month === $expensesMonth;
        })->sum('amount');
        
        $expensesByCategory = $expenses->filter(function($expense) use ($expensesYear, $expensesMonth) {
            return $expense->incurred_at && 
                   $expense->incurred_at->year === $expensesYear && 
                   $expense->incurred_at->month === $expensesMonth;
        })->groupBy('category')->map(function($categoryExpenses) {
            return $categoryExpenses->sum('amount');
        });
        
        // Previous month expenses
        $expensesPreviousMonth = Carbon::create($expensesYear, $expensesMonth, 1)->subMonth();
        $expensesPreviousYear = $expensesPreviousMonth->year;
        $expensesPreviousMonthNumber = $expensesPreviousMonth->month;
        
        $previousMonthExpenses = $expenses->filter(function($expense) use ($expensesPreviousYear, $expensesPreviousMonthNumber) {
            return $expense->incurred_at && 
                   $expense->incurred_at->year === $expensesPreviousYear && 
                   $expense->incurred_at->month === $expensesPreviousMonthNumber;
        })->sum('amount');
        
        $expensesDifference = $monthlyExpenses - $previousMonthExpenses;
        $expensesComparison = $expensesDifference >= 0 ? '+' : '';
        $expensesComparisonText = $expensesComparison . '₱' . number_format(abs($expensesDifference), 2) . ' vs last month';
        
        $expensesBudget = 5000; 
        $expensesBudgetPercentage = $expensesBudget > 0 ? round(($monthlyExpenses / $expensesBudget) * 100) : 0;
        
        return [
            'monthlyExpenses' => $monthlyExpenses,
            'expensesByCategory' => $expensesByCategory,
            'expensesComparisonText' => $expensesComparisonText,
            'expensesBudget' => $expensesBudget,
            'expensesBudgetPercentage' => $expensesBudgetPercentage,
        ];
    }
}
