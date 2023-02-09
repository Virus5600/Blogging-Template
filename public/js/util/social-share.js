$(document).ready(() => {
	$(document).on('click', `[data-social-share]`, (e) => {
		let obj = $(e.currentTarget);
		let url = obj.attr('data-social-share');
		let type = obj.attr('data-social-type');

		if (typeof url == 'undefined') {
			e.stopPropagation();
			return false;
		}

		switch (type) {
		case `facebook`:
			url = `http://www.facebook.com/sharer.php?u=${url}`;
			break;

		case `twitter`:
			url = `http://twitter.com/share?text=${url}`;
			break;

		case `whatsapp`:
			url = `https://api.whatsapp.com/send?text=${url}`;
			break;

		default:
			break;
		}

		window.open(url,'sharer','toolbar=0,status=0,width=648,height=395');
		return true;
	});
});