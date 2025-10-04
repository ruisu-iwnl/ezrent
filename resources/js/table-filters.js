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
    const filterSelect = table.querySelector('select[name="status_filter"]') || table.querySelector('select[name="category_filter"]') || table.querySelector('select[name="method_filter"]');
    
    if (!searchInput && !filterSelect) return;
    
    let searchTimeout;
    
    function filterTable() {
        
        const store = Alpine.store('ui');
        const isEditing = store.editingRowId !== null;
        
        
        if (isEditing) {
            const rows = table.querySelectorAll('tbody tr[x-data]');
            rows.forEach(row => {
                row.style.display = '';
            });
            updateStats(table, rows.length, '', '', statsSelector, config.customStatsFunction);
            return;
        }
        
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
        
        const table = row.closest('table').closest('[id]');
        const tableId = table ? table.id : '';
        
        let fieldMap = {};
        
        if (tableId === 'units-table') {
            fieldMap = {
                'code': 0,
                'description': 2,
                'status': 1
            };
        } else if (tableId === 'tenants-table') {
            fieldMap = {
                'name': 0,
                'email': 1,
                'phone': 2,
                'address': 3,
                'status': 4,
                'notes': 8
            };
        } else if (tableId === 'expenses-table') {
            fieldMap = {
                'description': 2,
                'category': 1
            };
        } else if (tableId === 'payments-table') {
            fieldMap = {
                'tenant': 1,
                'unit': 2,
                'method': 4
            };
        } else {

            fieldMap = {
                'code': 0,
                'description': 2,
                'status': 1,
                'tenant': 1,
                'unit': 2,
                'method': 4
            };
        }
        
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
        
        const saveCancelButtons = statsElement.querySelector('span.ml-4');
        const saveCancelHTML = saveCancelButtons ? saveCancelButtons.outerHTML : '';
        
        if (searchValue || filterValue) {
            statsElement.innerHTML = `<span>Showing: <span class="font-medium">${visibleCount} records</span></span><span class="text-indigo-600">(Filtered)</span>${saveCancelHTML}`;
        } else {
            if (customStatsFunction) {
                if (table.id === 'payments-table') {
                    const thisMonthCount = table.getAttribute('data-this-month-count') || '0';
                    const customStats = customStatsFunction(table); 
                    const modifiedStats = customStats.replace(
                        '<span>Total: <span class="font-medium">',
                        '<span>Total: <span class="font-medium">'
                    ).replace(
                        '</span></span>\n                <span>•</span>',
                        '</span></span>\n                <span>•</span>\n                <span>This Month: <span class="font-medium text-green-600">' + thisMonthCount + '</span></span>\n                <span>•</span>'
                    );
                    statsElement.innerHTML = modifiedStats + saveCancelHTML;
                } else {
                    statsElement.innerHTML = customStatsFunction(table) + saveCancelHTML;
                }
            } else {
                const totalRows = table.querySelectorAll('tbody tr[x-data]').length;
                statsElement.innerHTML = `<span>Total: <span class="font-medium">${totalRows} records</span></span>${saveCancelHTML}`;
            }
        }
    }
    
   
    function updateInputStates() {
        const store = Alpine.store('ui');
        const isEditing = store.editingRowId !== null;
        
        const tableMapping = {
            'units-table': 'unit',
            'tenants-table': 'tenant',
            'expenses-table': 'expense',
            'payments-table': 'payment'
        };
        
        const editingTableName = tableMapping[tableId];
        const isThisTableEditing = isEditing && store.editingTable === editingTableName;
        
        if (searchInput) {
            searchInput.disabled = isThisTableEditing;
            searchInput.style.opacity = isThisTableEditing ? '0.5' : '1';
        }
        
        if (filterSelect) {
            filterSelect.disabled = isThisTableEditing;
            filterSelect.style.opacity = isThisTableEditing ? '0.5' : '1';
        }
    }
    
   
    Alpine.effect(() => {
        const store = Alpine.store('ui');
        store.editingRowId; 
        store.editingTable; 
        updateInputStates();
    });
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            if (this.disabled) return; 
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterTable();
            }, 200);
        });
    }
    
    if (filterSelect) {
        filterSelect.addEventListener('change', function() {
            if (this.disabled) return; 
            filterTable();
        });
    }
}
