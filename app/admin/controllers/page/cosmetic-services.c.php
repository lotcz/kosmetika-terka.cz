<?php

	$this->setPageTitle('Služby');
	$this->renderAdminTable(
		'cosmetic_service',
		[
			[
				'name' => 'cosmetic_service_category_name',
				'label' => 'Category'
			],
			[
				'name' => 'cosmetic_service_name',
				'label' => 'Name'
			],
			[
				'name' => 'cosmetic_service_price',
				'label' => 'Price'
			],
			[
				'name' => 'cosmetic_service_duration_minutes',
				'label' => 'Trvání'
			],
			[
				'name' => 'cosmetic_service_is_in_offers',
				'label' => 'Nabídka',
				'type' => 'bool'
			],
			[
				'name' => 'cosmetic_service_is_in_pricelist',
				'label' => 'Ceník',
				'type' => 'bool'
			],
			[
				'name' => 'cosmetic_service_is_in_calendar',
				'label' => 'Kalendář',
				'type' => 'bool'
			]
		],
		'viewCosmeticServices',
		['cosmetic_service_category_name', 'cosmetic_service_name'],
		'cosmetic_service_category_sorting_weight,cosmetic_service_category_name,cosmetic_service_sorting_weight,cosmetic_service_name asc',
		['cosmetic_service_name', 'cosmetic_service_category_name', 'cosmetic_service_price', 'cosmetic_service_duration_minutes']
	);
