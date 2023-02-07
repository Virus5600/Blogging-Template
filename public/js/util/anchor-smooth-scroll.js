document.addEventListener('click', (event) => {
	let anchor = event.currentTarget.getElementsByTagName('a');

	if (anchor.className == 'anchor') {
		if (Array.from(anchor.querySelectorAll('.not-smooth')).includes(event.target) || !anchor.contains(event.target))
			return;

		let targetLocation = anchor.getAttribute('href').trim();

		if (!targetLocation.startsWith('#'))
			return;

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
			window.history.pushState({}, '', targetLocation);
			document.querySelector(targetLocation).scrollIntoView({
				behavior: 'smooth'
			});
		}
	}
});