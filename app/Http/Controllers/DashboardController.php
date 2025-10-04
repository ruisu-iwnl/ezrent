<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\UnitFeeLog;
use App\Services\DashboardStatsService;
use App\Services\LeaseStatusService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $testDate = $request->get('test_date') ? \Carbon\Carbon::parse($request->get('test_date')) : null;

        if ($user->role === 'admin') {
            return $this->getAdminDashboard($request, $testDate);
        } else {
            return $this->getTenantDashboard($user);
        }
    }

    private function getAdminDashboard(Request $request, $testDate)
    {

        $data = $this->getBaseData($request);
        
        foreach ($data['units'] as $unit) {
            $unit->handleExpiredLeases($testDate);
            $unit->updateStatusFromLease($testDate);
        }

        $statsService = new DashboardStatsService();
        $stats = $statsService->calculateMonthlyStats(
            $data['payments'], 
            $data['allLeases'], 
            $data['expenses'], 
            $testDate
        );

        $leaseService = new LeaseStatusService();
        $leaseStatus = $leaseService->getLeaseStatusSummary($data['allLeases'], $testDate);
        $leases = $leaseService->getRentDueLeases($data['allLeases'], $testDate);

        $viewData = array_merge($data, $stats, $leaseStatus, [
            'leases' => $leases,
            'testDate' => $testDate,
        ]);

        return view('dashboard', $viewData);
    }

    private function getTenantDashboard($user)
    {
        $tenant = Tenant::where('user_id', $user->id)->with(['lease.unit'])->first();
        return view('dashboard', compact('tenant'));
    }

    private function getBaseData(Request $request)
    {
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
            ->whereHas('tenant.user')
            ->whereHas('unit')
            ->get();

        return compact('units', 'payments', 'tenants', 'expenses', 'allLeases');
    }
}
