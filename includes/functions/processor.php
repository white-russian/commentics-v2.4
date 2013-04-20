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


function cmtx_subscriber_exists ($email, $page_id) { //check whether subscriber exists

	global $cmtx_mysql_table_prefix; //globalise variables

	$email = strtolower($email); //temporarily convert to lowercase

	//check whether a confirmed subscriber of current page
	if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `email` = '$email' AND `page_id` = '$page_id' AND `is_confirmed` = '1'"))) {
		return true;
	} else {
		return false;
	}

} //end of subscriber-exists function


function cmtx_subscriber_bad ($email) { //check whether subscriber has any pending subscriptions

	global $cmtx_mysql_table_prefix; //globalise variables

	$email = strtolower($email); //temporarily convert to lowercase

	//check whether any unconfirmed subscriptions for any page
	if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `email` = '$email' AND `is_confirmed` = '0'"))) {
		return true;
	} else {
		return false;
	}

} //end of subscriber-bad function


function cmtx_add_subscriber ($name, $email, $page_id) { //adds new subscriber

	global $cmtx_mysql_table_prefix, $cmtx_path; //globalise variables

	$is_unique = false; //initialise flag as false

	while (!$is_unique) { //while the token is not unique

		$token = cmtx_get_random_key(20); //create new token

		if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `token` = '$token'")) == 0) { //if the token does not already exist
			$is_unique = true; //the created token is unique
		}

	}

	//insert subscriber into 'subscribers' database table
	mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "subscribers` (`name`, `email`, `page_id`, `token`, `is_confirmed`, `dated`) VALUES ('$name', '$email', '$page_id', '$token', '0', NOW())");

	$name = cmtx_prepare_name_for_email($name); //prepare name for email
	$email = cmtx_prepare_email_for_email($email); //prepare email address for email

	$subscriber_confirmation_email_file = $cmtx_path . "includes/emails/" . cmtx_setting('language_frontend') . "/user/subscriber_confirmation.txt"; //build path to subscriber confirmation email file
	$body = file_get_contents($subscriber_confirmation_email_file); //get the file's contents

	$confirmation_link = cmtx_url_encode_spaces(cmtx_setting('url_to_comments_folder')) . "subscribers.php" . "?id=" . $token . "&confirm=1"; //build confirmation link

	$page_reference = cmtx_decode(cmtx_get_page_reference()); //get the reference of the current page
	$page_url = cmtx_decode(cmtx_get_page_url()); //get the URL of the current page

	//convert email variables with actual variables
	$body = str_ireplace("[name]", $name, $body);
	$body = str_ireplace("[page reference]", $page_reference, $body);
	$body = str_ireplace("[page url]", $page_url, $body);
	$body = str_ireplace("[confirmation link]", $confirmation_link, $body);

	//send email
	cmtx_email($email, $name, cmtx_setting('subscriber_confirmation_subject'), $body, cmtx_setting('subscriber_confirmation_from_email'), cmtx_setting('subscriber_confirmation_from_name'), cmtx_setting('subscriber_confirmation_reply_to'));
	
} //end of add-subscriber function


function cmtx_notify_subscribers ($poster, $comment, $page_id) { //notify subscribers of new comment

	global $cmtx_mysql_table_prefix, $cmtx_path; //globalise variables

	//select confirmed subscribers from database
	$subscribers = mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "subscribers` WHERE `page_id` = '$page_id' AND `is_confirmed` = '1'");

	$page_reference = cmtx_decode(cmtx_get_page_reference()); //get the reference of the current page
	$page_url = cmtx_decode(cmtx_get_page_url()); //get the URL of the current page

	$subscriber_notification_email_file = $cmtx_path . "includes/emails/" . cmtx_setting('language_frontend') . "/user/subscriber_notification.txt"; //build path to subscriber notification email file

	$poster = cmtx_prepare_name_for_email($poster); //prepare name for email
	$comment = cmtx_prepare_comment_for_email($comment); //prepare comment for email

	$count = 0; //count how many emails are sent

	while ($subscriber = mysql_fetch_assoc($subscribers)) { //while there are subscribers

		$body = file_get_contents($subscriber_notification_email_file); //get the file's contents

		$email = $subscriber["email"];

		$name = cmtx_decode($subscriber["name"]);

		$token = $subscriber["token"];

		$unsubscribe_link = cmtx_url_encode_spaces(cmtx_setting('url_to_comments_folder')) . "subscribers.php" . "?id=" . $token . "&unsubscribe=1"; //build unsubscribe link

		//convert email variables with actual variables
		$body = str_ireplace("[name]", $name, $body);
		$body = str_ireplace("[page reference]", $page_reference, $body);
		$body = str_ireplace("[page url]", $page_url, $body);
		$body = str_ireplace("[poster]", $poster, $body);
		$body = str_ireplace("[comment]", $comment, $body);
		$body = str_ireplace("[unsubscribe link]", $unsubscribe_link, $body);

		//send email
		cmtx_email($email, $name, cmtx_setting('subscriber_notification_subject'), $body, cmtx_setting('subscriber_notification_from_email'), cmtx_setting('subscriber_notification_from_name'), cmtx_setting('subscriber_notification_reply_to'));

		$count++; //increment email counter

	}

	mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `is_sent` = '1' ORDER BY `dated` DESC LIMIT 1"); //mark comment as sent
	mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `sent_to` = '$count' ORDER BY `dated` DESC LIMIT 1"); //set how many were sent (if any)

} //end of notify-subscribers function


function cmtx_notify_admin_new_ban ($reason) { //notify admin of new ban

	global $cmtx_mysql_table_prefix, $cmtx_path; //globalise variables

	$ip_address = cmtx_get_ip_address();

	$admin_new_ban_email_file = $cmtx_path . "includes/emails/" . cmtx_setting('language_frontend') . "/admin/new_ban.txt"; //build path to admin new ban email file
	$body = file_get_contents($admin_new_ban_email_file); //get the file's contents

	$admin_link = cmtx_url_encode_spaces(cmtx_setting('url_to_comments_folder') . cmtx_setting('admin_folder')) . "/"; //build admin panel link

	//convert email variables with actual variables
	$body = str_ireplace("[ip address]", $ip_address, $body);
	$body = str_ireplace("[ban reasoning]", $reason, $body);
	$body = str_ireplace("[admin link]", $admin_link, $body);

	//select administrators from database
	$admins = mysql_query("SELECT `email` FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `receive_email_new_ban` = '1' AND `is_enabled` = '1'");

	while ($admin = mysql_fetch_assoc($admins)) { //while there are administrators

		$email = $admin["email"]; //get administrator email address
		
		cmtx_email($email, null, cmtx_setting('admin_new_ban_subject'), $body, cmtx_setting('admin_new_ban_from_email'), cmtx_setting('admin_new_ban_from_name'), cmtx_setting('admin_new_ban_reply_to'));

	}

} //end of notify-admin-new-ban function


