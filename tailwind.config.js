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
        'bg-brand-orange',
        'bg-brand-orange-pale',
        'border-brand-orange',
        'text-brand-orange',
        'bg-navy',
        'border-navy',
        'text-navy',
        'bg-brand-danger',
        'border-brand-danger',
        'bg-brand-muted',
        'border-brand-border',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Public Sans', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                navy: {
                    DEFAULT: '#0D2B4E',
                    dark: '#0a2240',
                },
                brand: {
                    orange: '#E87820',
                    'orange-pale': 'rgba(232, 120, 32, 0.10)',
                    cream: '#F4F7FA',
                    border: '#DDE6EE',
                    muted: '#8AAABB',
                    danger: '#E05050',
                },
            },
            boxShadow: {
                vuexy: '0 2px 6px rgba(13, 43, 78, 0.08)',
            },
        },
    },

    plugins: [forms],
};
