<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'HoJo Park') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-full antialiased" style="font-family: Inter, ui-sans-serif, system-ui, sans-serif">
        <div class="relative min-h-screen overflow-hidden bg-gradient-to-br from-navy via-[#0f3560] to-navy">
            {{-- Ornamen organik --}}
            <div class="pointer-events-none absolute inset-0" aria-hidden="true">
                <svg class="absolute -left-24 -top-32 h-[28rem] w-[28rem] text-white/15" viewBox="0 0 400 400" fill="currentColor">
                    <path d="M200 0C310 0 400 90 400 200s-90 200-200 200S0 310 0 200 90 0 200 0zm0 80c-66 0-120 54-120 120s54 120 120 120 120-54 120-120-54-120-120-120z" opacity="0.9" />
                </svg>
                <svg class="absolute -right-16 top-1/4 h-80 w-80 text-rose-100/20" viewBox="0 0 320 320" fill="currentColor">
                    <ellipse cx="160" cy="160" rx="140" ry="120" />
                </svg>
                <svg class="absolute bottom-0 left-1/3 h-96 w-96 -translate-x-1/2 text-white/10" viewBox="0 0 400 300" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M0 280 Q100 200 200 250 T400 220" />
                    <path d="M0 240 Q150 120 400 200" opacity="0.6" />
                </svg>
            </div>
            {{-- Garis diagonal halus --}}
            <div
                class="pointer-events-none absolute inset-0 opacity-[0.06]"
                style="background-image: repeating-linear-gradient(-35deg, #fff 0, #fff 1px, transparent 1px, transparent 14px);"
                aria-hidden="true"
            ></div>

            <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-10 sm:px-6 sm:py-12">
                @if (request()->routeIs('login'))
                    {{ $slot }}
                @else
                    <div class="w-full max-w-md rounded-3xl border border-white/20 bg-white p-8 shadow-2xl shadow-black/20">
                        {{ $slot }}
                    </div>
                @endif
            </div>
        </div>
        @livewireScripts
    </body>
</html>
