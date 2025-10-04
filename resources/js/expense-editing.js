import { initializeTableEditing } from './table-editing.js';

export function initializeExpenseEditing() {
    initializeTableEditing({
        tableName: 'expense',
        dataProperty: 'expense',
        idField: 'id',
        uniqueFields: [],
        updateRoute: 'expenses',
        successMessage: 'Expense updated successfully!',
        duplicateMessage: 'This value already exists. Please choose a different one.'
    });
}
