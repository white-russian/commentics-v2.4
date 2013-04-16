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

<h3><?php echo CMTX_TITLE_FORM_SIZES_MAXIMUMS; ?></h3>
<hr class="title"/>

<?php
if (isset($_GET['notice']) && $_GET['notice'] == "dismiss" && cmtx_check_csrf_url_key()) {
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '0' WHERE `title` = 'notice_layout_form_sizes_maximums'");
} else {
if (cmtx_setting('notice_layout_form_sizes_maximums')) { ?>
<div class="info"><?php echo CMTX_MSG_NOTICE_LAYOUT_FORM_SIZES_MAXIMUMS . " <a href='index.php?page=layout_form_sizes_maximums&notice=dismiss&key=" . $_SESSION['cmtx_csrf_key'] . "'>" . CMTX_LINK_DISMISS . "</a>"; ?></div>
<div style="clear: left;"></div>
<?php } } ?>

<?php
if (isset($_POST['submit']) && cmtx_setting('is_demo')) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO; ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

cmtx_check_csrf_form_key();

$field_size_name = $_POST['field_size_name'];
$field_size_email = $_POST['field_size_email'];
$field_size_website = $_POST['field_size_website'];
$field_size_town = $_POST['field_size_town'];
$field_size_comment_columns = $_POST['field_size_comment_columns'];
$field_size_comment_rows = $_POST['field_size_comment_rows'];
$field_size_question = $_POST['field_size_question'];

$field_maximum_name = $_POST['field_maximum_name'];
$field_maximum_email = $_POST['field_maximum_email'];
$field_maximum_website = $_POST['field_maximum_website'];
$field_maximum_town = $_POST['field_maximum_town'];
$comment_maximum_characters = $_POST['comment_maximum_characters'];
$field_maximum_question = $_POST['field_maximum_question'];

$field_size_name_san = cmtx_sanitize($field_size_name);
$field_size_email_san = cmtx_sanitize($field_size_email);
$field_size_website_san = cmtx_sanitize($field_size_website);
$field_size_town_san = cmtx_sanitize($field_size_town);
$field_size_comment_columns_san = cmtx_sanitize($field_size_comment_columns);
$field_size_comment_rows_san = cmtx_sanitize($field_size_comment_rows);
$field_size_question_san = cmtx_sanitize($field_size_question);

$field_maximum_name_san = cmtx_sanitize($field_maximum_name);
$field_maximum_email_san = cmtx_sanitize($field_maximum_email);
$field_maximum_website_san = cmtx_sanitize($field_maximum_website);
$field_maximum_town_san = cmtx_sanitize($field_maximum_town);
$comment_maximum_characters_san = cmtx_sanitize($comment_maximum_characters);
$field_maximum_question_san = cmtx_sanitize($field_maximum_question);

mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$field_size_name_san' WHERE `title` = 'field_size_name'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$field_size_email_san' WHERE `title` = 'field_size_email'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$field_size_website_san' WHERE `title` = 'field_size_website'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$field_size_town_san' WHERE `title` = 'field_size_town'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$field_size_comment_columns_san' WHERE `title` = 'field_size_comment_columns'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$field_size_comment_rows_san' WHERE `title` = 'field_size_comment_rows'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$field_size_question_san' WHERE `title` = 'field_size_question'");

mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$field_maximum_name_san' WHERE `title` = 'field_maximum_name'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$field_maximum_email_san' WHERE `title` = 'field_maximum_email'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$field_maximum_website_san' WHERE `title` = 'field_maximum_website'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$field_maximum_town_san' WHERE `title` = 'field_maximum_town'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$comment_maximum_characters_san' WHERE `title` = 'comment_maximum_characters'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$field_maximum_question_san' WHERE `title` = 'field_maximum_question'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED; ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_FORM_SIZES_MAXIMUMS; ?>

<p />

