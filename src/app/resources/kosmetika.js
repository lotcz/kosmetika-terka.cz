window.document.addEventListener(
	"DOMContentLoaded",
	() => {
		const navbar = z.getById('navbar');
		const links = document.querySelectorAll('#navbar .nav-link');
		links.forEach(
			(l) => l.addEventListener(
				'click',
				() => {
					if (z.hasClass(navbar, 'show')) {
						z.removeClass(navbar, 'show');
					}
				}
			)
		);
	}
);
