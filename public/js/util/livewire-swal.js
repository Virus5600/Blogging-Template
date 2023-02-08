window.addEventListener('flash_error', (e) => {
	let flash = e.detail;
	let options = {
		title: `${flash.flash_error}`,
		position: `top`,
		showConfirmButton: false,
		toast: true,
		timer: 10000,
		background: `#dc3545`,
		customClass: {
			title: `text-white`,
			content: `text-white`,
			popup: `px-3`
		},
	}
	
	Swal.fire(__setLivewireSwalOptions(options, flash));
});

window.addEventListener('flash_info', (e) => {
	let flash = e.detail;
	let options = {
		title: `${flash.flash_info}`,
		position: `top`,
		showConfirmButton: false,
		toast: true,
		timer: 10000,
		background: `#17a2b8`,
		customClass: {
			title: `text-white`,
			content: `text-white`,
			popup: `px-3`
		},
	}

	Swal.fire(__setLivewireSwalOptions(options, flash));
});

window.addEventListener('flash_success', (e) => {
	let flash = e.detail;
	let options = {
		title: `${flash.flash_success}`,
		position: `top`,
		showConfirmButton: false,
		toast: true,
		timer: 10000,
		background: `#28a745`,
		customClass: {
			title: `text-white`,
			content: `text-white`,
			popup: `px-3`
		},
	}

	Swal.fire(__setLivewireSwalOptions(options, flash));
});

const __setLivewireSwalOptions = (options, flash) => {
	if (flash.has_icon != undefined)
		options["icon"] = `error`;

	if (flash.message != undefined)
		options["html"] = `${flash.message}`;

	if (flash.position != undefined)
	 	options["position"] = flash.position;

	if (flash.is_toast != undefined)
		options["is_toast"] = flash.is_toast;
	
	if (flash.has_timer != undefined)
		if (flash.has_timer)
			options['timer'] = flash.duration != undefined ? flash.duration : 10000;
		else
			delete options['duration'];

	return options;
}