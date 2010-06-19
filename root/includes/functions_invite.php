<?php
/** 
* @author Bycoja bycoja@web.de
*
* @package phpBB3
* @version $Id: functions_invite.php 5.0.1 2009-04-12 22:35:59GMT Bycoja $
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

define('REGISTER_KEY_DISABLED',		'key_disabled');
define('REGISTER_KEY_CHARSET',		'abcdefghijkmnpqrstuvwxyz123456789ABCDEFGHIJKLMNPQRSTUVWXYZ');
define('REGISTER_KEY_MIN_CHARS',	12);
define('REGISTER_KEY_MAX_CHARS',	18);
define('LOG_ENTRIES_PER_PAGE', 	20);
define('EMAIL', 	0);
define('PM', 		1);
define('OPTIONAL', 	2);

$INVITE_MESSAGE_TYPE = array(
	'invite'	=> 0,
	'confirm'	=> 1,
);

/**
* Class invite
*/              
class invite
{
	var $config;
	var $message;
	var $invite_user;
	var $register_user;
	
	var $INVITE_MESSAGE_TYPE = array(
			'invite'	=> 0,
			'confirm'	=> 1,
		);

	/**
	* function invite
	 */
	function invite()
	{
		global $db;
		
		// If the module hasn't been added yet, the database tables don't exist
		$sql = 'SELECT *
			FROM ' . MODULES_TABLE . "
			WHERE module_langname = 'ACP_INVITE'
				AND module_class = 'acp'";
		$result = $db->sql_query($sql);
		$row 	= $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if (!$row)
		{
			return;
		}
		
		$this->get_config();
	}
	
	/**
	* function get_config
	 */
	function get_config()
	{
		global $db;
		
		//$sql 	= '(SELECT config_name, config_value FROM ' . INVITE_CONFIG_TABLE . ') UNION (SELECT config_name, config_value FROM ' . INVITE_CONFIG_PLUGINS_TABLE . ')';
		$sql 	= 'SELECT config_name, config_value FROM ' . INVITE_CONFIG_TABLE;
		$result	= $db->sql_query($sql);
		
		while ($row = $db->sql_fetchrow($result))
		{
			$this->config[$row['config_name']] = $row['config_value'];
		}
		$db->sql_freeresult($result);
	}
	
	/**
	* function set_config
	*/
	function set_config($key, $value, $message = false)
	{
		global $db;
		
		if ($message)
		{
			foreach ($value as $message_type => $message)
			{
				$sql = 'UPDATE ' . INVITE_MESSAGE_TABLE . '
						SET message = "' . $db->sql_escape($message) . '"
						WHERE language_iso = "' . $db->sql_escape($key) . '" AND message_type = ' . (int) $message_type;
				$db->sql_query($sql);
			}
		}
		else
		{
			$sql = 'UPDATE ' . INVITE_CONFIG_TABLE . '
					SET config_value = "' . $db->sql_escape($value) . '"
					WHERE config_name = "' . $db->sql_escape($key) . '"';
			$db->sql_query($sql);
		}
	}
	
	/**
	* function get_languages
	*/
	function get_languages()
	{
		global $db;
		
		$langs	= array();
		
		$sql 	= 'SELECT lang_iso, lang_dir FROM ' . LANG_TABLE . ' ORDER BY lang_english_name';
		$result = $db->sql_query($sql);
		
		while ($row = $db->sql_fetchrow($result))
		{
			$langs[$row['lang_iso']] = $row['lang_dir'];
		}
		$db->sql_freeresult($result);
		
		return $langs;
	}
	
	/**
	* function load_message
	*/
	function load_message($iso, $message_type, $return = false)
	{
		global $db;
		
		$sql 	= 'SELECT * FROM ' . INVITE_MESSAGE_TABLE . ' WHERE language_iso = "' . $db->sql_escape($iso) . '" AND message_type = ' . (int) $message_type;
		$result = $db->sql_query($sql);
		
		while ($row = $db->sql_fetchrow($result))
		{
			$this->message = $row['message'];
		}
		$db->sql_freeresult($result);
		
		if ($return)
		{
			return $this->message;
		}
	}
	
