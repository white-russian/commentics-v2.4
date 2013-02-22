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

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_page_number' WHERE title = 'show_comments_info'");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('comments','show_comment_count','1');");

$gravatar_default = mysql_query("SELECT * FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'gravatar_default'");
$gravatar_default = mysql_fetch_assoc($gravatar_default);
$gravatar_default = $gravatar_default["value"];
if ($gravatar_default == "") {
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = 'default' WHERE title = 'gravatar_default'");
}

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('comments','gravatar_size','70');");

mysql_query("DELETE FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'field_size_captcha'");
mysql_query("DELETE FROM `".$cmtx_mysql_table_prefix."settings` WHERE title = 'field_maximum_captcha'");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('form','recaptcha_public_key','');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('form','recaptcha_private_key','');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('form','recaptcha_theme','white');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('form','recaptcha_language','en');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('notice','notice_field_size_css','1');");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'comments_order' WHERE title = 'newest_first'");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('form','hide_form','0');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('form','enabled_remember','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('form','default_remember','0');");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '0' WHERE title = 'default_notify'");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('order','sort_order_captchas','1,2');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('order','sort_order_checkboxes','1,2,3,4');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('system','check_comments_url','1');");

mysql_query("ALTER TABLE `".$cmtx_mysql_table_prefix."pages` CHANGE custom_id page_id varchar(250) NOT NULL default ''");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('system','delay_pages','0');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','form_cookie','0');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('processor','form_cookie_days','365');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('system','admin_cookie_days','365');");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'ban_cookie_days' WHERE title = 'banning_cookie_days'");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('comments','show_topic','1');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('comments','rich_snippets_markup','Microformats');");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_gravatar' WHERE title = 'enabled_gravatar'");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_social' WHERE title = 'enabled_social'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_social_facebook' WHERE title = 'enabled_social_facebook'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_social_delicious' WHERE title = 'enabled_social_delicious'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_social_stumbleupon' WHERE title = 'enabled_social_stumbleupon'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_social_digg' WHERE title = 'enabled_social_digg'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_social_technorati' WHERE title = 'enabled_social_technorati'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_social_google' WHERE title = 'enabled_social_google'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_social_reddit' WHERE title = 'enabled_social_reddit'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_social_myspace' WHERE title = 'enabled_social_myspace'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_social_twitter' WHERE title = 'enabled_social_twitter'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_social_linkedin' WHERE title = 'enabled_social_linkedin'");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_sort_by' WHERE title = 'enabled_sort_by'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_sort_by_1' WHERE title = 'enabled_sort_by_1'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_sort_by_2' WHERE title = 'enabled_sort_by_2'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_sort_by_3' WHERE title = 'enabled_sort_by_3'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_sort_by_4' WHERE title = 'enabled_sort_by_4'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_sort_by_5' WHERE title = 'enabled_sort_by_5'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET title = 'show_sort_by_6' WHERE title = 'enabled_sort_by_6'");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('comments','show_read_more','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('comments','read_more_limit','500');");

mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('tasks','task_enabled_reactivate_inactive_subscribers','1');");
mysql_query("INSERT INTO `".$cmtx_mysql_table_prefix."settings` (category, title, value) VALUES ('tasks','days_to_reactivate_inactive_subscribers','3');");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '2' WHERE title = 'comment_minimum_characters'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '1' WHERE title = 'comment_minimum_words'");

mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '60' WHERE title = 'flood_control_delay_time'");
mysql_query("UPDATE `".$cmtx_mysql_table_prefix."settings` SET value = '5' WHERE title = 'flood_control_maximum_amount'");

if (mysql_errno()) {
echo mysql_errno() . ": " . mysql_error() . "<br />";
$error = true;
}

?>