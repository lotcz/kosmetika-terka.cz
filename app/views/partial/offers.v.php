<div>
	<h2>Nabídka</h2>

	<?php
		foreach ($offers as $title => $services) {
			?>
				<div class="text-center">
					<h3><?=$title?></h3>
				</div>
				<div class="row">
					<?php
						foreach ($services as $service) {
							?>
								<div class="col-lg-6">
									<div class="p-lg-3">
										<div class="p-2 p-lg-3 text-center">
											<img src="<?=$this->z->images->img($service->get('cosmetic_service_image'), 'wide')?>" class="rounded img-fluid">
										</div>
										<h4><?=$service->get('cosmetic_service_name')?></h4>
										<div><?=$service->get('cosmetic_service_description')?></div>
									</div>
								</div>
							<?php
						}
					?>
				</div>
			<?php
		}
	?>

</div>
