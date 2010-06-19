<?php
/** 
* @author Bycoja bycoja@web.de
*
* @package acp
* @version $Id: acp_invite.php 5.0.2 2009-04-15 22:35:59GMT Bycoja $
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
* @package acp
* @todo		- No register key entered: identify invited friends by e-mail
			- http://bycoja.by.funpic.de/viewtopic.php?f=13&t=53#p463
			- OpenInviter
*/
class acp_invite
{
	var $u_action, $invite;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache, $phpEx;
		global $config, $phpbb_root_path, $phpbb_admin_path;
		
		$user->add_lang(array('ucp', 'mods/info_acp_invite', 'acp/board'));
		
		include ($phpbb_root_path . 'includes/functions_user.' . $phpEx);
		include ($phpbb_root_path . 'includes/functions_invite.' . $phpEx);
		
		// General vars
		$invite		 		= new invite();
		$action				= request_var('action', '');
		$this->page_title	= ($mode == 'log') ? 'ACP_INVITE_LOG' : 'ACP_INVITE';
		$this->tpl_name		= ($mode == 'log') ? 'acp_invite_log' : 'acp_invite';
		$submit				= (isset($_POST['submit']))  ? true : false;		
		
		foreach ($invite->config as $k => $v)
		{
			$new_config[$k] = utf8_normalize_nfc(request_var($k, $v, true));
		}
		
		switch ($mode)
		{
			case 'settings':
				$block_assigned		= false;
				$message_error		= false;
				$message_ary 		= array();
				$error				= array();
				$lang_ary			= $invite->get_languages();
				
				$queue_time_m	= request_var('queue_time_m', floor($invite->config['queue_time'] / 60));
				$queue_time_s	= request_var('queue_time_s', $invite->config['queue_time'] % 60);
				
				foreach ($lang_ary as $iso => $data)
				{
					foreach ($INVITE_MESSAGE_TYPE as $string => $int)
					{
						// Insert non-existing entries in database
						$sql 		= 'SELECT COUNT(language_iso) AS check_exist FROM ' . INVITE_MESSAGE_TABLE . ' WHERE language_iso = "' . $db->sql_escape($iso) . '" AND message_type = ' . (int) $int;
						$result		= $db->sql_query($sql);
						$count 		= (int) $db->sql_fetchfield('check_exist');
						
						if (!$count)
						{
							$sql_ary = array(
								'language_iso'	=> $iso,
								'message_type'	=> $int,
								'message'		=> $iso . '_' . $user->lang['INVITE_' . strtoupper(array_search($int, $INVITE_MESSAGE_TYPE))],
							);
							
							$sql = 'INSERT INTO ' . INVITE_MESSAGE_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary);
							$db->sql_query($sql);
						}
						$db->sql_freeresult($result);
						
						// Fill $message_ary with the messages located in database
						// example# array ( 'iso' => array ( int => 'message', int => 'message', ),)
						$message_ary[$iso][$int]	= utf8_normalize_nfc(request_var($string . '_' . $iso, $invite->load_message($iso, $int, true), true));
					}
				}
				
				/*
				* Delete languages, which are not used anymore
				* Not necessary as old languages are simply not displayed in language select
				*
				$lang_update		= (request_var('lang_update', '')) ? true : false;
				
				if ($lang_update)
				{
					$lang_database 	= array();
					
					$sql 			= 'SELECT DISTINCT language_iso FROM ' . INVITE_MESSAGE_TABLE;
					$result			= $db->sql_query($sql);
					
					while ($row = $db->sql_fetchrow($result))
					{
						$lang_database[] = $row['language_iso'];
					}
					$db->sql_freeresult($result);
					
					foreach ($lang_database as $key => $iso)
					{
						$sql 		= 'SELECT COUNT(lang_id) AS check_exist FROM ' . LANG_TABLE . ' WHERE lang_iso = "' . $db->sql_escape($iso) . '"';
						$result		= $db->sql_query($sql);
						$lang_exist = (int) $db->sql_fetchfield('check_exist');
						$db->sql_freeresult($result);
						
						if (!$lang_exist)
						{
							$sql 		= 'DELETE FROM ' . INVITE_MESSAGE_TABLE . ' WHERE language_iso = "' . $db->sql_escape($iso) . '"';
							$result		= $db->sql_query($sql);
						}
					}
				}
				*/
				
