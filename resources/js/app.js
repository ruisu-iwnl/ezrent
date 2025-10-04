import './bootstrap';

import Alpine from 'alpinejs';
import { initializeUnitEditing } from './unit-editing.js';

window.Alpine = Alpine;

Alpine.store('ui', {
    showPayment: false,
    showUnit: false,
    showTenantAssign: false,
    showExpense: false,
    editingRowId: null,
});

initializeUnitEditing();

Alpine.start();
