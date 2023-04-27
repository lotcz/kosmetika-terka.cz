<?php

	require_once __DIR__ . '/../models/cosmetic-service.m.php';

	class kosmetikaModule extends zModule {

		public function loadPricelist() {
			return $this->groupCosmeticServices(
				$pricelist = CosmeticServiceModel::select(
					$this->z->db,
					'viewCosmeticServices',
					'cosmetic_service_category_is_in_pricelist = 1 and cosmetic_service_is_in_pricelist = 1',
					'cosmetic_service_category_sorting_weight, cosmetic_service_category_name, cosmetic_service_sorting_weight, cosmetic_service_name'
				)
			);
		}

		public function loadOffers() {
			return $this->groupCosmeticServices(
				CosmeticServiceModel::select(
					$this->z->db,
					'viewCosmeticServices',
					'cosmetic_service_category_is_in_offers = 1 and cosmetic_service_is_in_offers = 1',
					'cosmetic_service_category_sorting_weight, cosmetic_service_category_name, cosmetic_service_sorting_weight, cosmetic_service_name'
				)
			);
		}

		private function groupCosmeticServices($services) {
			$result = [];
			$title = null;

			foreach ($services as $s) {
				if ($title === null || $s->get('cosmetic_service_category_name') !== $title) {
					$title = $s->get('cosmetic_service_category_name');
					$result[$title] = [];
				}
				$result[$title][] = $s;
			}

			return $result;
		}

	}
