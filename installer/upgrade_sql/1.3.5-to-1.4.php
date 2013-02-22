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

$session_key = cmtx_get_random_key(20);

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','detect_link_in_name_enabled','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','link_in_name_action','reject');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','detect_link_in_town_enabled','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','link_in_town_action','ban');");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title='detect_link_in_comment_enabled' WHERE title = 'approve_links'");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','link_in_comment_action','approve');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('social','enabled_social_linkedin','1');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','check_repeats_enabled','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','check_repeats_action','reject');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','reserved_towns_enabled','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','reserved_towns_action','reject');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','dummy_towns_enabled','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','dummy_towns_action','reject');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','banned_towns_enabled','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','banned_towns_action','ban');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('security','session_key','$session_key');");

mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."admins` DROP COLUMN default_name;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."admins` DROP COLUMN default_email;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."admins` DROP COLUMN default_website;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."admins` DROP COLUMN default_town;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."admins` DROP COLUMN default_country;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."admins` DROP COLUMN default_rating;");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."admins` DROP COLUMN default_comment;");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','form_cookie','1');");

$from_name = mysql_query("SELECT * FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'admin_new_ban_from_name'");
$from_name = mysql_fetch_assoc($from_name);
$from_name = $from_name["value"];

$from_email = mysql_query("SELECT * FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'admin_new_ban_from_email'");
$from_email = mysql_fetch_assoc($from_email);
$from_email = $from_email["value"];

$reply_to = mysql_query("SELECT * FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'admin_new_ban_reply_to'");
$reply_to = mysql_fetch_assoc($reply_to);
$reply_to = $reply_to["value"];

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('email','admin_reset_password_subject','Comments: Password Reset');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('email','admin_reset_password_from_name','$from_name');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('email','admin_reset_password_from_email','$from_email');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('email','admin_reset_password_reply_to','$reply_to');");

mysql_query("CREATE TABLE IF NOT EXISTS `".$cmtx_mysql_table_prefix."access` (
  id int(10) unsigned NOT NULL auto_increment,
  admin_id int(10) unsigned NOT NULL default '1',
  username varchar(250) NOT NULL default '',
  ip_address varchar(39) NOT NULL default '',
  page varchar(250) NOT NULL default '',
  dated datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;");

if (mysql_errno()) {
echo mysql_errno() . ": " . mysql_error() . "<br />";
$error = true;
}

?>