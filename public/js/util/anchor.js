document.addEventListener('click', (event) => {
	let anchor = event.currentTarget.querySelector('.anchor, [data-target-location]');

	if (anchor.className == 'anchor' || typeof anchor.dataset.targetLocation != 'undefined') {
		if (Array.from(anchor.querySelectorAll('.not-anchor, .not-anchor *')).includes(event.target) || !anchor.contains(event.target))
			return;

		let targetLocation = anchor.dataset.targetLocation;
		if (targetLocation.startsWith('callback:')) {
			let fn = targetLocation.substr(targetLocation.indexOf(':') + 1, targetLocation.indexOf('(') - targetLocation.indexOf(':') - 1);
			let fnparam = targetLocation
				.substr(targetLocation.indexOf('(') + 1, targetLocation.indexOf(')') - targetLocation.indexOf('(') - 1)
				.trim()
				.split(/,(?=(?:(?:[^"']*["']){2})*[^"']*$)/g)
				.filter((i) => {return i != '';});

			for (let i = 0; i < fnparam.length; i++) {
				fnparam[i] = fnparam[i].trim();
				fnparam[i] = fnparam[i].substring(1, fnparam[i].length-1);
			}

			window[fn].apply(null, fnparam);
		}
		else {
			window.location = targetLocation;
		}
	}
});