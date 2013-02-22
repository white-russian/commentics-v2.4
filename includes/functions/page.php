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


function cmtx_sanitize ($value, $stage_one, $stage_two) { //sanitizes data

	$value = trim($value); //strip any space from beginning and end of string
	
	$value = preg_replace('/  */', ' ', $value); //replace multiple spaces with one space

	if ($stage_one) {
		$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); //convert special characters, including quotes, to HTML entities
	}

	if ($stage_two) {
		$value = mysql_real_escape_string($value); //escape any special characters for database
	}
		
	return $value; //return sanitized string
	
} //end of sanitize function


function cmtx_encode ($value) { //encode text

	$value = htmlspecialchars($value, ENT_QUOTES);

	return $value;

} //end of encode function


function cmtx_decode ($value) { //decode text

	$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');

	return $value;

} //end of decode function


function cmtx_url_encode ($value) { //encode URL

	$value = cmtx_url_encode_spaces($value);
	$value = cmtx_encode($value);

	return $value;

} //end of url-encode function


function cmtx_url_decode ($value) { //decode URL

	$value = cmtx_url_decode_spaces($value);
	$value = cmtx_decode($value);

	return $value;

} //end of url-decode function


function cmtx_url_encode_spaces ($value) { //encode URL spaces

	$value = str_ireplace(" ", "%20", $value);

	return $value;

} //end of url-encode-spaces function


function cmtx_url_decode_spaces ($value) { //decode URL spaces

	$value = str_ireplace("%20", " ", $value);

	return $value;

} //end of url-decode-spaces function


function cmtx_define ($value) { //prepare define string for output

	$value = cmtx_sanitize($value, true, false); //encode string

	return $value; //return prepared string

} //end of define function


function cmtx_strip_slashes ($value) { //strip slashes

	if (is_array($value)) {
		$value = array_map('cmtx_strip_slashes', $value);
	} else if (is_object($value)) {
		$vars = get_object_vars($value);
		foreach ($vars as $key => $data) {
			$value->{$key} = cmtx_strip_slashes($data);
		}
	} else {
		$value = stripslashes($value);
	}

	return $value;

} //end of strip-slashes function


