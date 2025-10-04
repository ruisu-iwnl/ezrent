<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\UnitFeeLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Development helper: Override current date for testing
        $testDate = $request->get('test_date') ? \Carbon\Carbon::parse($request->get('test_date')) : null;

        if ($user->role === 'admin') {
            $unitsQuery = Unit::with(['leases.tenant.user', 'admin']);
            
            if ($request->filled('status_filter')) {
                $unitsQuery->where('status', $request->status_filter);
            }
            
            if ($request->filled('search')) {
                $searchTerm = $request->search;
                $unitsQuery->where(function($query) use ($searchTerm) {
                    $query->where('code', 'like', "%{$searchTerm}%")
                          ->orWhere('description', 'like', "%{$searchTerm}%");
                });
            }
            
            $units = $unitsQuery->get();
            $payments = Payment::with(['lease.tenant.user', 'lease.unit'])->latest()->take(10)->get();
            $tenants = Tenant::with(['user', 'lease.unit'])->get();
            $expenses = UnitFeeLog::with(['unit', 'lease.tenant.user', 'logger'])->get();

            $allLeases = Lease::with(['tenant.user', 'unit'])
                ->where(function($query) {
                    $query->whereNull('end_date')
                          ->orWhere('end_date', '>', now());
                })
                ->whereHas('tenant.user')
                ->whereHas('unit')
                ->get();

            $leases = $allLeases->filter(function($lease) use ($testDate) {
                return $lease->getRentDueStatus($testDate) === 'due';
            });

            $referenceDate = $testDate ?: now();
            $currentYear = $referenceDate->year;
            $currentMonth = $referenceDate->month;
            
            $previousMonth = $referenceDate->copy()->subMonth();
            $previousYear = $previousMonth->year;
            $previousMonthNumber = $previousMonth->month;
            
            $totalMonthlyRevenue = $payments->filter(function($payment) use ($currentYear, $currentMonth) {
                return $payment->paid_at->year === $currentYear && $payment->paid_at->month === $currentMonth;
            })->sum('amount');
            
            $outstandingPayments = $allLeases->sum(function($lease) use ($currentYear, $currentMonth) {
                return $lease->getRemainingAmountForMonth($currentYear, $currentMonth);
            });
            
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
            
           
            $expensesPreviousMonth = \Carbon\Carbon::create($expensesYear, $expensesMonth, 1)->subMonth();
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
            
            $previousMonthRevenue = $payments->filter(function($payment) use ($previousYear, $previousMonthNumber) {
                return $payment->paid_at->year === $previousYear && $payment->paid_at->month === $previousMonthNumber;
            })->sum('amount');
            
            $revenueDifference = $totalMonthlyRevenue - $previousMonthRevenue;
            $revenueComparison = $revenueDifference >= 0 ? '+' : '';
            $revenueComparisonText = $revenueComparison . '₱' . number_format(abs($revenueDifference), 2) . ' vs last month';
            
            $monthlyTarget = $allLeases->sum('monthly_rent');
            $targetPercentage = $monthlyTarget > 0 ? round(($totalMonthlyRevenue / $monthlyTarget) * 100) : 0;
            
            $overdueLeases = $allLeases->filter(function($lease) use ($currentYear, $currentMonth, $referenceDate) {

                $remainingAmount = $lease->getRemainingAmountForMonth($currentYear, $currentMonth);
                if ($remainingAmount <= 0) return false; 
                
               
                $monthStart = $referenceDate->copy()->startOfMonth();
                $gracePeriodEnd = $monthStart->copy()->addDays(5);
                
                return $referenceDate->greaterThan($gracePeriodEnd);
            });
            
            $overdueAmount = $overdueLeases->sum(function($lease) use ($currentYear, $currentMonth) {
                return $lease->getRemainingAmountForMonth($currentYear, $currentMonth);
            });
            
            $overdueCount = $overdueLeases->count();
            
           
            $overdueDetails = $overdueLeases->map(function($lease) use ($currentYear, $currentMonth, $referenceDate) {
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

            return view('dashboard', compact('units', 'payments', 'tenants', 'expenses', 'leases', 'testDate', 'totalMonthlyRevenue', 'outstandingPayments', 'monthlyExpenses', 'revenueComparisonText', 'monthlyTarget', 'targetPercentage', 'overdueAmount', 'overdueCount', 'overdueDetails', 'expensesByCategory', 'expensesComparisonText', 'expensesBudget', 'expensesBudgetPercentage'));
        } else {
            $tenant = Tenant::where('user_id', $user->id)->with(['lease.unit'])->first();

            return view('dashboard', compact('tenant'));
        }
    }
}
