<div id="payments-table" class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg" data-test-date="{{ $testDate ? $testDate->format('Y-m-d') : '' }}" data-this-month-count="{{ $payments->filter(function($payment) use ($testDate) { $referenceDate = $testDate ?: now(); return $payment->paid_at->year === $referenceDate->year && $payment->paid_at->month === $referenceDate->month; })->count() }}">
    <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <h4 class="font-medium">Payments Management</h4>
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <span>Total: <span class="font-medium">{{ $payments->count() }}</span></span>
                <span>•</span>
                <span>This Month: <span class="font-medium text-green-600">{{ $payments->filter(function($payment) use ($testDate) { $referenceDate = $testDate ?: now(); return $payment->paid_at->year === $referenceDate->year && $payment->paid_at->month === $referenceDate->month; })->count() }}</span></span>
                <span>•</span>
                <span>Cash: <span class="font-medium text-green-600">{{ $payments->where('method', 'cash')->count() }}</span></span>
                <span>•</span>
                <span>GCash: <span class="font-medium text-blue-600">{{ $payments->where('method', 'gcash')->count() }}</span></span>
                <span>•</span>
                <span>Bank Transfer: <span class="font-medium text-purple-600">{{ $payments->where('method', 'bank_transfer')->count() }}</span></span>
                <span>•</span>
                <span>Check: <span class="font-medium text-yellow-600">{{ $payments->where('method', 'check')->count() }}</span></span>
                <span x-show="$store.ui.editingRowId && $store.ui.editingTable === 'payment'" x-cloak x-transition class="ml-4">
                    <button @click="saveCurrentPayment()" class="px-3 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700">Save</button>
                    <button @click="cancelPaymentEditing()" class="px-3 py-1 text-xs bg-gray-600 text-white rounded hover:bg-gray-700 ml-1">Cancel</button>
                </span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <select name="month_filter" class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm">
                <option value="">All Months</option>
                @foreach($availableMonths as $month)
                    <option value="{{ $month['value'] }}" {{ $month['selected'] ? 'selected' : '' }}>
                        {{ $month['label'] }}
                    </option>
                @endforeach
            </select>
            <input type="text" name="search" placeholder="Search tenant or unit..." class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm w-48">
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-900/40">
                <tr>
                    <th class="text-left px-4 py-3 font-medium">Date</th>
                    <th class="text-left px-4 py-3 font-medium">Tenant</th>
                    <th class="text-left px-4 py-3 font-medium">Unit</th>
                    <th class="text-left px-4 py-3 font-medium">Amount</th>
                    <th class="text-left px-4 py-3 font-medium">Method</th>
                    <th class="text-left px-4 py-3 font-medium">Reference</th>
                    <th class="text-left px-4 py-3 font-medium">Notes</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $selectedMonth = request('month_filter');

                    if (!$selectedMonth) {
                        $defaultMonth = collect($availableMonths)->firstWhere('selected', true);
                        $selectedMonth = $defaultMonth ? $defaultMonth['value'] : null;
                    }
                    
                    $filteredPayments = $payments;
                    if ($selectedMonth) {
                        $filteredPayments = $payments->filter(function($payment) use ($selectedMonth) {
                            return $payment->paid_at->format('Y-m') === $selectedMonth;
                        });
                    }
                @endphp
                @forelse($filteredPayments as $payment)
                <tr x-data="{ payment: { id: {{ $payment->id }}, amount: {{ $payment->amount }}, method: '{{ $payment->method }}', reference: '{{ $payment->reference }}', notes: '{{ $payment->notes }}' }, editing: false }" 
                    class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50"
                    data-original-amount="{{ $payment->amount }}"
                    data-original-method="{{ $payment->method }}"
                    data-original-reference="{{ $payment->reference }}"
                    data-original-notes="{{ $payment->notes }}">
                    <td class="px-4 py-3 font-medium">{{ $payment->paid_at->format('M j, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col">
                            <span class="font-medium">{{ $payment->lease->tenant->user->name }}</span>
                            <span class="text-xs text-gray-500">{{ $payment->lease->tenant->user->email }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium">{{ $payment->lease->unit->code }}</td>
                    <td class="px-4 py-3 font-medium text-green-600">
                        <div x-show="!editing" @click="startEditingPayment(payment.id); editing = true" class="cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400">₱{{ number_format($payment->amount, 2) }}</div>
                        <input x-show="editing" x-cloak x-model="payment.amount" type="number" step="0.01" class="w-full px-2 py-1 text-sm border rounded dark:bg-gray-700 dark:border-gray-600" placeholder="Amount" @click.stop>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                        <div x-show="!editing" @click="startEditingPayment(payment.id); editing = true" class="cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400">
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs 
                                @if($payment->method === 'cash') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($payment->method === 'gcash') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($payment->method === 'bank_transfer') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                @elseif($payment->method === 'check') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 @endif">
                                {{ ucfirst(str_replace('_', ' ', $payment->method)) }}
                            </span>
                        </div>
                        <select x-show="editing" x-cloak x-model="payment.method" class="w-full px-2 py-1 text-sm border rounded dark:bg-gray-700 dark:border-gray-600" @click.stop>
                            <option value="cash">Cash</option>
                            <option value="gcash">GCash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="check">Check</option>
                        </select>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                        <div x-show="!editing" @click="startEditingPayment(payment.id); editing = true" class="cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400">{{ $payment->reference ?? 'Click to add reference' }}</div>
                        <input x-show="editing" x-cloak x-model="payment.reference" type="text" class="w-full px-2 py-1 text-sm border rounded dark:bg-gray-700 dark:border-gray-600" placeholder="Reference" @click.stop>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                        <div x-show="!editing" @click="startEditingPayment(payment.id); editing = true" class="cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400">{{ $payment->notes ?? 'Click to add notes' }}</div>
                        <textarea x-show="editing" x-cloak x-model="payment.notes" rows="2" class="w-full px-2 py-1 text-sm border rounded dark:bg-gray-700 dark:border-gray-600" placeholder="Notes" @click.stop></textarea>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">No payments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
