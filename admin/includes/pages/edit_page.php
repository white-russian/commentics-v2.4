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

<h3><?php echo CMTX_TITLE_EDIT_PAGE ?></h3>
<hr class="title"/>

<?php
if (isset($_GET['id']) && ctype_digit($_GET['id']) && cmtx_record_exists($_GET['id'], "pages")) {
} else { ?>
<div class="error"><?php echo CMTX_MSG_RECORD_MISSING ?></div>
<div style="clear: left;"></div>
<a href="index.php?page=manage_pages"><?php echo CMTX_LINK_BACK ?></a>
<?php
die();
}
?>

<?php
if (isset($_POST['submit']) && $cmtx_settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

cmtx_check_csrf_form_key();

$id = $_GET['id'];
$page_id = $_POST['page_id'];
$reference = $_POST['reference'];
$url = $_POST['url'];
$form_enabled = $_POST['form_enabled'];

$id_san = cmtx_sanitize($id);
$page_id_san = cmtx_sanitize($page_id, true, true);
$reference_san = cmtx_sanitize($reference, true, true);
$url_san = cmtx_url_encode_spaces($url);
$url_san = cmtx_sanitize($url_san, true, true);
$form_enabled_san = cmtx_sanitize($form_enabled);

if (!empty($page_id) && mysql_num_rows(mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `page_id` = '$page_id_san' AND `id` != '$id_san'"))) {

?>
<div class="error"><?php echo CMTX_MSG_PAGE_EXISTS ?></div>
<div style="clear: left;"></div>
<?php

} else {

mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "pages` SET `page_id` = '$page_id_san' WHERE `id` = '$id_san'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "pages` SET `reference` = '$reference_san' WHERE `id` = '$id_san'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "pages` SET `url` = '$url_san' WHERE `id` = '$id_san'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "pages` SET `is_form_enabled` = '$form_enabled_san' WHERE `id` = '$id_san'");

?>
<div class="success"><?php echo CMTX_MSG_PAGE_UPDATED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<?php } ?>

<?php
$id = $_GET['id'];
$id_san = cmtx_sanitize($id);
$page_query = mysql_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "pages` WHERE `id` = '$id_san'");
$page_result = mysql_fetch_assoc($page_query);
$page_id = $page_result["page_id"];
$reference = $page_result["reference"];
$url = $page_result["url"];
$form_enabled = $page_result["is_form_enabled"];
$time = date("g:ia", strtotime($page_result["dated"]));
$date = date("jS M Y", strtotime($page_result["dated"]));
?>

<p />

<?php $cmtx_settings = new cmtx_settings; ?>

<form name="edit_page" id="edit_page" action="index.php?page=edit_page&id=<?php echo $id ?>" method="post">
<label class='edit_page'><?php echo CMTX_FIELD_LABEL_PAGE_ID ?></label> <input type="text" required name="page_id" size="30" maxlength="250" value="<?php echo $page_id; ?>"/>
<p />
<label class='edit_page'><?php echo CMTX_FIELD_LABEL_REFERENCE ?></label> <input type="text" required name="reference" size="30" maxlength="250" value="<?php echo $reference; ?>"/>
<p />
<label class='edit_page'><?php echo CMTX_FIELD_LABEL_URL ?></label> <input type="text" required name="url" size="45" maxlength="250" value="<?php echo $url; ?>"/>
<p />
<label class='edit_page'><?php echo CMTX_FIELD_LABEL_FORM_ENABLED ?></label>
<?php if ($form_enabled) { ?>
<select name='form_enabled'>
<option value='0'><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1' selected='selected'><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } else { ?>
<select name='form_enabled'>
<option value='0' selected='selected'><?php echo CMTX_FIELD_VALUE_NO ?></option>
<option value='1'><?php echo CMTX_FIELD_VALUE_YES ?></option>
</select>
<?php } ?>
<p />
<label class='edit_page'><?php echo CMTX_FIELD_LABEL_TIME ?></label> <input readonly="readonly" type="text" class="readonly" name="time" size="5" maxlength="250" value="<?php echo $time; ?>"/>
<p />
<label class='edit_page'><?php echo CMTX_FIELD_LABEL_DATE ?></label> <input readonly="readonly" type="text" class="readonly" name="date" size="12" maxlength="250" value="<?php echo $date; ?>"/>
<p />
<?php cmtx_set_csrf_form_key(); ?>
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
<input type="button" class="button" name="delete" onclick="if(delete_page_confirmation()){window.location='index.php?page=manage_pages&action=delete&id=<?php echo $id . "&key=" . $_SESSION['cmtx_csrf_key']?>'};" title="<?php echo CMTX_BUTTON_DELETE ?>" value="<?php echo CMTX_BUTTON_DELETE ?>"/>
</form>

<p />

<a href="index.php?page=manage_pages"><?php echo CMTX_LINK_BACK ?></a>