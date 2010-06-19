<?php
/**
*
* @author Bycoja bycoja@web.de
* @package acp
* @version $Id acp_invite.php 0.6.1 2010-04-05 15:14:09GMT Bycoja $
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

		include ($phpbb_root_path . 'includes/functions_user.' . $phpEx);
		include ($phpbb_root_path . 'includes/functions_invite.' . $phpEx);

		$user->add_lang(array('ucp', 'mods/info_acp_invite', 'acp/board', 'acp/email'));

		$invite	= new invite();
		$action	= request_var('action', '');
		$submit	= (isset($_POST['submit'])) ? true : false;
		$error	= array();

		foreach ($invite->config as $k => $v)
		{
			$new_config[$k] = utf8_normalize_nfc(request_var($k, $v, true));
		}

		$form_key = 'acp_invite';
		add_form_key($form_key);

		switch ($mode)
		{
			case 'settings':

				$this->page_title = 'ACP_INVITE_SETTINGS';
				$this->tpl_name = 'acp_invite';

				$queue_time_m = request_var('queue_time_m', floor($invite->config['queue_time'] / 60));
				$queue_time_s = request_var('queue_time_s', $invite->config['queue_time'] % 60);

				if ($submit)
				{
					$new_config['queue_time'] = $queue_time_s + ($queue_time_m * 60);

					$check_ary = array(
						'queue_time'				=> array('num', true, 1, 9999999999),
						'message_min_chars'			=> array('num', true, 1, 9999),
						'message_max_chars'			=> array('num', false, 1, 9999),
						'subject_min_chars'			=> array('num', false, 1, 999),
						'subject_max_chars'			=> array('num', false, 1, 999),
					);
					$error = validate_data($new_config, $check_ary);

					if (!check_form_key($form_key))
					{
						$error[] = $user->lang['FORM_INVALID'];
					}

					// No errors.. continue!
					if (!sizeof($error))
					{
						foreach ($new_config as $k => $v)
						{
							$invite->set_config($k, $v);
						}

						add_log('admin', 'LOG_INVITE_SETTINGS_UPDATED');
						trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
					}

					// Replace "error" strings with their real, localised form
					$error = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$user->lang['\\1'])) ? \$user->lang['\\1'] : '\\1'", $error);
				}

				// TEMPLATE

				// We'd better display a warning...
				if (!$config['email_enable'])
				{
					$error[] = sprintf($user->lang['ERROR_EMAIL_DISABLED'], append_sid("{$phpbb_admin_path}index.$phpEx?i=board&amp;mode=email"));
				}

				foreach ($new_config as $k => $v)
				{
					$template->assign_vars(array(
						'S_' . strtoupper($k)	=> $v,
					));
				}

				$template->assign_vars(array(
					// Display all errors: 'ERROR'		=> (sizeof($error)) ? implode('<br />', $error) : '',
					'ERROR'						=> (sizeof($error)) ? array_pop($error) : '',

					'S_VALUE_EMAIL'				=> EMAIL,
					'S_VALUE_PM'				=> PM,
					'S_VALUE_OPTIONAL'			=> OPTIONAL,

					'S_GROUP_SELECT'			=> group_select_options($new_config['key_group'], false, 0), // Show groups not managed by founders
					'S_EMAIL_ENABLE'			=> ($config['email_enable']) ? true : false,
					'S_SELECT_LANGUAGE'			=> $this->build_select('language', '', $new_config['invite_language_select']),
					'S_SELECT_PROFILE_LOCATION'	=> $this->build_select('profile_location'),
					'S_SELECT_PROFILE_TYPE'		=> $this->build_select('profile_type'),
					'S_PRIORITY_OPTIONS'		=> $this->build_select('priority', '', $new_config['invite_priority_flag']),
					'S_QUEUE_TIME_M'			=> $queue_time_m,
					'S_QUEUE_TIME_S'			=> $queue_time_s,

					'U_ACTION'					=> $this->u_action,
				));

				if ($invite->ultimate_points_installed())
				{
					$template->assign_vars(array(
						'S_ULTIMATE_POINTS_INSTALLED' => true,
					));
				}

				if ($invite->cash_installed())
				{
					global $cash;

					$template->assign_vars(array(
						'S_CASH_INSTALLED' => true,

						'S_CASH_CURRENCY_INVITE'	=> $cash->get_currencies($invite->config['cash_id_invite'], true),
						'S_CASH_CURRENCY_REGISTER'	=> $cash->get_currencies($invite->config['cash_id_register'], true),
					));
				}

			break;

			case 'templates':

				$this->page_title = 'ACP_INVITE_TEMPLATES';
				$this->tpl_name = 'acp_invite_templates';

				$select = (isset($_POST['select'])) ? true : false;

				$tpl_type = request_var('template_type', '', true);
				$tpl_lang = request_var('template_language', $user->data['user_lang'], true);
				$tpl_subject = ($select) ? $invite->get_template("{$tpl_type}_subject.txt", $tpl_lang) : '';
				$tpl_message = ($select) ? $invite->get_template("{$tpl_type}_message.txt", $tpl_lang) : '';

				if ($submit)
				{
					$tpl_subject = request_var('template_subject', $invite->get_template("{$tpl_type}_subject.txt", $tpl_lang), true);
					$tpl_message = request_var('template_message', $invite->get_template("{$tpl_type}_message.txt", $tpl_lang), true);

					if (!check_form_key($form_key))
					{
						$error[] = $user->lang['FORM_INVALID'];
					}

					// No errors.. continue!
					if (!sizeof($error))
					{
						$invite->set_template($tpl_subject, "{$tpl_type}_subject.txt", $tpl_lang);
						$invite->set_template($tpl_message, "{$tpl_type}_message.txt", $tpl_lang);

						add_log('admin', 'LOG_INVITE_TEMPLATES_UPDATED');
						trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
					}
				}

				// Output wildcard tables
				$wildcards['general'] = $this->print_wildcard_array($invite, 'general');
				$wildcards['user'] = $this->print_wildcard_array($invite, 'user');

				foreach ($wildcards as $type => $data)
				{
					foreach ($data as $wildcard => $example_value)
					{
						$template->assign_block_vars($type . '_wildcards', array(
							'WILDCARD'		=> $wildcard,
							'EXAMPLE_VALUE'	=> $example_value,
						));
					}
				}

				$template->assign_vars(array(
					// Display all errors: 'ERROR'	=> (sizeof($error)) ? implode('<br />', $error) : '',
					'ERROR'				=> (sizeof($error)) ? array_pop($error) : '',
					'TEMPLATE_SUBJECT'	=> $tpl_subject,
					'TEMPLATE_MESSAGE'	=> $tpl_message,
					
					'S_EDIT_TEMPLATE' 				=> ($select) ? true : false,
					'S_TEMPLATE_TYPE_SELECT'		=> $this->build_select('message', $invite->INVITE_MESSAGE_TYPE, $tpl_type),
					'S_TEMPLATE_LANGUAGE_SELECT'	=> language_select($tpl_lang),
				));

			break;

			case 'log':

				$this->page_title	= 'ACP_INVITE_LOG';
				$this->tpl_name		= 'acp_invite_log';
				$this->log_type		= LOG_INVITE;

				$start				= request_var('start', 0);
				$show_info			= request_var('info', 0);
				$marked				= request_var('mark', array(0));
				$filter				= request_var('filter', 'all');
				$deletemark 		= (isset($_POST['delmarked'])) ? true : false;
				$deleteall			= (isset($_POST['delall'])) ? true : false;
				$entries_per_page	= 25;

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
						add_log('admin', 'LOG_INVITE_LOG_CLEARED');
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
				$sql_user	= $invite->user_return_data($db->sql_escape(utf8_clean_string($sort_user)), 'username_clean', 'user_id');

				// Grab log data
				$log_data 	= array();
				$log_count 	= 0;
				view_log('invite', $log_data, $log_count, $entries_per_page, $start, $sql_user, $filter, $sql_user, $sql_where, $sql_sort);

				$u_sort_param	.= ($sql_user) ? "&amp;ui=$sort_user" : '';
				$log_count		= ($sql_user) ? $log_count : (($sort_user) ? 0 : $log_count);

				$template->assign_vars(array(
					'U_ACTION'		=> $this->u_action,

					'S_FILTER'		=> $this->build_select('filter', '', $filter),
					'S_ON_PAGE'		=> on_page($log_count, $entries_per_page, $start),
					'PAGINATION'	=> generate_pagination($this->u_action . "&amp;$u_sort_param", $log_count, $entries_per_page, $start, true),

					'S_LIMIT_DAYS'	=> $s_limit_days,
					'S_SORT_KEY'	=> $s_sort_key,
					'S_SORT_DIR'	=> $s_sort_dir,
					'S_SORT_USER'	=> ($sort_user) ? $sort_user : '',
					'S_CLEARLOGS'	=> $auth->acl_get('a_clearlogs'),
					'S_USER_ENTRY'	=> (empty($sort_user)) ? true : $sql_user,
				));

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
						)
					);
				}

			break;
		}
	}

	function build_select($mode, $INVITE_MESSAGE_TYPE = '', $selected = '')
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
					'MEMBERLIST'		=> 'm',
				);
			break;

			case 'profile_type':
				$array = array(
					'DISPLAY_INVITER'	=> 'inviter',
					'DISPLAY_INVITE'	=> 'invite',
					'DISPLAY_REGISTER'	=> 'register',
				);
			break;

			case 'language':
				$array = array();
			break;

			case 'priority':
				$array = array(
					'OPTIONAL'				=> MAIL_LOW_PRIORITY + 1,
					'MAIL_LOW_PRIORITY'		=> MAIL_LOW_PRIORITY,
					'MAIL_NORMAL_PRIORITY'	=> MAIL_NORMAL_PRIORITY,
					'MAIL_HIGH_PRIORITY'	=> MAIL_HIGH_PRIORITY,
				);
			break;

			case 'filter':
				$array = array(
					'LOG_FILTER_ALL'		=> 'all',
					'LOG_FILTER_INVITE'		=> 'invite',
					'LOG_FILTER_CONFIRM'	=> 'confirm',
					'LOG_FILTER_REGISTER'	=> 'register',
					'LOG_FILTER_ZEBRA'		=> 'zebra',
				);
			break;

			default:
			break;
		}

		$select = '';
		foreach ($array as $k => $v)
		{
			$mark = ($selected == $v) ? ' selected="selected"' : '';

			$select .= '<option value="' . $v . '"' . $mark . '>' . $user->lang[$k] . '</option>';
		}

		// Language select
		$mark = ($selected == 'opt') ? ' selected="selected"' : '';
		$select .= ($mode == 'language') ? '<option value="opt"' . $mark . '>' . $user->lang['OPTIONAL'] . '</option>' : '';
		$mark = ($selected == 'user') ? ' selected="selected"' : '';
		$select .= ($mode == 'language') ? '<option value="user"' . $mark . '>' . $user->lang['USER_LANGUAGE'] . '</option>' : '';
		$select .= ($mode == 'language') ? language_select($selected) : '';

		return $select;
	}

	function print_wildcard_array($invite, $mode)
	{
		global $config, $user, $phpEx;

		$arrray = array();

		switch ($mode)
		{
			case 'general':
				$wildcards['USER_SUBJECT'] = $wildcards['USER_MESSAGE'] = $user->lang['USER_DEFINED'];
				$wildcards['REGISTRATION_KEY'] = $invite->create_key();
				$wildcards['REGISTRATION_URL'] = generate_board_url() . '/ucp.' . $phpEx . '?mode=register&referral=' . urlencode($user->data['username']) . '&key=' . $wildcards['REGISTRATION_KEY'];
				$wildcards['SITENAME'] = htmlspecialchars_decode($config['sitename']);
				$wildcards['CONTACT_EMAIL'] = $config['board_contact'];
				$wildcards['BOARD_URL'] = generate_board_url();
			break;

			case 'user':
				// Show only the most important ones as there's a lot of boring crap in users table
				$user_wildcards = array('user_id', 'username', 'username_clean', 'user_ip', 'user_email', 'user_posts', 'user_lang', 'user_from', 'user_icq', 'user_aim', 'user_yim', 'user_msnm', 'user_jabber', 'user_website', 'user_occ', 'user_interests', 'user_inviter_id', 'user_inviter_name', 'user_invitations', 'user_registrations');

				$wildcards['INVITED_USER_PROFILE_URL'] = generate_board_url() . '/memberlist.' . $phpEx . '?mode=viewprofile&u=' . $user->data['user_id'];
				$wildcards['RECIPIENT_NAME'] = $user->lang['USER_DEFINED'];

				foreach ($user->data as $k => $v)
				{
					if (array_search($k, $user_wildcards))
					{
						$wildcards['INVITER_' . strtoupper($k)] = $v;
						$wildcards['INVITED_' . strtoupper($k)] = $v;
					}
				}
			break;

			default:
			break;
		}

		return $wildcards;
	}
}
?>