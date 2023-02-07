$(document).ready(() => {
	$(document).on('change keyup keydown', '.text-counter-input', (e) => {
		let obj = $(e.currentTarget);
		let parent = obj.parent();
		let counter = parent.find('.text-counter');
		let max = obj.attr('data-max');

		counter.text(max - obj.val().length);
		if (counter.text() == 0) {
			counter.addClass('bg-warning');
			counter.removeClass('bg-danger');
			obj.addClass('mark-warning');
			obj.removeClass('mark-danger');
		}
		else if (counter.text() < 0) {
			counter.removeClass('bg-warning');
			counter.addClass('bg-danger');
			obj.removeClass('mark-warning');
			obj.addClass('mark-danger');
		}
		else {
			counter.removeClass('bg-danger');
			counter.removeClass('bg-warning');
			obj.removeClass('mark-danger');
			obj.removeClass('mark-warning');
		}
	});

	$('.text-counter-input').trigger('change');
});