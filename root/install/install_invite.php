<?php
/**
*
* @author Bycoja bycoja@web.de
* @package umil
* @version $Id invitation.php 0.7.0 2012-04-16 01:37:02GMT Bycoja $
* @copyright (c) 2008-2012 Bycoja
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

// Additional options
$options = array(
	'transfer_invitation_data'	=> array('lang' => 'TRANSFER_INVITATION_DATA', 'type' => 'radio:yes_no', 'function' => 'transfer_invitation_data', 'explain' => true),
);
$transfer_invitation_data = request_var('transfer_invitation_data', '', true);

// The name of the mod to be displayed during installation.
$mod_name = 'ACP_INVITE_DONATE_BUTTON';

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

		// Add role and group permissions
		'permission_set' => array(
			array('ROLE_ADMIN_STANDARD', 'a_invite_settings', 'role'),
			array('ROLE_ADMIN_STANDARD', 'a_invite_log', 'role'),
			array('ROLE_ADMIN_FULL', 'a_invite_settings', 'role'),
			array('ROLE_ADMIN_FULL', 'a_invite_log', 'role'),
			array('ROLE_USER_FULL', 'u_send_invite', 'role'),
			array('ROLE_USER_STANDARD', 'u_send_invite', 'role'),
			array('ROLE_USER_NOPM', 'u_send_invite', 'role'),
			array('ROLE_USER_NOAVATAR', 'u_send_invite', 'role'),
			array('REGISTERED', 'u_send_invite', 'group'),
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

	// Version 0.6.1
	'0.6.1'	=> array(
		// Change existing fields
		'table_column_update' => array(
			array($table_prefix . 'users', 'user_inviter_id', array('UINT', 0)),
			// NULL doesn't work for some reason, so we have to handle this in our custom function
			//array($table_prefix . 'users', 'user_inviter_name', array('VCHAR_UNI', NULL)),
		),

		/*
		* Now we need to insert some data. The easiest way to do that is through a custom function.
		* Enter 'custom' for the array key and the name of the function for the value.
		*/
		'custom'	=> 'insert_data_061',
	),

	// Version 0.7.0
	'0.7.0'	=> array(
		// Remove modules.. otherwise the module order is messed up
		'module_remove' => array(
			array('acp', 'ACP_INVITE', 'ACP_INVITE_SETTINGS'),
			array('acp', 'ACP_INVITE', 'ACP_INVITE_TEMPLATES'),
			array('acp', 'ACP_INVITE', 'ACP_INVITE_LOG'),
		),

		// Add modules
		'module_add' => array(
			array('acp', 'ACP_INVITE', array(
					'module_basename'	=> 'invite',
					'module_langname'	=> 'ACP_INVITE_OVERVIEW',
					'module_mode'		=> 'overview',
					'module_auth'		=> 'acl_a_invite_settings',
				),
			),

			array('acp', 'ACP_INVITE', array(
					'module_basename'	=> 'invite',
					'module_langname'	=> 'ACP_INVITE_SETTINGS',
					'module_mode'		=> 'settings',
					'module_auth'		=> 'acl_a_invite_settings',
				),
			),

			array('acp', 'ACP_INVITE', array(
					'module_basename'	=> 'invite',
					'module_langname'	=> 'ACP_REFERRAL_SETTINGS',
					'module_mode'		=> 'referral_settings',
					'module_auth'		=> 'acl_a_invite_settings',
				),
			),

			array('acp', 'ACP_INVITE', array(
					'module_basename'	=> 'invite',
					'module_langname'	=> 'ACP_INVITE_TEMPLATES',
					'module_mode'		=> 'templates',
					'module_auth'		=> 'acl_a_invite_settings',
				),
			),

			array('acp', 'ACP_INVITE', array(
					'module_basename'	=> 'invite',
					'module_langname'	=> 'ACP_INVITE_LOG',
					'module_mode'		=> 'log',
					'module_auth'		=> 'acl_a_invite_log',
				),
			),
		),

		'table_add'		=> array(
			array($table_prefix . 'invite_referrals', array(
					'COLUMNS'		=> array(
						'referrer_id'	=> array('UINT', 0),
						'referral_id'	=> array('UINT', 0),
						'time'			=> array('UINT:11', 0),
					),
				),
			),
		),

		// Add fields to users table
		'table_column_add' => array(
			array($table_prefix . 'invite_log', 'expiration_time', array('UINT:11', 0)),
			array($table_prefix . 'users', 'user_referrals', array('UINT', 0)),
			array($table_prefix . 'users', 'user_referrer_id', array('UINT', 0)),
			array($table_prefix . 'users', 'user_referrer_name', array('VCHAR_UNI', '')),
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
		'custom'	=> 'insert_data_070',
	),
);

