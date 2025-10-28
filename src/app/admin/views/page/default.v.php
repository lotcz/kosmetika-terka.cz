<ul>
	<li>
		<a href="<?=$this->url('admin/cosmetic-service-categories') ?>">
			Kategorie
		</a>
	</li>
	<li>
		<a href="<?=$this->url('admin/cosmetic-services') ?>">
			Služby
		</a>
	</li>
	<li>
		<a href="<?=$this->url('admin/users')?>">
			Zákazníci
		</a>
	</li>
	<li>
		<a href="<?=$this->url('admin/default/default/gallery/edit/' . $this->z->kosmetika->getGalleryId()) ?>">
			Galerie
		</a>
	</li>
</ul>

<h2>Kalendář</h2>

<?php
	$this->z->calendar->renderCalendar('admin-calendar', true);
?>
