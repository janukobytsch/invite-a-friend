<?php
/**
*
* @author Bycoja bycoja@web.de
* @package acp
* @version $Id iaf_check_version.php 0.7.0 2010-06-22 17:28:02GMT Bycoja $
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
			'tag'		=> 'iaf',
			'version'	=> '0.7.0',
			'file'		=> array('bycoja.bplaced.net', 'mods/versioncheck', 'iaf.xml'),
		);
	}
}

?>