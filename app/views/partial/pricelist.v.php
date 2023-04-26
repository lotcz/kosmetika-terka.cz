<tbody id="cenik">
	<h2>Ceník</h2>

	<?php
		$title = "";

		foreach ($pricelist as $offer) {
			if ($offer->get('cosmetic_service_category_name') !== $title) {
				if ($title !== "") {
					?>
								</tbody>
							</table>
						</div>
					<?php
				}

				$title = $offer->get('cosmetic_service_category_name');

				?>
					<div class="text-center">
						<h3><?=$title?></h3>
					</div>
					<div class="col-lg-6 mx-auto">
						<table class="table">
							<tbody>
				<?php
			}

			?>
				<tr>
					<td><?=$offer->get('cosmetic_service_name')?></td>
					<td>
						<?php
							$t = $offer->get('cosmetic_service_duration_minutes');
							if (strlen($t) > 0) {
								echo $t . " min";
							}
						?>
					</td>
					<td><?=$this->formatMoney($offer->get('cosmetic_service_price'))?></td>
				</tr>
			<?php
		}

		if ($title !== "") {
			?>
						</tbody>
					</table>
				</div>
			<?php
		}