// As version 0.5.4 doesn't support UMIL we have to make updating work correctly...
if (isset($config[$version_config_name]))
{
	if (version_compare($config[$version_config_name], '0.5.4', '=='))
	{
		// Set up version array containing update instructions
		$versions['0.6.0'] = array(
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
		);
	}
}

// Include the UMIF Auto file and everything else will be handled automatically.
include($phpbb_root_path . 'umil/umil_auto.' . $phpEx);

/*
* Here is our custom function that will be called in order to transfer existing invitation data and make it work with the new release
* Requires the invitation related database fields in the users table to be set
*
* Depending on the amount of existing data calling this function will run a lot of queries... be warned!
* Will only work correctly if no entries in the invitatin log table have been deleted manually.
*/
function transfer_invitation_data()
{
	global $db, $umil;

	// Array to be filled with the existing invitation data
	$invitation_data = array();

	// Array to be filled with the number of existing invitations for each user
	$invitation_count = array();

	// Grab data within the invitation table from previous versions
	$sql 	= 'SELECT *
		FROM ' . INVITE_LOG_TABLE;
	$result	= $db->sql_query($sql);
	$invitation_data = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	// Requires the invitation related database fields in the users table to be set
	for ($i = 0, $size = sizeof($invitation_data); $i < $size; $i++)
	{
		// Initialise the invitation count when running for the first time
		if (!isset($invitation_count[$invitation_data[$i]['invite_user_id']]['user_invitations']))
		{
			$invitation_count[$invitation_data[$i]['invite_user_id']]['user_invitations'] = 0;
			$invitation_count[$invitation_data[$i]['invite_user_id']]['user_registrations'] = 0;
		}

		// Add referral data and associate the invited user with the one who invited him
		if ($invitation_data[$i]['register_user_id'] && $invitation_data[$i]['register_key_used'])
		{
			$sql 	= 'SELECT username_clean
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . $invitation_data[$i]['invite_user_id'];
			$result = $db->sql_query($sql);
			$invite_username = $db->sql_fetchfield('username_clean');
			$db->sql_freeresult($result);

			$sql_ary	= array(
				'user_inviter_id'	=> (int) $invitation_data[$i]['invite_user_id'],
				'user_inviter_name'	=> $invite_username,
			);

			$sql = 'UPDATE ' . USERS_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE user_id = ' . (int) $invitation_data[$i]['register_user_id'];
			$result = $db->sql_query($sql);

			$invitation_count[$invitation_data[$i]['invite_user_id']]['user_registrations']++;
		}
		$invitation_count[$invitation_data[$i]['invite_user_id']]['user_invitations']++;
	}

	// Add the number of invitations sent
	foreach ($invitation_count as $user_id => $user_count_ary)
	{
		// Check whether the database fields in users table are already filled
		$sql = 'SELECT user_invitations, user_registrations
			FROM ' . USERS_TABLE . "
			WHERE user_id = $user_id";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$existing['user_invitations'] = $row['user_invitations'];
			$existing['user_registrations'] = $row['user_registrations'];
		}
		$db->sql_freeresult($result);

		// Go on with next user if the invitation log table had been edited manually
		if ((($user_count_ary['user_invitations'] - $existing['user_invitations']) < 0) || $increase['user_registrations'] < 0)
		{
			continue;
		}
		else
		{
			$sql_ary	= array(
				'user_invitations'		=> $user_count_ary['user_invitations'],
				'user_registrations'	=> $user_count_ary['user_registrations'],
			);

			$sql = 'UPDATE ' . USERS_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
				WHERE user_id = $user_id";
			$result = $db->sql_query($sql);
		}
	}
}

