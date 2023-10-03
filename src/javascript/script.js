/**
 * Front-end JavaScript
 *
 * The JavaScript code you place here will be processed by esbuild. The output
 * file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */
const $ = jQuery;
$(document).ready(function() {
	$('#actionButton').click(function() {
		alert('You clicked the button using jQuery!');
	})
})
