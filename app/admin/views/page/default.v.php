<ul>
	<li>
		<a href="<?=$this->url('admin/default/default/gallery/edit/' . $this->z->kosmetika->getGalleryId()) ?>">
			Upravit galerii
		</a>
	</li>
</ul>


<h2>Kalendář</h2>

<?php
	$this->z->calendar->renderCalendar('admin-calendar', true);
?>
