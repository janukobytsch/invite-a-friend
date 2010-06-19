<?php
/**
* @author Bycoja bycoja@web.de
* info_acp_invite [Deutsch — Du]
*
* @package language
* @version $Id: info_acp_invite.php 053 2009-11-24 22:35:59GMT Bycoja $
* @copyright (c) 2008 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Deutsche Übersetzung durch den Autor:
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

// Permissions
$lang = array_merge($lang, array(
    'acl_u_send_invite'	=> array('lang' => 'Kann Einladungen an Freunde senden', 'cat' => 'misc'),
));

$lang = array_merge($lang, array(
	'ACP_INVITE_INSTALLED'				=> '»Freunde einladen« wurde erfolgreich installiert und kann unter dem Reiter "Allgemein" aufgerufen werden.<br/><br/>%s»Freunde einladen« aufrufen%s',
	'ACP_INVITE'						=> 'Freunde einladen',
	'ACP_INVITE_EXPLAIN'				=> 'Hier kannst du die Einstellungen bezüglich der E-Mails, mit denen Benutzer Freunde werben können, vornehmen.',
	'ACP_INVITE_LOG'					=> 'Einladungs-Protokoll',
	'ACP_INVITE_LOG_EXPLAIN'			=> 'Diese Liste zeigt alle Vorgänge, die mit den von Benutzern versendeten Einladungen in Verbindung stehen. Du kannst dir auch detaillierte Informationen zu einzelnen Benutzern anzeigen lassen.',
	'JAVASCRIPT_NOTICE'					=> 'Du musst <b>JavaScript</b> aktivieren, um alle Einstellungsmöglichkeiten nutzen zu können.',

	'ACC_TRANSFER'						=> 'Übernehmen',
	'OPTIONAL'							=> 'Optional',
	'INVITE_INVITE'						=> 'Einladung',
	'INVITE_CONFIRM'					=> 'Bestätigung',
	'VIEWTOPIC'							=> 'Thema',
	'MEMBERLIST_VIEW'					=> 'Profil',
	'INVITE_INFO'						=> 'Details',

	'SETTINGS_ENABLE'							=> '»Freunde einladen« aktivieren',
	'SETTINGS_ENABLE_KEY'						=> 'Registrierungs-Schlüssel anfordern',
	'SETTINGS_ENABLE_KEY_EXPLAIN'				=> 'Einen Registrierungs-Schlüssel, der zuvor von einem Freund versendet wurde, zur Registrierung neuer Benutzer anfordern.',
	'SETTINGS_KEY_GROUP_EXPLAIN'				=> 'Benutzer, die einen Registrierungs-Schlüssel angeben, werden automatisch zu der hier ausgewählten Benutzergruppe hinzugefügt.',
	'SETTINGS_CONFIRM'							=> 'Bestätigung versenden',
	'SETTINGS_CONFIRM_EXPLAIN'					=> 'Diese Einstellung legt fest, ob eine Bestätigung an Benutzer, deren eingeladene Freunde sich registrieren, versendet wird.',
	'SETTINGS_ZEBRA'							=> 'Freundesliste',
	'SETTINGS_ZEBRA_EXPLAIN'					=> 'Eingeladene Freunde automatisch zur Freundesliste hinzufügen.',
	'SETTINGS_INVITE_ACC_ACTIVATION_EXPLAIN'	=> 'Diese Einstellung legt fest, ob Benutzer, die bei der Registrierung einen Registrierungs-Schlüssel angeben, sofortigen Zugang zum Board haben. Du kannst auch die Registrierungs-Einstellung übernehmen.',
	'SETTINGS_INVITE_CONFIRM_CODE'				=> 'CAPTCHA verwenden',
	'SETTINGS_INVITE_CONFIRM_CODE_EXPLAIN'		=> 'Um automatisiertes Versenden von Einladungen zu unterbinden, muss beim Versenden ein Bestätigungscode eingegeben werden.',
	'SETTINGS_INVITE_MULTIPLE'					=> 'Mehrfache Einladung',
	'SETTINGS_INVITE_MULTIPLE_EXPLAIN'			=> 'Erlaubt das Versenden mehrerer Einladungen an die gleiche E-Mail-Adresse.',
	'SETTINGS_INVITE_YOURSELF'					=> 'Eigene Einladung',
	'SETTINGS_INVITE_YOURSELF_EXPLAIN'			=> 'Erlaubt die Registrierung mit Schlüsseln, die von Benutzern an sich selbst versendet wurden.',
	'SETTINGS_INVITE_LANGUAGE_SELECT'			=> 'Sprachauswahl',
	'SETTINGS_INVITE_LANGUAGE_SELECT_EXPLAIN'	=> 'Der Absender kann die Sprache einer Einladung frei auswählen.',

	'SETTINGS_QUEUE_TIME'						=> 'Wartezeit',
	'SETTINGS_QUEUE_TIME_EXPLAIN'				=> 'Ein Benutzer muss zum Versenden einer neuen E-Mail die hier angegebene Zeitspanne warten.',
	'SETTINGS_MESSAGE_CHARS'					=> 'Länge der Nachricht',
	'SETTINGS_MESSAGE_CHARS_EXPLAIN'			=> 'Die minimale und maximale Anzahl an Zeichen in der Nachricht.',
	'SETTINGS_SUBJECT_CHARS'					=> 'Länge des Betreffs',
	'SETTINGS_SUBJECT_CHARS_EXPLAIN'			=> 'Die minimale und maximale Anzahl an Zeichen im Betreff.',
	'SETTINGS_MESSAGE_INVITE_EXPLAIN'			=> 'Die Nachricht, die Benutzer an Freunde versenden, wird in folgende Nachricht eingebettet.',
	'SETTINGS_MESSAGE_CONFIRM_EXPLAIN'			=> 'Die Nachricht, die an einen Benutzer versendet wird, wenn sich ein geworbener Freund registriert.',

	'SETTINGS_LIMIT_INVITE'						=> 'Beschränkung der Einladungen',
	'SETTINGS_LIMIT_INVITE_EXPLAIN'				=> '1. Feld: Die maximale Anzahl versendeter Einladungen (Grundwert).<br/>2. Feld: 1. Wert erhöht sich alle x Beiträge um 1 Einladung.<br/>3. Feld: 1. Wert erhöht sich alle x Themen um 1 Einladung.<br/>(0 = keine Beschränkung)',
	'INVITE_DAILY'								=> 'Täglich',
	'INVITE_TOTAL'								=> 'Insgesamt',
	'INVITATIONS'								=> 'Einladungen',

	'DISPLAY_OPTIONS'							=> 'Anzeige-Optionen',
	'SETTINGS_DISPLAY_NAVIGATION'				=> 'Navigations-Link anzeigen',
	'SETTINGS_DISPLAY_NAVIGATION_EXPLAIN'		=> 'Einen Link zum Verfassen von Einladungen im Persönlichen Bereich in der oberen Navigation angezeigen.',
	'SETTINGS_DISPLAY_REGISTRATION'				=> 'Eingabefeld anzeigen',
	'SETTINGS_DISPLAY_REGISTRATION_EXPLAIN'		=> 'Das Eingabefeld für Registrierungs-Schlüssel bei der Registrierung anzeigen.',
	'SETTINGS_PROFILE_FIELDS'					=> 'Profilfelder anzeigen',
	'SETTINGS_PROFILE_FIELDS_EXPLAIN'			=> 'Die angegebenen Profilfelder an dem hier ausgewählten Ort anzeigen.',	
	'DISPLAY_INVITE'							=> 'Versendete Einladungen',
	'DISPLAY_REGISTER'							=> 'Geworbene Benutzer',
	'DISPLAY_NAME'								=> 'Geworbene Benutzer (Namen)',

	'ERROR_EMAIL_DISABLED'						=> 'Die E-Mail-Funktionalität ist deaktiviert, sodass keine Einladungen über das Board versendet werden können.<br /><br /><a href="%s">» Aktiviere E-Mail-Funktionalität</a>',
	'ERROR_INVITE_SETTINGS'						=> 'Du musst alle Felder korrekt ausfüllen.',
	'ERROR_MESSAGE_INVITE'						=> 'Du musst alle Einladungen ausfüllen.',
	'ERROR_MESSAGE_CONFIRM'						=> 'Du musst alle Bestätigungen ausfüllen.',

	'LOG_INVITE_SETTINGS_UPDATED'				=> '<strong>Einstellungen zum Einladen von Freunden geändert</strong>',
	'LOG_INVITE_INVITE'							=> '<strong>Einladung versendet</strong><br/>» an „%1$s“',
	'LOG_INVITE_CONFIRM'						=> '<strong>Bestätigung versendet</strong><br/>» an „%1$s“ zur Bestätigung der Registrierung von „%2$s“',
	'LOG_INVITE_REGISTER'						=> '<strong>Registrierungs-Schlüssel verwendet</strong><br/>» zur Registrierung des Benutzers „%1$s“',
	'LOG_INVITE_ZEBRA'							=> '<strong>„%1$s“ als Freund hinzugefügt</strong><br/>» von „%2$s“',

	//Plugins
	'ULTIMATE_POINTS_SETTINGS'			=> 'Ultimate Points-Einstellungen',
	'ULTIMATE_POINTS_ENABLE'			=> 'Ultimate Points aktivieren',
	'ULTIMATE_POINTS_INVITE'			=> 'Ultimate Points pro Einladung',
	'ULTIMATE_POINTS_INVITE_EXPLAIN'	=> 'Die Menge Ultimate Points, die für Einladungen vergeben wird.',
	'ULTIMATE_POINTS_REGISTER'			=> 'Ultimate Points pro Registrierung',
	'ULTIMATE_POINTS_REGISTER_EXPLAIN'	=> 'Die Menge Ultimate Points, die für Registrierungen eingeladener Freunde vergeben wird.',

	'CASH_SETTINGS'						=> 'Cash-Einstellungen',
	'CASH_ENABLE'						=> 'Cash aktivieren',
	'CASH_INVITE'						=> 'Cash pro Einladung',
	'CASH_INVITE_EXPLAIN'				=> 'Die Menge Cash, die für Einladungen vergeben wird.',
	'CASH_REGISTER'						=> 'Cash pro Registrierung',
	'CASH_REGISTER_EXPLAIN'				=> 'Die Menge Cash, die für Registrierungen eingeladener Freunde vergeben wird.',

));
?>