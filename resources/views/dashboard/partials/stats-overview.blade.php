<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Monthly Revenue</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">₱{{ number_format($totalMonthlyRevenue, 2) }}</p>
                <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                    <span class="inline-flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $revenueComparisonText }}
                    </span>
                </p>
            </div>
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
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
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Outstanding Payments</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">₱{{ number_format($outstandingPayments, 2) }}</p>
                <p class="text-xs text-orange-600 dark:text-orange-400 mt-1">
                    <span class="inline-flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        +₱1,500 vs last month
                    </span>
                </p>
            </div>
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>
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
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Monthly Expenses</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">₱{{ number_format($monthlyExpenses, 2) }}</p>
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1">
                            <span class="inline-flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $expensesComparisonText }}
                            </span>
                        </p>
            </div>
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
            </div>
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
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Lease Status</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $activeCount }} Active</p>
                <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                    <span class="inline-flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $expiringSoonCount }} expiring soon
                    </span>
                </p>
            </div>
            <div class="flex-shrink-0">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
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
                            {{ $detail['lease']->tenant->user->name ?? 'Unknown' }} - {{ $detail['days_until_expiration'] }} days
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
</div>
