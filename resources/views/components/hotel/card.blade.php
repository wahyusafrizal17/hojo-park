@props(['title' => null, 'badge' => null, 'noPadding' => false])

<div {{ $attributes->merge(['class' => 'vuexy-card overflow-hidden']) }}>
    @if ($title || $badge || isset($header))
        <div class="flex items-center justify-between gap-3 border-b border-brand-border px-6 py-4">
            @if (isset($header))
                {{ $header }}
            @else
                <h2 class="text-[15px] font-semibold text-navy">{{ $title }}</h2>
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
