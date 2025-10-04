import './bootstrap';

import Alpine from 'alpinejs';
import { initializeUnitEditing } from './unit-editing.js';
import { initializeUnitsFilter } from './units-filter.js';
import { initializePaymentsFilter } from './payments-filter.js';

window.Alpine = Alpine;

Alpine.store('ui', {
    showPayment: false,
    showUnit: false,
    showTenantAssign: false,
    showExpense: false,
    editingRowId: null,
});

initializeUnitEditing();
initializeUnitsFilter();
initializePaymentsFilter();

Alpine.start();
