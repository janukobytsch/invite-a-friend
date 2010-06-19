<?php
/**
*
* info_acp_invite [Deutsch]
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
    'acl_u_send_iaf'	=> array('lang' => 'Kann Einladungen an Freunde senden', 'cat' => 'misc'),
));

$lang = array_merge($lang, array(
	// General
	'UCP_INVITE'						=> 'Freunde einladen',
	'UCP_INVITE_INVITE'					=> 'Einladung schreiben',
	'ACP_INVITE_A_FRIEND'				=> 'Freunde einladen',
	'ACP_INVITE_A_FRIEND_EXPLAIN'		=> 'Hier kannst du die Einstellungen bezüglich der E-Mails, die Benutzer an Freunde verschicken können, vornehmen.',
	'ACP_INVITE_A_FRIEND_LOG'			=> 'Einladungs-Protokoll',
	'ACP_INVITE_A_FRIEND_LOG_EXPLAIN'	=> 'Hier kannst du Information zu allen Einladungen, die von Benutzern versendet wurden, finden.',
	
	// Errors
	'ERROR_SETTINGS'					=> 'Du musst alle Felder korrekt ausfüllen.',
	
	// Log
	'LOG_IAF_SETTINGS_UPDATED'			=> '<strong>Einstellungen zum Einladen von Freunden geändert</strong>',
	'LOG_INVITE_EMAIL'					=> '<strong>Einladung versendet</strong><br/>» an „%1$s“',
	'LOG_INVITE_CONFIRM_EMAIL'			=> '<strong>E-Mail-Bestätigung versendet</strong><br/>» an „%1$s“ zur Bestätigung der Registrierung von „%2$s“',
	'LOG_INVITE_KEY_USED'				=> '<strong>Registrierungs-Schlüssel verwendet</strong><br/>» zur Registrierung des Benutzers „%1$s“',
	'LOG_CASH_INVITATION'				=> '<strong>%2$s „%3$s“ vergeben</strong><br/>» aufgrund der an „%1$s“ gesendeten Einladung',
	'LOG_CASH_REGISTRATION'				=> '<strong>%2$s „%3$s“ vergeben</strong><br/>» aufgrund der Registrierung des Benutzers „%1$s“',
	
	'INVITE_INFO'						=> 'Details',
	'INVITATIONS'						=> 'Versendete Einladungen',
	'REGISTRATIONS'						=> 'Geworbene Benutzer',
	
	// Settings
	'SETTINGS_ENABLE'					=> 'Einladung von Freunden aktivieren',
	'SETTINGS_AUTH_KEY'					=> 'Registrierungs-Schlüssel aktivieren',
	'SETTINGS_AUTH_KEY_EXPLAIN'			=> 'Neue Benutzer können sich nur noch mit Registrierungs-Schlüsseln, die von Freunden versendet werden, registrieren.',
	'SETTINGS_SELF_INVITE'				=> 'Einladungen beschränken',
	'SETTINGS_SELF_INVITE_EXPLAIN'		=> 'Verhindert das ständige Versenden von Einladungen an sich selbst, indem nur ein Registrierungs-Schlüssel pro IP verwendet werden kann.',
	'SETTINGS_MULTI_EMAIL'				=> 'Mehrere Einladungen zulassen',
	'SETTINGS_MULTI_EMAIL_EXPLAIN'		=> 'Erlaubt das Versenden mehrerer Einladungen an die gleiche E-Mail-Adresse.',
	'SETTINGS_CONFIRM_EMAIL'			=> 'E-Mail-Bestätigung',
	'SETTINGS_CONFIRM_EMAIL_EXPLAIN'	=> 'Sendet eine E-Mail zur Bestätigung an einen Benutzer, wenn sich der eingeladene Freund registriert.',
	'SETTINGS_SEND_NOW'					=> 'E-Mails sofort versenden',
	'SETTINGS_SEND_NOW_EXPLAIN'			=> 'E-Mails an Freunde ohne Verzögerung versenden.',
	'SETTINGS_MESSAGE_CHARS'			=> 'Länge der Nachricht',
	'SETTINGS_MESSAGE_CHARS_EXPLAIN'	=> 'Die minimale und maximale Anzahl an Zeichen in der Nachricht.',
	'SETTINGS_SUBJECT_CHARS'			=> 'Länge des Betreffs',
	'SETTINGS_SUBJECT_CHARS_EXPLAIN'	=> 'Die minimale und maximale Anzahl an Zeichen im Betreffs.',
	'SETTINGS_KEY_CHARS'				=> 'Länge des Registrierungs-Schlüssels',
	'SETTINGS_KEY_CHARS_EXPLAIN'		=> 'Die minimale und maximale Anzahl an Zeichen im Registrierungs-Schlüssels.',
	'SETTINGS_CHARSET'					=> 'Zeichen im Registrierungs-Schlüssel',
	'SETTINGS_CHARSET_EXPLAIN'			=> 'Mögliche Zeichen aus denen der Registrierungs-Schlüssel zusammengesetzt wird.',
	'SETTINGS_TIME'						=> 'Vergangene Zeit',
	'SETTINGS_TIME_EXPLAIN'				=> 'Ein Benutzer muss zum Versenden einer neuen E-Mail die hier angegebene Zeitspanne warten.',
	
	'SETTINGS_IAF_MESSAGE_EXPLAIN'		=> 'Die Nachricht, die Benutzer an Freunde versenden, wird in folgende Nachricht eingebettet. Als Platzhalter wird {MESSAGE} verwendet.',
	'SETTINGS_CONFIRM_MESSAGE_EXPLAIN'	=> 'Die Nachricht, die an einen Benutzer versendet wird, wenn sich der geworbene Freund registriert.',

	// Cash settings
	'CASH_ENABLE'						=> 'Cash aktivieren',
	'CASH_INVITATION'					=> 'Cash pro Einladung',
	'CASH_INVITATION_EXPLAIN'			=> 'Die Menge Cash, die für Einladungen vergeben wird.',
	'CASH_REGISTRATION'					=> 'Cash pro Registrierung',
	'CASH_REGISTRATION_EXPLAIN'			=> 'Die Menge Cash, die für Registrierungen eingeladener Freunde vergeben wird.',
));
?>