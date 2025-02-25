import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		 './storage/framework/views/*.php',
		 './resources/**/*.blade.php',
		 './resources/**/*.js',
		 './resources/**/*.vue',
		 "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
        './vendor/masmerise/livewire-toaster/resources/views/*.blade.php',
        './vendor/usernotnull/tall-toasts/config/**/*.php',
        './vendor/usernotnull/tall-toasts/resources/views/**/*.blade.php',
	],
    theme: {
        extend: {
            colors: {
                primary: '#2B9D66',
                secondary: '#AFE9CD',
                'secondary-opaque': '#496E5D'
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    safelist: [
        'max-w-[54rem]',
        'w-[54rem]',
    ],

    plugins: [
		require("@tailwindcss/typography"),
		require("daisyui"),
	],

    daisyui: {
        themes: [{
            casaalba: {
                ...require("daisyui/src/theming/themes")["light"],
                primary: '#2B9D66',
                'primary-content': '#d4ffe8',
                secondary: '#AFE9CD',
                'secondary-content': '#2B9D66',
            }
        }],

    },
};
