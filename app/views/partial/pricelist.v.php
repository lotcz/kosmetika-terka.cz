<div class="row">
	<h2>Ceník</h2>

	<?php
		foreach ($pricelist as $title => $services) {
			?>
				<div class="text-center">
					<h3><?=$title?></h3>
				</div>
				<div class="col col-lg-8 mx-auto">
					<table class="table">
						<tbody>
							<?php
								foreach ($services as $service) {
									?>
										<tr>
											<td><?=$service->get('cosmetic_service_name')?></td>
											<td class="text-end">
												<?php
													$t = $service->get('cosmetic_service_duration_minutes');
													if ($t !== null && $t > 0) {
														echo $t . "&nbsp;min";
													}
												?>
											</td>
											<td class="text-end"><?=$this->formatMoney($service->get('cosmetic_service_price'))?></td>
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
