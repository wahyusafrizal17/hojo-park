<div class="relative w-full">
    <div class="relative">
        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3 text-brand-muted dark:text-slate-400">
            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
            </svg>
        </span>
        <input
            type="search"
            wire:model.live.debounce.350ms="q"
            placeholder="{{ __('Cari plat, tamu, atau kamar…') }}"
            class="w-full rounded-lg border border-transparent bg-brand-cream py-2.5 ps-10 pe-4 text-sm text-navy placeholder:text-brand-muted focus:border-brand-orange focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-orange/25 dark:border-slate-700 dark:bg-slate-800/80 dark:text-slate-200 dark:placeholder:text-slate-500 dark:focus:border-brand-orange dark:focus:bg-slate-800"
        />
    </div>
    @if (strlen(trim($q)) >= 2)
        <div class="absolute z-50 mt-2 max-h-80 w-full overflow-auto rounded-lg border border-brand-border bg-white py-1 shadow-xl dark:border-slate-700 dark:bg-[#0f2744]">
            @forelse ($results as $r)
                <a
                    href="{{ route('parking.map') }}"
                    wire:navigate
                    class="block border-b border-brand-border/60 px-4 py-3 transition last:border-0 hover:bg-brand-cream dark:border-slate-700/60 dark:hover:bg-slate-800/80"
                >
                    <p class="font-medium text-navy dark:text-white">{{ $r->guest_name }}</p>
                    <p class="mt-0.5 text-xs text-brand-muted dark:text-slate-400">{{ $r->plate_number }} · {{ __('Kamar') }} {{ $r->room_number }} · {{ $r->slot?->slot_code }}</p>
                </a>
            @empty
                <p class="px-4 py-6 text-center text-sm text-brand-muted dark:text-slate-400">{{ __('Tidak ditemukan.') }}</p>
            @endforelse
        </div>
    @endif
</div>
