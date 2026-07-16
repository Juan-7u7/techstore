import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],

    theme: {
        extend: {
            colors: {
                fondo: '#F5F5F0',
                surface: '#FFFFFF',
                primary: '#18181B',
                accent: '#3B82F6',
                muted: '#71717A',
                border: '#E4E4E7',
                dark: '#18181B',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                'display': ['3.5rem', { lineHeight: '1.05', fontWeight: '600', letterSpacing: '-0.02em' }],
                'heading': ['2rem', { lineHeight: '1.15', fontWeight: '600', letterSpacing: '-0.01em' }],
                'subheading': ['1.25rem', { lineHeight: '1.3', fontWeight: '500' }],
            },
            spacing: {
                18: '4.5rem',
                22: '5.5rem',
                30: '7.5rem',
                34: '8.5rem',
                38: '9.5rem',
                42: '10.5rem',
                50: '12.5rem',
            },
            boxShadow: {
                'soft-sm': '0 1px 2px rgba(0,0,0,0.04), 0 1px 3px rgba(0,0,0,0.06)',
                'soft-md': '0 2px 4px rgba(0,0,0,0.04), 0 4px 8px rgba(0,0,0,0.06)',
                'soft-lg': '0 4px 8px rgba(0,0,0,0.04), 0 8px 16px rgba(0,0,0,0.06)',
                'soft-xl': '0 8px 16px rgba(0,0,0,0.04), 0 16px 24px rgba(0,0,0,0.06)',
            },
            borderRadius: {
                pill: '9999px',
            },
        },
    },

    plugins: [forms],
};
