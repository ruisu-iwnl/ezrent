<div x-show="$store.ui.showPayment" x-cloak class="fixed inset-0 z-[110] flex items-center justify-center">
    <div class="fixed inset-0 w-screen h-screen bg-black/60" @click="$store.ui.showPayment=false"></div>
    <div class="relative z-[120] w-full max-w-2xl bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
            <h4 class="font-medium">Add Payment</h4>
            <button class="text-gray-500" @click="$store.ui.showPayment=false">✕</button>
        </div>
        <div class="p-4 space-y-4">
            <div>
                <label class="text-sm block mb-1">Lease (Tenant & Unit)</label>
                <select name="payment[lease_id]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                    <option value="">Select a lease...</option>
                    <option value="1">John Tenant - A-201 (₱10,000/month)</option>
                    <option value="2">Jane Doe - A-202 (₱12,000/month)</option>
                </select>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm block mb-1">Amount</label>
                    <input name="payment[amount]" type="number" step="0.01" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="0.00">
                </div>
                <div>
                    <label class="text-sm block mb-1">Payment Method</label>
                    <select name="payment[method]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                        <option value="">Select method...</option>
                        <option value="cash">Cash</option>
                        <option value="gcash">GCash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="check">Check</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm block mb-1">Paid At</label>
                    <input name="payment[paid_at]" type="datetime-local" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                </div>
                <div>
                    <label class="text-sm block mb-1">Reference</label>
                    <input name="payment[reference]" type="text" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="Transaction ID, Check #, etc.">
                </div>
            </div>
            <div>
                <label class="text-sm block mb-1">Receipt Picture</label>
                <input name="payment[receipt]" type="file" accept="image/*" class="w-full text-sm">
                <p class="text-xs text-gray-500 mt-1">Upload receipt image (JPG, PNG, etc.)</p>
            </div>
            <div>
                <label class="text-sm block mb-1">Notes</label>
                <textarea name="payment[notes]" rows="3" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="Additional payment details (optional)"></textarea>
            </div>
        </div>
        <div class="px-4 pb-4 flex items-center justify-end gap-2">
            <button class="px-3 py-2 rounded-md border" @click="$store.ui.showPayment=false">Cancel</button>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Record Payment</button>
        </div>
    </div>
</div>
