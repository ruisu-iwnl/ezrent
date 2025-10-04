export function initializeTableFilters(config) {
    const {
        tableId,              
        searchPlaceholder,    
        filterOptions,        
        filterLabel,          
        searchFields,         
        statusField,          
        statsSelector         
    } = config;
    
    const table = document.getElementById(tableId);
    if (!table) return;
    
    const searchInput = table.querySelector('input[name="search"]');
    const filterSelect = table.querySelector('select[name="status_filter"]');
    
    if (!searchInput && !filterSelect) return;
    
    let searchTimeout;
    
    function filterTable() {
        const searchValue = searchInput ? searchInput.value.toLowerCase() : '';
        const filterValue = filterSelect ? filterSelect.value : '';
        
        const rows = table.querySelectorAll('tbody tr[x-data]');
        let visibleCount = 0;
        
        rows.forEach(row => {
            let matchesSearch = true;
            let matchesFilter = true;
            
            if (searchValue) {
                matchesSearch = searchFields.some(field => {
                    const cell = getCellByField(row, field);
                    return cell && cell.textContent.toLowerCase().includes(searchValue);
                });
            }
            
             if (filterValue) {
                 const statusCell = getCellByField(row, statusField);
                 if (statusCell) {
                     const cellText = statusCell.textContent.toLowerCase().trim();
                     const filterText = filterValue.toLowerCase();
                     matchesFilter = cellText.startsWith(filterText);
                 }
             }
            
            if (matchesSearch && matchesFilter) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        const tbody = table.querySelector('tbody');
        const existingEmptyRow = tbody.querySelector('.empty-state-row');
        
        if (visibleCount === 0 && (searchValue || filterValue)) {
            if (existingEmptyRow) {
                existingEmptyRow.remove();
            }
            const emptyRow = document.createElement('tr');
            emptyRow.className = 'empty-state-row';
            emptyRow.innerHTML = `<td colspan="${getColumnCount(table)}" class="px-4 py-8 text-center text-gray-500">No records found matching your criteria.</td>`;
            tbody.appendChild(emptyRow);
        } else if (existingEmptyRow) {
            existingEmptyRow.remove();
        }
        
         updateStats(table, visibleCount, searchValue, filterValue, statsSelector, config.customStatsFunction);
    }
    
    function getCellByField(row, field) {
        const cells = row.querySelectorAll('td');
        
        const fieldMap = {
            'code': 0,
            'description': 2,
            'status': 1,
            'tenant': 1,
            'unit': 2,
            'method': 4
        };
        
        const columnIndex = fieldMap[field];
        return columnIndex !== undefined ? cells[columnIndex] : null;
    }
    
    function getColumnCount(table) {
        const headerRow = table.querySelector('thead tr');
        return headerRow ? headerRow.querySelectorAll('th').length : 5;
    }
    
     function updateStats(table, visibleCount, searchValue, filterValue, statsSelector, customStatsFunction) {
         const statsElement = table.querySelector(statsSelector || '.flex.items-center.gap-2.text-xs.text-gray-500');
         if (!statsElement) return;
         
         if (searchValue || filterValue) {
             statsElement.innerHTML = `<span>Showing: <span class="font-medium">${visibleCount} records</span></span><span class="text-indigo-600">(Filtered)</span>`;
         } else {

             if (customStatsFunction) {
                 statsElement.innerHTML = customStatsFunction(table);
             } else {
                 const totalRows = table.querySelectorAll('tbody tr[x-data]').length;
                 statsElement.innerHTML = `<span>Total: <span class="font-medium">${totalRows} records</span></span>`;
             }
         }
     }
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterTable();
            }, 200);
        });
    }
    
    if (filterSelect) {
        filterSelect.addEventListener('change', function() {
            filterTable();
        });
    }
}
