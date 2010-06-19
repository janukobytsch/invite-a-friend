<?php
/** 
*
* @package acp
* @version $Id: acp_invite.php 8645 2008-10-03 10:40:17Z Bycoja $
* @copyright (c) 2008 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* @package acp
*/
class acp_invite
{
	var $u_action, $invite;

	function main($id, $mode)
	{
		global $db, $user, $template, $cache, $phpEx;
		global $config, $phpbb_root_path, $phpbb_admin_path;
		
		$user->add_lang(array('invite', 'ucp', 'mods/info_acp_invite', 'acp/board'));
		
		include ($phpbb_root_path . 'includes/functions_user.' . $phpEx);
		include ($phpbb_root_path . 'includes/functions_invite.' . $phpEx);
		
		// Set up general vars
		$invite		 		= new invite();
		$this->page_title	= ($mode == 'log') ? 'ACP_INVITE_A_FRIEND_LOG' : 'ACP_INVITE_A_FRIEND';
		$this->tpl_name		= ($mode == 'log') ? 'acp_invite_log' : 'acp_invite';

		$action				= request_var('action', '');
		$submit				= (isset($_POST['submit']))  ? true : false;
		$error				= array();
		
		/**
		* Development
		*
		$cache_file 	= $phpbb_root_path . 'cache/ctpl_admin_acp_invite.html.' . $phpEx;
		$cache_file2 	= $phpbb_root_path . 'cache/ctpl_admin_acp_invite_log.html.' . $phpEx;
		
		if (file_exists($cache_file))
		{
			unlink($cache_file);
		}
		if (file_exists($cache_file2))
		{
			unlink($cache_file2);
		}
		*/
		
		// Do the job ...
		switch ($mode)
		{
			case 'settings':
				// Set up general vars
				$message			= request_var('message', $invite->message, true);
				$confirm_message	= request_var('confirm_message', $invite->confirm_message, true);
		
				foreach ($invite->config as $k => $v)
				{
					$iaf_config[$k] = utf8_normalize_nfc(request_var($k, $v, true));
				}
		
				if ($submit)
				{
					$check_ary = array(
						'time'			=> array('num', false, 1, 99999),
						'min_message'	=> array('num', false, 1, 9999),
						'max_message'	=> array('num', false, 1, 9999),
						'min_subject'	=> array('num', false, 1, 999),
						'max_subject'	=> array('num', false, 1, 999),
						'key_min_chars'	=> array('num', false, 1, 999),
						'key_max_chars'	=> array('num', false, 1, 999),
						'charset'		=> array('string', false, 1, 250),
					);
					
					$error = validate_data($iaf_config, $check_ary);
					
					if (empty($message) || empty($confirm_message))
					{
						$error[]	= $user->lang['ERROR_SETTINGS'];
					}
					
					if (!sizeof($error))
					{
						foreach ($iaf_config as $k => $v)
						{
							$invite->set_config($k, $iaf_config[$k]);
						}
						
						// Update messages
						$invite->message_file($user->data['user_lang'], 'invite', 'update', $message);
						$invite->message_file($user->data['user_lang'], 'invite_confirm', 'update', $confirm_message);
						
						add_log('admin', 'LOG_IAF_SETTINGS_UPDATED');
						trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
					}
					
					// Replace "error" strings with their real, localised form
					$error = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$user->lang['\\1'])) ? \$user->lang['\\1'] : '\\1'", $error);
				}
				
				// Well, i'm too lazy to assign every single config var ...
				foreach ($iaf_config as $k => $v)
				{
					$template->assign_vars(array(
						'S_' . strtoupper($k)	=> $v,
					));
				}
				
				$template->assign_vars(array(
					// Display all errors: 'ERROR'		=> (sizeof($error)) ? implode('<br />', $error) : '',
					// We only display the first error in array so eveything is clearly arranged
					'ERROR'				=> (sizeof($error)) ? $user->lang['ERROR_SETTINGS'] : '',
					
					'S_MESSAGE'			=> $message,
					'S_CONFIRM_MESSAGE'	=> $confirm_message,
					'U_ACTION'			=> $this->u_action,
				));
			break;
			
