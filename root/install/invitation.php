<?php
/**
*
* @author Bycoja bycoja@web.de
* @package umil
* @version $Id index.php 0.6.0 2010-04-02 01:37:02GMT Bycoja $
* @copyright (c) 2010 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
define('UMIL_AUTO', true);
define('IN_PHPBB', true);
define('IN_INSTALL', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

if (!file_exists($phpbb_root_path . 'umil/umil_auto.' . $phpEx))
{
	trigger_error('Please download the latest UMIL (Unified MOD Install Library) from: <a href="http://www.phpbb.com/mods/umil/">phpBB.com/mods/umil</a>', E_USER_ERROR);
}

include($phpbb_root_path . 'includes/functions_mods.'.$phpEx);

// The name of the mod to be displayed during installation.
$mod_name = 'ACP_INVITE';

/*
* The name of the config variable which will hold the currently installed version
* You do not need to set this yourself, UMIL will handle setting and updating the version itself.
*/
$version_config_name = 'invite_version';

/*
* The language file which will be included when installing
* Language entries that should exist in the language file for UMIL (replace $mod_name with the mod's name you set to $mod_name above)
* $mod_name
* 'INSTALL_' . $mod_name
* 'INSTALL_' . $mod_name . '_CONFIRM'
* 'UPDATE_' . $mod_name
* 'UPDATE_' . $mod_name . '_CONFIRM'
* 'UNINSTALL_' . $mod_name
* 'UNINSTALL_' . $mod_name . '_CONFIRM'
*/
$language_file = 'mods/info_acp_invite';

/*
* The array of versions and actions within each.
* You do not need to order it a specific way (it will be sorted automatically), however, you must enter every version, even if no actions are done for it.
*
* You must use correct version numbering.  Unless you know exactly what you can use, only use X.X.X (replacing X with an integer).
* The version numbering must otherwise be compatible with the version_compare function - http://php.net/manual/en/function.version-compare.php
*/

