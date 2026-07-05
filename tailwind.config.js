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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Anton', 'sans-serif'],
                label: ['"Bebas Neue"', 'sans-serif'],
                oswald: ['Oswald', 'sans-serif'],
            },
            colors: {
                brand: {
                    cream: '#F4F1EA',
                    dark: '#1D1D1D',
                    orange: '#D95C3F',
                    green: '#256D4A',
                    'green-light': '#5C8D59',
                    brown: '#8B6B4A',
                }
            }
        },
    },

    plugins: [forms],
};

