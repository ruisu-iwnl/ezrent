<div class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg">
    <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <h4 class="font-medium">Tenants Management</h4>
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <span>Total: <span class="font-medium">12</span></span>
                <span>•</span>
                <span>Active: <span class="font-medium text-green-600">10</span></span>
                <span>•</span>
                <span>Inactive: <span class="font-medium text-gray-600">2</span></span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <select name="status_filter" class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            <input type="text" placeholder="Search tenant name..." class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm w-48">
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-900/40">
                <tr>
                    <th class="text-left px-4 py-3 font-medium">Name</th>
                    <th class="text-left px-4 py-3 font-medium">Email</th>
                    <th class="text-left px-4 py-3 font-medium">Phone</th>
                    <th class="text-left px-4 py-3 font-medium">Status</th>
                    <th class="text-left px-4 py-3 font-medium">Current Unit</th>
                    <th class="text-left px-4 py-3 font-medium">Rent Due</th>
                    <th class="text-left px-4 py-3 font-medium">Valid ID</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">John Tenant</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">john@email.com</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">+63 912 345 6789</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col">
                            <span class="font-medium">A-201</span>
                            <span class="text-xs text-gray-500">2-bedroom apartment</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium text-orange-600">₱10,000</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">✓ Verified</span>
                    </td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">Jane Doe</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">jane@email.com</td>
                    <td class="px-4 py-3 text-gray-500 italic">Not provided</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col">
                            <span class="font-medium">A-202</span>
                            <span class="text-xs text-gray-500">1-bedroom studio</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium text-green-600">₱12,000</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">✓ Verified</span>
                    </td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">Mike Johnson</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">mike@email.com</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">+63 915 987 6543</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col">
                            <span class="font-medium">B-101</span>
                            <span class="text-xs text-gray-500">3-bedroom ground floor</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium text-red-600">₱8,500</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">Pending</span>
                    </td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium text-gray-500">Sarah Wilson</td>
                    <td class="px-4 py-3 text-gray-500 italic">sarah@email.com</td>
                    <td class="px-4 py-3 text-gray-500 italic">+63 918 765 4321</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">Inactive</span>
                    </td>
                    <td class="px-4 py-3 text-gray-500 italic">No current unit</td>
                    <td class="px-4 py-3 text-gray-500 italic">—</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">✓ Verified</span>
                    </td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">Alex Rodriguez</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">alex@email.com</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">+63 920 111 2222</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Active</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col">
                            <span class="font-medium">A-301</span>
                            <span class="text-xs text-gray-500">2-bedroom apartment</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium text-green-600">₱11,000</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Expired</span>
                    </td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium text-gray-500">Maria Garcia</td>
                    <td class="px-4 py-3 text-gray-500 italic">maria@email.com</td>
                    <td class="px-4 py-3 text-gray-500 italic">Not provided</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">Inactive</span>
                    </td>
                    <td class="px-4 py-3 text-gray-500 italic">No current unit</td>
                    <td class="px-4 py-3 text-gray-500 italic">—</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Missing</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
