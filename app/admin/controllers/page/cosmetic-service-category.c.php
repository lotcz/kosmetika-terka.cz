<?php
	require_once __DIR__ . '/../../../models/cosmetic-service-category.m.php';

	$this->renderAdminForm(
		'CosmeticServiceCategoryModel',
		[
			[
				'name' => 'cosmetic_service_category_name',
				'label' => 'Název',
				'type' => 'text'
			],
			[
				'name' => 'cosmetic_service_category_sorting_weight',
				'label' => 'Řazení',
				'type' => 'integer',
				'value' => 0
			],
			[
				'name' => 'cosmetic_service_category_is_in_offers',
				'label' => 'Zobrazit v nabídce',
				'type' => 'bool',
				'value' => 1
			],
			[
				'name' => 'cosmetic_service_category_is_in_pricelist',
				'label' => 'Zobrazit v ceníku',
				'type' => 'bool',
				'value' => 1
			],
			[
				'name' => 'cosmetic_service_category_is_in_calendar',
				'label' => 'Zobrazit v kalendáři',
				'type' => 'bool',
				'value' => 1
			]
		],
		null, //before update
		null, //after update
		null, //before delete
		null //after delete
	);
