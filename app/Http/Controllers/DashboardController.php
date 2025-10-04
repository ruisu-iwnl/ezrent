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
            $expenses = UnitFeeLog::with(['unit', 'lease.tenant.user', 'logger'])->latest()->take(10)->get();
            $leases = Lease::with(['tenant.user', 'unit'])
                ->where(function($query) {
                    $query->whereNull('end_date')
                          ->orWhere('end_date', '>', now());
                })
                ->whereHas('tenant.user')
                ->whereHas('unit')
                ->get();

            return view('dashboard', compact('units', 'payments', 'tenants', 'expenses', 'leases'));
        } else {
            $tenant = Tenant::where('user_id', $user->id)->with(['lease.unit'])->first();

            return view('dashboard', compact('tenant'));
        }
    }
}
