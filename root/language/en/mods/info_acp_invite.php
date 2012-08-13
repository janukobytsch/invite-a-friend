<?php
/**
*
* info_acp_invite [British English]
*
* @author Bycoja bycoja@web.de
* @package language
* @version $Id info_acp_invite.php 0.7.0 2012-06-22 17:28:02GMT Bycoja $
* @copyright (c) 2008-2012 Bycoja
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

// Permissions
$lang = array_merge($lang, array(
	'acl_a_invite_settings'	=> array('lang' => 'Can manage Invite A Friend settings', 'cat' => 'misc'),
	'acl_a_invite_log'		=> array('lang' => 'Can manage Invite A Friend log', 'cat' => 'misc'),
    'acl_u_send_invite'		=> array('lang' => 'Can send invitations to friends', 'cat' => 'misc'),
));

$lang = array_merge($lang, array(
	// General
	'ACP_INVITE'						=> 'Invite A Friend',
	'ACP_INVITE_OVERVIEW'				=> 'Overview',
	'ACP_INVITE_OVERVIEW_EXPLAIN'		=> 'Thank you for choosing Invite A Friend. This page will give you a quick overview of the invitation and referral statistics. The links on the left hand side of this screen allow you to control every aspect of this modification. Each page will have instructions on how to use the tools.',
	'ACP_INVITE_SETTINGS'				=> 'Invitation settings',
	'ACP_INVITE_SETTINGS_EXPLAIN'		=> 'Invitations allow your users to invite their friend via e-mail. Here you can set all default settings for these invitations.',
	'ACP_INVITE_TEMPLATES'				=> 'Message templates',
	'ACP_INVITE_TEMPLATES_EXPLAIN'		=> 'Here you can edit all templates related to the invitations. You can find both the templates for the confirmation sent to the inviter and the invitation itself below. As for the invitation templates, the user´s message and subject will be embedded into the template by using wildcards in curly braces. For a full list of possible wildcards look at the table below. Please note that you must not enter HTML or BBCode but plain text.',
	'ACP_INVITE_LOG'					=> 'Action log',
	'ACP_INVITE_LOG_EXPLAIN'			=> 'This lists all actions relating to the invitations which users can send to their friends. Use the form below to search for specific data. You do not need to fill out all fields.',
	'ACP_INVITE_DISPLAY_OPTIONS'		=> 'Display options',
	'ACP_INVITE_LIMITATION_OPTIONS'		=> 'Limitation',
	'ACP_REFERRAL_SETTINGS'				=> 'Referral settings',
	'ACP_REFERRAL_SETTINGS_EXPLAIN'		=> 'Referrals enable your users to recruit new users using a referral link. Users can also specify the username of the person who referred them to your board during registration. Here you can set all default settings for this feature.',
	'ACP_GROUP_SETTINGS'				=> 'Group settings',
	'INVITATION'						=> 'Invitation',
	'INVITATION_EXPLAIN'				=> 'Send an invitation to your friends',

	// Error messages
	'ACP_IAF_DISABLED'					=> '»Invite A Friend« is disabled.',
	'ACP_INVITATION_DISABLED'			=> 'Invitations are disabled at the moment.',
	'ACP_REFERRAL_DISABLED'				=> 'Referrals are disabled at the moment..',
	'ERROR_EMAIL_DISABLED'				=> 'Your users cannot send any invitations due to e-mail-funtionality being disabled.<br /><br /><a href="%s">» Activate E-mail-functionality</a>',
	'ERROR_INVITE_SETTINGS'				=> 'You have to fill in all fields correctly.',
	'ERROR_MESSAGE_INVITE'				=> 'You have to fill in all invitations. Please check whether you filled in the invitations of other languages, too.',
	'ERROR_MESSAGE_CONFIRM'				=> 'You have to fill in all confirmations. Please check whether you filled in the confirmations of other languages, too.',
	'JAVASCRIPT_NOTICE'					=> 'You should activate <b>JavaScript</b> in order to use all settings properly.',

	// Overview
	'INVITE_STATS'							=> 'Statistics',
	'NUMBER_INVITATIONS'					=> 'Number of invitations',
	'NUMBER_SUCCESSFUL_INVITATIONS'			=> 'Number of successful invitations',
	'NUMBER_REFERRALS'						=> 'Number of referrals',
	'INVITATIONS_PER_DAY'					=> 'Invitations per day',
	'SUCCESSFUL_INVITATIONS_PER_DAY'		=> 'Successful invitations per day',
	'REFERRALS_PER_DAY'						=> 'Referrals per day',
	'INVITE_INSTALL_DATE'					=> 'Installation date',
	'LAST_UPDATE'							=> 'Last update',
	'INVITE_VERSION'						=> 'Version',
	'ACP_INVITE_SYNC_REFERRAL_DATA'			=> 'Resynchronise referrals',
	'ACP_INVITE_SYNC_REFERRAL_DATA_EXPLAIN'	=> 'Recalculates the number of referrals and resynchronises referrer data.',
	'ACP_INVITE_CONFIRM_SYNC_REFERRAL_DATA'	=> 'Are you sure you wish to resynchronise referrals?',
	'ACP_INVITE_SYNC_REFERRAL_DATA_SUCCESS'	=> 'Referrals have been resynchronized successfully.',

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
	'LOG_FILTER_REGISTER'				=> 'Successful invitations',
	'LOG_FILTER_ZEBRA'					=> 'Friends added',
	'LOG_FILTER_REFERRAL'				=> 'Referrals',
	'LOG_INVITE_LOG_CLEARED'			=> '<strong>Cleared Invite A Friend log</strong>',
	'LOG_INVITE_SETTINGS_UPDATED'		=> '<strong>Altered Invite A Friend settings</strong>',
	'LOG_INVITE_TEMPLATES_UPDATED'		=> '<strong>Altered Invite A Friend templates</strong>',
	'LOG_INVITE_INVITE'					=> '<strong>Invitation sent</strong><br/>» to „%1$s“',
	'LOG_INVITE_CONFIRM'				=> '<strong>Obtained confirmation</strong><br/>» due to the registration of „%2$s“',
	'LOG_INVITE_REGISTER'				=> '<strong>Successful invitation</strong><br/>» „%1$s“',
	'LOG_INVITE_ZEBRA'					=> '<strong>Friend added</strong><br/>» „%1$s“',
	'LOG_INVITE_REFERRAL'				=> '<strong>Successful referral</strong><br/>» „%1$s“',
	'LOG INVITE SYNC REFERRAL DATA'		=> '<strong>Invite A Friend referrals resynchronized</strong>',

	//Plugins
	'ULTIMATE_POINTS_SETTINGS'			=> 'Ultimate Points settings',
	'ULTIMATE_POINTS_ENABLE'			=> 'Enable Ultimate Points',
	'ULTIMATE_POINTS_INVITE'			=> 'Ultimate points per invitation',
	'ULTIMATE_POINTS_INVITE_EXPLAIN'	=> 'The amount of ultimate points allocated per invitation.',
	'ULTIMATE_POINTS_REGISTER'			=> 'Ultimate points per registration',
	'ULTIMATE_POINTS_REGISTER_EXPLAIN'	=> 'The amount of ultimate points allocated per invited friend, who registers a new account.',
	'CASH_SETTINGS'						=> 'Cash settings',
	'CASH_ENABLE'						=> 'Enable cash',
	'CASH_INVITE'						=> 'Cash per invitation',
	'CASH_INVITE_EXPLAIN'				=> 'The amount of cash allocated per invitation.',
	'CASH_REGISTER'						=> 'Cash per registration',
	'CASH_REGISTER_EXPLAIN'				=> 'The amount of cash allocated per invited friend, who registers a new account.',

	// Profile data
	'INVITE'							=> 'Invite friends',
	'ACC_TRANSFER'						=> 'Use standard',
	'OPTIONAL'							=> 'Optional',
	'INVITE_INVITE'						=> 'Invitation',
	'INVITE_CONFIRM'					=> 'Confirmation',
	'INVITE_REFERRAL'					=> 'Referral',
	'VIEWTOPIC'							=> 'Topic',
	'MEMBERLIST_VIEW'					=> 'Profile',
	'INVITATIONS'						=> 'Invitations',
	'DISPLAY_INVITER'					=> 'Invited by',
	'DISPLAY_INVITE'					=> 'Invitations sent',
	'DISPLAY_REGISTER'					=> 'Successful invitations',
	'DISPLAY_REFERRALS'					=> 'Referrals',
	'DISPLAY_REFERRER'					=> 'Referred by',
	'MEMBERDAYS'						=> 'Days of membership',
	'REFERRALS'							=> 'Referrals',
	'USER_LANGUAGE'						=> 'User’s language',
	'INVITATIONS_DAY'					=> '%.2f invitations per day',
	'INVITATIONS_PCT'					=> '%.2f%% of all invitations',
	'REGISTRATIONS_DAY'					=> '%.2f successful invitations per day',
	'REGISTRATIONS_PCT'					=> '%.2f%% of all successful invitations',
	'REGISTRATIONS_SUCCESS_RATE'		=> 'Personal success rate of %.2f%%',
	'REFERRALS_DAY'						=> '%.2f referrals per day',
	'REFERRALS_PCT'						=> '%.2f%% of all referrals',
	'REFERRAL_LINK'						=> 'Referral link',
	'SEARCH_USER_REGISTRATIONS'			=> 'Search user’s successful invitations',
	'SEARCH_USER_REFERRALS'				=> 'Search user’s referrals',
	'PAGE_TITLE_INVITE_SEARCH'			=> 'Members invited by %s',
	'PAGE_TITLE_REFERRAL_SEARCH'		=> 'Members referred by %s',
	'USER_ADMIN_INVITATIONS'			=> 'View user’s invitations',
	'USER_ADMIN_REGISTRATIONS'			=> 'View user’s successful invitations',
	'USER_ADMIN_REFERRALS'				=> 'View user’s referrals',

	// Invitation settings
	'SETTINGS_ENABLE'							=> 'Enable »Invite A Friend«',
	'SETTINGS_ENABLE_EXPLAIN'					=> 'This will enable or disable all features of this modification.',
	'SETTINGS_ENABLE_POWERED_BY'				=> 'Show »Powered by«',
	'SETTINGS_ENABLE_POWERED_BY_EXPLAIN'		=> 'You are free to hide this. If you would like to show your appreciation for all the hard work and time put into this modification, a <strong><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4SA7YVJADG5S8" target="_blank">donation</a></strong> would be very much appreciated.',
	'SETTINGS_ENABLE_INVITATION'				=> 'Enable invitations',
	'SETTINGS_ENABLE_INVITATION_EXPLAIN'		=> 'Adds the ability to send invitations, keep track of invited whom, etc.',
	'SETTINGS_ENABLE_KEY'						=> 'Invitation code required',
	'SETTINGS_ENABLE_KEY_EXPLAIN'				=> 'Restricts registration to invited users. <strong>For private boards.</strong>',
	'SETTINGS_ENABLE_INVITE_GROUP'				=> 'Enable special group',
	'SETTINGS_ENABLE_INVITE_GROUP_EXPLAIN'		=> 'If enabled, invited users will be added to a special group.',
	'SETTINGS_KEY_GROUP'						=> 'Special group',
	'SETTINGS_KEY_GROUP_EXPLAIN'				=> 'Invited users will be added to this group automatically.',
	'SETTINGS_KEY_GROUP_DEFAULT'				=> 'Set special group to default',
	'SETTINGS_KEY_GROUP_DEFAULT_EXPLAIN'		=> 'If enabled, the special group selected above will be the default group of invited users.',
	'SETTINGS_REMOVE_NEWLY_REGISTERED'			=> 'Remove from Newly Registered Users',
	'SETTINGS_REMOVE_NEWLY_REGISTERED_EXPLAIN'	=> 'This will remove invited users from the Newly Registered Users group.',
	'SETTINGS_INVITE_ACC_ACTIVATION_EXPLAIN'	=> 'This determines whether invited users have immediate access to the board or if a confirmation is required. You can also use the standard board settings.',
	'SETTINGS_INVITE_MULTIPLE'					=> 'Prevent spam',
	'SETTINGS_INVITE_MULTIPLE_EXPLAIN'			=> 'This will prevent invitations from being sent to the same e-mail address twice.',
	'SETTINGS_PREVENT_ABUSE'					=> 'Prevent abuse',
	'SETTINGS_PREVENT_ABUSE_EXPLAIN'			=> 'Make sure that the IP address of the sender doesn’t match the IP of the invited user.<br/><em>Note: Recommended if you use reward systems.</em>',
	'SETTINGS_INVITE_EXPIRATION_TIME'			=> 'Expiration time',
	'SETTINGS_INVITE_EXPIRATION_TIME_EXPLAIN'	=> 'Sent invitations will expire after this time and can no longer be used to register.<br/><em>Note: Only affects new invitations. Set to 0 to disable.</em>',
	'SETTINGS_INVITE_REQUIRED_POSTS'			=> 'Post requirement',
	'SETTINGS_INVITE_REQUIRED_POSTS_EXPLAIN'	=> 'The minimum amount of posts required to send invitations.<br/><em>Note: Set to 0 to disable.</em>',
	'SETTINGS_INVITE_CONFIRM_CODE'				=> 'Visual confirmation',
	'SETTINGS_INVITE_CONFIRM_CODE_EXPLAIN'		=> 'Requires users to enter a random code matching an image to prohibit automated invitations.',
	'SETTINGS_SET_COOKIE'						=> 'Set cookies',
	'SETTINGS_SET_COOKIE_EXPLAIN'				=> 'This will enable invited persons to explore your board before registering while keeping relevant data.',
	'SETTINGS_EMAIL_IDENTIFICATION'				=> 'Enable e-mail identification',
	'SETTINGS_EMAIL_IDENTIFICATION_EXPLAIN'		=> 'Associate users with the one who invited them by comparing e-mail addresses, even if no invitation code is specified.',
	'SETTINGS_INVITE_SEARCH_ALLOWED'			=> 'Enable search',
	'SETTINGS_INVITE_SEARCH_ALLOWED_EXPLAIN'	=> 'If set to yes, users will be able to find a member by searching for invitation related criteria.<br/><em>Note: The criterion itself must be enabled in the display options below.</em>',
	'SETTINGS_QUEUE_TIME'						=> 'Queue',
	'SETTINGS_QUEUE_TIME_EXPLAIN'				=> 'The period of time users must wait after having sent an invitation to send another one.',
	'SETTINGS_MESSAGE_CHARS'					=> 'Message length',
	'SETTINGS_MESSAGE_CHARS_EXPLAIN'			=> 'Minimum and maximum number of characters in messages.',
	'SETTINGS_SUBJECT_CHARS'					=> 'Subject length',
	'SETTINGS_SUBJECT_CHARS_EXPLAIN'			=> 'Minimum and maximum number of characters in subjects.',
	'SETTINGS_MULTIPLE_RECIPIENTS'				=> 'Multiple recipients',
	'SETTINGS_MULTIPLE_RECIPIENTS_EXPLAIN'		=> 'Maximum number of people whom an invitation can be sent to at once.',
	'SETTINGS_CONFIRM'							=> 'Send confirmation',
	'SETTINGS_CONFIRM_EXPLAIN'					=> 'If enabled, users will receive a confirmation message when their invited friend registers.',
	'SETTINGS_ZEBRA'							=> 'Add friends',
	'SETTINGS_ZEBRA_EXPLAIN'					=> 'This will add the invited user and the one who invited him to the friendlist of each other.',
	'SETTINGS_INVITE_LANGUAGE_SELECT'			=> 'Invitation language',
	'SETTINGS_INVITE_LANGUAGE_SELECT_EXPLAIN'	=> '',
	'SETTINGS_INVITE_PRIORITY_FLAG'				=> 'Invitation mail priority',
	'SETTINGS_INVITE_PRIORITY_FLAG_EXPLAIN'		=> '',
	'SETTINGS_DISPLAY_NAVIGATION_LEFT'			=> 'Display left navigation link',
	'SETTINGS_DISPLAY_NAVIGATION_LEFT_EXPLAIN'	=> 'This will show a link to the invitation form in the top left menu next to the User Control Panel.',
	'SETTINGS_DISPLAY_NAVIGATION_RIGHT'			=> 'Display right navigation link',
	'SETTINGS_DISPLAY_NAVIGATION_RIGHT_EXPLAIN'	=> 'This will show a link to the invitation form in the top right menu next to the Search.',
	'SETTINGS_DISPLAY_REGISTRATION'				=> 'Display invitation codes',
	'SETTINGS_DISPLAY_REGISTRATION_EXPLAIN'		=> 'This will show the input field for invitation codes during registration.',
	'SETTINGS_AUTOHIDE_VALID_KEY'				=> 'Autohide valid invitation codes',
	'SETTINGS_AUTOHIDE_VALID_KEY_EXPLAIN'		=> 'If enabled, the input field will be hidden automatically if a valid code can be detected (Cookie or URL).',
	'SETTINGS_PROFILE_FIELDS'					=> 'Display statistics',
	'SETTINGS_PROFILE_FIELDS_EXPLAIN'			=> 'Choose where to display which information. Select a location first, then the type of information.',	
	'SETTINGS_ADVANCED_STATISTICS'				=> 'Display advanced statistics',
	'SETTINGS_ADVANCED_STATISTICS_EXPLAIN'		=> 'This will show additional information while viewing profiles.<br/><em>Note: Requires the according profile statistics to be enabled below.</em>',	
	'SETTINGS_ENABLE_UNLIMITED'					=> 'Unlimited invitations',
	'SETTINGS_ENABLE_UNLIMITED_EXPLAIN'			=> 'If enabled, everyone will be able to send an unlimited amount of invitations. <strong>Overrides any limitation.</strong>',
	'SETTINGS_ENABLE_LIMIT_TOTAL'				=> 'Enable total limit',
	'SETTINGS_ENABLE_LIMIT_DAILY'				=> 'Enable daily limit',
	'SETTINGS_LIMIT_TOTAL_BASIC'				=> 'Total limit',
	'SETTINGS_LIMIT_TOTAL_BASIC_EXPLAIN'		=> 'The number of invitations users can send overall. This basic value will increase as you add additional invitations using the following settings.',
	'SETTINGS_LIMIT_DAILY_BASIC'				=> 'Daily limit',
	'SETTINGS_LIMIT_DAILY_BASIC_EXPLAIN'		=> 'The number of invitations users can send every day as long as they do not exceed the total limit. This basic value will increase as you add additional invitations using the following settings.',
	'SETTINGS_LIMIT_POSTS'						=> 'Additional invitations per post',
	'SETTINGS_LIMIT_TOPICS'						=> 'Additional invitations per topic',
	'SETTINGS_LIMIT_MEMBERDAYS'					=> 'Additional invitations per day of membership',
	'SETTINGS_LIMIT_REGISTRATIONS'				=> 'Additional invitations per successful invitation',
	'SETTINGS_LIMIT_REFERRALS'					=> 'Additional invitations per referral',
	'SETTINGS_LIMIT_REFERRALS_EXPLAIN'			=> '<em>Note: Requires referral features to be enabled.</em>',

	// Referral settings
	'SETTINGS_ENABLE_REFERRAL'					=> 'Enable referrals',
	'SETTINGS_ENABLE_REFERRAL_EXPLAIN'			=> 'Adds the ability to refer new users, keep track of who referred whom, etc.',
	'SETTINGS_REFERRAL_INVITATION_BRIDGE'		=> 'Include successful invitations',
	'SETTINGS_REFERRAL_INVITATION_BRIDGE_EXPLAIN'=> 'If enabled, successful invitations will also increase the referral counter.<br/><em>Note: This connects invitation and referral features. Disable to keep referral features stand-alone.</em>',
	'SETTINGS_REFERRAL_AUTOHIDE'				=> 'Autohide referral field',
	'SETTINGS_REFERRAL_AUTOHIDE_EXPLAIN'		=> 'If enabled, the input field during registration will be hidden automatically if a referrer can be detected (Invitation code, Cookie or URL).',
	'SETTINGS_REFERRAL_AS'						=> 'Autocomplete',
	'SETTINGS_REFERRAL_AS_EXPLAIN'				=> 'If enabled, the referrer´s username will be completed automatically using AJAX.',
	'SETTINGS_REFERRAL_AS_LIMIT'				=> 'Autocomplete limit',
	'SETTINGS_REFERRAL_AS_LIMIT_EXPLAIN'		=> 'The maximum number of users to be displayed at the same time.<br/><em>Note: Higher numbers will result in more database queries.</em>',
	'SETTINGS_REFERRAL_FRIENDS'					=> 'Add friends',
	'SETTINGS_REFERRAL_FRIENDS_EXPLAIN'			=> 'This will add the referrer and the referred user to the friendlist of each other.<br/><em>Note: Overridden by invitation-specific settings.</em>',
	'SETTINGS_REFERRAL_REQUIRE'					=> 'Referrer required',
	'SETTINGS_REFERRAL_REQUIRE_EXPLAIN'			=> 'If enabled, users are forced to enter the username of the person who referred them.',
	'SETTINGS_REFERRAL_AUTODISABLE'				=> 'Autodisable referral field',
	'SETTINGS_REFERRAL_AUTODISABLE_EXPLAIN'		=> 'This will disable the input field during registration if a referrer can be detected (Invitation code, Cookie or URL).<br/><em>Note: Overridden by autohide setting.</em>',
	'SETTINGS_REFERRAL_COOKIE'					=> 'Set cookies',
	'SETTINGS_REFERRAL_COOKIE_EXPLAIN'			=> 'This will enable referred persons to explore your board before registering while keeping the username of the referrer.',
	'SETTINGS_REFERRAL_SEARCH_ALLOWED'			=> 'Enable search',
	'SETTINGS_REFERRAL_SEARCH_ALLOWED_EXPLAIN'	=> 'If set to yes, users will be able to find a member by searching for referral related criteria.<br/><em>Note: The criterion itself must be enabled in the display options below.</em>',
	'SETTINGS_DISPLAY_P_REFERRAL_LINK'			=> 'Show referral link',
	'SETTINGS_DISPLAY_P_REFERRAL_LINK_EXPLAIN'	=> 'This will display a referral link on the profile page of each user.',
	'SETTINGS_REFERRAL_CONFIRMATION'			=> 'Send confirmation',
	'SETTINGS_REFERRAL_CONFIRMATION_EXPLAIN'	=> 'If enabled, users will receive a confirmation when they are specified as a referrer or a new user registers using their referral link.',
	'SETTINGS_REFERRAL_CONFIRMATION_DUPLICATE'	=> 'Send confirmation for successful invitations',
	'SETTINGS_REFERRAL_CONFIRMATION_DUPLICATE_EXPLAIN'	=> 'If enabled, users will receive a confirmation even though the referral is due to a successful invitation.<br/><em>Note: This will result in duplicate confirmations, if successful invitations are confirmed too.</em>',

	// UMIL
	'ACP_INVITE_DONATE_BUTTON'			=> 'Invite A Friend <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=4SA7YVJADG5S8"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" target="_blank" title="Donate" /></a>',
	'TRANSFER_INVITATION_DATA'			=> 'Transfer old data',
	'TRANSFER_INVITATION_DATA_EXPLAIN'	=> 'Select yes to transfer statistics like the amount of invitations sent from version 0.5.4 and previous ones. The database table must not have been edited manually since that time.',
));

?>