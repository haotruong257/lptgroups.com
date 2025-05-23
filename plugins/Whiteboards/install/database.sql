CREATE TABLE IF NOT EXISTS `whiteboards_settings` (
  `setting_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'app',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `setting_name` (`setting_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; --#

INSERT INTO `whiteboards_settings` (`setting_name`, `setting_value`, `deleted`) VALUES ('whiteboards_item_purchase_code', 'Whiteboards-ITEM-PURCHASE-CODE', 0); --#

CREATE TABLE IF NOT EXISTS `whiteboards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `share_with_team_members` mediumtext COLLATE utf8_unicode_ci,
  `share_with_client_contacts` mediumtext COLLATE utf8_unicode_ci,
  `content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `permission` enum('viewer','editor') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'viewer',
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ; --#

