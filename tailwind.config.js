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
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
