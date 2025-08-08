<div class="text-center intro pt-4">
	<div class="mx-auto">
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
	<div class="text-center">
		<p>
			<?php
				if ($this->z->auth->isAuth() && !$this->z->auth->isAnonymous()) {
					$email = $this->z->auth->user->val('user_email');
					echo "Jste přihlášeni jako uživatel <strong>$email</strong>. <br/>";
					echo "<a class='btn btn-link' href='/profile'>Upravit profil</a>";
					echo "<a class='btn btn-primary btn-sm mx-2' href='/logout'>Odhlásit se</a>";
				} else {
					echo "Pro vkládání rezervací do kalendáře se musíte <a href='/login'>přihlásit</a>.";
				}
			?>
		</p>
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



