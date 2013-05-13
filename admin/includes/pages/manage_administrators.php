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

<h3><?php echo CMTX_TITLE_ADMINS; ?></h3>
<hr class="title"/>

<?php
$admin_id = cmtx_get_admin_id();
if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `is_super` = '1' AND `id` = '$admin_id'")) == 0) {
die("<p />" . CMTX_MSG_ADMIN_SUPER_ONLY);
}
?>

<?php
if (isset($_POST['submit']) && cmtx_setting('is_demo')) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO; ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

cmtx_check_csrf_form_key();

$username = $_POST['username'];
$password = md5($_POST['password_1']);
$email = $_POST['email'];

$is_unique = false;
	
while (!$is_unique) {

$cookie_key = cmtx_get_random_key(20);
		
if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `cookie_key` = '$cookie_key'")) == 0) {
	$is_unique = true;
}

}

$username = cmtx_sanitize($username);
$password = cmtx_sanitize($password);
$email = cmtx_sanitize($email);

if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `username` = '$username'"))) {

?>
<div class="error"><?php echo CMTX_MSG_ADMIN_EXISTS; ?></div>
<div style="clear: left;"></div>
<?php

} else {

mysql_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "admins` (`username`, `password`, `email`, `ip_address`, `cookie_key`, `detect_admin`, `detect_method`, `receive_email_new_ban`, `receive_email_new_comment_approve`, `receive_email_new_comment_okay`, `login_attempts`, `resets`, `last_login`, `restrict_pages`, `allowed_pages`, `is_super`, `is_enabled`, `dated`) VALUES ('$username', '$password', '$email', '', '$cookie_key', '1', 'both', '1', '1', '1', '0', '0', NOW(), '0', '', '0', '1', NOW());");
?>
<div class="success"><?php echo CMTX_MSG_ADMIN_ADDED; ?></div>
<div style="clear: left;"></div>
<?php } ?>

<?php } ?>

<?php
if (isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) && ctype_digit($_GET['id']) && cmtx_record_exists($_GET['id'], "admins") && cmtx_check_csrf_url_key()) {
if (cmtx_setting('is_demo')) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO; ?></div>
<div style="clear: left;"></div>
<?php
} else {
$id = $_GET['id'];
$id = cmtx_sanitize($id);
if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `is_super` = '1' AND `id` = '$id'"))) {
?>
<div class="error"><?php echo CMTX_MSG_ADMIN_SUPER_DELETE; ?></div>
<div style="clear: left;"></div>
<?php
} else {
mysql_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `id` = '$id'");
?>
<div class="success"><?php echo CMTX_MSG_ADMIN_DELETED; ?></div>
<div style="clear: left;"></div>
<?php } } } ?>

<?php
if (isset($_POST['bulk_delete']) && isset($_POST['bulk']) && cmtx_setting('is_demo')) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO; ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['bulk_delete']) && isset($_POST['bulk'])) {
cmtx_check_csrf_form_key();
$items = $_POST['bulk'];
$count = count($items);
$success = 0; $failure = 0;
for ($i = 0; $i < $count; $i++) {
	$id = $items[$i];
	$id = cmtx_sanitize($id);
	if (mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `is_super` = '1' AND `id` = '$id'"))) {
		$failure ++;
	} else {
		mysql_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "admins` WHERE `id` = '$id'");
		$success ++;
	}
}
?>
<?php if ($success == 1) { ?><div class="success"><?php echo CMTX_MSG_ADMIN_BULK_DELETED; ?></div><?php } ?>
<?php if ($success > 1) { ?><div class="success"><?php printf(CMTX_MSG_ADMINS_BULK_DELETED, $success); ?></div><?php } ?>
<div style="clear: left;"></div>
<?php if ($failure == 1) { ?><div class="error"><?php echo CMTX_MSG_ADMIN_BULK_SUPER_DELETE; ?></div><?php } ?>
<?php if ($failure > 1) { ?><div class="error"><?php printf(CMTX_MSG_ADMINS_BULK_SUPER_DELETE, $failure); ?></div><?php } ?>
<div style="clear: left;"></div>
<?php
}
?>