$versions = array(
	// Version 0.6.0 - First beta version using UMIL
	'0.6.0'	=> array(
		// Add permission settings
		'permission_add' => array(
			array('a_invite_settings', true),
			array('a_invite_log', true),
			array('u_send_invite', true),
		),

		// Add role permissions
		'permission_set' => array(
			array('ROLE_ADMIN_STANDARD', 'a_invite_settings', 'role'),
			array('ROLE_ADMIN_STANDARD', 'a_invite_log', 'role'),
			array('ROLE_ADMIN_FULL', 'a_invite_settings', 'role'),
			array('ROLE_ADMIN_FULL', 'a_invite_log', 'role'),
			array('ROLE_USER_FULL', 'u_send_invite', 'role'),
			array('ROLE_USER_STANDARD', 'u_send_invite', 'role'),
			array('ROLE_USER_NOPM', 'u_send_invite', 'role'),
			array('ROLE_USER_NOAVATAR', 'u_send_invite', 'role'),
		),

		// Add modules
		'module_add' => array(
			// Add a new category to ACP_CAT_DOT_MODS
			array('acp', 'ACP_CAT_DOT_MODS', 'ACP_INVITE'),

			// Add settings module to the added category
			array('acp', 'ACP_INVITE', array(
					'module_basename'	=> 'invite',
					'module_langname'	=> 'ACP_INVITE_SETTINGS',
					'module_mode'		=> 'settings',
					'module_auth'		=> 'acl_a_invite_settings',
				),
			),

			// Add templates module to the added category
			array('acp', 'ACP_INVITE', array(
					'module_basename'	=> 'invite',
					'module_langname'	=> 'ACP_INVITE_TEMPLATES',
					'module_mode'		=> 'templates',
					'module_auth'		=> 'acl_a_invite_settings',
				),
			),

			// Add log module to the added category
			array('acp', 'ACP_INVITE', array(
					'module_basename'	=> 'invite',
					'module_langname'	=> 'ACP_INVITE_LOG',
					'module_mode'		=> 'log',
					'module_auth'		=> 'acl_a_invite_log',
				),
			),

			// Add a new category to UCP
			array('ucp', '', 'UCP_INVITE'),

			// Add invitation module to the added category
			array('ucp', 'UCP_INVITE', array(
					'module_basename'	=> 'invite',
					'module_langname'	=> 'UCP_INVITE_INVITE',
					'module_mode'		=> 'invite',
					'module_auth'		=> 'acl_u_send_invite',
				),
			),
		),

		/**
		* Define the basic structure
		* The format:
		*		array('{TABLE_NAME}' => {TABLE_DATA})
		*		{TABLE_DATA}:
		*			COLUMNS = array({column_name} = array({column_type}, {default}, {auto_increment}))
		*			PRIMARY_KEY = {column_name(s)}
		*			KEYS = array({key_name} = array({key_type}, {column_name(s)})),
		*
		*	Column Types:
		*	INT:x		=> SIGNED int(x)
		*	BINT			=> BIGINT
		*	UINT		=> mediumint(8) UNSIGNED
		*	UINT:x		=> int(x) UNSIGNED
		*	TINT:x		=> tinyint(x)
		*	USINT		=> smallint(4) UNSIGNED (for _order columns)
		*	BOOL		=> tinyint(1) UNSIGNED
		*	VCHAR		=> varchar(255)
		*	CHAR:x		=> char(x)
		*	XSTEXT_UNI	=> text for storing 100 characters (topic_title for example)
		*	STEXT_UNI	=> text for storing 255 characters (normal input field with a max of 255 single-byte chars) - same as VCHAR_UNI
		*	TEXT_UNI		=> text for storing 3000 characters (short text, descriptions, comments, etc.)
		*	MTEXT_UNI	=> mediumtext (post text, large text)
		*	VCHAR:x		=> varchar(x)
		*	TIMESTAMP	=> int(11) UNSIGNED
		*	DECIMAL		=> decimal number (5,2)
		*	DECIMAL:		=> decimal number (x,2)
		*	PDECIMAL		=> precision decimal number (6,3)
		*	PDECIMAL:		=> precision decimal number (x,3)
		*	VCHAR_UNI	=> varchar(255) BINARY
		*	VCHAR_CI		=> varchar_ci for postgresql, others VCHAR
		*/
		'table_add'		=> array(
			array($table_prefix . 'invite_log', array(
					'COLUMNS'		=> array(
						'log_id'				=> array('UINT', NULL, 'auto_increment'),
						'invite_user_id'		=> array('UINT', 0),
						'invite_confirm'		=> array('BOOL', 0),
						'invite_confirm_method'	=> array('BOOL', 0),
						'invite_zebra'			=> array('BOOL', 0),
						'invite_time'			=> array('TIMESTAMP', 0),
						'invite_session_ip'		=> array('VCHAR:32', ''),
						'register_key'			=> array('VCHAR:40', ''),
						'register_key_used'		=> array('BOOL', 0),
						'register_email'		=> array('VCHAR:100', ''),
						'register_user_id'		=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> 'log_id',
				),
			),

			array($table_prefix . 'invite_config', array(
					'COLUMNS'		=> array(
						'config_name'		=> array('VCHAR', ''),
						'config_value'		=> array('VCHAR_UNI', ''),
					),
					'PRIMARY_KEY'	=> 'config_name',
				),
			),
		),

		// Add fields to users table
		'table_column_add' => array(
			array($table_prefix . 'users', 'user_invitations', array('UINT', 0)),
			array($table_prefix . 'users', 'user_registrations', array('UINT', 0)),
			array($table_prefix . 'users', 'user_inviter_id', array('UINT', NULL)),
			array($table_prefix . 'users', 'user_inviter_name', array('VCHAR_UNI', '')),
		),

		// Clear the cache
		'cache_purge' => array(
			array(),
			array('auth'),
			array('template'),
		),

		/*
		* Now we need to insert some data. The easiest way to do that is through a custom function.
		* Enter 'custom' for the array key and the name of the function for the value.
		*/
		'custom'	=> 'insert_data_060',
	),
);

// As version 0.5.4 doesn't support UMIL we have to make updating work correctly...
if (isset($config[$version_config_name]))
{
	if (version_compare($config[$version_config_name], '0.5.4', '=='))
	{
		// Set up version array containing update instructions
		$versions = array(
			'0.6.0'	=> array(
				// Add permission settings
				'permission_add' => array(
					array('a_invite_settings', true),
					array('a_invite_log', true),
				),

				// Add role permissions
				'permission_set' => array(
					array('ROLE_ADMIN_STANDARD', 'a_invite_settings', 'role'),
					array('ROLE_ADMIN_STANDARD', 'a_invite_log', 'role'),
					array('ROLE_ADMIN_FULL', 'a_invite_settings', 'role'),
					array('ROLE_ADMIN_FULL', 'a_invite_log', 'role'),
				),

				/*
				* We won't add any modules here as some of them already exist
				* Handle them in our custom function
				*/

				// Add fields to users table
				'table_column_add' => array(
					array($table_prefix . 'users', 'user_invitations', array('UINT', 0)),
					array($table_prefix . 'users', 'user_registrations', array('UINT', 0)),
					array($table_prefix . 'users', 'user_inviter_id', array('UINT', NULL)),
					array($table_prefix . 'users', 'user_inviter_name', array('VCHAR_UNI', '')),
				),

				// Clear the cache
				'cache_purge' => array(
					array(),
					array('auth'),
					array('template'),
				),

				/*
				* Now we need to insert some data. The easiest way to do that is through a custom function.
				* Enter 'custom' for the array key and the name of the function for the value.
				*/
				'custom'	=> 'insert_data_060',
			),
		);
	}
}

// Include the UMIF Auto file and everything else will be handled automatically.
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);


