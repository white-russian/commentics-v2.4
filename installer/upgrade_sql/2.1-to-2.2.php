<?php
/*
Copyright © 2009-2013 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/

if (!defined("IN_COMMENTICS")) { die("Access Denied."); }

mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "settings` (`category`, `title`, `value`) VALUES ('system', 'lower_pages', '0');");

mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "admins` ADD `login_attempts` tinyint(1) unsigned NOT NULL default '0'");
mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "admins` ADD `resets` tinyint(1) unsigned NOT NULL default '0'");

mysql_query("CREATE TABLE IF NOT EXISTS `" . $cmtx_mysql_table_prefix . "attempts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ip_address` varchar(250) NOT NULL default '',
  `amount` int(10) unsigned NOT NULL default '0',
  `dated` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;");

mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "access` CHANGE `ip_address` `ip_address` varchar(250) NOT NULL default ''");
mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "admins` CHANGE `ip_address` `ip_address` varchar(250) NOT NULL default ''");
mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "bans` CHANGE `ip_address` `ip_address` varchar(250) NOT NULL default ''");
mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "comments` CHANGE `ip_address` `ip_address` varchar(250) NOT NULL default ''");
mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "reports` CHANGE `ip_address` `ip_address` varchar(250) NOT NULL default ''");
mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "viewers` CHANGE `ip_address` `ip_address` varchar(250) NOT NULL default ''");
mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "voters` CHANGE `ip_address` `ip_address` varchar(250) NOT NULL default ''");

mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "admins` ADD `restrict_pages` tinyint(1) unsigned NOT NULL default '0'");
mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "admins` ADD `allowed_pages` text NOT NULL");

mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `title` = 'notice_manage_comments' WHERE `title` = 'notice_limit_comments'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `title` = 'notice_layout_form_sizes_maximums' WHERE `title` = 'notice_field_size_css'");
mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "settings` (`category`, `title`, `value`) VALUES ('notice', 'notice_layout_form_questions', '1');");
mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "settings` (`category`, `title`, `value`) VALUES ('notice', 'notice_settings_admin_detection', '1');");

mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "settings` (`category`, `title`, `value`) VALUES ('security', 'check_honeypot', '1');");
mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "settings` (`category`, `title`, `value`) VALUES ('security', 'check_time', '1');");

mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "settings` (`category`, `title`, `value`) VALUES ('order', 'split_screen', '0');");

mysql_query("ALTER TABLE `". $cmtx_mysql_table_prefix . "viewers` ADD `id` int(10) unsigned NOT NULL primary key auto_increment");

if (mysql_errno()) {
echo mysql_errno() . ": " . mysql_error() . "<br />";
$error = true;
}

?>