<p />

<form name="administrator" id="administrator" action="index.php?page=manage_administrators" method="post" onsubmit="return check_passwords()">
<?php echo CMTX_FIELD_LABEL_USERNAME; ?> <input type="text" required name="username" size="12" maxlength="250"/>&nbsp;
<?php echo CMTX_FIELD_LABEL_PASSWORD; ?> <input type="password" required name="password_1" size="20" maxlength="250"/>&nbsp;
<?php echo CMTX_FIELD_LABEL_REPEAT; ?> <input type="password" required name="password_2" size="20" maxlength="250"/>&nbsp;
<?php echo CMTX_FIELD_LABEL_EMAIL; ?> <input type="email" required name="email" size="30" maxlength="250"/>&nbsp;
<?php cmtx_set_csrf_form_key(); ?>
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_ADD_ADMIN; ?>" value="<?php echo CMTX_BUTTON_ADD_ADMIN; ?>"/>
</form>

<br />

<form name="datatables" id="datatables" action="index.php?page=manage_administrators" method="post">

<table id="data" class="display" summary="Administrators">
    <thead>
    	<tr>
			<th style='width:0px;'><input type="checkbox" name="select_all" id="select_all" onclick="bulk_select();"/></th>
			<th><?php echo CMTX_TABLE_USERNAME; ?></th>
            <th><?php echo CMTX_TABLE_EMAIL; ?></th>
			<th><?php echo CMTX_TABLE_ENABLED; ?></th>
			<th><?php echo CMTX_TABLE_SUPER_ADMIN; ?></th>
			<th><?php echo CMTX_TABLE_LAST_LOGIN; ?></th>
            <th><?php echo CMTX_TABLE_DATE_TIME; ?></th>
            <th><?php echo CMTX_TABLE_ACTION; ?></th>
        </tr>
    </thead>
    <tbody>

<?php
$administrators = mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "admins` ORDER BY `id` ASC");
while ($administrator = mysql_fetch_assoc($administrators)) {
?>
    	<tr>
			<td><input type="checkbox" name="bulk[]" value="<?php echo $administrator["id"]; ?>" onclick="bulk_check();"/></td>
        	<td><?php echo cmtx_sanitize($administrator["username"], true, false); ?></td>
            <td><?php echo $administrator["email"]; ?></td>
			<td><?php if ($administrator["is_enabled"]) { echo CMTX_TABLE_YES; } else { echo CMTX_TABLE_NO; } ?></td>
			<td><?php if ($administrator["is_super"]) { echo CMTX_TABLE_YES; } else { echo CMTX_TABLE_NO; } ?></td>
			<td><span style="display:none;"><?php echo date("YmdHis", strtotime($administrator["last_login"])); ?></span><?php echo date("jS F Y g:ia", strtotime($administrator["last_login"])); ?></td>
			<td><span style="display:none;"><?php echo date("YmdHis", strtotime($administrator["dated"])); ?></span><?php echo date("jS F Y g:ia", strtotime($administrator["dated"])); ?></td>
			<td>
			<a href="<?php echo "index.php?page=edit_administrator&id=" . $administrator["id"];?>"><img src="images/buttons/edit.png" class="button_edit" title="Edit" alt="Edit"></a>
			<a href="<?php echo "index.php?page=manage_administrators&action=delete&id=" . $administrator["id"] . "&key=" . $_SESSION['cmtx_csrf_key'];?>"><img src="images/buttons/delete.png" class="button_delete" onclick="return delete_confirmation()" title="Delete" alt="Delete"></a>
			</td>
        </tr>	
<?php } ?>

    </tbody>
</table>

<div style="clear: left;"></div>

<div style="margin-top:10px;"></div>

<?php cmtx_set_csrf_form_key(); ?>
<input type="submit" class="button" name="bulk_delete" title="<?php echo CMTX_BUTTON_DELETE; ?>" value="<?php echo CMTX_BUTTON_DELETE; ?>" onclick="return delete_bulk_confirmation()"/>
</form>