	/**
	* function set_vars
	*/
	function set_vars($data)
	{
		global $config, $phpEx, $user;
		
		// User vars
		foreach ($this->invite_user as $k => $v)
		{
			$this->vars['INVITE_' . strtoupper($k)] = $v;
		}
		
		if (sizeof($this->register_user))
		{
			foreach ($this->register_user as $k => $v)
			{
				$this->vars['REGISTER_' . strtoupper($k)] = $v;
			}
			
			$this->vars['REGISTER_USER_PROFILE'] = generate_board_url() . '/memberlist.' . $phpEx . '?mode=viewprofile&u=' . $this->register_user['user_id'];
		}
		
		// Config vars
		foreach ($this->config as $k => $v)
		{
			$this->vars['INVITE_CONFIG_' . strtoupper($k)] = $v;
		}
		
		// Additional vars
		$register_key_url				= ($this->config['enable_key']) ? '&key=' . $data['register_key'] : '';
		
		$this->vars['RECIPIENT'] 		= (isset($data['register_real_name'])) ? $data['register_real_name'] : '';
		$this->vars['REGISTER_KEY'] 	= ($this->config['enable_key']) ? $data['register_key'] : $user->lang['REGISTER_KEY_DISABLED'];
		$this->vars['URL_REGISTER_KEY']	= generate_board_url() . '/ucp.' . $phpEx . '?mode=register' . $register_key_url;
		$this->vars['URL_REGISTER']		= $this->vars['URL_REGISTER_KEY'];
	}
	
	/**
	* function message_handle
	*/
	function message_handle($data, $invite_user = false, $register_user = false)
	{
		global $db, $user;
		
		// Set user data
		$user_ary = array(
			'invite'	=> $invite_user,
			'register'	=> $register_user,
		);
		
		foreach ($user_ary as $name => $var)
		{
			if ($var)
			{
				$user_id = $data[$name . '_user_id'];
				
				$sql 	= 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = ' . (int) $user_id;
				$result	= $db->sql_query($sql);
				
				while ($row	= $db->sql_fetchrow($result))
				{
					foreach ($row as $k => $v)
					{
						if ($name == 'invite')
						{
							$this->invite_user[$k] = utf8_normalize_nfc($v);
						}
						if ($name == 'register')
						{
							$this->register_user[$k] = utf8_normalize_nfc($v);
						}
					}
				}
				$db->sql_freeresult($result);
			}
		}
		
		$this->set_vars($data);
		$this->messenger($data, $data['method']);
		
		if (empty($this->register_user))
		{
			$this->log_table($data);
		}
		
		// ACP log
		$user_id_save = $user->data['user_id'];
		
		if ($data['message_type'] == $this->INVITE_MESSAGE_TYPE['invite'])
		{
			$user->data['user_id']	= $this->invite_user['user_id'];
			add_log('invite', 'LOG_INVITE_' . strtoupper(array_search($data['message_type'], $this->INVITE_MESSAGE_TYPE)), $data['register_email']);
			
			$this->give_cash('invite', $this->invite_user['user_id']);
			$this->give_points('invite', $this->invite_user['user_id']);
		}
		else
		{
			$user->data['user_id']	= $this->register_user['user_id'];
			$name_or_email = ($data['method'] == EMAIL) ? $this->invite_user['user_email'] : $this->invite_user['username'];
			add_log('invite', 'LOG_INVITE_' . strtoupper(array_search($data['message_type'], $this->INVITE_MESSAGE_TYPE)), $name_or_email, $this->register_user['username']);
		}
		
		$user->data['user_id'] = $user_id_save;
		
		return true;
	}
	/**
	* function messenger
	*/
	function messenger($data, $method)
	{
		global $config, $user, $phpbb_root_path, $phpEx;
		
		include_once($phpbb_root_path . 'includes/functions_messenger.' . $phpEx);
		include_once($phpbb_root_path . 'includes/functions_privmsgs.' . $phpEx);
		
		$message = htmlspecialchars_decode($this->load_message($data['invite_language'], $data['message_type'], true));
		$subject = htmlspecialchars_decode($data['subject']);
		
		switch($method)
		{
			case EMAIL:
				// Use false so send the email immediately
				$messenger		= new messenger(false);
				$username		= (isset($data['register_real_name'])) ? $data['register_real_name'] : $this->register_user['username'];
				
				// Assign vars
				foreach ($this->vars as $k => $v)
				{
					$messenger->vars[$k] = $v;
				}
				
				$messenger->msg = $message;
				$messenger->to($data['register_email'], $username);
				
				$messenger->headers('X-AntiAbuse: Board servername - ' . $config['server_name']);
				$messenger->headers('X-AntiAbuse: User_id - ' . $data['method_user_id']);
				$messenger->headers('X-AntiAbuse: Username - ' . $this->user_return_data($data['method_user_id'], 'user_id', 'username'));
				$messenger->headers('X-AntiAbuse: User IP - ' . $this->user_return_data($data['method_user_id'], 'user_id', 'user_ip'));
				
				$messenger->subject($subject);
				$messenger->set_mail_priority(MAIL_NORMAL_PRIORITY);
				
				$messenger->assign_vars(array(
					'CONTACT_EMAIL' => $config['board_contact'],
					'MESSAGE'		=> (empty($data['message'])) ? '' : htmlspecialchars_decode($data['message']),
				));
				
				$messenger->send();
				$messenger->save_queue();
			break;
			
			case PM:
				// We can use invite_user_id here, because we are just going to send confirmations
				$address_list 	= array();
				$address_list['u'][$data['invite_user_id']] = 'to';
				
				// Replace all placeholders
				foreach ($this->vars as $replace => $value)
				{
					$message	= str_replace('{' . $replace . '}', $value, $message);
				}
				
				$pm_data = array(
						'from_user_id'			=> $this->register_user['user_id'],
						'from_user_ip'			=> $this->register_user['user_ip'],
						'from_username'			=> $this->register_user['username'],
						'icon_id'				=> 0,
						'enable_sig'			=> true,
						'enable_bbcode'			=> false,
						'enable_smilies'		=> false,
						'enable_urls'			=> false,
						'bbcode_bitfield'		=> '',
						'bbcode_uid'			=> '',
						'message'				=> $message,
						'attachment_data'		=> '',
						'filename_data'			=> '',
						'address_list'			=> $address_list,
				);
				
				submit_pm('post', $subject, $pm_data);
			break;
		}
	}
	
