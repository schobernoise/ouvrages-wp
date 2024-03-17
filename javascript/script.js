/**
 * Front-end JavaScript
 *
 * The JavaScript code you place here will be processed by esbuild. The output
 * file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 *
 */

var superToggle = function (element, ...classes) {
	classes.forEach((cls) => {
		element.classList.toggle(cls);
	});
};

document.addEventListener('DOMContentLoaded', function () {
	document
		.querySelector('.mobile-menu-button')
		.addEventListener('click', function () {
			document.querySelector('.mobile-menu').classList.toggle('hidden');

			superToggle(
				document.querySelector('.mobile-menu-button'),
				'text-white',
				'text-schoberDarkRed',
				'ml-24'
			);

			document
				.querySelector('.mobile-menu-button-wrapper')
				.classList.toggle('backdrop-blur-2xl');

			document.querySelector('#container').classList.toggle('pt-20');

			superToggle(
				document.querySelector('.menu-divider'),
				'bg-schoberDarkRed',
				'bg-white',
				'ml-16'
			);
		});

	document
		.querySelector('#primary-menu')
		.addEventListener('click', function () {
			document.querySelector('.mobile-menu').classList.toggle('hidden');
		});
});
