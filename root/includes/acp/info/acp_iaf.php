<?php
/** 
*
* @author Bycoja bycoja@web.de
* @package acp
* @version $Id acp_iaf.php 0.7.0 2010-06-22 17:28:02GMT Bycoja $
* @copyright (c) 2010 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @package module_install
*/
class acp_iaf_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_iaf',
			'title'		=> 'ACP_IAF_TITLE',
			'version'	=> '0.7.0',
			'modes'		=> array(
				'invitation'	=> array('title' => 'ACP_IAF_INVITATION_SETTINGS', 'auth' => 'acl_a_iaf_view_invitation_settings', 'cat' => array('ACP_IAF_TITLE')),
				'referral'		=> array('title' => 'ACP_IAF_REFERRAL_SETTINGS', 'auth' => 'acl_a_iaf_view_referral_settings', 'cat' => array('ACP_IAF_TITLE')),
				'templates'		=> array('title' => 'ACP_IAF_TEMPLATES', 'auth' => 'acl_a_iaf_view_templates', 'cat' => array('ACP_IAF_TITLE')),
				'log'			=> array('title' => 'ACP_IAF_LOG', 'auth' => 'acl_a_iaf_view_log', 'cat' => array('ACP_IAF_TITLE')),
				'pending_regs'	=> array('title' => 'ACP_IAF_PENDING_REGS', 'auth' => 'acl_a_iaf_view_pending_regs', 'cat' => array('ACP_IAF_TITLE')),
			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}

?>