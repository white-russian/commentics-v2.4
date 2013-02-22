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


function cmtx_get_time_zone() { //get time zone

	global $mysql_table_prefix;
	
	$time_zone_query = mysql_query("SELECT * FROM `" . $mysql_table_prefix . "settings` WHERE `title` = 'time_zone'");
	$time_zone_result = mysql_fetch_assoc($time_zone_query);
	$time_zone = $time_zone_result["value"];

	return $time_zone;

} //end of get-time-zone function


function cmtx_get_version() { //get version

	global $mysql_table_prefix;

	$version_query = mysql_query("SELECT * FROM `" . $mysql_table_prefix . "version` ORDER BY `dated` DESC LIMIT 1");
	$version_result = mysql_fetch_assoc($version_query);
	$version = $version_result["version"];

	return $version;

} //end of get-version function


function cmtx_get_admin_folder() { //get admin folder

	global $mysql_table_prefix;

	$admin_folder_query = mysql_query("SELECT * FROM `" . $mysql_table_prefix . "settings` WHERE `title` = 'admin_folder'");
	$admin_folder_result = mysql_fetch_assoc($admin_folder_query);
	$admin_folder = $admin_folder_result["value"];

    return $admin_folder;

} //end of get-admin-folder function

?>