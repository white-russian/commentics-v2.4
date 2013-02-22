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


function cmtx_add_signature ($language) { //adds signature to email files

	cmtx_write_signature("../includes/emails/" . $language . "/admin/new_ban.txt");
	cmtx_write_signature("../includes/emails/" . $language . "/admin/new_comment_approve.txt");
	cmtx_write_signature("../includes/emails/" . $language . "/admin/new_comment_okay.txt");
	cmtx_write_signature("../includes/emails/" . $language . "/admin/reset_password.txt");
	cmtx_write_signature("../includes/emails/" . $language . "/admin/new_flag.txt");
	cmtx_write_signature("../includes/emails/" . $language . "/user/subscriber_confirmation.txt");
	cmtx_write_signature("../includes/emails/" . $language . "/user/subscriber_notification.txt");

} //end of add-signature function


function cmtx_write_signature ($path) { //writes signature to email files

	global $site_name, $site_domain;

	if (is_writable($path)) {
		$file = fopen($path, "a");
		fwrite($file, $site_name . "\r\n" . "http://www." . $site_domain);
		fclose($file);
	}

} //end of write-signature function


function cmtx_write_reserved_data ($path) { //appends reserved data to word files

	global $site_domain;

	if (is_writable($path)) {
		$file = fopen($path, "a");
		fwrite($file, $site_domain);
		fclose($file);
	}

} //end of write-reserved-data function
?>