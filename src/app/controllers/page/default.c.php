<?php

	$intro = new CosmeticServiceModel($this->z->db, 7);
	$this->setData('intro', $intro);

	$this->setData('offers', $this->z->kosmetika->loadOffers());

	$this->setData('pricelist', $this->z->kosmetika->loadPricelist());
