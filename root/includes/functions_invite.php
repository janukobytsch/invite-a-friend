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
* Class invite
* Send emails, create keys ...
*/              
class invite
{
	var $config;
	var $from;
	var $vars;
	
	// Contains the message stored in ./language/.../email/invite.txt
	var $message;
	
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
		
		$this->message_file($user->data['user_lang']);
	}
	
	/**
	* function message_file
	* Read and update the message stored in ./language/.../email/invite.txt
	*/
	function message_file($template_lang, $mode = 'read', $new_message = '')
	{
		global $phpEx, $phpbb_root_path, $user;
		
		$tpl_file = "{$phpbb_root_path}language/$template_lang/email/invite.txt";
		
		if ($mode == 'read')
		{
			if (($data = @file_get_contents($tpl_file)) === false)
			{
				trigger_error("Failed opening template file [ $tpl_file ]", E_USER_ERROR);
			}
			
			$this->message = $data;
		}
		
		if ($mode == 'update')
		{
			$file = fopen($tpl_file, "r+");
			
			rewind($file);
			fwrite($file, $new_message);
			fclose($file);
		}
	}
	
	/**
	* function set_config
	* Updates the iaf_config-table
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
	* Sends the email to a friend
	*/
	function send_email($data)
	{
		global $phpEx, $phpbb_root_path, $config;
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
		$this->insert_key($data['from'], $data['key']);
		
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
		
		return $rand; 
	}
	
	/**
	* function insert_key
	* Create an entry for the key in database
	*/
	function insert_key($user_id, $key)
	{
		global $db;
		
		$key_data	= array(
			'user_id'	=> (int) $user_id,
			'auth_key'	=> (string) $key,
			'key_time'	=> time(),
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
		
		$sql 		= 'SELECT COUNT(key_id) AS valid FROM ' . INVITE_KEYS_TABLE . " WHERE auth_key = '$key'";
		$result 	= $db->sql_query($sql);
		$valid		= $db->sql_fetchfield('valid');
		
		return $valid;
	}
	
	/**
	* function delete_key
	* Delete the key so it can't be used more than one time
	*/
	function delete_key($key)
	{
		global $db;
		
		$sql 		= 'DELETE FROM ' . INVITE_KEYS_TABLE . " WHERE auth_key = '$key'";
		$result 	= $db->sql_query($sql);
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
				$this->from[$k] = utf8_normalize_nfc(request_var($k, $v, true));
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
		foreach ($this->from as $k => $v)
		{
			$this->vars[strtoupper($k)] = utf8_normalize_nfc(request_var($k, $v, true));
		}
		
		$this->vars['RECIPIENT'] 	= $data['name'];
		$this->vars['AUTH_KEY'] 	= $data['key'];
	}
}
?>