function cmtx_validate_page_id() { //validate page ID

	global $cmtx_page_id, $cmtx_reference, $cmtx_parameters, $cmtx_mysql_table_prefix, $cmtx_settings; //globalise variables

	if (!isset($cmtx_page_id) || empty($cmtx_page_id)) { //if no page ID

		?><span class="cmtx_page_id_alert"><?php echo CMTX_ALERT_MESSAGE_NO_PAGE_ID;?></span><?php
		die();

	} else if ($cmtx_page_id == "cmtx_system_page") { //if a system page

		?><span class="cmtx_page_id_alert"><?php echo CMTX_ALERT_MESSAGE_INVALID_PAGE_ID;?></span><?php
		die();

	} else if (cmtx_strlen($cmtx_page_id) < 250) { //if page ID validates

		//get URL
		$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://" . strtolower($_SERVER['SERVER_NAME']) . $_SERVER['REQUEST_URI'];
		$url = cmtx_url_decode($url);
		if ($cmtx_settings->lower_pages) {
			$url = strtolower($url);
		}

		//remove URL parameters if configured
		if (isset($cmtx_parameters)) {
			if (empty($cmtx_parameters) || $cmtx_parameters == "none") {
				$url = strtok($url, "?");
			} else {
				$queries = explode(",", $cmtx_parameters);
				$query_string = "";
				foreach ($queries as $query) {
					if (isset($_GET[$query])) { $query_string .= $query . "=" . $_GET[$query] . "&"; } else { die(); }
				}
				if (preg_match('/[&$]/i', $query_string)) { //if query ends in &
					$query_string = substr($query_string, 0, -1); //remove &
				}
				$url = strtok($url, "?");
				$url .= "?" . $query_string;
			}
		}

		//ensure reference is set
		if (!isset($cmtx_reference)) {
			$cmtx_reference = "";
		}

		//get page title
		if (stristr($cmtx_page_id, "cmtx_title") || stristr($cmtx_reference, "cmtx_title")) {
			if (cmtx_get_ip_address() == "127.0.0.1") { //if on localhost
				$path = $_SERVER['SCRIPT_FILENAME'];
			} else {
				$path = cmtx_url_encode($url);
			}
			if ((bool)ini_get('allow_url_fopen')) {
				$file = file_get_contents($path);
			} else if (extension_loaded('curl') && cmtx_get_ip_address() != "127.0.0.1") { //if cURL is available and not on localhost
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)");
				curl_setopt($ch, CURLOPT_URL, $path);
				$file = curl_exec($ch);
				curl_close($ch);
			}
			if (isset($file)) {
				if (preg_match("/<title>(.+)<\/title>/i", $file, $match)) {
					$cmtx_page_id = str_ireplace("cmtx_title", $match[1], $cmtx_page_id);
					$cmtx_reference = str_ireplace("cmtx_title", $match[1], $cmtx_reference);
				} else {
					$cmtx_page_id = str_ireplace("cmtx_title", "Title not found", $cmtx_page_id);
					$cmtx_reference = str_ireplace("cmtx_title", "Title not found", $cmtx_reference);
				}
			} else {
				$cmtx_page_id = str_ireplace("cmtx_title", "Server incapable", $cmtx_page_id);
				$cmtx_reference = str_ireplace("cmtx_title", "Server incapable", $cmtx_reference);
			}
		}

		//get page filename
		if (stristr($cmtx_page_id, "cmtx_filename") || stristr($cmtx_reference, "cmtx_filename")) {
			if (isset($_SERVER['SCRIPT_NAME'])) {
				$cmtx_page_id = str_ireplace("cmtx_filename", $_SERVER['SCRIPT_NAME'], $cmtx_page_id);
				$cmtx_reference = str_ireplace("cmtx_filename", basename($_SERVER['SCRIPT_NAME']), $cmtx_reference);
			} else {
				$cmtx_page_id = str_ireplace("cmtx_filename", "Server incapable", $cmtx_page_id);
				$cmtx_reference = str_ireplace("cmtx_filename", "Server incapable", $cmtx_reference);
			}
		}

		//set page ID as reference
		if (stristr($cmtx_page_id, "cmtx_reference")) {
			$cmtx_page_id = str_ireplace("cmtx_reference", $cmtx_reference, $cmtx_page_id);
		}

		//set reference as page ID
		if (stristr($cmtx_reference, "cmtx_page_id")) {
			$cmtx_reference = str_ireplace("cmtx_page_id", $cmtx_page_id, $cmtx_reference);
		}

		//set reference as URL
		if (stristr($cmtx_reference, "cmtx_url")) {
			$cmtx_reference = str_ireplace("cmtx_url", $cmtx_url, $cmtx_reference);
		}

		//set page ID as URL
		if (stristr($cmtx_page_id, "cmtx_url")) {
			$cmtx_temp = $url;
			$cmtx_temp = str_ireplace("www.", "", $cmtx_temp); //remove 'www.' if there
			$cmtx_temp = str_ireplace("index.php", "", $cmtx_temp); //remove 'index.php' if there
			$cmtx_temp = str_ireplace("index.htm", "", $cmtx_temp); //remove 'index.htm' if there
			$cmtx_temp = str_ireplace("index.html", "", $cmtx_temp); //remove 'index.html' if there
			$cmtx_temp = str_ireplace("index.shtml", "", $cmtx_temp); //remove 'index.shtml' if there
			$cmtx_temp = str_ireplace("https://", "http://", $cmtx_temp); //remove SSL if there
			$cmtx_temp = preg_replace("/&cmtx_page=[0-9]*/", "", $cmtx_temp); //remove cmtx_page=x if there (1)
			$cmtx_temp = preg_replace("/cmtx_page=[0-9]*&/", "", $cmtx_temp); //remove cmtx_page=x if there (2)
			$cmtx_temp = preg_replace("/cmtx_page=[0-9]*/", "", $cmtx_temp); //remove cmtx_page=x if there (3)
			$cmtx_temp = preg_replace("/&cmtx_sort=[0-9]*/", "", $cmtx_temp); //remove cmtx_sort=x if there (1)
			$cmtx_temp = preg_replace("/cmtx_sort=[0-9]*&/", "", $cmtx_temp); //remove cmtx_sort=x if there (2)
			$cmtx_temp = preg_replace("/cmtx_sort=[0-9]*/", "", $cmtx_temp); //remove cmtx_sort=x if there (3)
			$cmtx_temp = preg_replace("/&cmtx_perm=[0-9]*/", "", $cmtx_temp); //remove cmtx_perm=x if there (1)
			$cmtx_temp = preg_replace("/cmtx_perm=[0-9]*&/", "", $cmtx_temp); //remove cmtx_perm=x if there (2)
			$cmtx_temp = preg_replace("/cmtx_perm=[0-9]*/", "", $cmtx_temp); //remove cmtx_perm=x if there (3)
			$cmtx_temp = strtolower($cmtx_temp); //convert to lowercase
			$cmtx_page_id = str_ireplace("cmtx_url", $cmtx_temp, $cmtx_page_id);
		}

		//sanitize data
		$cmtx_page_id = cmtx_sanitize($cmtx_page_id, true, true);
		
		$cmtx_reference = cmtx_sanitize($cmtx_reference, true, true);
		
		$url = cmtx_url_encode_spaces($url); //encode spaces
		$url = cmtx_sanitize($url, true, true);

		if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `page_id` = '$cmtx_page_id'"))) { //if ID is found

			$query = mysql_query("SELECT `id` FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `page_id` = '$cmtx_page_id'"); //get real ID
			$result = mysql_fetch_assoc($query);
			$cmtx_page_id = $result["id"];
			return $cmtx_page_id;

		} else { //create page

			if ($cmtx_settings->delay_pages) {

				if (isset($_POST['cmtx_submit']) || isset($_POST['cmtx_sub']) || isset($_POST['cmtx_preview']) || isset($_POST['cmtx_prev'])) {

					mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "pages` (`page_id`, `reference`, `url`, `is_form_enabled`, `dated`) VALUES ('$cmtx_page_id', '$cmtx_reference', '$url', 1, NOW())");

					return mysql_insert_id();

				} else {

					return "cmtx_system_page";

				}

			} else {

				mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "pages` (`page_id`, `reference`, `url`, `is_form_enabled`, `dated`) VALUES ('$cmtx_page_id', '$cmtx_reference', '$url', 1, NOW())");

				return mysql_insert_id();

			}

		}

	} else { //page ID did not validate

		?><span class="cmtx_page_id_alert"><?php echo CMTX_ALERT_MESSAGE_INVALID_PAGE_ID;?></span><?php
		die();

	}

} //end of validate-page-id function


