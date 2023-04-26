<?php

	$this->setPageTitle('Služby');
	$this->renderAdminTable(
		'cosmetic_service',
		[
			[
				'name' => 'cosmetic_service_name',
				'label' => 'Name'
			],
			[
				'name' => 'cosmetic_service_category_name',
				'label' => 'Category'
			],
			[
				'name' => 'cosmetic_service_price',
				'label' => 'Price'
			],
			[
				'name' => 'cosmetic_service_duration_minutes',
				'label' => 'Trvání (v minutách)'
			],
			[
				'name' => 'cosmetic_service_is_in_offers',
				'label' => 'Zobrazit v nabídce',
				'type' => 'bool'
			],
			[
				'name' => 'cosmetic_service_is_in_pricelist',
				'label' => 'Zobrazit v ceníku',
				'type' => 'bool'
			],
			[
				'name' => 'cosmetic_service_is_in_calendar',
				'label' => 'Zobrazit v kalendáři',
				'type' => 'bool'
			]
		],
		'viewCosmeticServices',
		['cosmetic_service_name'],
		'cosmetic_service_name asc',
		['cosmetic_service_name']
	);