	/**
	* function log_table
	*/
	function log_table($data)
	{
		global $db;
		
		$sql_ary = array(
			'invite_user_id'		=> $data['invite_user_id'],
			'register_user_id'		=> $data['register_user_id'],
			'register_email'		=> $data['register_email'],
			'invite_confirm'		=> (!$this->config['confirm']) ? 0 : (($this->config['confirm'] == 1) ? 1 : $data['invite_confirm']),
			'invite_confirm_method'	=> ($this->config['confirm_method'] == EMAIL) ? EMAIL : (($this->config['confirm_method'] == PM) ? PM : $data['invite_confirm_method']),
			'register_key_used'		=> $data['register_key_used'],
			'register_key'			=> $data['register_key'],
			'invite_session_ip'		=> $data['invite_session_ip'],
			'invite_time'			=> $data['invite_time'],
			'invite_zebra'			=> (!$this->config['zebra']) ? 0 : (($this->config['zebra'] == 1) ? 1 : $data['invite_zebra']),
		);
		
		$sql = 'INSERT INTO ' . INVITE_LOG_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
		$db->sql_query($sql);
	}
	
	/**
	* function user_return_data
	*/
	function user_return_data($data, $given = 'username_clean', $return = 'user_id')
	{
		global $db;
		
		$user_return_data	= array();
		
		if ($data)
		{
			$sql	= 'SELECT * FROM ' . USERS_TABLE . " WHERE $given = '" . $db->sql_escape($data) . "'";
			$result = $db->sql_query($sql);
				
			while ($row = $db->sql_fetchrow($result))
			{
				foreach ($row as $k => $v)
				{
					$user_return_data[$k] = utf8_normalize_nfc($v);
				}
			}
			$db->sql_freeresult($result);
			
			if (sizeof($user_return_data))
			{
				return $user_return_data[$return];
			}
			else
			{
				return false;
			}
		}
	}
	
	/**
	* function create_key
	*/
	function create_key()
	{
		mt_srand(crc32(microtime()));
		$charset 	= REGISTER_KEY_CHARSET;
		$disabled	= REGISTER_KEY_DISABLED;
		$lenght		= rand(REGISTER_KEY_MIN_CHARS, REGISTER_KEY_MAX_CHARS);
		
		$str_lng 	= strlen($charset) - 1;
		$rand		= '';
		
		for($i = 0; $i < $lenght; $i++)   
		{
			$rand .= $charset{mt_rand(0, $str_lng)};
		}
		
		// It is highly unlikely this will happen, but still possible
		if ($rand == $disabled)
		{
			$rand		= '';
			$charset	= str_replace($disabled{0}, '', $charset);
			
			for($i = 0; $i < $lenght; $i++)   
			{
				$rand .= $charset{mt_rand(0, $str_lng)};
			}
		}
		
		// If keys are disabled we still create a key
		if (!$this->config['enable_key'])
		{
			$rand = $disabled;
		}
		
		return $rand; 
	}
	
