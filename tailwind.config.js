import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#1E3A8A', // Replace with your preferred primary color
                secondary: '#F3F4F6', // Replace with your preferred secondary color
                black: '#000000',
            },
            animation: {
                'slide': 'slide 5s linear infinite',  // Duration set to 5 seconds
            },
            keyframes: {
                slide: {
                    '0%': { transform: 'translateX(0)' },
                    '100%': { transform: 'translateX(-100%)' },
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/aspect-ratio'),
    ],
};
