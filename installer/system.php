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

session_start();

if (isset($_POST['submit'])) {
	header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/menu.php");
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Installer</title>
<meta name="robots" content="noindex"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>
</head>
<body>

<img src="../images/commentics/logo.png" class="logo" title="Commentics" alt="Commentics"/>

<br />

<?php
@error_reporting(0); //turn off all error reporting
@ini_set('display_errors', 0); //don't display errors
@ini_set("log_errors" , 0); //don't log errors
?>

<?php
define('IN_COMMENTICS', 'true');
define('CMTX_IN_INSTALLER', 'true');
?>

<?php
require "../includes/db/connect.php"; //connect to database
if (!$cmtx_db_ok) { die(); }
?>

A system check is being performed ..

<p></p>

<?php
$proceed = true;
$notes = "";
?>

<?php
echo "<label class='system_item'>PHP version is 5.2 or higher</label>";
if (version_compare(PHP_VERSION, '5.2.0', '>=')) {
echo "<span class='system_green'>Pass</span>";
} else {
echo "<span class='system_red'>Fail</span>";
$notes .= "- you must have PHP 5.2 or higher.<br />";
$proceed = false;
}

echo "<br />";

echo "<label class='system_item'>MySQL is 5.0.7 or higher</label>";
if (version_compare(mysql_get_server_info(), '5.0.7', '>=')) {
echo "<span class='system_green'>Pass</span>";
} else {
echo "<span class='system_red'>Fail</span>";
$notes .= "- you must have MySQL 5.0.7 or higher.<br />";
$proceed = false;
}

echo "<br />";

echo "<label class='system_item'>A PHP session is available</label>";
if (session_id() != '') {
	if (isset($_SESSION['cmtx_session_test']) && $_SESSION['cmtx_session_test'] == "1") {
		echo "<span class='system_green'>Pass</span>";
	} else {
		echo "<span class='system_red'>Fail</span>";
		$notes .= "- A session is required for the admin panel.<br />";
		$proceed = false;
	}
} else {
echo "<span class='system_red'>Fail</span>";
$notes .= "- A session is required for the admin panel.<br />";
$proceed = false;
}

echo "<br />";

echo "<label class='system_item'>Ctype extension is enabled</label>";
if (extension_loaded('ctype')) {
echo "<span class='system_green'>Pass</span>";
} else {
echo "<span class='system_red'>Fail</span>";
$notes .= "- Ctype extension is required.<br />";
$proceed = false;
}

echo "<br />";

echo "<label class='system_item'>filter_var() func is enabled</label>";
if (function_exists('filter_var') && is_callable('filter_var')) {
echo "<span class='system_green'>Pass</span>";
} else {
echo "<span class='system_red'>Fail</span>";
$notes .= "- filter_var() is needed for form validation.<br />";
$proceed = false;
}

echo "<br />";

echo "<label class='system_item'>Magic Quotes is disabled</label>";
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
echo "<span class='system_amber'>Fail</span>";
$notes .= "- Magic Quotes should be disabled or you will see extra slashes";
$notes .= " (<a href='http://www.commentics.org/support/knowledgebase.php?article=29' target='_blank'>FAQ</a>)<br />";
} else {
echo "<span class='system_green'>Pass</span>";
}

echo "<br />";

echo "<label class='system_item'>System() function is enabled</label>";
if (function_exists('system') && is_callable('system')) {
echo "<span class='system_green'>Pass</span>";
} else {
echo "<span class='system_amber'>Fail</span>";
$notes .= "- the system() function is used for the database backup tool.<br />";
}

echo "<br />";

echo "<label class='system_item'>cURL extension is enabled</label>";
if (extension_loaded('curl')) {
echo "<span class='system_green'>Pass</span>";
} else {
echo "<span class='system_amber'>Fail</span>";
$notes .= "- cURL may be used for version checking and news.<br />";
}

echo "<br />";

echo "<label class='system_item'>fopen(URL) is enabled</label>";
if ((bool)ini_get('allow_url_fopen')) {
echo "<span class='system_green'>Pass</span>";
} else {
echo "<span class='system_amber'>Fail</span>";
$notes .= "- fopen(URL) may be used for version checking and news.<br />";
}

echo "<br />";

echo "<label class='system_item'>fsockopen() is enabled</label>";
if (function_exists('fsockopen') && is_callable('fsockopen')) {
echo "<span class='system_green'>Pass</span>";
} else {
echo "<span class='system_amber'>Fail</span>";
$notes .= "- fsockopen() is used for Akismet and ReCaptcha.<br />";
}
?>

<p></p>

<?php
if (!empty($notes)) {
echo "<b>Notes</b>:<br />";
echo "<i>$notes</i>";
echo "<p></p>";
}
?>

<?php
if (!empty($notes) && $proceed) {
echo "You may still proceed.";
echo "<p></p>";
}
?>

<?php if ($proceed) { ?>
<form name="system" id="system" action="system.php" method="post">
<input type="submit" name="submit" value="Continue"/>
</form>
<?php } else { ?>
<span class='fail'>The installer can not proceed.</span>
<?php } ?>

</body>
</html>