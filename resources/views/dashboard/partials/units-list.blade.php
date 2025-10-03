<div class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg">
    <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <h4 class="font-medium">Units Management</h4>
            <div class="flex items-center gap-2 text-xs text-gray-500">
                <span>Total: <span class="font-medium">8</span></span>
                <span>•</span>
                <span>Vacant: <span class="font-medium text-green-600">5</span></span>
                <span>•</span>
                <span>Occupied: <span class="font-medium text-blue-600">2</span></span>
                <span>•</span>
                <span>Maintenance: <span class="font-medium text-orange-600">1</span></span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <select name="status_filter" class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm">
                <option value="">All Status</option>
                <option value="vacant">Vacant</option>
                <option value="occupied">Occupied</option>
                <option value="maintenance">Maintenance</option>
            </select>
            <input type="text" placeholder="Search unit code..." class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm w-48">
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-900/40">
                <tr>
                    <th class="text-left px-4 py-3 font-medium">Unit Code</th>
                    <th class="text-left px-4 py-3 font-medium">Status</th>
                    <th class="text-left px-4 py-3 font-medium">Description</th>
                    <th class="text-left px-4 py-3 font-medium">Current Tenant</th>
                    <th class="text-left px-4 py-3 font-medium">Monthly Rent</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">A-201</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Occupied</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">2-bedroom apartment, city view</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col">
                            <span class="font-medium">John Tenant</span>
                            <span class="text-xs text-gray-500">john@email.com</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 font-medium">₱10,000</td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">A-202</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Vacant</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">1-bedroom studio unit</td>
                    <td class="px-4 py-3 text-gray-500 italic">Available</td>
                    <td class="px-4 py-3 font-medium text-gray-500">—</td>
                </tr>
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50">
                    <td class="px-4 py-3 font-medium">B-101</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">Maintenance</span>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">3-bedroom ground floor unit</td>
                    <td class="px-4 py-3 text-gray-500 italic">Under repair</td>
                    <td class="px-4 py-3 font-medium text-gray-500">—</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
