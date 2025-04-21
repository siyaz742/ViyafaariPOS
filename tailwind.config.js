import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Lato', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'main-verylight': '#A1C6D3',
                'main-light': '#5A8FA3',
                'main-dark': '#284B63',
                'main-dark75': 'rgba(40, 75, 99, 0.75)',
                'main-light75': 'rgba(90, 143, 163, 0.75)',
                'main-light40': 'rgba(90, 143, 163, 0.40)',
                'main-light10': 'rgba(90, 143, 163, 0.05)',
                'accent-superlight': 'rgba(129, 108, 97, 0.25)',
                'accent-verylight': '#F1E6D2',
                'accent-light': '#D5C6B1',
                'accent-dark': '#816C61',
                'accent-dark85': 'rgba(129, 108, 97, 0.85)',
                'accent-light85': 'rgba(213, 198, 177, 0.85)',
                'outline': '#1C2938',
                'tpwhite': 'rgba(255, 255, 255, 0.15)',
                'excel-green': 'rgba(33, 115, 70, 255)',
                'excel-light': 'rgba(33, 163, 102, 0.70)',
                'pdf-red': 'rgba(244, 15, 2, 0.60)'

            },
        },
    },

    plugins: [forms],
};
