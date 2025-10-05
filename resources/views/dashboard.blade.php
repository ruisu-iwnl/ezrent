<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @php($role = auth()->user()->role ?? 'tenant')
            {{ $role === 'admin' ? __('Admin Dashboard') : __('Tenant Dashboard') }}
        </h2>
    </x-slot>

    @php($role = auth()->user()->role ?? 'tenant')
    @if($role === 'admin')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        @include('dashboard.admin')
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="py-6">
            <div class="max-w-full mx-auto sm:px-0 lg:px-0">
                <div class="overflow-hidden">
                    <div class="text-gray-900 dark:text-gray-100">
                        @include('dashboard.tenant')
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
