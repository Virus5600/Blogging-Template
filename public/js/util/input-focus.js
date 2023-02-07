// INIT
var __inputFocus = [];
$(document).ready(() => {
	__inputFocus = $(`[data-input-focus]`);

	let list = {};

	__inputFocus.each((k, v) => {
		let accessKey = $(v).attr('accesskey');

		if (typeof accessKey == 'undefined')
			accessKey = $(v).attr('data-input-focus');

		if (`${accessKey}` in list)
			list[`${accessKey}`].push(v);
		else
			list[`${accessKey}`] = [v];
	});

	for (let i in list) {
		if (list[`${i}`].length > 1) {
			console.warn(`There are multiple instances of input fields that uses "${i}" as their accesskey. This may cause unexpected behavior.\n`, list[`${i}`]);
		}
	}
});

// KEYPRESS
$(document).on("keypress keydown", (e) => {
	let key = String.fromCharCode(e.keyCode);
	let target = $(`[data-input-focus="${key}"], [accesskey="${key}"]`);
	let accessKey = target.attr('accesskey');

	// Default values
	{
		if (typeof accessKey == 'undefined')
			accessKey = target.attr('data-input-focus');
	}

	if (String.fromCharCode(e.keyCode) == accessKey) {
		if (!$('input, textarea').is(':focus')) {
			if (!target.is(':focus'))
				e.preventDefault();
			target.focus();
		}
	}
});

// FOCUS EVENT
$(document).on('focusin focusout', `[data-input-focus]`, (e) => {
	let target = $(e.currentTarget);
	let accessKey = target.attr('accesskey');
	let placeholder = target.attr('data-input-focused-placeholder');

	// Default values
	{
		if (typeof accessKey == 'undefined')
			accessKey = target.attr('data-input-focus');

		if (typeof placeholder == 'undefined')
			placeholder = "Search...";
	}

	if (e.type == 'focusin')
		target.attr('placeholder', `${placeholder}`);
	else if (e.type == 'focusout')
		target.attr('placeholder', `Press ${accessKey} to search`);
});

// SUBMIT
$(document).on('submit keypress', `[data-input-focus]`, (e) => {

});