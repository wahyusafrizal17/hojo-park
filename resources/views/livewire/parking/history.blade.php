<div class="space-y-6" wire:poll.10s>
    <x-hotel.page-header
        :title="__('Riwayat Parkir')"
        :subtitle="__('Filter tanggal, ekspor Excel/PDF, dan lacak durasi parkir.')"
    >
        <x-slot name="actions">
            <a href="{{ route('parking.history.excel', request()->query()) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-orange px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-emerald-700">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" d="M12 16.5V3m0 0L8.25 6.75M12 3l3.75 3.75M4.5 19.5h15"/></svg>
                Excel
            </a>
            <a href="{{ route('parking.history.pdf', request()->query()) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-200">
                <svg class="h-4 w-4 text-rose-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
                PDF
            </a>
        </x-slot>
    </x-hotel.page-header>

    <x-hotel.card :title="__('Filter')">
        <div class="grid gap-4 md:grid-cols-3">
            <div>
                <label class="mb-1.5 block text-xs font-medium text-slate-600 dark:text-slate-400">{{ __('Dari tanggal') }}</label>
                <input type="date" wire:model.live="date_from" class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm focus:border-brand-orange focus:ring-brand-orange/20 dark:border-slate-600 dark:bg-slate-800" />
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-medium text-slate-600 dark:text-slate-400">{{ __('Sampai tanggal') }}</label>
                <input type="date" wire:model.live="date_to" class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm focus:border-brand-orange focus:ring-brand-orange/20 dark:border-slate-600 dark:bg-slate-800" />
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-medium text-slate-600 dark:text-slate-400">{{ __('Status') }}</label>
                <select wire:model.live="status" class="w-full rounded-lg border-slate-200 bg-slate-50 text-sm focus:border-brand-orange focus:ring-brand-orange/20 dark:border-slate-600 dark:bg-slate-800">
                    <option value="">{{ __('Semua') }}</option>
                    <option value="active">{{ __('Aktif') }}</option>
                    <option value="completed">{{ __('Selesai') }}</option>
                    <option value="cancelled">{{ __('Batal') }}</option>
                </select>
            </div>
        </div>
    </x-hotel.card>

    <x-hotel.card :noPadding="true">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="table-head">
                        <th class="px-6 py-3.5">{{ __('Tamu') }}</th>
                        <th class="px-6 py-3.5">{{ __('Kamar') }}</th>
                        <th class="px-6 py-3.5">{{ __('Plat') }}</th>
                        <th class="px-6 py-3.5">{{ __('Slot') }}</th>
                        <th class="px-6 py-3.5">{{ __('Masuk') }}</th>
                        <th class="px-6 py-3.5">{{ __('Keluar') }}</th>
                        <th class="px-6 py-3.5">{{ __('Durasi') }}</th>
                        <th class="px-6 py-3.5">{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($rows as $row)
                        <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/30">
                            <td class="px-6 py-3.5 font-medium text-slate-800 dark:text-white">{{ $row->guest_name }}</td>
                            <td class="px-6 py-3.5 text-slate-600 dark:text-slate-300">{{ $row->room_number }}</td>
                            <td class="px-6 py-3.5 font-mono text-xs">{{ $row->plate_number }}</td>
                            <td class="px-6 py-3.5">
                                <span class="rounded-md bg-red-500/10 px-2 py-0.5 text-xs font-semibold text-brand-orange dark:text-red-300">{{ $row->slot?->slot_code }}</span>
                            </td>
                            <td class="px-6 py-3.5 text-slate-600 dark:text-slate-300">{{ $row->checked_in_at?->timezone(config('app.timezone'))->format('d M Y H:i') }}</td>
                            <td class="px-6 py-3.5 text-slate-600 dark:text-slate-300">{{ $row->checked_out_at?->timezone(config('app.timezone'))->format('d M Y H:i') ?? '—' }}</td>
                            <td class="px-6 py-3.5 text-slate-600 dark:text-slate-300">{{ $row->durationHuman() ?? '—' }}</td>
                            <td class="px-6 py-3.5">
                                @php
                                    $statusStyles = [
                                        'active' => 'bg-brand-orange/10 text-emerald-700 dark:text-emerald-300',
                                        'completed' => 'bg-slate-500/10 text-slate-600 dark:text-slate-300',
                                        'cancelled' => 'bg-navy/10 text-rose-700 dark:text-rose-300',
                                    ];
                                @endphp
                                <span class="inline-flex rounded-md px-2 py-0.5 text-[11px] font-semibold uppercase {{ $statusStyles[$row->status->value] ?? '' }}">{{ $row->status->value }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-500">{{ __('Tidak ada data.') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-6 py-4 dark:border-slate-800">
            {{ $rows->links() }}
        </div>
    </x-hotel.card>
</div>
