<div class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg">
    <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <h4 class="font-medium">Expenses Management</h4>
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <span>This Month: <span class="font-medium text-red-600">₱3,200</span></span>
                <span>•</span>
                <span>Repairs: <span class="font-medium text-orange-600">₱1,200</span></span>
                <span>•</span>
                <span>Utilities: <span class="font-medium text-blue-600">₱800</span></span>
                <span>•</span>
                <span>Labor: <span class="font-medium text-purple-600">₱600</span></span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <select name="category_filter" class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm">
                <option value="">All Categories</option>
                <option value="repair">Repair</option>
                <option value="utilities">Utilities</option>
                <option value="labor">Labor</option>
                <option value="maintenance">Maintenance</option>
                <option value="other">Other</option>
            </select>
            <input type="text" placeholder="Search description..." class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm w-48">
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-900/40">
                <tr>
                    <th class="text-left px-4 py-3 font-medium">Incurred At</th>
                    <th class="text-left px-4 py-3 font-medium">Category</th>
                    <th class="text-left px-4 py-3 font-medium">Description</th>
                    <th class="text-left px-4 py-3 font-medium">Unit</th>
                    <th class="text-left px-4 py-3 font-medium">Lease</th>
                    <th class="text-left px-4 py-3 font-medium">Amount</th>
                    <th class="text-left px-4 py-3 font-medium">Logged By</th>
                    <th class="text-left px-4 py-3 font-medium">Attachment</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">Oct 2, 2025</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">repair</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Kitchen faucet replacement</td>
                    <td class="px-4 py-3 font-medium">A-201</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">John Tenant (Lease #1)</td>
                    <td class="px-4 py-3 font-medium text-red-600">₱800.00</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Admin User</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✓ Receipt</span>
                    </td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">Oct 1, 2025</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">utilities</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Monthly water bill</td>
                    <td class="px-4 py-3 font-medium">A-201</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">John Tenant (Lease #1)</td>
                    <td class="px-4 py-3 font-medium text-red-600">₱800.00</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Admin User</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✓ Bill</span>
                    </td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">Sep 30, 2025</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">labor</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Cleaning service for vacant unit</td>
                    <td class="px-4 py-3 font-medium">A-202</td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-500">-</td>
                    <td class="px-4 py-3 font-medium text-red-600">₱600.00</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Admin User</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✓ Invoice</span>
                    </td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">Sep 28, 2025</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">repair</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Door lock replacement</td>
                    <td class="px-4 py-3 font-medium">B-101</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Jane Doe (Lease #2)</td>
                    <td class="px-4 py-3 font-medium text-red-600">₱400.00</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Admin User</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                    </td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">Sep 25, 2025</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">other</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Office supplies</td>
                    <td class="px-4 py-3 font-medium">Office</td>
                    <td class="px-4 py-3 text-gray-500 dark:text-gray-500">-</td>
                    <td class="px-4 py-3 font-medium text-red-600">₱600.00</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">Admin User</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✓ Receipt</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
