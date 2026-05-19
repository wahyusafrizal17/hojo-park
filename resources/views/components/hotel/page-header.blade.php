@props(['title', 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between']) }}>
    <div>
        <h1 class="text-[1.35rem] font-semibold tracking-tight text-navy">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-1 text-sm text-brand-muted">{{ $subtitle }}</p>
        @endif
    </div>
    @if (isset($actions))
        <div class="flex flex-wrap items-center gap-2">
            {{ $actions }}
        </div>
    @endif
</div>
