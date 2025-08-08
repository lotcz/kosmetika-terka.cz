window.document.addEventListener(
	"DOMContentLoaded",
	() => {
		const toggler = document.querySelector('.navbar-toggler');
		const links = document.querySelectorAll('#navbar .nav-link');
		links.forEach((l) => l.addEventListener('click', () => toggler.click()));
	}
);
