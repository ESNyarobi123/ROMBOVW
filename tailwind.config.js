import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                mobilex: {
                    bg: '#0a1711',          /* Very dark green background */
                    panel: '#10261a',       /* Dark green for cards */
                    panelHover: '#163625',  /* Hover state for panels */
                    primary: '#86efac',     /* Soft neon green text */
                    accent: '#39FF14',      /* Extreme neon green action buttons */
                    accentHover: '#66ff4d', /* Brighter neon green for hover */
                    border: '#1b3d29',      /* Subtle green borders */
                    textSoft: '#bbf7d0',    /* Soft neon green highlights */
                    white: '#ffffff'        /* Pure white */
                }
            }
        },
    },
    plugins: [],
};
