import { initializeTableFilters } from './table-filters.js';

export function initializePaymentFilter() {
    initializeTableFilters({
        tableId: 'payments-table',
        searchPlaceholder: 'Search tenant or unit...',
        filterOptions: [
            { value: 'cash', label: 'Cash' },
            { value: 'gcash', label: 'GCash' },
            { value: 'bank_transfer', label: 'Bank Transfer' },
            { value: 'check', label: 'Check' }
        ],
        filterLabel: 'All Methods',
        searchFields: ['tenant', 'unit'],
        statusField: 'method',
        statsSelector: '.flex.items-center.gap-2.text-xs.text-gray-500',
        customStatsFunction: function(table) {
            const totalRows = table.querySelectorAll('tbody tr[x-data]').length;
            const cashCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const methodCell = row.querySelector('td:nth-child(5)');
                return methodCell && methodCell.textContent.toLowerCase().trim().startsWith('cash');
            }).length;
            const gcashCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const methodCell = row.querySelector('td:nth-child(5)');
                return methodCell && methodCell.textContent.toLowerCase().trim().startsWith('gcash');
            }).length;
            const bankTransferCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const methodCell = row.querySelector('td:nth-child(5)');
                return methodCell && methodCell.textContent.toLowerCase().trim().startsWith('bank');
            }).length;
            const checkCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const methodCell = row.querySelector('td:nth-child(5)');
                return methodCell && methodCell.textContent.toLowerCase().trim().startsWith('check');
            }).length;
            
            return `
                <span>Total: <span class="font-medium">${totalRows} payments</span></span>
                <span>•</span>
                <span>Cash: <span class="font-medium text-green-600">${cashCount}</span></span>
                <span>•</span>
                <span>GCash: <span class="font-medium text-blue-600">${gcashCount}</span></span>
                <span>•</span>
                <span>Bank Transfer: <span class="font-medium text-purple-600">${bankTransferCount}</span></span>
                <span>•</span>
                <span>Check: <span class="font-medium text-yellow-600">${checkCount}</span></span>
            `;
        }
    });
}
