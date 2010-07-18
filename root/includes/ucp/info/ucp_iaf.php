<?php
/**
*
* @author Bycoja bycoja@web.de
* @package ucp
* @version $Id ucp_iaf.php 0.7.0 2010-06-22 17:28:02GMT Bycoja $
* @copyright (c) 2010 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @package module_install
*/
class ucp_iaf_info
{
	function module()
	{
		return array(
			'filename'	=> 'ucp_iaf',
			'title'    	=> 'UCP_IAF_TITLE',
			'version' 	=> '0.7.0',
			'modes'    	=> array(
				'compose'		=> array('title' => 'UCP_IAF_COMPOSE', 'auth' => 'acl_u_iaf_compose', 'cat' => array('UCP_IAF_TITLE')),
				'log'			=> array('title' => 'UCP_IAF_LOG', 'auth' => 'acl_u_iaf_view_log', 'cat' => array('UCP_IAF_TITLE')),
				'pending_regs'	=> array('title' => 'UCP_IAF_PENDING', 'auth' => 'acl_u_iaf_view_pending_regs', 'cat' => array('UCP_IAF_TITLE')),
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