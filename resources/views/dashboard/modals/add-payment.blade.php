<div x-data x-init="$store.ui.showPayment = $store.ui.showPayment || @js($errors->getBag('payment')->any())" x-show="$store.ui.showPayment" x-cloak x-transition class="fixed inset-0 z-[110] flex items-center justify-center">
    <div class="fixed inset-0 w-screen h-screen bg-black/60 transition-none" @click="$store.ui.showPayment=false"></div>
    <div class="relative z-[120] w-full max-w-2xl bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
            <h4 class="font-medium">Add Payment</h4>
            <button class="text-gray-500" @click="$store.ui.showPayment=false">✕</button>
        </div>
        <form method="POST" action="{{ route('payments.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="p-4 space-y-4">
                <div>
                    <label class="text-sm block mb-1">Lease (Tenant & Unit)</label>
                    <select name="payment[lease_id]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('payment.lease_id','payment') border-red-500 @enderror" required>
                        <option value="">Select a lease...</option>
                        @forelse($leases as $lease)
                            @php
                                $referenceDate = $testDate ?: now();
                                $remainingAmount = $lease->getRemainingAmountForMonth($referenceDate->year, $referenceDate->month);
                            @endphp
                            <option value="{{ $lease->id }}" {{ old('payment.lease_id') == $lease->id ? 'selected' : '' }}>
                                {{ $lease->tenant->user->name ?? 'Unknown Tenant' }} - {{ $lease->unit->code ?? 'Unknown Unit' }} (Due: ₱{{ number_format($remainingAmount, 2) }})
                            </option>
                        @empty
                            <option value="" disabled>No active leases found</option>
                        @endforelse
                    </select>
                    @error('payment.lease_id','payment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm block mb-1">Amount</label>
                    <input name="payment[amount]" type="number" step="0.01" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('payment.amount','payment') border-red-500 @enderror" placeholder="0.00" value="{{ old('payment.amount') }}" required>
                    @error('payment.amount','payment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm block mb-1">Payment Method</label>
                    <select name="payment[method]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('payment.method','payment') border-red-500 @enderror" required>
                        <option value="">Select method...</option>
                        <option value="cash" {{ old('payment.method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="gcash" {{ old('payment.method') == 'gcash' ? 'selected' : '' }}>GCash</option>
                        <option value="bank_transfer" {{ old('payment.method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="check" {{ old('payment.method') == 'check' ? 'selected' : '' }}>Check</option>
                    </select>
                    @error('payment.method','payment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm block mb-1">Paid At</label>
                    <input name="payment[paid_at]" type="datetime-local" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('payment.paid_at','payment') border-red-500 @enderror" value="{{ old('payment.paid_at') }}" required>
                    @error('payment.paid_at','payment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm block mb-1">Reference</label>
                    <input name="payment[reference]" type="text" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('payment.reference','payment') border-red-500 @enderror" placeholder="Transaction ID, Check #, etc." value="{{ old('payment.reference') }}">
                    @error('payment.reference','payment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
                <div>
                    <label class="text-sm block mb-1">Receipt Picture</label>
                    <input name="payment[receipt]" type="file" accept="image/*" class="w-full text-sm @error('payment.receipt','payment') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Upload receipt image (JPG, PNG, etc.)</p>
                    @error('payment.receipt','payment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm block mb-1">Notes</label>
                    <textarea name="payment[notes]" rows="3" maxlength="100" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('payment.notes','payment') border-red-500 @enderror" placeholder="Additional payment details (max 100 chars)">{{ old('payment.notes') }}</textarea>
                    <div class="text-xs text-gray-500 mt-1">Max 100 characters</div>
                    @error('payment.notes','payment')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="px-4 pb-4 flex items-center justify-end gap-2">
                <button type="button" class="px-3 py-2 rounded-md border" @click="$store.ui.showPayment=false">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Record Payment</button>
            </div>
        </form>
    </div>
</div>
