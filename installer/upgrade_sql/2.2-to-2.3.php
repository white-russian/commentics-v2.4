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

mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "settings` (`category`, `title`, `value`) VALUES ('comments', 'show_permalink', '1')");

mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "subscribers` DROP COLUMN `is_active`");
mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "subscribers` DROP COLUMN `last_action`");

mysql_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "settings` WHERE `title` = 'task_enabled_delete_inactive_subscribers'");
mysql_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "settings` WHERE `title` = 'days_to_delete_inactive_subscribers'");
mysql_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "settings` WHERE `title` = 'task_enabled_reactivate_inactive_subscribers'");
mysql_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "settings` WHERE `title` = 'days_to_reactivate_inactive_subscribers'");

mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "comments` DROP COLUMN `is_flagged`");
mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "comments` ADD `reports` int(10) unsigned NOT NULL default '0'");
mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "comments` ADD `is_verified` tinyint(1) unsigned NOT NULL default '0'");

mysql_query("RENAME TABLE `" . $cmtx_mysql_table_prefix . "reports` TO `" . $cmtx_mysql_table_prefix . "reporters`");
mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "reporters` DROP COLUMN `status`");
mysql_query("ALTER TABLE `" . $cmtx_mysql_table_prefix . "reporters` DROP COLUMN `reason`");

mysql_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "settings` WHERE `title` = 'task_enabled_delete_comment_ips'");
mysql_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "settings` WHERE `title` = 'days_to_delete_comment_ips'");

mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `title` = 'task_enabled_delete_reporters' WHERE `title` = 'task_enabled_delete_reports'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `title` = 'days_to_delete_reporters' WHERE `title` = 'days_to_delete_reports'");

mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `title` = 'task_enabled_delete_subscribers' WHERE `title` = 'task_enabled_delete_unconfirmed_subscribers'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `title` = 'days_to_delete_subscribers' WHERE `title` = 'days_to_delete_unconfirmed_subscribers'");

if (mysql_errno()) {
echo mysql_errno() . ": " . mysql_error() . "<br />";
$error = true;
}

?>