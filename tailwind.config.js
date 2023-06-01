const colors = require("tailwindcss/colors");

module.exports = {
    mode: 'jit',
    content: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            screens: {
                'xl': '1200px',
                '2xl': '1540px',
            },
            maxHeight: {
                '1/4': '25%',
                '1/2': '50%',
                '3/4': '75%',
            },
            height: {
                '92': '357px',
            },
            spacing: {
                1: '5px',
                2: '10px',
                3: '15px',
                4: '20px',
                5: '25px',
                6: '30px',
                7: '35px',
                8: '40px',
                9: '45px',
                10: '50px',
                11: '55px',
                12: '60px',
                13: '65px',
                14: '70px',
                15: '75px',
                16: '80px',
                17: '85px',
                18: '90px',
                19: '95px',
                20: '100px',
                21: '105px',
                22: '110px',
                23: '115px',
                24: '120px',
                30: '150px',
                extra: '90px',
            },
            borderWidth: {
                DEFAULT: '1px',
                '0': '0',
                '2': '2px',
                '3': '3px',
                '4': '4px',
                '6': '6px',
                '8': '8px',
            },
            borderRadius: {
                1: '5px',
                2: '10px',
                3: '15px',
                4: '20px',
                5: '25px',
                6: '30px',
                7: '35px',
                8: '40px',
                9: '45px',
                10: '50px',
            },
            container: {
                screens: {
                    'xl': '1200px',
                    '2xl': '1540px',
                },
            },
            fontSize: {
                hero: '80px',
                title: '50px',
                xxs: '0.625rem',
                md: '1.143rem',
            },
            boxShadow: {
                'inset-1': 'inset 0 1px 0 0 #E1E1E1, inset 0 -1px 0 0 #E1E1E1, inset -1px 0 0 #E1E1E1, inset 1px 0 0 #E1E1E1, inset 0 0 0 1px #E1E1E1',
                'blue': '0px 4px 20px rgba(27, 54, 248, 0.6)',
                'error': '0px 0px 4px rgba(0, 0, 0, 0.04), 0px 4px 32px rgba(0, 0, 0, 0.16)',
            },
            skew: {
                '20': '20deg',
                '15': '15deg',
                'n15': '-15deg',
            },
        },
        colors: {
            ...colors,
            brand: {
                DEFAULT: '#877eeb',
                hover: '#6355e5'
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
        fontFamily: {
            gilroy: ['Gilroy', 'Arial', 'sans-serif'],
        },
        container: {
            center: true,
            padding: {
                DEFAULT: '1rem',
            },
        },
    },
    extend: {
        boxShadow: {
            table: '0px 0px 20px rgba(102, 117, 255, 0.06)',
            block: '0px 0px 40px rgba(22, 23, 28, 0.06)',
            lite: '0px 0px 1px rgba(0, 0, 0, 0.15)',
        },
    },
    plugins: [
        require('@tailwindcss/line-clamp'),
        // require('@tailwindcss/forms'),
    ],
    corePlugins: {
        isolation: false,
        boxDecorationBreak: false,
        fontVariantNumeric: false,
        mixBlendMode: false,
        backgroundBlendMode: false,
        hueRotate: false,
        invert: false,
        contrast: false,
        saturate: false,
        sepia: false,
        backdropHueRotate: false,
        backdropInvert: false,
        backdropContrast: false,
        backdropSaturate: false,
        backdropSepia: false,
    },
};
