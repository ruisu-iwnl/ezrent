<?php

namespace App\Http\Controllers;

use App\Models\UnitFeeLog;
use App\Models\Unit;
use App\Models\Lease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'expense.unit_id' => 'required|exists:units,id',
            'expense.lease_id' => 'nullable|exists:leases,id',
            'expense.category' => 'required|string|max:255',
            'expense.description' => 'nullable|string|max:1000',
            'expense.amount' => 'required|numeric|min:0',
            'expense.incurred_at' => 'nullable|date',
            'expense.attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $expense = UnitFeeLog::create([
            'unit_id' => $request->input('expense.unit_id'),
            'lease_id' => $request->input('expense.lease_id'),
            'logged_by' => Auth::id(),
            'category' => $request->input('expense.category'),
            'description' => $request->input('expense.description'),
            'amount' => $request->input('expense.amount'),
            'incurred_at' => $request->input('expense.incurred_at') ?: now()->toDateString(),
            'attachment_path' => $request->hasFile('expense.attachment') ? $request->file('expense.attachment')->store('expense_attachments', 'public') : null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Expense recorded successfully!');
    }

    public function update(Request $request, UnitFeeLog $expense)
    {
        $request->validate([
            'expense.description' => 'nullable|string|max:1000',
            'expense.amount' => 'required|numeric|min:0',
            'expense.category' => 'required|string|max:255',
        ]);

        $expense->update([
            'description' => $request->input('expense.description'),
            'amount' => $request->input('expense.amount'),
            'category' => $request->input('expense.category'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Expense updated successfully!');
    }
}
