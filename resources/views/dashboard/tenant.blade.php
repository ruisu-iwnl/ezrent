<div class="space-y-4 max-w-4xl mx-auto" x-data>
	{{-- Minimal Header (no cards) --}}
	<div class="flex items-center justify-between">
		<div class="flex items-baseline gap-2">
			<h2 class="text-lg font-semibold text-gray-900 dark:text-white">Tenant Overview</h2>
			<span class="text-xs text-gray-500 dark:text-gray-400">Lease and billing at a glance</span>
		</div>
		<div class="flex items-center gap-6 text-right">
			<div>
				<div class="text-[11px] text-gray-500 dark:text-gray-400">Monthly Rent</div>
				<div class="text-lg font-semibold text-indigo-600">₱{{ number_format($monthlyRent ?? 0, 2) }}</div>
			</div>
			<div>
				<div class="text-[11px] text-gray-500 dark:text-gray-400">Next Due</div>
				<div class="text-lg font-semibold text-orange-500">{{ isset($nextDueDate) ? $nextDueDate->format('M d, Y') : '—' }}</div>
			</div>
		</div>
	</div>

	<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
		{{-- Lease (divider-based) --}}
		<div>
			<h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Lease</h4>
			<dl class="divide-y divide-gray-200 dark:divide-gray-800 text-sm">
				<div class="grid grid-cols-2 py-2">
					<dt class="text-gray-600 dark:text-gray-400">Unit</dt>
					<dd class="text-right font-medium text-gray-900 dark:text-gray-100">{{ optional($lease?->unit)->code ?? '—' }}</dd>
				</div>
				<div class="grid grid-cols-2 py-2">
					<dt class="text-gray-600 dark:text-gray-400">Lease Term</dt>
					<dd class="text-right font-medium text-gray-900 dark:text-gray-100">{{ $lease?->start_date?->format('M d, Y') ?? '—' }} – {{ $lease?->end_date?->format('M d, Y') ?? '—' }}</dd>
				</div>
				<div class="grid grid-cols-2 py-2">
					<dt class="text-gray-600 dark:text-gray-400">Rent</dt>
					<dd class="text-right font-medium text-gray-900 dark:text-gray-100">₱{{ number_format($lease->monthly_rent ?? 0, 2) }} / month</dd>
				</div>
				<div class="grid grid-cols-2 py-2">
					<dt class="text-gray-600 dark:text-gray-400">Deposit</dt>
					<dd class="text-right font-medium text-gray-900 dark:text-gray-100">₱{{ number_format($lease->security_deposit ?? 0, 2) }}</dd>
				</div>
				<div class="grid grid-cols-2 py-2">
					<dt class="text-gray-600 dark:text-gray-400">This Month Remaining</dt>
					<dd class="text-right font-semibold {{ ($currentMonthRemaining ?? 0) > 0 ? 'text-orange-500' : 'text-green-600' }}">₱{{ number_format($currentMonthRemaining ?? 0, 2) }}</dd>
				</div>
			</dl>
		</div>

		{{-- Payments (stacked rows) --}}
		<div>
			<h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Payments</h4>
			<div class="space-y-3">
				@php($isPaid = ($currentMonthRemaining ?? 0) <= 0)
				<div class="flex items-center justify-between">
					<div>
						<div class="text-[11px] text-gray-500 dark:text-gray-400">Upcoming Due</div>
						<div class="text-xl font-bold text-gray-900 dark:text-gray-100">₱{{ number_format($monthlyRent ?? 0, 2) }}</div>
						<div class="text-sm text-gray-600 dark:text-gray-400">{{ isset($nextDueDate) ? $nextDueDate->format('M d, Y') : '—' }}</div>
					</div>
					<span class="text-xs px-2 py-1 rounded font-medium {{ $isPaid ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300' }}">{{ $isPaid ? 'Paid' : 'Due' }}</span>
				</div>
				@if(!$isPaid)
					<div class="text-sm">
						<span class="text-gray-600 dark:text-gray-400">Remaining this month:</span>
						<span class="font-semibold text-orange-600 dark:text-orange-400">₱{{ number_format($currentMonthRemaining ?? 0, 2) }}</span>
					</div>
				@endif

				<div class="border-t border-gray-200 dark:border-gray-800 pt-3">
					<div class="text-[11px] text-gray-500 dark:text-gray-400">Recent Payment</div>
					@if($recentPayment)
						<div class="flex items-end justify-between">
							<div>
								<div class="text-xl font-bold text-green-600 dark:text-green-400">₱{{ number_format($recentPayment->amount, 2) }}</div>
								<div class="text-sm text-gray-600 dark:text-gray-400">{{ $recentPayment->paid_at->format('M d, Y') }}</div>
							</div>
							<span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">{{ strtoupper($recentPayment->method) }}</span>
						</div>
					@else
						<div class="text-sm text-gray-500 dark:text-gray-400">No payments yet.</div>
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="grid grid-cols-1 gap-4">
		<h4 class="text-sm font-semibold text-gray-900 dark:text-white">Contact Information</h4>
		<form action="{{ route('tenants.update', $tenant?->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-3">
			@csrf
			@method('PUT')
			<div>
				<label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
				<input type="text" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700" value="{{ auth()->user()->name }}" disabled />
			</div>
			<div>
				<label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Email</label>
				<input type="email" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700" value="{{ auth()->user()->email }}" disabled />
			</div>
			<div>
				<label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Phone</label>
				<input name="tenant[phone]" inputmode="numeric" pattern="[0-9]*" type="text" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700" value="{{ $tenant?->phone }}" />
			</div>
			<div>
				<label class="block text-sm text-gray-700 dark:text-gray-300 mb-1">Address</label>
				<input name="tenant[address]" type="text" class="w-full rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700" value="{{ $tenant?->address }}" />
			</div>
			<div class="md:col-span-2 flex items-center justify-end">
				<button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Save Changes</button>
			</div>
		</form>
	</div>
</div>

