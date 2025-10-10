<div id="tenants-table" class="bg-white dark:bg-gray-800 border border-gray-200/60 dark:border-gray-700 rounded-lg">
    <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h4 class="font-medium">Tenants Management</h4>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span>Total: <span class="font-medium">{{ $tenants->count() }}</span></span>
                    <span>•</span>
                    <span>Active: <span class="font-medium text-green-600">{{ $tenants->where('status', 'active')->count() }}</span></span>
                    <span>•</span>
                    <span>Inactive: <span class="font-medium text-gray-600">{{ $tenants->where('status', 'inactive')->count() }}</span></span>
                    <span>•</span>
                    <span>Former: <span class="font-medium text-blue-600">{{ $tenants->where('status', 'former')->count() }}</span></span>
                    <span class="ml-4" x-show="$store.ui.editingRowId && $store.ui.editingTable === 'tenant'" x-cloak x-transition>
                        <button @click="saveCurrentTenant()" class="px-2 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700">Save</button>
                        <button @click="cancelTenantEditing()" class="px-2 py-1 text-xs bg-gray-500 text-white rounded hover:bg-gray-600 ml-1">Cancel</button>
                    </span>
                </div>
            </div>
        <div class="flex items-center gap-2">
            <select name="status_filter" class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="former">Former</option>
            </select>
            <input type="text" name="search" placeholder="Search tenant name..." class="rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-sm w-48">
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-900/40">
                <tr>
                    <th class="text-left px-4 py-3 font-medium">Name</th>
                    <th class="text-left px-4 py-3 font-medium">Email</th>
                    <th class="text-left px-4 py-3 font-medium">Phone</th>
                    <th class="text-left px-4 py-3 font-medium">Address</th>
                    <th class="text-left px-4 py-3 font-medium">Status</th>
                    <th class="text-left px-4 py-3 font-medium">Current Unit</th>
					<th class="text-left px-4 py-3 font-medium">Lease Period</th>
                    <th class="text-left px-4 py-3 font-medium">Rent Due</th>
                    <th class="text-left px-4 py-3 font-medium">Valid ID</th>
                    <th class="text-left px-4 py-3 font-medium">Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                <tr class="border-t border-gray-200/60 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900/50 cursor-pointer"
                    x-data="{ tenant: {{ $tenant->toJson() }}, editing: false }"
                    @click="if(!editing){ $store.ui.selectedTenant = tenant; $dispatch('open-modal', 'tenant-details'); }"
                    data-original-phone="{{ $tenant->phone }}"
                    data-original-address="{{ $tenant->address }}"
                    data-original-notes="{{ $tenant->notes }}">
                    <td class="px-4 py-3 font-medium">{{ $tenant->user->name }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $tenant->user->email }}</td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                        <div x-show="!editing" @click.stop="startEditingTenant(tenant.id); editing = true" class="cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400">{{ $tenant->phone ?? 'Click to add phone' }}</div>
                        <input x-show="editing" x-cloak x-model="tenant.phone" type="number" class="w-full px-2 py-1 text-sm border rounded dark:bg-gray-700 dark:border-gray-600" placeholder="Phone number" @click.stop>
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                        <div x-show="!editing" @click.stop="startEditingTenant(tenant.id); editing = true" class="cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400 truncate max-w-[4rem]" title="{{ $tenant->address }}">{{ $tenant->address ?? 'Click to add address' }}</div>
                        <textarea x-show="editing" x-cloak x-model="tenant.address" rows="2" maxlength="100" class="w-full px-2 py-1 text-sm border rounded dark:bg-gray-700 dark:border-gray-600" placeholder="Address (max 100 chars)" @click.stop></textarea>
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs {{ $tenant->getStatusBadgeClass() }}">
                            {{ ucfirst($tenant->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($tenant->lease)
                            <div class="flex flex-col">
                                <span class="font-medium truncate max-w-[3rem]" title="{{ $tenant->lease->unit->code }}">{{ $tenant->lease->unit->code }}</span>
                                <span class="text-xs text-gray-500 truncate max-w-[6rem]" title="{{ $tenant->lease->unit->description }}">{{ $tenant->lease->unit->description ?? 'No description' }}</span>
                            </div>
                        @else
                            <span class="text-gray-500 italic">No current unit</span>
                        @endif
                    </td>
					<td class="px-4 py-3">
						@if($tenant->lease)
							@php
								$start = \Carbon\Carbon::parse($tenant->lease->start_date);
								$end = \Carbon\Carbon::parse($tenant->lease->end_date);
							@endphp
							@php $months = intval($start->diffInMonths($end)); @endphp
							<div class="flex flex-col gap-0.5 leading-tight">
								<span class="font-medium whitespace-nowrap" title="{{ $start->toFormattedDateString() }} → {{ $end->toFormattedDateString() }}">
									{{ $start->format('M j, y') }} <span class="mx-1 text-gray-400">→</span> {{ $end->format('M j, y') }}
								</span>
								<span class="inline-flex w-fit items-center px-1.5 py-0.5 rounded text-[10px] bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300">
									Duration: {{ $months }} {{ \Illuminate\Support\Str::plural('month', $months) }}
								</span>
							</div>
						@else
							<span class="text-gray-500 italic">—</span>
						@endif
					</td>
                    <td class="px-4 py-3 font-medium">
                        @if($tenant->lease)
                            @php
                                $referenceDate = $testDate ?: now();
                                $remainingAmount = $tenant->lease->getRemainingAmountForMonth($referenceDate->year, $referenceDate->month);
                                $totalPaid = $tenant->lease->getTotalPaidForMonth($referenceDate->year, $referenceDate->month);
                            @endphp
                            @if($remainingAmount <= 0)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Paid
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    ₱{{ number_format($remainingAmount, 2) }}
                                </span>
                            @endif
                        @else
                            <span class="text-gray-500 italic">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($tenant->valid_id_path)
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">✓ Verified</span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Missing</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                        <div x-show="!editing" @click.stop="startEditingTenant(tenant.id); editing = true" class="cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400 truncate max-w-[4rem]" title="{{ $tenant->notes }}">{{ $tenant->notes ?? 'Click to add notes (max 100 chars)' }}</div>
                        <textarea x-show="editing" x-cloak x-model="tenant.notes" rows="2" maxlength="100" class="w-full px-2 py-1 text-sm border rounded dark:bg-gray-700 dark:border-gray-600" placeholder="Notes (max 100 chars)" @click.stop></textarea>
                    </td>
                </tr>
                @empty
                <tr>
				<td colspan="10" class="px-4 py-8 text-center text-gray-500">No tenants found. Create your first tenant using the "Add Tenant & Assign" button above.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <x-modal name="tenant-details" :show="false" maxWidth="2xl">
        <div class="p-4" x-data>
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold" x-text="$store.ui.selectedTenant?.user?.name || 'Tenant'"></h3>
                    <p class="text-sm text-gray-500" x-text="$store.ui.selectedTenant?.user?.email || ''"></p>
                </div>
                <button class="text-gray-400 hover:text-gray-600" @click="$dispatch('close-modal', 'tenant-details')">✕</button>
            </div>

            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <div class="text-gray-500">Phone</div>
                    <div class="font-medium" x-text="$store.ui.selectedTenant?.phone || '—'"></div>
                </div>
                <div>
                    <div class="text-gray-500">Status</div>
                    <div class="font-medium" x-text="$store.ui.selectedTenant?.status ? ($store.ui.selectedTenant.status[0].toUpperCase() + $store.ui.selectedTenant.status.slice(1)) : '—'"></div>
                </div>
                <div class="sm:col-span-2">
                    <div class="text-gray-500">Address</div>
                    <div class="font-medium break-words" x-text="$store.ui.selectedTenant?.address || '—'"></div>
                </div>
                <template x-if="$store.ui.selectedTenant?.lease">
                    <div class="sm:col-span-2">
                        <div class="text-gray-500">Current Unit</div>
                        <div class="font-medium">
                            <span x-text="$store.ui.selectedTenant?.lease?.unit?.code || ''"></span>
                            <span class="text-gray-500" x-show="$store.ui.selectedTenant?.lease?.unit?.description"> — </span>
                            <span class="text-gray-500" x-text="$store.ui.selectedTenant?.lease?.unit?.description || ''"></span>
                        </div>
                    </div>
                </template>
                <div class="sm:col-span-2">
                    <div class="text-gray-500">Notes</div>
                    <div class="font-medium break-words" x-text="$store.ui.selectedTenant?.notes || '—'"></div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button @click="$dispatch('close-modal', 'tenant-details')">Close</x-secondary-button>
            </div>
        </div>
    </x-modal>
</div>
