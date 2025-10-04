<div x-show="$store.ui.showExpense" x-cloak class="fixed inset-0 z-[110] flex items-center justify-center">
    <div class="fixed inset-0 w-screen h-screen bg-black/60" @click="$store.ui.showExpense=false"></div>
    <div class="relative z-[120] w-full max-w-2xl bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
            <h4 class="font-medium">Add Expense</h4>
            <button class="text-gray-500" @click="$store.ui.showExpense=false">✕</button>
        </div>
        <div class="p-4 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm block mb-1">Unit</label>
                    <select name="expense[unit_id]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                        <option value="">Select a unit...</option>
                        <option value="1">A-201</option>
                        <option value="2">A-202</option>
                        <option value="3">B-101</option>
                        <option value="4">Office</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm block mb-1">Lease (Optional)</label>
                    <select name="expense[lease_id]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                        <option value="">No specific lease...</option>
                        <option value="1">John Tenant - A-201</option>
                        <option value="2">Jane Doe - A-202</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm block mb-1">Category</label>
                    <select name="expense[category]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                        <option value="">Select category...</option>
                        <option value="repair">Repair</option>
                        <option value="utilities">Utilities</option>
                        <option value="labor">Labor</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm block mb-1">Amount</label>
                    <input name="expense[amount]" type="number" step="0.01" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="0.00">
                </div>
            </div>
            <div>
                <label class="text-sm block mb-1">Incurred At</label>
                <input name="expense[incurred_at]" type="date" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700">
            </div>
            <div>
                <label class="text-sm block mb-1">Description</label>
                <textarea name="expense[description]" rows="3" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="Describe the expense (optional)"></textarea>
            </div>
            <div>
                <label class="text-sm block mb-1">Attachment</label>
                <input name="expense[attachment]" type="file" accept="image/*,.pdf" class="w-full text-sm">
                <p class="text-xs text-gray-500 mt-1">Upload receipt, bill, or invoice (JPG, PNG, PDF)</p>
            </div>
        </div>
        <div class="px-4 pb-4 flex items-center justify-end gap-2">
            <button class="px-3 py-2 rounded-md border" @click="$store.ui.showExpense=false">Cancel</button>
            <button class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Record Expense</button>
        </div>
    </div>
</div>
