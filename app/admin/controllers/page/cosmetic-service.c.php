<?php
	require_once __DIR__ . '/../../../models/cosmetic-service.m.php';
	require_once __DIR__ . '/../../../models/cosmetic-service-category.m.php';

	$this->z->enableModule('tinymce');

	$this->renderAdminForm(
		'CosmeticServiceModel',
		[
			[
				'name' => 'cosmetic_service_cosmetic_service_category_id',
				'label' => 'Category',
				'type' => 'select',
				'select_table' => 'cosmetic_service_category',
				'select_data' => CosmeticServiceCategoryModel::all($this->z->db),
				'select_id_field' => 'cosmetic_service_category_id',
				'select_label_field' => 'cosmetic_service_category_name'
			],
			[
				'name' => 'cosmetic_service_name',
				'label' => 'Název',
				'type' => 'text'
			],
			[
				'name' => 'cosmetic_service_image',
				'label' => 'Obrázek',
				'type' => 'image',
				'image_size' => 'thumb'
			],
			[
				'name' => 'cosmetic_service_description',
				'label' => 'Popis',
				'type' => 'tinymce'
			],
			[
				'name' => 'cosmetic_service_price',
				'label' => 'Price',
				'type' => 'text',
				'validations' => [['type' => 'price']],
				'value' => 0
			],
			[
				'name' => 'cosmetic_service_duration_minutes',
				'label' => 'Průměrná doba trvání (v minutách)',
				'type' => 'integer'
			],
			[
				'name' => 'cosmetic_service_sorting_weight',
				'label' => 'Řazení',
				'type' => 'integer',
				'value' => 0
			],
			[
				'name' => 'cosmetic_service_is_in_offers',
				'label' => 'Zobrazit v nabídce',
				'type' => 'bool',
				'value' => 1
			],
			[
				'name' => 'cosmetic_service_is_in_pricelist',
				'label' => 'Zobrazit v ceníku',
				'type' => 'bool',
				'value' => 1
			],
			[
				'name' => 'cosmetic_service_is_in_calendar',
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