function cmtx_get_page_reference() { //get page reference

	global $cmtx_mysql_table_prefix, $cmtx_page_id; //globalise variables

	$query = mysql_query("SELECT `reference` FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `id` = '$cmtx_page_id'");
	$result = mysql_fetch_assoc($query);
	$page_reference = $result["reference"];

	return $page_reference;

} //end of get-page-reference function


function cmtx_get_page_url() { //get page URL

	global $cmtx_mysql_table_prefix, $cmtx_page_id; //globalise variables

	$query = mysql_query("SELECT `url` FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `id` = '$cmtx_page_id'");
	$result = mysql_fetch_assoc($query);
	$page_url = $result["url"];

	return $page_url;

} //end of get-page-url function


function cmtx_get_ip_address() { //get IP address

	if (isset($_SERVER)) {
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
    } else {
		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip_address = getenv('HTTP_X_FORWARDED_FOR');
		} else if (getenv('HTTP_CLIENT_IP')) {
			$ip_address = getenv('HTTP_CLIENT_IP');
		} else {
			$ip_address = getenv('REMOTE_ADDR');
		}
    }

	$ip_address = cmtx_sanitize($ip_address, true, true);

	return $ip_address; //return IP address

} //end of get-ip-address function


function cmtx_get_user_agent() { //get user agent

	if (isset($_SERVER['HTTP_USER_AGENT']) && cmtx_strlen($_SERVER['HTTP_USER_AGENT']) < 250) {
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$user_agent = cmtx_sanitize($user_agent, true, true);
	} else {
		$user_agent = "";
	}

	return $user_agent; //return user agent

} //end of get-user-agent function


function cmtx_in_maintenance() { //check if in maintenance mode

	global $cmtx_settings, $cmtx_is_admin; //globalise variables

	if ($cmtx_settings->maintenance_mode && !$cmtx_is_admin) {
		?><h3>Commentics</h3>
		<div style="margin-bottom: 10px;"></div>
		<div class="cmtx_maintenance_message"><?php
		echo $cmtx_settings->maintenance_message;
		?></div><?php
		return true;
	} else {
		return false;
	}

} //end of in-maintenance function


