<div x-show="$store.ui.showTenantAssign" x-cloak x-transition class="fixed inset-0 z-[110] flex items-center justify-center">
    <div class="fixed inset-0 w-screen h-screen bg-black/60 transition-none" @click="$store.ui.showTenantAssign=false"></div>
    <div class="relative z-[120] w-full max-w-4xl bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <form method="POST" action="{{ route('tenants.store') }}">
            @csrf
            <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
                <h4 class="font-medium">Add Tenant & Assign to Unit</h4>
                <button type="button" class="text-gray-500" @click="$store.ui.showTenantAssign=false">✕</button>
            </div>
        <div class="p-4 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <div class="text-sm font-semibold mb-2">Tenant Identity</div>
                <div class="space-y-3">
                    <div>
                        <input name="user[name]" type="text" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('user.name') border-red-500 @enderror" placeholder="Full name" value="{{ old('user.name') }}" required>
                        @error('user.name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input name="user[email]" type="email" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('user.email') border-red-500 @enderror" placeholder="Email" value="{{ old('user.email') }}" required>
                        @error('user.email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input name="tenant[phone]" type="text" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('tenant.phone') border-red-500 @enderror" placeholder="Phone (optional)" value="{{ old('tenant.phone') }}">
                        @error('tenant.phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input name="tenant[date_of_birth]" type="date" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('tenant.date_of_birth') border-red-500 @enderror" value="{{ old('tenant.date_of_birth') }}">
                        @error('tenant.date_of_birth')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input name="tenant[address]" type="text" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('tenant.address') border-red-500 @enderror" placeholder="Address (optional)" value="{{ old('tenant.address') }}">
                        @error('tenant.address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <input name="tenant[valid_id]" type="file" class="w-full text-sm @error('tenant.valid_id') border-red-500 @enderror">
                        @error('tenant.valid_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <textarea name="tenant[notes]" rows="2" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('tenant.notes') border-red-500 @enderror" placeholder="Notes (optional)">{{ old('tenant.notes') }}</textarea>
                        @error('tenant.notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div>
                <div class="text-sm font-semibold mb-2">Unit</div>
                <div class="space-y-3">
                    <div>
                        <select name="lease[unit_id]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('lease.unit_id') border-red-500 @enderror" required>
                            <option value="">Choose a vacant unit…</option>
                            @foreach($units->where('status', 'vacant') as $unit)
                                <option value="{{ $unit->id }}" {{ old('lease.unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->code }} - {{ $unit->description ?? 'No description' }}</option>
                            @endforeach
                        </select>
                        @error('lease.unit_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <p class="text-xs text-gray-500">Only vacant units are listed.</p>
                </div>
            </div>
            <div>
                <div class="text-sm font-semibold mb-2">Lease</div>
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <input name="lease[start_date]" type="date" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('lease.start_date') border-red-500 @enderror" value="{{ old('lease.start_date') }}" required>
                            @error('lease.start_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <input name="lease[end_date]" type="date" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('lease.end_date') border-red-500 @enderror" value="{{ old('lease.end_date') }}">
                            @error('lease.end_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <input name="lease[monthly_rent]" type="number" step="0.01" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('lease.monthly_rent') border-red-500 @enderror" placeholder="Monthly rent" value="{{ old('lease.monthly_rent') }}" required>
                            @error('lease.monthly_rent')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <input name="lease[security_deposit]" type="number" step="0.01" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('lease.security_deposit') border-red-500 @enderror" placeholder="Deposit (optional)" value="{{ old('lease.security_deposit') }}">
                            @error('lease.security_deposit')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <input name="lease[document]" type="file" class="w-full text-sm @error('lease.document') border-red-500 @enderror">
                        @error('lease.document')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <textarea name="lease[notes]" rows="2" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('lease.notes') border-red-500 @enderror" placeholder="Lease notes (optional)">{{ old('lease.notes') }}</textarea>
                        @error('lease.notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
            <div class="px-4 pb-4 flex items-center justify-end gap-2">
                <button type="button" class="px-3 py-2 rounded-md border" @click="$store.ui.showTenantAssign=false">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Create Tenant & Assign</button>
            </div>
        </form>
    </div>
</div>
