export function initializeTableEditing(config) {
    const {
        tableName,           
        dataProperty,        
        idField,            
        uniqueFields,       
        updateRoute,        
        successMessage = 'Record updated successfully!',
        noChangesMessage = 'No changes detected.',
        duplicateMessage = 'This value already exists. Please choose a different one.'
    } = config;

    window.saveCurrentRecord = function() {
        const store = Alpine.store('ui');
        if (!store.editingRowId) {
            alert(`No ${tableName} selected for editing`);
            return;
        }

        const editingRows = document.querySelectorAll('[x-data]');
        let editingRow = null;
        let recordData = null;
        
        for (let row of editingRows) {
            const data = Alpine.$data(row);
            if (data && data.editing === true && data[dataProperty] && data[dataProperty][idField] === store.editingRowId) {
                editingRow = row;
                recordData = data;
                break;
            }
        }
        
        if (!editingRow || !recordData) {
            alert('Could not find editing row');
            return;
        }
        
        const hasChanges = checkForChanges(editingRow, recordData[dataProperty]);
        if (!hasChanges) {
            recordData.editing = false;
            store.editingRowId = null;
            return;
        }
        
        const duplicateError = checkForDuplicates(recordData[dataProperty], uniqueFields, idField);
        if (duplicateError) {
            alert(duplicateError);
            return;
        }
        
        submitForm(recordData[dataProperty], updateRoute, idField);
    };

    window.cancelEditing = function() {
        const store = Alpine.store('ui');
        if (!store.editingRowId) {
            return;
        }
        
        const editingRows = document.querySelectorAll('[x-data]');
        
        for (let row of editingRows) {
            const data = Alpine.$data(row);
            if (data && data.editing === true && data[dataProperty] && data[dataProperty][idField] === store.editingRowId) {
                data.editing = false;
                break;
            }
        }
        
        store.editingRowId = null;
    };

    function checkForChanges(row, currentData) {
        const originalValues = {};
        const attributes = row.attributes;
        
        for (let attr of attributes) {
            if (attr.name.startsWith('data-original-')) {
                const fieldName = attr.name.replace('data-original-', '');
                originalValues[fieldName] = attr.value;
            }
        }
        
        for (let field in originalValues) {
            const currentValue = currentData[field] || '';
            const originalValue = originalValues[field] || '';
            if (currentValue !== originalValue) {
                return true;
            }
        }
        
        return false;
    }

    function checkForDuplicates(currentData, uniqueFields, idField) {
        if (!uniqueFields || uniqueFields.length === 0) return null;
        
        const allRows = document.querySelectorAll('[x-data]');
        
        for (let row of allRows) {
            const data = Alpine.$data(row);
            if (data && data[dataProperty] && data[dataProperty][idField] !== currentData[idField]) {
                for (let field of uniqueFields) {
                    if (data[dataProperty][field] === currentData[field]) {
                        return `${field} already exists. Please choose a different ${field}.`;
                    }
                }
            }
        }
        
        return null;
    }

    function submitForm(data, route, idField) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `${route}/${data[idField]}`;
        form.style.display = 'none';
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        form.appendChild(methodInput);
        
        for (let field in data) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `${tableName}[${field}]`;
            input.value = data[field] || '';
            form.appendChild(input);
        }
        
        document.body.appendChild(form);
        form.submit();
    }
}
