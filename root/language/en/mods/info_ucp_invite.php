<?php
/**
*
* info_ucp_invite [British English]
*
* @author Bycoja bycoja@web.de
* @package language
* @version $Id info_ucp_invite.php 0.6.1 2010-04-05 15:14:09GMT Bycoja $
* @copyright (c) 2010 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* English tranlation by:
* Bycoja
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'UCP_INVITE'					=> 'Invite A Friend',
	'UCP_INVITE_INVITE'				=> 'Compose invitation',
	'UCP_INVITE_DESCRIPTION'		=> 'Send an invitation e-mail to a friend of yours and draw his attention to this board.',
	'REGISTER_KEY'					=> 'Registration key',
	'REGISTER_KEY_EXPLAIN'			=> 'Obtained by a user of this board via e-mail.',

	// Invitation form
	'RECIPIENT_EMAIL'				=> 'Your friend’s e-mail address',
	'RECIPIENT_NAME'				=> 'Your friend’s name',
	'MESSAGE_EXPLAIN'				=> 'Tell your friend why you would like him to visit this board.',
	'SEND_CONFIRMATION'				=> 'Receive confirmation',
	'SEND_CONFIRMATION_METHOD'		=> 'Receive confirmation via',
	'INVITATION_ZEBRA'				=> 'Add invited user to friendlist',
	'OPTIONAL'						=> 'Optional',

	// Error messages
	'EMAIL_DISABLED'				=> 'E-mail-functionality has been disabled and you cannot send any invitations.',
	'EMAIL_SENT_FAILURE'			=> 'An error occurred while sending the invitation.',
	'EMAIL_SENT_SUCCESS'			=> 'The e-mail was successfully sent to your friend.',
	'INVITE_DISABLED'				=> 'Sending invitations to friends has been disabled by the Board Administration.',
	'QUEUE_QUEUE'					=> 'You have to wait %d:%02d minutes until you can send another e-mail to a friend of yours.',
	'INVITATION_LIMIT_DAILY'		=> 'You have reached the daily limit of %d invitations and you may not send another invitation today.',
	'INVITATION_LIMIT_TOTAL'		=> 'You have reached the total limit of %d invitations and you may not send another invitation at all.',
	'INVITE_YOURSELF'				=> 'You must not use registration keys you sent to yourself.',
	'INVITE_TO_YOUR_EMAIL'			=> 'You cannot invite yourself.',
	'INVITE_MULTIPLE'				=> 'The entered e-mail address already obtained an invitation.',
	'REGISTER_KEY_INVALID'			=> 'The registration key is invalid.',
	'REGISTER_KEY_INVALID_OPTIONAL'	=> 'The registration key is invalid. You can leave it out.',
	'TOO_SHORT_REGISTER_REAL_NAME'	=> 'The name you entered is too short.',
	'TOO_SHORT_SUBJECT'				=> 'The subject you entered is too short.',
	'TOO_SHORT_MESSAGE'				=> 'The message you entered is too short.',
	'TOO_LONG_REGISTER_REAL_NAME'	=> 'The name you entered is too long.',
	'TOO_LONG_SUBJECT'				=> 'The subject you entered is too long.',
	'TOO_LONG_MESSAGE'				=> 'The message you entered is too long.',

	// CAPTCHA
	'POST_CONFIRM_EXPLAIN'			=> 'To prevent automated invitations the board requires you to enter a confirmation code. The code is displayed in the image you should see below. If you are visually impaired or cannot otherwise read this code please contact the Board Administrator.',

));

?>