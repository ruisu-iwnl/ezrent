<div x-data x-init="$store.ui.showExpense = $store.ui.showExpense || @js($errors->getBag('expense')->any())" x-show="$store.ui.showExpense" x-cloak x-transition class="fixed inset-0 z-[110] flex items-center justify-center">
    <div class="fixed inset-0 w-screen h-screen bg-black/60 transition-none" @click="$store.ui.showExpense=false"></div>
    <div class="relative z-[120] w-full max-w-2xl bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
            <h4 class="font-medium">Add Expense</h4>
            <button class="text-gray-500" @click="$store.ui.showExpense=false">✕</button>
        </div>
        <form method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="p-4 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm block mb-1">Unit</label>
                    <select name="expense[unit_id]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('expense.unit_id','expense') border-red-500 @enderror">
                        <option value="">Select a unit...</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('expense.unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->code }}</option>
                        @endforeach
                    </select>
                    @error('expense.unit_id','expense')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm block mb-1">Lease (Optional)</label>
                    <select name="expense[lease_id]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('expense.lease_id','expense') border-red-500 @enderror">
                        <option value="">No specific lease...</option>
                        @foreach($units->where('status', 'occupied') as $unit)
                            @if($unit->leases->isNotEmpty())
                                @php($lease = $unit->leases->first())
                                <option value="{{ $lease->id }}" {{ old('expense.lease_id') == $lease->id ? 'selected' : '' }}>{{ $lease->tenant->user->name }} - {{ $unit->code }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('expense.lease_id','expense')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm block mb-1">Category</label>
                    <select name="expense[category]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('expense.category','expense') border-red-500 @enderror">
                        <option value="">Select category...</option>
                        <option value="repair" {{ old('expense.category') == 'repair' ? 'selected' : '' }}>Repair</option>
                        <option value="utilities" {{ old('expense.category') == 'utilities' ? 'selected' : '' }}>Utilities</option>
                        <option value="labor" {{ old('expense.category') == 'labor' ? 'selected' : '' }}>Labor</option>
                        <option value="maintenance" {{ old('expense.category') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="other" {{ old('expense.category') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('expense.category','expense')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm block mb-1">Amount</label>
                    <input name="expense[amount]" type="number" step="0.01" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('expense.amount','expense') border-red-500 @enderror" placeholder="0.00" value="{{ old('expense.amount') }}">
                    @error('expense.amount','expense')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div>
                <label class="text-sm block mb-1">Incurred At</label>
                <input name="expense[incurred_at]" type="date" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('expense.incurred_at','expense') border-red-500 @enderror" value="{{ old('expense.incurred_at') }}">
                @error('expense.incurred_at','expense')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="text-sm block mb-1">Description</label>
                <textarea name="expense[description]" rows="3" maxlength="100" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('expense.description','expense') border-red-500 @enderror" placeholder="Describe the expense (max 100 chars)">{{ old('expense.description') }}</textarea>
                <div class="text-xs text-gray-500 mt-1">Max 100 characters</div>
                @error('expense.description','expense')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="text-sm block mb-1">Attachment</label>
                <input name="expense[attachment]" type="file" accept="image/*,.pdf" class="w-full text-sm @error('expense.attachment','expense') border-red-500 @enderror">
                <p class="text-xs text-gray-500 mt-1">Upload receipt, bill, or invoice (JPG, PNG, PDF)</p>
                @error('expense.attachment','expense')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
            <div class="px-4 pb-4 flex items-center justify-end gap-2">
                <button type="button" class="px-3 py-2 rounded-md border" @click="$store.ui.showExpense=false">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Record Expense</button>
            </div>
        </form>
    </div>
</div>
