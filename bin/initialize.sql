CREATE TABLE IF NOT EXISTS `persons` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(64) NOT NULL,
  `email` varchar(128) NULL,
  `phone` varchar(16) NULL,
  `role` varchar(16) NOT NULL
) ENGINE='InnoDB';

CREATE TABLE IF NOT EXISTS `emails` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `message` text NOT NULL,
  `subject` varchar(128) NOT NULL,
  `sended` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE='InnoDB';

CREATE TABLE IF NOT EXISTS `emails_to_persons` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email_id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `attempts` tinyint(2) NOT NULL DEFAULT '0',
  FOREIGN KEY (`email_id`) REFERENCES `emails` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`) ON DELETE CASCADE
) ENGINE='InnoDB';

CREATE TABLE IF NOT EXISTS `unsent_emails` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email_id` int(11) NOT NULL,
  `cron_id` varchar(36) NULL,
  FOREIGN KEY (`email_id`) REFERENCES `emails` (`id`) ON DELETE CASCADE
) ENGINE='InnoDB';
