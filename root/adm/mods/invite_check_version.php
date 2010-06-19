<?php
/**
*
* @author Bycoja bycoja@web.de
* @package acp
* @version $Id invite_version_check.php 0.6.1 2010-04-05 15:14:09GMT Bycoja $
* @copyright (c) 2010 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @package mod_version_check
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

class invite_check_version
{
	function version()
	{
		global $config;

		return array(
			'author'	=> 'Bycoja',
			'title'		=> 'Invite A Friend',
			'tag'		=> 'invite',
			'version'	=> '0.6.1',
			'file'		=> array('bycoja.bplaced.net', 'mods/versioncheck', 'invite.xml'),
		);
	}
}

?>