	/**
	* function invite_yourself
	*/
	function invite_yourself($key)
	{
		global $user, $db;
		
		// Just check if wished
		if ($this->config['invite_yourself'] || ($this->config['enable_key'] == 2 && empty($key)))
		{
			return false;
		}
		
		$sql 			= 'SELECT COUNT(log_id) AS invitations FROM ' . INVITE_LOG_TABLE . " WHERE invite_session_ip = '" . $db->sql_escape($user->data['session_ip']) . "'";
		$result 		= $db->sql_query($sql);
		$invitations	= $db->sql_fetchfield('invitations');
		
		if ($invitations > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	* function valid_key
	*/
	function valid_key($key, $key_used = true)
	{
		global $db;
		
		// $key == AUTH_KEY_DISABLED is important to check!
		// Otherwise someone could enter 'key_disabled', which is default value for REGISTER_KEY_DISABLED!
		if ($key == REGISTER_KEY_DISABLED)
		{
			return false;
		}
		
		// Optional registration-key?
		if (empty($key) && $this->config['enable_key'] == 1)
		{
			return false;
		}
		if (empty($key) && $this->config['enable_key'] == 2)
		{
			return true;
		}
		
		$sql_add	= ($key_used) ? ' AND register_key_used = 0' : '';
		
		$sql 		= 'SELECT COUNT(log_id) AS valid FROM ' . INVITE_LOG_TABLE . " WHERE register_key = '" . $db->sql_escape($key) . "'$sql_add";
		$result 	= $db->sql_query($sql);
		$valid		= $db->sql_fetchfield('valid');
		
		return $valid;
	}
	
	/**
	* function register_user
	*/
	function register_user($key, $register_user_id)
	{
		global $db, $user;
		
		// Update the referring log entry
		$sql_ary	= array(
			'register_key_used'	=> 1,
			'register_user_id'	=> (int) $register_user_id,
		);
		
		if (empty($key) && $this->config['enable_key'] == 2)
		{
			return;
		}
		
		$sql 		= 'UPDATE ' . INVITE_LOG_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . " WHERE register_key = '" . $db->sql_escape($key) . "'";
		$result 	= $db->sql_query($sql);
		
		// Which invitation do we talk about?
		$sql 		= 'SELECT * FROM ' . INVITE_LOG_TABLE . ' WHERE register_user_id = ' . (int) $register_user_id;
		$result		= $db->sql_query($sql);
		
		while ($row	= $db->sql_fetchrow($result))
		{
			foreach ($row as $k => $v)
			{
				$invitation_data[$k] = utf8_normalize_nfc($v);
			}
		}
		$db->sql_freeresult($result);
		
		// Send confirmation
		if ($invitation_data['invite_confirm'])
		{
			$confirm_data 					= $invitation_data;
			$confirm_data['register_email'] = $this->user_return_data($invitation_data['invite_user_id'], 'user_id', 'user_email');
			$confirm_data['message_type'] 	= $this->INVITE_MESSAGE_TYPE['confirm'];
			$confirm_data['method'] 		= (empty($confirm_data['register_email'])) ? PM : $invitation_data['invite_confirm_method'];
			$confirm_data['method_user_id'] = $register_user_id;
			$confirm_data['invite_language']= $this->user_return_data($invitation_data['invite_user_id'], 'user_id', 'user_lang');
			$confirm_data['subject']		= $user->lang['INVITE_CONFIRM'];
			
			$this->message_handle($confirm_data, true, true);
		}
		
		$save_user_id = $user->data['user_id'];
		
		// Add friend
		if ($invitation_data['invite_zebra'])
		{
			$zebra_data	= array();
			
			$zebra_data[]	= array(
				'user_id'	=> (int) $this->invite_user['user_id'],
				'zebra_id'	=> (int) $this->register_user['user_id'],
				'friend'	=> 1,
				'foe'		=> 0,
			);
			$zebra_data[]	= array(
				'user_id'	=> (int) $this->register_user['user_id'],
				'zebra_id'	=> (int) $this->invite_user['user_id'],
				'friend'	=> 1,
				'foe'		=> 0,
			);
			
			for ($i = 0, $size = sizeof($zebra_data); $i < $size; $i++)
			{
				$user->data['user_id']	= $zebra_data[$i]['zebra_id'];
				$db->sql_query('INSERT INTO ' . ZEBRA_TABLE . $db->sql_build_array('INSERT', $zebra_data[$i]));
				add_log('invite', 'LOG_INVITE_ZEBRA', $this->user_return_data($zebra_data[$i]['user_id'], 'user_id', 'username'), $this->user_return_data($zebra_data[$i]['zebra_id'], 'user_id', 'username'));
			}
		}
		
		$user->data['user_id']	= $register_user_id;
		add_log('invite', 'LOG_INVITE_REGISTER', $this->register_user['username']);
		$user->data['user_id'] = $save_user_id;
		
		$this->give_cash('register', $this->invite_user['user_id']);
		$this->give_points('register', $this->invite_user['user_id']);
	}
	
	/**
	* function get_profile_info
	*/
	function get_profile_info($log_id, $mode = 'log', $user_id = '')
	{
		global $db, $phpbb_admin_path, $phpbb_root_path, $phpEx;
		
		$profile_url 	= (defined('IN_ADMIN')) ? append_sid("{$phpbb_admin_path}index.$phpEx", 'i=users&amp;mode=overview') : append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile');
		$new_users		= array();
		
		if ($mode == 'log')
		{
			$sql = "SELECT l.*, u.username, u.username_clean, u.user_colour
			FROM " . LOG_TABLE . " l, " . USERS_TABLE . " u
			WHERE l.log_id = " . (int) $log_id . "
				AND u.user_id = l.user_id";
		}
		else
		{
			$sql = 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = ' . (int) $user_id;
		}
		$result = $db->sql_query($sql);
		
		while ($row = $db->sql_fetchrow($result))
		{
			$data = array(
				'user_id'			=> $row['user_id'],
				'username'			=> $row['username'],
				'username_full'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour'], false, $profile_url),
			);
		}
		$db->sql_freeresult($result);
		
		// Invitations sent
		$sql	= 'SELECT COUNT(log_id) as invitations FROM ' . INVITE_LOG_TABLE . ' WHERE invite_user_id = ' . (int) $data['user_id'];
		$result = $db->sql_query($sql);
		
		$data['invitations']	= $db->sql_fetchfield('invitations');
		$db->sql_freeresult($result);
		
		// Total registrations
		$sql	= 'SELECT COUNT(log_id) as registrations FROM ' . INVITE_LOG_TABLE . ' WHERE invite_user_id = ' . (int) $data['user_id'] . ' AND register_key_used = 1';
		$result = $db->sql_query($sql);
		
		$data['registrations']	= $db->sql_fetchfield('registrations');
		$db->sql_freeresult($result);
		
		// Get all invitations sent by our current user
		$sql 			= 'SELECT * FROM ' . INVITE_LOG_TABLE . ' WHERE invite_user_id = ' . (int) $data['user_id'] . ' AND register_key_used = 1';
		$result 		= $db->sql_query($sql);
		
		while ($row = $db->sql_fetchrow($result))
		{
			foreach ($row as $k => $v)
			{
				$invitations_row[$k] = utf8_normalize_nfc($v);
			}
			
			// Fix: Undefined variable
			if ($invitations_row['register_user_id'])
			{
				// Get information on all new users, who were invited by our current user
				$sql2			= 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = ' . (int) $invitations_row['register_user_id'];
				$result2 		= $db->sql_query($sql2);
					
				while ($row2 = $db->sql_fetchrow($result2))
				{
					foreach ($row2 as $k2 => $v2)
					{
						$register_user_row[$k2] = utf8_normalize_nfc($v2);
					}
				}
				$db->sql_freeresult($result2);
				
				// Add them to an array so we can use implode() later
				$new_users[] = get_username_string('full', $register_user_row['user_id'], $register_user_row['username'], $register_user_row['user_colour'], false, $profile_url);
			}
		}
		$db->sql_freeresult($result);
		
		$data['reg_users']	= implode(', ', $new_users);
		
		return $data;
	}
	
	/**
	* function profile_fields
	*/
	function profile_fields($postrow, $poster_id)
	{
		global $template, $user;
		
		$user->add_lang('mods/info_acp_invite');
		$info = $this->get_profile_info('', 'profile', $poster_id);
		
		$invite_row = array(
			'POSTER_INVITE_INVITE'		=> $info['invitations'],
			'POSTER_INVITE_REGISTER'	=> $info['registrations'],
			'POSTER_INVITE_NAME'		=> $info['reg_users'],
		);
		
		$template->assign_vars(array(
			'S_T_DISPLAY_INVITE'	=> $this->config['display_t_invite'],
			'S_T_DISPLAY_REGISTER'	=> $this->config['display_t_register'],
			'S_T_DISPLAY_NAME'		=> $this->config['display_t_name'],
			'S_P_DISPLAY_INVITE'	=> $this->config['display_p_invite'],
			'S_P_DISPLAY_REGISTER'	=> $this->config['display_p_register'],
			'S_P_DISPLAY_NAME'		=> $this->config['display_p_name'],
		));
		
		$postrow = array_merge($invite_row, $postrow);
		
		return $postrow;
	}
	
	/**
	* function header_template
	*/
	function header_template()
	{
		global $user, $auth, $template, $phpbb_root_path, $phpEx;
		
		if (!$this->config['display_navigation'])
		{
			return;
		}
		$user->add_lang('mods/info_acp_invite');
		
		$template->assign_vars(array(
			'U_INVITE_A_FRIEND'		=> append_sid("{$phpbb_root_path}ucp.$phpEx", 'i=invite&amp;mode=invite'),
			'S_DISPLAY_INVITE'		=> (!$this->config['enable']) ? false : (($auth->acl_get('u_send_invite')) ? true : false),
		));
	}
	
	/** ################
	* ##### PLUGINS######
	*/#################
	
	/**
	* function cash_installed
	*/
	function cash_installed()
	{
		global $phpbb_root_path, $phpEx;
		
		$check_file = $phpbb_root_path . 'includes/mods/cash/cash_class.' . $phpEx;
		
		if (file_exists($check_file))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	* function give_cash
	*/
	function give_cash($mode, $user_id)
	{
		//
		
		if ($this->cash_installed() && $this->config['enable_cash'])
		{
			global $cash;
			
			if ($mode == 'invite')
			{
				$cash->give_cash($user_id, $this->config['cash_invite'], $this->config['cash_id_invite']);
			}
			else
			{
				// $mode = 'register'
				$cash->give_cash($user_id, $this->config['cash_register'], $this->config['cash_id_register']);
			}
		}
	}
	
	/**
	* function get_currency_name
	*/
	function get_currency_name($cash_id)
	{
		global $db;
		
		if ($this->cash_installed())
		{
			global $cash;
			
			$sql	= 'SELECT * FROM ' . CASH_TABLE . ' WHERE cash_id = ' . (int) $cash_id;
			$result = $db->sql_query($sql);
				
			while ($row = $db->sql_fetchrow($result))
			{
				$return	= $row['cash_name'];
			}
			$db->sql_freeresult($result);
			
			return $return;
		}
	}
	
	/**
	* function points_installed
	*/
	function points_installed()
	{
		global $phpbb_root_path, $phpEx;
		
		$check_file = $phpbb_root_path . 'includes/points/functions_points.' . $phpEx;
		
		if (file_exists($check_file))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	* function give_points
	*/
	function give_points($mode, $user_id)
	{
		global $db;
		
		if ($this->points_installed() && $this->config['enable_points'])
		{
			$add_points	= ($mode == 'invite') ? $this->config['points_invite'] : $this->config['points_register'];
			
			$sql = 'UPDATE ' . USERS_TABLE . ' SET ' . USER_POINTS . ' = ' . USER_POINTS . ' + ' . (int) $add_points . " WHERE user_id = '" . (int) $user_id . "'";
			$db->sql_query($sql);
		}
	}
	
	/**
	* function get_points_name
	*/
	function get_points_name()
	{
		global $db;
		
		if ($this->points_installed() && $this->config['enable_points'])
		{
			$sql 		= 'SELECT * FROM ' . POINTS_CONFIG_TABLE;
			$result 	= $db->sql_query($sql);
			$points_row = $db->sql_fetchrow($result);
			$db->sql_freeresult($result);
			
			return $points_row['points_name'];
		}
	}
}
?>