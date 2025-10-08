import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
    extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                background: '#000000', // fond noir pur
                primary: '#2BFAFA',    // couleur principale bleu cyran
                text: {
                    DEFAULT: '#ffffff', // texte blanc
                    primary: '#2BFAFA', // texte couleur principale
                },
            },
            borderRadius: {
                DEFAULT: '0.75rem',  // arrondis par défaut
                lg: '1rem',
                full: '9999px',
            },
        },
    },

    plugins: [
        forms,
        typography,
    ],
};