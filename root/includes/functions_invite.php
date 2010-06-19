<?php
/**
*
* @package phpBB3
* @version $Id: functions_invite.php 8645 2008-10-03 10:40:17Z Bycoja $
* @copyright (c) 2008 Bycoja
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
* Default constants
*/
define('AUTH_KEY_DISABLED',		'key_disabled');
define('LOG_ENTRIES_PER_PAGE',	20);

/**
* Class invite
* Send emails, create keys ...
*/              
class invite
{
	var $config;
	var $from;
	var $new_user;
	var $vars;
	
	// Contains the message stored in ./language/.../email/invite.txt
	var $message;
	
	// Contains the message stored in ./language/.../email/invite_confirm.txt
	var $confirm_message;
	
	/**
	* Constructor
	 */
	function invite()
	{
		global $db, $user;
		
		// $this->config
		
		$sql 	= 'SELECT * FROM ' . INVITE_CONFIG_TABLE . ' WHERE config_id = 1';
		$result	= $db->sql_query($sql);
		
		while ($row	= $db->sql_fetchrow($result))
		{
			foreach ($row as $k => $v)
			{
				$this->config[$k] = utf8_normalize_nfc(request_var($k, $v, true));
			}
		}
		
		$db->sql_freeresult($result);
	
		// $this->message
		
		$this->message_file($user->data['user_lang'], 'invite');
		
		// $this->confirm_message
		
		$this->message_file($user->data['user_lang'], 'invite_confirm');
	}
	
	/**
	* function message_file
	* Read and update the messages stored in ./language/.../email/...
	*/
	function message_file($template_lang, $template_file, $mode = 'read', $new_message = '')
	{
		global $phpEx, $phpbb_root_path, $user;
		
		if ($template_file == 'invite')
		{
			$tpl_file = "{$phpbb_root_path}language/$template_lang/email/invite.txt";
		}
		else
		{
			$tpl_file = "{$phpbb_root_path}language/$template_lang/email/invite_confirm.txt";
		}
		
		if ($mode == 'read')
		{
			if (($data = @file_get_contents($tpl_file)) === false)
			{
				trigger_error("Failed opening template file [ $tpl_file ]", E_USER_ERROR);
			}
			
			if ($template_file == 'invite')
			{
				$this->message = $data;
			}
			else
			{
				$this->confirm_message = $data;
			}
		}
		
		if ($mode == 'update')
		{
			$file = fopen($tpl_file, "w+");
			
			rewind($file);
			fwrite($file, $new_message);
			fclose($file);
		}
	}
	
	/**
	* function set_config
	* Update the iaf_config-table
	*/
	function set_config($key, $value)
	{
		global $db;

		$sql = 'UPDATE ' . INVITE_CONFIG_TABLE . "
				SET " . $key . " = '" . $db->sql_escape($value) . "'
				WHERE config_id = 1";
		$db->sql_query($sql);
	}
	
	/**
	* function send_email
	* Send the email to a friend
	*/
	function send_email($data)
	{
		global $phpEx, $phpbb_root_path, $config, $user;
		include_once($phpbb_root_path . 'includes/functions_messenger.' . $phpEx);
		
		// Use false so send the email immediately
		$use_queue	= ($this->config['send_now']) ? false : true;
		$messenger	= new messenger($use_queue);
		
		// Get some information about the sender and set vars
		$this->get_sender($data['from']);
		$this->set_vars($data);
		
		foreach ($this->vars as $k => $v)
		{
			$messenger->vars[$k] = utf8_normalize_nfc(request_var($k, $v, true));
		}
		
		$messenger->to($data['email'], $data['name']);
		$messenger->template('invite', $data['lang']);

		$messenger->headers('X-AntiAbuse: Board servername - ' . $config['server_name']);
		$messenger->headers('X-AntiAbuse: User_id - ' . $user->data['user_id']);
		$messenger->headers('X-AntiAbuse: Username - ' . $user->data['username']);
		$messenger->headers('X-AntiAbuse: User IP - ' . $user->ip);

		$messenger->subject(htmlspecialchars_decode($data['subject']));
		$messenger->set_mail_priority(MAIL_NORMAL_PRIORITY);

		$messenger->assign_vars(array(
			'CONTACT_EMAIL' => $config['board_contact'],
			'MESSAGE'		=> htmlspecialchars_decode($data['message']))
		);
		
		$messenger->send();
		$messenger->save_queue();
		
		// Create an entry for the key in database
		// If keys are disabled we still create an entry,
		// so we can use INVITE_KEYS_TABLE as log
		$this->insert_key($data);
		
		// Cash mod
		$this->give_cash('invitation', $data['from']);
		
		// Add log entry
		add_log('invite', 'LOG_INVITE_EMAIL', $data['email']);
		
		if ($this->cash_installed() && $this->config['cash_enable'])
		{
			add_log('invite', 'LOG_CASH_INVITATION', $data['email'], $this->config['cash_invitation'], $this->get_currency_name($this->config['cash_id_invitation']));
		}
		
		return true;
	}
	
