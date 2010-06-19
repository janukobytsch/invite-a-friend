<?php
/**
*
* invite [English]
*
* @package language
* @version $Id: invite.php 8645 2008-10-03 10:40:17Z Bycoja $
* @copyright (c) 2008 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
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
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	// General
	'INVITE_A_FRIEND'			=> 'Invite a friend',
	'UCP_INVITE'				=> 'Invite a friend',
	'UCP_INVITE_INVITE'			=> 'Compose invitation',
	'INVITE_A_FRIEND_DESC'		=> 'Send an e-mail to a friend of yours and advise him of this board',
	'INVITE_CONFIRM_EMAIL'		=> 'Confirmation - Invite a friend',
	'OPTIONAL'					=> 'Optional',
	
	// Form
	'AUTH_KEY'					=> 'Registration-key',
	'AUTH_KEY_EXPLAIN'			=> 'Obtained by a user of this board via e-mail.',
	'AUTH_KEY_DISABLED'			=> 'You don’t need a registration-key to register at the moment.',
	'EMAIL_SENT_SUCCESS'		=> 'The e-mail was successfully sent to your friend.',
	'FRIENDS_EMAIL'				=> 'Your friend’s e-mail address',
	'FRIENDS_NAME'				=> 'Your friend’s name',
	'SEND_CONFIRM_EMAIL'		=> 'Send confirmation',
	
	// Errors
	'IAF_DISABLED'				=> 'Inviting friends is currently disabled.',
	'INVITE_YOURSELF'			=> 'You must not use more than one registration-key each IP.',
	
	'ALREADY_INVITED'			=> 'The entered e-mail address already obtained an invitation.',
	'AUTH_KEY_WRONG'			=> 'The registration-key is invalid.',
	'OPTIONAL_AUTH_KEY_WRONG'	=> 'The registration-key is invalid. You can leave it out.',
	'EMAIL_EQ_EMAIL'			=> 'You can’t invite yourself.',
	'EMAIL_SENT_FAILURE'		=> 'An error occured while sending the e-mail.',
	'TOO_SHORT_NAME'			=> 'The name you entered is too short.',
	'TOO_SHORT_SUBJECT'			=> 'The subject you entered is too short.',
	'TOO_SHORT_MESSAGE'			=> 'The message you entered is too short.',
	'TOO_LONG_NAME'				=> 'The name you entered is too long.',
	'TOO_LONG_SUBJECT'			=> 'The subject you entered is too long.',
	'TOO_LONG_MESSAGE'			=> 'The message you entered is too long.',
	'WAIT_NEXT_IAF'				=> 'You have to wait a while until you can send another e-mail to a friend of yours.',
));

?>