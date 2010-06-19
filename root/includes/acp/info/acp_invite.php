<?php
/** 
* @author Bycoja bycoja@web.de
*
* @package acp
* @version $Id: acp_invite.php 5.0.1 2009-04-12 22:35:59GMT Bycoja $
* @copyright (c) 2008-2009 Bycoja
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
	var $version 	= '0.5.1';
	var $module		= array(
		'acp_settings'	=> 'ACP_INVITE',
		'acp_log'		=> 'ACP_INVITE_LOG',
		'ucp_category'	=> 'UCP_INVITE',
		'ucp_module'	=> 'UCP_INVITE_INVITE',
	);

	function module()
	{
		$action = request_var('action', '');

		if ($action == 'add' || $action == 'quickadd')
		{
			$this->install();
		}
		
		return array(
			'filename'	=> 'acp_invite',
			'title'		=> 'ACP_INVITE',
			'version'	=> $this->version,
			'modes'		=> array(
				'settings'		=> array('title' => $this->module['acp_settings'], 'auth' => 'acl_a_', 'cat' => array('ACP_BOARD_CONFIGURATION')),
				'log'			=> array('title' => $this->module['acp_log'], 'auth' => 'acl_a_viewlogs', 'cat' => array('ACP_FORUM_LOGS')),
			),
		);
	}

	function install()
	{
		global $phpbb_admin_path, $phpEx, $config, $cache, $user;

		// Make sure we don't already have this version installed
		if (isset($config['invite_version']))
		{
			if (!version_compare($config['invite_version'], $this->version, '<'))
			{
				return;
			}
			else
			{
				$this->upgrade();
				return;
			}
		}
		
		$this->create_tables();
		$this->populate_tables();
		$this->add_permissions();
		$this->add_config();
		$this->add_modules();
		$this->unlink_files();
		$cache->purge();
		
		$invite_url = append_sid("{$phpbb_admin_path}index.$phpEx", 'i=invite&amp;mode=settings');
		trigger_error(sprintf($user->lang['ACP_INVITE_INSTALLED'], '<a href="' . $invite_url . '">', '</a>'));
	}
	
	function create_tables()
	{
		global $phpbb_root_path, $phpEx, $db, $dbms, $table_prefix;
		include($phpbb_root_path . 'includes/functions_install.'.$phpEx);
		
		$available_dbms = get_available_dbms();
		
		// If mysql is chosen, we need to adjust the schema filename slightly to reflect the correct version. ;)
		if ($dbms == 'mysql')
		{
			if (version_compare($db->sql_server_info(true), '4.1.3', '>='))
			{
				$available_dbms[$dbms]['SCHEMA'] .= '_41';
			}
			else
			{
				$available_dbms[$dbms]['SCHEMA'] .= '_40';
			}
		}
		
		// Load the correct schema
		$dbms_schema = $phpbb_root_path . 'includes/invite/schemas/' . $available_dbms[$dbms]['SCHEMA'] . '_schema.sql';;
		
		// How should we treat this schema?
		$remove_remarks = $available_dbms[$dbms]['COMMENTS'];
		$delimiter 		= $available_dbms[$dbms]['DELIM'];
		
		$sql_query = @file_get_contents($dbms_schema);
		$sql_query = preg_replace('#phpbb_#i', $table_prefix, $sql_query);
		$remove_remarks($sql_query);
		$sql_query = split_sql_file($sql_query, $delimiter);
		
		foreach ($sql_query as $sql)
		{
			$db->sql_query($sql);
		}
	}
	
	function populate_tables()
	{
		global $db;
		
		// INVITE_CONFIG_TABLE
		$config_ary = array(
			'enable'					=> 1,
			'enable_key'				=> 1,
			'confirm'					=> 2,
			'confirm_method'			=> 2,
			'invite_require_activation'	=> 3,
			'invite_confirm_code'		=> 1,
			'invite_language_select'	=> 1,
			'invite_multiple'			=> 0,
			'invite_yourself'			=> 0,
			'zebra'						=> 2,
			'limit_invite_day'			=> 10,
			'limit_invite_day_posts'	=> 0,
			'limit_invite_day_topics'	=> 0,
			'limit_invite_user'			=> 500,
			'limit_invite_user_posts'	=> 0,
			'limit_invite_user_topics'	=> 0,
			'display_navigation'		=> 1,
			'display_registration'		=> 1,
			'display_t_invite'			=> 1,
			'display_t_register'		=> 1,
			'display_t_name'			=> 0,
			'display_p_invite'			=> 1,
			'display_p_register'		=> 1,
			'display_p_name'			=> 1,
			'message_min_chars'			=> 1,
			'message_max_chars'			=> 1000,
			'subject_min_chars'			=> 1,
			'subject_max_chars'			=> 50,
			'queue_time'				=> 300,
			'enable_cash'				=> 0,
			'cash_invite'				=> 10,
			'cash_id_invite'			=> 1,
			'cash_register'				=> 20,
			'cash_id_register'			=> 1,
			'enable_points'				=> 0,
			'points_invite'				=> 5,
			'points_register'			=> 20,
		);
		
		foreach ($config_ary as $k => $v)
		{
			$sql_ary = array(
			   'config_name'	=> $k,
			   'config_value'	=> $v,
			);
		
			$sql = 'INSERT INTO ' . INVITE_CONFIG_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
			$db->sql_query($sql);
		}
		
		// INVITE_MESSAGE_TABLE
		$message_ary = array();
		
		$message_ary[] = 'Hello {RECIPIENT},
				this message has been sent by a friend of yours known as "{INVITE_USERNAME}", because you might be interested in the following website:
				{U_BOARD}

				You can use the following URL to register: {URL_REGISTER_KEY}

				Your friend wrote:
				-------------------------------------------
				{MESSAGE}';

		$message_ary[] = 'Hello {INVITE_USERNAME},
				this message was sent to you, because a friend of yours registered on {U_BOARD} and chose the nickname &quot;{REGISTER_USERNAME}&quot;.

				You can view his profile here: {REGISTER_USER_PROFILE}';

		foreach ($message_ary as $k => $v)
		{
			$sql_ary = array(
			   'message_type'	=> $k,
			   'message'		=> preg_replace("/[\x09\x20]{2}/", ' ', $v),
			);
		
			$sql = 'INSERT INTO ' . INVITE_MESSAGE_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
			$db->sql_query($sql);
		}
	}
	
	function add_permissions()
	{
		global $phpbb_root_path, $phpEx, $db;
		include($phpbb_root_path . 'includes/acp/auth.'.$phpEx);
		
		$auth_admin = new auth_admin();
		
		$permission_ary = array(
			'u_send_invite'		=> array('ROLE_USER_FULL', 'ROLE_USER_STANDARD'),
		);
		
		foreach ($permission_ary as $permission => $role_ary)
		{
			$auth_admin->acl_add_option(array(
				    'local'		=> array(),
				    'global'  	=> array($permission),
				));
			
			// Option
			$sql = 'SELECT auth_option_id FROM ' . ACL_OPTIONS_TABLE . "
					WHERE auth_option = '{$permission}'";
			$result 		= $db->sql_query($sql);
			$auth_option_id = (int) $db->sql_fetchfield('auth_option_id');
			$db->sql_freeresult($result);
			
			// Role
			$sql = 'SELECT role_id FROM ' . ACL_ROLES_TABLE . '
				WHERE ' . $db->sql_in_set('role_name', $role_ary);
			$result 	= $db->sql_query($sql);
			$sql_ary	= array();
			
			while ($row = $db->sql_fetchrow($result))
			{
				// Give the wanted role its option
				$sql_ary[] = array(
					'role_id'			=> $row['role_id'],
					'auth_option_id'	=> $auth_option_id,
					'auth_setting'		=> 1,
				);
			}
			$db->sql_freeresult($result);
			$db->sql_multi_insert(ACL_ROLES_DATA_TABLE, $sql_ary);
		}
	}
	
	function add_config()
	{
		global $config;
		
		set_config('invite_version', $this->version);
	}
	
	function add_modules()
	{
		global $db, $phpbb_root_path, $phpEx;

		if (!class_exists('acp_modules'))
		{
			include($phpbb_root_path . 'includes/acp/acp_modules.'.$phpEx);
		}
		
		$module = new acp_modules();
		
		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . "
			WHERE module_langname = '" . $this->module['acp_settings'] . "'";
		$result = $db->sql_query($sql);
		
		if (!$db->sql_fetchrow($result))
		{
			/*
			* ACP Modules
			*/
			// Insert Parent Module
			$acp_parent_module_data = array(
				'module_enabled'	=> 1,
				'module_display'	=> 1,
				'module_class'		=> 'acp',
				'parent_id'			=> 1,
				'module_langname'	=> $this->module['acp_settings'],
				'module_auth'		=> '',
			);

			$module->update_module_data($acp_parent_module_data, true);
			
			// Config Module
			$acp_config_module_data = array(
				'module_enabled'	=> 1,
				'module_display'	=> 1,
				'module_class'		=> 'acp',
				'parent_id'			=> $acp_parent_module_data['module_id'],
				'module_langname'	=> $this->module['acp_settings'],

				'module_basename'	=> 'invite',
				'module_mode'		=> 'settings',
				'module_auth'		=> '',
			);

			$module->update_module_data($acp_config_module_data, true);
			
			// Log Module
			$acp_log_module_data = array(
				'module_enabled'	=> 1,
				'module_display'	=> 1,
				'module_class'		=> 'acp',
				'parent_id'			=> $acp_parent_module_data['module_id'],
				'module_langname'	=> $this->module['acp_log'],

				'module_basename'	=> 'invite',
				'module_mode'		=> 'log',
				'module_auth'		=> 'acl_a_viewlogs',
			);

			$module->update_module_data($acp_log_module_data, true);
			
			/*
			* UCP Modules
			*/
			// Insert Category Module
			$ucp_category_module_data = array(
				'module_enabled'	=> 1,
				'module_display'	=> 1,
				'module_class'		=> 'ucp',
				'parent_id'			=> 0,
				'module_langname'	=> $this->module['ucp_category'],
				'module_auth'		=> '',
			);

			$module->update_module_data($ucp_category_module_data, true);
			
			// Invite Module
			$ucp_invite_module_data = array(
				'module_enabled'	=> 1,
				'module_display'	=> 1,
				'module_class'		=> 'ucp',
				'parent_id'			=> $ucp_category_module_data['module_id'],
				'module_langname'	=> $this->module['ucp_module'],

				'module_basename'	=> 'invite',
				'module_mode'		=> 'invite',
				'module_auth'		=> '',
			);

			$module->update_module_data($ucp_invite_module_data, true);
		}
	}
	
	function unlink_files()
	{
		global $phpbb_root_path;
		
		$sql_file		= array();
		$sql_file[] 	= $phpbb_root_path . 'includes/invite/schemas/mysql_40_schema.sql';
		$sql_file[] 	= $phpbb_root_path . 'includes/invite/schemas/mysql_41_schema.sql';
		
		foreach ($sql_file as $k => $v)
		{
			if (file_exists($v))
			{
				unlink($v);
			}
		}
	}
	
	function upgrade()
	{
	}
	
	function uninstall()
	{
	}
}


?>