function cmtx_notify_admin_new_comment_approve ($poster, $comment) { //notify admin of new comment to approve

	global $cmtx_mysql_table_prefix, $cmtx_path, $cmtx_approve_reason; //globalise variables

	$admin_new_comment_approve_email_file = $cmtx_path . "includes/emails/" . cmtx_setting('language_frontend') . "/admin/new_comment_approve.txt"; //build path to admin new comment approve email file
	$body = file_get_contents($admin_new_comment_approve_email_file); //get the file's contents

	$page_reference = cmtx_decode(cmtx_get_page_reference()); //get the reference of the current page
	$page_url = cmtx_decode(cmtx_get_page_url()); //get the URL of the current page

	$poster = cmtx_prepare_name_for_email($poster); //prepare name for email
	$comment = cmtx_prepare_comment_for_email($comment); //prepare comment for email

	$admin_link = cmtx_url_encode_spaces(cmtx_setting('url_to_comments_folder') . cmtx_setting('admin_folder')) . "/"; //build admin panel link

	//convert email variables with actual variables
	$body = str_ireplace("[page reference]", $page_reference, $body);
	$body = str_ireplace("[page url]", $page_url, $body);
	$body = str_ireplace("[poster]", $poster, $body);
	$body = str_ireplace("[comment]", $comment, $body);
	$body = str_ireplace("[approval reasoning]", $cmtx_approve_reason, $body);
	$body = str_ireplace("[admin link]", $admin_link, $body);

	//select administrators from database
	$admins = mysql_query("SELECT `email` FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `receive_email_new_comment_approve` = '1' AND `is_enabled` = '1'");

	while ($admin = mysql_fetch_assoc($admins)) { //while there are administrators

		$email = $admin["email"]; //get administrator email address
		
		cmtx_email($email, null, cmtx_setting('admin_new_comment_approve_subject'), $body, cmtx_setting('admin_new_comment_approve_from_email'), cmtx_setting('admin_new_comment_approve_from_name'), cmtx_setting('admin_new_comment_approve_reply_to'));

	}

} //end of notify-admin-new-comment-approve function


function cmtx_notify_admin_new_comment_okay ($poster, $comment) { //notify admin of new comment

	global $cmtx_mysql_table_prefix, $cmtx_is_admin, $cmtx_path; //globalise variables

	$admin_new_comment_okay_email_file = $cmtx_path . "includes/emails/" . cmtx_setting('language_frontend') . "/admin/new_comment_okay.txt"; //build path to admin new comment okay email file
	$body = file_get_contents($admin_new_comment_okay_email_file); //get the file's contents

	$page_reference = cmtx_decode(cmtx_get_page_reference()); //get the reference of the current page
	$page_url = cmtx_decode(cmtx_get_page_url()); //get the URL of the current page

	$poster = cmtx_prepare_name_for_email($poster); //prepare name for email
	$comment = cmtx_prepare_comment_for_email($comment); //prepare comment for email

	$admin_link = cmtx_url_encode_spaces(cmtx_setting('url_to_comments_folder') . cmtx_setting('admin_folder')) . "/"; //build admin panel link

	//convert email variables with actual variables
	$body = str_ireplace("[page reference]", $page_reference, $body);
	$body = str_ireplace("[page url]", $page_url, $body);
	$body = str_ireplace("[poster]", $poster, $body);
	$body = str_ireplace("[comment]", $comment, $body);
	$body = str_ireplace("[admin link]", $admin_link, $body);

	//select administrators from database
	$admins = mysql_query("SELECT `email` FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `receive_email_new_comment_okay` = '1' AND `is_enabled` = '1'");

	while ($admin = mysql_fetch_assoc($admins)) { //while there are administrators

		$email = $admin["email"]; //get administrator email address

		if ($cmtx_is_admin && cmtx_is_admin_email($email)) {} else { //if not detected admin who submitted

			cmtx_email($email, null, cmtx_setting('admin_new_comment_okay_subject'), $body, cmtx_setting('admin_new_comment_okay_from_email'), cmtx_setting('admin_new_comment_okay_from_name'), cmtx_setting('admin_new_comment_okay_reply_to'));

		}

	}

} //end of notify-admin-new-comment-okay function


function cmtx_is_admin_email ($email) { //checks whether email address belongs to detected admin

	global $cmtx_mysql_table_prefix; //globalise variables

	$is_admin_email = false; //initialise flag as false

	$ip_address = cmtx_get_ip_address();

	if (isset($_COOKIE['Commentics-Admin']) && ctype_alnum($_COOKIE['Commentics-Admin']) && cmtx_strlen($_COOKIE['Commentics-Admin']) == 20) {
		$cookie_value = cmtx_sanitize($_COOKIE['Commentics-Admin'], true, true);
	} else {
		$cookie_value = "";
	}

	if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `cookie_key` = '$cookie_value' AND `is_enabled` = '1' LIMIT 1"))) {

		$admin = mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `cookie_key` = '$cookie_value' AND `is_enabled` = '1' LIMIT 1");
		$admin = mysql_fetch_assoc($admin);

	} else {
	
		$admin = mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `ip_address` = '$ip_address' AND `is_enabled` = '1' LIMIT 1");
		$admin = mysql_fetch_assoc($admin);

	}

	if ($email == $admin['email']) {
		$is_admin_email = true;
	}

	return $is_admin_email;

} //end of is-admin-email function


function cmtx_check_for_one_name ($name) { //checks whether a single name was entered

	$number_of_names = count(explode(" ", $name)); //get number of names

	if ($number_of_names > 1) { //if more than one name
		cmtx_error(CMTX_ERROR_MESSAGE_ONE_NAME); //reject user for entering more than one name
	}

} //end of check-for-one-name function


function cmtx_validate_name ($name) { //checks whether name was valid

	if (!preg_match('/^[\p{L}&\-\'. ]+$/u', $name) || !preg_match('/^[\p{L}]+/u', $name)) { //if the submitted name does not validate
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_NAME); //reject user for entering invalid name	
	}

	// letters, ampersand, hyphen, apostrophe, period, space
	// \p{L} (any kind of letter from any language)

} //end of validate-name function


