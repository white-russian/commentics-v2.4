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

if (!defined('IN_COMMENTICS')) { die('Access Denied.'); }

mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "settings` (`category`, `title`, `value`) VALUES ('comments', 'gravatar_custom', 'http://');");

$from_name = mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "settings` WHERE `title` = 'admin_new_ban_from_name'");
$from_name = mysql_fetch_assoc($from_name);
$from_name = $from_name["value"];

$from_email = mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "settings` WHERE `title` = 'admin_new_ban_from_email'");
$from_email = mysql_fetch_assoc($from_email);
$from_email = $from_email["value"];

$reply_to = mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "settings` WHERE `title` = 'admin_new_ban_reply_to'");
$reply_to = mysql_fetch_assoc($reply_to);
$reply_to = $reply_to["value"];

mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "settings` (`category`, `title`, `value`) VALUES ('email', 'admin_method_test_subject', 'Comments: Method Test');");
mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "settings` (`category`, `title`, `value`) VALUES ('email', 'admin_method_test_from_name', '$from_name');");
mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "settings` (`category`, `title`, `value`) VALUES ('email', 'admin_method_test_from_email', '$from_email');");
mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "settings` (`category`, `title`, `value`) VALUES ('email', 'admin_method_test_reply_to', '$reply_to');");

mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "settings` (`category`, `title`, `value`) VALUES ('comments', 'scroll_speed', '50');");

if (mysql_errno()) {
echo mysql_errno() . ': ' . mysql_error() . '<br />';
$error = true;
}

?>