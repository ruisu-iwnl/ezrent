import { initializeTableEditing } from './table-editing.js';

export function initializeUnitEditing() {
    initializeTableEditing({
        tableName: 'unit',
        dataProperty: 'unit',
        idField: 'id',
        uniqueFields: ['code'],
        updateRoute: 'units',
        successMessage: 'Unit updated successfully!',
        duplicateMessage: 'Unit code already exists. Please choose a different code.'
    });
}
