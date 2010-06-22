<?php
/**
*
* @author Bycoja bycoja@web.de
* @package phpBB3
* @version $Id functions_invite.php 0.6.2 2010-06-22 17:28:02GMT Bycoja $
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

define('EMAIL', 	0);
define('PM', 		1);
define('OPTIONAL', 	2);

$INVITE_MESSAGE_TYPE = array(
	'invite'	=> 0,
	'confirm'	=> 1,
);

/**
* Invitation class
* @package phpBB3
*/      
class invite
{
	var $version = '0.6.2';
	var $INVITE_MESSAGE_TYPE = array('invite' => 0, 'confirm' => 1,);

	var $config;
	var $message;
	var $invite_user;
	var $register_user;

	/**
	* function invite
	 */
	function invite()
	{
		global $db, $config;

		// Make sure the mod is actually installed
		if (!isset($config['invite_version']) || defined('IN_INSTALL'))
		{
			return;
		}

		if (empty($this->config))
		{
			$this->get_config();
		}

		// If not in ACP, disable everything in order not to check whether the mod itself is enabled every time
		if (!$this->config['enable'] && !defined('IN_ADMIN'))
		{
			foreach ($this->config as $k => $v)
			{
				$this->config[$k] = 0;
			}

			return false;
		}
	}