				if ($submit)
				{
					$new_config['queue_time']= $queue_time_s + ($queue_time_m * 60);
					
					$check_ary = array(
						'queue_time'				=> array('num', true, 1, 9999999999),
						'message_min_chars'			=> array('num', true, 1, 9999),
						'message_max_chars'			=> array('num', false, 1, 9999),
						'subject_min_chars'			=> array('num', false, 1, 999),
						'subject_max_chars'			=> array('num', false, 1, 999),
						'limit_invite_day'			=> array('num', true, 0, 99999),
						'limit_invite_day_posts'	=> array('num', true, 0, 99999),
						'limit_invite_day_topics'	=> array('num', true, 0, 99999),
						'limit_invite_user'			=> array('num', true, 0, 99999),
						'limit_invite_user_posts'	=> array('num', true, 0, 99999),
						'limit_invite_user_topics'	=> array('num', true, 0, 99999),
					);
					$error = validate_data($new_config, $check_ary);
					
					// Empty messages?
					foreach ($lang_ary as $iso => $data)
					{
						foreach ($INVITE_MESSAGE_TYPE as $string => $int)
						{
							if (empty($message_ary[$iso][$int]))
							{
								$error[] = $user->lang['ERROR_MESSAGE_' . strtoupper($string)];
								
								// Message errors are more important than others, so we display the message error
								$message_error = true;
							}
						}
					}
					
					// No errors.. continue!
					if (!sizeof($error))
					{
						foreach ($new_config as $k => $v)
						{
							$invite->set_config($k, $v);
						}
						foreach ($message_ary as $iso => $data)
						{
						
							$invite->set_config($iso, $data, true);
						}
						
						add_log('admin', 'LOG_INVITE_SETTINGS_UPDATED');
						trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
					}
					
					// Replace "error" strings with their real, localised form
					$error = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$user->lang['\\1'])) ? \$user->lang['\\1'] : '\\1'", $error);
				}
				
				// TEMPLATE
				
				foreach ($new_config as $k => $v)
				{
					$template->assign_vars(array(
						'S_' . strtoupper($k)	=> $v,
					));
				}
				
				// Handle messages
				foreach ($INVITE_MESSAGE_TYPE as $parent_string => $parent_int)
				{
					foreach ($message_ary as $iso => $data)
					{
						if ($user->data['user_lang'] == $iso && !$block_assigned)
						{
							$style_display		= 'block';
							$block_assigned 	= true;
						}
						else
						{
							$style_display		= 'none';
						}
						
						$assign_block_ary 	= array(
							'S_STYLE_DISPLAY'	=> $style_display,
							'LANGUAGE'			=> $iso,
							'MESSAGE_TYPE'		=> $parent_string,
						);
						
						// Add message types => message
						foreach ($INVITE_MESSAGE_TYPE as $string => $int)
						{
							$assign_block_ary[strtoupper($string)] = $data[$int];
							
							if ($assign_block_ary['MESSAGE_TYPE'] == $string)
							{
								$assign_block_ary['MESSAGE'] = $assign_block_ary[strtoupper($string)];
							}
						}
						
						$template->assign_block_vars('message', $assign_block_ary);
					}
					
					$template->assign_block_vars('explain', array(
						'EXPLAIN_TYPE'		=> $parent_string,
						'EXPLAIN_TEXT'		=> $user->lang['SETTINGS_MESSAGE_' . strtoupper($parent_string) . '_EXPLAIN'],
					));
				}
				
				$template->assign_vars(array(
					// Display all errors: 'ERROR'		=> (sizeof($error)) ? implode('<br />', $error) : '',
					'ERROR'						=> (sizeof($error) && !$message_error) ? $user->lang['ERROR_INVITE_SETTINGS'] : (sizeof($error) && $message_error) ? array_pop($error) : '',
					
					'S_VALUE_EMAIL'				=> EMAIL,
					'S_VALUE_PM'				=> PM,
					'S_VALUE_OPTIONAL'			=> OPTIONAL,
					
					'S_GROUP_SELECT'			=> group_select_options($new_config['key_group'], false, 0), // Show groups not managed by founders
					'S_EMAIL_ENABLE'			=> ($config['email_enable']) ? true : false,
					'S_SELECT_LANGUAGE'			=> language_select($user->data['user_lang']),
					'S_SELECT_MESSAGE'			=> $this->build_select('message', $INVITE_MESSAGE_TYPE),
					'S_SELECT_PROFILE_LOCATION'	=> $this->build_select('profile_location'),
					'S_SELECT_PROFILE_TYPE'		=> $this->build_select('profile_type'),
					'S_QUEUE_TIME_M'			=> $queue_time_m,
					'S_QUEUE_TIME_S'			=> $queue_time_s,
					
					'U_ACTION'					=> $this->u_action,
				));
				
				// ####### PLUGINS ########
				if ($invite->cash_installed())
				{
					global $cash;
					
					$template->assign_vars(array(
						'S_CASH_INSTALLED'				=> true,
						
						'S_CASH_CURRENCY_INVITE'	=> $cash->get_currencies($invite->config['cash_id_invite'], true),
						'S_CASH_CURRENCY_REGISTER'	=> $cash->get_currencies($invite->config['cash_id_register'], true),
					));
				}
				
				if ($invite->points_installed())
				{
					$template->assign_vars(array(
						'S_POINTS_INSTALLED'			=> true,
					));
				}
			break;
			
			case 'log':
				// Set up general vars
				$this->log_type		= LOG_INVITE;
				$entries_per_page	= LOG_ENTRIES_PER_PAGE;
				
				$start				= request_var('start', 0);
				$show_info			= request_var('info', 0);
				$marked				= request_var('mark', array(0));
				$deletemark 		= (isset($_POST['delmarked'])) ? true : false;
				$deleteall			= (isset($_POST['delall'])) ? true : false;
				
				// Sort keys
				$sort_days	= request_var('st', 0);
				$sort_key	= request_var('sk', 't');
				$sort_dir	= request_var('sd', 'd');
				$sort_user	= request_var('ui', '', true);
				
				// Delete entries if requested and able
				if (($deletemark || $deleteall) && $auth->acl_get('a_clearlogs'))
				{
					if (confirm_box(true))
					{
						$where_sql = '';

						if ($deletemark && sizeof($marked))
						{
							$sql_in = array();
							foreach ($marked as $mark)
							{
								$sql_in[] = $mark;
							}
							$where_sql = ' AND ' . $db->sql_in_set('log_id', $sql_in);
							unset($sql_in);
						}

						if ($where_sql || $deleteall)
						{
							$sql = 'DELETE FROM ' . LOG_TABLE . "
								WHERE log_type = {$this->log_type}
								$where_sql";
							$db->sql_query($sql);
						}
					}
					else
					{
						confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
							'start'		=> $start,
							'delmarked'	=> $deletemark,
							'delall'	=> $deleteall,
							'mark'		=> $marked,
							'st'		=> $sort_days,
							'sk'		=> $sort_key,
							'sd'		=> $sort_dir,
							'i'			=> $id,
							'mode'		=> $mode,
							'action'	=> $action))
						);
					}
				}
				
				// Sorting
				$limit_days 	= array(0 => $user->lang['ALL_ENTRIES'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
				$sort_by_text	= array('u' => $user->lang['SORT_USERNAME'], 't' => $user->lang['SORT_DATE'], 'i' => $user->lang['SORT_IP'], 'o' => $user->lang['SORT_ACTION']);
				$sort_by_sql 	= array('u' => 'u.username_clean', 't' => 'l.log_time', 'i' => 'l.log_ip', 'o' => 'l.log_operation');
				
				$s_limit_days 	= $s_sort_key = $s_sort_dir = $u_sort_param = '';
				gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

				// Define where and sort sql for use in displaying logs
				$sql_where 	= ($sort_days) ? (time() - ($sort_days * 86400)) : 0;
				$sql_sort 	= $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
				$sql_user	= $invite->user_return_data($db->sql_escape(utf8_clean_string($sort_user)));
				
				// Grab log data
				$log_data 	= array();
				$log_count 	= 0;
				view_log('invite', $log_data, $log_count, $entries_per_page, $start, $sql_user, 0, 0, $sql_where, $sql_sort);
				
				$u_sort_param	.= ($show_info) ? "&amp;info=$show_info" : '';
				$u_sort_param	.= ($sql_user) ? "&amp;ui=$sort_user" : '';
				$log_count		= ($sql_user) ? $log_count : (($sort_user) ? 0 : $log_count);
				
				$template->assign_vars(array(
					'U_ACTION'		=> $this->u_action,
					
					'S_ON_PAGE'		=> on_page($log_count, $entries_per_page, $start),
					'PAGINATION'	=> generate_pagination($this->u_action . "&amp;$u_sort_param", $log_count, $entries_per_page, $start, true),
					
					'S_LIMIT_DAYS'	=> $s_limit_days,
					'S_SORT_KEY'	=> $s_sort_key,
					'S_SORT_DIR'	=> $s_sort_dir,
					'S_SORT_USER'	=> ($sort_user) ? $sort_user : '',
					'S_CLEARLOGS'	=> $auth->acl_get('a_clearlogs'),
					'S_SHOW_INFO'	=> ($show_info) ? true : false,
					'S_USER_ENTRY'	=> (empty($sort_user)) ? true : $sql_user,
				));
				
				if ($show_info)
				{
					$info = $invite->get_profile_info($show_info);
					
					$template->assign_vars(array(
						'INFO_USERNAME'			=> $info['username_full'],
						'INFO_INVITATIONS'		=> $info['invitations'],
						'INFO_REGISTRATIONS'	=> $info['registrations'],
						'INFO_REG_USERS'		=> $info['reg_users'],
					));
				}
				
				foreach ($log_data as $row)
				{
					// Remove info to fix the bug 'Invitation log - Details'
					$u_sort_param	= ($show_info) ? str_replace("&amp;info=$show_info", '', $u_sort_param) : $u_sort_param;
					$data			= array();
					
					$template->assign_block_vars('log', array(
						'USERNAME'			=> $row['username_full'],
						'REPORTEE_USERNAME'	=> ($row['reportee_username'] && $row['user_id'] != $row['reportee_id']) ? $row['reportee_username_full'] : '',

						'IP'				=> $row['ip'],
						'DATE'				=> $user->format_date($row['time']),
						'ACTION'			=> $row['action'],
						'DATA'				=> (sizeof($data)) ? implode(' | ', $data) : '',
						'ID'				=> $row['id'],
						'INFO'				=> append_sid("{$phpbb_admin_path}index.$phpEx", 'i=invite&amp;mode=log&amp;info=' . $row['id'] . "&amp;$u_sort_param&amp;start=$start"),
						)
					);
				}
			break;
		}
	}
	
	function build_select($mode, $INVITE_MESSAGE_TYPE = '')
	{
		global $user;
		
		switch ($mode)
		{
			case 'message':
				$arrray = array();
				
				foreach ($INVITE_MESSAGE_TYPE as $string => $int)
				{
					$array['INVITE_' . strtoupper($string)] = $string;
				}
			break;
			
			case 'profile_location':
				$array = array(
					'VIEWTOPIC'			=> 't',
					'MEMBERLIST_VIEW'	=> 'p',
				);
			break;
			
			case 'profile_type':
				$array = array(
					'DISPLAY_INVITE'	=> 'invite',
					'DISPLAY_REGISTER'	=> 'register',
					'DISPLAY_NAME'		=> 'name',
				);
			break;
		}
		
		$select = '';
		foreach ($array as $k => $v)
		{
			$select .= '<option value="' . $v . '">' . $user->lang[$k] . '</option>';
		}
		
		return $select;
	}
}
?>