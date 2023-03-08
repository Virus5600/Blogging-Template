/**
 * Warns the user that they're leaving without saving their changes.
 * @param urlTo String value. The page they're attempting to open.
 * @param title String value. Title of the confirmation.
 * @param message String value. Message of the confirmation.
 * @param isLivewire Boolean value. Whether the value of `urlTo` is a livewire event or not
 * @param livewireComponent Object value. Required whenever `isLivewire` is `true`. This identifies what component will call the provided livewire action
 */
function confirmLeave(urlTo, title="Are you sure?", message = "You have unsave changes.", isLivewire = false, livewireComponent = null) {
	Swal.fire({
		icon: 'warning',
		html: `<h4>${title}</h4><p>${message}</p>`,
		showDenyButton: true,
		confirmButtonText: 'Yes',
		denyButtonText: 'No'
	}).then((result) => {
		if (result.isConfirmed) {
			if (isLivewire) {
				try {

					if (typeof livewireComponent == 'undefined' || livewireComponent == null)
						throw new Exception("");

					let params = urlTo.split(/,\s*/g);

					livewireComponent = livewireComponent.substr(livewireComponent.indexOf("'") + 1);
					livewireComponent = livewireComponent.substr(0, livewireComponent.lastIndexOf("'"));
					livewireComponent = window.livewire.find(livewireComponent);

					livewireComponent.call.apply(this, params);
				} catch (e) {
					if (typeof livewireComponent == 'undefined' || livewireComponent == null)
						console.warn("Livewire not installed, using default method");
					console.table(e);
					window.location.href = urlTo;
				}
			}
			else {
				window.location.href = urlTo;
			}
		}
	});
}

document.addEventListener("DOMContentLoaded", function() {
	document.addEventListener("click", function(e) {
		if (e.target.hasAttribute("data-confirm-leave")) {
			let obj = e.target;

			let url = obj.getAttribute("data-confirm-leave");
			let title = obj.getAttribute("data-confirm-leave-title");
			let message = obj.getAttribute("data-confirm-leave-message");
			let isLivewire = obj.hasAttribute("data-confirm-leave-livewire");
			let livewireComponent = obj.getAttribute("data-confirm-leave-livewire");

			title = title == null ? "Are you sure?" : title;
			message = message == null ? "You have unsave changes." : message;
			
			confirmLeave(url, title, message, isLivewire, livewireComponent);
		}
	});
});