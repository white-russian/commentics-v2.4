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
?>

<div class='page_help_block'>
<a class='page_help_text' href="http://www.commentics.org/wiki/doku.php?id=admin:<?php echo $_GET['page']; ?>" target="_blank"><?php echo CMTX_LINK_HELP ?></a>
</div>

<h3><?php echo CMTX_TITLE_EMAIL_NEW_FLAG ?></h3>
<hr class="title"/>

<?php
if (isset($_POST['submit']) && $cmtx_settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

cmtx_check_csrf_form_key();

$admin_new_flag_subject = $_POST['admin_new_flag_subject'];
$admin_new_flag_from_name = $_POST['admin_new_flag_from_name'];
$admin_new_flag_from_email = $_POST['admin_new_flag_from_email'];
$admin_new_flag_reply_to = $_POST['admin_new_flag_reply_to'];
$email_content = $_POST['email_content'];

$admin_new_flag_subject_san = cmtx_sanitize($admin_new_flag_subject);
$admin_new_flag_from_name_san = cmtx_sanitize($admin_new_flag_from_name);
$admin_new_flag_from_email_san = cmtx_sanitize($admin_new_flag_from_email);
$admin_new_flag_reply_to_san = cmtx_sanitize($admin_new_flag_reply_to);

mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$admin_new_flag_subject_san' WHERE `title` = 'admin_new_flag_subject'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$admin_new_flag_from_name_san' WHERE `title` = 'admin_new_flag_from_name'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$admin_new_flag_from_email_san' WHERE `title` = 'admin_new_flag_from_email'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$admin_new_flag_reply_to_san' WHERE `title` = 'admin_new_flag_reply_to'");

$file = "../includes/emails/" . $cmtx_settings->language_frontend . "/admin/new_flag.txt";
$handle = fopen($file,"w");
fputs($handle, $email_content);
fclose($handle);
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_EMAIL_NEW_FLAG ?>

<?php
$data = file_get_contents("../includes/emails/" . $cmtx_settings->language_frontend . "/admin/new_flag.txt");
?>

<p />

<?php $cmtx_settings = new cmtx_settings; ?>

<form name="settings_email_editor_admin_new_flag" id="settings_email_editor_admin_new_flag" action="index.php?page=settings_email_editor_admin_new_flag" method="post">
<label class='settings_email_editor_admin_new_flag'><?php echo CMTX_FIELD_LABEL_SUBJECT ?></label> <input type="text" required name="admin_new_flag_subject" size="35" maxlength="250" value="<?php echo $cmtx_settings->admin_new_flag_subject; ?>"/>
<p />
<label class='settings_email_editor_admin_new_flag'><?php echo CMTX_FIELD_LABEL_FROM_NAME ?></label> <input type="text" required name="admin_new_flag_from_name" size="20" maxlength="250" value="<?php echo $cmtx_settings->admin_new_flag_from_name; ?>"/>
<p />
<label class='settings_email_editor_admin_new_flag'><?php echo CMTX_FIELD_LABEL_FROM_EMAIL ?></label> <input type="email" required name="admin_new_flag_from_email" size="35" maxlength="250" value="<?php echo $cmtx_settings->admin_new_flag_from_email; ?>"/>
<p />
<label class='settings_email_editor_admin_new_flag'><?php echo CMTX_FIELD_LABEL_REPLY_EMAIL ?></label> <input type="email" required name="admin_new_flag_reply_to" size="35" maxlength="250" value="<?php echo $cmtx_settings->admin_new_flag_reply_to; ?>"/>
<p /><br />
<b><?php echo CMTX_FIELD_VALUE_VARIABLES ?></b>: <i> [page reference] [page url] [poster] [comment] [admin link] </i>
<textarea name="email_content" cols="" rows="10" style="width:100%"><?php echo $data; ?></textarea>
<p />
<?php cmtx_set_csrf_form_key(); ?>
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>