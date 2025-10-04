import './bootstrap';

import Alpine from 'alpinejs';
import { initializeUnitEditing } from './unit-editing.js';
import { initializeUnitsFilter } from './units-filter.js';
import { initializePaymentFilter } from './payment-filter.js';
import { initializePaymentEditing } from './payment-editing.js';
import { initializeTenantsFilter } from './tenants-filter.js';
import { initializeTenantEditing } from './tenant-editing.js';
import { initializeExpenseEditing } from './expense-editing.js';
import { initializeExpensesFilter } from './expenses-filter.js';

window.Alpine = Alpine;

Alpine.store('ui', {
    showPayment: false,
    showUnit: false,
    showTenantAssign: false,
    showExpense: false,
    editingRowId: null,
    editingTable: null,
});

initializeUnitEditing();
initializeUnitsFilter();
initializePaymentFilter();
initializePaymentEditing();
initializeTenantsFilter();
initializeTenantEditing();
initializeExpenseEditing();
initializeExpensesFilter();

Alpine.start();
