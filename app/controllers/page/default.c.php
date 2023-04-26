<?php

	require_once __DIR__ . '/../../models/cosmetic-service.m.php';

	$intro = new CosmeticServiceModel($this->z->db, 7);
	$this->setData('intro', $intro);

	$offers = CosmeticServiceModel::select(
		$this->z->db,
		'viewCosmeticServices',
		'cosmetic_service_category_is_in_offers = 1 and cosmetic_service_is_in_offers = 1',
		'cosmetic_service_category_sorting_weight, cosmetic_service_category_name, cosmetic_service_sorting_weight, cosmetic_service_name'
	);
	$this->setData('offers', $offers);

	$pricelist = CosmeticServiceModel::select(
		$this->z->db,
		'viewCosmeticServices',
		'cosmetic_service_category_is_in_pricelist = 1 and cosmetic_service_is_in_pricelist = 1',
		'cosmetic_service_category_sorting_weight, cosmetic_service_category_name, cosmetic_service_sorting_weight, cosmetic_service_name'
	);
	$this->setData('pricelist', $pricelist);
