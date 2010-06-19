<?php
/**
* @author Bycoja bycoja@web.de
* info_acp_invite [Deutsch]
*
* @package language
* @version $Id: info_acp_invite.php 9017 2009-02-28 12:24:11Z Bycoja $
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
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'UCP_INVITE'					=> 'Freunde einladen',
	'UCP_INVITE_INVITE'				=> 'Einladung schreiben',
	'UCP_INVITE_DESCRIPTION'		=> 'Sendet eine E-Mail an einen Freund und macht ihn auf dieses Forum aufmerksam.',
	
	'RECIPIENT_EMAIL'				=> 'E-Mail-Adresse des Freundes',
	'RECIPIENT_NAME'				=> 'Name des Freundes',
	'SEND_CONFIRM'					=> 'Bestätigung senden',
	'SEND_CONFIRM_METHOD'			=> 'Bestätigung empfangen als',
	'INVITE_ZEBRA'					=> 'Zur Freundesliste hinzufügen',
	'OPTIONAL'						=> 'Optional',
	
	'INVITE_CONFIRM'				=> 'Bestätigung - Freunde einladen',
	'INVITE_CONFIRMATION'			=> 'Bestätigung der Einladung',
	'INVITE_CONFIRM_EXPLAIN'		=> 'Um automatisiertes Versenden von Einladungen zu unterbinden, musst du einen Bestätigungscode angeben. Der Code ist in dem Bild unterhalb dieses Textes enthalten. Wenn du nur über ein eingeschränktes Sehvermögen verfügst oder aus einem anderen Grund den Code nicht lesen kannst, kontaktiere bitte die Board-Administration.',
	
	'REGISTER_KEY'					=> 'Registrierungs-Schlüssel',
	'REGISTER_KEY_EXPLAIN'			=> 'Von einem Benutzer des Boards per E-Mail erhalten.',
	'REGISTER_KEY_DISABLED'			=> 'Zur Zeit wird kein Registrierungs-Schlüssel benötigt.',
	
	'QUEUE_QUEUE'					=> 'Du musst bis zum Versenden der nächsten Nachricht noch eine Weile warten.',
	'QUEUE_LIMIT_INVITE_DAY'		=> 'Du hast das Tageslimit erreicht und kannst heute keine weiteren Einladungen versenden.',
	'QUEUE_LIMIT_INVITE_USER'		=> 'Du hast das Benutzerlimit erreicht und kannst keine weiteren Einladungen versenden.',
	'INVITE_DISABLED'				=> 'Das Einladen von Freunden wurde von der Board-Administration deaktiviert.',
	'INVITE_YOURSELF'				=> 'Du kannst dich nicht mit von dir versendeten Registrierungs-Schlüsseln registrieren.',
	'INVITE_TO_YOUR_EMAIL'			=> 'Du kannst dich nicht selbst einladen.',
	
	'EMAIL_SENT_FAILURE'			=> 'Beim Versenden der E-Mail ist ein Fehler aufgetreten.',
	'EMAIL_SENT_SUCCESS'			=> 'Die E-Mail wurde erfolgreich versendet.',
	'EMAIL_INVALID'					=> 'Die angegebene E-Mail-Adresse ist ungültig.',
	'INVITE_MULTIPLE'				=> 'Die angegebene E-Mail-Adresse hat bereits eine Einladung erhalten.',
	'REGISTER_KEY_INVALID'			=> 'Der angegebene Registrierungs-Schlüssel ist ungültig.',
	'REGISTER_KEY_INVALID_OPTIONAL'	=> 'Der angegebene Registrierungs-Schlüssel ist ungültig, lasse ihn stattdessen aus.',
	'TOO_SHORT_REGISTER_REAL_NAME'	=> 'Der angegebene Name ist zu kurz.',
	'TOO_SHORT_SUBJECT'				=> 'Der angegebene Betreff ist zu kurz.',
	'TOO_SHORT_MESSAGE'				=> 'Die angegebene Nachricht ist zu kurz.',
	'TOO_LONG_REGISTER_REAL_NAME'	=> 'Der angegebene Name ist zu lang.',
	'TOO_LONG_SUBJECT'				=> 'Der angegebene Betreff ist zu lang.',
	'TOO_LONG_MESSAGE'				=> 'Die angegebene Nachricht ist zu lang.',
	
));
?>