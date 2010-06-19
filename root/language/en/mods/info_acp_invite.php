<?php
/**
*
* info_acp_invite [English]
*
* @package language
* @version $Id: info_acp_invite.php 8645 2008-10-03 10:40:17Z Bycoja $
* @copyright (c) 2008 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
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

// Permissions
$lang = array_merge($lang, array(
    'acl_u_send_iaf'	=> array('lang' => 'Can send invitations to friends', 'cat' => 'misc'),
));

$lang = array_merge($lang, array(
	// General
	'ACP_INVITE_A_FRIEND'				=> 'Invite a friend',
	'ACP_INVITE_A_FRIEND_EXPLAIN'		=> 'Here you can set all default settings for the e-mails which users can send to their friends.',
	'ACP_INVITE_A_FRIEND_LOG'			=> 'Invite a friend - Log',
	'ACP_INVITE_A_FRIEND_LOG_EXPLAIN'	=> 'Here you can see information on all invitations sent to friends of your members.',
	
	// Errors
	'ERROR_SETTINGS'					=> 'You have to fill in all fields correctly.',
	
	// Log
	'LOG_IAF_SETTINGS_UPDATED'			=> '<strong>Altered \'Invite a friend\' settings</strong>',
	
	'DATE'								=> 'Date',
	'INVITATIONS'						=> 'Invitations',
	'REGISTRATIONS'						=> 'Registered friends',
	
	// Settings
	'SETTINGS_ENABLE'					=> 'Enable invitations',
	'SETTINGS_AUTH_KEY'					=> 'Enable registration-keys',
	'SETTINGS_AUTH_KEY_EXPLAIN'			=> 'New users will need a registration-key, which is obtained by e-mail, to register.',
	'SETTINGS_SELF_INVITE'				=> 'Limit invitations',
	'SETTINGS_SELF_INVITE_EXPLAIN'		=> 'Prohibit sending invitations to yourself all the time. You must not use more than one registration-key each IP if enabled.',
	'SETTINGS_MULTI_EMAIL'				=> 'Allow multiple invitations',
	'SETTINGS_MULTI_EMAIL_EXPLAIN'		=> 'Multiple invitations can be send to the same e-mail address.',
	'SETTINGS_CONFIRM_EMAIL'			=> 'Confirmation e-mail',
	'SETTINGS_CONFIRM_EMAIL_EXPLAIN'	=> 'If a invited friend registers, a confirmation e-mail will be send to the appropriate user.',
	'SETTINGS_SEND_NOW'					=> 'Send e-mails immediately',
	'SETTINGS_SEND_NOW_EXPLAIN'			=> 'Send e-mails without any delay to friends.',
	'SETTINGS_MESSAGE_CHARS'			=> 'Message length',
	'SETTINGS_MESSAGE_CHARS_EXPLAIN'	=> 'Minimum and maximum number of characters in messages.',
	'SETTINGS_SUBJECT_CHARS'			=> 'Subject length',
	'SETTINGS_SUBJECT_CHARS_EXPLAIN'	=> 'Minimum and maximum number of characters in subjects.',
	'SETTINGS_KEY_CHARS'				=> 'Registration-key length',
	'SETTINGS_KEY_CHARS_EXPLAIN'		=> 'Minimum and maximum number of characters in registration-keys.',
	'SETTINGS_CHARSET'					=> 'Characters used in registration-keys',
	'SETTINGS_CHARSET_EXPLAIN'			=> 'Possible characters registration-keys may consist of.',
	'SETTINGS_TIME'						=> 'Elapsed time',
	'SETTINGS_TIME_EXPLAIN'				=> 'Users have to wait the here entered period of time to send a new message.',
	
	'SETTINGS_IAF_MESSAGE_EXPLAIN'		=> 'The e-mails users send to their friends will be embed into the following message:',
	'SETTINGS_CONFIRM_MESSAGE_EXPLAIN'	=> 'The following message will be send to a user if the invited friend registers:',
));
?>