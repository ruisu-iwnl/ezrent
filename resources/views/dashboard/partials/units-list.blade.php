<div id="units-table" class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg">
    <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <h4 class="font-medium">Units Management</h4>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span>Showing: <span class="font-medium">{{ $units->count() }} units</span></span>
                    @if(request('status_filter') || request('search'))
                        <span class="text-indigo-600">(Filtered)</span>
                    @else
                        <span>•</span>
                        <span>Vacant: <span class="font-medium text-green-600">{{ $units->where('status', 'vacant')->count() }}</span></span>
                        <span>•</span>
                        <span>Occupied: <span class="font-medium text-blue-600">{{ $units->where('status', 'occupied')->count() }}</span></span>
                        <span>•</span>
                        <span>Maintenance: <span class="font-medium text-orange-600">{{ $units->where('status', 'maintenance')->count() }}</span></span>
                    @endif
                    <span class="ml-4" x-show="$store.ui.editingRowId" x-transition>
                        <button @click="saveCurrentRecord()" class="px-2 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700">Save</button>
                        <button @click="cancelEditing()" class="px-2 py-1 text-xs bg-gray-500 text-white rounded hover:bg-gray-600 ml-1">Cancel</button>
                    </span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <select name="status_filter" class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm">
                <option value="">All Status</option>
                <option value="vacant" {{ request('status_filter') === 'vacant' ? 'selected' : '' }}>Vacant</option>
                <option value="occupied" {{ request('status_filter') === 'occupied' ? 'selected' : '' }}>Occupied</option>
                <option value="maintenance" {{ request('status_filter') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
            <input type="text" name="search" placeholder="Search unit code..." value="{{ request('search') }}" class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm w-48">
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
                @forelse($units as $unit)
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50" 
                    x-data="{ unit: {{ $unit->toJson() }}, editing: false }"
                    data-original-code="{{ $unit->code }}"
                    data-original-status="{{ $unit->status }}"
                    data-original-description="{{ $unit->description }}">
                    <td class="px-4 py-3 font-medium">
                        <div x-show="!editing" @click="editing = true; $store.ui.editingRowId = unit.id" class="cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400">{{ $unit->code }}</div>
                        <input x-show="editing" x-model="unit.code" type="text" class="w-full px-2 py-1 text-sm border rounded dark:bg-gray-700 dark:border-gray-600" @click.stop>
                    </td>
                    <td class="px-4 py-3">
                        <div x-show="!editing" @click="editing = true; $store.ui.editingRowId = unit.id" class="cursor-pointer">
                            @if($unit->status === 'vacant')
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Vacant</span>
                            @elseif($unit->status === 'occupied')
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Occupied</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">Maintenance</span>
                            @endif
                        </div>
                        <select x-show="editing" x-model="unit.status" class="text-xs px-2 py-1 border rounded dark:bg-gray-700 dark:border-gray-600" @click.stop>
                            <option value="vacant">Vacant</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                        <div x-show="!editing" @click="editing = true; $store.ui.editingRowId = unit.id" class="cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400">{{ $unit->description ?? 'Click to add description' }}</div>
                        <textarea x-show="editing" x-model="unit.description" rows="2" class="w-full px-2 py-1 text-sm border rounded dark:bg-gray-700 dark:border-gray-600" @click.stop></textarea>
                    </td>
                    <td class="px-4 py-3">
                        @if($unit->leases->isNotEmpty())
                            @php($currentLease = $unit->leases->first())
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $currentLease->tenant->user->name }}</span>
                                <span class="text-xs text-gray-500">{{ $currentLease->tenant->user->email }}</span>
                            </div>
                        @else
                            <span class="text-gray-500 italic">Vacant</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-medium">
                        @if($unit->leases->isNotEmpty())
                            ₱{{ number_format($unit->leases->first()->monthly_rent, 2) }}
                        @else
                            <span class="text-gray-500">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-500">No units found. Create your first unit using the "Add Unit" button above.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
