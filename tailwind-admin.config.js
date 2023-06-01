const colors = require('tailwindcss/colors');

module.exports = {
    mode: 'jit',
    content: [
        './resources/views/admin/**/*.blade.php',
        './resources/views/components/admin/**/*.blade.php',
        './resources/views/components/svg/**/*.blade.php',
        './resources/admin/**/*.js',
        './resources/admin/**/*.scss',
        './resources/admin/**/*.vue',
    ],
    theme: {
        container: {
            center: true,
        },
        colors: {
            ...colors,
            brand: {
                DEFAULT: '#a50034',
            },
            black: {
                ...colors.black,
                DEFAULT: '#000',
                brand: '#212322'
            },
            gray: {
                ...colors.gray,
                DEFAULT: '#000',
                100: '#F9FAFC',
                200: '#EDEFFA',
                300: '#E4E4E4',
                600: '#6d7188',
                700: '#4b4c4d',
                800: '#333',
                900: '#212322',
            },
            red: {
                ...colors.red,
                DEFAULT: '#f00',
                burgundian: '#a50034',
                'burgundian-dark': '#750025',
            },
            white: {
                DEFAULT: '#fff',
            },
            transparent: {
                DEFAULT: 'transparent',
            },
            maxHeight: {
                16: '4rem',
                20: '5rem',
            },
        },
        extend: {
            boxShadow: {
                table: '0px 0px 20px rgba(102, 117, 255, 0.06)',
                block: '0px 0px 40px rgba(22, 23, 28, 0.06)',
                lite: '0px 0px 1px rgba(0, 0, 0, 0.15)',
            },
        },
    },
};
