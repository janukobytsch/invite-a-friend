<?php
/**
*
* info_acp_invite [Deutsch - Du]
*
* @author Bycoja bycoja@web.de
* @package language
* @version $Id info_ucp_invite.php 0.6.2 2010-06-22 17:28:02GMT Bycoja $
* @copyright (c) 2010 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* German tranlation by:
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
	'UCP_INVITE'					=> 'Freunde einladen',
	'UCP_INVITE_INVITE'				=> 'Einladung schreiben',
	'UCP_INVITE_DESCRIPTION'		=> 'Sendet eine E-Mail an einen Freund und macht ihn auf dieses Forum aufmerksam.',
	'REGISTER_KEY'					=> 'Registrierungs-Schlüssel',
	'REGISTER_KEY_EXPLAIN'			=> 'Von einem Benutzer des Boards per E-Mail erhalten.',

	// Invitation form
	'RECIPIENT_EMAIL'				=> 'E-Mail-Adresse des Freundes',
	'RECIPIENT_NAME'				=> 'Name des Freundes',
	'ADD_RECIPIENT'					=> 'Empfänger hinzufügen',
	'DELETE_RECIPIENT'				=> 'Empfänger entfernen',
	'MESSAGE_EXPLAIN'				=> 'Erzähle deinem Freund, warum er dieses Board unbedingt besuchen muss.',
	'SEND_CONFIRMATION'				=> 'Bestätigung empfangen',
	'SEND_CONFIRMATION_METHOD'		=> 'Bestätigung empfangen als',
	'INVITATION_ZEBRA'				=> 'Eingeladenen Benutzer zur Freundesliste hinzufügen',
	'OPTIONAL'						=> 'Optional',

	// Error messages
	'EMAIL_DISABLED'				=> 'Du kannst keine Einladung versenden, da die E-Mail-Funktionalität des Boards ist deaktiviert.',
	'EMAIL_SENT_FAILURE'			=> 'Beim Versenden der E-Mail ist ein Fehler aufgetreten.',
	'EMAIL_SENT_SUCCESS'			=> 'Die E-Mail wurde erfolgreich versendet.',
	'INVITE_DISABLED'				=> 'Das Einladen von Freunden wurde von der Board-Administration deaktiviert.',
	'QUEUE_QUEUE'					=> 'Du musst %d:%02d Minuten bis zum Versenden der nächsten Einladung warten.',
	'INVITATION_LIMIT_DAILY'		=> 'Du hast das Tageslimit von %d Einladungen erreicht und kannst heute keine weiteren Einladungen versenden.',
	'INVITATION_LIMIT_TOTAL'		=> 'Du hast das Gesamtlimit von %d Einladungen erreicht und kannst keine weiteren Einladungen versenden.',
	'INVITATION_LIMIT_DAILY_MULTI'	=> 'Du hast heute %d/%d Einladungen versendet und überschreitest das Tageslimit, wenn du %d Einladungen versendest.',
	'INVITATION_LIMIT_TOTAL_MULTI'	=> 'Du hast insgesamt %d/%d Einladungen versendet und überschreitest das Gesamtlimit, wenn du %d Einladungen versendest.',
	'REDUCE_RECIPIENTS'				=> 'Bitte verringere die Anzahl der Empfänger.',
	'INVITE_YOURSELF'				=> 'Der Registrierungs-Schlüssel wurde von deinem Computer aus versendet. Um Missbrauch zu verhindern, darfst du ihn nicht verwenden.',
	'INVITE_TO_YOUR_EMAIL'			=> 'Die angegebene E-Mail-Adresse wird bereits von dir verwendet. Du kannst dich nicht selbst einladen.',
	'INVITE_MULTIPLE'				=> 'Die angegebene E-Mail-Adresse hat bereits eine Einladung erhalten.',
	'INVITE_SAME_RECIPIENT'			=> 'Du kannst nicht mehrere Einladungen an die gleiche E-Mail-Adresse versenden.',
	'REGISTER_KEY_INVALID'			=> 'Der angegebene Registrierungs-Schlüssel ist ungültig.',
	'REGISTER_KEY_INVALID_OPTIONAL'	=> 'Der angegebene Registrierungs-Schlüssel ist ungültig, lasse ihn stattdessen aus.',
	'TOO_SHORT_REGISTER_REAL_NAME'	=> 'Der angegebene Name ist zu kurz.',
	'TOO_SHORT_SUBJECT'				=> 'Der angegebene Betreff ist zu kurz.',
	'TOO_SHORT_MESSAGE'				=> 'Die angegebene Nachricht ist zu kurz.',
	'TOO_LONG_REGISTER_REAL_NAME'	=> 'Der angegebene Name ist zu lang.',
	'TOO_LONG_SUBJECT'				=> 'Der angegebene Betreff ist zu lang.',
	'TOO_LONG_MESSAGE'				=> 'Die angegebene Nachricht ist zu lang.',

	// CAPTCHA
	'POST_CONFIRM_EXPLAIN'			=> 'Um automatisiertes Versenden von Einladungen zu unterbinden, musst du einen Bestätigungscode angeben. Der Code ist in dem Bild unterhalb dieses Textes enthalten. Wenn du nur über ein eingeschränktes Sehvermögen verfügst oder aus einem anderen Grund den Code nicht lesen kannst, kontaktiere bitte die Board-Administration.',

));
?>