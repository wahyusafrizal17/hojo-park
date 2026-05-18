<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full max-w-4xl">
    <div class="overflow-hidden rounded-3xl bg-white shadow-2xl shadow-black/25 ring-1 ring-black/5">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            {{-- Kolom ilustrasi (desktop) --}}
            <div class="relative hidden min-h-[22rem] items-center justify-center overflow-hidden bg-gradient-to-br from-rose-50 via-white to-red-50 p-6 lg:flex">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(225,29,72,0.12),transparent_50%)]"></div>
                <img
                    src="{{ asset('login.png') }}"
                    alt=""
                    class="relative h-full w-full max-h-[28rem] object-contain object-center"
                />
            </div>

            {{-- Form --}}
            <div class="flex flex-col justify-center px-8 py-10 sm:px-10 sm:py-12">
                <div class="mb-8 flex justify-center">
                    <img
                        src="{{ asset('logo.png') }}"
                        alt="{{ config('app.name') }}"
                        class="h-auto w-full max-w-[220px] object-contain"
                    />
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form wire:submit="login" class="space-y-5">

                    <div x-data="{ showPassword: false }">
                        <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">{{ __('Kata Sandi Akses') }}</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </span>
                            <input
                                wire:model="form.password"
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                required
                                autofocus
                                autocomplete="current-password"
                                placeholder="{{ __('Masukkan kata sandi Security atau Administrator') }}"
                                class="block w-full rounded-xl border border-gray-200 bg-gray-50/50 py-3 pl-11 pr-12 text-sm text-gray-900 placeholder:text-gray-400 transition focus:border-rose-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-rose-500/20"
                            />
                            <button
                                type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 transition hover:text-gray-600"
                                @click="showPassword = !showPassword"
                                :aria-pressed="showPassword"
                                aria-label="{{ __('Tampilkan sandi') }}"
                            >
                                <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('form.password')" class="mt-1.5" />
                    </div>

                    <label class="inline-flex cursor-pointer items-center gap-2">
                        <input wire:model="form.remember" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-rose-600 focus:ring-rose-500/30" name="remember" />
                        <span class="text-sm text-gray-600">{{ __('Ingat sesi ini') }}</span>
                    </label>

                    <button
                        type="submit"
                        class="flex w-full items-center justify-center rounded-xl bg-rose-600 py-3.5 text-sm font-semibold text-white shadow-lg shadow-rose-600/30 transition hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 active:scale-[0.99]"
                    >
                        {{ __('Masuk') }}
                    </button>
                </form>

                <p class="mt-10 text-center text-xs text-gray-400">
                    © {{ date('Y') }} {{ config('app.name') }}. {{ __('Hak cipta dilindungi.') }}
                </p>
            </div>
        </div>
    </div>
</div>