<form name="layout_form_sizes_maximums" id="layout_form_sizes_maximums" action="index.php?page=layout_form_sizes_maximums" method="post">
<b><?php echo rtrim(CMTX_FIELD_LABEL_NAME, ':') ?></b> <?php echo CMTX_FIELD_VALUE_SIZE_FIELD; ?> <input type="text" required name="field_size_name" size="1" maxlength="250" value="<?php echo cmtx_setting('field_size_name'); ?>"/> <?php echo CMTX_FIELD_VALUE_WITH_MAX; ?> <input type="text" required name="field_maximum_name" size="1" maxlength="250" value="<?php echo cmtx_setting('field_maximum_name'); ?>"/> <?php echo CMTX_FIELD_VALUE_CHARACTERS . "." ?>
<p />
<b><?php echo rtrim(CMTX_FIELD_LABEL_EMAIL, ':') ?></b> <?php echo CMTX_FIELD_VALUE_SIZE_FIELD; ?> <input type="text" required name="field_size_email" size="1" maxlength="250" value="<?php echo cmtx_setting('field_size_email'); ?>"/> <?php echo CMTX_FIELD_VALUE_WITH_MAX; ?> <input type="text" required name="field_maximum_email" size="1" maxlength="250" value="<?php echo cmtx_setting('field_maximum_email'); ?>"/> <?php echo CMTX_FIELD_VALUE_CHARACTERS . "." ?>
<p />
<b><?php echo rtrim(CMTX_FIELD_LABEL_WEBSITE, ':') ?></b> <?php echo CMTX_FIELD_VALUE_SIZE_FIELD; ?> <input type="text" required name="field_size_website" size="1" maxlength="250" value="<?php echo cmtx_setting('field_size_website'); ?>"/> <?php echo CMTX_FIELD_VALUE_WITH_MAX; ?> <input type="text" required name="field_maximum_website" size="1" maxlength="250" value="<?php echo cmtx_setting('field_maximum_website'); ?>"/> <?php echo CMTX_FIELD_VALUE_CHARACTERS . "." ?>
<p />
<b><?php echo rtrim(CMTX_FIELD_LABEL_TOWN, ':') ?></b> <?php echo CMTX_FIELD_VALUE_SIZE_FIELD; ?> <input type="text" required name="field_size_town" size="1" maxlength="250" value="<?php echo cmtx_setting('field_size_town'); ?>"/> <?php echo CMTX_FIELD_VALUE_WITH_MAX; ?> <input type="text" required name="field_maximum_town" size="1" maxlength="250" value="<?php echo cmtx_setting('field_maximum_town'); ?>"/> <?php echo CMTX_FIELD_VALUE_CHARACTERS . "." ?>
<p />
<b><?php echo rtrim(CMTX_FIELD_LABEL_COMMENT, ':') ?></b> <?php echo CMTX_FIELD_VALUE_SIZE_COLUMN; ?> <input type="text" required name="field_size_comment_columns" size="1" maxlength="250" value="<?php echo cmtx_setting('field_size_comment_columns'); ?>"/> <?php echo CMTX_FIELD_VALUE_SIZE_ROW; ?> <input type="text" required name="field_size_comment_rows" size="1" maxlength="250" value="<?php echo cmtx_setting('field_size_comment_rows'); ?>"/> <?php echo CMTX_FIELD_VALUE_WITH_MAX; ?> <input type="text" required name="comment_maximum_characters" size="1" maxlength="250" value="<?php echo cmtx_setting('comment_maximum_characters'); ?>"/> <?php echo CMTX_FIELD_VALUE_CHARACTERS . "." ?>
<p />
<b><?php echo rtrim(CMTX_FIELD_LABEL_QUESTION, ':') ?></b> <?php echo CMTX_FIELD_VALUE_SIZE_FIELD; ?> <input type="text" required name="field_size_question" size="1" maxlength="250" value="<?php echo cmtx_setting('field_size_question'); ?>"/> <?php echo CMTX_FIELD_VALUE_WITH_MAX; ?> <input type="text" required name="field_maximum_question" size="1" maxlength="250" value="<?php echo cmtx_setting('field_maximum_question'); ?>"/> <?php echo CMTX_FIELD_VALUE_CHARACTERS . "." ?>
<p />
<?php cmtx_set_csrf_form_key(); ?>
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE; ?>" value="<?php echo CMTX_BUTTON_UPDATE; ?>"/>
</form>