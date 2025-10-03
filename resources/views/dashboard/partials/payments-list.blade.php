<div class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg">
    <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <h4 class="font-medium">Payments Management</h4>
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <span>Total: <span class="font-medium">24</span></span>
                <span>•</span>
                <span>This Month: <span class="font-medium text-green-600">8</span></span>
                <span>•</span>
                <span>Pending: <span class="font-medium text-orange-600">2</span></span>
                <span>•</span>
                <span>Overdue: <span class="font-medium text-red-600">1</span></span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <select name="method_filter" class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm">
                <option value="">All Methods</option>
                <option value="cash">Cash</option>
                <option value="gcash">GCash</option>
                <option value="bank_transfer">Bank Transfer</option>
                <option value="check">Check</option>
            </select>
            <input type="text" placeholder="Search tenant or unit..." class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm w-48">
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-900/40">
                <tr>
                    <th class="text-left px-4 py-3 font-medium">Date</th>
                    <th class="text-left px-4 py-3 font-medium">Tenant</th>
                    <th class="text-left px-4 py-3 font-medium">Unit</th>
                    <th class="text-left px-4 py-3 font-medium">Amount</th>
                    <th class="text-left px-4 py-3 font-medium">Method</th>
                    <th class="text-left px-4 py-3 font-medium">Reference</th>
                    <th class="text-left px-4 py-3 font-medium">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">Oct 3, 2025</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col">
                            <span class="font-medium">John Tenant</span>
                            <span class="text-xs text-gray-500">john@email.com</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium">A-201</td>
                    <td class="px-4 py-3 font-medium text-green-600">₱10,000</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">GCash</span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">GC123456789</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Complete</span>
                    </td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">Oct 1, 2025</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col">
                            <span class="font-medium">Jane Doe</span>
                            <span class="text-xs text-gray-500">jane@email.com</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium">A-202</td>
                    <td class="px-4 py-3 font-medium text-green-600">₱12,000</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">Cash</span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">Cash Receipt #001</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Complete</span>
                    </td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">Sep 28, 2025</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col">
                            <span class="font-medium">Mike Johnson</span>
                            <span class="text-xs text-gray-500">mike@email.com</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium">B-101</td>
                    <td class="px-4 py-3 font-medium text-green-600">₱8,500</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Bank Transfer</span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">BT987654321</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">Pending</span>
                    </td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">Sep 25, 2025</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col">
                            <span class="font-medium">Sarah Wilson</span>
                            <span class="text-xs text-gray-500">sarah@email.com</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium">A-301</td>
                    <td class="px-4 py-3 font-medium text-green-600">₱11,000</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Check</span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">CHK-000123</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Overdue</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
