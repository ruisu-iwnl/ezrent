import { initializeTableFilters } from './table-filters.js';

export function initializeTenantsFilter() {
    initializeTableFilters({
        tableId: 'tenants-table',
        searchPlaceholder: 'Search tenant name...',
        filterOptions: [
            { value: 'active', label: 'Active' },
            { value: 'inactive', label: 'Inactive' },
            { value: 'former', label: 'Former' }
        ],
        filterLabel: 'All Status',
        searchFields: ['name', 'email'],
        statusField: 'status',
        statsSelector: '.flex.items-center.gap-2.text-xs.text-gray-500',
        customStatsFunction: function(table) {
            const totalRows = table.querySelectorAll('tbody tr[x-data]').length;
            const activeCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const statusCell = row.querySelector('td:nth-child(5)');
                return statusCell && statusCell.textContent.toLowerCase().includes('active');
            }).length;
            const inactiveCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const statusCell = row.querySelector('td:nth-child(5)');
                return statusCell && statusCell.textContent.toLowerCase().includes('inactive');
            }).length;
            const formerCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const statusCell = row.querySelector('td:nth-child(5)');
                return statusCell && statusCell.textContent.toLowerCase().includes('former');
            }).length;
            
            return `
                <span>Total: <span class="font-medium">${totalRows}</span></span>
                <span>•</span>
                <span>Active: <span class="font-medium text-green-600">${activeCount}</span></span>
                <span>•</span>
                <span>Inactive: <span class="font-medium text-gray-600">${inactiveCount}</span></span>
                <span>•</span>
                <span>Former: <span class="font-medium text-blue-600">${formerCount}</span></span>
            `;
        }
    });
}
