ALTER TABLE `customer` ADD `is_admin` INT NOT NULL DEFAULT '0' AFTER `is_bot`;

-- 

ALTER TABLE `pertanyaan` ADD `deleted_at` DATETIME NULL AFTER `updated_at`;
ALTER TABLE `wa_bot` CHANGE `curr_level` `curr_level` VARCHAR(255) NOT NULL DEFAULT '0', 
	CHANGE `curr_option` `curr_option` VARCHAR(255) NOT NULL DEFAULT '0',
	CHANGE `curr_parent` `curr_parent` VARCHAR(255) NULL DEFAULT '0';

ALTER TABLE `pertanyaan` CHANGE `parent_id` `parent_id` INT NOT NULL DEFAULT '0';

--

ALTER TABLE `wa_conversation` ADD `rate` VARCHAR(255) NULL AFTER `status`;
ALTER TABLE `wa_conversation` CHANGE `status` `status` INT NOT NULL DEFAULT '1';

--

ALTER TABLE `pertanyaan` ADD `file_support` LONGTEXT NULL AFTER `jawaban`;
ALTER TABLE `pertanyaan` ADD `mime_type` LONGTEXT NULL AFTER `file_support`;

--

ALTER TABLE `wa_chat` ADD `file_support` LONGTEXT NULL AFTER `content`;
ALTER TABLE `wa_chat` ADD `mime_type` LONGTEXT NULL AFTER `file_support`;

--

ALTER TABLE `wa_chat` ADD `caption` LONGTEXT NULL AFTER `mime_type`;

--

ALTER TABLE `users`
  DROP `qontak_user_id`,
  DROP `qontak_email`,
  DROP `qontak_password`,
  DROP `email`,
  DROP `email_verified_at`,
  DROP `password`,
  DROP `sso`,
  DROP `remember_token`,
  DROP `phone`;

CREATE TABLE `message_manager`.`user_role` (`id` INT NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL , PRIMARY KEY (`id`));
INSERT INTO `user_role` (`id`, `name`) VALUES (NULL, 'Super Admin'), (NULL, 'Admin'), (NULL, 'User'), (NULL, 'Guest');

ALTER TABLE `users` CHANGE `role` `role` INT NOT NULL DEFAULT '0';

--

ALTER TABLE `customer` ADD `user_id` INT NOT NULL DEFAULT '0';

-- (02/05/2024)

ALTER TABLE `users` ADD `username` TEXT NOT NULL AFTER `id`;

-- (07/05/2024)

CREATE TABLE `pabx` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `calldate` DATETIME NULL,
  `number` TEXT NULL,
  `durasi` BIGINT NULL,
  `respon` TEXT NULL,
  `catatan` LONGTEXT NULL,
  PRIMARY KEY (`id`)
);

-- (14/05/2024)

CREATE TABLE `wa_tag` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tags_id` INT NOT NULL,
  `wa_conversation_id` INT NOT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE `wa_conversation` ADD `user_id` INT NOT NULL DEFAULT '0';
ALTER TABLE `customer` DROP `user_id`;

--