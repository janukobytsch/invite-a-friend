<?php
/**
*
* info_acp_invite [Deutsch - Du]
*
* @author Bycoja bycoja@web.de
* @package language
* @version $Id info_acp_invite.php 0.6.2 2010-06-22 17:28:02GMT Bycoja $
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

// Permissions
$lang = array_merge($lang, array(
	'acl_a_invite'		=> array('lang' => 'Kann die Einladungs-Einstellungen verwalten', 'cat' => 'misc'),
	'acl_a_invite_log'	=> array('lang' => 'Kann das Einladungs-Protokoll verwalten', 'cat' => 'misc'),
    'acl_u_send_invite'	=> array('lang' => 'Kann Einladungen an Freunde senden', 'cat' => 'misc'),
));

$lang = array_merge($lang, array(
	'ACP_INVITE'						=> 'Freunde einladen',
	'ACP_INVITE_SETTINGS'				=> 'Einladungs-Einstellungen',
	'ACP_INVITE_SETTINGS_EXPLAIN'		=> 'Hier kannst du alle grundlegenden Einstellungen bezüglich der Einladungen, die Benutzer an ihre Freunde versenden können, vornehmen.',
	'ACP_INVITE_TEMPLATES'				=> 'Einladungs-Templates',
	'ACP_INVITE_TEMPLATES_EXPLAIN'		=> 'Hier kannst du alle mit den Einladung in Verbindung stehende Templates ändern. Sowohl die Templates für Bestätigungen, die an den einladenden Benutzer gesendet werden, als auch die Templates für die Einladungen selbst lassen sich hier finden. Der vom Absender angegebene Betreff und die Nachricht werden in die Templates für Einladungen eingebunden und sind als Platzhalter in geschweiften Klammern anzugeben. Eine vollständige Liste aller Platzhalter findet sich in der Tabelle unterhalb. Bitte beachte, ausschließlich reinen Text und kein HTML oder BBCode zu verwenden.',
	'ACP_INVITE_LOG'					=> 'Einladungs-Protokoll',
	'ACP_INVITE_LOG_EXPLAIN'			=> 'Diese Liste zeigt alle Vorgänge, die mit den von Benutzern versendeten Einladungen in Verbindung stehen. Du kannst dir auch detaillierte Informationen zu einzelnen Benutzern anzeigen lassen, indem du das untenstehende Formular verwendest. Du musst nicht alle Felder ausfüllen.',
	'ACP_INVITE_DISPLAY_OPTIONS'		=> 'Anzeige-Optionen',
	'ACP_INVITE_LIMITATION_OPTIONS'		=> 'Beschränkung',
	'INVITATION'						=> 'Einladung',
	'INVITATION_EXPLAIN'				=> 'Sende eine Einladung an deine Freunde',

	// Error messages
	'ERROR_EMAIL_DISABLED'				=> 'Die E-Mail-Funktionalität ist deaktiviert, sodass keine Einladungen über das Board versendet werden können.<br /><br /><a href="%s">» Aktiviere E-Mail-Funktionalität</a>',
	'ERROR_INVITE_SETTINGS'				=> 'Du musst alle Felder korrekt ausfüllen.',
	'ERROR_MESSAGE_INVITE'				=> 'Du musst alle Einladungen ausfüllen.',
	'ERROR_MESSAGE_CONFIRM'				=> 'Du musst alle Bestätigungen ausfüllen.',
	'JAVASCRIPT_NOTICE'					=> 'Du musst <b>JavaScript</b> aktivieren, um alle Einstellungsmöglichkeiten nutzen zu können.',

	// Templates
	'ACP_SELECT_TEMPLATE'				=> 'Template auswählen',
	'ACP_EDIT_TEMPLATE'					=> 'Template bearbeiten',
	'TEMPLATE_TYPE'						=> 'Typ des Templates',
	'TEMPLATE_LANGUAGE'					=> 'Spraches des Templates',
	'SHOW_WILDCARDS'					=> '» Mögliche Platzhalter',
	'GENERAL_WILDCARDS'					=> 'Allgemein',
	'USER_WILDCARDS'					=> 'Benutzerspezifisch',
	'WILDCARD'							=> 'Platzhalter',
	'EXAMPLE_VALUE'						=> 'Beispielwert',
	'USER_DEFINED'						=> 'vom Benutzer angegeben',

	// Invitation log
	'LOG_FILTER'						=> 'Aktion anzeigen',
	'LOG_FILTER_ALL'					=> 'Alle',
	'LOG_FILTER_INVITE'					=> 'Einladungen',
	'LOG_FILTER_CONFIRM'				=> 'Bestätigungen',
	'LOG_FILTER_REGISTER'				=> 'Registrierungen',
	'LOG_FILTER_ZEBRA'					=> 'Freundschaften',
	'LOG_INVITE_LOG_CLEARED'			=> '<strong>Einladungs-Protokoll bearbeitet</strong>',
	'LOG_INVITE_SETTINGS_UPDATED'		=> '<strong>Einladungs-Einstellungen geändert</strong>',
	'LOG_INVITE_TEMPLATES_UPDATED'		=> '<strong>Einladungs-Templates bearbeitet</strong>',
	'LOG_INVITE_INVITE'					=> '<strong>Einladung versendet</strong><br/>» an „%1$s“',
	'LOG_INVITE_CONFIRM'				=> '<strong>Bestätigung erhalten</strong><br/>» aufgrund der Registrierung von „%2$s“',
	'LOG_INVITE_REGISTER'				=> '<strong>Registrierungs-Schlüssel verwendet</strong><br/>» zur Registrierung des Benutzers „%1$s“',
	'LOG_INVITE_ZEBRA'					=> '<strong>Freund hinzugefügt</strong><br/>» „%1$s“ aufgrund der Registrierung des eingeladenen Benutzer',

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

	// Various stuff
	'ACC_TRANSFER'						=> 'Übernehmen',
	'OPTIONAL'							=> 'Optional',
	'INVITE_INVITE'						=> 'Einladung',
	'INVITE_CONFIRM'					=> 'Bestätigung',
	'VIEWTOPIC'							=> 'Thema',
	'MEMBERLIST_VIEW'					=> 'Profil',
	'INVITATIONS'						=> 'Einladungen',
	'DISPLAY_INVITER'					=> 'Eingeladen von',
	'DISPLAY_INVITE'					=> 'Einladungen versendet',
	'DISPLAY_REGISTER'					=> 'Erfolgreiche Einladungen',
	'MEMBERDAYS'						=> 'Tage der Mitgliedschaft',
	'USER_LANGUAGE'						=> 'Sprache des Benutzers',
	'INVITATIONS_DAY'					=> '%.2f Einladungen pro Tag',
	'INVITATIONS_PCT'					=> '%.2f%% aller Einladungen',
	'REGISTRATIONS_DAY'					=> '%.2f erfolgreiche Einladungen pro Tag',
	'REGISTRATIONS_PCT'					=> '%.2f%% aller erfolgreichen Einladungen',
	'REGISTRATIONS_SUCCESS_RATE'		=> 'Persönliche Erfolgsrate von %.2f%%',
	'SEARCH_USER_REGISTRATIONS'			=> 'Erfolgreiche Einladungen des Benutzers anzeigen',
	'PAGE_TITLE_INVITE_SEARCH'			=> 'Von %s eingeladene Mitglieder',
	'USER_ADMIN_INVITATIONS'			=> 'Einladungen des Benutzers anzeigen',
	'USER_ADMIN_REGISTRATIONS'			=> 'Erfolgreiche Einladungen des Benutzers anzeigen',

	// Invitation settings
	'SETTINGS_ENABLE'							=> '»Freunde einladen« aktivieren',
	'SETTINGS_ENABLE_KEY'						=> 'Registrierungs-Schlüssel anfordern',
	'SETTINGS_ENABLE_KEY_EXPLAIN'				=> 'Beschränkt die Registrierung auf eingeladene Benutzer, hauptsächlich für private Boards.',
	'SETTINGS_KEY_GROUP'						=> 'Gruppe der Eingeladenen',
	'SETTINGS_KEY_GROUP_EXPLAIN'				=> 'Wenn zukünftige Benutzer optionalerweise einen gültigen Registrierungs-Schlüssel angeben, werden sie automatisch zur ausgewählten Benutzergruppe hinzugefügt.',
	'SETTINGS_KEY_GROUP_DEFAULT'				=> 'Ausgewählte Gruppe als Standard setzen',
	'SETTINGS_KEY_GROUP_DEFAULT_EXPLAIN'		=> 'Wenn zukünftige Benutzer optionalerweise einen gültigen Registrierungs-Schlüssel angeben, werden sie nicht nur in die ausgewählte Gruppe aufgenommen, sondern diese ist zugleich ihre Standardgruppe.',
	'SETTINGS_REMOVE_NEWLY_REGISTERED'			=> 'Aus Kürzlich Registrierte Benutzer entfernen',
	'SETTINGS_REMOVE_NEWLY_REGISTERED_EXPLAIN'	=> 'Wenn zukünftige Benutzer optionalerweise einen gültigen Registrierungs-Schlüssel angeben, werden sie aus der Benutzergruppe der Kürzlich Registrierten Benutzer entfernt.',
	'SETTINGS_INVITE_ACC_ACTIVATION_EXPLAIN'	=> 'Diese Einstellung legt fest, ob Benutzer, die bei der Registrierung optionalerweise einen gültigen Registrierungs-Schlüssel angeben, sofortigen Zugang zum Board haben. Du kannst auch die Registrierungs-Einstellung ohne Schlüssel übernehmen.',
	'SETTINGS_INVITE_MULTIPLE'					=> 'Mehrfache Einladung erlauben',
	'SETTINGS_INVITE_MULTIPLE_EXPLAIN'			=> 'Erlaubt das Versenden mehrerer Einladungen an die gleiche E-Mail-Adresse.',
	'SETTINGS_PREVENT_ABUSE'					=> 'Missbrauch vorbeugen',
	'SETTINGS_PREVENT_ABUSE_EXPLAIN'			=> 'Stellt sicher, dass die IP-Adresse des eingeladenen Benutzers nicht mit der des Einladenden übereinstimmt. Bei Verwendung von Belohnungssystemen empfohlen.',
	'SETTINGS_INVITE_CONFIRM_CODE'				=> 'Visuellen Bestätigungscode aktivieren',
	'SETTINGS_INVITE_CONFIRM_CODE_EXPLAIN'		=> 'Benutzer müssen einen durch ein Bild vorgegebenen Schlüssel eingeben, um automatisches Versenden von Einladungen zu unterbinden.',
	'SETTINGS_SET_COOKIE'						=> 'Cookie verwenden',
	'SETTINGS_SET_COOKIE_EXPLAIN'				=> 'Die Verwendung von Cookies hilft nicht nur dabei, statistische Informationen zu erheben, sondern ermöglicht es dem eingeladenen Benutzer auch, das Board vor der Registrierung zu erkunden.',
	'SETTINGS_EMAIL_IDENTIFICATION'				=> 'E-Mail-Identifikation aktivieren',
	'SETTINGS_EMAIL_IDENTIFICATION_EXPLAIN'		=> 'Bringt den eingeladenen Benutzer mit dem Einladenden durch einen Vergleich der E-Mail-Adressen in Verbindung, auch wenn kein Registrierungs-Schlüssel angegeben wird.',
	'SETTINGS_INVITE_SEARCH_ALLOWED'			=> 'Mitgliedersuche aktivieren',
	'SETTINGS_INVITE_SEARCH_ALLOWED_EXPLAIN'	=> 'Ermöglicht die Suche nach Benutzern anhand von einladungsspezifischen Kriterien. Das Kriterium selbst muss in den Anzeige-Optionen aktiviert sein.',
	'SETTINGS_QUEUE_TIME'						=> 'Wartezeit',
	'SETTINGS_QUEUE_TIME_EXPLAIN'				=> 'Die Wartezeit zwischen dem Versenden zweier Einladungen.',
	'SETTINGS_MESSAGE_CHARS'					=> 'Länge der Nachricht',
	'SETTINGS_MESSAGE_CHARS_EXPLAIN'			=> 'Die minimale und maximale Anzahl an Zeichen in der Nachricht.',
	'SETTINGS_SUBJECT_CHARS'					=> 'Länge des Betreffs',
	'SETTINGS_SUBJECT_CHARS_EXPLAIN'			=> 'Die minimale und maximale Anzahl an Zeichen im Betreff.',
	'SETTINGS_MULTIPLE_RECIPIENTS'				=> 'Anzahl der Empfänger',
	'SETTINGS_MULTIPLE_RECIPIENTS_EXPLAIN'		=> 'Die maximale Anzahl von Empfängern einer einzigen Einladung.',
	'SETTINGS_CONFIRM'							=> 'Bestätigung senden',
	'SETTINGS_CONFIRM_EXPLAIN'					=> 'Sendet eine Bestätigung an den einladenden Benutzer, sobald sich der Eingeladene registriert.',
	'SETTINGS_ZEBRA'							=> 'Zur Freundesliste hinzufügen',
	'SETTINGS_ZEBRA_EXPLAIN'					=> 'Fügt den eingeladenen und den einladenden Benutzer automatisch zur Freundesliste des jeweils anderen hinzu.',
	'SETTINGS_INVITE_LANGUAGE_SELECT'			=> 'Sprache der Einladung',
	'SETTINGS_INVITE_LANGUAGE_SELECT_EXPLAIN'	=> '',
	'SETTINGS_INVITE_PRIORITY_FLAG'				=> 'Priorität der E-Mail-Einladung',
	'SETTINGS_INVITE_PRIORITY_FLAG_EXPLAIN'		=> '',
	'SETTINGS_DISPLAY_NAVIGATION'				=> 'Navigations-Link anzeigen',
	'SETTINGS_DISPLAY_NAVIGATION_EXPLAIN'		=> '',
	'SETTINGS_DISPLAY_REGISTRATION'				=> 'Eingabefeld anzeigen',
	'SETTINGS_DISPLAY_REGISTRATION_EXPLAIN'		=> 'Das Eingabefeld für Registrierungs-Schlüssel bei der Registrierung anzeigen.',
	'SETTINGS_AUTOHIDE_VALID_KEY'				=> 'Eingabefeld automatisch verstecken',
	'SETTINGS_AUTOHIDE_VALID_KEY_EXPLAIN'		=> 'Wenn der übergebene Registrierungs-Schlüssel gültig ist, wird das Eingabefeld automatisch ausgeblendet.',
	'SETTINGS_PROFILE_FIELDS'					=> 'Statistiken anzeigen',
	'SETTINGS_PROFILE_FIELDS_EXPLAIN'			=> 'Wähle aus, wo welche Information angezeigt werden soll.',	
	'SETTINGS_ADVANCED_STATISTICS'				=> 'Erweiterte Statistiken anzeigen',
	'SETTINGS_ADVANCED_STATISTICS_EXPLAIN'		=> 'Zeigt erweiterte Statistiken beim Betrachen von Benutzerprofilen an. Erfordert, dass die Standard-Statistiken für Benutzerprofile aktiviert sind.',	
	'SETTINGS_ENABLE_LIMIT_TOTAL'				=> 'Gesamtlimit aktivieren',
	'SETTINGS_ENABLE_LIMIT_DAILY'				=> 'Tageslimit aktivieren',
	'SETTINGS_LIMIT_TOTAL_BASIC'				=> 'Gesamtlimit',
	'SETTINGS_LIMIT_TOTAL_BASIC_EXPLAIN'		=> 'Die Anzahl Einladungen, die ein Benutzer insgesamt versenden kann. Dieser Basiswert erhöht sich mit den folgenden Einstellungen.',
	'SETTINGS_LIMIT_DAILY_BASIC'				=> 'Tageslimit',
	'SETTINGS_LIMIT_DAILY_BASIC_EXPLAIN'		=> 'Die Anzahl Einladungen, die ein Benutzer täglich versenden kann, solange er das Gesamtlimit nicht überschreitet. Dieser Basiswert erhöht sich mit den folgenden Einstellungen.',
	'SETTINGS_LIMIT_POSTS'						=> 'Zusätzliche Einladungen pro Beitrag',
	'SETTINGS_LIMIT_TOPICS'						=> 'Zusätzliche Einladungen pro Thema',
	'SETTINGS_LIMIT_MEMBERDAYS'					=> 'Zusätzliche Einladungen pro Tag der Mitgliedschaft',
	'SETTINGS_LIMIT_REGISTRATIONS'				=> 'Zusätzliche Einladungen pro erfolgreiche Einladung',

	// UMIL
	'TRANSFER_INVITATION_DATA'					=> 'Alte Daten übertragen',
	'TRANSFER_INVITATION_DATA_EXPLAIN'			=> 'Überträgt alte Statistiken wie die Anzahl der versendeten Einladungen von Version 0.5.4 und früher. Es dürfen keine manuellen Eingriffe in die Datenbank stattgefunden haben.',
));

?>