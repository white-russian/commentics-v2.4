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

<h3><?php echo CMTX_TITLE_LIST_BANNED_TOWNS; ?></h3>
<hr class="title"/>

<?php
if (isset($_POST['submit']) && cmtx_setting('is_demo')) {
?>
<div class="warning"><?php echo CMTX_MSG_DEMO; ?></div>
<div style="clear: left;"></div>
<?php
} else if (isset($_POST['submit'])) {

cmtx_check_csrf_form_key();

$data = $_POST['banned_towns'];
$file = "../includes/words/banned_towns.txt";
$handle = fopen($file,"w");
fputs($handle, $data);
fclose($handle);
?>
<div class="success"><?php echo CMTX_MSG_LIST_UPDATED; ?></div>
<div style="clear: left;"></div>
<?php } ?>

<p />

<?php echo CMTX_DESC_WILDCARDS; ?> <a href="" onclick="show_hide('wildcards');return false;" style="text-decoration:none;"><?php echo CMTX_LINK_MORE; ?></a>

<div id="wildcards" style="display:none;">
<div class="wildcard_box">
<b>1</b>. <?php echo CMTX_DESC_WILDCARDS_1 ?>
<ul>
<li>New <span class="wildcard_not_found"><?php echo CMTX_DESC_WILDCARD_NOT_FOUND; ?></span></li>
<li>New* <span class="wildcard_found"><?php echo CMTX_DESC_WILDCARD_FOUND; ?></span></li>
<li>castle <span class="wildcard_not_found"><?php echo CMTX_DESC_WILDCARD_NOT_FOUND; ?></span></li>
<li>*castle <span class="wildcard_found"><?php echo CMTX_DESC_WILDCARD_FOUND; ?></span></li>
<li>cast <span class="wildcard_not_found"><?php echo CMTX_DESC_WILDCARD_NOT_FOUND; ?></span></li>
<li>*cast* <span class="wildcard_found"><?php echo CMTX_DESC_WILDCARD_FOUND; ?></span></li>
</ul>
<b>2</b>. <?php echo CMTX_DESC_WILDCARDS_2 ?>
<p/>
<b>3</b>. <?php echo CMTX_DESC_WILDCARDS_3 ?>
</div>
</div>

<p />

<?php
$data = file_get_contents('../includes/words/banned_towns.txt');
?>

<p />

<form name="list_banned_towns" id="list_banned_towns" action="index.php?page=list_banned_towns" method="post">
<textarea name="banned_towns" cols="" rows="15" style="width:100%"><?php echo $data; ?></textarea>
<p />
<?php cmtx_set_csrf_form_key(); ?>
<input type="submit" class="button" name="submit" title="<?php echo CMTX_BUTTON_UPDATE; ?>" value="<?php echo CMTX_BUTTON_UPDATE; ?>"/>
</form>

<p />

<a href="index.php?page=settings_processor_town"><?php echo CMTX_LINK_BACK; ?></a>