/*
* Here is our custom function that will be called in order to import existing invitation data for use of referral features added in 0.7.0
* Requires the invitation related database fields in the users table to be set
*
* Depending on the amount of existing data calling this function will run a lot of queries... be warned!
*/
function import_invitation_referral_data()
{
	global $db, $umil;

	// Array to be filled with the existing invitation data
	$invitation_data = array();

	// Array to be filled with the number of existing invitations for each user
	$invitation_count = array();

	// Grab data within the invitation table from previous versions
	$sql 	= 'SELECT *
		FROM ' . INVITE_LOG_TABLE;
	$result	= $db->sql_query($sql);
	$invitation_data = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	// Requires the invitation related database fields in the users table to be set
	for ($i = 0, $size = sizeof($invitation_data); $i < $size; $i++)
	{
		// Initialise the invitation count when running for the first time
		if (!isset($invitation_count[$invitation_data[$i]['invite_user_id']]['user_invitations']))
		{
			$invitation_count[$invitation_data[$i]['invite_user_id']]['user_invitations'] = 0;
			$invitation_count[$invitation_data[$i]['invite_user_id']]['user_registrations'] = 0;
		}

		// Add referral data and associate the invited user with the one who invited him
		if ($invitation_data[$i]['register_user_id'] && $invitation_data[$i]['register_key_used'])
		{
			$sql 	= 'SELECT username_clean
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . $invitation_data[$i]['invite_user_id'];
			$result = $db->sql_query($sql);
			$invite_username = $db->sql_fetchfield('username_clean');
			$db->sql_freeresult($result);

			$sql_ary	= array(
				'user_inviter_id'	=> (int) $invitation_data[$i]['invite_user_id'],
				'user_inviter_name'	=> $invite_username,
			);

			$sql = 'UPDATE ' . USERS_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE user_id = ' . (int) $invitation_data[$i]['register_user_id'];
			$result = $db->sql_query($sql);

			$invitation_count[$invitation_data[$i]['invite_user_id']]['user_registrations']++;
		}
		$invitation_count[$invitation_data[$i]['invite_user_id']]['user_invitations']++;
	}

	// Add the number of invitations sent
	foreach ($invitation_count as $user_id => $user_count_ary)
	{
		// Check whether the database fields in users table are already filled
		$sql = 'SELECT user_invitations, user_registrations
			FROM ' . USERS_TABLE . "
			WHERE user_id = $user_id";
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$existing['user_invitations'] = $row['user_invitations'];
			$existing['user_registrations'] = $row['user_registrations'];
		}
		$db->sql_freeresult($result);

		// Go on with next user if the invitation log table had been edited manually
		if ((($user_count_ary['user_invitations'] - $existing['user_invitations']) < 0) || $increase['user_registrations'] < 0)
		{
			continue;
		}
		else
		{
			$sql_ary	= array(
				'user_invitations'		=> $user_count_ary['user_invitations'],
				'user_registrations'	=> $user_count_ary['user_registrations'],
			);

			$sql = 'UPDATE ' . USERS_TABLE . '
				SET ' . $db->sql_build_array('UPDATE', $sql_ary) . "
				WHERE user_id = $user_id";
			$result = $db->sql_query($sql);
		}
	}
}

/*
* Here is our custom function that will be called for version 0.6.0
*
* @param string $action The action (install|update|uninstall) will be sent through this.
* @param string $version The version this is being run for will be sent through this.
*/
function insert_data_060($action, $version)
{
	global $db, $table_prefix, $umil, $config, $version_config_name, $transfer_invitation_data;

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
					$umil->module_remove(array(
						array('acp', 'ACP_INVITE', 'ACP_INVITE'),
						array('acp', false, 'ACP_INVITE_LOG'),
						array('acp', false, 'ACP_INVITE'),
						array('ucp', false, 'UCP_INVITE_INVITE'),
						array('ucp', false, 'UCP_INVITE'),
					));

					// Add the new modules
					$umil->module_add(array(
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
					));
				}
			}

			// Transfer existing invitation data if wished
			if ($transfer_invitation_data)
			{
				transfer_invitation_data();

				// Send a message that the command was successful
				return 'Transferring invitation data';
			}

			// Send a message that the command was successful
			return 'Populating database tables';
		break;

 		case 'uninstall' :
		break;
	}
}

/*
* Here is our custom function that will be called for version 0.6.1
*
* @param string $action The action (install|update|uninstall) will be sent through this.
* @param string $version The version this is being run for will be sent through this.
*/
function insert_data_061($action, $version)
{
	global $db, $table_prefix, $transfer_invitation_data;

	switch ($action)
	{
		case 'install' :
		case 'update' :
			// Allow NULL
			$db->sql_query('ALTER TABLE ' . $table_prefix . 'users CHANGE user_inviter_name user_inviter_name VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NULL');

			// Send a message that the command was successful
			return 'Altering database tables';
		break;

 		case 'uninstall' :
		break;
	}
}

