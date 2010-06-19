<?php
/**
*
* @package ucp
* @version $Id: ucp_invite.php 8479 2008-10-10 00:22:48Z Bycoja $
* @copyright (c) 2005 phpBB Group
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
         'filename'   => 'ucp_invite',
         'title'      => 'UCP_INVITE',
         'version'   => '0.2.2',
         'modes'      => array(
            'invite'      => array('title' => 'UCP_INVITE_INVITE', 'auth' => '', 'cat' => array('UCP_INVITE')),
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