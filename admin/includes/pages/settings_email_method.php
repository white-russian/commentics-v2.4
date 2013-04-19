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
?>

<div class='page_help_block'>
<a class='page_help_text' href="http://www.commentics.org/wiki/doku.php?id=admin:<?php echo $_GET['page']; ?>" target="_blank"><?php echo CMTX_LINK_HELP; ?></a>
</div>

<h3><?php echo CMTX_TITLE_EMAIL_METHOD; ?></h3>
<hr class="title"/>

<?php
if (isset($_POST['submit']) && cmtx_setting('is_demo')) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO; ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

cmtx_check_csrf_form_key();

$transport_method = $_POST['transport_method'];
$smtp_host = $_POST['smtp_host'];
$smtp_port = $_POST['smtp_port'];
$smtp_encrypt = $_POST['smtp_encrypt'];
if (isset($_POST['smtp_auth'])) { $smtp_auth = 1; } else { $smtp_auth = 0; }
$smtp_username = $_POST['smtp_username'];
$smtp_password = $_POST['smtp_password'];
$sendmail_path = $_POST['sendmail_path'];

$transport_method_san = cmtx_sanitize($transport_method);
$smtp_host_san = cmtx_sanitize($smtp_host);
$smtp_port_san = cmtx_sanitize($smtp_port);
$smtp_encrypt_san = cmtx_sanitize($smtp_encrypt);
$smtp_username_san = cmtx_sanitize($smtp_username);
$smtp_password_san = cmtx_sanitize($smtp_password);
$sendmail_path_san = cmtx_sanitize($sendmail_path);

mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$transport_method_san' WHERE `title` = 'transport_method'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$smtp_host_san' WHERE `title` = 'smtp_host'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$smtp_port_san' WHERE `title` = 'smtp_port'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$smtp_encrypt_san' WHERE `title` = 'smtp_encrypt'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$smtp_auth' WHERE `title` = 'smtp_auth'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$smtp_username_san' WHERE `title` = 'smtp_username'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$smtp_password_san' WHERE `title` = 'smtp_password'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$sendmail_path_san' WHERE `title` = 'sendmail_path'");

if (isset($_POST['method_test'])) {
	$admin_method_test_email_file = '../includes/emails/' . cmtx_setting('language_frontend') . '/admin/method_test.txt'; //build path to admin method test email file
	$body = file_get_contents($admin_method_test_email_file); //get the file's contents
	$admin_id = cmtx_get_admin_id();
	$administrator = mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `id` = '$admin_id'");
	$administrator = mysql_fetch_assoc($administrator);
	$email = $administrator["email"];
	cmtx_email($email, null, cmtx_setting('admin_method_test_subject'), $body, cmtx_setting('admin_method_test_from_email'), cmtx_setting('admin_method_test_from_name'), cmtx_setting('admin_method_test_reply_to'));
}
?>
<div class="success"><?php echo CMTX_MSG_SAVED; ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_EMAIL_METHOD; ?>

<p />

<form name="settings_email_method" id="settings_email_method" action="index.php?page=settings_email_method" method="post">
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_METHOD; ?></label> <?php if (cmtx_setting('transport_method') == "php-basic") { ?> <input type="radio" checked="checked" name="transport_method" value="php-basic" onclick="show_hide('php');"/> <?php } else { ?> <input type="radio" name="transport_method" value="php-basic" onclick="show_hide('php');"/> <?php } ?> PHP (Basic)
<br />
<label class='settings_email_method'>&nbsp;</label> <?php if (cmtx_setting('transport_method') == "php") { ?> <input type="radio" checked="checked" name="transport_method" value="php" onclick="show_hide('php');"/> <?php } else { ?> <input type="radio" name="transport_method" value="php" onclick="show_hide('php');"/> <?php } ?> PHP (Swift) &nbsp;<span class="note"><?php echo CMTX_NOTE_TYPICAL; ?></span>
<br />
<label class='settings_email_method'>&nbsp;</label> <?php if (cmtx_setting('transport_method') == "smtp") { ?> <input type="radio" checked="checked" name="transport_method" value="smtp" onclick="show_hide('smtp');"/> <?php } else { ?> <input type="radio" name="transport_method" value="smtp" onclick="show_hide('smtp');"/> <?php } ?> SMTP (Swift)
<br />
<label class='settings_email_method'>&nbsp;</label> <?php if (cmtx_setting('transport_method') == "sendmail") { ?> <input type="radio" checked="checked" name="transport_method" value="sendmail" onclick="show_hide('sendmail');"/> <?php } else { ?> <input type="radio" name="transport_method" value="sendmail" onclick="show_hide('sendmail');"/> <?php } ?> Sendmail (Swift)
<div id="smtp" <?php if (cmtx_setting('transport_method') != "smtp") { echo "style='display:none;'"; } ?> >
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_SMTP_HOST; ?></label> <input type="text" required name="smtp_host" size="20" maxlength="250" value="<?php echo cmtx_setting('smtp_host'); ?>"/>
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_SMTP_PORT; ?></label> <input type="text" required name="smtp_port" size="1" maxlength="250" value="<?php echo cmtx_setting('smtp_port'); ?>"/>
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_SMTP_ENCRYPT; ?></label>
<select name='smtp_encrypt'>
<?php if (cmtx_setting('smtp_encrypt') == "off") { ?>
<option value='off' selected='selected'><?php echo CMTX_FIELD_VALUE_OFF; ?></option>
<option value='ssl'><?php echo CMTX_FIELD_VALUE_SSL; ?></option>
<option value='tls'><?php echo CMTX_FIELD_VALUE_TLS; ?></option>
<?php } else if (cmtx_setting('smtp_encrypt') == "ssl") { ?>
<option value='off'><?php echo CMTX_FIELD_VALUE_OFF; ?></option>
<option value='ssl' selected='selected'><?php echo CMTX_FIELD_VALUE_SSL; ?></option>
<option value='tls'><?php echo CMTX_FIELD_VALUE_TLS; ?></option>
<?php } else { ?>
<option value='off'><?php echo CMTX_FIELD_VALUE_OFF; ?></option>
<option value='ssl'><?php echo CMTX_FIELD_VALUE_SSL; ?></option>
<option value='tls' selected='selected'><?php echo CMTX_FIELD_VALUE_TLS; ?></option>
<?php } ?>
</select>
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_SMTP_AUTH; ?></label> <?php if (cmtx_setting('smtp_auth')) { ?> <input type="checkbox" checked="checked" name="smtp_auth"/> <?php } else { ?> <input type="checkbox" name="smtp_auth"/> <?php } ?>
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_USER; ?></label> <input type="text" name="smtp_username" size="20" maxlength="250" value="<?php echo cmtx_setting('smtp_username'); ?>"/>
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_PASS; ?></label> <input type="password" name="smtp_password" size="20" maxlength="250" value="<?php echo cmtx_setting('smtp_password'); ?>"/>
</div>
<div id="sendmail" <?php if (cmtx_setting('transport_method') != "sendmail") { echo "style='display:none;'"; } ?> >
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_SENDMAIL_PATH; ?></label> <input type="text" required name="sendmail_path" size="20" maxlength="250" value="<?php echo cmtx_setting('sendmail_path'); ?>"/>
</div>
<p />
<label class='settings_email_method'><?php echo CMTX_FIELD_LABEL_TEST; ?></label> <input type="checkbox" name="method_test"/> <?php echo CMTX_FIELD_VALUE_METHOD_TEST; ?>
<p />
<?php cmtx_set_csrf_form_key(); ?>
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE; ?>" value="<?php echo CMTX_BUTTON_UPDATE; ?>"/>
</form>