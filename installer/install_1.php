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
?>
<!DOCTYPE html>
<html>
<head>
<title>Installer</title>
<meta name="robots" content="noindex"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="css/stylesheet.css"/>

<script type="text/javascript">
// <![CDATA[
function check_passwords() {
if (document.install.admin_password_1.value == document.install.admin_password_2.value) {
return true;
} else {
alert("The two passwords do not match.");
return false;
}
}
// ]]>
</script>

</head>
<body>

<img src="../images/commentics/logo.png" class="logo" title="Commentics" alt="Commentics"/>

<br />

<?php
/* Error Reporting */
@error_reporting(-1); //show every possible error
@ini_set('display_errors', 1); //display errors
?>

<?php
define('IN_COMMENTICS', 'true');
define('CMTX_IN_INSTALLER', 'true');
?>

<?php
require "../includes/db/connect.php"; //connect to database
if (!$cmtx_db_ok) { die(); }
?>

<?php
if (mysql_num_rows(mysql_query("SHOW TABLES LIKE '" . $cmtx_mysql_table_prefix . "comments'"))) {
echo "<span class='fail'>The programme is already installed.</span>";
echo "<p></p>";
echo "<a href='javascript:history.back()'>back</a>";
echo "</body>";
echo "</html>";
die();
}
?>

The Installer will now create the tables in the database.

<p></p>
<hr/>
<p></p>

<form name="install" id="install" action="install_2.php" method="post" onsubmit="return check_passwords()">

<span class='heading'>Administrator</span>

<p></p>

<span class='heading_note'>These settings are for the Commentics admin panel.</span>

<p></p>

<span class='field'>Admin Username:</span><br />
<input type="text" required autofocus name="admin_username" size="20"/> <span class='field_note'>(enter your admin panel username)</span>
<p></p>
<span class='field'>Admin Password:</span><br />
<input type="password" required name="admin_password_1" size="20"/> <span class='field_note'>(enter your admin panel password)</span>
<p></p>
<span class='field'>Repeat Password:</span><br />
<input type="password" required name="admin_password_2" size="20"/> <span class='field_note'>(repeat your admin panel password)</span>
<p></p>
<span class='field'>Admin Email Address:</span><br />
<input type="email" required name="admin_email_address" size="25"/> <span class='field_note'>(enter your admin email address)</span>

<p></p>
<hr/>
<p></p>

<span class='heading'>General</span>

<p></p>

<span class='heading_note'>General settings.</span>

<p></p>

<span class='field'>Time Zone:</span><br />
<?php
$time_zones = DateTimeZone::listIdentifiers();
echo "<select name='time_zone'>";
foreach ($time_zones as $time_zone) {
	echo "<option value='$time_zone'>$time_zone</option>";
}
echo "</select>";
?>
<span class='field_note'> (select your time zone)</span>

<p></p>

<span class='field'>Admin Folder:</span><br />
<input type="text" required name="admin_folder" size="20" value="admin"/> <span class='field_note'>(enter your renamed admin folder)</span>

<p></p>
<hr/>
<p></p>

<span class='heading'>Site</span>

<p></p>

<span class='heading_note'>The Installer can populate many of the admin settings according to the three inputs below.</span>

<p></p>

<span class='heading_note'>You can change these settings at any time so don't worry too much about getting it right.</span>

<p></p>

<span class='field'>Site Name:</span><br />
<input type="text" required name="site_name" size="20" value="My Site"/> <span class='field_note'>(enter the name of your site)</span>
<p></p>
<span class='field'>Site Domain:</span><br />
<input type="text" required name="site_domain" size="25" value="mysite.com"/> <span class='field_note'>(enter your domain name without the http:// or www)</span>
<p></p>
<span class='field'>URL to Comments Folder:</span><br />
<span class='part'>http://</span><input type="text" required name="comments_url" size="25" value="www.mysite.com"/><span class='part'>/comments/</span> <span class='field_note'>(enter the URL to your comments folder)</span>
<p></p>
<span class='example'>e.g. mysite.com</span> <span class='example_note'>(without www)</span>
<br />
<span class='example'>e.g. www.mysite.com/myfolder</span> <span class='example_note'>(in a folder)</span>
<br />
<span class='example'>e.g. www.subdomain.mysite.com</span> <span class='example_note'>(subdomain)</span>
<br />
<span class='example'>e.g. localhost</span> <span class='example_note'>(localhost)</span>
<br />
<span class='example'>e.g. localhost/myfolder</span> <span class='example_note'>(localhost and in a folder)</span>

<p></p>
<hr/>
<p></p>

When ready click 'Install' below.

<p></p>

<input type="submit" name="submit" value="Install"/>
</form>

</body>
</html>