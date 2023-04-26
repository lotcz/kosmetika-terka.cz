<div>
	<h2>Nabídka</h2>

	<?php
		$title = "";

		foreach ($offers as $offer) {
			if ($offer->get('cosmetic_service_category_name') !== $title) {
				if ($title !== "") {
					?>
						</div>
					<?php
				}

				$title = $offer->get('cosmetic_service_category_name');

				?>
					<div class="text-center">
						<h3><?=$title?></h3>
					</div>
					<div class="row">
				<?php
			}

			?>
				<div class="col-sm-6 col-lg-3">
					<div class="p-3">
						<div class="p-3">
							<img src="<?=$this->z->images->img($offer->get('cosmetic_service_image'), 'view')?>" class="rounded img-fluid">
						</div>
						<h4><?=$offer->get('cosmetic_service_name')?></h4>
						<div><?=$offer->get('cosmetic_service_description')?></div>
					</div>
				</div>
			<?php
		}

		if ($title !== "") {
			?>
				</div>
			<?php
		}
