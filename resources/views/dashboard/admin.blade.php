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
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-yellow-800">🛠️ Development Helper</h4>
                    <p class="text-xs text-yellow-700 mt-1">Override current date for testing rent due system</p>
                </div>
                <form method="GET" class="flex items-center gap-2">
                    <input type="date" name="test_date" value="{{ $testDate ? $testDate->format('Y-m-d') : '' }}" 
                           class="text-xs border border-yellow-300 rounded px-2 py-1">
                    <button type="submit" class="text-xs bg-yellow-600 text-white px-3 py-1 rounded hover:bg-yellow-700">
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
                <div class="mt-2 text-xs text-yellow-700">
                    <strong>Testing as:</strong> {{ $testDate->format('F j, Y') }} ({{ $testDate->format('Y-m') }})
                </div>
            @endif
        </div>
    @endif

    @include('dashboard.partials.stats-overview')

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