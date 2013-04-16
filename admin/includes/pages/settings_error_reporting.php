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

<h3><?php echo CMTX_TITLE_ERROR_REPORTING; ?></h3>
<hr class="title"/>

<?php
if (isset($_POST['submit']) && cmtx_setting('is_demo')) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO; ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

cmtx_check_csrf_form_key();

if (isset($_POST['enabled_frontend'])) { $error_reporting_frontend = 1; } else { $error_reporting_frontend = 0; }
if (isset($_POST['enabled_admin'])) { $error_reporting_admin = 1; } else { $error_reporting_admin = 0; }
$error_reporting_method = $_POST['error_reporting_method'];

$error_reporting_method_san = cmtx_sanitize($error_reporting_method);

mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$error_reporting_frontend' WHERE `title` = 'error_reporting_frontend'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$error_reporting_admin' WHERE `title` = 'error_reporting_admin'");
mysql_query("UPDATE `" . $cmtx_mysql_table_prefix . "settings` SET `value` = '$error_reporting_method_san' WHERE `title` = 'error_reporting_method'");
?>
<div class="success"><?php echo CMTX_MSG_SAVED; ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_SETTINGS_ERROR_REPORTING; ?>

<p />

<form name="settings_error_reporting" id="settings_error_reporting" action="index.php?page=settings_error_reporting" method="post">
<label class='settings_error_reporting'><?php echo CMTX_FIELD_LABEL_FRONTEND; ?></label> <?php if (cmtx_setting('error_reporting_frontend')) { ?> <input type="checkbox" checked="checked" name="enabled_frontend"/> <?php } else { ?> <input type="checkbox" name="enabled_frontend"/> <?php } ?>
<p />
<label class='settings_error_reporting'><?php echo CMTX_FIELD_LABEL_BACKEND; ?></label> <?php if (cmtx_setting('error_reporting_admin')) { ?> <input type="checkbox" checked="checked" name="enabled_admin"/> <?php } else { ?> <input type="checkbox" name="enabled_admin"/> <?php } ?>
<p />
<label class='settings_error_reporting'><?php echo CMTX_FIELD_LABEL_METHOD; ?></label>
<select name='error_reporting_method'>
<?php if (cmtx_setting('error_reporting_method') == "log") { ?>
<option value='log' selected='selected'><?php echo CMTX_FIELD_VALUE_LOG_TO_FILE; ?></option>
<option value='screen'><?php echo CMTX_FIELD_VALUE_SHOW_ON_SCREEN; ?></option>
<?php } else { ?>
<option value='log'><?php echo CMTX_FIELD_VALUE_LOG_TO_FILE; ?></option>
<option value='screen' selected='selected'><?php echo CMTX_FIELD_VALUE_SHOW_ON_SCREEN; ?></option>
<?php } ?>
</select>
<p />
<label class='settings_error_reporting'><?php echo CMTX_FIELD_LABEL_VIEW_LOG; ?></label>
<a href="index.php?page=error_log_frontend"><?php echo CMTX_LINK_FRONTEND; ?></a> / <a href="index.php?page=error_log_backend"><?php echo CMTX_LINK_BACKEND; ?></a>
<p />
<?php cmtx_set_csrf_form_key(); ?>
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE; ?>" value="<?php echo CMTX_BUTTON_UPDATE; ?>"/>
</form>