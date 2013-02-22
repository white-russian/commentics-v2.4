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

mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."comments` ADD reply text NOT NULL");

mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."pages` ADD custom_id varchar(250) NOT NULL default ''");

mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."banned` ADD unban tinyint(1) unsigned NOT NULL default '0'");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','reserved_emails_enabled','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','reserved_emails_action','reject');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','reserved_websites_enabled','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','reserved_websites_action','reject');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','comment_parser_convert_links','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','comment_parser_convert_emails','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','comment_parser_new_window','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','comment_parser_nofollow','1');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','website_new_window','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','website_nofollow','1');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('commentics','powered_by_new_window','1');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('security','check_referrer','1');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('comments','anchor_text_pagination','comments');");

mysql_query("ALTER $mysql_database DEFAULT CHARACTER SET utf8;");

mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."banned` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."comments` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."last_login` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."pages` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."questions` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."settings` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."subscribers` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."version` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."viewers` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;");

if (mysql_errno()) {
echo mysql_errno() . ": " . mysql_error() . "<br />";
$error = true;
}

?>