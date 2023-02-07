function copyToClipboard(element) {
	let temp = $("<input>");
	$("body").append(temp);

	let textToCopy;
	if (typeof $(element).attr('data-copy-target') != 'undefined')
		textToCopy = $($(element).attr('data-copy-target')).val();
	else if (typeof $(element).attr('data-copy-text') != 'undefined')
		textToCopy = $(element).attr('data-copy-text');
	else
		textToCopy = $(element).val();

	temp.val(textToCopy).select();
	document.execCommand("copy");
	temp.remove();
	
	Swal.fire({
		title: `Text copied`,
		position: `bottom`,
		showConfirmButton: false,
		toast: true,
		timer: 3750,
		background: `#28a745`,
		customClass: {
			title: `text-white`,
			popup: `px-0`
		},
		width: 150
	});
}