// Set the Preflight flag based on the build target.
const includePreflight = 'editor' === process.env._TW_TARGET ? false : true;

module.exports = {
	presets: [
		// Manage Tailwind Typography's configuration in a separate file.
		require('./tailwind-typography.config.js'),
	],
	content: [
		// Ensure changes to PHP files and `theme.json` trigger a rebuild.
		'./theme/**/*.php',
		'./theme/js/*.js',
	],
	theme: {
		// Extend the default Tailwind theme.
		screens: {
			xs: '320px',
			sm: '640px',
			md: '768px',
			lg: '976px',
			xl: '1400px',
			'2xl': '1920px',
		},
		extend: {
			spacing: {
				22: '88px', // Custom spacing for content margin
				minus1: '-8px',
				minus2: '-12px',
				minus3: '-16px',
				minus4: '-24px',
				minus5: '-32px',
				minus6: '-48px',
			},
			colors: {
				schoberDarkRed: '#5F021F',
				schoberBrightRed: '#9F1313',
				schoberDarkBlue: '#003145',
				schoberMidBlue: '#006773',
				schberTourquoise: '#92FFFF',
			},
			fontFamily: {
				sans: ['avenir', 'system-ui'], // Add your custom font followed by fallback fonts
			},

			zIndex: {
				'-10': '-10',
				'-20': '-20',
				'-30': '-30',
				'-40': '-40',
			},

			transitionDelay: {
				400: '400ms',
				600: '600ms',
			},
		},
	},
	corePlugins: {
		// Disable Preflight base styles in builds targeting the editor.
		preflight: includePreflight,
	},
	plugins: [
		// Add Tailwind Typography (via _tw fork).
		require('@_tw/typography'),

		// Extract colors and widths from `theme.json`.
		require('@_tw/themejson'),

		// Uncomment below to add additional first-party Tailwind plugins.
		// require('@tailwindcss/forms'),
		// require('@tailwindcss/aspect-ratio'),
		// require('@tailwindcss/container-queries'),
	],
};
