<div id="expenses-table" class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg">
    <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <h4 class="font-medium">Expenses Management</h4>
            <div class="flex items-center gap-2 text-xs text-gray-500">
                @if($expenses->count() > 0)
                    <span>This Month: <span class="font-medium text-red-600">₱{{ number_format($expenses->where('incurred_at', '>=', now()->startOfMonth())->sum('amount'), 2) }}</span></span>
                    <span>•</span>
                    <span>Repairs: <span class="font-medium text-orange-600">₱{{ number_format($expenses->where('category', 'repair')->sum('amount'), 2) }}</span></span>
                    <span>•</span>
                    <span>Utilities: <span class="font-medium text-blue-600">₱{{ number_format($expenses->where('category', 'utilities')->sum('amount'), 2) }}</span></span>
                    <span>•</span>
                    <span>Labor: <span class="font-medium text-purple-600">₱{{ number_format($expenses->where('category', 'labor')->sum('amount'), 2) }}</span></span>
                @else
                    <span>No expenses recorded yet</span>
                @endif
                <span class="ml-4" x-show="$store.ui.editingRowId && $store.ui.editingTable === 'expense'" x-cloak x-transition>
                    <button @click="saveCurrentExpense()" class="px-2 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700">Save</button>
                    <button @click="cancelExpenseEditing()" class="px-2 py-1 text-xs bg-gray-500 text-white rounded hover:bg-gray-600 ml-1">Cancel</button>
                </span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <select name="category_filter" class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm">
                <option value="">All Categories</option>
                <option value="repair">Repair</option>
                <option value="utilities">Utilities</option>
                <option value="labor">Labor</option>
                <option value="maintenance">Maintenance</option>
                <option value="other">Other</option>
            </select>
            <input type="text" name="search" placeholder="Search description..." class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm w-48">
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-900/40">
                <tr>
                    <th class="text-left px-4 py-3 font-medium">Incurred At</th>
                    <th class="text-left px-4 py-3 font-medium">Category</th>
                    <th class="text-left px-4 py-3 font-medium">Description</th>
                    <th class="text-left px-4 py-3 font-medium">Unit</th>
                    <th class="text-left px-4 py-3 font-medium">Lease</th>
                    <th class="text-left px-4 py-3 font-medium">Amount</th>
                    <th class="text-left px-4 py-3 font-medium">Logged By</th>
                    <th class="text-left px-4 py-3 font-medium">Attachment</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                    <tr x-data="{ expense: @js($expense), editing: false }" 
                        class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50"
                        data-original-description="{{ $expense->description }}"
                        data-original-amount="{{ $expense->amount }}"
                        data-original-category="{{ $expense->category }}">
                        <td class="px-4 py-3 font-medium">{{ $expense->incurred_at ? \Carbon\Carbon::parse($expense->incurred_at)->format('M j, Y') : '-' }}</td>
                         <td class="px-4 py-3">
                             <div x-show="!editing" @click="startEditingExpense(expense.id); editing = true" class="cursor-pointer">
                                 @if($expense->category === 'repair')
                                     <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">Repair</span>
                                 @elseif($expense->category === 'utilities')
                                     <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Utilities</span>
                                 @elseif($expense->category === 'labor')
                                     <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">Labor</span>
                                 @elseif($expense->category === 'maintenance')
                                     <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Maintenance</span>
                                 @else
                                     <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">Other</span>
                                 @endif
                             </div>
                             <select x-show="editing" x-cloak x-model="expense.category" class="text-xs px-2 py-1 border rounded dark:bg-gray-700 dark:border-gray-600" @click.stop>
                                 <option value="repair">Repair</option>
                                 <option value="utilities">Utilities</option>
                                 <option value="labor">Labor</option>
                                 <option value="maintenance">Maintenance</option>
                                 <option value="other">Other</option>
                             </select>
                         </td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                            <div x-show="!editing" @click="startEditingExpense(expense.id); editing = true" class="cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400">{{ $expense->description ?? 'Click to add description' }}</div>
                            <textarea x-show="editing" x-cloak x-model="expense.description" rows="2" class="w-full px-2 py-1 text-sm border rounded dark:bg-gray-700 dark:border-gray-600" @click.stop></textarea>
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $expense->unit->code }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                            @if($expense->lease)
                                {{ $expense->lease->tenant->user->name }} (Lease #{{ $expense->lease->id }})
                            @else
                                <span class="text-gray-500 dark:text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-red-600">
                            <div x-show="!editing" @click="startEditingExpense(expense.id); editing = true" class="cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400">₱{{ number_format($expense->amount, 2) }}</div>
                            <input x-show="editing" x-cloak x-model="expense.amount" type="number" step="0.01" class="w-full px-2 py-1 text-sm border rounded dark:bg-gray-700 dark:border-gray-600" @click.stop>
                        </td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $expense->logger->name }}</td>
                        <td class="px-4 py-3">
                            @if($expense->attachment_path)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✓ Receipt</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-gray-500">No expenses recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
