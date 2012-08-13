<?php
/**
*
* info_acp_invite [Deutsch - Du]
*
* @author Bycoja bycoja@web.de
* @package language
* @version $Id info_acp_invite.php 0.7.0 2012-06-22 17:28:02GMT Bycoja $
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

// Permissions
$lang = array_merge($lang, array(
	'acl_a_invite'		=> array('lang' => 'Kann die Invite A Friend Einstellungen verwalten', 'cat' => 'misc'),
	'acl_a_invite_log'	=> array('lang' => 'Kann das Invite A Friend Protokoll verwalten', 'cat' => 'misc'),
    'acl_u_send_invite'	=> array('lang' => 'Kann Einladungen an Freunde senden', 'cat' => 'misc'),
));

$lang = array_merge($lang, array(
	// General
	'ACP_INVITE'						=> 'Invite A Friend',
	'ACP_INVITE_OVERVIEW'				=> 'Übersicht',
	'ACP_INVITE_OVERVIEW_EXPLAIN'		=> 'Danke, dass du dich für Invite A Friend entschieden hast. Diese Übersicht gibt dir einen schnellen Überblick über die verschiedenen Statistiken. Das Menü auf der linken Seite ermöglicht dir, das Verhalten der Modifikation an deine Wünsche anzupassen. Auf jeder Seite findest du weitere Informationen, wie du die Funktionen nutzen musst.',
	'ACP_INVITE_SETTINGS'				=> 'Einladungen',
	'ACP_INVITE_SETTINGS_EXPLAIN'		=> 'Einladungen erlauben Benutzern des Boards, ihre Freunde per E-Mail einzuladen. Hier kannst du alle grundlegenden Einstellungen zur Einladungs-Funktionalität vornehmen.',
	'ACP_INVITE_TEMPLATES'				=> 'Templates',
	'ACP_INVITE_TEMPLATES_EXPLAIN'		=> 'Hier kannst du alle Templates für die von dieser Modifikation versandten Nachrichten ändern. Hier findest du sowohl die Bestätigungen, die für erfolgreiche Einladungen und Anwerbungen verschickt werden, als auch das Template für die Einladung selbst. Der vom Absender angegebene Betreff und die Nachricht werden in die Templates der Einladung eingebunden und sind als Platzhalter in geschweiften Klammern anzugeben. Eine vollständige Liste aller Platzhalter findet sich in der Tabelle unterhalb. Bitte beachte, ausschließlich reinen Text und kein HTML oder BBCode zu verwenden.',
	'ACP_INVITE_LOG'					=> 'Protokoll',
	'ACP_INVITE_LOG_EXPLAIN'			=> 'Diese Liste zeigt alle Vorgänge, die mit dieser Modifikation in Verbindung stehen (Einladungen, Anwerbungen, Erfolgreich angeworbene Benutzer, Bestätigungen, etc.). Du kannst dir auch detaillierte Informationen zu einzelnen Benutzern anzeigen lassen, indem du das untenstehende Formular verwendest. Du musst nicht alle Felder ausfüllen.',
	'ACP_INVITE_DISPLAY_OPTIONS'		=> 'Anzeige-Optionen',
	'ACP_INVITE_LIMITATION_OPTIONS'		=> 'Beschränkung',
	'ACP_REFERRAL_SETTINGS'				=> 'Anwerbungen',
	'ACP_REFERRAL_SETTINGS_EXPLAIN'		=> 'Die Anwerbungs-Funktionalität erlaubt es Benutzern des Boards, neue Benutzer über einen Rekutierungslink anzuwerben. Neue Benutzer können stattdessen auch den Benutzernamen der Person, von der sie angeworben wurden, bei der Registrierung anzugeben. Hier kannst du alle grundlegenden Einstellungen zur Anwerbungs-Funktionalität vornehmen.',
	'ACP_GROUP_SETTINGS'				=> 'Gruppen-Einstellungen',
	'INVITATION'						=> 'Einladung',
	'INVITATION_EXPLAIN'				=> 'Sende eine Einladung an deine Freunde',

	// Error messages
	'ACP_IAF_DISABLED'					=> '»Invite A Friend« ist deaktiviert.',
	'ACP_INVITATION_DISABLED'			=> 'Einladungen sind zur Zeit deaktiviert.',
	'ACP_REFERRAL_DISABLED'				=> 'Anwerbungen sind zur Zeit deaktiviert.',
	'ERROR_EMAIL_DISABLED'				=> 'Zur Zeit können keine Einladungen über das Board versendet werden, da die E-Mail-Funktionalität deaktiviert ist.<br /><br /><a href="%s">» Aktiviere E-Mail-Funktionalität</a>',
	'ERROR_INVITE_SETTINGS'				=> 'Du musst alle Felder korrekt ausfüllen.',
	'ERROR_MESSAGE_INVITE'				=> 'Du musst alle Einladungen ausfüllen.',
	'ERROR_MESSAGE_CONFIRM'				=> 'Du musst alle Bestätigungen ausfüllen.',
	'JAVASCRIPT_NOTICE'					=> 'Du musst <b>JavaScript</b> aktivieren, um alle Einstellungsmöglichkeiten nutzen zu können.',

	// Overview
	'INVITE_STATS'							=> 'Statistik',
	'NUMBER_INVITATIONS'					=> 'Anzahl Einladungen',
	'NUMBER_SUCCESSFUL_INVITATIONS'			=> 'Anzahl erfolgreiche Einladungen',
	'NUMBER_REFERRALS'						=> 'Anzahl Anwerbungen',
	'INVITATIONS_PER_DAY'					=> 'Einladungen pro Tag',
	'SUCCESSFUL_INVITATIONS_PER_DAY'		=> 'Erfolgreiche Einladungen pro Tag',
	'REFERRALS_PER_DAY'						=> 'Anwerbungen pro Tag',
	'INVITE_INSTALL_DATE'					=> 'Installiert am',
	'LAST_UPDATE'							=> 'Letztes Update',
	'INVITE_VERSION'						=> 'Version',
	'ACP_INVITE_SYNC_REFERRAL_DATA'			=> 'Anwerbungen resynchronisieren',
	'ACP_INVITE_SYNC_REFERRAL_DATA_EXPLAIN'	=> 'Berechnet die Anzahl von Anwerbungen neu und resynchronisiert Anwerber. Abhängig von "Erfolgreiche Einladungen einschließen".',
	'ACP_INVITE_CONFIRM_SYNC_REFERRAL_DATA'	=> 'Bist du dir sicher, dass du die Anwerbungen resynchronisieren willst?',
	'ACP_INVITE_SYNC_REFERRAL_DATA_SUCCESS'	=> 'Die Anwerbungen wurden erfolgreich synchronisiert.',

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
	'LOG_FILTER_CONFIRM'				=> 'Erfolgreiche Einladungen',
	'LOG_FILTER_REGISTER'				=> 'Registrierungen',
	'LOG_FILTER_ZEBRA'					=> 'Freundschaften',
	'LOG_FILTER_REFERRAL'				=> 'Anwerbungen',
	'LOG_INVITE_LOG_CLEARED'			=> '<strong>Invite A Friend - Protokoll bearbeitet</strong>',
	'LOG_INVITE_SETTINGS_UPDATED'		=> '<strong>Invite A Friend - Einstellungen geändert</strong>',
	'LOG_INVITE_TEMPLATES_UPDATED'		=> '<strong>Invite A Friend - Templates bearbeitet</strong>',
	'LOG_INVITE_INVITE'					=> '<strong>Einladung versendet</strong><br/>» an „%1$s“',
	'LOG_INVITE_CONFIRM'				=> '<strong>Bestätigung erhalten</strong><br/>» aufgrund der Registrierung von „%2$s“',
	'LOG_INVITE_REGISTER'				=> '<strong>Erfolgreiche Einladung</strong><br/>» Registrierung des Benutzers „%1$s“',
	'LOG_INVITE_ZEBRA'					=> '<strong>Freund hinzugefügt</strong><br/>» „%1$s“ aufgrund der Registrierung des eingeladenen Benutzer',
	'LOG_INVITE_REFERRAL'				=> '<strong>Erfolgreiche Anwerbung</strong><br/>» Registrierung des Benutzers „%1$s“',
	'LOG INVITE SYNC REFERRAL DATA'		=> '<strong>Invite A Friend - Anwerbungen synchronisiert</strong>',

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

	// Profile data
	'INVITE'							=> 'Freunde einladen',
	'ACC_TRANSFER'						=> 'Standard übernehmen',
	'OPTIONAL'							=> 'Optional',
	'INVITE_INVITE'						=> 'Einladung',
	'INVITE_CONFIRM'					=> 'Bestätigung',
	'INVITE_REFERRAL'					=> 'Anwerbung',
	'VIEWTOPIC'							=> 'Thema',
	'MEMBERLIST_VIEW'					=> 'Profil',
	'INVITATIONS'						=> 'Einladungen',
	'DISPLAY_INVITER'					=> 'Eingeladen von',
	'DISPLAY_INVITE'					=> 'Einladungen versendet',
	'DISPLAY_REGISTER'					=> 'Erfolgreiche Einladungen',
	'DISPLAY_REFERRALS'					=> 'Anwerbungen',
	'DISPLAY_REFERRER'					=> 'Angeworben von',
	'MEMBERDAYS'						=> 'Tage der Mitgliedschaft',
	'REFERRALS'							=> 'Anwerbungen',
	'USER_LANGUAGE'						=> 'Sprache des Benutzers',
	'INVITATIONS_DAY'					=> '%.2f Einladungen pro Tag',
	'INVITATIONS_PCT'					=> '%.2f%% aller Einladungen',
	'REGISTRATIONS_DAY'					=> '%.2f erfolgreiche Einladungen pro Tag',
	'REGISTRATIONS_PCT'					=> '%.2f%% aller erfolgreichen Einladungen',
	'REGISTRATIONS_SUCCESS_RATE'		=> 'Persönliche Erfolgsrate von %.2f%%',
	'REFERRALS_DAY'						=> '%.2f Anwerbungen pro Tag',
	'REFERRALS_PCT'						=> '%.2f%% aller Anwerbungen',
	'REFERRAL_LINK'						=> 'Rekrutierungslink',
	'SEARCH_USER_REGISTRATIONS'			=> 'Erfolgreiche Einladungen anzeigen',
	'SEARCH_USER_REFERRALS'				=> 'Erfolgreiche Anwerbungen anzeigen',
	'PAGE_TITLE_INVITE_SEARCH'			=> 'Von %s eingeladene Mitglieder',
	'PAGE_TITLE_REFERRAL_SEARCH'		=> 'Von %s angeworbene Benutzer',
	'USER_ADMIN_INVITATIONS'			=> 'Einladungen des Benutzers anzeigen',
	'USER_ADMIN_REGISTRATIONS'			=> 'Erfolgreiche Einladungen des Benutzers anzeigen',
	'USER_ADMIN_REFERRALS'				=> 'Erfolgereiche Anwerbungen des Benutzers anzeigen',

	// Invitation settings
	'SETTINGS_ENABLE'							=> '»Invite A Friend« aktivieren',
	'SETTINGS_ENABLE_EXPLAIN'					=> 'Hiermit aktivierst du alle Funktionen dieser Modifikation.',
	'SETTINGS_ENABLE_POWERED_BY'				=> '»Powered by« anzeigen',
	'SETTINGS_ENABLE_POWERED_BY_EXPLAIN'		=> 'Du kannst diesen Verweis jederzeit ausblenden. Falls du die in diese Modifikation investierte Zeit und Arbeit zu schätzen weißt, würden wir uns sehr über eine <strong><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4SA7YVJADG5S8">Spende</a></strong> freuen.',
	'SETTINGS_ENABLE_INVITATION'				=> 'Einladungen aktivieren',
	'SETTINGS_ENABLE_INVITATION_EXPLAIN'		=> 'Aktiviert die grundlegende Einladungs-Funktionalität.',
	'SETTINGS_ENABLE_KEY'						=> 'Einladungscode benötigt',
	'SETTINGS_ENABLE_KEY_EXPLAIN'				=> 'Beschränkt die Registrierung auf eingeladene Benutzer. <strong>Für private Boards</strong>.',
	'SETTINGS_ENABLE_INVITE_GROUP'				=> 'Gruppe für eingeladene Benutzer aktivieren',
	'SETTINGS_ENABLE_INVITE_GROUP_EXPLAIN'		=> 'Falls aktiviert, werden eingeladene Benutzer automatisch der unten angegebenen Gruppe hinzugefügt.',
	'SETTINGS_KEY_GROUP'						=> 'Gruppe für eingeladene Benutzer',
	'SETTINGS_KEY_GROUP_EXPLAIN'				=> 'Eingeladene Benutzer werden dieser Gruppe automatisch hinzugefügt.',
	'SETTINGS_KEY_GROUP_DEFAULT'				=> 'Ausgewählte Gruppe als Standard setzen',
	'SETTINGS_KEY_GROUP_DEFAULT_EXPLAIN'		=> 'Die oben ausgewählte Gruppe wird hiermit zur Standardgruppe des eingeladenen Benutzers.',
	'SETTINGS_REMOVE_NEWLY_REGISTERED'			=> 'Aus Kürzlich Registrierte Benutzer entfernen',
	'SETTINGS_REMOVE_NEWLY_REGISTERED_EXPLAIN'	=> 'Falls aktiviert, werden eingeladene Benutzer automatisch aus der Gruppe der Kürzlich Registrierten Benutzer entfernt.',
	'SETTINGS_INVITE_ACC_ACTIVATION_EXPLAIN'	=> 'Diese Einstellung legt fest, ob eingeladene Benutzer sofortigen Zugang zum Board haben. Du kannst auch die Standard-Einstellung des Boards übernehmen.',
	'SETTINGS_INVITE_MULTIPLE'					=> 'Spam verhindern',
	'SETTINGS_INVITE_MULTIPLE_EXPLAIN'			=> 'Falls aktiviert, können Benutzer die gleiche E-Mail-Adresse nicht mehrmals einladen.',
	'SETTINGS_PREVENT_ABUSE'					=> 'Missbrauch vorbeugen',
	'SETTINGS_PREVENT_ABUSE_EXPLAIN'			=> 'Stellt sicher, dass die IP-Adresse des eingeladenen Benutzers nicht mit der des Einladenden übereinstimmt. Bei Verwendung von Belohnungssystemen empfohlen.',
	'SETTINGS_INVITE_EXPIRATION_TIME'			=> 'Verfallsdatum festlegen',
	'SETTINGS_INVITE_EXPIRATION_TIME_EXPLAIN'	=> 'Versandte Einladungen verfallen nach der hier angegebenen Zeit und können nicht länger zur Registrierung verwendet werden.<br/><em>Note: Betrifft nur neue Einladungen. Um diese Einstellung zu deaktivieren, stelle als Wert 0 ein.</em>',
	'SETTINGS_INVITE_REQUIRED_POSTS'			=> 'Beitragminimum',
	'SETTINGS_INVITE_REQUIRED_POSTS_EXPLAIN'	=> 'Die minimale Anzahl Beiträge, die zur Nutzung der Einladungs-Funktionalität erforderlich ist.<br/><em>Um diese Einstellung zu deaktivieren, stelle als Wert 0 ein.</em>',
	'SETTINGS_INVITE_CONFIRM_CODE'				=> 'Visuellen Bestätigungscode aktivieren',
	'SETTINGS_INVITE_CONFIRM_CODE_EXPLAIN'		=> 'Benutzer müssen einen durch ein Bild vorgegebenen Schlüssel eingeben, um automatisches Versenden von Einladungen zu unterbinden.',
	'SETTINGS_SET_COOKIE'						=> 'Cookies setzen',
	'SETTINGS_SET_COOKIE_EXPLAIN'				=> 'Die Verwendung von Cookies hilft nicht nur dabei, statistische Informationen zu erheben, sondern ermöglicht es dem eingeladenen Benutzer auch, das Board vor der Registrierung zu erkunden.',
	'SETTINGS_EMAIL_IDENTIFICATION'				=> 'E-Mail-Identifikation aktivieren',
	'SETTINGS_EMAIL_IDENTIFICATION_EXPLAIN'		=> 'Bringt den eingeladenen Benutzer mit dem Einladenden durch einen Vergleich der E-Mail-Adressen in Verbindung, auch wenn kein Registrierungs-Schlüssel angegeben wird.',
	'SETTINGS_INVITE_SEARCH_ALLOWED'			=> 'Mitgliedersuche aktivieren',
	'SETTINGS_INVITE_SEARCH_ALLOWED_EXPLAIN'	=> 'Ermöglicht die Suche nach Benutzern anhand von einladungsspezifischen Kriterien.<br/><em>Das Kriterium selbst muss in den Anzeige-Optionen aktiviert sein.</em>',
	'SETTINGS_QUEUE_TIME'						=> 'Wartezeit',
	'SETTINGS_QUEUE_TIME_EXPLAIN'				=> 'Die Wartezeit zwischen dem Versenden zweier Einladungen.',
	'SETTINGS_MESSAGE_CHARS'					=> 'Länge der Nachricht',
	'SETTINGS_MESSAGE_CHARS_EXPLAIN'			=> 'Die minimale und maximale Anzahl an Zeichen in der Nachricht.',
	'SETTINGS_SUBJECT_CHARS'					=> 'Länge des Betreffs',
	'SETTINGS_SUBJECT_CHARS_EXPLAIN'			=> 'Die minimale und maximale Anzahl an Zeichen im Betreff.',
	'SETTINGS_MULTIPLE_RECIPIENTS'				=> 'Anzahl der Empfänger',
	'SETTINGS_MULTIPLE_RECIPIENTS_EXPLAIN'		=> 'Die maximale Anzahl von Empfängern.',
	'SETTINGS_CONFIRM'							=> 'Bestätigung senden',
	'SETTINGS_CONFIRM_EXPLAIN'					=> 'Sendet eine Bestätigung an den einladenden Benutzer, sobald sich der Eingeladene registriert.',
	'SETTINGS_ZEBRA'							=> 'Freunde hinzufügen',
	'SETTINGS_ZEBRA_EXPLAIN'					=> 'Fügt den eingeladenen und den einladenden Benutzer automatisch zur Freundesliste des jeweils anderen hinzu.',
	'SETTINGS_INVITE_LANGUAGE_SELECT'			=> 'Sprache der Einladung',
	'SETTINGS_INVITE_LANGUAGE_SELECT_EXPLAIN'	=> '',
	'SETTINGS_INVITE_PRIORITY_FLAG'				=> 'Priorität der E-Mail-Einladung',
	'SETTINGS_INVITE_PRIORITY_FLAG_EXPLAIN'		=> '',
	'SETTINGS_DISPLAY_NAVIGATION_LEFT'			=> 'Navigations-Link links anzeigen',
	'SETTINGS_DISPLAY_NAVIGATION_LEFT_EXPLAIN'	=> 'Falls aktiviert, wird ein Link zum Einladungsformular im Menü links neben dem Persönlichen Bereich angezeigt.',
	'SETTINGS_DISPLAY_NAVIGATION_RIGHT'			=> 'Navigations-Link rechts anzeigen',
	'SETTINGS_DISPLAY_NAVIGATION_RIGHT_EXPLAIN'	=> 'Falls aktiviert, wird ein Link zum Einladungsformular im Menü rechts neben der Abmeldung angezeigt.',
	'SETTINGS_DISPLAY_REGISTRATION'				=> 'Einladungscode anzeigen',
	'SETTINGS_DISPLAY_REGISTRATION_EXPLAIN'		=> 'Das Eingabefeld für den Einladungscode bei der Registrierung anzeigen.',
	'SETTINGS_AUTOHIDE_VALID_KEY'				=> 'Einladungscode automatisch verstecken',
	'SETTINGS_AUTOHIDE_VALID_KEY_EXPLAIN'		=> 'Hiermit wird das Eingabefeld für den Einladungscode bei der Registrierung automatisch versteckt, wenn ein gültiger Einladungscode ermittelt werden kann (Cookie oder URL).',
	'SETTINGS_PROFILE_FIELDS'					=> 'Statistiken anzeigen',
	'SETTINGS_PROFILE_FIELDS_EXPLAIN'			=> 'Wähle aus, wo welche Information angezeigt werden soll. Wähle zunächst einen Ort, dann den Typ der Information.',	
	'SETTINGS_ADVANCED_STATISTICS'				=> 'Erweiterte Statistiken anzeigen',
	'SETTINGS_ADVANCED_STATISTICS_EXPLAIN'		=> 'Zeigt erweiterte Statistiken beim Betrachen von Benutzerprofilen an.<br/><em>Erfordert, dass die entsprechende Information unten aktiviert ist.</em>',	
	'SETTINGS_ENABLE_UNLIMITED'					=> 'Unbegrenzte Anzahl Einladungen',
	'SETTINGS_ENABLE_UNLIMITED_EXPLAIN'			=> 'Hiermit kann jeder Benutzer unendlich viele Einladungen versenden. <strong>Überschreibt jegliche Limitierung.</strong>',
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
	'SETTINGS_LIMIT_REFERRALS'					=> 'Zusätzliche Einladungen pro erfolgreiche Anwerbung',
	'SETTINGS_LIMIT_REFERRALS_EXPLAIN'			=> '<em>Erfordert, dass Anwerbungen aktiviert sind.</em>',

	// Referral settings
	'SETTINGS_ENABLE_REFERRAL'					=> 'Anwerbungen aktivieren',
	'SETTINGS_ENABLE_REFERRAL_EXPLAIN'			=> 'Aktiviert die Anwerbungs-Funktionalität.',
	'SETTINGS_REFERRAL_INVITATION_BRIDGE'		=> 'Erfolgreiche Einladungen einschließen',
	'SETTINGS_REFERRAL_INVITATION_BRIDGE_EXPLAIN'=> 'Falls aktiviert, zählen erfolgreiche Einladungen ebenfalls als Anwerbung.',
	'SETTINGS_REFERRAL_AUTOHIDE'				=> 'Anwerbungsfeld automatisch verstecken',
	'SETTINGS_REFERRAL_AUTOHIDE_EXPLAIN'		=> 'Hiermit wird das Eingabefeld bei der Registrierung automatisch versteckt, falls eine Person, die den Benutzer angeworben hat, ermittel werden kann (Cookie, URL oder Einladungscode).',
	'SETTINGS_REFERRAL_AS'						=> 'Autovervollständigen',
	'SETTINGS_REFERRAL_AS_EXPLAIN'				=> 'Falls aktiviert, wird der Benutzername der Person, die den neuen Benutzer angeworben hat, automatisch mittels AJAX vervollständigt.',
	'SETTINGS_REFERRAL_AS_LIMIT'				=> 'Autoverollständigen Limit',
	'SETTINGS_REFERRAL_AS_LIMIT_EXPLAIN'		=> 'Die maximale Anzahl Benutzer, die beim Autovervollständigen gleichzeitig angezeigt wird.',
	'SETTINGS_REFERRAL_FRIENDS'					=> 'Freunde hinzufügen',
	'SETTINGS_REFERRAL_FRIENDS_EXPLAIN'			=> 'Füngt den angeworbenen Benutzer und die Person, die den Benutzer angeworben hat, automatisch zur Freundesliste des jeweils anderen hinzu.<br/><em>Diese Einstellung wird von einladungsspezifischen Einstellungen überschrieben.</em>',
	'SETTINGS_REFERRAL_REQUIRE'					=> 'Anwerbung benötigt',
	'SETTINGS_REFERRAL_REQUIRE_EXPLAIN'			=> 'Falls aktiviert, müssen neue Benutzer den Namen der Person, die sie angeworben hat, angeben.',
	'SETTINGS_REFERRAL_AUTODISABLE'				=> 'Anwerbungsfeld automatisch deaktivieren',
	'SETTINGS_REFERRAL_AUTODISABLE_EXPLAIN'		=> 'Hiermit wird das Eingabefeld bei der Registrierung automatisch deaktiviert, falls eine Person, die den Benutzer angeworben hat, ermittel werden kann.<br/><em>Diese Einstellung wird von "Anwerbungsfeld automatisch verstecken" überschrieben.</em>',
	'SETTINGS_REFERRAL_COOKIE'					=> 'Cookies setzen',
	'SETTINGS_REFERRAL_COOKIE_EXPLAIN'			=> 'Die Verwendung von Cookies ermöglicht es dem angeworbenen Benutzer, das Board vor der Registrierung zu erkunden, ohne dass die Informationen zum Anwerber verloren gehen.',
	'SETTINGS_REFERRAL_SEARCH_ALLOWED'			=> 'Mitgliedersuche aktivieren',
	'SETTINGS_REFERRAL_SEARCH_ALLOWED_EXPLAIN'	=> 'Ermöglicht die Suche nach Benutzern anhand von empfehlungsspezifischen Kriterien.<br/><em>Das Kriterium selbst muss in den Anzeige-Optionen aktiviert sein.</em>',
	'SETTINGS_DISPLAY_P_REFERRAL_LINK'			=> 'Rekrutierungslink anzeigen',
	'SETTINGS_DISPLAY_P_REFERRAL_LINK_EXPLAIN'	=> 'Falls aktiviert, wird der Rekrutierungslink, über den neue Benutzer angeworben werden können, im Benutzerprofil eines jeden Benutzers angezeigt.',
	'SETTINGS_REFERRAL_CONFIRMATION'			=> 'Bestätigung senden',
	'SETTINGS_REFERRAL_CONFIRMATION_EXPLAIN'	=> 'Falls aktiviert, erhalten Benutzer eine Nachricht, wenn sie als Anwerber angegeben werden oder sich ein neuer Benutzer über ihren Rekrutierungslink registriert.',
	'SETTINGS_REFERRAL_CONFIRMATION_DUPLICATE'	=> 'Bestätigung für erfolgreiche Einladungen senden',
	'SETTINGS_REFERRAL_CONFIRMATION_DUPLICATE_EXPLAIN'	=> 'Falls aktiviert, erhalten Benutzer eine Bestätigung, auch wenn die erfolgreiche Anwerbung das Resultat einer Einladung ist.<br/><em>Dies führt zu doppelten Bestätigung, falls die erfolgreiche Einladung ebenfalls bestätigt wird.</em>',

	// UMIL
	'ACP_INVITE_DONATE_BUTTON'			=> 'Invite A Friend <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4SA7YVJADG5S8"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" target="_blank" title="Spenden" /></a>',
	'TRANSFER_INVITATION_DATA'			=> 'Alte Daten übertragen',
	'TRANSFER_INVITATION_DATA_EXPLAIN'	=> 'Überträgt alte Statistiken wie die Anzahl der versendeten Einladungen von Version 0.5.4 und früher. Es dürfen keine manuellen Eingriffe in die Datenbank stattgefunden haben.',
));

?>