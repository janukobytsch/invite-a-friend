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
		global $db, $user, $auth, $template, $cache, $phpEx;
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
		
		// ########### Remove this later!!!!!!######################################
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
		// ##############################################################
		
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
					
					'S_CASH_INSTALLED'	=> $invite->cash_installed(),
					'S_MESSAGE'			=> $message,
					'S_CONFIRM_MESSAGE'	=> $confirm_message,
					'U_ACTION'			=> $this->u_action,
				));
				
				if ($invite->cash_installed())
				{
					global $cash;
					$user->add_lang('mods/cash_mod');
					
					$template->assign_vars(array(
						'S_CASH_INSTALLED'				=> true,
						
						'S_CASH_INVITATION_CURRENCY'	=> $cash->get_currencies($iaf_config['cash_id_invitation'], true),
						'S_CASH_REGISTRATION_CURRENCY'	=> $cash->get_currencies($iaf_config['cash_id_registration'], true),
					));
				}
			break;
			
			case 'log':
				// Set up general vars
				$this->log_type		= LOG_INVITE;
				
				$start				= request_var('start', 0);
				$show_info			= request_var('info', 0);
				$deletemark 		= (!empty($_POST['delmarked'])) ? true : false;
				$deleteall			= (!empty($_POST['delall'])) ? true : false;
				$marked				= request_var('mark', array(0));
				$entries_per_page	= LOG_ENTRIES_PER_PAGE;
				
				// Sort keys
				$sort_days	= request_var('st', 0);
				$sort_key	= request_var('sk', 't');
				$sort_dir	= request_var('sd', 'd');
				
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
				$limit_days = array(0 => $user->lang['ALL_ENTRIES'], 1 => $user->lang['1_DAY'], 7 => $user->lang['7_DAYS'], 14 => $user->lang['2_WEEKS'], 30 => $user->lang['1_MONTH'], 90 => $user->lang['3_MONTHS'], 180 => $user->lang['6_MONTHS'], 365 => $user->lang['1_YEAR']);
				$sort_by_text = array('u' => $user->lang['SORT_USERNAME'], 't' => $user->lang['SORT_DATE'], 'i' => $user->lang['SORT_IP'], 'o' => $user->lang['SORT_ACTION']);
				$sort_by_sql = array('u' => 'u.username_clean', 't' => 'l.log_time', 'i' => 'l.log_ip', 'o' => 'l.log_operation');

				$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
				gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);

				// Define where and sort sql for use in displaying logs
				$sql_where = ($sort_days) ? (time() - ($sort_days * 86400)) : 0;
				$sql_sort = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');
		
				// Grab log data
				$log_data = array();
				$log_count = 0;
				view_log('invite', $log_data, $log_count, $entries_per_page, $start, 0, 0, 0, $sql_where, $sql_sort);
				
				$template->assign_vars(array(
					'U_ACTION'		=> $this->u_action,
					
					'S_ON_PAGE'		=> on_page($log_count, $entries_per_page, $start),
					'PAGINATION'	=> generate_pagination($this->u_action, $log_count, $entries_per_page, $start, true),
					
					'S_LIMIT_DAYS'	=> $s_limit_days,
					'S_SORT_KEY'	=> $s_sort_key,
					'S_SORT_DIR'	=> $s_sort_dir,
					'S_CLEARLOGS'	=> $auth->acl_get('a_clearlogs'),
					'S_SHOW_INFO'	=> ($show_info) ? true : false,
				));
				
				if ($show_info)
				{
					$info	= $invite->get_info($show_info);
					
					$template->assign_vars(array(
						'INFO_USERNAME'			=> $info['username_full'],
						'INFO_INVITATIONS'		=> $info['invitations'],
						'INFO_REGISTRATIONS'	=> $info['registrations'],
						'INFO_REG_USERS'			=> $info['reg_users'],
					));
				}
				
				foreach ($log_data as $row)
				{
					$data = array();
					
					$template->assign_block_vars('log', array(
						'USERNAME'			=> $row['username_full'],
						'REPORTEE_USERNAME'	=> ($row['reportee_username'] && $row['user_id'] != $row['reportee_id']) ? $row['reportee_username_full'] : '',

						'IP'				=> $row['ip'],
						'DATE'				=> $user->format_date($row['time']),
						'ACTION'			=> $row['action'],
						'DATA'				=> (sizeof($data)) ? implode(' | ', $data) : '',
						'ID'				=> $row['id'],
						'INFO'				=> append_sid("{$phpbb_admin_path}index.$phpEx", 'i=invite&amp;mode=log&amp;info=' . $row['id']),
						)
					);
				}
			break;
		}
	}
}
?>