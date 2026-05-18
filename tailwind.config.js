import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Enums/**/*.php',
    ],

    safelist: [
        'bg-emerald-500',
        'bg-emerald-500/90',
        'border-emerald-600',
        'bg-rose-500',
        'bg-rose-500/90',
        'border-rose-600',
        'bg-amber-400',
        'bg-amber-400/95',
        'border-amber-500',
        'bg-slate-400',
        'bg-slate-400/90',
        'border-slate-500',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Public Sans', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#fef2f2',
                    100: '#fee2e2',
                    200: '#fecaca',
                    300: '#fca5a5',
                    400: '#f87171',
                    500: '#ef4444',
                    600: '#dc2626',
                    700: '#b91c1c',
                    800: '#991b1b',
                    900: '#7f1d1d',
                    950: '#450a0a',
                },
                vuexy: {
                    sidebar: '#2a0e12',
                    body: '#f5f5f9',
                },
            },
            boxShadow: {
                vuexy: '0 2px 6px rgba(47, 43, 61, 0.08)',
            },
        },
    },

    plugins: [forms],
};