/*
* Here is our custom function that will be called for version 0.7.0
*
* @param string $action The action (install|update|uninstall) will be sent through this.
* @param string $version The version this is being run for will be sent through this.
*/
function insert_data_070($action, $version)
{
	global $db, $table_prefix, $umil, $config, $version_config_name, $transfer_invitation_data;

	switch ($action)
	{
		case 'install' :
		case 'update' :
			if ($umil->table_exists($table_prefix . 'invite_config'))
			{
				// Config has changed so much this version.. truncate!
				$db->sql_query('TRUNCATE TABLE ' . $table_prefix . 'invite_config');

				// Now that's a lot of config...
				$phpbb_invite_config = array(
					array('config_name'=>'advanced_statistics','config_value'=>'1'),
					array('config_name'=>'autohide_valid_key','config_value'=>'1'),
					array('config_name'=>'cash_id_invite','config_value'=>'1'),
					array('config_name'=>'cash_id_register','config_value'=>'1'),
					array('config_name'=>'cash_invite','config_value'=>'10'),
					array('config_name'=>'cash_register','config_value'=>'20'),
					array('config_name'=>'confirm','config_value'=>'2'),
					array('config_name'=>'confirm_method','config_value'=>'2'),
					array('config_name'=>'display_m_invite','config_value'=>'1'),
					array('config_name'=>'display_m_inviter','config_value'=>'0'),
					array('config_name'=>'display_m_referrals','config_value'=>'1'),
					array('config_name'=>'display_m_referrer','config_value'=>'1'),
					array('config_name'=>'display_m_register','config_value'=>'0'),
					array('config_name'=>'display_navigation_left','config_value'=>'1'),
					array('config_name'=>'display_navigation_right','config_value'=>'1'),
					array('config_name'=>'display_p_invite','config_value'=>'1'),
					array('config_name'=>'display_p_inviter','config_value'=>'0'),
					array('config_name'=>'display_p_referral_link','config_value'=>'1'),
					array('config_name'=>'display_p_referrals','config_value'=>'1'),
					array('config_name'=>'display_p_referrer','config_value'=>'1'),
					array('config_name'=>'display_p_register','config_value'=>'0'),
					array('config_name'=>'display_registration','config_value'=>'1'),
					array('config_name'=>'display_t_invite','config_value'=>'1'),
					array('config_name'=>'display_t_inviter','config_value'=>'0'),
					array('config_name'=>'display_t_referrals','config_value'=>'1'),
					array('config_name'=>'display_t_referrer','config_value'=>'1'),
					array('config_name'=>'display_t_register','config_value'=>'0'),
					array('config_name'=>'enable','config_value'=>'1'),
					array('config_name'=>'enable_cash','config_value'=>'0'),
					array('config_name'=>'enable_email_identification','config_value'=>'1'),
					array('config_name'=>'enable_invitation','config_value'=>'1'),
					array('config_name'=>'enable_invite_group','config_value'=>'0'),
					array('config_name'=>'enable_key','config_value'=>'0'),
					array('config_name'=>'enable_limit_daily','config_value'=>'0'),
					array('config_name'=>'enable_limit_total','config_value'=>'0'),
					array('config_name'=>'enable_powered_by','config_value'=>'1'),
					array('config_name'=>'enable_referral','config_value'=>'1'),
					array('config_name'=>'enable_ultimate_points','config_value'=>'0'),
					array('config_name'=>'enable_unlimited','config_value'=>'1'),
					array('config_name'=>'invite_confirm_code','config_value'=>'1'),
					array('config_name'=>'invite_expiration_time','config_value'=>'30'),
					array('config_name'=>'invite_language_select','config_value'=>'user'),
					array('config_name'=>'invite_multiple','config_value'=>'1'),
					array('config_name'=>'invite_priority_flag','config_value'=>'3'),
					array('config_name'=>'invite_require_activation','config_value'=>'3'),
					array('config_name'=>'invite_required_posts','config_value'=>'0'),
					array('config_name'=>'invite_search_allowed','config_value'=>'1'),
					array('config_name'=>'key_group','config_value'=>'2'),
					array('config_name'=>'key_group_default','config_value'=>'1'),
					array('config_name'=>'limit_daily_basic','config_value'=>'5'),
					array('config_name'=>'limit_daily_memberdays','config_value'=>'100'),
					array('config_name'=>'limit_daily_memberdays_invitations','config_value'=>'1'),
					array('config_name'=>'limit_daily_posts','config_value'=>'200'),
					array('config_name'=>'limit_daily_posts_invitations','config_value'=>'1'),
					array('config_name'=>'limit_daily_referrals','config_value'=>'10'),
					array('config_name'=>'limit_daily_referrals_invitations','config_value'=>'1'),
					array('config_name'=>'limit_daily_registrations','config_value'=>'10'),
					array('config_name'=>'limit_daily_registrations_invitations','config_value'=>'1'),
					array('config_name'=>'limit_daily_topics','config_value'=>'10'),
					array('config_name'=>'limit_daily_topics_invitations','config_value'=>'1'),
					array('config_name'=>'limit_total_basic','config_value'=>'10'),
					array('config_name'=>'limit_total_memberdays','config_value'=>'100'),
					array('config_name'=>'limit_total_memberdays_invitations','config_value'=>'10'),
					array('config_name'=>'limit_total_posts','config_value'=>'200'),
					array('config_name'=>'limit_total_posts_invitations','config_value'=>'5'),
					array('config_name'=>'limit_total_referrals','config_value'=>'5'),
					array('config_name'=>'limit_total_referrals_invitations','config_value'=>'1'),
					array('config_name'=>'limit_total_registrations','config_value'=>'2'),
					array('config_name'=>'limit_total_registrations_invitations','config_value'=>'1'),
					array('config_name'=>'limit_total_topics','config_value'=>'10'),
					array('config_name'=>'limit_total_topics_invitations','config_value'=>'2'),
					array('config_name'=>'message_max_chars','config_value'=>'1000'),
					array('config_name'=>'message_min_chars','config_value'=>'1'),
					array('config_name'=>'multiple_recipients_max','config_value'=>'3'),
					array('config_name'=>'num_invitations','config_value'=>'0'),
					array('config_name'=>'num_referrals','config_value'=>'0'),
					array('config_name'=>'num_registrations','config_value'=>'0'),
					array('config_name'=>'prevent_abuse','config_value'=>'1'),
					array('config_name'=>'queue_time','config_value'=>'300'),
					array('config_name'=>'referral_as','config_value'=>'1'),
					array('config_name'=>'referral_as_limit','config_value'=>'20'),
					array('config_name'=>'referral_autodisable','config_value'=>'1'),
					array('config_name'=>'referral_autohide','config_value'=>'0'),
					array('config_name'=>'referral_confirmation','config_value'=>'1'),
					array('config_name'=>'referral_confirmation_duplicate','config_value'=>'0'),
					array('config_name'=>'referral_confirmation_method','config_value'=>'1'),
					array('config_name'=>'referral_cookie','config_value'=>'1'),
					array('config_name'=>'referral_friends','config_value'=>'1'),
					array('config_name'=>'referral_invitation_bridge','config_value'=>'1'),
					array('config_name'=>'referral_require','config_value'=>'0'),
					array('config_name'=>'referral_search_allowed','config_value'=>'1'),
					array('config_name'=>'referral_statistics','config_value'=>'1'),
					array('config_name'=>'remove_newly_registered','config_value'=>'0'),
					array('config_name'=>'set_cookie','config_value'=>'1'),
					array('config_name'=>'subject_max_chars','config_value'=>'50'),
					array('config_name'=>'subject_min_chars','config_value'=>'1'),
					array('config_name'=>'tracking_time','config_value'=>'1344131366'),
					array('config_name'=>'ultimate_points_invite','config_value'=>'5'),
					array('config_name'=>'ultimate_points_register','config_value'=>'20'),
					array('config_name'=>'version','config_value'=>'0.6.1'),
					array('config_name'=>'zebra','config_value'=>'2')
				);

				$sql_ary = array();

				for ($i = 0; $i < sizeof($phpbb_invite_config); $i++)
				{
					$sql_ary[] = array('config_name' => $phpbb_invite_config[$i]['config_name'], 'config_value' => $phpbb_invite_config[$i]['config_value']);
				}

				$db->sql_multi_insert($table_prefix . 'invite_config ', $sql_ary);
			}

			return 'Added new config';
		break;

 		case 'uninstall' :
		break;
	}
}
?>