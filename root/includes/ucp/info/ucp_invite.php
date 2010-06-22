<?php
/**
*
* @author Bycoja bycoja@web.de
* @package ucp
* @version $Id ucp_invite.php 0.6.2 2010-06-22 17:28:02GMT Bycoja $
* @copyright (c) 2010 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @package module_install
*/
class ucp_invite_info
{
	function module()
	{
		return array(
			'filename'	=> 'ucp_invite',
			'title'    	=> 'UCP_INVITE',
			'version' 	=> '0.6.2',
			'modes'    	=> array(
				'invite'	=> array('title' => 'UCP_INVITE_INVITE', 'auth' => 'acl_u_send_invite', 'cat' => array('UCP_INVITE')),
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