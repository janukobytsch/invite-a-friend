<?php
/**
*
* @author Bycoja bycoja@web.de
* @package ucp
* @version $Id ucp_invite 0.6.0 2010-04-02 01:37:02GMT Bycoja $
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
class ucp_invite_info
{
	function module()
	{
		return array(
			'filename'	=> 'ucp_invite',
			'title'    	=> 'UCP_INVITE',
			'version' 	=> '0.6.0',
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