	/**
	* function send_confirm
	* Send confirmation that invitited user has registered
	*/
	function send_confirm($key, $new_user_id)
	{
		global $phpEx, $phpbb_root_path, $config, $user, $db;
		include_once($phpbb_root_path . 'includes/functions_messenger.' . $phpEx);
		
		// Use false so send the email immediately
		$use_queue	= ($this->config['send_now']) ? false : true;
		$messenger	= new messenger($use_queue);
		
		// Get some information about the new user and set vars
		$this->get_new_user($new_user_id);
		
		// Fix: [phpBB Debug] PHP Notice: in file /includes/functions_invite.php on line 209: Undefined variable: invitation_data
		if ($this->config['auth_key'] == 2 && empty($key))
		{
			return false;
		}
		
		// Which invitation do we talk about?
		$sql 	= 'SELECT * FROM ' . INVITE_KEYS_TABLE . " WHERE auth_key = '$key' AND key_used = 1";
		$result	= $db->sql_query($sql);
		
		while ($row	= $db->sql_fetchrow($result))
		{
			foreach ($row as $k => $v)
			{
				$invitation_data[$k] = utf8_normalize_nfc(request_var($k, $v, true));
			}
		}
		
		// Don't send confirmation e-mail if not wished
		if (!$invitation_data['send_confirm'])
		{
			return false;
		}
		
		// Get some information about the sender and set vars
		$this->get_sender($invitation_data['user_id']);
		
		$data	= array(
			'key'	=> $key,
			'name'	=> $this->from['username'],
		);
		$this->set_vars($data);
		
		foreach ($this->vars as $k => $v)
		{
			$messenger->vars[$k] = utf8_normalize_nfc(request_var($k, $v, true));
		}
		
		$messenger->to($this->from['user_email'], $this->from['username']);
		$messenger->template('invite_confirm', $this->from['user_lang']);
		
		$messenger->headers('X-AntiAbuse: Board servername - ' . $config['server_name']);
		$messenger->headers('X-AntiAbuse: User_id - ' . $user->data['user_id']);
		$messenger->headers('X-AntiAbuse: Username - ' . $user->data['username']);
		$messenger->headers('X-AntiAbuse: User IP - ' . $user->ip);
		
		$messenger->subject(htmlspecialchars_decode($user->lang['INVITE_CONFIRM_EMAIL']));
		$messenger->set_mail_priority(MAIL_NORMAL_PRIORITY);
		
		$messenger->assign_vars(array(
			'CONTACT_EMAIL' => $config['board_contact'],
		));
		
		$messenger->send();
		$messenger->save_queue();
		
		
		$user_id_save			= $user->data['user_id'];
		$user->data['user_id']	= $this->from['user_id'];
		
		add_log('invite', 'LOG_INVITE_CONFIRM_EMAIL', $this->from['user_email'], $this->new_user['username']);
		
		$user->data['user_id']	= $user_id_save;
		
		return true;
	}
	
