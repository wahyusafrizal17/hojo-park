@props([
    'label',
    'value',
    'hint' => null,
    'icon' => 'chart',
    'tone' => 'primary',
])

@php
    $tones = [
        'primary' => ['bg' => 'bg-red-500/10', 'icon' => 'text-red-600 dark:text-red-400', 'ring' => 'ring-red-500/20'],
        'success' => ['bg' => 'bg-emerald-500/10', 'icon' => 'text-emerald-600 dark:text-emerald-400', 'ring' => 'ring-emerald-500/20'],
        'danger' => ['bg' => 'bg-rose-500/10', 'icon' => 'text-rose-600 dark:text-rose-400', 'ring' => 'ring-rose-500/20'],
        'warning' => ['bg' => 'bg-amber-500/10', 'icon' => 'text-amber-600 dark:text-amber-400', 'ring' => 'ring-amber-500/20'],
        'info' => ['bg' => 'bg-red-500/10', 'icon' => 'text-red-600 dark:text-red-400', 'ring' => 'ring-red-500/20'],
    ];
    $t = $tones[$tone] ?? $tones['primary'];

    $icons = [
        'chart' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>',
        'car' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>',
        'check' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'clock' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'grid' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>',
    ];
    $iconPath = $icons[$icon] ?? $icons['chart'];
@endphp

<div {{ $attributes->merge(['class' => 'vuexy-card relative overflow-hidden p-5']) }}>
    <div class="pointer-events-none absolute -right-8 -top-8 h-28 w-28 rounded-full opacity-60 blur-2xl {{ $t['bg'] }}" aria-hidden="true"></div>
    <div class="relative flex items-start justify-between gap-4">
        <div class="min-w-0 flex-1">
            <p class="text-[13px] font-medium text-slate-500 dark:text-slate-400">{{ $label }}</p>
            <p class="mt-1 text-[1.65rem] font-bold leading-none tracking-tight text-slate-800 dark:text-white">{{ $value }}</p>
            @if ($hint)
                <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">{{ $hint }}</p>
            @endif
        </div>
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl ring-1 {{ $t['bg'] }} {{ $t['ring'] }}">
            <svg class="h-6 w-6 {{ $t['icon'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor">{!! $iconPath !!}</svg>
        </div>
    </div>
</div>
