<div class="space-y-6">
    <x-hotel.page-header
        :title="__('Activity Log')"
        :subtitle="__('Audit trail login, check-in/out, dan perubahan slot.')"
    />

    <x-hotel.card :noPadding="true">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:border-slate-800 dark:bg-slate-800/50 dark:text-slate-400">
                        <th class="px-6 py-3.5">{{ __('Waktu') }}</th>
                        <th class="px-6 py-3.5">{{ __('Pengguna') }}</th>
                        <th class="px-6 py-3.5">{{ __('Aksi') }}</th>
                        <th class="px-6 py-3.5">{{ __('Deskripsi') }}</th>
                        <th class="px-6 py-3.5">{{ __('IP') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($logs as $log)
                        <tr class="transition hover:bg-slate-50/80 dark:hover:bg-slate-800/30">
                            <td class="whitespace-nowrap px-6 py-3.5 text-slate-600 dark:text-slate-300">{{ $log->created_at->timezone(config('app.timezone'))->format('d M Y H:i:s') }}</td>
                            <td class="px-6 py-3.5 font-medium text-slate-800 dark:text-white">{{ $log->user?->name ?? '—' }}</td>
                            <td class="px-6 py-3.5">
                                <span class="rounded-md bg-red-500/10 px-2 py-0.5 font-mono text-[11px] font-semibold text-red-700 dark:text-red-300">{{ $log->action }}</span>
                            </td>
                            <td class="px-6 py-3.5 text-slate-600 dark:text-slate-300">{{ $log->description }}</td>
                            <td class="px-6 py-3.5 font-mono text-xs text-slate-500">{{ $log->ip_address }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-slate-100 px-6 py-4 dark:border-slate-800">
            {{ $logs->links() }}
        </div>
    </x-hotel.card>
</div>
