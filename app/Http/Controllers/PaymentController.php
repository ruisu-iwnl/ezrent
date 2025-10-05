<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validateWithBag('payment', [
            'payment.lease_id' => 'required|exists:leases,id',
            'payment.amount' => 'required|numeric|min:0',
            'payment.paid_at' => 'required|date',
            'payment.method' => 'required|string|max:255',
            'payment.reference' => [
                'nullable','string','max:255',
                Rule::unique('payments','reference'),
            ],
            'payment.notes' => 'nullable|string|max:100',
            'payment.receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'payment.reference.unique' => 'This payment reference already exists. Please use a different reference.',
        ]);

        $lease = \App\Models\Lease::findOrFail($request->input('payment.lease_id'));
        $paymentDate = \Carbon\Carbon::parse($request->input('payment.paid_at'));
        $remainingAmount = $lease->getRemainingAmountForMonth($paymentDate->year, $paymentDate->month);
        
        if ($request->input('payment.amount') > $remainingAmount) {
            return redirect()->back()
                ->withErrors(['payment.amount' => "Payment amount cannot exceed remaining due amount of ₱" . number_format($remainingAmount, 2)])
                ->withInput();
        }

        DB::transaction(function () use ($request) {
            $receiptPath = null;
            if ($request->hasFile('payment.receipt')) {
                $receiptPath = $request->file('payment.receipt')->store('payment_receipts', 'public');
            }

            Payment::create([
                'lease_id' => $request->input('payment.lease_id'),
                'amount' => $request->input('payment.amount'),
                'paid_at' => $request->input('payment.paid_at'),
                'method' => $request->input('payment.method'),
                'reference' => $request->input('payment.reference'),
                'notes' => $request->input('payment.notes'),
                'receipt_path' => $receiptPath,
            ]);
        });

        return redirect()->route('dashboard')->with('success', 'Payment recorded successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validateWithBag('payment', [
            'payment.amount' => 'required|numeric|min:0',
            'payment.method' => 'required|string|max:255',
            'payment.reference' => [
                'nullable','string','max:255',
                Rule::unique('payments','reference')->ignore($payment->id),
            ],
            'payment.notes' => 'nullable|string|max:100',
        ], [
            'payment.reference.unique' => 'This payment reference already exists. Please use a different reference.',
        ]);

        // Get the lease and validate amount for edit
        $lease = $payment->lease;
        $paymentDate = $payment->paid_at;
        
        // Calculate remaining amount excluding current payment being edited
        $otherPayments = $lease->payments()
            ->whereYear('paid_at', $paymentDate->year)
            ->whereMonth('paid_at', $paymentDate->month)
            ->where('id', '!=', $payment->id)
            ->sum('amount');
            
        $remainingAmount = $lease->monthly_rent - $otherPayments;
        
        if ($request->input('payment.amount') > $remainingAmount) {
            return redirect()->back()
                ->withErrors(['payment.amount' => "Payment amount cannot exceed remaining due amount of ₱" . number_format($remainingAmount, 2)])
                ->withInput();
        }

        $payment->update([
            'amount' => $request->input('payment.amount'),
            'method' => $request->input('payment.method'),
            'reference' => $request->input('payment.reference'),
            'notes' => $request->input('payment.notes'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Payment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
