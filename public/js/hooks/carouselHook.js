$(document).ready(() => {
	let carousel = $('#carousel');
	let arrow = carousel.attr('data-arrow');
	let path = carousel.attr('data-sp');
	let isFlex = carousel.attr('data-flex');
		isFlex = typeof isFlex == 'undefined' ? false : isFlex;

	$.get(
		carousel.attr('data-image'), {}
	).done((response) => {
		let toAppend = ``;
		$.each(response.content, (k, v) => {
			toAppend += `<div class="d-flex h-inherit" style="background: #222 url('${`${path}/${v.image}`}') no-repeat center; background-size: cover; max-height: 25rem;">`;
			toAppend += `	<div class="backdrop-blur d-flex my-auto w-100">`;
			toAppend += `		<image src="${`${path}/${v.image}`}" alt="${v.description}" class="mx-auto w-100 w-lg-auto" style="max-height: 25rem;">`;
			toAppend += `	</div>`;
			toAppend += `</div>`;
		});

		carousel.html(toAppend);

		carousel.removeAttr('data-sp');
		carousel.removeAttr('data-image');

		carousel.slick({
			dots: false,
			infinite: true,
			autoplay: true,
			speed: 1000,
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true,
			respondTo: 'slider',
			prevArrow: `<button class='custom-slick-arrow custom-slick-prev' aria-label="Previous" type="button">Previous</button>`,
			nextArrow: `<button class='custom-slick-arrow custom-slick-next' aria-label="Next" type="button">Next</button>`
		});

		$('head').append(`<style type="text/css">.custom-slick-arrow { background: url("${arrow}") no-repeat; }</style>`);

		if (isFlex)
			carousel.find(`.slick-track`).addClass(`d-flex`);

		$('#carouselHook').remove();
	});
});