	/**
	* function create_key
	* Create a random key
	*/
	function create_key()
	{
		mt_srand(crc32(microtime()));
		$charset 	= $this->config['charset'];
		$lenght		= rand($this->config['key_min_chars'], $this->config['key_max_chars']);
		
		$str_lng 	= strlen($charset) - 1;
		$rand		= '';
		
		for($i = 0; $i < $lenght; $i++)   
		{
			$rand	.= $charset{mt_rand(0, $str_lng)};
		}
		
		// It is highly unlikely this will happen, but still possible
		if ($rand == AUTH_KEY_DISABLED)
		{
			$rand		= '';
			
			// We delete the first character used in AUTH_KEY_DISABLED in $charset
			// so we can't create AUTH_KEY_DISABLED again
			$auth_key_disabled	= AUTH_KEY_DISABLED;
			$charset			= str_replace($auth_key_disabled{0}, '', $charset);
			
			for($i = 0; $i < $lenght; $i++)   
			{
				$rand	.= $charset{mt_rand(0, $str_lng)};
			}
		}
		
		// If keys are disabled we still create a key,
		// so we can use INVITE_KEYS_TABLE as log
		if (!$this->config['auth_key'])
		{
			$rand = AUTH_KEY_DISABLED;
		}
		
		return $rand; 
	}
	
	/**
	* function insert_key
	* Create an entry for the key in database
	*/
	function insert_key($data)
	{
		global $db;
		
		$key_data	= array(
			'user_id'		=> (int) $data['from'],
			'to_email'		=> (string) $data['email'],
			'auth_key'		=> (string) $data['key'],
			'key_time'		=> time(),
			'send_confirm'	=> (!$this->config['confirm_email']) ? 0 : (($this->config['confirm_email'] == 1) ? 1 : $data['confirm_email']),
			'key_used'		=> 0,
			'new_user'		=> 0,
		);
		
		$db->sql_query('INSERT INTO ' . INVITE_KEYS_TABLE . $db->sql_build_array('INSERT', $key_data));
	}
	
	/**
	* function valid_key
	* Check if our key exists in database
	*/
	function valid_key($key)
	{
		global $db;
		
		// $key == AUTH_KEY_DISABLED is important to check!
		// Otherwise someone could enter 'key_disabled', which is default value for AUTH_KEY_DISABLED!
		if ($key == AUTH_KEY_DISABLED)
		{
			return false;
		}
		
		// Optional registration-key?
		if (empty($key) && $this->config['auth_key'] == 1)
		{
			return false;
		}
		if (empty($key) && $this->config['auth_key'] == 2)
		{
			return true;
		}
		
		$sql 		= 'SELECT COUNT(key_id) AS valid FROM ' . INVITE_KEYS_TABLE . " WHERE auth_key = '$key' AND key_used = 0";
		$result 	= $db->sql_query($sql);
		$valid		= $db->sql_fetchfield('valid');
		
		return $valid;
	}
	
	/**
	* function key_used
	* Set key_used to 1 so the key can't be used more than one time
	*/
	function key_used($key, $new_user_id = false)
	{
		global $db, $user;
		
		$data	= array(
			'key_used'	=> 1,
			'new_user'	=> $new_user_id,
		);
		
		// We don't have to check whether $key is empty
		// because we shouldn't get to this point
		// if registration-keys == 1
		if (empty($key) && $this->config['auth_key'] == 2)
		{
			return;
		}
		
		$sql 		= 'UPDATE ' . INVITE_KEYS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $data) . " WHERE auth_key = '$key'";
		$result 	= $db->sql_query($sql);
		
		// Correct user_id (log)
		$sql 		= 'SELECT * FROM ' . INVITE_KEYS_TABLE . ' WHERE new_user = ' . $new_user_id;
		$result		= $db->sql_query($sql);
		
		while ($row	= $db->sql_fetchrow($result))
		{
			foreach ($row as $k => $v)
			{
				$invitation_data[$k] = utf8_normalize_nfc($v);
			}
		}
		
		// Cash mod
		$this->give_cash('registration', $invitation_data['user_id']);
		
		// Add log entry
		$this->get_new_user($new_user_id);
		
		$user_id_save			= $user->data['user_id'];
		$user->data['user_id']	= $invitation_data['user_id'];
		
		add_log('invite', 'LOG_INVITE_KEY_USED', $this->new_user['username']);
		
