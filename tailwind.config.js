const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
    
    safelist: [
        'bg-teal-500',
        'bg-teal-600',
        'text-teal-500',
        'text-teal-600',
        'text-teal-700',
        'border-teal-500',
        'hover:bg-teal-600',
        'hover:text-teal-600',
        'focus:border-teal-500',
        'focus:outline-teal-500',
        'focus:ring-teal-500',
    ],
};