function cmtx_is_administrator() { //is the user the administrator

	global $cmtx_mysql_table_prefix; //globalise variables

	//initialise values
	$administrator_found = false;
	$admin_ip_address_found = false;
	$admin_cookie_found = false;
	$detect_admin = false;
	$detect_method = "both";

	//check IP address
	$ip_address = cmtx_get_ip_address();
	if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `ip_address` = '$ip_address' AND `is_enabled` = '1'"))) {
		$admin_ip_address_found = true; //set IP address flag as true
	}

	//check cookie
	if (isset($_COOKIE['Commentics-Admin']) && ctype_alnum($_COOKIE['Commentics-Admin']) && cmtx_strlen($_COOKIE['Commentics-Admin']) == 20) {
		$cookie_value = cmtx_sanitize($_COOKIE['Commentics-Admin'], true, true);
		if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `cookie_key` = '$cookie_value' AND `is_enabled` = '1'"))) {
			$admin_cookie_found = true; //set cookie flag as true
		}
	}

	//get detection settings
	if ($admin_ip_address_found || $admin_cookie_found) {

		if ($admin_ip_address_found) {

			$detection_settings = mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `ip_address` = '$ip_address' AND `is_enabled` = '1' LIMIT 1");
			$detection_settings = mysql_fetch_assoc($detection_settings);
			$detect_admin = $detection_settings["detect_admin"];
			$detect_method = $detection_settings["detect_method"];

		} else {

			$detection_settings = mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `cookie_key` = '$cookie_value' AND `is_enabled` = '1' LIMIT 1");
			$detection_settings = mysql_fetch_assoc($detection_settings);
			$detect_admin = $detection_settings["detect_admin"];
			$detect_method = $detection_settings["detect_method"];		

		}

	}

	if ($detect_admin) { //if administrator should be detected

		if ($detect_method == "ip_address") {
			if ($admin_ip_address_found) {
				$administrator_found = true;
			}
		} else if ($detect_method == "cookie") {
			if ($admin_cookie_found) {
				$administrator_found = true;
			}
		} else if ($detect_method == "either") {
			if ($admin_ip_address_found || $admin_cookie_found) {
				$administrator_found = true;
			}
		} else if ($detect_method == "both") {
			if ($admin_ip_address_found && $admin_cookie_found) {
				$administrator_found = true;
			}
		}

	}

	return $administrator_found;

} //end of is-administrator function


function cmtx_prepare_name_for_email ($name) { //prepares name for email

	$name = cmtx_strip_slashes($name);

	$name = cmtx_decode($name);

	return $name;

} //end of prepare-name-for-email function


function cmtx_prepare_email_for_email ($email) { //prepares email address for email

	$email = cmtx_strip_slashes($email);

	$email = cmtx_decode($email);

	return $email;

} //end of prepare-email-for-email function


function cmtx_prepare_comment_for_email ($comment, $slashes = true) { //prepares comment for email

	if ($slashes) {
		$comment = cmtx_strip_slashes($comment);
	}

	$comment = str_ireplace("<br />", "\r\n", $comment);
	$comment = str_ireplace("<br/>", "\r\n", $comment);
	$comment = str_ireplace("<br>", "\r\n", $comment);

	$comment = str_ireplace("<p></p>", "\r\n\r\n", $comment);
	$comment = str_ireplace("<p />", "\r\n\r\n", $comment);
	$comment = str_ireplace("<p/>", "\r\n\r\n", $comment);

	$comment = str_ireplace("<li>", "- ", $comment);
	$comment = str_ireplace("</li>", "\r\n", $comment);
	$comment = str_ireplace("\r\n</ul>", "", $comment);
	$comment = str_ireplace("\r\n</ol>", "", $comment);

	$comment = strip_tags($comment);

	$comment = cmtx_decode($comment);

	$comment = preg_replace('/(\r\n){3,}/', "\r\n\r\n", $comment);

	$comment = trim($comment);

	return $comment;

} //end of prepare-comment-for-email function


function cmtx_get_random_key ($length) { //generates a random key

	$characters = "0123456789abcdefghijklmnopqrstuvwxyz"; //allowed characters
	$key = "";
	for ($i = 0; $i < $length; $i++) {
		$key .= $characters[mt_rand(0, cmtx_strlen($characters)-1)];
	}

	return $key;

} //end of get-random-key function


function cmtx_add_viewer() { //add viewer to database

	global $cmtx_mysql_table_prefix, $cmtx_settings, $cmtx_page_id; //globalise variables

	if ($cmtx_page_id != "cmtx_system_page") {

		$ip_address = cmtx_get_ip_address();
		$user_agent = cmtx_get_user_agent();
		$page_reference = cmtx_sanitize(cmtx_get_page_reference(), false, true);
		$page_url = cmtx_sanitize(cmtx_get_page_url(), false, true);

		$timestamp = time();
		$timeout = $timestamp - $cmtx_settings->viewers_timeout;

		mysql_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "viewers` WHERE `timestamp` < '$timeout'");
		mysql_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "viewers` WHERE `ip_address` = '$ip_address'");
		mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "viewers` (`user_agent`, `ip_address`, `page_reference`, `page_url`, `timestamp`) VALUES ('$user_agent', '$ip_address', '$page_reference', '$page_url', '$timestamp')");

	}

} //end of add-viewer function


