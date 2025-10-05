<div x-data class="space-y-6">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Development Helper: Date Override --}}
    @if(config('app.debug'))
        <div class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg p-4 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-medium">🛠️ Development Helper</h4>
                    <p class="text-xs text-gray-500 mt-1">Override current date for testing rent due system</p>
                </div>
                <form method="GET" class="flex items-center gap-2">
                    <input type="date" name="test_date" value="{{ $testDate ? $testDate->format('Y-m-d') : '' }}" 
                           class="text-xs border-gray-300 dark:bg-gray-900 dark:border-gray-700 rounded px-2 py-1">
                    <button type="submit" class="text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                        Test Date
                    </button>
                    @if($testDate)
                        <a href="{{ route('dashboard') }}" class="text-xs bg-gray-600 text-white px-3 py-1 rounded hover:bg-gray-700">
                            Reset
                        </a>
                    @endif
                </form>
            </div>
            @if($testDate)
                <div class="mt-2 text-xs text-gray-500">
                    <strong>Testing as:</strong> {{ $testDate->format('F j, Y') }} ({{ $testDate->format('Y-m') }})
                </div>
            @endif
        </div>
    @endif

    @include('dashboard.partials.stats-overview')

    {{-- Financial Reports Section --}}
    <div class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Monthly Financial Report</h3>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $testDate ? $testDate->format('F Y') : now()->format('F Y') }}
                </span>
                <a href="{{ route('financial-report.index', request()->query()) }}" target="_blank" 
                   class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Full Report
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Revenue Breakdown --}}
            <div>
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Revenue Breakdown</h4>
                <div class="space-y-2">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Total Revenue</span>
                        <span class="font-medium text-green-600 dark:text-green-400">₱{{ number_format($totalMonthlyRevenue, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Monthly Target</span>
                        <span class="font-medium text-gray-900 dark:text-white">₱{{ number_format($monthlyTarget, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Target Achievement</span>
                        <span class="font-medium {{ $targetPercentage >= 100 ? 'text-green-600 dark:text-green-400' : 'text-orange-600 dark:text-orange-400' }}">
                            {{ $targetPercentage }}%
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Outstanding Payments</span>
                        <span class="font-medium text-red-600 dark:text-red-400">₱{{ number_format($outstandingPayments, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Expense Breakdown --}}
            <div>
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Expense Breakdown</h4>
                <div class="space-y-2">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Total Expenses</span>
                        <span class="font-medium text-red-600 dark:text-red-400">₱{{ number_format($monthlyExpenses, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Budget</span>
                        <span class="font-medium text-gray-900 dark:text-white">₱{{ number_format($expensesBudget, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Budget Usage</span>
                        <span class="font-medium {{ $expensesBudgetPercentage <= 100 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $expensesBudgetPercentage }}%
                        </span>
                    </div>
                    @if($expensesByCategory->count() > 0)
                        <div class="pt-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">By Category:</span>
                            <div class="mt-1 space-y-1">
                                @foreach($expensesByCategory->take(3) as $category => $amount)
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-gray-600 dark:text-gray-400">{{ ucfirst($category) }}</span>
                                        <span class="text-red-500 dark:text-red-400">₱{{ number_format($amount, 2) }}</span>
                                    </div>
                                @endforeach
                                @if($expensesByCategory->count() > 3)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        +{{ $expensesByCategory->count() - 3 }} more categories
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Net Profit Summary --}}
        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Net Profit/Loss</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Revenue - Expenses</p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold {{ $netProfit >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        ₱{{ number_format($netProfit, 2) }}
                    </div>
                    <div class="text-sm {{ $netProfit >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        {{ $profitMargin }}% margin
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-4 text-sm">
        <a role="button" @click="$store.ui.showPayment = true" class="inline-flex items-center gap-1 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            <span>Add Payment</span>
        </a>
        <span class="h-4 w-px bg-gray-300 dark:bg-gray-700"></span>
        <a role="button" @click="$store.ui.showUnit = true" class="inline-flex items-center gap-1 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"/></svg>
            <span>Add Unit</span>
        </a>
        <span class="h-4 w-px bg-gray-300 dark:bg-gray-700"></span>
        <a role="button" @click="$store.ui.showTenantAssign = true" class="inline-flex items-center gap-1 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm-9 9a9 9 0 1 1 18 0Z"/></svg>
            <span>Add Tenant & Assign</span>
        </a>
        <span class="h-4 w-px bg-gray-300 dark:bg-gray-700"></span>
        <a role="button" @click="$store.ui.showExpense = true" class="inline-flex items-center gap-1 text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            <span>Add Expense</span>
        </a>
    </div>
    
    @include('dashboard.partials.payments-list')
    @include('dashboard.partials.tenants-list')
    @include('dashboard.partials.units-list')
    @include('dashboard.partials.expenses-list')

    @include('dashboard.modals.add-payment')
    @include('dashboard.modals.add-unit')
    @include('dashboard.modals.add-tenant-assign')
    @include('dashboard.modals.add-expense')
</div>