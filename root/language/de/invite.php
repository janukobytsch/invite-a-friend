<?php
/**
*
* invite [Deutsch]
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
	'INVITE_A_FRIEND'			=> 'Freunde einladen',
	'UCP_INVITE'				=> 'Freunde einladen',
	'UCP_INVITE_INVITE'			=> 'Einladung schreiben',
	'INVITE_A_FRIEND_DESC'		=> 'Sende eine E-Mail an einen deiner Freunde und mache ihn auf dieses Forum aufmerksam',
	'INVITE_CONFIRM_EMAIL'		=> 'Bestätigung - Freunde einladen',
	'OPTIONAL'					=> 'Optional',
	
	// Form
	'AUTH_KEY'					=> 'Registrierungs-Schlüssel',
	'AUTH_KEY_EXPLAIN'			=> 'Von einem Benutzer des Boards per E-Mail erhalten.',
	'AUTH_KEY_DISABLED'			=> 'Zur Zeit wird kein Registrierungs-Schlüssel benötigt.',
	'EMAIL_SENT_SUCCESS'		=> 'Die E-Mail wurde erfolgreich versendet.',
	'FRIENDS_EMAIL'				=> 'E-Mail-Adresse des Freundes',
	'FRIENDS_NAME'				=> 'Name des Freundes',
	'SEND_CONFIRM_EMAIL'		=> 'Bestätigung senden',
	
	// Errors
	'IAF_DISABLED'				=> 'Das Einladen von Freunden wurde von der Board-Administration deaktiviert.',
	'INVITE_YOURSELF'			=> 'Du kannst pro IP nur einen Registrierungs-Schlüssel verwenden.',
	
	'ALREADY_INVITED'			=> 'Die von dir angegebene E-Mail-Adresse hat bereits eine Einladung erhalten.',
	'AUTH_KEY_WRONG'			=> 'Der Registrierungs-Schlüssel ist ungültig.',
	'OPTIONAL_AUTH_KEY_WRONG'	=> 'Der Registrierungs-Schlüssel ist ungültig, lasse ihn stattdessen aus.',
	'EMAIL_EQ_EMAIL'			=> 'Du kannst dich nicht selbst einladen.',
	'EMAIL_SENT_FAILURE'		=> 'Beim Versenden der E-Mail ist ein Fehler aufgetreten.',
	'TOO_SHORT_NAME'			=> 'Der von dir angegebene Name ist zu kurz.',
	'TOO_SHORT_SUBJECT'			=> 'Der von dir angegebene Betreff ist zu kurz.',
	'TOO_SHORT_MESSAGE'			=> 'Die von dir angegebene Nachricht ist zu kurz.',
	'TOO_LONG_NAME'				=> 'Der von dir angegebene Name ist zu lang.',
	'TOO_LONG_SUBJECT'			=> 'Der von dir angegebene Betreff ist zu lang.',
	'TOO_LONG_MESSAGE'			=> 'Die von dir angegebene Nachricht ist zu lang.',
	'WAIT_NEXT_IAF'				=> 'Du musst bis zum Versenden der nächsten Nachricht noch eine Weile warten.',
));

?>