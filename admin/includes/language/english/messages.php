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

define('CMTX_MSG_SAVED', 'Settings saved.');

define('CMTX_MSG_COMMENT_UPDATED', 'Comment updated.');
define('CMTX_MSG_COMMENT_DELETED', 'Comment deleted.');
define('CMTX_MSG_COMMENT_BULK_DELETED', '1 comment deleted.');
define('CMTX_MSG_COMMENTS_BULK_DELETED', '%d comments deleted.');
define('CMTX_MSG_COMMENT_APPROVED', 'Comment approved.');
define('CMTX_MSG_COMMENT_BULK_APPROVED', '1 comment approved.');
define('CMTX_MSG_COMMENTS_BULK_APPROVED', '%d comments approved.');
define('CMTX_MSG_COMMENT_ALREADY_APPROVED', 'Comment already approved.');
define('CMTX_MSG_COMMENT_BULK_ALREADY_APPROVED', '1 comment already approved.');
define('CMTX_MSG_COMMENTS_BULK_ALREADY_APPROVED', '%d comments already approved.');
define('CMTX_MSG_COMMENT_SENT', 'Comment sent.');
define('CMTX_MSG_COMMENT_BULK_SENT', '1 comment sent.');
define('CMTX_MSG_COMMENTS_BULK_SENT', '%d comments sent.');
define('CMTX_MSG_COMMENT_ALREADY_SENT', 'Comment already sent.');
define('CMTX_MSG_COMMENT_BULK_ALREADY_SENT', '1 comment already sent.');
define('CMTX_MSG_COMMENTS_BULK_ALREADY_SENT', '%d comments already sent.');
define('CMTX_MSG_SPAM_REMOVED', 'Spam removed.');

define('CMTX_MSG_PAGE_UPDATED', 'Page updated.');
define('CMTX_MSG_PAGE_DELETED', 'Page deleted.');
define('CMTX_MSG_PAGE_BULK_DELETED', '1 page deleted.');
define('CMTX_MSG_PAGES_BULK_DELETED', '%d pages deleted.');
define('CMTX_MSG_IDENTIFIER_EXISTS', 'Identifier already exists.');

define('CMTX_MSG_ADMIN_ADDED', 'Administrator added.');
define('CMTX_MSG_ADMIN_UPDATED', 'Administrator updated.');
define('CMTX_MSG_ADMIN_DELETED', 'Administrator deleted.');
define('CMTX_MSG_ADMIN_BULK_DELETED', '1 administrator deleted.');
define('CMTX_MSG_ADMINS_BULK_DELETED', '%d administrators deleted.');
define('CMTX_MSG_ADMIN_EXISTS', 'Username already exists.');
define('CMTX_MSG_ADMIN_SUPER_DELETE', 'The super administrator can not be deleted.');
define('CMTX_MSG_ADMIN_BULK_SUPER_DELETE', '1 super administrator could not be deleted.');
define('CMTX_MSG_ADMINS_BULK_SUPER_DELETE', '&d super administrator could not be deleted.');
define('CMTX_MSG_ADMIN_SUPER_DISABLE', 'The super administrator can not be disabled.');
define('CMTX_MSG_ADMIN_SUPER_RESTRICT', 'The super administrator can not be restricted.');
define('CMTX_MSG_ADMIN_SUPER_ONLY', 'Sorry, only the super administrator can access this page.');

define('CMTX_MSG_BAN_ADDED', 'Ban added.');
define('CMTX_MSG_BAN_UPDATED', 'Ban updated.');
define('CMTX_MSG_BAN_DELETED', 'Ban deleted.');
define('CMTX_MSG_BAN_BULK_DELETED', '1 ban deleted.');
define('CMTX_MSG_BANS_BULK_DELETED', '%d bans deleted.');

define('CMTX_MSG_SUB_ADDED', 'Subscriber added.');
define('CMTX_MSG_SUB_UPDATED', 'Subscriber updated.');
define('CMTX_MSG_SUB_DELETED', 'Subscriber deleted.');
define('CMTX_MSG_SUB_BULK_DELETED', '1 subscriber deleted.');
define('CMTX_MSG_SUBS_BULK_DELETED', '%d subscribers deleted.');

define('CMTX_MSG_QUESTION_ADDED', 'Question added.');
define('CMTX_MSG_QUESTION_UPDATED', 'Question updated.');
define('CMTX_MSG_QUESTION_DELETED', 'Question deleted.');
define('CMTX_MSG_QUESTION_BULK_DELETED', '1 question deleted.');
define('CMTX_MSG_QUESTIONS_BULK_DELETED', '%d questions deleted.');

define('CMTX_MSG_IP_ADDRESS_UPDATED', 'IP Address Updated.');

define('CMTX_MSG_AKISMET_UNABLE', '<p>The fsockopen() function on your server appears to be disabled.</p><p>This feature requires it. Please contact your host to enable it.</p>');

define('CMTX_MSG_EMAIL_SENT', 'Email sent.');

define('CMTX_MSG_LOG_RESET', 'Error log reset.');

define('CMTX_MSG_LIST_UPDATED', 'List updated.');

define('CMTX_MSG_RECAPTCHA_UNABLE', '<p>The fsockopen() function on your server appears to be disabled.</p><p>This feature requires it. Please contact your host to enable it.</p>');

define('CMTX_MSG_BACKUP_CREATED', 'Backup created.');
define('CMTX_MSG_BACKUP_DELETED', 'Backup deleted.');
define('CMTX_MSG_BACKUP_BULK_DELETED', '1 backup deleted.');
define('CMTX_MSG_BACKUPS_BULK_DELETED', '%d backups deleted.');
define('CMTX_MSG_BACKUP_NOT_FOUND', 'Backup not found.');
define('CMTX_MSG_BACKUP_BULK_NOT_FOUND', '1 backup not found.');
define('CMTX_MSG_BACKUPS_BULK_NOT_FOUND', '%d backups not found.');
define('CMTX_MSG_BACKUP_UNABLE', '<p>The system() function on your server appears to be disabled.</p><p>This feature requires it. Please contact your host to enable it.</p>');

define('CMTX_MSG_OPTIMIZED', 'Tables optimized.');

define('CMTX_MSG_NOTICE_MANAGE_COMMENTS', 'To improve performance, only the latest 50 comments are shown. Go to Settings -> System to change this.');
define('CMTX_MSG_NOTICE_LAYOUT_FORM_SIZES_MAXIMUMS', 'The field sizes are now controlled and overridden by the CSS stylesheet.');
define('CMTX_MSG_NOTICE_LAYOUT_FORM_QUESTIONS', 'Answers are case-insensitive. Separate multiple answers with the | character.');
define('CMTX_MSG_NOTICE_SETTINGS_ADMIN_DETECTION', 'Posting as the admin has <a href="http://www.commentics.org/wiki/doku.php?id=admin:settings_admin_detection" target="_blank">differences</a>.');
define('CMTX_MSG_NOTICE_SETTINGS_EMAIL_SENDER', 'The "<b>From Email</b>" should be a registered address.');

define('CMTX_MSG_RECORD_MISSING', 'Not found.');

define('CMTX_MSG_DEMO', 'This function has been disabled in the demo.');

?>