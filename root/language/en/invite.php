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
	'INVITE_A_FRIEND'		=> 'Invite a friend',
	'INVITE_A_FRIEND_DESC'	=> 'Send an e-mail to a friend of yours and advise him of this board',
	'IAF_DISABLED'			=> 'Inviting friends is currently disabled.',
	
	'AUTH_KEY'				=> 'Registration-key',
	'AUTH_KEY_EXPLAIN'		=> 'Obtained by a user of this board via e-mail.',
	'AUTH_KEY_WRONG'		=> 'The registration-key is invalid.',
	'EMAIL_SENT_SUCCESS'	=> 'The e-mail was successfully sent to your friend.',
	'EMAIL_SENT_FAILURE'	=> 'An error occured while sending the e-mail.',
	'FRIENDS_EMAIL'			=> 'Your friend\'s e-mail address',
	'FRIENDS_NAME'			=> 'Your friend\'s name',
	
	'TOO_SHORT_NAME'		=> 'The name you entered is too short.',
	'TOO_SHORT_SUBJECT'		=> 'The subject you entered is too short.',
	'TOO_SHORT_MESSAGE'		=> 'The message you entered is too short.',
	'TOO_LONG_NAME'			=> 'The name you entered is too long.',
	'TOO_LONG_SUBJECT'		=> 'The subject you entered is too long.',
	'TOO_LONG_MESSAGE'		=> 'The message you entered is too long.',
	'WAIT_NEXT_IAF'			=> 'You have to wait a while until you can send another e-mail to a friend of yours.',
));

?>