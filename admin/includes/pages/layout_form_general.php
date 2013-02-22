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

<h3><?php echo CMTX_TITLE_FORM_GENERAL ?></h3>
<hr class="title"/>

<?php
if (isset($_POST['submit']) && $cmtx_settings->is_demo) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

cmtx_check_csrf_form_key();

if (isset($_POST['display_javascript_disabled'])) { $display_javascript_disabled = 1; } else { $display_javascript_disabled = 0; }
if (isset($_POST['display_required_symbol'])) { $display_required_symbol = 1; } else { $display_required_symbol = 0; }
if (isset($_POST['display_required_symbol_message'])) { $display_required_symbol_message = 1; } else { $display_required_symbol_message = 0; }
if (isset($_POST['display_email_note'])) { $display_email_note = 1; } else { $display_email_note = 0; }
if (isset($_POST['hide_form'])) { $hide_form = 1; } else { $hide_form = 0; }
if (isset($_POST['form_cookie'])) { $form_cookie = 1; } else { $form_cookie = 0; }
$form_cookie_days = $_POST['form_cookie_days'];
$repeat_ratings = $_POST['repeat_ratings'];
if (isset($_POST['agree_to_preview'])) { $agree_to_preview = 1; } else { $agree_to_preview = 0; }

$form_cookie_days_san = cmtx_sanitize($form_cookie_days);
$repeat_ratings_san = cmtx_sanitize($repeat_ratings);

mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$display_javascript_disabled' WHERE `title` = 'display_javascript_disabled'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$display_required_symbol' WHERE `title` = 'display_required_symbol'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$display_required_symbol_message' WHERE `title` = 'display_required_symbol_message'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$display_email_note' WHERE `title` = 'display_email_note'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$hide_form' WHERE `title` = 'hide_form'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$form_cookie' WHERE `title` = 'form_cookie'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$form_cookie_days_san' WHERE `title` = 'form_cookie_days'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$repeat_ratings_san' WHERE `title` = 'repeat_ratings'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$agree_to_preview' WHERE `title` = 'agree_to_preview'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_LAYOUT_FORM_GENERAL ?>

<p />

<?php $cmtx_settings = new cmtx_settings; ?>

<form name="layout_form_general" id="layout_form_general" action="index.php?page=layout_form_general" method="post">
<label class='layout_form_general'><?php echo CMTX_FIELD_LABEL_DISPLAY_JS_MSG ?></label> <?php if ($cmtx_settings->display_javascript_disabled) { ?> <input type="checkbox" checked="checked" name="display_javascript_disabled"/> <?php } else { ?> <input type="checkbox" name="display_javascript_disabled"/> <?php } ?>
<?php cmtx_generate_hint(CMTX_HINT_DISPLAY_JS_MSG); ?>
<p />
<label class='layout_form_general'><?php echo CMTX_FIELD_LABEL_DISPLAY_AST_SYMBOL ?></label> <?php if ($cmtx_settings->display_required_symbol) { ?> <input type="checkbox" checked="checked" name="display_required_symbol"/> <?php } else { ?> <input type="checkbox" name="display_required_symbol"/> <?php } ?>
<?php cmtx_generate_hint(CMTX_HINT_DISPLAY_AST_SYMBOL); ?>
<p />
<label class='layout_form_general'><?php echo CMTX_FIELD_LABEL_DISPLAY_AST_MSG ?></label> <?php if ($cmtx_settings->display_required_symbol_message) { ?> <input type="checkbox" checked="checked" name="display_required_symbol_message"/> <?php } else { ?> <input type="checkbox" name="display_required_symbol_message"/> <?php } ?>
<?php cmtx_generate_hint(CMTX_HINT_DISPLAY_AST_MSG); ?>
<p />
<label class='layout_form_general'><?php echo CMTX_FIELD_LABEL_DISPLAY_EMAIL_NOTE ?></label> <?php if ($cmtx_settings->display_email_note) { ?> <input type="checkbox" checked="checked" name="display_email_note"/> <?php } else { ?> <input type="checkbox" name="display_email_note"/> <?php } ?>
<?php cmtx_generate_hint(CMTX_HINT_DISPLAY_EMAIL_NOTE); ?>
<p />
<label class='layout_form_general'><?php echo CMTX_FIELD_LABEL_HIDE_FORM ?></label> <?php if ($cmtx_settings->hide_form) { ?> <input type="checkbox" checked="checked" name="hide_form"/> <?php } else { ?> <input type="checkbox" name="hide_form"/> <?php } ?>
<?php cmtx_generate_hint(CMTX_HINT_HIDE_FORM); ?>
<p />
<label class='layout_form_general'><?php echo CMTX_FIELD_LABEL_FORM_COOKIE ?></label> <?php if ($cmtx_settings->form_cookie) { ?> <input type="checkbox" checked="checked" name="form_cookie"/> <?php } else { ?> <input type="checkbox" name="form_cookie"/> <?php } ?>
<?php cmtx_generate_hint(CMTX_HINT_FORM_COOKIE); ?>
<p />
<label class='layout_form_general'><?php echo CMTX_FIELD_LABEL_FORM_COOKIE_DAYS ?></label> <input type="text" required name="form_cookie_days" size="1" maxlength="3" value="<?php echo $cmtx_settings->form_cookie_days; ?>"/> <span class='note'><?php echo CMTX_NOTE_DAYS ?></span>
<?php cmtx_generate_hint(CMTX_HINT_FORM_COOKIE_DAYS); ?>
<p />
<label class='layout_form_general'><?php echo CMTX_FIELD_LABEL_REPEAT_RATINGS ?></label>
<select name='repeat_ratings'>
<?php if ($cmtx_settings->repeat_ratings == "allow") { ?>
<option value='allow' selected='selected'><?php echo CMTX_FIELD_VALUE_ALLOW ?></option>
<option value='disable'><?php echo CMTX_FIELD_VALUE_DISABLE ?></option>
<option value='hide'><?php echo CMTX_FIELD_VALUE_HIDE ?></option>
<?php } else if ($cmtx_settings->repeat_ratings == "disable") { ?>
<option value='allow'><?php echo CMTX_FIELD_VALUE_ALLOW ?></option>
<option value='disable' selected='selected'><?php echo CMTX_FIELD_VALUE_DISABLE ?></option>
<option value='hide'><?php echo CMTX_FIELD_VALUE_HIDE ?></option>
<?php } else { ?>
<option value='allow'><?php echo CMTX_FIELD_VALUE_ALLOW ?></option>
<option value='disable'><?php echo CMTX_FIELD_VALUE_DISABLE ?></option>
<option value='hide' selected='selected'><?php echo CMTX_FIELD_VALUE_HIDE ?></option>
<?php } ?>
</select>
<?php cmtx_generate_hint(CMTX_HINT_REPEAT_RATINGS); ?>
<p />
<label class='layout_form_general'><?php echo CMTX_FIELD_LABEL_AGREE_TO_PREVIEW ?></label> <?php if ($cmtx_settings->agree_to_preview) { ?> <input type="checkbox" checked="checked" name="agree_to_preview"/> <?php } else { ?> <input type="checkbox" name="agree_to_preview"/> <?php } ?>
<?php cmtx_generate_hint(CMTX_HINT_AGREE_TO_PREVIEW); ?>
<p />
<?php cmtx_set_csrf_form_key(); ?>
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE ?>" value="<?php echo CMTX_BUTTON_UPDATE ?>"/>
</form>