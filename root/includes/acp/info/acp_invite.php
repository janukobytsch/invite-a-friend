<?php
/**
* @author Bycoja bycoja@web.de
*
* @package acp
* @version $Id: acp_invite.php 8479 2009-02-18 18:04:51Z Bycoja $
* @copyright (c) 2008 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package module_install
*/
class acp_invite_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_invite',
			'title'		=> 'ACP_INVITE',
			'version'	=> '0.5.0',
			'modes'		=> array(
				'settings'		=> array('title' => 'ACP_INVITE', 'auth' => 'acl_a_', 'cat' => array('ACP_BOARD_CONFIGURATION')),
				'log'			=> array('title' => 'ACP_INVITE_LOG', 'auth' => 'acl_a_viewlogs', 'cat' => array('ACP_FORUM_LOGS')),
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