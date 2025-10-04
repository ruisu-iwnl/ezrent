import { initializeTableEditing } from './table-editing.js';

export function initializeTenantEditing() {
    initializeTableEditing({
        tableName: 'tenant',
        dataProperty: 'tenant',
        idField: 'id',
        uniqueFields: [],
        updateRoute: 'tenants',
        successMessage: 'Tenant updated successfully!',
        duplicateMessage: 'This value already exists. Please choose a different one.'
    });
}