/*
* Here is our custom function that will be called for version 0.6.0
*
* @param string $action The action (install|update|uninstall) will be sent through this.
* @param string $version The version this is being run for will be sent through this.
*/
function insert_data_060($action, $version)
{
	global $db, $table_prefix, $umil, $config, $version_config_name;

	switch ($action)
	{
		case 'install' :
		case 'update' :
			// Run this when installing the first time
			if ($umil->table_exists($table_prefix . 'invite_config'))
			{
				// Before we fill anything in this table, we truncate it. Maybe someone missed an old installation.
				$db->sql_query('TRUNCATE TABLE ' . $table_prefix . 'invite_config');

				// Now that's a lot of config...
				$sql_ary = array();

				$sql_ary[] = array('config_name' => 'tracking_time', 			'config_value' => time());
				$sql_ary[] = array('config_name' => 'num_invitations', 			'config_value' => 0);
				$sql_ary[] = array('config_name' => 'num_registrations', 		'config_value' => 0);
				$sql_ary[] = array('config_name' => 'enable',					'config_value' => 1);
				$sql_ary[] = array('config_name' => 'enable_key',				'config_value' => 2);
				$sql_ary[] = array('config_name' => 'key_group', 				'config_value' => 2);
				$sql_ary[] = array('config_name' => 'key_group_default', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'remove_newly_registered', 	'config_value' => 1);
				$sql_ary[] = array('config_name' => 'invite_require_activation','config_value' => 0);
				$sql_ary[] = array('config_name' => 'invite_multiple', 			'config_value' => 1);
				$sql_ary[] = array('config_name' => 'prevent_abuse', 			'config_value' => 1);
				$sql_ary[] = array('config_name' => 'invite_confirm_code', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'set_cookie', 				'config_value' => 1);
				$sql_ary[] = array('config_name' => 'enable_email_identification','config_value' => 1);
				$sql_ary[] = array('config_name' => 'invite_search_allowed', 	'config_value' => 1);
				$sql_ary[] = array('config_name' => 'queue_time', 				'config_value' => 300);
				$sql_ary[] = array('config_name' => 'message_min_chars', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'message_max_chars', 		'config_value' => 1000);
				$sql_ary[] = array('config_name' => 'subject_min_chars', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'subject_max_chars', 		'config_value' => 50);
				$sql_ary[] = array('config_name' => 'confirm', 					'config_value' => 2);
				$sql_ary[] = array('config_name' => 'confirm_method', 			'config_value' => 2);
				$sql_ary[] = array('config_name' => 'zebra', 					'config_value' => 2);
				$sql_ary[] = array('config_name' => 'invite_language_select', 	'config_value' => 'opt');
				$sql_ary[] = array('config_name' => 'invite_priority_flag', 	'config_value' => MAIL_NORMAL_PRIORITY);
				$sql_ary[] = array('config_name' => 'display_navigation', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'display_registration', 	'config_value' => 1);
				$sql_ary[] = array('config_name' => 'autohide_valid_key', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'advanced_statistics', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'display_t_inviter', 		'config_value' => 0);
				$sql_ary[] = array('config_name' => 'display_t_invite', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'display_t_register', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'display_p_inviter', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'display_p_invite', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'display_p_register', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'display_m_inviter', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'display_m_invite', 		'config_value' => 1);
				$sql_ary[] = array('config_name' => 'display_m_register', 		'config_value' => 0);
				$sql_ary[] = array('config_name' => 'enable_limit_daily', 		'config_value' => 0);
				$sql_ary[] = array('config_name' => 'limit_daily_basic', 		'config_value' => 10);
				$sql_ary[] = array('config_name' => 'limit_daily_registrations','config_value' => 10);
				$sql_ary[] = array('config_name' => 'limit_daily_registrations_invitations','config_value' => 1);
				$sql_ary[] = array('config_name' => 'limit_daily_posts', 		'config_value' => 200);
				$sql_ary[] = array('config_name' => 'limit_daily_posts_invitations','config_value' => 1);
				$sql_ary[] = array('config_name' => 'limit_daily_topics', 		'config_value' => 10);
				$sql_ary[] = array('config_name' => 'limit_daily_topics_invitations','config_value' => 1);
				$sql_ary[] = array('config_name' => 'limit_daily_memberdays', 	'config_value' => 100);
				$sql_ary[] = array('config_name' => 'limit_daily_memberdays_invitations','config_value' => 1);
				$sql_ary[] = array('config_name' => 'enable_limit_total', 		'config_value' => 0);
				$sql_ary[] = array('config_name' => 'limit_total_basic', 		'config_value' => 100);
				$sql_ary[] = array('config_name' => 'limit_total_registrations','config_value' => 10);
				$sql_ary[] = array('config_name' => 'limit_total_registrations_invitations','config_value' => 2);
				$sql_ary[] = array('config_name' => 'limit_total_posts', 		'config_value' => 200);
				$sql_ary[] = array('config_name' => 'limit_total_posts_invitations','config_value' => 5);
				$sql_ary[] = array('config_name' => 'limit_total_topics',		'config_value' => 10);
				$sql_ary[] = array('config_name' => 'limit_total_topics_invitations','config_value' => 2);
				$sql_ary[] = array('config_name' => 'limit_total_memberdays', 	'config_value' => 100);
				$sql_ary[] = array('config_name' => 'limit_total_memberdays_invitations','config_value' => 10);
				$sql_ary[] = array('config_name' => 'enable_cash',				'config_value' => 0);
				$sql_ary[] = array('config_name' => 'cash_invite', 				'config_value' => 10);
				$sql_ary[] = array('config_name' => 'cash_id_invite', 			'config_value' => 1);
				$sql_ary[] = array('config_name' => 'cash_register', 			'config_value' => 20);
				$sql_ary[] = array('config_name' => 'cash_id_register',			'config_value' => 1);
				$sql_ary[] = array('config_name' => 'enable_ultimate_points', 	'config_value' => 0);
				$sql_ary[] = array('config_name' => 'ultimate_points_invite', 	'config_value' => 5);
				$sql_ary[] = array('config_name' => 'ultimate_points_register', 'config_value' => 20);

				$db->sql_multi_insert($table_prefix . 'invite_config ', $sql_ary);
			}

			// As version 0.5.4 doesn't support UMIL we have to make updating work correctly...
			if (isset($config[$version_config_name]))
			{
				if (version_compare($config[$version_config_name], '0.5.4', '=='))
				{
					if (!class_exists('umil'))
					{
						include($phpbb_root_path . 'umil/umil.' . $phpEx);

						if (!isset($umil) || !is_object($umil))
						{
							$umil = new umil();
						}
					}
					// Remove old modules with categories first to not cause any error
					$umil->module_remove('acp', 'ACP_INVITE', 'ACP_INVITE');
					$umil->module_remove('acp', false, 'ACP_INVITE_LOG');
					$umil->module_remove('acp', false, 'ACP_INVITE');
					$umil->module_remove('ucp', false, 'UCP_INVITE_INVITE');
					$umil->module_remove('ucp', false, 'UCP_INVITE');

					// Add a new category to ACP_CAT_DOT_MODS
					$umil->module_add('acp', 'ACP_CAT_DOT_MODS', array(
						'module_langname'	=> 'ACP_INVITE',
					));

					// Add settings module to the added category
					$umil->module_add('acp', 'ACP_INVITE', array(
						'module_basename'	=> 'invite',
						'module_langname'	=> 'ACP_INVITE_SETTINGS',
						'module_mode'		=> 'settings',
						'module_auth'		=> 'acl_a_invite_settings',
					));

					// Add templates module to the added category
					$umil->module_add('acp', 'ACP_INVITE', array(
						'module_basename'	=> 'invite',
						'module_langname'	=> 'ACP_INVITE_TEMPLATES',
						'module_mode'		=> 'templates',
						'module_auth'		=> 'acl_a_invite_settings',
					));

					// Add log module to the added category
					$umil->module_add('acp', 'ACP_INVITE', array(
						'module_basename'	=> 'invite',
						'module_langname'	=> 'ACP_INVITE_LOG',
						'module_mode'		=> 'log',
						'module_auth'		=> 'acl_a_invite_log',
					));

					// Add a new category to UCP
					$umil->module_add('ucp', 0, array(
						'module_langname'	=> 'UCP_INVITE',
					));

					// Add invitation module to the added category
					$umil->module_add('ucp', 'UCP_INVITE', array(
						'module_basename'	=> 'invite',
						'module_langname'	=> 'UCP_INVITE_INVITE',
						'module_mode'		=> 'invite',
						'module_auth'		=> 'acl_u_send_invite',
					));
				}
			}

			// Send a message that the command was successful
			return 'Populated database tables';
		break;

 		case 'uninstall' :
		break;
	}
}

?>