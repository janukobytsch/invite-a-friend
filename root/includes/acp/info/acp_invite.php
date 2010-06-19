<?php
/**
*
* @package acp
* @version $Id: acp_invite.php 8645 2008-10-03 10:40:17Z Bycoja $
* @copyright (c) 2008 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @package module_install
*/
class acp_invite_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_invite',
			'title'		=> 'ACP_INVITE_A_FRIEND',
			'version'	=> '0.2.2',
			'modes'		=> array(
				'settings'		=> array('title' => 'ACP_INVITE_A_FRIEND', 'auth' => 'acl_a_', 'cat' => array('ACP_BOARD_CONFIGURATION')),
				'log'			=> array('title' => 'ACP_INVITE_A_FRIEND_LOG', 'auth' => 'acl_a_', 'cat' => array('ACP_BOARD_CONFIGURATION')),
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