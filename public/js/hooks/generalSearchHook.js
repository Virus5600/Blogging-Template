$(document).on("keypress", (e) => {
	let target = $("#general-search");
	if (String.fromCharCode(e.keyCode) == target.attr('accesskey')) {
		if (!$('input, textarea').is(':focus')) {
			if (!target.is(':focus'))
				e.preventDefault();
			target.focus();
		}
	}
});

$('#general-search').on('focusin focusout', (e) => {
	let obj = $(e.currentTarget);

	if (e.type == 'focusin')
		obj.attr('placeholder', 'Search...');
	else if (e.type == 'focusout')
		obj.attr('placeholder', 'Press / to search');
});

$('#general-search').on('submit keypress', (e) => {
	if (e.keyCode == 13) {
		e.preventDefault();

		let parent = $(e.target).parent();
		let path = parent.attr('action');
		let content = $('#content').get();

		$.post(
			path, parent.serialize()
		).done((response) => {
			console.log(response);
			$('#content').html(response.content);
		});
	}
});