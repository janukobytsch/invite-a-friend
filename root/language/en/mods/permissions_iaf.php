<?php
/**
*
* permissions_invitations [British English]
*
* @author Bycoja bycoja@web.de
* @package language
* @version $Id permissions_invitations.php 0.6.2 2010-06-22 17:28:02GMT Bycoja $
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

// Define a new permission category
$lang['permission_cat']['invitations'] = 'Invitations';

// Add the permissions
$lang = array_merge($lang, array(
	// Admin permissions
	'acl_a_view_invitation_settings'		=> array('lang' => 'Can view the invitation settings', 'cat' => 'invitations'),
	'acl_a_alter_invitation_settings'		=> array('lang' => 'Can alter the invitation settings', 'cat' => 'invitations'),
	'acl_a_view_invitation_templates'		=> array('lang' => 'Can view the invitation templates', 'cat' => 'invitations'),
	'acl_a_alter_invitation_templates'		=> array('lang' => 'Can alter the invitation templates', 'cat' => 'invitations'),
	'acl_a_view_invitation_log'				=> array('lang' => 'Can view the invitation log', 'cat' => 'invitations'),
	'acl_a_clear_invitation_log'			=> array('lang' => 'Can clear the invitation log', 'cat' => 'invitations'),
	'acl_a_view_invitation_pending'			=> array('lang' => 'Can view pending registrations', 'cat' => 'invitations'),
	'acl_a_cancel_invitation_pending'		=> array('lang' => 'Can cancel pending registrations disabling the referral key', 'cat' => 'invitations'),

	// Moderator permissions
	'acl_m_ignore_invitation_limit'			=> array('lang' => 'Can exceed the invitation limits', 'cat' => 'invitations'),
	'acl_m_ignore_invitation_queue'			=> array('lang' => 'Can skip the invitation queue', 'cat' => 'invitations'),
	'acl_m_ignore_recipients_limit'			=> array('lang' => 'Can exceed the maximum number of recipients', 'cat' => 'invitations'),
	'acl_m_ignore_characters_limit'			=> array('lang' => 'Can ignore the maximum number of characters', 'cat' => 'invitations'),
	'acl_m_ignore_invitation_captcha'		=> array('lang' => 'Can ignore the visual confirmation when sending invitations', 'cat' => 'invitations'),
	'acl_m_ignore_invitation_fee'			=> array('lang' => 'Can ignore the invitation fee<br /><em>This only applies if a reward system (e.g. CashMOD) is installed.</em>', 'cat' => 'invitations'),

	// User permissions
	'acl_u_send_invitations'				=> array('lang' => 'Can send invitations', 'cat' => 'invitations'),
	'acl_u_view_invitation_log'				=> array('lang' => 'Can view his invitation log', 'cat' => 'invitations'),
	'acl_u_view_invitation_pending'			=> array('lang' => 'Can view his pending registrations', 'cat' => 'invitations'),
	'acl_u_cancel_invitation_pending'		=> array('lang' => 'Can cancel his pending registrations disabling the referral key', 'cat' => 'invitations'),
	'acl_u_multiple_recipients'				=> array('lang' => 'Can send invitations to multiple recipients', 'cat' => 'invitations'),
	'acl_u_receive_confirmation'			=> array('lang' => 'Can receive confirmations', 'cat' => 'invitations'),
	'acl_u_add_invitation_friend'			=> array('lang' => 'Can add invited users as future friends', 'cat' => 'invitations'),
	'acl_u_change_invitation_priority'		=> array('lang' => 'Can set the invitation priority', 'cat' => 'invitations'),
	'acl_u_search_invitation_criteria'		=> array('lang' => 'Can find members by searching for invitation related criteria', 'cat' => 'invitations'),
	'acl_u_credit_invitations'				=> array('lang' => 'Can receive credit for invitations<br /><em>This only applies if a reward system (e.g. CashMOD) is installed.</em>', 'cat' => 'invitations'),
	'acl_u_credit_referrals'				=> array('lang' => 'Can receive credit for referrals<br /><em>This only applies if a reward system (e.g. CashMOD) is installed.</em>', 'cat' => 'invitations'),
	'acl_u_credit_successful_invitations'	=> array('lang' => 'Can receive credit for successful invitations<br /><em>This only applies if a reward system (e.g. CashMOD) is installed.</em>', 'cat' => 'invitations'),
));

?>