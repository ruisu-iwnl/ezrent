import { initializeTableFilters } from './table-filters.js';

export function initializePaymentsFilter() {
    initializeTableFilters({
        tableId: 'payments-table',
        searchPlaceholder: 'Search tenant or unit...',
        filterOptions: [
            { value: 'gcash', label: 'GCash' },
            { value: 'cash', label: 'Cash' },
            { value: 'bank_transfer', label: 'Bank Transfer' },
            { value: 'check', label: 'Check' }
        ],
        filterLabel: 'All Methods',
        searchFields: ['tenant', 'unit'],
        statusField: 'method',
        statsSelector: '.flex.items-center.gap-2.text-xs.text-gray-500'
    });
}
