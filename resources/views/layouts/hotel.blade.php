<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full"
    x-data="{
        dark: false,
        sidebarOpen: false,
        userMenu: false,
    }"
    x-init="dark = (localStorage.getItem('hotel_theme') === 'dark'); $watch('dark', v => localStorage.setItem('hotel_theme', v ? 'dark' : 'light'))"
    x-bind:class="{ 'dark': dark }"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? config('app.name') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=public-sans:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="h-full font-sans antialiased" style="font-family:'Public Sans',ui-sans-serif,system-ui,sans-serif">
        @php
            $user = auth()->user();
            $roleLabel = $user?->roleLabel() ?? '';
            $initials = $user ? strtoupper(substr($user->name, 0, 1).(str_contains($user->name, ' ') ? substr($user->name, strpos($user->name, ' ') + 1, 1) : substr($user->name, 1, 1))) : 'U';
        @endphp

        <div class="min-h-screen">
            @if (session()->has('hotel_toast'))
                <div
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 3200)"
                    x-show="show"
                    x-transition.opacity
                    class="fixed right-5 top-5 z-[100] w-80 max-w-[90vw]"
                >
                    @php($t = session('hotel_toast'))
                    <div @class([
                        'rounded-lg border px-4 py-3 text-sm shadow-lg',
                        'border-brand-border bg-white text-navy dark:border-slate-700 dark:bg-[#0f2744] dark:text-slate-200' => ($t['type'] ?? 'success') === 'success',
                        'border-brand-danger/30 bg-white text-brand-danger dark:border-brand-danger/40 dark:bg-[#0f2744]' => ($t['type'] ?? '') === 'error',
                    ])>
                        {{ $t['message'] ?? '' }}
                    </div>
                </div>
            @endif

            {{-- Mobile overlay --}}
            <div
                x-show="sidebarOpen"
                x-transition.opacity
                class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"
                @click="sidebarOpen = false"
                x-cloak
            ></div>

            {{-- Sidebar --}}
            <aside
                class="vuexy-sidebar vuexy-scrollbar fixed inset-y-0 left-0 z-50 flex w-[260px] flex-col transition-transform duration-200 lg:translate-x-0"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            >
                <div class="flex h-[4.25rem] items-center gap-3 border-b border-white/10 px-5">
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex min-w-0 flex-1 items-center">
                        <img
                            src="{{ asset('logo.png') }}"
                            alt="{{ config('app.name') }}"
                            class="h-9 w-auto max-w-[160px] object-contain"
                        />
                    </a>
                    <button type="button" class="shrink-0 rounded-lg p-1.5 text-slate-400 hover:bg-white/10 lg:hidden" @click="sidebarOpen = false">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-width="1.5" d="M6 6l12 12M18 6L6 18"/></svg>
                    </button>
                </div>

                <nav class="vuexy-scrollbar flex-1 space-y-1 overflow-y-auto px-3 py-4">
                    <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-widest text-brand-muted">{{ __('Menu') }}</p>
                    <x-hotel.nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="home">{{ __('Dashboard') }}</x-hotel.nav-link>
                    <x-hotel.nav-link href="{{ route('parking.map') }}" :active="request()->routeIs('parking.map')" icon="map">{{ __('Denah Parkir') }}</x-hotel.nav-link>
                    @if ($user?->isAdministrator())
                        <x-hotel.nav-link href="{{ route('parking.history') }}" :active="request()->routeIs('parking.history')" icon="table">{{ __('Riwayat Parkir') }}</x-hotel.nav-link>
                        <x-hotel.nav-link href="{{ route('parking.activity') }}" :active="request()->routeIs('parking.activity')" icon="shield">{{ __('Activity Log') }}</x-hotel.nav-link>
                        <x-hotel.nav-link href="{{ route('settings') }}" :active="request()->routeIs('settings')" icon="settings">{{ __('Pengaturan') }}</x-hotel.nav-link>
                    @endif
                    <p class="mb-2 mt-6 px-3 text-[11px] font-semibold uppercase tracking-widest text-brand-muted">{{ __('Akun') }}</p>
                    <x-hotel.nav-link href="{{ route('profile') }}" :active="request()->routeIs('profile')" icon="user">{{ __('Profil') }}</x-hotel.nav-link>
                </nav>

                <div class="border-t border-white/10 p-4">
                    <div class="flex items-center gap-3 rounded-lg bg-white/5 px-3 py-2.5">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-orange/20 text-xs font-bold text-brand-orange ring-1 ring-brand-orange/40">
                            {{ $initials }}
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium text-white">{{ $user->name }}</p>
                            <p class="truncate text-xs text-brand-muted">{{ $roleLabel }}</p>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Main --}}
            <div class="lg:ps-[260px]">
                <header class="sticky top-0 z-30 border-b border-brand-border bg-white shadow-sm backdrop-blur-md dark:border-slate-700/60 dark:bg-[#0f2744]/95">
                    <div class="flex h-[4.25rem] items-center gap-3 px-4 sm:px-6">
                        <button
                            type="button"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-brand-border text-brand-muted hover:bg-brand-cream dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800/80 lg:hidden"
                            @click="sidebarOpen = true"
                        >
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                        </button>

                        <div class="hidden min-w-0 flex-1 md:block md:max-w-xl">
                            <livewire:layout.global-search />
                        </div>

                        <div class="ms-auto flex items-center gap-1.5 sm:gap-2">
                            <button
                                type="button"
                                @click="dark = !dark"
                                class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                                title="{{ __('Toggle theme') }}"
                            >
                                <svg x-show="!dark" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                                <svg x-show="dark" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"/></svg>
                            </button>

                            <div class="relative" @click.outside="userMenu = false">
                                <button
                                    type="button"
                                    @click="userMenu = !userMenu"
                                    class="flex items-center gap-2 rounded-lg py-1.5 pe-2 ps-1.5 transition hover:bg-brand-cream dark:hover:bg-slate-800/80"
                                >
                                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-navy text-xs font-bold text-white">{{ $initials }}</span>
                                    <span class="hidden text-start sm:block">
                                        <span class="block text-sm font-medium text-navy dark:text-white">{{ $user->name }}</span>
                                        <span class="block text-xs text-brand-muted dark:text-slate-400">{{ $roleLabel }}</span>
                                    </span>
                                    <svg class="hidden h-4 w-4 text-brand-muted sm:block" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" stroke-linecap="round" d="M6 9l6 6 6-6"/></svg>
                                </button>
                                <div
                                    x-show="userMenu"
                                    x-transition
                                    x-cloak
                                    class="absolute end-0 mt-2 w-52 overflow-hidden rounded-lg border border-brand-border bg-white py-1 shadow-lg dark:border-slate-700 dark:bg-[#0f2744]"
                                >
                                    <a href="{{ route('profile') }}" wire:navigate class="flex items-center gap-2 px-4 py-2.5 text-sm text-navy hover:bg-brand-cream dark:text-slate-200 dark:hover:bg-slate-800/80">
                                        <svg class="h-4 w-4 opacity-60" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/></svg>
                                        {{ __('Profil') }}
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-sm text-brand-danger hover:bg-brand-danger/5">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-width="1.5" stroke-linecap="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                                            {{ __('Keluar') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-t border-brand-border px-4 py-2.5 dark:border-slate-700/60 md:hidden">
                        <livewire:layout.global-search />
                    </div>
                </header>

                <main class="px-4 py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>

                <footer class="px-6 pb-6 pt-2 text-center text-xs text-brand-muted">
                    © {{ date('Y') }} {{ config('app.name') }} · {{ __('Manajemen Parkir Hotel') }}
                </footer>
            </div>
        </div>
        @livewireScripts
        @stack('scripts')
    </body>
</html>
