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
                ...require("daisyui/src/theming/themes")["winter"],
                "primary": "#2B9D66",
                "primary-content": "#E3F7EE",
                "secondary": "#AFE9CD",
                "secondary-content": "#2B9D66",
                "accent": "#05C367",
                "accent-content": "#F3FCF7",
                "neutral": "#FCFCFC",
                "neutral-content": "#333333",
                "base-100": "#FAFAFA",
                "base-200": "#E6E6E6",
                "base-300": "#D3D3D3",
                "base-content": "#404040",
                "info": "#025FFF",
                "info-content": "#DAE7FF",
                "success": "#05c367",
                "success-content": "#f3fcf7",
                "warning": "#F58105",
                "warning-content": "#FEF4E8",
                "error": "#BC3633",
                "error-content": "#FCF3F3F3",
            }
        }],

    },
};
