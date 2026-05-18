@props(['title' => null, 'badge' => null, 'noPadding' => false])

<div {{ $attributes->merge(['class' => 'vuexy-card overflow-hidden']) }}>
    @if ($title || $badge || isset($header))
        <div class="flex items-center justify-between gap-3 border-b border-slate-100 px-6 py-4 dark:border-slate-800">
            @if (isset($header))
                {{ $header }}
            @else
                <h2 class="text-[15px] font-semibold text-slate-800 dark:text-white">{{ $title }}</h2>
                @if ($badge)
                    <span class="vuexy-badge">{{ $badge }}</span>
                @endif
            @endif
        </div>
    @endif
    <div @class(['px-6 py-5' => ! $noPadding])>
        {{ $slot }}
    </div>
</div>
