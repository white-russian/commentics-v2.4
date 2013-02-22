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

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('language','language_backend','english');");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'language_frontend' WHERE title = 'language'");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'admin_new_flag_subject' WHERE title = 'admin_new_comment_flag_subject'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'admin_new_flag_from_name' WHERE title = 'admin_new_comment_flag_from_name'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'admin_new_flag_from_email' WHERE title = 'admin_new_comment_flag_from_email'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'admin_new_flag_reply_to' WHERE title = 'admin_new_comment_flag_reply_to'");
mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."admins` CHANGE receive_email_new_comment_flag receive_email_new_flag tinyint(1) unsigned NOT NULL default '1'");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'task_enabled_delete_bans' WHERE title = 'task_enabled_delete_old_bans'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'days_to_delete_bans' WHERE title = 'days_to_delete_old_bans'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'task_enabled_delete_reports' WHERE title = 'task_enabled_delete_old_reports'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'days_to_delete_reports' WHERE title = 'days_to_delete_old_reports'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'task_enabled_delete_voters' WHERE title = 'task_enabled_delete_old_voters'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'days_to_delete_voters' WHERE title = 'days_to_delete_old_voters'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'task_enabled_delete_comment_ips' WHERE title = 'task_enabled_delete_old_comment_ips'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'days_to_delete_comment_ips' WHERE title = 'days_to_delete_old_comment_ips'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'task_enabled_delete_unconfirmed_subscribers' WHERE title = 'task_enabled_delete_old_unconfirmed_subscribers'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'days_to_delete_unconfirmed_subscribers' WHERE title = 'days_to_delete_old_unconfirmed_subscribers'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'task_enabled_delete_inactive_subscribers' WHERE title = 'task_enabled_delete_old_inactive_subscribers'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'days_to_delete_inactive_subscribers' WHERE title = 'days_to_delete_old_inactive_subscribers'");

mysql_query("DELETE FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'stop_repeat_voting'");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('form','repeat_ratings','disable');");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'enabled_counter' WHERE title = 'enabled_comment_counter'");

mysql_query("DELETE FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'enabled_reply'");
mysql_query("DELETE FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'default_reply'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value='1,2,3,4,5,6' WHERE title = 'sort_order_fields'");

mysql_query("DELETE FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'anchor_process'");
mysql_query("DELETE FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'anchor_form'");
mysql_query("DELETE FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'anchor_reset'");
mysql_query("DELETE FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'anchor_comments'");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('security','hide_trap_bans','0');");

mysql_query("DELETE FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'form_cookie'");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'approve_comments' WHERE title = 'approve_all'");

mysql_query("DELETE FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'enabled_notifications'");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '0' WHERE title = 'enabled_social_technorati'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '0' WHERE title = 'enabled_social_reddit'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '0' WHERE title = 'enabled_social_myspace'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '0' WHERE title = 'enabled_social_linkedin'");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '1' WHERE title = 'js_vote_ok'");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '31' WHERE title = 'field_size_name'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '31' WHERE title = 'field_size_email'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '31' WHERE title = 'field_size_website'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '31' WHERE title = 'field_size_town'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '39' WHERE title = 'field_size_comment_columns'");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."questions` SET question = 'Enter the third letter of the word <i>castle</i>.' WHERE question = 'Enter the first, third and fourth letters of the word <i>castle</i>.'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."questions` SET answer = 's' WHERE answer = 'cst'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."questions` SET question = 'Enter the last letter of the word <i>satellite</i>.' WHERE question = 'Enter the second, third and fifth letters of the word <i>satellite</i>.'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."questions` SET answer = 'e' WHERE answer = 'atl'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."questions` SET question = 'Type the numbers for four hundred seventy-two.' WHERE question = 'Type the numbers for one thousand six hundred forty-two.'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."questions` SET answer = '472' WHERE answer = '1642'");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '0' WHERE title = 'enabled_smilies_confused'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '0' WHERE title = 'enabled_smilies_thumbsup'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '0' WHERE title = 'enabled_smilies_thumbdown'");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '0' WHERE title = 'check_capitals_enabled'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '0' WHERE title = 'check_repeats_enabled'");

if (mysql_errno()) {
echo mysql_errno() . ": " . mysql_error() . "<br />";
$error = true;
}

?>