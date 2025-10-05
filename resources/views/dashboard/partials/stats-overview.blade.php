<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg p-6">
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Monthly Revenue</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">₱{{ number_format($totalMonthlyRevenue, 2) }}</p>
            <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                <span class="inline-flex items-center">
                    <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $revenueComparisonText }}
                </span>
            </p>
        </div>
        <div class="mt-4">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Target: ₱{{ number_format($monthlyTarget, 2) }}</span>
                <span class="text-gray-600 dark:text-gray-400">{{ $targetPercentage }}%</span>
            </div>
            <div class="mt-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-green-600 h-2 rounded-full" style="width: {{ min($targetPercentage, 100) }}%"></div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg p-6">
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Outstanding Payments</p>
            <p class="text-2xl font-bold text-gray-600 dark:text-gray-400">₱{{ number_format($outstandingPayments, 2) }}</p>
            <p class="text-xs {{ str_starts_with($outstandingComparisonText, '+') ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }} mt-1">
                <span class="inline-flex items-center">
                    @if(str_starts_with($outstandingComparisonText, '+'))
                        <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    @else
                        <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                    {{ $outstandingComparisonText }}
                </span>
            </p>
        </div>
        <div class="mt-4">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Overdue: {{ $overdueCount }} tenants</span>
                <span class="text-gray-600 dark:text-gray-400">₱{{ number_format($overdueAmount, 2) }}</span>
            </div>
            <div class="mt-1 grid grid-cols-2 gap-2 text-xs">
                @if($overdueDetails->where('days_overdue', '>', 30)->count() > 0)
                    <div class="bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 px-2 py-1 rounded">
                        ₱{{ number_format($overdueDetails->where('days_overdue', '>', 30)->sum('amount'), 2) }} overdue >30 days
                    </div>
                @endif
                @if($overdueDetails->where('days_overdue', '<=', 30)->count() > 0)
                    <div class="bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-400 px-2 py-1 rounded">
                        {{ $overdueDetails->where('days_overdue', '<=', 30)->count() }} payments pending
                    </div>
                @endif
                @if($overdueCount == 0)
                    <div class="bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 px-2 py-1 rounded">
                        All payments on time
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg p-6">
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Monthly Expenses</p>
            <p class="text-2xl font-bold text-gray-600 dark:text-gray-400">₱{{ number_format($monthlyExpenses, 2) }}</p>
            <p class="text-xs text-red-600 dark:text-red-400 mt-1">
                <span class="inline-flex items-center">
                    <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $expensesComparisonText }}
                </span>
            </p>
        </div>
        <div class="mt-4">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Budget: ₱{{ number_format($expensesBudget, 2) }}</span>
                <span class="text-gray-600 dark:text-gray-400">{{ $expensesBudgetPercentage }}%</span>
            </div>
            <div class="mt-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-red-600 h-2 rounded-full" style="width: {{ min($expensesBudgetPercentage, 100) }}%"></div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-1 text-xs">
                @forelse($expensesByCategory as $category => $amount)
                    <div class="bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-400 px-2 py-1 rounded">
                        ₱{{ number_format($amount, 2) }} {{ ucfirst($category) }}
                    </div>
                @empty
                    <div class="bg-gray-50 dark:bg-gray-900/20 text-gray-700 dark:text-gray-400 px-2 py-1 rounded">
                        No expenses this month
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg p-6">
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Lease Status</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $activeCount }} Active</p>
            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                <span class="inline-flex items-center">
                    <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $expiringSoonCount }} expiring soon
                </span>
            </p>
        </div>
        <div class="mt-4">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Expired: {{ $expiredCount }}</span>
                <span class="text-gray-600 dark:text-gray-400">Total: {{ $activeCount + $expiredCount + $expiringSoonCount }}</span>
            </div>
            <div class="mt-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $activeCount + $expiredCount + $expiringSoonCount > 0 ? round(($activeCount / ($activeCount + $expiredCount + $expiringSoonCount)) * 100) : 0 }}%"></div>
            </div>
            <div class="mt-2 grid grid-cols-2 gap-1 text-xs">
                @if($expiringDetails->count() > 0)
                    @foreach($expiringDetails->take(2) as $detail)
                        <div class="bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-400 px-2 py-1 rounded">
                            {{ $detail['tenant']->user->name ?? 'Unknown' }} - {{ $detail['days_until_expiration'] }} days
                        </div>
                    @endforeach
                @else
                    <div class="bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400 px-2 py-1 rounded">
                        No expiring leases
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg p-6">
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Financial Summary</p>
            <p class="text-2xl font-bold {{ $netProfit >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                ₱{{ number_format($netProfit, 2) }}
            </p>
            <p class="text-xs {{ str_starts_with($profitComparisonText, '+') ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} mt-1">
                <span class="inline-flex items-center">
                    @if(str_starts_with($profitComparisonText, '+'))
                        <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    @else
                        <svg class="w-2.5 h-2.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                    {{ $profitComparisonText }}
                </span>
            </p>
        </div>
        <div class="mt-4">
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">Profit Margin</span>
                <span class="text-gray-600 dark:text-gray-400">{{ $profitMargin }}%</span>
            </div>
            <div class="mt-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="{{ $netProfit >= 0 ? 'bg-green-600' : 'bg-red-600' }} h-2 rounded-full" style="width: {{ min(abs($profitMargin), 100) }}%"></div>
            </div>
            <div class="mt-3 flex justify-center">
                <button class="inline-flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 border border-gray-300 dark:border-gray-600 px-3 py-1.5 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export PDF
                </button>
            </div>
        </div>
    </div>
</div>
