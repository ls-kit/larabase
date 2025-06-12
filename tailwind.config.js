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
            // fontFamily: {
            //     sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            // },
            fontFamily: {
        sans: ['"Hind Siliguri"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
            colors: {
          primary: '#005f73',
          secondary: '#0a9396',
          accent: '#94d2bd',
          highlight: '#ee9b00',
            neon: '#d4f1f4',
            'primary-dark': '#003f43'
        }
        ,
          boxShadow: {
            neon: '0 0 15px rgba(212, 241, 244, 0.5)',
            'neon-lg': '0 0 25px rgba(212, 241, 244, 0.7)'
          }
        },
    },

    plugins: [forms],
};
