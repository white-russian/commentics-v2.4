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

/* Error box */
define('CMTX_ERROR_NUMBER', 'Sorry but %d error was found when processing your comment.');
define('CMTX_ERRORS_NUMBER', 'Sorry but %d errors were found when processing your comment.');
define('CMTX_ERROR_CORRECTION', 'Please correct this error and submit the form again:');
define('CMTX_ERRORS_CORRECTION', 'Please correct these errors and submit the form again:');

/* Preview box */
define('CMTX_PREVIEW_TEXT', 'Preview Only');

/* Approval box */
define('CMTX_APPROVAL_OPENING', 'Thank you.');
define('CMTX_APPROVAL_TEXT', 'Your comment is awaiting approval.');

/* Success box */
define('CMTX_SUCCESS_OPENING', 'Thank you.');
define('CMTX_SUCCESS_TEXT', 'Your comment has been added.');

/* Error messages */
define('CMTX_ERROR_MESSAGE_NO_NAME', 'The name field can not be empty. Please enter your name.');
define('CMTX_ERROR_MESSAGE_ONE_NAME', 'Only one name can be entered for the name field. Please enter one name.');
define('CMTX_ERROR_MESSAGE_INVALID_NAME', 'The name must start with a letter and optionally contain - & . \'');
define('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'The name entered is reserved. Please choose another name.');
define('CMTX_ERROR_MESSAGE_BANNED_NAME', 'The name entered is forbidden. Please choose another name.');
define('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'The name entered is not yours. Please enter your real name.');
define('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'The name entered contains a link. Please enter your real name.');
define('CMTX_ERROR_MESSAGE_NO_EMAIL', 'The email field can not be empty. Please enter your email.');
define('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'The email address entered is incorrect. Please check your entry.');
define('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'The email address entered is reserved. Please enter your email.');
define('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'The email address entered is forbidden. Please enter another email.');
define('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'The email address entered is not yours. Please enter your email.');
define('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'The website field can not be empty. Please enter your website.');
define('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'The website address entered is incorrect. Please check your entry.');
define('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'The website address entered is reserved. Please enter your website.');
define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'The website address entered is forbidden. Please remove it.');
define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'The website address in your comment is forbidden. Please remove it.');
define('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'The website address entered is not yours. Please enter your website.');
define('CMTX_ERROR_MESSAGE_NO_TOWN', 'The town field can not be empty. Please enter your town.');
define('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'The town must start with a letter and optionally contain - & . \'');
define('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'The town entered is reserved. Please enter another town.');
define('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'The town entered is forbidden. Please enter another town.');
define('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'The town entered is not yours. Please enter your town.');
define('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'The town entered contains a link. Please enter your town.');
define('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'The country field was not selected. Please select your country.');
define('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'The selected country is invalid. Please contact the administrator.');
define('CMTX_ERROR_MESSAGE_COUNTRY_SEARCH', 'The selected country could not be found. Please try again.');
define('CMTX_ERROR_MESSAGE_NO_RATING', 'The rating field was not selected. Please select your rating.');
define('CMTX_ERROR_MESSAGE_INVALID_RATING', 'The selected rating is invalid. Please contact the administrator.');
define('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'The comment you are replying to is invalid. Please try again.');
define('CMTX_ERROR_MESSAGE_NO_COMMENT', 'The comment field can not be empty. Please enter your comment.');
define('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'The comment entered was too short. Please enter a longer comment.');
define('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'The comment entered was too long. Please enter a shorter comment.');
define('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'The comment entered contains too many lines. Please enter fewer lines.');
define('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'You have submitted this comment. Please submit a new comment.');
define('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'The comment entered contains too many smilies (Max: %d).');
define('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'The comment entered contains offensive words. Please remove these words.');
define('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Swearing is not allowed. Please remove the swear words from your comment.');
define('CMTX_ERROR_MESSAGE_SPAMMING', 'Spamming is not allowed. Please remove the spam from your comment.');
define('CMTX_ERROR_MESSAGE_LONG_WORD', 'The comment entered contains a long word. Please shorten or remove this word.');
define('CMTX_ERROR_MESSAGE_CAPITALS', 'The comment entered contains too many capitals. Please enter fewer capitals.');
define('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'The comment entered contains a link. Please remove the link.');
define('CMTX_ERROR_MESSAGE_REPEATS', 'The comment entered contains repeating characters. Please remove them.');
define('CMTX_ERROR_MESSAGE_NO_ANSWER', 'The question field can not be empty. Please enter the answer.');
define('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'The answer to the question was incorrect. Please try again.');
define('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'The captcha field can not be empty. Please enter the characters.');
define('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'The characters for the captcha image were incorrect. Please try again.');
define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Your last comment was submitted recently. Please wait longer.');
define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'You have submitted several comments recently. Please wait a while.');
define('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Please enable your web browser to send referrer information.');
define('CMTX_ERROR_MESSAGE_INCORRECT_REFERRER', 'The referrer suggests that you submitted from another website.');
define('CMTX_ERROR_MESSAGE_MAXIMUMS', 'Please enable your web browser to respect the maximum field lengths.');
define('CMTX_ERROR_MESSAGE_HONEYPOT', 'A hidden field, used to detect bots, was filled in. Please leave it empty.');
define('CMTX_ERROR_MESSAGE_MIN_TIME', 'The form was submitted too quickly. Please take longer.');
define('CMTX_ERROR_MESSAGE_MISSING_DATA', 'Some expected data was missing. Please submit the form again.');

/* Messages displayed to user when banned */
define('CMTX_BAN_MESSAGE_BANNED_NOW', '<p>You have just been banned.</p><p>This can be due to a variety of reasons including swearing, spamming and hacker-related behaviour.</p><p>If you feel that this was in error, please contact the website administrator, quoting your IP address.</p>');
define('CMTX_BAN_MESSAGE_BANNED_PREVIOUSLY', 'Sorry, you have previously been banned.');

/* Ban reasons */
define('CMTX_BAN_REASON_NO_SECURITY_KEY', 'No security key.');
define('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Incorrect security key.');
define('CMTX_BAN_REASON_NO_RESUBMIT_KEY', 'No resubmit key.');
define('CMTX_BAN_REASON_INVALID_RESUBMIT_KEY', 'Invalid resubmit key.');
define('CMTX_BAN_REASON_INJECTION', 'Injection attempt.');
define('CMTX_BAN_REASON_RESERVED_NAME', 'Reserved name entered.');
define('CMTX_BAN_REASON_BANNED_NAME', 'Banned name entered.');
define('CMTX_BAN_REASON_DUMMY_NAME', 'Dummy name entered.');
define('CMTX_BAN_REASON_LINK_IN_NAME', 'Link entered in name.');
define('CMTX_BAN_REASON_RESERVED_EMAIL', 'Reserved email address entered.');
define('CMTX_BAN_REASON_BANNED_EMAIL', 'Banned email address entered.');
define('CMTX_BAN_REASON_DUMMY_EMAIL', 'Dummy email address entered.');
define('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Reserved website address entered.');
define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Banned website entered in website.');
define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Banned website entered in comment.');
define('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Dummy website address entered.');
define('CMTX_BAN_REASON_RESERVED_TOWN', 'Reserved town entered.');
define('CMTX_BAN_REASON_BANNED_TOWN', 'Banned town entered.');
define('CMTX_BAN_REASON_DUMMY_TOWN', 'Dummy town entered.');
define('CMTX_BAN_REASON_LINK_IN_TOWN', 'Link entered in town.');
define('CMTX_BAN_REASON_MILD_SWEARING', 'Mild swearing.');
define('CMTX_BAN_REASON_STRONG_SWEARING', 'Strong swearing.');
define('CMTX_BAN_REASON_SPAMMING', 'Spamming.');
define('CMTX_BAN_REASON_CAPITALS', 'Too many capitals.');
define('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Link entered in comment.');
define('CMTX_BAN_REASON_REPEATS', 'Repeats entered in comment.');

/* Approval reasons */
define('CMTX_APPROVE_REASON_ALL', 'Approve all.');
define('CMTX_APPROVE_REASON_RESERVED_NAME', 'Reserved name entered.');
define('CMTX_APPROVE_REASON_BANNED_NAME', 'Banned name entered.');
define('CMTX_APPROVE_REASON_DUMMY_NAME', 'Dummy name entered.');
define('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Link entered in name.');
define('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Reserved email address entered.');
define('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Banned email address entered.');
define('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Dummy email address entered.');
define('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Website entered.');
define('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Reserved website address entered.');
define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Banned website entered in website.');
define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Banned website entered in comment.');
define('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Dummy website address entered.');
define('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Reserved town entered.');
define('CMTX_APPROVE_REASON_BANNED_TOWN', 'Banned town entered.');
define('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Dummy town entered.');
define('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Link entered in town.');
define('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Link entered.');
define('CMTX_APPROVE_REASON_REPEATS', 'Repeats entered.');
define('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Image entered.');
define('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Video entered.');
define('CMTX_APPROVE_REASON_MILD_SWEARING', 'Mild swearing.');
define('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Strong swearing.');
define('CMTX_APPROVE_REASON_SPAMMING', 'Spam.');
define('CMTX_APPROVE_REASON_CAPITALS', 'Too many capitals.');
define('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');

?>