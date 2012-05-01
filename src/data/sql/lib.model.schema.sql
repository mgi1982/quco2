
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- site
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `site`;

CREATE TABLE `site`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`url` VARCHAR(255) NOT NULL,
	`description` TEXT NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `site_U_1` (`url`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- metric
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `metric`;

CREATE TABLE `metric`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`description` TEXT NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- ecriteria
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `ecriteria`;

CREATE TABLE `ecriteria`
(
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`metric_id` INTEGER NOT NULL,
	`description` TEXT NOT NULL,
	`form_field` TEXT NOT NULL,
	PRIMARY KEY (`id`,`metric_id`),
	INDEX `ecriteria_FI_1` (`metric_id`),
	CONSTRAINT `ecriteria_FK_1`
		FOREIGN KEY (`metric_id`)
		REFERENCES `metric` (`id`)
		ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- evaluation
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `evaluation`;

CREATE TABLE `evaluation`
(
	`site_id` INTEGER NOT NULL,
	`ecriteria_id` INTEGER NOT NULL,
	`metric_id` INTEGER NOT NULL,
	`value` INTEGER,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`site_id`,`ecriteria_id`,`metric_id`),
	INDEX `evaluation_FI_2` (`ecriteria_id`),
	INDEX `evaluation_FI_3` (`metric_id`),
	CONSTRAINT `evaluation_FK_1`
		FOREIGN KEY (`site_id`)
		REFERENCES `site` (`id`)
		ON DELETE CASCADE,
	CONSTRAINT `evaluation_FK_2`
		FOREIGN KEY (`ecriteria_id`)
		REFERENCES `ecriteria` (`id`)
		ON DELETE CASCADE,
	CONSTRAINT `evaluation_FK_3`
		FOREIGN KEY (`metric_id`)
		REFERENCES `metric` (`id`)
		ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
