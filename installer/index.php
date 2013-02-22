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
	header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/system.php");
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

Welcome to the Installer for Commentics.

<p></p>
<hr/>
<p></p>

If you are <b>installing</b> the programme make sure that:

<ul>
<li>You have created the database.</li>
<li>You have entered its details in /comments/includes/db/details.php</li>
<li>Your MySQL user has <b>at least</b> the following privileges:
	<ul><li>Select, Insert, Update, Delete, Create, Alter, Index and Drop.</li></ul>
</ul>

<p></p>
<hr/>
<p></p>

If you are <b>upgrading</b> the programme make sure that:

<ul>
<li>You have backed up your database.</li>
<li>You have backed up your files.</li>
</ul>

<p></p>
<hr/>
<p></p>

Click 'Start' to begin.

<?php
if (session_id() != '') {
	$_SESSION['cmtx_session_test'] = "1";
}
?>

<p></p>

<form name="installer" id="installer" action="index.php" method="post">
<input type="submit" name="submit" value="Start"/>
</form>

</body>
</html>