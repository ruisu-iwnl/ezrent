<div x-show="$store.ui.showUnit" x-cloak x-transition class="fixed inset-0 z-[110] flex items-center justify-center">
    <div class="fixed inset-0 w-screen h-screen bg-black/60 transition-none" @click="$store.ui.showUnit=false"></div>
    <div class="relative z-[120] w-full max-w-2xl bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <form method="POST" action="{{ route('units.store') }}">
            @csrf
            <div class="px-4 py-3 border-b border-gray-200/60 dark:border-gray-700 flex items-center justify-between">
                <h4 class="font-medium">Add Unit</h4>
                <button type="button" class="text-gray-500" @click="$store.ui.showUnit=false">✕</button>
            </div>
            <div class="p-4 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm block mb-1">Code</label>
                        <input name="unit[code]" type="text" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('unit.code') border-red-500 @enderror" placeholder="A-201" value="{{ old('unit.code') }}" required>
                        @error('unit.code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm block mb-1">Status</label>
                        <select name="unit[status]" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('unit.status') border-red-500 @enderror" required>
                            <option value="vacant" {{ old('unit.status', 'vacant') === 'vacant' ? 'selected' : '' }}>Vacant</option>
                            <option value="maintenance" {{ old('unit.status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('unit.status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label class="text-sm block mb-1">Description</label>
                    <textarea name="unit[description]" rows="3" class="w-full rounded-md border-gray-300 dark:bg-gray-900 dark:border-gray-700 @error('unit.description') border-red-500 @enderror" placeholder="Optional details">{{ old('unit.description') }}</textarea>
                    @error('unit.description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="px-4 pb-4 flex items-center justify-end gap-2">
                <button type="button" class="px-3 py-2 rounded-md border" @click="$store.ui.showUnit=false">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Create Unit</button>
            </div>
        </form>
    </div>
</div>
