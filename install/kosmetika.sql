DROP TABLE IF EXISTS `cosmetic_service_category`;

CREATE TABLE `cosmetic_service_category` (
  `cosmetic_service_category_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cosmetic_service_category_name` varchar(255) NOT NULL,
  `cosmetic_service_category_sorting_weight` INT not null default 0,
  `cosmetic_service_category_is_in_pricelist` BOOLEAN NOT NULL DEFAULT true,
  `cosmetic_service_category_is_in_calendar` BOOLEAN NOT NULL DEFAULT true,
  `cosmetic_service_category_is_in_offers` BOOLEAN NOT NULL DEFAULT true,

  PRIMARY KEY (`cosmetic_service_category_id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `cosmetic_service`;

CREATE TABLE `cosmetic_service` (
  `cosmetic_service_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cosmetic_service_cosmetic_service_category_id` INT UNSIGNED NOT NULL,
  `cosmetic_service_name` varchar(255) NOT NULL,
  `cosmetic_service_image` VARCHAR(255) NULL,
  `cosmetic_service_description` text NULL,
  `cosmetic_service_sorting_weight` INT not null default 0,
  `cosmetic_service_price` DECIMAL(10,2) UNSIGNED,
  `cosmetic_service_duration_minutes` INT UNSIGNED,
  `cosmetic_service_is_in_pricelist` BOOLEAN NOT NULL DEFAULT true,
  `cosmetic_service_is_in_calendar` BOOLEAN NOT NULL DEFAULT true,
  `cosmetic_service_is_in_offers` BOOLEAN NOT NULL DEFAULT true,

  PRIMARY KEY (`cosmetic_service_id`),
  CONSTRAINT `cosmetic_service_category_fk`
		FOREIGN KEY (`cosmetic_service_cosmetic_service_category_id`)
		REFERENCES `cosmetic_service_category` (`cosmetic_service_category_id`),
	UNIQUE INDEX `cosmetic_service_name_unique` (`cosmetic_service_name` ASC)
) ENGINE=InnoDB;


DROP VIEW IF EXISTS `viewCosmeticServices`;

CREATE VIEW viewCosmeticServices AS
	SELECT *
	FROM cosmetic_service s
	LEFT OUTER JOIN cosmetic_service_category c ON (c.cosmetic_service_category_id = s.cosmetic_service_cosmetic_service_category_id);

SELECT * FROM `viewCosmeticServices` WHERE cosmetic_service_category_is_in_pricelist = 1 and cosmetic_service_is_in_pricelist = 1 ORDER BY cosmetic_service_category_sorting_weight, cosmetic_service_category_name, cosmetic_service_sorting_weight, cosmetic_service_name
