<?php

	return [

		// TinyMCE configuration, will be serialized to JSON.
		'tinymce_conf' => [
			'selector' => 'textarea.wysiwyg',
			'language' => 'cs',
			'autoresize' => false,
			'resize' => true,
			'height' => 250,
			'branding' => false,
			'menubar' => false,
			'plugins' => "wordcount link lists image code",
			'toolbar' => "undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright | bullist numlist | image | link unlink | pastetext code | wordcount",
			'paste_as_text' => true,
			'image_caption' => true,
			'image_advtab' => true,
			'image_dimensions' => false,
			'typeahead_urls' => false,
			'promotion' => false,
			'style_formats' => [
				[ 'title' => 'Odstavec', 'format' => 'p' ],
				[ 'title' => 'Nadpis', 'format' => 'h2' ],
				[ 'title' => 'Nadpis 2', 'format' => 'h3' ],
				[ 'title' => 'Nadpis 3', 'format' => 'h4' ],
			]
		],

	];
