<?php 
/*
	Comments actions via email. 
	Version 0.3 (16.03.2016)
*/

//set the path
$cmtx_path = '';

/* Database Connection */
require 'includes/db/connect.php'; //connect to database
if (!$cmtx_db_ok) { die(); }

//load function files
require_once $cmtx_path . 'includes/bootstrap/functions.php'; //load bootstrap file for functions

//AHTUNG
function ahtung() 
{
	$rn = "\r\n";
	$domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);
	$admin_email = ENTER_YOUR_EMAIL_HERE;
	$message = 'IP: ' . $_SERVER["REMOTE_ADDR"] . $rn . 'HTTP_REFERER: ' . $_SERVER["HTTP_REFERER"] . $rn . 'REQUEST_URI: ' . $_SERVER["REQUEST_URI"] . $rn;
	mail($admin_email, "AHTUNG! Unauthorized access to " . $domain . "!", $message, 
		"From: comments@" . $domain . "\r\n"
		."Reply-To: no-reply@" . $domain . "\r\n"
		."X-Mailer: PHP/" . phpversion());
	//Rename the file
	//rename("mail_actions.php", "mail_actions_hide.php");
	//disable free access to the file
	chmod("mail_actions.php", 0000);
}

//VARIABLES
$id = $_GET['id'];
$action = $_GET['action'];
$comment_url = cmtx_decode(cmtx_get_permalink($id, cmtx_get_page_url())); //get the permalink of the comment
$comment_query = cmtx_db_query("SELECT * FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
$comment_result = cmtx_db_fetch_assoc($comment_query);
$name = $comment_result["name"];
$email = $comment_result["email"];
$website = $comment_result["website"];
$ip_address = $comment_result["ip_address"];

//SECRET KEY, MUST BE EQUAL TO THE $comment_id_secret IN /commentics/includes/functions/processor.php
$cis = md5($id . 'ENTER_YOUR_SECRET_KEY_HERE');

//Show something to potential hacker
$error_text = "<html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You don't have permission to access this folder.</p><hr/></body></html>";

//CHECK $cis, IF NOT - AHTUNG, ELSE - ACTION
if (isset($_GET['cis']) && $_GET['cis'] == $cis) {
	//Check if comment exists
	if ($id == $comment_result["id"]) {
		switch ($action) {
			//Approve
			case "ok":
				cmtx_db_query("UPDATE `" . $cmtx_mysql_table_prefix . "comments` SET `is_approved` = '1' WHERE `id` = '$id'");
				//header( 'Location: ' . $comment_url . '', true, 301 );
				echo "ok ......... OK";
				break;
			//Delete
			case "404":
				cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
				echo "404 ......... OK";
				break;
			//Delete + BAN by email + IP
			case "000":
				// Ban IP
				cmtx_db_query("INSERT INTO `" . $cmtx_mysql_table_prefix . "bans` (`ip_address`, `reason`, `unban`, `dated`) VALUES ('$ip_address', 'Accaunt blocked. Spam.', '0', NOW());");
				// Ban email
				$file = 'includes/words/custom/banned_emails.txt';
				$handle = fopen($file, 'a');
				fputs($handle, "\r\n" . $email);
				fclose($handle);
				// Delete comment
				cmtx_db_query("DELETE FROM `" . $cmtx_mysql_table_prefix . "comments` WHERE `id` = '$id'");
				echo "000 ......... OK";
				break;
			default:
			echo $error_text;
		}
	}
	//если такого комментария уже нет
	else {echo "Comment " . $id . " doesn't exist!";}
}
else {
	ahtung();
	//We can transfer potential hacker somewhere
	//header( 'Location: http://' . $_SERVER['HTTP_HOST'] . '', true, 301 );
	echo $error_text;
}

?>
