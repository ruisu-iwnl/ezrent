import { initializeTableFilters } from './table-filters.js';

export function initializeExpensesFilter() {
    initializeTableFilters({
        tableId: 'expenses-table',
        searchPlaceholder: 'Search description...',
        filterOptions: [
            { value: 'repair', label: 'Repair' },
            { value: 'utilities', label: 'Utilities' },
            { value: 'labor', label: 'Labor' },
            { value: 'maintenance', label: 'Maintenance' },
            { value: 'other', label: 'Other' }
        ],
        filterLabel: 'All Categories',
        searchFields: ['description'],
        statusField: 'category',
        statsSelector: '.flex.items-center.gap-2.text-xs.text-gray-500',
        customStatsFunction: function(table) {
            const totalRows = table.querySelectorAll('tbody tr[x-data]').length;
            const repairCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const categoryCell = row.querySelector('td:nth-child(2)');
                return categoryCell && categoryCell.textContent.toLowerCase().trim().startsWith('repair');
            }).length;
            const utilitiesCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const categoryCell = row.querySelector('td:nth-child(2)');
                return categoryCell && categoryCell.textContent.toLowerCase().trim().startsWith('utilities');
            }).length;
            const laborCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const categoryCell = row.querySelector('td:nth-child(2)');
                return categoryCell && categoryCell.textContent.toLowerCase().trim().startsWith('labor');
            }).length;
            const maintenanceCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const categoryCell = row.querySelector('td:nth-child(2)');
                return categoryCell && categoryCell.textContent.toLowerCase().trim().startsWith('maintenance');
            }).length;
            const otherCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const categoryCell = row.querySelector('td:nth-child(2)');
                return categoryCell && categoryCell.textContent.toLowerCase().trim().startsWith('other');
            }).length;
            
            return `
                <span>Total: <span class="font-medium">${totalRows} expenses</span></span>
                <span>•</span>
                <span>Repairs: <span class="font-medium text-orange-600">${repairCount}</span></span>
                <span>•</span>
                <span>Utilities: <span class="font-medium text-blue-600">${utilitiesCount}</span></span>
                <span>•</span>
                <span>Labor: <span class="font-medium text-purple-600">${laborCount}</span></span>
                <span>•</span>
                <span>Maintenance: <span class="font-medium text-yellow-600">${maintenanceCount}</span></span>
                <span>•</span>
                <span>Other: <span class="font-medium text-gray-600">${otherCount}</span></span>
            `;
        }
    });
}
