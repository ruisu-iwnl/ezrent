import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.store('ui', {
    showPayment: false,
    showUnit: false,
    showTenantAssign: false,
    showExpense: false,
});

Alpine.start();
