<?php
/**
*
* info_acp_invite [British English]
*
* @author Bycoja bycoja@web.de
* @package language
* @version $Id info_acp_invite.php 0.6.2 2010-06-22 17:28:02GMT Bycoja $
* @copyright (c) 2010 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* English tranlation by:
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
	'ACP_IAF_TITLE'							=> 'Invite A Friend',
	'ACP_IAF_INVITATION_SETTINGS'			=> 'Invitation settings',
	'ACP_IAF_INVITATION_SETTINGS_EXPLAIN'	=> 'Here you can set all default settings for the invitations which users can send to their friends.',
	'ACP_IAF_REFERRAL_SETTINGS'				=> 'Referral settings',
	'ACP_IAF_REFERRAL_SETTINGS_EXPLAIN'		=> 'Referrals are users associated to others who have referred them to your board by sending an invitation or being specified as their referrer during the registration process. Here you can configure the referral features and determine how they integrate with the invitations.',
	'ACP_IAF_TEMPLATES'						=> 'Template settings',
	'ACP_IAF_TEMPLATES_EXPLAIN'				=> 'Here you can edit all templates related to the referrals and invitations. You can find both the templates for the confirmation sent to the inviter and the invitation itself below. As for the invitation templates, the user’s message and subject will be embedded into the template by using wildcards in curly braces. For a full list of possible wildcards look at the table below. Please note that you must not enter HTML or BBCode but plain text.',
	'ACP_IAF_LOG'							=> 'Invitation log',
	'ACP_IAF_LOG_EXPLAIN'					=> 'This lists all actions relating to the invitations which users can send to their friends. Use the form below to search for specific data. You do not need to fill out all fields.',
	
	'ACP_INVITATION_LIMITATION_SETTINGS'		=> 'Limitation settings',
	'ACP_INVITATION_DISPLAY_OPTIONS'			=> 'Display options',

	// Error messages
	'ERROR_EMAIL_DISABLED'				=> 'E-mails have been disabled and you cannot send any invitations.<br /><br /><a href="%s">» Activate E-mail-functionality</a>',
	'ERROR_INVITE_SETTINGS'				=> 'You have to fill in all fields correctly.',
	'ERROR_MESSAGE_INVITE'				=> 'You have to fill in all invitations. Please check whether you filled in the invitations of other languages, too.',
	'ERROR_MESSAGE_CONFIRM'				=> 'You have to fill in all confirmations. Please check whether you filled in the confirmations of other languages, too.',
	'JAVASCRIPT_NOTICE'					=> 'You should activate <b>JavaScript</b> in order to use all settings properly.',

	// Templates
	'ACP_SELECT_TEMPLATE'				=> 'Select template',
	'ACP_EDIT_TEMPLATE'					=> 'Edit template',
	'TEMPLATE_TYPE'						=> 'Template type',
	'TEMPLATE_LANGUAGE'					=> 'Template language',
	'SHOW_WILDCARDS'					=> '» Possible wildcards',
	'GENERAL_WILDCARDS'					=> 'General',
	'USER_WILDCARDS'					=> 'User related',
	'WILDCARD'							=> 'Wildcard',
	'EXAMPLE_VALUE'						=> 'Example value',
	'USER_DEFINED'						=> 'entered by user',

	// Invitation log
	'LOG_FILTER'						=> 'Display actions',
	'LOG_FILTER_ALL'					=> 'All',
	'LOG_FILTER_INVITE'					=> 'Invitations',
	'LOG_FILTER_CONFIRM'				=> 'Confirmations',
	'LOG_FILTER_REGISTER'				=> 'Registrations',
	'LOG_FILTER_ZEBRA'					=> 'Friends added',
	'LOG_INVITE_LOG_CLEARED'			=> '<strong>Cleared invitation log</strong>',
	'LOG_INVITE_SETTINGS_UPDATED'		=> '<strong>Altered invitation settings</strong>',
	'LOG_INVITE_TEMPLATES_UPDATED'		=> '<strong>Altered invitation templates</strong>',
	'LOG_INVITE_INVITE'					=> '<strong>Invitation sent</strong><br/>» to „%1$s“',
	'LOG_INVITE_CONFIRM'				=> '<strong>Obtained confirmation</strong><br/>» in order to confirm the registration of „%2$s“',
	'LOG_INVITE_REGISTER'				=> '<strong>Successful invitation</strong><br/>» key consumed in order to register „%1$s“',
	'LOG_INVITE_ZEBRA'					=> '<strong>Friend added</strong><br/>» „%1$s“ due to his registration',



	// Various stuff
	'ACC_TRANSFER'						=> 'Transfer',
	'OPTIONAL'							=> 'Optional',
	'INVITE_INVITE'						=> 'Invitation',
	'INVITE_CONFIRM'					=> 'Confirmation',
	'VIEWTOPIC'							=> 'Topic',
	'MEMBERLIST_VIEW'					=> 'Profile',
	'INVITATIONS'						=> 'Invitations',
	'DISPLAY_INVITER'					=> 'Referred by',
	'DISPLAY_INVITE'					=> 'Invitations sent',
	'DISPLAY_REGISTER'					=> 'Successful invitations',
	'SUCCESSFUL_INVITATIONS'			=> 'Successful invitations',
	'REFERRALS'							=> 'Referrals',
	'MEMBERDAYS'						=> 'Days of membership',
	'USER_LANGUAGE'						=> 'User’s language',
	'INVITATIONS_DAY'					=> '%.2f invitations per day',
	'INVITATIONS_PCT'					=> '%.2f%% of all invitations',
	'REGISTRATIONS_DAY'					=> '%.2f successful invitations per day',
	'REGISTRATIONS_PCT'					=> '%.2f%% of all successful invitations',
	'REGISTRATIONS_SUCCESS_RATE'		=> 'Personal success rate of %.2f%%',
	'SEARCH_USER_REGISTRATIONS'			=> 'Search user’s successful invitations',
	'PAGE_TITLE_INVITE_SEARCH'			=> 'Members invited by %s',
	'USER_ADMIN_INVITATIONS'			=> 'View user’s invitations',
	'USER_ADMIN_REGISTRATIONS'			=> 'View user’s successful invitations',

	// Invitation settings
	'SETTINGS_ENABLE'							=> 'Enable invitations',
	'SETTINGS_ENABLE_KEY'						=> 'Require registration keys',
	'SETTINGS_ENABLE_KEY_EXPLAIN'				=> 'Restricts registration to invited users, mainly for private boards.',
	'SETTINGS_KEY_GROUP'						=> 'Invited users’ group',
	'SETTINGS_KEY_GROUP_EXPLAIN'				=> 'If users-to-be optionally enter a registration key, they will be added to the selected group automatically.',
	'SETTINGS_KEY_GROUP_DEFAULT'				=> 'Set selected group to default',
	'SETTINGS_KEY_GROUP_DEFAULT_EXPLAIN'		=> 'If users-to-be optionally enter a registration key, they will be not only put into the selected group, but this group also being their default one.',
	'SETTINGS_REMOVE_NEWLY_REGISTERED'			=> 'Remove from Newly Registered Users',
	'SETTINGS_REMOVE_NEWLY_REGISTERED_EXPLAIN'	=> 'If users-to-be optionally enter a registration key, they will be removed from Newly Registered Users group.',
	'SETTINGS_INVITE_ACC_ACTIVATION_EXPLAIN'	=> 'This determines whether users-to-be, who optionally enter a registration key, have immediate access to the board or if confirmation is required. You can also transfer settings from »User registration settings« if you would like them to activate their account like everyone else.',
	'SETTINGS_INVITE_MULTIPLE'					=> 'Allow multiple invitations',
	'SETTINGS_INVITE_MULTIPLE_EXPLAIN'			=> 'Multiple invitations can be sent to the same e-mail address.',
	'SETTINGS_PREVENT_ABUSE'					=> 'Prevent abuse',
	'SETTINGS_PREVENT_ABUSE_EXPLAIN'			=> 'Make sure that the IP address of the sender doesn’t match the one of the invited user. Recommended if you use reward systems.',
	'SETTINGS_INVITE_CONFIRM_CODE'				=> 'Enable visual confirmation',
	'SETTINGS_INVITE_CONFIRM_CODE_EXPLAIN'		=> 'Requires users to enter a random code matching an image to prohibit sending invitations automatically.',
	'SETTINGS_SET_COOKIE'						=> 'Set cookies',
	'SETTINGS_SET_COOKIE_EXPLAIN'				=> 'Making use of cookies will not only help to keep track of statistical information, but will also enable the invited user to explore your board before registering.',
	'SETTINGS_EMAIL_IDENTIFICATION'				=> 'Enable e-mail identification',
	'SETTINGS_EMAIL_IDENTIFICATION_EXPLAIN'		=> 'Associate users-to-be with the one who invited them by comparing e-mail addresses and keep track of statistical information, even if the invited users do not specify a registration key.',
	'SETTINGS_INVITE_SEARCH_ALLOWED'			=> 'Enable member search',
	'SETTINGS_INVITE_SEARCH_ALLOWED_EXPLAIN'	=> 'If set to yes, users will be able to find a member by searching for invitation related criteria. The criterion itself must be enabled in display options.',
	'SETTINGS_FRIEND_NAME_CHARS'				=> 'Friend’s name length',
	'SETTINGS_FRIEND_NAME_CHARS_EXPLAIN'		=> 'Minimum and maximum number of characters in the friends’ names.',
	'SETTINGS_YOUR_EMAIL_CHARS'					=> 'Sender’s e-mail lenght',
	'SETTINGS_YOUR_EMAIL_CHARS_EXPLAIN'			=> 'Minimum and maximum number of characters in the senders’ e-mail addresses.',
	'SETTINGS_YOUR_NAME_CHARS'					=> 'Sender’s name lenght',
	'SETTINGS_YOUR_NAME_CHARS_EXPLAIN'			=> 'Minimum and maximum number of characters in the senders’ names.',
	'SETTINGS_MESSAGE_CHARS'					=> 'Message length',
	'SETTINGS_MESSAGE_CHARS_EXPLAIN'			=> 'Minimum and maximum number of characters in messages.',
	'SETTINGS_SUBJECT_CHARS'					=> 'Subject length',
	'SETTINGS_SUBJECT_CHARS_EXPLAIN'			=> 'Minimum and maximum number of characters in subjects.',
	'SETTINGS_MULTIPLE_RECIPIENTS'				=> 'Multiple recipients',
	'SETTINGS_MULTIPLE_RECIPIENTS_EXPLAIN'		=> 'Maximum number of people whom a single invitation can be sent to.',
	'SETTINGS_CONFIRM'							=> 'Send confirmation',
	'SETTINGS_CONFIRM_EXPLAIN'					=> 'Send a confirmation message on successful invitations to the user whose invited friend registered.',
	'SETTINGS_ZEBRA'							=> 'Add to friendlist',
	'SETTINGS_ZEBRA_EXPLAIN'					=> 'Automatically add the invited user and the one who invited him to the friendlist of each other.',
	'SETTINGS_INVITE_LANGUAGE_SELECT'			=> 'Invitation language',
	'SETTINGS_INVITE_LANGUAGE_SELECT_EXPLAIN'	=> '',
	'SETTINGS_INVITE_PRIORITY_FLAG'				=> 'Invitation mail priority',
	'SETTINGS_INVITE_PRIORITY_FLAG_EXPLAIN'		=> '',
	'SETTINGS_DISPLAY_NAVIGATION'				=> 'Display navigation link',
	'SETTINGS_DISPLAY_NAVIGATION_EXPLAIN'		=> '',
	'SETTINGS_DISPLAY_REGISTRATION'				=> 'Display registration keys',
	'SETTINGS_DISPLAY_REGISTRATION_EXPLAIN'		=> 'Display the input field for registration keys in the registration form.',
	'SETTINGS_AUTOHIDE_VALID_KEY'				=> 'Autohide valid registration keys',
	'SETTINGS_AUTOHIDE_VALID_KEY_EXPLAIN'		=> 'Automatically hide the input field for registration keys if a valid key has been passed per cookie or URL.',
	'SETTINGS_PROFILE_FIELDS'					=> 'Display statistics',
	'SETTINGS_PROFILE_FIELDS_EXPLAIN'			=> 'Choose where to display which information.',	
	'SETTINGS_ADVANCED_STATISTICS'				=> 'Display advanced statistics',
	'SETTINGS_ADVANCED_STATISTICS_EXPLAIN'		=> 'Display additional information while viewing profiles. Requires the standard profile statistics to be enabled.',	

	// Limitation
	'SETTINGS_QUEUE_TIME'						=> 'Flood interval',
	'SETTINGS_QUEUE_TIME_EXPLAIN'				=> 'The time a user must wait between sending new invitations.',
	'SETTINGS_ENABLE_LIMIT_TOTAL'				=> 'Enable total limit',
	'SETTINGS_ENABLE_LIMIT_DAILY'				=> 'Enable daily limit',
	'SETTINGS_LIMIT_TOTAL_BASIC'				=> 'Total limit',
	'SETTINGS_LIMIT_TOTAL_BASIC_EXPLAIN'		=> 'The number of invitations users can send overall. This basic value increases as you allocate additional invitations.',
	'SETTINGS_LIMIT_DAILY_BASIC'				=> 'Daily limit',
	'SETTINGS_LIMIT_DAILY_BASIC_EXPLAIN'		=> 'The number of invitations users can send every day as long as they do not exceed the total limit. This basic value increases as you allocate additional invitations.',
	'SETTINGS_LIMIT_POSTS'						=> 'Invitations per posts',
	'SETTINGS_LIMIT_TOPICS'						=> 'Invitations per topics',
	'SETTINGS_LIMIT_MEMBERDAYS'					=> 'Invitations per days of membership',
	'SETTINGS_LIMIT_REFERRALS'					=> 'Invitations per referrals',
	'SETTINGS_LIMIT_REGISTRATIONS'				=> 'Invitations per successful invitations',

	//Plugins
	'SETTINGS_ENABLE_PLUGIN'					=> 'Enable plugin',
	'SETTINGS_ENABLE_PLUGIN_EXPLAIN'			=> 'Enables additional functionality related to the plugin.',
	'SETTINGS_INVITATION_FEE'					=> 'Charged fee per invitation',
	'SETTINGS_ULTIMATE_POINTS_INVITE'			=> 'Points per invitation',
	'SETTINGS_ULTIMATE_POINTS_REGISTER'			=> 'Points per successful invitation',
	'SETTINGS_ULTIMATE_POINTS_REFERRAL'			=> 'Points per referral',
	'SETTINGS_CASH_INVITE'						=> 'Cash per invitation',
	'SETTINGS_CASH_REGISTER'					=> 'Cash per successful invitation',
	'SETTINGS_CASH_REFERRAL'					=> 'Cash per referral',

	// UMIL
	'TRANSFER_INVITATION_DATA'					=> 'Transfer Existing Data',
	'TRANSFER_INVITATION_DATA_EXPLAIN'			=> 'Select yes to transfer statistics from previous versions when updating. The database table must not have been edited manually since then.',
));

?>