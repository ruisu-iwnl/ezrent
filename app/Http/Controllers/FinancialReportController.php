<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Lease;
use App\Models\UnitFeeLog;
use App\Services\DashboardStatsService;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    public function index(Request $request)
    {
        $testDate = $request->get('test_date') ? \Carbon\Carbon::parse($request->get('test_date')) : null;
        
        $payments = Payment::with(['lease.tenant.user', 'lease.unit'])->get();
        $allLeases = Lease::with(['tenant.user', 'unit'])
            ->whereHas('tenant.user')
            ->whereHas('unit')
            ->get();
        $expenses = UnitFeeLog::with(['unit', 'lease.tenant.user', 'logger'])->get();

        $statsService = new DashboardStatsService();
        $stats = $statsService->calculateMonthlyStats($payments, $allLeases, $expenses, $testDate);

        $referenceDate = $testDate ?: now();
        $currentYear = $referenceDate->year;
        $currentMonth = $referenceDate->month;

        $monthlyPayments = $payments->filter(function($payment) use ($currentYear, $currentMonth) {
            return $payment->paid_at->year === $currentYear && $payment->paid_at->month === $currentMonth;
        });

        $monthlyExpenses = $expenses->filter(function($expense) use ($currentYear, $currentMonth) {
            return $expense->incurred_at && 
                   $expense->incurred_at->year === $currentYear && 
                   $expense->incurred_at->month === $currentMonth;
        });

        $outstandingLeases = $allLeases->filter(function($lease) use ($testDate) {
            return $lease->tenant->status === 'active';
        });

        return view('reports.financial', [
            'stats' => $stats,
            'monthlyPayments' => $monthlyPayments,
            'monthlyExpenses' => $monthlyExpenses,
            'outstandingLeases' => $outstandingLeases,
            'currentMonth' => $referenceDate->format('F Y'),
            'testDate' => $testDate,
        ]);
    }
}
