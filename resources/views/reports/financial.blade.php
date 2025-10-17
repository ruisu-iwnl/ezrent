<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Report - {{ $currentMonth }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logos/logo2.png') }}"> 
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
            .page-break { page-break-before: always; }
            .print-grid { display: grid !important; grid-template-columns: 1fr 1fr !important; }
            .print-border { border-right: 1px solid #d1d5db !important; }
            .print-title { font-size: 0.875rem !important; }
            .print-subtitle { font-size: 0.75rem !important; }

            .table-section { page-break-inside: avoid; }
            .table-section h2 { page-break-after: avoid; }
            table { page-break-inside: auto; }
            thead { display: table-header-group; }
            tbody { display: table-row-group; }
            tr { page-break-inside: avoid; }
        }
        .compact-text { font-size: 0.75rem; }
        .compact-title { font-size: 0.875rem; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <img src="{{ asset('images/logos/logo2.png') }}" alt="EZRent Logo" class="h-16 w-auto">
                    </div>
                    <div class="text-right">
                        <h2 class="compact-title font-semibold text-gray-900 dark:text-white print-title">EZRent Financial Report</h2>
                        <p class="compact-text text-gray-600 dark:text-gray-400 mt-1 print-subtitle">{{ $currentMonth }}</p>
                    </div>
                    <div class="flex gap-3 no-print">
                        <button onclick="window.print()" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print PDF
                        </button>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden mb-4">
                    <div class="grid grid-cols-1 lg:grid-cols-2 print-grid">
                        <div class="p-4 border-r border-gray-200 dark:border-gray-600 print-border">
                            <h2 class="compact-title font-semibold text-gray-900 dark:text-white mb-3">Property Management Account</h2>
                            <div class="space-y-2">
                                <div>
                                    <span class="compact-text font-medium text-gray-600 dark:text-gray-400">Property:</span>
                                    <span class="compact-text text-gray-900 dark:text-white ml-2">EZRent Properties</span>
                                </div>
                                <div>
                                    <span class="compact-text font-medium text-gray-600 dark:text-gray-400">Report Period:</span>
                                    <span class="compact-text text-gray-900 dark:text-white ml-2">{{ $currentMonth }}</span>
                                </div>
                                <div>
                                    <span class="compact-text font-medium text-gray-600 dark:text-gray-400">Total Units:</span>
                                    <span class="compact-text text-gray-900 dark:text-white ml-2">{{ $outstandingLeases->count() }} Active</span>
                                </div>
                                <div>
                                    <span class="compact-text font-medium text-gray-600 dark:text-gray-400">Report Generated:</span>
                                    <span class="compact-text text-gray-900 dark:text-white ml-2">{{ now()->format('M j, Y \a\t g:i A') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 dark:bg-gray-700">
                            <h3 class="compact-title font-semibold text-gray-900 dark:text-white mb-4">Financial Summary</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="compact-text text-gray-600 dark:text-gray-400">Total Revenue:</span>
                                    <span class="compact-text font-medium text-green-600 dark:text-green-400">₱{{ number_format($stats['totalMonthlyRevenue'], 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="compact-text text-gray-600 dark:text-gray-400">Total Expenses:</span>
                                    <span class="compact-text font-medium text-red-600 dark:text-red-400">-₱{{ number_format($stats['monthlyExpenses'], 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="compact-text text-gray-600 dark:text-gray-400">Outstanding Payments:</span>
                                    <span class="compact-text font-medium text-orange-600 dark:text-orange-400">-₱{{ number_format($stats['outstandingPayments'], 2) }}</span>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-600 pt-3 mt-3">
                                    <div class="flex justify-between">
                                        <span class="compact-text font-semibold text-gray-900 dark:text-white">Net Profit/Loss:</span>
                                        <span class="compact-text font-bold {{ $stats['netProfit'] >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            ₱{{ number_format($stats['netProfit'], 2) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between mt-1">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Profit Margin:</span>
                                        <span class="text-xs font-medium text-blue-600 dark:text-blue-400">{{ $stats['profitMargin'] }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 mb-4 table-section">
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h2 class="compact-title font-semibold text-gray-900 dark:text-white">Revenue Transactions</h2>
                    <p class="compact-text text-gray-600 dark:text-gray-400 mt-1">Transactions 1-{{ $monthlyPayments->count() }} {{ $currentMonth }}</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date and Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount (PHP)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($monthlyPayments as $payment)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap compact-text text-gray-900 dark:text-white">
                                        {{ $payment->paid_at->format('M j, g:i A') }}
                                    </td>
                                    <td class="px-6 py-4 compact-text text-gray-900 dark:text-white">
                                        <div>
                                            <div class="font-medium">{{ $payment->description ?? 'Rent Payment' }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                Unit: {{ $payment->lease->unit->code ?? 'Unknown' }} | 
                                                Tenant: {{ $payment->lease->tenant->user->name ?? 'Unknown' }}
                                            </div>
                                            <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                                Reference ID: PAY-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap compact-text font-bold text-green-600 dark:text-green-400 text-right">
                                        ₱{{ number_format($payment->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center compact-text text-gray-500 dark:text-gray-400">
                                        No revenue transactions recorded for this month
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 mb-4 table-section">
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <h2 class="compact-title font-semibold text-gray-900 dark:text-white">Expense Transactions</h2>
                    <p class="compact-text text-gray-600 dark:text-gray-400 mt-1">Transactions 1-{{ $monthlyExpenses->count() }} {{ $currentMonth }}</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date and Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount (PHP)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($monthlyExpenses as $expense)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap compact-text text-gray-900 dark:text-white">
                                        {{ $expense->incurred_at->format('M j, g:i A') }}
                                    </td>
                                    <td class="px-6 py-4 compact-text text-gray-900 dark:text-white">
                                        <div>
                                            <div class="font-medium">{{ ucfirst($expense->category) }} - {{ $expense->description ?? 'Property Maintenance' }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                Unit: {{ $expense->unit->code ?? 'Unknown' }} | 
                                                Logged by: {{ $expense->logger->name ?? 'Unknown' }}
                                            </div>
                                            <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                                Reference ID: EXP-{{ str_pad($expense->id, 6, '0', STR_PAD_LEFT) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap compact-text font-bold text-red-600 dark:text-red-400 text-right">
                                        -₱{{ number_format($expense->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center compact-text text-gray-500 dark:text-gray-400">
                                        No expense transactions recorded for this month
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="text-center compact-text text-gray-500 dark:text-gray-400 no-print">
                <p>Report generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
                <p class="mt-1">EZRent Property Management System</p>
            </div>
        </div>
    </div>
</body>
</html>
