<?php
/**
*
* info_acp_invite [Deutsch - Du]
*
* @author Bycoja bycoja@web.de
* @package language
* @version $Id info_ucp_invite.php 0.7.0 2012-06-22 17:28:02GMT Bycoja $
* @copyright (c) 2008-2012 Bycoja
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
	'UCP_INVITE'					=> 'Einladungen',
	'UCP_INVITE_INVITE'				=> 'Einladung schreiben',
	'UCP_INVITE_DESCRIPTION'		=> 'Sende eine E-Mail an deine Freunde und erzähle ihnen von diesem Board.',
	'REGISTER_KEY'					=> 'Einladungscode',
	'REGISTER_KEY_EXPLAIN'			=> 'Von einem Benutzer des Boards erhalten.',
	'REFERRED_BY'					=> 'Angeworben von',
	'REFERRED_BY_EXPLAIN'			=> 'Der Benutzername der Person, die dich angeworben hat',

	// Invitation form
	'RECIPIENT_EMAIL'				=> 'E-Mail-Adresse des Freundes',
	'RECIPIENT_NAME'				=> 'Name des Freundes',
	'ADD_RECIPIENT'					=> 'Empfänger hinzufügen',
	'DELETE_RECIPIENT'				=> 'Empfänger entfernen',
	'MESSAGE_EXPLAIN'				=> 'Erzähle deinem Freund, was dir an diesem Board gefällt.',
	'SEND_CONFIRMATION'				=> 'Eine Bestätigung erhalten',
	'SEND_CONFIRMATION_METHOD'		=> 'Eine Bestätigung erhalten via',
	'INVITATION_ZEBRA'				=> 'Eingeladenen Benutzer als Freund hinzufügen',
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
	'INVITE_YOURSELF'				=> 'Der Einladungscode wurde von deinem Computer aus versendet. Um Missbrauch zu verhindern, darfst du ihn nicht verwenden.',
	'INVITE_TO_YOUR_EMAIL'			=> 'Die angegebene E-Mail-Adresse wird bereits von dir verwendet.',
	'INVITE_MULTIPLE'				=> 'Die angegebene E-Mail-Adresse hat bereits eine Einladung erhalten.',
	'INVITE_SAME_RECIPIENT'			=> 'Du kannst nicht mehrere Einladungen an die gleiche E-Mail-Adresse versenden.',
	'REGISTER_KEY_INVALID'			=> 'Der angegebene Einladungscode ist ungültig.',
	'REGISTER_KEY_INVALID_OPTIONAL'	=> 'Der angegebene Einladungscode ist ungültig, lasse ihn stattdessen aus.',
	'TOO_SHORT_REGISTER_REAL_NAME'	=> 'Der angegebene Name ist zu kurz.',
	'TOO_SHORT_SUBJECT'				=> 'Der angegebene Betreff ist zu kurz.',
	'TOO_SHORT_MESSAGE'				=> 'Die angegebene Nachricht ist zu kurz.',
	'TOO_LONG_REGISTER_REAL_NAME'	=> 'Der angegebene Name ist zu lang.',
	'TOO_LONG_SUBJECT'				=> 'Der angegebene Betreff ist zu lang.',
	'TOO_LONG_MESSAGE'				=> 'Die angegebene Nachricht ist zu lang.',
	'TOO_FEW_POSTS'					=> 'Du benötigst mindestens %d Beiträge, um Einladungen verschicken zu können.',
	'REGISTER_KEY_EXPIRED'			=> 'Der angegebene Einladungscode ist nicht mehr gültig.',
	'REFERRER_REQUIRED'				=> 'Du musst den Benutzernamen der Person, die dich angeworben hat, angeben.',
	'REFERRER_NOT_EXISTENT'			=> 'Der Benutzer, der dich angeworben haben soll, existiert nicht.',

	// Powered by
	'INVITE_POWERED_BY'				=> 'Powered by Invite A Friend © 2008-2012 <a href="http://jjacoby.de/" target="_blank">Bycoja</a>',

	// CAPTCHA
	'POST_CONFIRM_EXPLAIN'			=> 'Um automatisiertes Versenden von Einladungen zu unterbinden, musst du einen Bestätigungscode angeben. Der Code ist in dem Bild unterhalb dieses Textes enthalten. Wenn du nur über ein eingeschränktes Sehvermögen verfügst oder aus einem anderen Grund den Code nicht lesen kannst, kontaktiere bitte die Board-Administration.',

));
?>