		if ($this->cash_installed() && $this->config['cash_enable'])
		{
			add_log('invite', 'LOG_CASH_REGISTRATION', $this->new_user['username'], $this->config['cash_registration'], $this->get_currency_name($this->config['cash_id_registration']));
		}
		
		$user->data['user_id']	= $user_id_save;
	}
	
	/**
	* function get_sender
	* Set sender-data as $from
	*/
	function get_sender($user_id)
	{
		global $db;
		
		$sql 	= 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id;
		$result	= $db->sql_query($sql);
		
		while ($row	= $db->sql_fetchrow($result))
		{
			foreach ($row as $k => $v)
			{
				$this->from[$k] = utf8_normalize_nfc($v);
			}
		}
		
		$db->sql_freeresult($result);
	}
	
	/**
	* function get_new_user
	* Set recipient-data as $new_user
	*/
	function get_new_user($user_id)
	{
		global $db;
		
		$sql 	= 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id;
		$result	= $db->sql_query($sql);
		
		while ($row	= $db->sql_fetchrow($result))
		{
			foreach ($row as $k => $v)
			{
				$this->new_user[$k] = utf8_normalize_nfc($v);
			}
		}
		
		$db->sql_freeresult($result);
	}
	
	/**
	* function set_vars
	* Requires $this->from to be set (function get_sender)
	*/
	function set_vars($data)
	{
		global $config, $phpEx, $user;
		
		foreach ($this->from as $k => $v)
		{
			$this->vars['FROM_' . strtoupper($k)] = utf8_normalize_nfc(request_var($k, $v, true));
		}
		
		// Set vars for confirmation email
		if (sizeof($this->new_user))
		{
			foreach ($this->new_user as $k => $v)
			{
				$this->vars['NEW_USER_' . strtoupper($k)] = utf8_normalize_nfc(request_var($k, $v, true));
			}
			
			$this->vars['U_NEW_USER_PROFILE'] = generate_board_url() . '/memberlist.' . $phpEx . '?mode=viewprofile&u=' . $this->new_user['user_id'];
		}
		
		$this->vars['RECIPIENT'] 	= $data['name'];
		$this->vars['USERNAME']		= $user->data['username'];
		$this->vars['AUTH_KEY'] 	= ($this->config['auth_key']) ? $data['key'] : $user->lang['AUTH_KEY_DISABLED'];
		$this->vars['U_AUTH_KEY']	= generate_board_url() . '/ucp.' . $phpEx . '?mode=register&key=' . $data['key'];
	}
	
	/**
	* function session
	* Register a session using a registration-key
	*/
	function session($key)
	{
		global $user, $db;
		
		// $key == AUTH_KEY_DISABLED is important to check!
		// Otherwise someone could enter 'key_disabled', which is default value for AUTH_KEY_DISABLED!
		if (empty($key) || $key == AUTH_KEY_DISABLED)
		{
			return false;
		}
		
		$data	= array(
			'session_ip'	=> $user->data['session_ip'],
		);
		
		$sql 		= 'UPDATE ' . INVITE_KEYS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $data) . " WHERE auth_key = '$key' AND key_used = 0";
		$result 	= $db->sql_query($sql);
	}
	
	/**
	* function self_invite_check
	* Check whether someone want to trick us
	*/
	function self_invite_check($key)
	{
		global $user, $db;
		
		// Just check if wished
		if (!$this->config['self_invite'] || ($this->config['auth_key'] == 2 && empty($key)))
		{
			return false;
		}
				
		$sql 			= 'SELECT COUNT(key_id) AS num_sessions FROM ' . INVITE_KEYS_TABLE . " WHERE session_ip = '" . $user->data['session_ip'] . "'";
		$result 		= $db->sql_query($sql);
		$num_sessions	= $db->sql_fetchfield('num_sessions');
		
		if ($num_sessions > 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	* function get_info
	* Get information on the invitations which belong to the user defined in $log_id
	*/
	function get_info($log_id)
	{
		global $db, $phpbb_admin_path, $phpbb_root_path, $phpEx;
		
		// Set up some vars
		$profile_url 	= (defined('IN_ADMIN')) ? append_sid("{$phpbb_admin_path}index.$phpEx", 'i=users&amp;mode=overview') : append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile');
		$new_users		= array();
		
		$sql = "SELECT l.*, u.username, u.username_clean, u.user_colour
		FROM " . LOG_TABLE . " l, " . USERS_TABLE . " u
		WHERE l.log_id = $log_id
			AND u.user_id = l.user_id";
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
		$sql	= 'SELECT COUNT(key_id) as invitations FROM ' . INVITE_KEYS_TABLE . ' WHERE user_id = ' . $data['user_id'];
		$result = $db->sql_query($sql);
		
		$data['invitations']	= $db->sql_fetchfield('invitations');
		$db->sql_freeresult($result);
		
		// Total registrations
		$sql	= 'SELECT COUNT(key_id) as registrations FROM ' . INVITE_KEYS_TABLE . ' WHERE user_id = ' . $data['user_id'] . ' AND key_used = 1';
		$result = $db->sql_query($sql);
		
		$data['registrations']	= $db->sql_fetchfield('registrations');
		$db->sql_freeresult($result);
		
		// Get all invitations sent by our current user
		$sql 			= 'SELECT * FROM ' . INVITE_KEYS_TABLE . ' WHERE user_id = ' . $data['user_id'] . ' AND key_used = 1';
		$result 		= $db->sql_query($sql);
		
		while ($row = $db->sql_fetchrow($result))
		{
			foreach ($row as $k => $v)
			{
				$invitations_row[$k] = utf8_normalize_nfc($v);
			}
			
			// Get information on all new users, who were invited by our current user
			$sql2			= 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = ' . $invitations_row['new_user'];
			$result2 		= $db->sql_query($sql2);
				
			while ($row2 = $db->sql_fetchrow($result2))
			{
				foreach ($row2 as $k2 => $v2)
				{
					$new_user_row[$k2] = utf8_normalize_nfc($v2);
				}
			}
			$db->sql_freeresult($result2);
			
			// Add them to an array so we can use implode() later
			$new_users[] = get_username_string('full', $new_user_row['user_id'], $new_user_row['username'], $new_user_row['user_colour'], false, $profile_url);
		}
		$db->sql_freeresult($result);
		
		$data['reg_users']	= implode(', ', $new_users);
		
		return $data;
	}
		
	/**
	* function header_template
	* Called in functions.php so users don't have to add much code there
	*
	function header_template()
	{
		global $user, $auth, $template, $phpbb_root_path, $phpEx;
		
		$user->add_lang('invite');
		
		$template->assign_vars(array(
			'U_INVITE_A_FRIEND'		=> append_sid("{$phpbb_root_path}invite.$phpEx"),
			
			'S_SHOW_IAF'			=> (!$this->config['enable']) ? false : (($auth->acl_get('u_send_iaf')) ? true : false),
		));
	}
	*/
	
	/**
	* function cash_installed
	* Check whether cash mod is installed
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
	* Add the cash defined in config
	*/
	function give_cash($mode, $user_id)
	{
		global $config, $user, $phpbb_root_path, $phpEx;
		
		if ($this->cash_installed() && $this->config['cash_enable'])
		{
			global $cash;
			
			if ($mode = 'invitation')
			{
				$cash->give_cash($user_id, $this->config['cash_invitation'], $this->config['cash_id_invitation']);
			}
			else
			{
				// $mode = 'registration'
				$cash->give_cash($user_id, $this->config['cash_registration'], $this->config['cash_id_registration']);
			}
		}
	}
	
	/**
	* function get_currency_name
	* Return currency name from given id
	*/
	function get_currency_name($cash_id)
	{
		global $db;
		
		if ($this->cash_installed())
		{
			global $cash;
			
			$sql	= 'SELECT * FROM ' . CASH_TABLE . ' WHERE cash_id = ' . $cash_id;
			$result = $db->sql_query($sql);
				
			while ($row = $db->sql_fetchrow($result))
			{
				$return	= $row['cash_name'];
			}
			$db->sql_freeresult($result);
			
			return $return;
		}
	}
}
?>