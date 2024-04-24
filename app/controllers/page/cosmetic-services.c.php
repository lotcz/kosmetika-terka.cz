<?php

	$categories = $this->z->kosmetika->loadCalendarServices();
	$json = [];
	foreach ($categories as $cat_name => $services) {
		$json[$cat_name] = [];
		foreach ($services as $service) {
    		$json[$cat_name][] = $service->getJson();
    	}
	}
	$this->setData('json', $json);