			case 'log':
				// Set up general vars
				$profile_url		= (defined('IN_ADMIN')) ? append_sid("{$phpbb_admin_path}index.$phpEx", 'i=users&amp;mode=overview') : append_sid("{$phpbb_root_path}memberlist.$phpEx", 'mode=viewprofile');
				$start				= request_var('start', 0);
				$entries_per_page	= LOG_ENTRIES_PER_PAGE;
				
				// Get number of total entries in INVITE_KEYS_TABLE
				$sql 			= 'SELECT COUNT(key_id) as total_entries FROM ' . INVITE_KEYS_TABLE;
				$result 		= $db->sql_query($sql);
				$total_entries	= $db->sql_fetchfield('total_entries');
				
				// Get all values from INVITE_KEYS_TABLE
				$sql 	= 'SELECT * FROM ' . INVITE_KEYS_TABLE;
				$result = $db->sql_query_limit($sql, $entries_per_page, $start);
				
				while ($row = $db->sql_fetchrow($result))
				{
					$new_users	= array();
					
					// Get all information about the user who sent the invitation
					$user_sql 		= 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = ' . $row['user_id'];
					$user_result 	= $db->sql_query($user_sql);
					
					while ($user_row = $db->sql_fetchrow($user_result))
					{
						foreach ($user_row as $k => $v)
						{
							$row_user[$k] = utf8_normalize_nfc($v);
						}
					}
					$db->sql_freeresult($user_result);
					
					// Count all invitations sent by our current user
					$sql2 			= 'SELECT COUNT(key_id) as invitations FROM ' . INVITE_KEYS_TABLE . ' WHERE user_id = ' . $row_user['user_id'];
					$result2 		= $db->sql_query($sql2);
					$invitations	= $db->sql_fetchfield('invitations');
					
					// Get all invitations sent by our current user
					$sql2 			= 'SELECT * FROM ' . INVITE_KEYS_TABLE . ' WHERE user_id = ' . $row['user_id'] . ' AND key_used = 1';
					$result2 		= $db->sql_query($sql2);
					
					while ($row2 = $db->sql_fetchrow($result2))
					{
						foreach ($row2 as $k => $v)
						{
							$invitations_row[$k] = utf8_normalize_nfc($v);
						}
						
						// Get information about all new users, who were invited by our current user
						$sql3			= 'SELECT * FROM ' . USERS_TABLE . ' WHERE user_id = ' . $invitations_row['new_user'];
						$result3 		= $db->sql_query($sql3);
							
						while ($row3 = $db->sql_fetchrow($result3))
						{
							foreach ($row3 as $k2 => $v2)
							{
								$new_user_row[$k2] = utf8_normalize_nfc($v2);
							}
						}
						
						// Add them to an array so we can use implode() later
						$new_users[] = get_username_string('full', $new_user_row['user_id'], $new_user_row['username'], $new_user_row['user_colour'], false, $profile_url);
					}
					
					// Assign row
					$template->assign_block_vars('log', array(
						'USERNAME'				=> get_username_string('full', $row_user['user_id'], $row_user['username'], $row_user['user_colour'], false, $profile_url),
						'DATE'					=> $user->format_date($row['key_time']),
						'INVITATIONS'			=> $invitations,
						'REGISTRATIONS_USER'	=> implode($new_users, ', '),
						'EMAIL'					=> $row['to_email'],
						)
					);
				}
				
				// Pagination
				$template->assign_vars(array(
					'S_ON_PAGE'		=> on_page($total_entries, $entries_per_page, $start),
					'PAGINATION'	=> generate_pagination($this->u_action, $total_entries, $entries_per_page, $start, true),
				));
			break;
		}
	}
}
?>