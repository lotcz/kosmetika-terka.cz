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
						<a class="nav-link" href="#nabidka">Nabídka</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#galerie">Galerie</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#cenik">Ceník</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#objednani">Objednání</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#kontakt">Kontakt</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="main container-md">
		<div class="text-center intro">
			<div class="mx-auto my-5">
				<img src="<?=$this->z->images->img($intro->get('cosmetic_service_image'), 'view')?>" class="rounded img-fluid">
				<h1 class="m-3 my-5">Kosmetika <strong>Terka</strong></h1>
				<?php
					echo $intro->get('cosmetic_service_description');
				?>
				<div class="separator"></div>
			</div>
		</div>

		<div id="nabidka">
			<?php
				$this->renderPartialView('offers', ['offers' => $offers]);
			?>
		</div>

		<div id="galerie">
			<h2>Galerie</h2>
			<?php
				$this->z->gallery->renderGallery($this->z->kosmetika->getGalleryId());
			?>
		</div>

		<div id="cenik">
			<?php
				$this->renderPartialView('pricelist', ['pricelist' => $pricelist]);
			?>
		</div>

		<div id="objednani">
			<h2>Objednání</h2>
			<div class="text-center">
				<h3>Kalendář</h3>
			</div>
			<div>
				<?php
					$this->z->calendar->renderCalendar();
				?>
			</div>
		</div>

		<div id="kontakt">
			<?php
				$this->renderPartialView('contact');
			?>
		</div>
	</div>

	<footer class="py-5 text-center">
		webmaster <a href="https://zavadil.eu" target="_blank"><strong>Karel Zavadil</strong></a>, &copy; 2023
	</footer>

</main>

