<?php
/** 
*
* @author Bycoja bycoja@web.de
* @package acp
* @version $Id acp_invite.php 0.6.1 2010-04-05 15:14:09GMT Bycoja $
* @copyright (c) 2010 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
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
			'version'	=> '0.6.1',
			'modes'		=> array(
				'settings'		=> array('title' => 'ACP_INVITE_SETTINGS', 'auth' => 'acl_a_invite_settings', 'cat' => array('ACP_BOARD_CONFIGURATION')),
				'templates'		=> array('title' => 'ACP_INVITE_TEMPLATES', 'auth' => 'acl_a_invite_settings', 'cat' => array('ACP_BOARD_CONFIGURATION')),
				'log'			=> array('title' => 'ACP_INVITE_LOG', 'auth' => 'acl_a_invite_log', 'cat' => array('ACP_FORUM_LOGS')),
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