<?php

	$this->setPageTitle('Kategorie');
	$this->renderAdminTable(
		'cosmetic_service_category',
		[
			[
				'name' => 'cosmetic_service_category_name',
				'label' => 'Name'
			],
			[
				'name' => 'cosmetic_service_category_is_in_pricelist',
				'label' => 'Zobrazit v ceníku',
				'type' => 'bool'
			],
			[
				'name' => 'cosmetic_service_category_is_in_calendar',
				'label' => 'Zobrazit v kalendáři',
				'type' => 'bool'
			],
			[
				'name' => 'cosmetic_service_category_is_in_offers',
				'label' => 'Zobrazit v nabídkách',
				'type' => 'bool'
			]
		],
		'cosmetic_service_category',
		['cosmetic_service_category_name', 'cosmetic_service_category_price'],
		'cosmetic_service_category_name asc',
		['cosmetic_service_category_name']
	);
