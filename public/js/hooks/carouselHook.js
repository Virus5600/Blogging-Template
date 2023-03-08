$(document).ready(() => {
	let carousel = $('#carousel');
	let arrow = carousel.attr('data-arrow');
	let path = carousel.attr('data-sp');
	let isFlex = carousel.attr('data-flex');
		isFlex = typeof isFlex == 'undefined' ? false : isFlex;

	let nceRaw = $(`meta[name=nce]`).attr('content');
	let key = $(`meta[name=nce]`).attr('key');
	let value = $(`meta[name=nce]`).attr('value');
	let nce = "";
	if (typeof nceRaw != 'undefined' && nceRaw.length > 0) {
		for (let v of key)
			nce += String.fromCharCode(v.charCodeAt(0) - value);

		nce = ` ${nce}="${nceRaw}"`;
	}

	$.get(
		carousel.attr('data-image'), {}
	).done((response) => {
		let refStyle = `<style ${nce}>`;

		$.each(response.content, (k, v) => {
			let toAppend = ``;

			toAppend += `<div class="d-flex h-inherit carousel-image-container" id="carousel-image-container-${k}">`;
			toAppend += `	<div class="backdrop-blur d-flex my-auto w-100">`;
			toAppend += `		<image src="${`${path}/${v.image}`}" alt="${v.description}" class="mx-auto w-100 w-lg-auto carousel-image">`;
			toAppend += `	</div>`;
			toAppend += `</div>`;

			refStyle += `#carousel-image-container-${k} {`;
			refStyle += `	background: #222 url('${`${path}/${v.image}`}') no-repeat center;`;
			refStyle += `	background-size: cover;`;
			refStyle += `}`;
			refStyle += ``;

			carousel.append(toAppend);
		});

		refStyle += `</style>`;
		$($("head")[0]).append(refStyle);


		carousel.removeAttr('data-sp');
		carousel.removeAttr('data-image');

		carousel.slick({
			dots: false,
			infinite: true,
			// autoplay: true,
			speed: 1000,
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true,
			respondTo: 'slider',
			prevArrow: `<button class='custom-slick-arrow custom-slick-prev' aria-label="Previous" type="button">Previous</button>`,
			nextArrow: `<button class='custom-slick-arrow custom-slick-next' aria-label="Next" type="button">Next</button>`
		});

		$('head').append(`<style type="text/css" ${nce}>.custom-slick-arrow { background: url("${arrow}") no-repeat; }</style>`);

		if (isFlex)
			carousel.find(`.slick-track`).addClass(`d-flex`);

		$('#carouselHook').remove();
	});
});	