function cmtx_check_for_word ($file, $boundary, $entry, $action, $approve_msg, $error_msg, $ban_msg) { //checks whether a specific word was entered

	global $cmtx_path; //globalise variables

	$word_found = false; //initialise flag as false

	$words_file = $cmtx_path . "includes/words/$file.txt"; //build path to words file

	if (filesize($words_file) != 0) { //if file is not empty

		$words = file($words_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		foreach ($words as $word) { //for each word

			$word = preg_quote($word, '/'); //escape any special characters

			$word = str_ireplace("\*", "[^ .,]*", $word); //allow use of wildcard symbol

			if ($boundary) {
				$regexp = "/\b$word\b/i"; //pattern (b = word boundary, i = case-insensitive)
			} else {
				$regexp = "/$word/i"; //pattern (i = case-insensitive)
			}


			if (preg_match($regexp, $entry)) { //if there is a match
				$word_found = true; //set flag as true
			}

			if ( ($action == "mask" || $action == "mask_approve") && (!isset($_POST['cmtx_preview']) && !isset($_POST['cmtx_prev'])) ) { //if entering the word should result in masking and not in preview mode
				$entry = preg_replace($regexp, cmtx_setting('swear_word_masking'), $entry); //mask words
			}

		} //end of for-each-word

		if ($word_found) { //if word was entered
			if ($action == "approve" || $action == "mask_approve") { //if entering the word should require approval
				cmtx_approve($approve_msg); //approve user for entering word
			} else if ($action == "reject") { //if entering the word should be rejected
				cmtx_error($error_msg); //reject user for entering word
			} else if ($action == "ban") { //if entering the word should result in a ban
				cmtx_ban($ban_msg); //ban user for entering word
			}
		} //end of if-word-was-entered

	} //end of if-file-not-empty

	return $entry; //return the (possibly masked) entry

} //end of check-for-word function


function cmtx_validate_email ($email) { //checks whether email address was valid

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_EMAIL); //reject user for invalid email address	
	}

} //end of validate-email function


function cmtx_validate_website ($website) { //checks whether website was valid

	$website_valid = true; //initialise flag as true

	if (!filter_var($website, FILTER_VALIDATE_URL)) {
		$website_valid = false; //set flag as false
	}

	if (cmtx_setting('validate_website_ping')) { //if website should be pinged

		$headers = @get_headers($website);

		if ($headers[0] == "HTTP/1.1 404 Not Found") {
			$website_valid = false; //set flag as false
		}

	} //end of if-website-should-be-pinged

	if (!$website_valid) { //if invalid website was entered
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_WEBSITE); //reject user for invalid website address
	}

} //end of validate-website function


function cmtx_validate_town ($town) { //checks whether town was valid

	if (!preg_match('/^[\p{L}&\-\'. ]+$/u', $town) || !preg_match('/^[\p{L}]+/u', $town)) { //if the submitted town does not validate
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_TOWN); //reject user for entering invalid town
	}

	// letters, ampersand, hyphen, apostrophe, period, space
	// \p{L} (any kind of letter from any language)

} //end of validate-town function


function cmtx_validate_country ($country) { //checks whether country was valid

	if (!preg_match('/^[\p{L}&\-\'. ]+$/u', $country) || !preg_match('/^[\p{L}]+/u', $country)) { //if the submitted country does not validate
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_COUNTRY); //reject user for submitting invalid country
	}

	// letters, ampersand, hyphen, apostrophe, period, space
	// \p{L} (any kind of letter from any language)

} //end of validate-country function


function cmtx_find_country ($country) { //find whether country is in country list

	global $cmtx_path; //globalise variables

	$country = str_ireplace("'", "\'", $country); //escape ' with \

	$file = file($cmtx_path . "includes/language/" . cmtx_setting('language_frontend') . "/countries.php"); //set file to search

	foreach ($file as $line_number => $line) { //for each line in file

		$line_number++; //keep count of line number
			
		if ($line_number > 30) { //don't search copyright section

			$matches = array(); //used to store matches

			if (preg_match('/DEFINE\(\'(.*?)\',\s*\'(.*)\'\);/i', $line, $matches)) { //if the line is a valid define statement

				$value = $matches[2]; //get the value part of the define statement

				if ($value == $country) { //if the value is the country (country found)
					return; //exit this function
				}

			}

		}

	}

	cmtx_error(CMTX_ERROR_MESSAGE_COUNTRY_SEARCH); //reject user for submitting country not in country list

} //end of find-country function


function cmtx_validate_rating ($rating) { //checks whether rating was valid

	if (!preg_match('/[1-5]/', $rating)) { //if the submitted rating does not validate
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_RATING); //reject user for submitting invalid rating
	}

} //end of validate-rating function


function cmtx_validate_reply ($reply_id, $page_id) { //checks whether reply was valid

	global $cmtx_mysql_table_prefix; //globalise variables

	$reply_id = cmtx_sanitize($reply_id, true, true); //sanitize reply

	if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$reply_id' AND `page_id` = '$page_id' AND `is_approved` = '1'")) != 1 && $reply_id != 0) {
		cmtx_error(CMTX_ERROR_MESSAGE_INVALID_REPLY); //reject user for submitting invalid reply
	}

} //end of validate_reply function


function cmtx_comment_minimum ($comment) { //checks whether comment is less than minimum settings

	$comment = str_ireplace("<br />", " ", $comment); //remove <br /> tags
	$comment = str_ireplace("<p></p>", " ", $comment); //remove <p></p> tags
	$comment = strip_tags($comment); //strip any tags from comment
	$comment = trim($comment); //remove any space at beginning and end of comment

	$comment_number_of_characters = cmtx_strlen($comment); //number of characters in comment

	$comment_number_of_words = count(explode(" ", $comment)); //number of words in comment

	if ($comment_number_of_characters < cmtx_setting('comment_minimum_characters') || $comment_number_of_words < cmtx_setting('comment_minimum_words')) { //if comment is less than minimum
		cmtx_error(CMTX_ERROR_MESSAGE_COMMENT_MIN); //reject user for entering short comment
	}

} //end of comment-minimum function


function cmtx_comment_maximum ($comment) { //checks whether comment exceeds maximum

	$comment = trim($comment); //remove any space at beginning and end of comment

	$comment = strip_tags($comment); //strip any tags from comment

	$comment_number_of_characters = cmtx_strlen($comment); //number of characters in comment

	if ($comment_number_of_characters > cmtx_setting('comment_maximum_characters')) { //if comment exceeds maximum
		cmtx_error(CMTX_ERROR_MESSAGE_COMMENT_MAX); //reject user for entering long comment
	}

} //end of comment-maximum function


