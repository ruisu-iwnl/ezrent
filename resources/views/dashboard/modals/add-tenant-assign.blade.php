<div x-show="$store.ui.showTenantAssign" x-cloak class="fixed inset-0 z-[110] flex items-center justify-center">
    <div class="fixed inset-0 w-screen h-screen bg-black/60" @click="$store.ui.showTenantAssign=false"></div>
    <div class="relative z-[120] w-full max-w-4xl bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
            <h4 class="font-medium">Add Tenant & Assign to Unit</h4>
            <button class="text-gray-500" @click="$store.ui.showTenantAssign=false">✕</button>
        </div>
        <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <div class="text-sm font-semibold mb-2">Tenant Identity</div>
                <div class="space-y-3">
                    <input name="user[name]" type="text" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="Full name">
                    <input name="user[email]" type="email" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="Email">
                    <input name="tenant[phone]" type="text" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="Phone (optional)">
                    <input name="tenant[date_of_birth]" type="date" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                    <input name="tenant[address]" type="text" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="Address (optional)">
                    <input name="tenant[valid_id]**" type="file" class="w-full text-sm">
                    <textarea name="tenant[notes]" rows="2" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="Notes (optional)"></textarea>
                </div>
            </div>
            <div>
                <div class="text-sm font-semibold mb-2">Unit</div>
                <div class="space-y-3">
                    <select name="lease[unit_id]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                        <option value="">Choose a vacant unit…</option>
                        <option value="201">A-201 (Vacant)</option>
                        <option value="202">A-202 (Vacant)</option>
                    </select>
                    <p class="text-xs text-gray-500">Only vacant units are listed.</p>
                </div>
            </div>
            <div>
                <div class="text-sm font-semibold mb-2">Lease</div>
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                        <input name="lease[start_date]" type="date" class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700">
                        <input name="lease[end_date]" type="date" class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="End date (optional)">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <input name="lease[monthly_rent]" type="number" step="0.01" class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="Monthly rent">
                        <input name="lease[security_deposit]" type="number" step="0.01" class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="Deposit (optional)">
                    </div>
                    <input name="lease[document]" type="file" class="w-full text-sm">
                    <textarea name="lease[notes]" rows="2" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700" placeholder="Lease notes (optional)"></textarea>
                </div>
            </div>
        </div>
        <div class="px-4 pb-4 flex items-center justify-end gap-2">
            <button class="px-3 py-2 rounded-md border" @click="$store.ui.showTenantAssign=false">Cancel</button>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Create Tenant & Assign</button>
        </div>
    </div>
</div>
