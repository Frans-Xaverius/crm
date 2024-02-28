ALTER TABLE `customer` ADD `is_admin` INT NOT NULL DEFAULT '0' AFTER `is_bot`;

-- 

ALTER TABLE `pertanyaan` ADD `deleted_at` DATETIME NULL AFTER `updated_at`;
ALTER TABLE `wa_bot` CHANGE `curr_level` `curr_level` VARCHAR(255) NOT NULL DEFAULT '0', 
	CHANGE `curr_option` `curr_option` VARCHAR(255) NOT NULL DEFAULT '0',
	CHANGE `curr_parent` `curr_parent` VARCHAR(255) NULL DEFAULT '0';