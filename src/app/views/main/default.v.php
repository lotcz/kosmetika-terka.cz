<main data-bs-spy="scroll" data-bs-target="#navbar" data-bs-smooth-scroll="true" class="bg-white" tabindex="0">

	<nav class="navbar navbar-expand-sm bg-white border-bottom sticky-top">
		<div class="container-md">
			<a class="navbar-brand" href="/">Kosmetika <strong>Terka</strong></a>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Otevřít menu">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div id="navbar" class="collapse navbar-collapse">
				<ul class="navbar-nav me-auto my-2 my-lg-0" style="--bs-scroll-height: 100px;">
					<li class="nav-item">
						<a class="nav-link" href="/#nabidka">Nabídka</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/#galerie">Galerie</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/#cenik">Ceník</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/#objednani">Objednání</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/#kontakt">Kontakt</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="main container-md py-3">
		<?php
			$this->renderMessages();
			$this->renderPageView();
		?>
	</div>

</main>

<footer class="py-5 text-center">
	Webmaster <a href="https://zavadil.eu" target="_blank"><strong>Karel Zavadil</strong></a>, &copy; <?=date('Y')?>
</footer>
