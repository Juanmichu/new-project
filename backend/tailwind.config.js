/** @type {import('tailwindcss').Config} */
export default {
    content: [
		"./resources/**/*.blade.php",
		"./resources/**/*.js",
		"./resources/**/*.vue",
		"./app/**/*.php",
    ],
    theme: {
        extend: {
            fontFamily: {
				sans: ['Instrument Sans', 'sans-serif'],
			},
			colors: {
				primary: {
					50: '#eff6ff',
					500: '#3b82f6',
					600: '#2563eb',
					700: '#1d4ed8',
            },
        },
    },
	},
	plugins: [],
}