	/**
	* function get_config
	 */
	function get_config()
	{
		global $db;
		
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

		$sql = 'UPDATE ' . INVITE_CONFIG_TABLE . '
				SET config_value = "' . $db->sql_escape($value) . '"
				WHERE config_name = "' . $db->sql_escape($key) . '"';
		$db->sql_query($sql);
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
	* function get_template (adapted from DEV v1.0.0.)
	* Loads the requested template file
	*
	* @param string $template_file
	* @param optional string $template_lang
	* @param optional string $template_path
	* @return string $template
	*/
	function get_template($template_file, $template_lang = '', $template_path = '')
	{
		global $phpbb_root_path, $user;

		if (!trim($template_file))
		{
			trigger_error('invite->get_template(): No template file set.', E_USER_ERROR);
		}

		$template_lang 	= (!trim($template_lang)) ? basename($user->data['user_lang']) : $template_lang;
		$template_path 	= (!trim($template_path)) ? "{$phpbb_root_path}language/{$template_lang}/email/" : $template_path;
		$destination 	= $template_path . $template_file;

		$template = (file_exists($destination)) ? @file_get_contents($destination) : '';

		return $template;
	}

	/**
	* function set_template (adapted from DEV v1.0.0.)
	* Updates or creates the designated template file
	*
	* @param string $template_data
	* @param string $template_file
	* @param optional string $template_lang
	* @param optional string $template_path
	* @return string $template
	*/
	function set_template($template_data, $template_file, $template_lang = '', $template_path = '')
	{
		global $phpbb_root_path, $user;

		if (!trim($template_file))
		{
			trigger_error('invite->get_template(): No template file set.', E_USER_ERROR);
		}

		$template_lang 	= (!trim($template_lang)) ? basename($user->data['user_lang']) : $template_lang;
		$template_path 	= (!trim($template_path)) ? "{$phpbb_root_path}language/{$template_lang}/email/" : $template_path;
		$destination 	= $template_path . $template_file;

		if ($fp = @fopen($destination, 'wb'))
		{
			@flock($fp, LOCK_EX);
			@fwrite ($fp, $template_data);
			@flock($fp, LOCK_UN);
			@fclose($fp);

			phpbb_chmod($destination, CHMOD_READ | CHMOD_WRITE);
		}
	}

	/**
	* function set_cookie
	* Sets a cookie containing the registration key
	*/
	function set_cookie($key)
	{
		global $user;

		$user->set_cookie('reg_key', $key, 0); // Session cookie
	}

	/**
	* function set_vars
	*/
	function set_vars($data)
	{
		global $config, $phpEx, $user;

		// Inviter
		if (sizeof($this->invite_user))
		{
			foreach ($this->invite_user as $k => $v)
			{
				$this->vars['INVITER_' . strtoupper($k)] = $v;
			}
		}

		// Invitee
		if (sizeof($this->register_user))
		{
			foreach ($this->register_user as $k => $v)
			{
				$this->vars['INVITED_' . strtoupper($k)] = $v;
			}
			
			$this->vars['INVITED_USER_PROFILE_URL'] = generate_board_url() . '/memberlist.' . $phpEx . '?mode=viewprofile&u=' . $this->register_user['user_id'];
		}

		// Invitation config
		foreach ($this->config as $k => $v)
		{
			$this->vars['INVITATION_CONFIG_' . strtoupper($k)] = $v;
		}

		// Even if these vars is already defined in messenger, we have to define it here, too.
		// Otherwise it won't be parsed in confirmation PM.
		$this->vars['SITENAME']			= htmlspecialchars_decode($config['sitename']);
		$this->vars['BOARD_URL']		= generate_board_url();
		$this->vars['RECIPIENT_NAME'] 	= (isset($data['register_real_name'])) ? $data['register_real_name'] : '';
		$this->vars['REGISTRATION_KEY'] = $data['register_key'];
		$this->vars['REGISTRATION_URL']	= generate_board_url() . '/ucp.' . $phpEx . '?mode=register&referral=' . urlencode($user->data['username']) . '&key=' . $data['register_key'];
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
		$send_messenger = $this->messenger($data, $data['method']);

		if (!$send_messenger)
		{
			return false;
		}

		if (empty($this->register_user))
		{
			$this->log_table($data);
		}

		// Log actions
		if ($data['message_type'] == $this->INVITE_MESSAGE_TYPE['invite'])
		{
			$user->data['user_id']	= $this->invite_user['user_id'];
			add_log('invite', 'LOG_INVITE_' . strtoupper(array_search($data['message_type'], $this->INVITE_MESSAGE_TYPE)), $data['register_email']);

			$this->give_cash('invite', $this->invite_user['user_id']);
			$this->give_ultimate_points('invite', $this->invite_user['user_id']);

			// Statistics
			$sql 	= 'UPDATE ' . INVITE_CONFIG_TABLE . ' SET config_value = config_value + 1 WHERE config_name = "num_invitations"';
			$result = $db->sql_query($sql);
			$sql 	= 'UPDATE ' . USERS_TABLE . ' SET user_invitations = user_invitations + 1 WHERE user_id = ' . (int) $this->invite_user['user_id'];
			$result = $db->sql_query($sql);
		}
		else
		{
			// Use the inviters user_id here...
			$save_user_id = $user->data['user_id'];
			$user->data['user_id'] = $this->invite_user['user_id'];

			$name_or_email = ($data['method'] == EMAIL) ? $this->invite_user['user_email'] : $this->invite_user['username'];
			add_log('invite', 'LOG_INVITE_' . strtoupper(array_search($data['message_type'], $this->INVITE_MESSAGE_TYPE)), $name_or_email, $this->register_user['username']);

			$user->data['user_id'] = $save_user_id;
		}

		return true;
	}

	/**
	* function messenger
	*/
	function messenger($data, $method)
	{
		global $config, $user, $phpbb_root_path, $phpEx;

		if (!class_exists('messenger'))
		{
			include($phpbb_root_path . 'includes/functions_messenger.' . $phpEx);
		}
		if (!function_exists('submit_pm'))
		{
			include($phpbb_root_path . 'includes/functions_privmsgs.' . $phpEx);
		}

		$template_file = array_search($data['message_type'], $this->INVITE_MESSAGE_TYPE) . '_message';
		$subject = $this->get_template(array_search($data['message_type'], $this->INVITE_MESSAGE_TYPE) . '_subject.txt', $data['invite_language']);
		$message = $this->get_template("{$template_file}.txt", $data['invite_language']);

		// Set up subject and message wildcards
		$this->vars['USER_SUBJECT'] = (!empty($data['subject'])) ? htmlspecialchars_decode($data['subject']) : '';
		$this->vars['USER_MESSAGE'] = (!empty($data['message'])) ? htmlspecialchars_decode($data['message']) : '';
		
		// Use user specified subject and message if the template is empty
		$subject = (empty($subject)) ? $this->vars['USER_SUBJECT'] : $subject;
		$message = (empty($message)) ? $this->vars['USER_MESSAGE'] : $message;

		// Parse subject wildcards (message wildcards will be parsed later)
		foreach ($this->vars as $wildcard => $value)
		{
			$subject = str_replace('{' . $wildcard . '}', $value, $subject);
		}

		switch($method)
		{
			case EMAIL:

				$messenger	= new messenger(false); // Use false so send the e-mail immediately
				$username	= (isset($data['register_real_name'])) ? $data['register_real_name'] : $this->register_user['username'];

				$messenger->to($data['register_email'], $username);
				$messenger->template($template_file, $data['invite_language']);

				$messenger->headers('X-AntiAbuse: Board servername - ' . $config['server_name']);
				$messenger->headers('X-AntiAbuse: User_id - ' . $data['method_user_id']);
				$messenger->headers('X-AntiAbuse: Username - ' . $this->user_return_data($data['method_user_id'], 'user_id', 'username'));
				$messenger->headers('X-AntiAbuse: User IP - ' . $this->user_return_data($data['method_user_id'], 'user_id', 'user_ip'));

				$messenger->subject($subject);
				$messenger->set_mail_priority($data['priority']);

				$messenger->assign_vars($this->vars);
				$messenger->assign_vars(array(
					'CONTACT_EMAIL' => $config['board_contact'],
				));

				if (!($messenger->send()))
				{
					$errored = true;
					return false;
				}

			break;

			case PM:

				// We can use invite_user_id here, because we are just going to send confirmations
				$address_list = array();
				$address_list['u'][$data['invite_user_id']] = 'to';

				// Replace all placeholders
				foreach ($this->vars as $replace => $value)
				{
					$message = str_replace('{' . $replace . '}', $value, $message);
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

		return true;
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
	* function generate_key (adapted from DEV v1.0.0.)
	* Generates a referral key using phpBB's generation function
	*
	* @return string $referral_key
	*/
	function generate_key()
	{
		// Must be less than 32 characters due to md5 usage
		$str_lenght		= 12;

		$random_string 	= gen_rand_string($str_lenght);
		$referral_key 	= substr(md5($random_string), rand(1, (32 - $str_lenght)), $str_lenght);

		return $referral_key; 
	}

	/**
	* function invite_yourself
	*/
	function invite_yourself($key)
	{
		global $user, $db;

		// Just check if wished
		if (!$this->config['prevent_abuse'] || ($this->config['enable_key'] == 2 && empty($key)))
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

		if (empty($key))
		{
			return false;
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

		// Our last chance to associate the newly registered user with an invitation is to check his e-mail address if enabled
		if (!$this->valid_key($key))
		{
			$register_user_email = $this->user_return_data($register_user_id, 'user_id', 'user_email');

			if ($this->config['enable_email_identification'] && $this->email_is_invited($register_user_email))
			{
				// First inviter takes it all...
				$sql = 'SELECT register_key
					FROM ' . INVITE_LOG_TABLE . '
					WHERE register_email = "' . $db->sql_escape($register_user_email) . '"
					ORDER BY invite_time ASC
					LIMIT 1';
				$result = $db->sql_query($sql);
				$key = $db->sql_fetchfield('register_key');
			}
			else
			{
				return;
			}
		}

		// Update the referring log entry
		$sql_ary	= array(
			'register_key_used'	=> 1,
			'register_user_id'	=> (int) $register_user_id,
		);

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

		// Get inviter data
		if (!$this->register_user['user_id'])
		{
			$sql	= 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = ' . (int) $invitation_data['register_user_id'];
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				foreach ($row as $k => $v)
				{
					$this->register_user[$k] = utf8_normalize_nfc($v);
				}
			}
			$db->sql_freeresult($result);
		}

		// Get invitee data
		if (!$this->invite_user['user_id'])
		{
			$sql	= 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = ' . (int) $invitation_data['invite_user_id'];
			$result = $db->sql_query($sql);

			while ($row = $db->sql_fetchrow($result))
			{
				foreach ($row as $k => $v)
				{
					$this->invite_user[$k] = utf8_normalize_nfc($v);
				}
			}
			$db->sql_freeresult($result);
		}

		// Group handling
		if ($this->config['enable_key'] == 2 && $this->valid_key($key, false))
		{
			$sql = 'SELECT group_id
				FROM ' . GROUPS_TABLE . "
				WHERE group_name = 'NEWLY_REGISTERED'
					AND group_type = " . GROUP_SPECIAL;
			$result = $db->sql_query($sql);
			$newly_group_id = (int) $db->sql_fetchfield('group_id');
			$db->sql_freeresult($result);

			// Display some user for logged administrator actions
			$save_user_id = $user->data['user_id'];
			$user->data['user_id'] = $register_user_id;

			if ($this->config['remove_newly_registered'] == 1 && $this->config['key_group'] != $newly_group_id)
			{
				remove_newly_registered($register_user_id);
			}

			if ($this->config['key_group_default'])
			{
				group_user_add($this->config['key_group'], $register_user_id, false, false, true);
			}
			else
			{
				group_user_add($this->config['key_group'], $register_user_id);
			}

			// Restore original user id
			$user->data['user_id'] = $save_user_id;
		}

		// Send confirmation
		if ($invitation_data['invite_confirm'])
		{
			$user->add_lang('mods/info_acp_invite');

			$confirm_data 					= $invitation_data;
			$confirm_data['priority']		= MAIL_NORMAL_PRIORITY;
			$confirm_data['register_email'] = $this->invite_user['user_email'];
			$confirm_data['message_type'] 	= $this->INVITE_MESSAGE_TYPE['confirm'];
			$confirm_data['method'] 		= (empty($confirm_data['register_email'])) ? PM : $invitation_data['invite_confirm_method'];
			$confirm_data['method_user_id'] = $register_user_id;
			$confirm_data['invite_language']= $this->invite_user['user_lang'];
			$confirm_data['subject']		= $user->lang['ACP_INVITE'] . ' - ' . $user->lang['INVITE_CONFIRM'];

			$this->message_handle($confirm_data, true, true);
		}

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

		// Add inviter id to the newly registered user
		$sql_ary	= array(
			'user_inviter_id'	=> (int) $this->invite_user['user_id'],
			'user_inviter_name'	=> $db->sql_escape($this->invite_user['username']),
		);
		$sql 		= 'UPDATE ' . USERS_TABLE . ' SET ' . $db->sql_build_array('UPDATE', $sql_ary) . ' WHERE user_id = ' . (int) $this->register_user['user_id'];
		$result 	= $db->sql_query($sql);

		// Update statistics
		$sql 	= 'UPDATE ' . INVITE_CONFIG_TABLE . ' SET config_value = config_value + 1 WHERE config_name = "num_registrations"';
		$result = $db->sql_query($sql);
		$sql 	= 'UPDATE ' . USERS_TABLE . ' SET user_registrations = user_registrations + 1 WHERE user_id = ' . (int) $this->invite_user['user_id'];
		$result = $db->sql_query($sql);

		$this->give_cash('register', $this->invite_user['user_id']);
		$this->give_ultimate_points('register', $this->invite_user['user_id']);

		// Associate with the inviting user
		$save_user_id = $user->data['user_id'];
		$user->data['user_id'] = $this->invite_user['user_id'];

		add_log('invite', 'LOG_INVITE_REGISTER', $this->register_user['username']);

		$user->data['user_id'] = $save_user_id;
	}

	/**
	* function email_is_invited
	*/
	function email_is_invited($email)
	{
		global $db;

		$sql = 'SELECT log_id FROM ' . INVITE_LOG_TABLE . ' WHERE register_email = "' . $db->sql_escape($email) . '" AND register_key_used = 0';
		$result = $db->sql_query($sql);
		$log_id = $db->sql_fetchfield('log_id');

		return $log_id;
	}

	/**
	* function get_profile_info
	*/
	function get_profile_info($log_id, $mode = 'log', $user_id = '')
	{
		global $db, $phpbb_admin_path, $phpbb_root_path, $phpEx;

		$profile_url 	= (defined('IN_ADMIN')) ? append_sid("{$phpbb_admin_path}index.$phpEx", 'i=users&amp;mode=invite') : append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile');
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
			foreach($row as $k => $v)
			{
				$data[$k] = $v;
			}
			$data['username_full'] = get_username_string('full', $data['user_id'], $data['username'], $data['user_colour'], false, $profile_url);
		}
		$db->sql_freeresult($result);

		// Statistics
		$data['inviter_id'] = ($data['user_inviter_id']) ? get_username_string('full', $data['user_inviter_id'], $this->user_return_data($data['user_inviter_id'], 'user_id', 'username'), $this->user_return_data($data['user_inviter_id'], 'user_id', 'user_colour'), false, $profile_url) : '';
		$data['inviter_name'] = $data['user_inviter_name'];
		$data['invitations'] = $data['user_invitations'];
		$data['registrations'] = $data['user_registrations'];
		$data['total_invitations'] = $this->config['num_invitations'];
		$data['total_registrations'] = $this->config['num_registrations'];

		return $data;
	}

	/**
	* function profile_fields
	*/
	function profile_fields($postrow, $poster_id)
	{
		global $config, $template, $user, $auth, $phpEx, $phpbb_root_path;

		$user->add_lang('mods/info_acp_invite');
		$info = $this->get_profile_info('', 'profile', $poster_id);

		// Use mod´s installation time for correct calculation if the user had been registered before the installation
		$user_regdate = ($this->config['tracking_time'] > $info['user_regdate']) ? $this->config['tracking_time'] : $info['user_regdate'];

		// Do the relevant calculations
		$memberdays 			= max(1, round((time() - $user_regdate) / 86400));
		$invitations_per_day 	= $info['invitations'] / $memberdays;
		$invitations_pct		= ($info['total_invitations']) ? min(100, ($info['invitations'] / $info['total_invitations']) * 100) : 0;
		$registrations_per_day 	= $info['registrations'] / $memberdays;
		$registrations_pct 		= ($info['total_registrations']) ? min(100, ($info['registrations'] / $info['total_registrations']) * 100) : 0;
		$success_rate			= ($info['invitations'] && $info['registrations']) ? min(100, ($info['registrations'] / $info['invitations']) * 100) : 0;

		$invite_row = array(
			'POSTER_INVITE_INVITER_NAME'=>	$info['inviter_name'],
			'POSTER_INVITE_INVITER'		=> $info['inviter_id'],
			'POSTER_INVITE_INVITE'		=> ($info['invitations']) ? $info['invitations'] : 0,
			'POSTER_INVITE_REGISTER'	=> ($info['registrations']) ? $info['registrations'] : 0,
		);

		$template->assign_vars(array(
			'INVITATIONS_DAY'			=> ($this->config['advanced_statistics']) ? sprintf($user->lang['INVITATIONS_DAY'], $invitations_per_day) : false,
			'INVITATIONS_PCT'			=> ($this->config['advanced_statistics']) ? sprintf($user->lang['INVITATIONS_PCT'], $invitations_pct) : false,
			'REGISTRATIONS_DAY'			=> ($this->config['advanced_statistics']) ? sprintf($user->lang['REGISTRATIONS_DAY'], $registrations_per_day) : false,
			'REGISTRATIONS_PCT'			=> ($this->config['advanced_statistics']) ? sprintf($user->lang['REGISTRATIONS_PCT'], $registrations_pct) : false,
			'REGISTRATIONS_SUCCESS_RATE'=> ($this->config['advanced_statistics']) ? sprintf($user->lang['REGISTRATIONS_SUCCESS_RATE'], $success_rate) : false,

			'S_T_DISPLAY_INVITER'	=> ($this->config['display_t_inviter'] && !empty($info['inviter_id'])) ? true : false,
			'S_T_DISPLAY_INVITE'	=> $this->config['display_t_invite'],
			'S_T_DISPLAY_REGISTER'	=> $this->config['display_t_register'],
			'S_P_DISPLAY_INVITER'	=> ($this->config['display_p_inviter'] && !empty($info['inviter_id'])) ? true : false,
			'S_P_DISPLAY_INVITE'	=> $this->config['display_p_invite'],
			'S_P_DISPLAY_REGISTER'	=> $this->config['display_p_register'],

			'S_DISPLAY_REGISTRATION_SEARCH'	=> ($this->config['invite_search_allowed']) ? $this->config['display_m_inviter'] : '',

			'U_SEARCH_REGISTRATIONS'		=> append_sid("{$phpbb_root_path}memberlist.$phpEx", 'ui=' . $info['user_id']),
			'U_USER_ADMIN_INVITATIONS'		=> ($auth->acl_get('a_invite_log')) ? append_sid("{$phpbb_root_path}adm/index.$phpEx", 'i=invite&amp;mode=log&amp;filter=invite&amp;ui=' . $info['username'], true, $user->session_id) : '',
			'U_USER_ADMIN_REGISTRATIONS'	=> ($auth->acl_get('a_invite_log')) ? append_sid("{$phpbb_root_path}adm/index.$phpEx", 'i=invite&amp;mode=log&amp;filter=register&amp;ui=' . $info['username'], true, $user->session_id) : '',
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
			'S_DISPLAY_INVITE'		=> ($auth->acl_get('u_send_invite')) ? true : false,
		));
	}

	/** ################
	* ##### PLUGINS######
	*/#################

	/**
	* function ultimate_points_installed
	*/
	function ultimate_points_installed()
	{
		global $phpbb_root_path, $phpEx, $config;

		$check_file = $phpbb_root_path . 'includes/points/functions_points.' . $phpEx;

		if (isset($config['ultimate_points_version']))
		{
			if (version_compare($config['ultimate_points_version'], '1.0.0', '>='))
			{
				if (file_exists($check_file))
				{
					return true;
				}
			}
		}

		return false;
	}

	/**
	* function give_ultimate_points
	*/
	function give_ultimate_points($mode, $user_id)
	{
		//

		if ($this->ultimate_points_installed() && $this->config['enable_ultimate_points'])
		{
			if ($mode == 'invite')
			{
				add_points($user_id, $this->config['ultimate_points_invite']);
			}
			else
			{
				// $mode = 'register'
				add_points($user_id, $this->config['ultimate_points_register']);
			}
		}
	}

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
}
?>