function cmtx_comment_max_lines ($comment) { //checks whether comment contains too many lines

	$comment_number_of_lines = substr_count($comment, "<br />") + (substr_count($comment, "<p></p>") * 2); //number of lines in comment

	if ($comment_number_of_lines > cmtx_setting('comment_maximum_lines')) { //if comment contains too many lines
		cmtx_error(CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES); //reject user for entering too many lines
	}

} //end of comment-max-lines function


function cmtx_comment_resubmit() { //checks whether comment is new

	if (cmtx_session_set() && isset($_SESSION['cmtx_resubmit_key'])) {

		if ($_SESSION['cmtx_resubmit_key'] == $_POST['cmtx_resubmit_key']) {
			cmtx_error(CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT);
		}

	}

} //end of comment-resubmit function


function cmtx_check_repeats ($entry, $action, $approve_msg, $error_msg, $ban_msg) { //checks entry for repeating characters

	$repeats_found = false; //initialise flag as false

	if (cmtx_is_encoding_iso($entry)) { //if encoding is ISO-8859-1
		if (preg_match('/([^\d])\1{2,}/i', $entry)) { //if the submitted entry contains repeats
			$repeats_found = true;
		}
	}

	//3 or more non-numeric characters

	if ($repeats_found) { //if repeats found
		if ($action == "approve") { //if entering repeats should require approval
			cmtx_approve($approve_msg); //approve user for entering repeats
		} else if ($action == "reject") { //if entering repeats should be rejected
			cmtx_error($error_msg); //reject user for entering repeats
		} else if ($action == "ban") { //if entering repeats should result in a ban
			cmtx_ban($ban_msg); //ban user for entering repeats
		}
	} //end of if-repeats-found

} //end of check-repeats function


