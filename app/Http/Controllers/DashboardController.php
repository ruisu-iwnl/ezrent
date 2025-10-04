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
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $units = Unit::with(['leases.tenant.user', 'admin'])->get();
            $payments = Payment::with(['lease.tenant.user', 'lease.unit'])->latest()->take(10)->get();
            $tenants = Tenant::with(['user', 'lease.unit'])->get();
            $expenses = UnitFeeLog::with(['unit', 'lease.tenant.user', 'logger'])->latest()->take(10)->get();
            
            return view('dashboard', compact('units', 'payments', 'tenants', 'expenses'));
        } else {
            $tenant = Tenant::where('user_id', $user->id)->with(['lease.unit'])->first();
            
            return view('dashboard', compact('tenant'));
        }
    }
}
