<div>
	<h2>Ceník</h2>

	<?php
		foreach ($pricelist as $title => $services) {
			?>
				<div class="text-center">
					<h3><?=$title?></h3>
				</div>
				<div class="col-lg-6 mx-auto">
					<table class="table">
						<tbody>
							<?php
								foreach ($services as $service) {
									?>
										<tr>
											<td><?=$service->get('cosmetic_service_name')?></td>
											<td>
												<?php
													$t = $service->get('cosmetic_service_duration_minutes');
													if (strlen($t) > 0) {
														echo $t . " min";
													}
												?>
											</td>
											<td><?=$this->formatMoney($service->get('cosmetic_service_price'))?></td>
										</tr>
									<?php
								}
							?>
						</tbody>
					</table>
				</div>
			<?php
		}
	?>

</div>
