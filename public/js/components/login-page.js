$(document).ready(() => {
	$('[login-link-component]').on('click', (e) => {
		let obj = $(e.currentTarget);
		let counter = obj.attr('data-count');

		if (typeof counter == 'undefined') {
			obj.attr('data-count', 1);
		}
		else {
			if (counter < (parseInt(obj.attr('data-login-clicks')) - 1))
				obj.attr('data-count', parseInt(counter) + 1);
			else
				window.location = obj.attr('data-login-url');
		}
	});
});