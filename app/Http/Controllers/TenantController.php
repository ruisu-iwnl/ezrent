<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|email|unique:users,email',
            'tenant.phone' => 'nullable|string|max:20',
            'tenant.date_of_birth' => 'nullable|date',
            'tenant.address' => 'nullable|string|max:500',
            'tenant.notes' => 'nullable|string|max:1000',
            'lease.unit_id' => 'required|exists:units,id',
            'lease.start_date' => 'required|date',
            'lease.end_date' => 'nullable|date|after:lease.start_date',
            'lease.monthly_rent' => 'required|numeric|min:0',
            'lease.security_deposit' => 'nullable|numeric|min:0',
            'lease.notes' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($request) {


            //this is the case for now. i will edit this soon.
            $user = User::create([
                'name' => $request->input('user.name'),
                'email' => $request->input('user.email'),
                'password' => Hash::make('password123'), 
                'role' => 'tenant',
            ]);

            $tenant = Tenant::create([
                'user_id' => $user->id,
                'phone' => $request->input('tenant.phone'),
                'date_of_birth' => $request->input('tenant.date_of_birth'),
                'address' => $request->input('tenant.address'),
                'notes' => $request->input('tenant.notes'),
            ]);

            Lease::create([
                'tenant_id' => $tenant->id,
                'unit_id' => $request->input('lease.unit_id'),
                'start_date' => $request->input('lease.start_date'),
                'end_date' => $request->input('lease.end_date'),
                'monthly_rent' => $request->input('lease.monthly_rent'),
                'security_deposit' => $request->input('lease.security_deposit'),
                'notes' => $request->input('lease.notes'),
            ]);

            Unit::where('id', $request->input('lease.unit_id'))
                ->update(['status' => 'occupied']);
        });

        return redirect()->route('dashboard')->with('success', 'Tenant created and assigned to unit successfully!');
    }

    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'tenant.phone' => 'nullable|string|max:20',
            'tenant.address' => 'nullable|string|max:500',
            'tenant.notes' => 'nullable|string|max:1000',
        ]);

        $tenant->update([
            'phone' => $request->input('tenant.phone'),
            'address' => $request->input('tenant.address'),
            'notes' => $request->input('tenant.notes'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Tenant updated successfully!');
    }
}