function cmtx_check_for_link ($entry, $action, $approve_msg, $error_msg, $ban_msg) { //checks entry for link

	global $cmtx_path; //globalise variables

	$link_found = false; //initialise flag as false

	$detect_link_file = $cmtx_path . "includes/words/detect_links.txt"; //build path to link detection file

	if (filesize($detect_link_file) != 0) { //if file is not empty

		$link_detections = file($detect_link_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		foreach ($link_detections as $link_detection) { //for each link detection

			$link_detection = preg_quote($link_detection, '/'); //escape any special characters

			$regexp = "/$link_detection/i"; //link detection pattern (i = case-insensitive)

			if (preg_match($regexp, $entry)) { //if there is a match
				$link_found = true; //set flag as true
			}

		} //end of for-each-link-detection

		if ($link_found) { //if link was entered
			if ($action == "approve") { //if entering a link should require approval
				cmtx_approve($approve_msg); //approve user for entering link
			} else if ($action == "reject") { //if entering a link should be rejected
				cmtx_error($error_msg); //reject user for entering link
			} else if ($action == "ban") { //if entering a link should result in a ban
				cmtx_ban($ban_msg); //ban user for entering link
			}
		} //end of if-link-was-entered		

	} //end of if-file-not-empty

} //end of check-for-link function


function cmtx_comment_detect_image ($comment) { //checks comment for images

	$image_found = stripos($comment, '[IMG]'); //check for image tag

	if ($image_found !== false) { //if image was entered
		cmtx_approve(CMTX_APPROVE_REASON_IMAGE_ENTERED); //approve user for entering image
	} //end of if-image-was-entered

} //end of comment-detect-image function


function cmtx_comment_detect_video ($comment) { //checks comment for videos

	$video_found = stripos($comment, '[VIDEO]'); //check for video tag

	if ($video_found !== false) { //if video was entered
		cmtx_approve(CMTX_APPROVE_REASON_VIDEO_ENTERED); //approve user for entering video
	} //end of if-video-was-entered

} //end of comment-detect-video function


function cmtx_comment_add_bb_code ($comment) { //add BB Code to comment

	$code_box_styling = 'background-color:#FAFAFA; width:500px; padding:4px; white-space:nowrap; overflow:auto; border:1px inset;';
	$php_box_styling = 'background-color:#FAFAFA; width:500px; font-size:medium; padding:4px; white-space:nowrap; overflow:auto; border:1px inset;';
	$quote_box_styling = 'background-color:#FAFAFA; width:500px; padding:4px; white-space:nowrap; overflow:auto; border:1px inset;';
	$line_styling = 'color:#EDEDED;';

	if (cmtx_setting('enabled_bb_code_bold')) {
		$comment = preg_replace("/\[B\]\s*\[\/B\]/is", "", $comment); //remove bold tags with nothing visible inside
		$comment = preg_replace("/\[B\](.*?)\[\/B\]/is", "<b>$1</b>", $comment);
	}

	if (cmtx_setting('enabled_bb_code_italic')) {
		$comment = preg_replace("/\[I\]\s*\[\/I\]/is", "", $comment);
		$comment = preg_replace("/\[I\](.*?)\[\/I\]/is", "<i>$1</i>", $comment);
	}

	if (cmtx_setting('enabled_bb_code_underline')) {
		$comment = preg_replace("/\[U\]\s*\[\/U\]/is", "", $comment);
		$comment = preg_replace("/\[U\](.*?)\[\/U\]/is", "<u>$1</u>", $comment);
	}

	if (cmtx_setting('enabled_bb_code_strike')) {
		$comment = preg_replace("/\[STRIKE\]\s*\[\/STRIKE\]/is", "", $comment);
		$comment = preg_replace("/\[STRIKE\](.*?)\[\/STRIKE\]/is", "<del>$1</del>", $comment);
	}

	if (cmtx_setting('enabled_bb_code_superscript')) {
		$comment = preg_replace("/\[SUP\]\s*\[\/SUP\]/is", "", $comment);
		$comment = preg_replace("/\[SUP\](.*?)\[\/SUP\]/is", "<sup>$1</sup>", $comment);
	}

	if (cmtx_setting('enabled_bb_code_subscript')) {
		$comment = preg_replace("/\[SUB\]\s*\[\/SUB\]/is", "", $comment);
		$comment = preg_replace("/\[SUB\](.*?)\[\/SUB\]/is", "<sub>$1</sub>", $comment);
	}

	if (cmtx_setting('enabled_bb_code_code')) {
		$comment = preg_replace("/\[CODE\]\s*\[\/CODE\]/is", "", $comment);
		$comment = preg_replace("/\[CODE\](.*?)\[\/CODE\]/is", "<div style='" . $code_box_styling . "'>$1</div>", $comment);
	}

	if (cmtx_setting('enabled_bb_code_php_code')) {
		$comment = preg_replace("/\[PHP\]\s*\[\/PHP\]/is", "", $comment);
		while (preg_match("/\[PHP\](.*?)\[\/PHP\]/is", $comment, $matches)) {
			$code = html_entity_decode($matches[1]);
			$code = trim($code);
			$code = highlight_string($code, true);
			$code = str_ireplace("\r", "", $code);
			$code = str_ireplace("\n", "", $code);
			$code = str_ireplace("&nbsp;", " ", $code);
			$comment = str_ireplace("[PHP]" . $matches[1] . "[/PHP]", "<div style='" . $php_box_styling . "'>$code</div>", $comment);
		}
	}

	if (cmtx_setting('enabled_bb_code_quote')) {
		$comment = preg_replace("/\[QUOTE\]\s*\[\/QUOTE\]/is", "", $comment);
		$comment = preg_replace("/\[QUOTE\](.*?)\[\/QUOTE\]/is", "<div style='" . $quote_box_styling . "'>$1</div>", $comment);
	}

	if (cmtx_setting('enabled_bb_code_line')) {
		$comment = str_ireplace("[LINE]", "<hr style='" . $line_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_bb_code_list_bullet')) {
		$comment = str_ireplace("[BULLET]\r\n", "<ul>", $comment);
		$comment = str_ireplace("[ITEM]", "<li>", $comment);
		$comment = str_ireplace("[/ITEM]\r\n", "</li>", $comment);
		$comment = str_ireplace("[/BULLET]", "</ul>", $comment);
	}

	if (cmtx_setting('enabled_bb_code_list_numeric')) {
		$comment = str_ireplace("[NUMERIC]\r\n", "<ol>", $comment);
		$comment = str_ireplace("[ITEM]", "<li>", $comment);
		$comment = str_ireplace("[/ITEM]\r\n", "</li>", $comment);		
		$comment = str_ireplace("[/NUMERIC]", "</ol>", $comment);
	}

	if (cmtx_setting('enabled_bb_code_url')) {

		global $cmtx_bb_code_url_attribute;

		$cmtx_bb_code_url_attribute = ""; //initialize variable

		if (cmtx_setting('comment_links_new_window')) { //if links should open in new window
			$cmtx_bb_code_url_attribute = " target=\"_blank\"";
		}

		if (cmtx_setting('comment_links_nofollow')) { //if links should contain nofollow tag
			$cmtx_bb_code_url_attribute .= " rel=\"nofollow\"";
		}

		function cmtx_link_1 (array $matches) {

			global $cmtx_bb_code_url_attribute;

			$matches[1] = cmtx_url_encode_spaces($matches[1]);

			if (filter_var($matches[1], FILTER_VALIDATE_URL)) {
				return "<a href='" . $matches[1] . "'$cmtx_bb_code_url_attribute>" . $matches[1] . "</a>";
			} else {
				return CMTX_BB_INVALID_LINK;
			}
		}

		$comment = preg_replace_callback("/\[LINK\](.*?)\[\/LINK\]/is", "cmtx_link_1", $comment);

		function cmtx_link_2 (array $matches) {

			global $cmtx_bb_code_url_attribute;

			$matches[1] = cmtx_url_encode_spaces($matches[1]);

			if (filter_var($matches[1], FILTER_VALIDATE_URL)) {
				return "<a href='" . $matches[1] . "'$cmtx_bb_code_url_attribute>" . $matches[2] . "</a>";
			} else {
				return CMTX_BB_INVALID_LINK;
			}
		}

		$comment = preg_replace_callback("/\[LINK\=(.*?)\](.*?)\[\/LINK\]/is", "cmtx_link_2", $comment);

	}

	if (cmtx_setting('enabled_bb_code_email')) {

		global $cmtx_bb_code_email_attribute;

		$cmtx_bb_code_email_attribute = ""; //initialize variable

		if (cmtx_setting('comment_links_new_window')) { //if links should open in new window
			$cmtx_bb_code_email_attribute = " target=\"_blank\"";
		}

		if (cmtx_setting('comment_links_nofollow')) { //if links should contain nofollow tag
			$cmtx_bb_code_email_attribute .= " rel=\"nofollow\"";
		}

		function cmtx_email_1 (array $matches) {

			global $cmtx_bb_code_email_attribute;

			$matches[1] = cmtx_url_encode_spaces($matches[1]);

			if (filter_var($matches[1], FILTER_VALIDATE_EMAIL)) {
				return "<a href='mailto:" . $matches[1] . "'$cmtx_bb_code_email_attribute>" . $matches[1] . "</a>";
			} else {
				return CMTX_BB_INVALID_EMAIL;
			}
		}

		$comment = preg_replace_callback("/\[EMAIL\](.*?)\[\/EMAIL\]/is", "cmtx_email_1", $comment);

		function cmtx_email_2 (array $matches) {

			global $cmtx_bb_code_email_attribute;

			$matches[1] = cmtx_url_encode_spaces($matches[1]);

			if (filter_var($matches[1], FILTER_VALIDATE_EMAIL)) {
				return "<a href='mailto:" . $matches[1] . "'$cmtx_bb_code_email_attribute>" . $matches[2] . "</a>";
			} else {
				return CMTX_BB_INVALID_EMAIL;
			}
		}

		$comment = preg_replace_callback("/\[EMAIL\=(.*?)\](.*?)\[\/EMAIL\]/is", "cmtx_email_2", $comment);

	}

	if (cmtx_setting('enabled_bb_code_image')) {

		function cmtx_image_1 (array $matches) {

			$image_styling = 'max-width:508px; height:auto;';

			$matches[1] = cmtx_url_encode_spaces($matches[1]);

			if (filter_var($matches[1], FILTER_VALIDATE_URL)) {
				return "<img src='" . $matches[1] . "' style='" . $image_styling . "'/>";
			} else {
				return CMTX_BB_INVALID_IMAGE;
			}

		}

		$comment = preg_replace_callback("/\[IMG\](.*?)\[\/IMG\]/is", "cmtx_image_1", $comment);

	}

	if (cmtx_setting('enabled_bb_code_video')) {

		function cmtx_video_1 (array $matches) {

			global $cmtx_path;

			if (filter_var($matches[1], FILTER_VALIDATE_URL)) {
				require_once $cmtx_path . 'includes/AutoEmbed/AutoEmbed.class.php';
				$AE = new AutoEmbed();
				if (!$AE->parseUrl($matches[1])) {
					return CMTX_BB_INVALID_VIDEO;
				}
				return $AE->getEmbedCode();
			} else {
				return CMTX_BB_INVALID_VIDEO;
			}
		}

		$comment = preg_replace_callback("/\[VIDEO\](.*?)\[\/VIDEO\]/is", "cmtx_video_1", $comment);

	}

	return $comment;

} //end of comment-add-bb-code function


function cmtx_comment_add_smilies ($comment) { //add smilies to comment

	$smiley_styling = 'border-style: none; vertical-align: bottom;';

	if (cmtx_setting('enabled_smilies_smile')) {
		$comment = str_ireplace(":smile:", "<img src='" . cmtx_comments_folder() . "images/smilies/smile.gif' title='Smile' alt='Smile' style='" . $smiley_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_smilies_sad')) {
		$comment = str_ireplace(":sad:", "<img src='" . cmtx_comments_folder() . "images/smilies/sad.gif' title='Sad' alt='Sad' style='" . $smiley_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_smilies_huh')) {
		$comment = str_ireplace(":huh:", "<img src='" . cmtx_comments_folder() . "images/smilies/huh.gif' title='Huh' alt='Huh' style='" . $smiley_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_smilies_laugh')) {
		$comment = str_ireplace(":laugh:", "<img src='" . cmtx_comments_folder() . "images/smilies/laugh.gif' title='Laugh' alt='Laugh' style='" . $smiley_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_smilies_mad')) {
		$comment = str_ireplace(":mad:", "<img src='" . cmtx_comments_folder() . "images/smilies/mad.gif' title='Mad' alt='Mad' style='" . $smiley_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_smilies_tongue')) {
		$comment = str_ireplace(":tongue:", "<img src='" . cmtx_comments_folder() . "images/smilies/tongue.gif' title='Tongue' alt='Tongue' style='" . $smiley_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_smilies_crying')) {
		$comment = str_ireplace(":crying:", "<img src='" . cmtx_comments_folder() . "images/smilies/crying.gif' title='Crying' alt='Crying' style='" . $smiley_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_smilies_grin')) {
		$comment = str_ireplace(":grin:", "<img src='" . cmtx_comments_folder() . "images/smilies/grin.gif' title='Grin' alt='Grin' style='" . $smiley_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_smilies_wink')) {
		$comment = str_ireplace(":wink:", "<img src='" . cmtx_comments_folder() . "images/smilies/wink.gif' title='Wink' alt='Wink' style='" . $smiley_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_smilies_scared')) {
		$comment = str_ireplace(":scared:", "<img src='" . cmtx_comments_folder() . "images/smilies/scared.gif' title='Scared' alt='Scared' style='" . $smiley_styling . "'/>", $comment);
	}	

	if (cmtx_setting('enabled_smilies_cool')) {
		$comment = str_ireplace(":cool:", "<img src='" . cmtx_comments_folder() . "images/smilies/cool.gif' title='Cool' alt='Cool' style='" . $smiley_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_smilies_sleep')) {
		$comment = str_ireplace(":sleep:", "<img src='" . cmtx_comments_folder() . "images/smilies/sleep.gif' title='Sleep' alt='Sleep' style='" . $smiley_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_smilies_blush')) {
		$comment = str_ireplace(":blush:", "<img src='" . cmtx_comments_folder() . "images/smilies/blush.gif' title='Blush' alt='Blush' style='" . $smiley_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_smilies_unsure')) {
		$comment = str_ireplace(":unsure:", "<img src='" . cmtx_comments_folder() . "images/smilies/unsure.gif' title='Unsure' alt='Unsure' style='" . $smiley_styling . "'/>", $comment);
	}

	if (cmtx_setting('enabled_smilies_shocked')) {
		$comment = str_ireplace(":shocked:", "<img src='" . cmtx_comments_folder() . "images/smilies/shocked.gif' title='Shocked' alt='Shocked' style='" . $smiley_styling . "'/>", $comment);
	}

	return $comment;

} //end of comment-add-smilies function


function cmtx_check_maximum_smilies ($comment) { //checks whether number of smilies exceeds maximum

	$number_of_smilies = substr_count($comment, '<img src='); //number of smilies in comment

	if ($number_of_smilies > cmtx_setting('comment_maximum_smilies')) { //if number of smilies exceeds maximum
		cmtx_error(sprintf(CMTX_ERROR_MESSAGE_SMILIES_MAX, cmtx_setting('comment_maximum_smilies'))); //reject user for entering too many smilies
	}

} //end of check-maximum-smilies function


function cmtx_set_form_cookie($name, $email, $website, $town, $country) { //save user form inputs in cookie

	$name = cmtx_strip_slashes(cmtx_decode($name));
	$email = cmtx_strip_slashes(cmtx_decode($email));
	$website = cmtx_strip_slashes(cmtx_decode($website));
	$town = cmtx_strip_slashes(cmtx_decode($town));
	$country = cmtx_strip_slashes(cmtx_decode($country));

	@setcookie("Commentics-Form", $name . "|" . $email . "|" . $website . "|" . $town . "|" . $country, 60*60*24*cmtx_setting('form_cookie_days') + time(), '/'); //set form cookie

} //end of set-form-cookie function


function cmtx_purify ($comment) { //purifies html

	global $cmtx_path; //globalise variables

	require_once $cmtx_path . 'includes/htmLawed/htmLawed.php'; //load htmLawed script

	$comment = htmLawed($comment); //purify

	return $comment;

} //end of purify function


function cmtx_akismet ($name, $email, $website, $comment) { //check Akismet test for spam

	global $cmtx_path; //globalise variables

	$name = cmtx_strip_slashes(cmtx_decode($name));
	$email = cmtx_strip_slashes(cmtx_decode($email));
	$website = cmtx_strip_slashes(cmtx_decode($website));
	if ($website == "http://") { $website = ""; }
	$comment = cmtx_strip_slashes(cmtx_decode($comment));

	require_once $cmtx_path . 'includes/akismet/akismet.php'; //load Akismet script

	$WordPressAPIKey = cmtx_setting('akismet_key'); //set API key

	$MyBlogURL = parse_url(cmtx_get_page_url(), PHP_URL_HOST);

	$akismet = new Akismet($MyBlogURL, $WordPressAPIKey);

	$akismet->setCommentAuthor($name);
	$akismet->setCommentAuthorEmail($email);
	$akismet->setCommentAuthorURL($website);
	$akismet->setCommentContent($comment);
	$akismet->setCommentType("comment");
	$akismet->setPermalink(cmtx_get_page_url());

	if ($akismet->isCommentSpam()) {
		return true;
	} else {
		return false;
	}

} //end of akismet function


function cmtx_repopulate() { //repopulate the form with posted data

	global $cmtx_default_name, $cmtx_default_email, $cmtx_default_website, $cmtx_default_town, $cmtx_default_country, $cmtx_default_rating, $cmtx_default_comment, $cmtx_reply_id, $cmtx_default_notify, $cmtx_default_remember, $cmtx_default_privacy, $cmtx_default_terms; //globalise variables

	if (isset($_POST['cmtx_name'])) { $cmtx_default_name = $_POST['cmtx_name']; }
	if (isset($_POST['cmtx_email'])) { $cmtx_default_email = $_POST['cmtx_email']; }
	if (isset($_POST['cmtx_website'])) { $cmtx_default_website = $_POST['cmtx_website']; }
	if (isset($_POST['cmtx_town'])) { $cmtx_default_town = $_POST['cmtx_town']; }
	if (isset($_POST['cmtx_country'])) { $cmtx_default_country = $_POST['cmtx_country']; }
	if (isset($_POST['cmtx_rating'])) { $cmtx_default_rating = $_POST['cmtx_rating']; }
	if (isset($_POST['cmtx_comment'])) { $cmtx_default_comment = $_POST['cmtx_comment']; }
	if (isset($_POST['cmtx_reply_id'])) { $cmtx_reply_id = $_POST['cmtx_reply_id']; }
	if (isset($_POST['cmtx_notify'])) { $cmtx_default_notify = true; } else { $cmtx_default_notify = false; }
	if (isset($_POST['cmtx_remember'])) { $cmtx_default_remember = true; } else { $cmtx_default_remember = false; }
	if (isset($_POST['cmtx_privacy'])) { $cmtx_default_privacy = true; }
	if (isset($_POST['cmtx_terms'])) { $cmtx_default_terms = true; }

} //end of repopulate function


function cmtx_get_name ($id) { //get name from comment ID

	global $cmtx_mysql_table_prefix;

	$name_query = mysql_query("SELECT `name` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
	$name_result = mysql_fetch_assoc($name_query);
	$name = $name_result["name"];

	return $name;
	
} //end of get-name function


function cmtx_check_maximums() { //check field data does not exceed maximum lengths

	$pass = true;

	if (isset($_POST['cmtx_name'])) { //if name submitted
		if (cmtx_strlen($_POST['cmtx_name']) > cmtx_setting('field_maximum_name')) { //if name length exceeds maximum name length
			$pass = false;
		}
	}

	if (isset($_POST['cmtx_email'])) {
		if (cmtx_strlen($_POST['cmtx_email']) > cmtx_setting('field_maximum_email')) {
			$pass = false;
		}
	}

	if (isset($_POST['cmtx_website'])) {
		if (cmtx_strlen($_POST['cmtx_website']) > cmtx_setting('field_maximum_website')) {
			$pass = false;
		}
	}

	if (isset($_POST['cmtx_town'])) {
		if (cmtx_strlen($_POST['cmtx_town']) > cmtx_setting('field_maximum_town')) {
			$pass = false;
		}
	}

	if (isset($_POST['cmtx_country'])) {
		if (cmtx_strlen($_POST['cmtx_country']) > 50) {
			$pass = false;
		}
	}

	if (isset($_POST['cmtx_rating'])) {
		if (cmtx_strlen($_POST['cmtx_rating']) > 1) {
			$pass = false;
		}
	}

	if (!$pass) {
		cmtx_error(CMTX_ERROR_MESSAGE_MAXIMUMS);
	}

} //end of check-maximums function


function cmtx_fix_entry ($entry) { //converts words to lowercase except first letter

	if (cmtx_is_encoding_iso($entry)) { //if encoding is ISO-8859-1
		$entry = ucwords(strtolower($entry)); //convert
	}

	return $entry; //return fixed entry

} //end of fix-entry function


function cmtx_is_encoding_iso ($entry) { //checks whether character encoding is ISO-8859-1

	if (function_exists('mb_check_encoding') && is_callable('mb_check_encoding')) {
		if (mb_check_encoding($entry, "ASCII")) {
			return true;
		} else {
			return false;
		}
	} else {
		if (preg_match("/^[\\x00-\\xFF]*$/u", $entry) === 1) {
			return true;
		} else {
			return false;
		}
	}

} //end of is-encoding-iso function


function cmtx_is_injected ($entry) { //checks if entry contains injection attempt

	$injections = array('(\n+)','(\r+)','(\t+)','(%0A+)','(%0D+)','(%08+)','(%09+)');
	$inject = join('|', $injections);
	$inject = "/$inject/i";

	if (preg_match($inject,$entry)) { //if injection found
		cmtx_ban(CMTX_BAN_REASON_INJECTION); //ban user for injection attempt
	}

} //end of is-injected function


function cmtx_comment_parse_links ($comment) { //convert plain text links to html

	$attribute = ""; //initialize variable

	if (cmtx_setting('comment_links_new_window')) { //if links should open in new window
		$attribute = " target=\"_blank\"";
	}

	if (cmtx_setting('comment_links_nofollow')) { //if links should contain nofollow tag
		$attribute .= " rel=\"nofollow\"";
	}

	if (cmtx_setting('comment_parser_convert_links')) { //if web links should be converted
		$comment= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\"$attribute>$3</a>", $comment);
		$comment= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\"$attribute>$3</a>", $comment);
	}

	if (cmtx_setting('comment_parser_convert_emails')) { //if email addresses should be converted
		$comment= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\"$attribute>$2@$3</a>", $comment);
	}

	return $comment; //return parsed string

} //end of comment-parse-links function


function cmtx_comment_add_breaks ($comment) { //add line breaks

	$comment = trim($comment);

	$comment = preg_replace('/(\r\n){2,}/', "<p></p>", $comment); //replace instances of 2 or more \r\n with <p></p>

	$comment = preg_replace('/(\<br \/\>){2,}/', "<p></p>", $comment); //replace instances of 2 or more <br />s with  <p></p>

	$comment = str_ireplace("\r\n", "<br />", $comment); //replace remaining line breaks with <br />s

	return $comment; //return breaked string

} //end of comment-add-breaks function


function cmtx_comment_remove_breaks ($comment) { //remove line breaks

	$comment = trim($comment);

	$comment = preg_replace('/(\r\n){2,}/', " ", $comment); //replace instances of 2 or more \r\n with a space

	$comment = str_ireplace("\r\n", " ", $comment); //replace remaining line breaks with a space

	return $comment; //return non-breaked string

} //end of comment-remove-breaks function


function cmtx_comment_deny_long_words ($comment) { //deny very long words

	$long_word_found = false; //initialise flag as false

	$comment = str_ireplace("<br />", " ", $comment); //remove any <br /> tags
	$comment = str_ireplace("<p></p>", " ", $comment); //remove any <p></p> tags
	$comment = strip_tags($comment); //strip any tags

	$words = explode(" ", $comment); //get words into array

	foreach ($words as $word) { //for each word
		if (cmtx_strlen($word) >= cmtx_setting('long_word_length_to_deny')) { //if word length is longer than allowed word length
			$long_word_found = true; //set flag as true
		}
	}

	if ($long_word_found) { //if long word was entered
		cmtx_error(CMTX_ERROR_MESSAGE_LONG_WORD); //reject user for entering long word
	}

} //end of comment-deny-long-words function


function cmtx_comment_check_capitals ($comment) { //checks comment for too many capital letters

	if (cmtx_is_encoding_iso($comment)) { //if encoding is ISO-8859-1

		$comment = preg_replace('/[^a-z]/i', '', $comment); //remove non-letters

		$number_of_letters = cmtx_strlen($comment); //number of letters

		$number_of_capitals = cmtx_strlen(preg_replace('/[^A-Z]/', '', $comment)); //number of capitals

		if ($number_of_letters != 0 && $number_of_letters > 3 && $number_of_capitals != 0) { //if check is appropriate

			$percentage_of_capitals = ($number_of_capitals / $number_of_letters) * 100; //percentage of capitals

			if ($percentage_of_capitals >= cmtx_setting('check_capitals_percentage')) { //if too many capitals
				if (cmtx_setting('check_capitals_action') == "approve") { //if entering too many capitals should require approval
					cmtx_approve(CMTX_APPROVE_REASON_CAPITALS); //approve user for too many capitals
				} else if (cmtx_setting('check_capitals_action') == "reject") { //if entering too many capitals should be rejected
					cmtx_error(CMTX_ERROR_MESSAGE_CAPITALS); //reject user for too many capitals
				} else if (cmtx_setting('check_capitals_action') == "ban") { //if entering too many capitals should result in a ban
					cmtx_ban(CMTX_BAN_REASON_CAPITALS); //ban user for too many capitals
				}
			} //end of if-too-many-capitals

		}

	}

} //end of comment-check-capitals function


function cmtx_flood_control_delay() { //checks whether time since last comment is less than minimum delay

	global $cmtx_mysql_table_prefix, $cmtx_page_id; //globalise variables

	$ip_address = cmtx_get_ip_address();

	//get time/date of most recent comment (if any) by current user
	if (cmtx_setting('flood_control_delay_all_pages')) { //for all pages
		$query = mysql_query("SELECT `dated` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `ip_address` = '$ip_address' ORDER BY `dated` DESC LIMIT 1");
	} else { //for current page
		$query = mysql_query("SELECT `dated` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `ip_address` = '$ip_address' AND `page_id` = '$cmtx_page_id' ORDER BY `dated` DESC LIMIT 1");
	}

	if (mysql_num_rows($query)) { //if previous comment by current user was found

		$result = mysql_fetch_array($query);
		$time = strtotime($result['dated']);
		$difference = time() - $time;
		if ($difference < cmtx_setting('flood_control_delay_time')) { //if time since last comment is less than minimum allowed time
			cmtx_error(CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY); //reject user for consecutive comment
		}

	}

} //end of flood-control-delay function


function cmtx_flood_control_maximum() { //check amount of comments does not exceed set maximum within set period

	global $cmtx_mysql_table_prefix, $cmtx_page_id; //globalise variables

	$ip_address = cmtx_get_ip_address();

	$now = strtotime(date("Y-m-d H:i:s")); //get current time
	$earlier = $now - (3600 * cmtx_setting('flood_control_maximum_period')); //subtract time period from current time
	$earlier = date("Y-m-d H:is", $earlier); //convert to normal date

	//count number of comments (if any) within past period by current user
	if (cmtx_setting('flood_control_maximum_all_pages')) { //for all pages
		$query = mysql_query("SELECT COUNT(*) as `amount` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `ip_address` = '$ip_address' AND `dated` > '$earlier'");
	} else { //for current page
		$query = mysql_query("SELECT COUNT(*) as `amount` FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `ip_address` = '$ip_address' AND `page_id` = '$cmtx_page_id' AND `dated` > '$earlier'");
	}

	$result = mysql_fetch_array($query);
	$amount = $result['amount'];
	if ($amount >= cmtx_setting('flood_control_maximum_amount')) { //if comment amount exceeds allowed amount
		cmtx_error(CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM); //reject user for too many comments within past period
	}

} //end of flood-control-maximum function


function cmtx_check_if_banned() { //check if user is banned

	global $cmtx_mysql_table_prefix; //globalise variables

	$ip_address = cmtx_get_ip_address();

	$ban_found = false; //initialise flag as false

	if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "bans` WHERE `ip_address` = '$ip_address'"))) { //if user's IP address is found in 'bans' database table
		$ban_found = true; //set flag as true
	}

	if (isset($_COOKIE['Commentics-Ban']) && $_COOKIE['Commentics-Ban'] == "Banned") { //if a ban cookie is found
		$ban_found = true; //set flag as true
	}

	if ($ban_found) { //if a ban was found
		echo "<h3>Commentics</h3>";
		echo "<div style='margin-bottom: 10px;'></div>";
		die(CMTX_BAN_MESSAGE_BANNED_PREVIOUSLY); //end scripting and output message to user explaining they were previously banned
	}

} //end of check-if-banned function


function cmtx_ban ($reason) { //ban user

	global $cmtx_mysql_table_prefix, $cmtx_is_admin; //globalise variables

	$ip_address = cmtx_get_ip_address();

	$reason = cmtx_sanitize($reason, true, true);

	if (!$cmtx_is_admin) { //if not administrator

		//insert user's IP address into 'bans' database table
		mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "bans` (`ip_address`, `reason`, `dated`) VALUES ('$ip_address', '$reason', NOW())");

		@setcookie("Commentics-Ban", "Banned", (60 * 60 * 24 * cmtx_setting('ban_cookie_days')) + time(), '/'); //set ban cookie
		//time calculation: seconds * minutes * hours * days + current time

		cmtx_notify_admin_new_ban($reason); //notify admin of new ban

		echo "<h3>Commentics</h3>";
		echo "<div style='margin-bottom: 10px;'></div>";
		die(CMTX_BAN_MESSAGE_BANNED_NOW); //end scripting and output message to user explaining they are now banned

	}

} //end of ban function


function cmtx_error ($message) { //process error

	global $cmtx_error, $cmtx_error_message, $cmtx_error_total; //globalise variables

	$cmtx_error = true; //there is an error

	$cmtx_error_message .= "<li>" . $message . "</li>"; //concatenate to error message

	$cmtx_error_total ++; //accumulate total number of errors

} //end of error function


function cmtx_approve ($reason) { //process approval

	global $cmtx_approve, $cmtx_approve_reason; //globalise variables

	$cmtx_approve = true; //there is an approval

	$cmtx_approve_reason .= $reason . "\r\n"; //concatenate to approval reasoning

} //end of approve function
?>