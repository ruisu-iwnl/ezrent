import { initializeTableEditing } from './table-editing.js';

export function initializePaymentEditing() {
    initializeTableEditing({
        tableName: 'payment',
        dataProperty: 'payment',
        idField: 'id',
        uniqueFields: [], 
        updateRoute: 'payments',
        successMessage: 'Payment updated successfully!',
        duplicateMessage: 'This value already exists. Please choose a different one.'
    });
}