function cmtx_get_query ($type) { //gets query string from URL

	if ($type == "form" && isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
		$query = "?" . $_SERVER['QUERY_STRING'];
	} else if ($type == "page" && isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
		$query = "&" . $_SERVER['QUERY_STRING'];
	} else if ($type == "sort" && isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
		$query = "&" . $_SERVER['QUERY_STRING'];
	} else {
		$query = "";
	}

	$query = preg_replace("/&cmtx_page=[0-9]*/", "", $query);
	$query = preg_replace("/cmtx_page=[0-9]*&/", "", $query);
	$query = preg_replace("/cmtx_page=[0-9]*/", "", $query);

	$query = preg_replace("/&cmtx_perm=[0-9]*/", "", $query);
	$query = preg_replace("/cmtx_perm=[0-9]*&/", "", $query);
	$query = preg_replace("/cmtx_perm=[0-9]*/", "", $query);

	if ($type != "page") {
		$query = preg_replace("/&cmtx_sort=[0-9]*/", "", $query);
		$query = preg_replace("/cmtx_sort=[0-9]*&/", "", $query);
		$query = preg_replace("/cmtx_sort=[0-9]*/", "", $query);
	}

	$query = rtrim($query, "?");

	return $query;

} //end of get-query function


function cmtx_unban_user() { //unban user if requested

	global $cmtx_mysql_table_prefix; //globalise variables

	$bans = mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "bans` WHERE `unban` = '1'");

	while ($ban = mysql_fetch_assoc($bans)) {

		if (cmtx_get_ip_address() == $ban['ip_address']) {
			@setcookie("Commentics-Ban", "", time() - 3600, '/');
			mysql_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "bans` WHERE `id` = '" . $ban['id'] . "'");
		}

	}

} //end of unban-user function


function cmtx_strlen($entry) { //get length of string

	if (function_exists('mb_strlen') && is_callable('mb_strlen')) {
		$length = mb_strlen($entry, 'UTF-8');
	} else {
		$length = strlen(utf8_decode($entry));
	}

	return $length;

} //end of strlen function


function cmtx_unapprove_replies($id) { //unapprove replies of given comment

	global $cmtx_mysql_table_prefix;

	$query = mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `reply_to` = '$id'");

	while ($comments = mysql_fetch_assoc($query)) {

		$id = $comments["id"];

		mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `is_approved` = '0' WHERE `id` = '$id'");

		cmtx_unapprove_replies($id);

	}

} //end of unapprove-replies function


function cmtx_error_reporting($path) { //error reporting

	global $cmtx_settings; //globalise variables

	if ($cmtx_settings->error_reporting_frontend) { //if error reporting is turned on for frontend
		@error_reporting(-1); //show every possible error
		if ($cmtx_settings->error_reporting_method == "log") { //if errors should be logged to file
			@ini_set('display_errors', 0); //don't display errors
			@ini_set("log_errors" , 1); //log errors
			@ini_set("error_log" , $path); //set log path
		} else { //if errors should be displayed on screen
			@ini_set('display_errors', 1); //display errors
			@ini_set("log_errors" , 0); //don't log errors
		}
	} else { //if error reporting is turned off for frontend
		@error_reporting(0); //turn off all error reporting
		@ini_set('display_errors', 0); //don't display errors
		@ini_set("log_errors" , 0); //don't log errors
	}

} //end of error-reporting function


function cmtx_reconnect_db() { //reconnect database

	global $cmtx_db_orig; //globalise variables

	if (!empty($cmtx_db_orig)) {
		@mysql_select_db ($cmtx_db_orig);
	}

} //end of reconnect-db function


function cmtx_session_set() { //is a session available

	if (session_id() != '') {
		return true;
	} else {
		return false;
	}

} //end of session-set function


function cmtx_escape_js($text) { //escape a JavaScript string for output

	$text = str_ireplace("'", "\'", $text); //replace ' with \'

	return $text;

} //end of escape-js function


function cmtx_set_time_zone($time_zone) { //set the time zone

	global $cmtx_settings; //globalise variables

	@date_default_timezone_set($time_zone); //set time zone PHP

	@mysql_query("SET time_zone = '" . date("P") . "'"); //set time zone DB

} //end of set-time-zone function
?>