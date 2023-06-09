<?php

	$this->setPageTitle('Kategorie');
	$this->renderAdminTable(
		'cosmetic_service_category',
		[
			[
				'name' => 'cosmetic_service_category_sorting_weight',
				'label' => 'Řazení'
			],
			[
				'name' => 'cosmetic_service_category_name',
				'label' => 'Name'
			],
			[
				'name' => 'cosmetic_service_category_is_in_offers',
				'label' => 'Nabídka',
				'type' => 'bool'
			],
			[
				'name' => 'cosmetic_service_category_is_in_pricelist',
				'label' => 'Ceník',
				'type' => 'bool'
			],
			[
				'name' => 'cosmetic_service_category_is_in_calendar',
				'label' => 'Kalendář',
				'type' => 'bool'
			]
		],
		'cosmetic_service_category',
		[],
		'cosmetic_service_category_sorting_weight asc',
		['cosmetic_service_category_name']
	);
