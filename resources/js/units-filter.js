import { initializeTableFilters } from './table-filters.js';

export function initializeUnitsFilter() {
    initializeTableFilters({
        tableId: 'units-table',
        searchPlaceholder: 'Search unit code...',
        filterOptions: [
            { value: 'vacant', label: 'Vacant' },
            { value: 'occupied', label: 'Occupied' },
            { value: 'maintenance', label: 'Maintenance' }
        ],
        filterLabel: 'All Status',
        searchFields: ['code', 'description'],
        statusField: 'status',
        statsSelector: '.flex.items-center.gap-2.text-xs.text-gray-500',
        customStatsFunction: function(table) {
            const totalRows = table.querySelectorAll('tbody tr[x-data]').length;
            const vacantCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const statusCell = row.querySelector('td:nth-child(2)');
                return statusCell && statusCell.textContent.toLowerCase().trim().startsWith('vacant');
            }).length;
            const occupiedCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const statusCell = row.querySelector('td:nth-child(2)');
                return statusCell && statusCell.textContent.toLowerCase().trim().startsWith('occupied');
            }).length;
            const maintenanceCount = Array.from(table.querySelectorAll('tbody tr[x-data]')).filter(row => {
                const statusCell = row.querySelector('td:nth-child(2)');
                return statusCell && statusCell.textContent.toLowerCase().trim().startsWith('maintenance');
            }).length;
            
            return `
                <span>Total: <span class="font-medium">${totalRows} units</span></span>
                <span>•</span>
                <span>Vacant: <span class="font-medium text-green-600">${vacantCount}</span></span>
                <span>•</span>
                <span>Occupied: <span class="font-medium text-blue-600">${occupiedCount}</span></span>
                <span>•</span>
                <span>Maintenance: <span class="font-medium text-orange-600">${maintenanceCount}</span></span>
            `;
        }
    });
}