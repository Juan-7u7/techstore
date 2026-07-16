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
            // Paleta de colores personalizada del proyecto
            colors: {
                fondo: '#FAFAFA',   // Fondo principal claro
                accent: '#C7EEFF',  // Azul claro para detalles y hover
                primary: '#0077C0', // Azul principal para botones y titulos
                dark: '#1D242B',    // Oscuro para texto y headers
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            // Sistema de espaciado basado en 8px (Shopify)
            spacing: {
                18: '4.5rem',
                22: '5.5rem',
                30: '7.5rem',
                34: '8.5rem',
                38: '9.5rem',
                42: '10.5rem',
                50: '12.5rem',
            },
            // Stacked shadows estilo Shopify
            boxShadow: {
                'stack-sm': '0 1px 2px rgba(0,0,0,0.06), 0 1px 3px rgba(0,0,0,0.1)',
                'stack-md': '0 2px 4px rgba(0,0,0,0.06), 0 4px 6px rgba(0,0,0,0.08)',
                'stack-lg': '0 4px 6px rgba(0,0,0,0.05), 0 8px 16px rgba(0,0,0,0.08)',
                'stack-xl': '0 6px 12px rgba(0,0,0,0.05), 0 12px 24px rgba(0,0,0,0.08)',
            },
            // Radio de borde tipo pill
            borderRadius: {
                pill: '9999px',
            },
        },
    },

    plugins: [forms],
};
