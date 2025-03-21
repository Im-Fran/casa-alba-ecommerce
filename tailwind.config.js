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
                "primary": "#BEEED5",
                "primary-content": "#2B9D66",
                "secondary": "#AFE9CD",
                "secondary-content": "#2B9D66",
                "accent": "#2B9D66",
                "accent-content": "#F3FCF7",
                "neutral": "#FCFCFC",
                "neutral-content": "#333333",
                "base-100": "#FAFAFA",
                "base-200": "#F0F0F0",
                "base-300": "#E6E6E6",
                "base-content": "#404040",
                "info": "#025FFF",
                "info-content": "#DAE7FF",
                "success": "#05c367",
                "success-content": "#f3fcf7",
                "warning": "#F58105",
                "warning-content": "#FEF4E8",
                "error": "#BC3633",
                "error-content": "#FCF3F3",
            }
        }],

    },
};
