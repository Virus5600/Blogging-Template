try {
	// jQuery
	window.$ = window.jQuery = window.jquery = require('jquery');

	// popper.js
	window.Popper = require('popper.js');

	// Bootstrap 4
	require('bootstrap/dist/js/bootstrap.bundle.min')
	require('bootstrap-select/dist/js/bootstrap-select.min')

	// Sweetalert 2
	window.Swal = require('sweetalert2/dist/sweetalert2.all.min');

	// Slick Carousel
	window.slick = require('slick-carousel/slick/slick.min');

	// Fontawesome 6
	require('@fortawesome/fontawesome-free');

	// Summernote
	require('summernote/dist/summernote-lite.min.js');
} catch (e) {
	console.error(e);
}