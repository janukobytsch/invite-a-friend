<?php
/**
* @author Bycoja bycoja@web.de
* info_acp_invite [British English]
*
* @package language
* @version $Id: info_ucp_invite.php 054 2009-11-28 14:41:59GMT Bycoja $
* @copyright (c) 2008 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Englische Übersetzung durch den Autor:
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
	'UCP_INVITE_DESCRIPTION'		=> 'Send an e-mail to a friend of yours and advise him of this board.',

	'RECIPIENT_EMAIL'				=> 'Your friend’s e-mail address',
	'RECIPIENT_NAME'				=> 'Your friend’s name',
	'SEND_CONFIRM'					=> 'Send confirmation',
	'SEND_CONFIRM_METHOD'			=> 'Confirmation via',
	'INVITE_ZEBRA'					=> 'Add friend',
	'OPTIONAL'						=> 'Optional',

	'INVITE_NO_REGISTER_KEY'		=> 'If you don’t enter a registration key: ',
	'REGISTER_KEY'					=> 'Registration key',
	'REGISTER_KEY_EXPLAIN'			=> 'Obtained by a user of this board via e-mail.',
	'REGISTER_KEY_DISABLED'			=> 'You don’t need a registration key in order to register at the moment.',

	'QUEUE_QUEUE'					=> 'You have to wait a while until you can send another e-mail to a friend of yours.',
	'QUEUE_LIMIT_INVITE_DAY'		=> 'You have reached the daily limit and are not able to send other invitations today.',
	'QUEUE_LIMIT_INVITE_USER'		=> 'You have reached the total limit and are not able to send other invitations.',
	'INVITE_DISABLED'				=> 'Inviting friends is currently disabled.',
	'INVITE_YOURSELF'				=> 'You must not use registration keys you sent to yourself.',
	'INVITE_TO_YOUR_EMAIL'			=> 'You cannnot invite yourself.',

	'EMAIL_DISABLED'				=> 'E-mail-functionality has been disabled, so you cannot send any invitations.',
	'EMAIL_SENT_FAILURE'			=> 'An error occured while sending the e-mail.',
	'EMAIL_SENT_SUCCESS'			=> 'The e-mail was successfully sent to your friend.',
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