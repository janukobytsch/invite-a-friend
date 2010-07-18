<?php
/**
*
* @author Bycoja bycoja@web.de
* @package ucp
* @version $Id ucp_iaf.php 0.7.0 2010-06-22 17:28:02GMT Bycoja $
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
* ucp_invite
* @package ucp
*/
class ucp_invite
{
	var $u_action;

	function main($id, $mode)
	{
		global $config, $db, $user, $auth, $template;
		global $phpbb_admin_path, $phpbb_root_path, $phpEx;

		include($phpbb_root_path . 'includes/functions_invite.' . $phpEx);
		$user->add_lang(array('acp/email'));

		$invite			= new invite();
		$submit			= (isset($_POST['submit'])) ? true : false;
		$remove_rc		= (isset($_POST['remove_rc'])) ? true : false;
		$add_rc			= (isset($_POST['add_rc'])) ? true : false;
		$disable_form	= false;
		$sent			= false;
		$error 			= array();
		$email_ary 		= array();

		// CAPTCHA
		$confirm_id			= request_var('confirm_id', '');
		$s_hidden_fields	= ($confirm_id) ? array('confirm_id' => $confirm_id) : array();

		// Handle multiple recipients
		$recipient_count	= (int) request_var('rc', 1);
		$recipient_count	= ($add_rc) ? $recipient_count + 1 : $recipient_count;
		$recipient_count	= ($remove_rc) ? $recipient_count - 1 : $recipient_count;
		$recipient_count	= ($recipient_count < 1 || !$auth->acl_get('u_multiple_recipients')) ? 1 : $recipient_count;

		if (!$auth->acl_get('m_ignore_recipients_limit'))
		{
			$recipient_count = ($invite->config['multiple_recipients_max'] <= $recipient_count) ? $invite->config['multiple_recipients_max'] : $recipient_count;
		}
		$s_hidden_fields['rc']	= $recipient_count;

		$form_key = 'ucp_invite';
		add_form_key($form_key);

		// Several checks
		if (!$auth->acl_get('u_send_invitations'))
		{
		    trigger_error('NOT_AUTHORISED');
		}

		if (!$config['email_enable'])
		{
			trigger_error('EMAILS_DISABLED');
		}

		if (!$invite->config['enable'])
		{
			trigger_error('INVITATIONS_DISABLED');
		}

		// Do we have to wait?
		if ($user->data['user_invitations'] && !$auth->acl_get('m_ignore_invitation_queue'))
		{
			$sql = 'SELECT MAX(invite_time) AS max_time FROM ' . INVITE_LOG_TABLE . ' WHERE invite_user_id = ' . $user->data['user_id'];
			$result = $db->sql_query($sql);
			$last_invite = (int) $db->sql_fetchfield('max_time');
			$db->sql_freeresult();

			if ((time() - $last_invite) < $invite->config['queue_time'])
			{
				$queue_time_m	= floor(($invite->config['queue_time'] - (time() - $last_invite)) / 60);
				$queue_time_s	= ($invite->config['queue_time'] - (time() - $last_invite)) % 60;
				$error[] 		= sprintf($user->lang['QUEUE_QUEUE'], $queue_time_m, $queue_time_s);
				$disable_form	= true;
			}
		}

		// Have we reached the invitation limit? @todo admin-specified $limit_periods (limitation rules)
		$limit_enabled	= false;
		$limit_periods 	= array('limit_daily', 'limit_total');
		$limit_criteria	= array('posts', 'topics', 'memberdays', 'registrations', 'referrals');

		foreach ($limit_periods as $k => $v)
		{
			if ($invite->config['enable_' . $v])
			{
				$limit_enabled = true;
			}
		}

		// Are we allowed to exceed the limits?
		if ($auth->acl_get('m_ignore_invitation_limit'))
		{
			$limit_enabled = false;
		}

		if ($limit_enabled)
		{
			// Invitations sent today (last 24h)
			$last_day = time() - 86400;
			$sql = 'SELECT COUNT(log_id) AS invitations_today FROM ' . INVITE_LOG_TABLE . ' WHERE invite_user_id = ' . $user->data['user_id'] . ' AND invite_time >= ' . $last_day;
			$result = $db->sql_query($sql);
			$user->data['user_invitations_limit_daily'] = (int) $db->sql_fetchfield('invitations_today');
			$db->sql_freeresult();

			// Invitations sent altogether
			$user->data['user_invitations_limit_total'] = $user->data['user_invitations'];

			// Number of topics created
			$sql = 'SELECT COUNT(topic_id) AS user_topics FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . $user->data['user_id'];
			$result = $db->sql_query($sql);
			$user->data['user_topics'] = (int) $db->sql_fetchfield('user_topics');
			$db->sql_freeresult();

			// Days of membership
			$user->data['user_memberdays'] = floor((time() - $user->data['user_regdate']) / 86400);

			// Calculate the available amount of invitations
			foreach ($limit_periods as $k => $v)
			{
				if ($invite->config['enable_' . $v])
				{
					$user->data['user_' . $v] = (int) $invite->config[$v . '_basic'];

					foreach ($limit_criteria as $ck => $cv)
					{
						// Don't divide by zero
						$user->data['user_' . $v] += ($invite->config[$v . '_' . $cv] == 0) ? 0 : floor($user->data['user_' . $cv] / $invite->config[$v . '_' . $cv]) * $invite->config[$v . '_' . $cv . '_invitations'];
					}

					// Single recipient
					if ($user->data['user_invitations_' . $v] >= $user->data['user_' . $v])
					{
						$error[] = sprintf($user->lang['INVITATION_' . strtoupper($v)], $user->data['user_' . $v]);
						$disable_form = true;
					}

					// Multiple recipients
					if ($recipient_count > 1 && (($user->data['user_invitations_' . $v] + $recipient_count) > $user->data['user_' . $v]))
					{
						// $reduce = $recipient_count - ($user->data['user_' . $v] - $user->data['user_invitations_' . $v]);
						$error[] = sprintf($user->lang['REDUCE_RECIPIENTS']) . ' ' . sprintf($user->lang['INVITATION_' . strtoupper($v) . '_MULTI'], $user->data['user_invitations_' . $v], $user->data['user_' . $v], $recipient_count);
						$disable_form = true;
					}
				}
			}
		}

		// Check whether we have enough money to pay the fee
		$charge_fee = ($auth->acl_get('m_ignore_invitation_fee')) ? false : true;

		if ($charge_fee)
		{
			foreach ($invite->plugins as $plugin_name => $plugin)
			{
				if ($invite->config['enable_' . $plugin_name])
				{
					$available_credit = $invite->handle_credit('checkout', '', $user->data['user_id']);

					if (($available_credit - $invite->config[$plugin_name . '_fee'] * $recipient_count) < 0)
					{
						$disable_form 	= true;
						$rc_reduce 		= ($recipient_count != 1) ? sprintf($user->lang['REDUCE_RECIPIENTS']) : '';
						$error[] 		= sprintf($user->lang[strtoupper($plugin_name) . '_MISSING_CREDIT']) . ' ' . $rc_reduce;
					}
				}
			}
		}

		// Set up the array containing the important information
		$email_data	= array(
			'message_type'			=> $INVITE_MESSAGE_TYPE['invite'],
			'method'				=> EMAIL,
			'method_user_id'		=> $user->data['user_id'],
			'invite_language'		=> ($invite->config['invite_language_select'] == 'opt') ? utf8_normalize_nfc(request_var('form_invite_language_select', $user->data['user_lang'], true)) : (($invite->config['invite_language_select'] == 'user') ? $user->data['user_lang'] : $invite->config['invite_language_select']),
			'priority'				=> ($auth->acl_get('u_change_invitation_priority') && $invite->config['invite_priority_flag'] == MAIL_LOW_PRIORITY + 1) ? request_var('form_priority', 0) : $invite->config['invite_priority_flag'], // MAIL_LOW_PRIORITY + 1 equals optional
			'invite_real_name'		=> utf8_normalize_nfc(request_var('form_invite_real_name', '', true)),
			'subject'				=> utf8_normalize_nfc(request_var('form_subject', '', true)),
			'message'				=> utf8_normalize_nfc(request_var('form_message', '', true)),
			'register_key'			=> $invite->generate_key(),
			'register_key_used'		=> 0,
			'register_user_id'		=> 0,
			'invite_user_id'		=> $user->data['user_id'],
			'invite_session_ip'		=> $user->data['session_ip'],
			'invite_time'			=> time(),
			'invite_zebra'			=> ($auth->acl_get('u_add_invitation_friend')) ? request_var('form_invite_zebra', 0) : 0,
			'confirm_code'			=> request_var('confirm_code', ''),
			'confirm_id'			=> request_var('confirm_id', ''),
		);

		// Additional email data concerning the templates
		foreach ($INVITE_MESSAGE_TYPE as $string => $int)
		{
			$email_data['invite_' . $string] = request_var('form_invite_' . $string, 0);
			$email_data['invite_' . $string . '_method'] = request_var('form_invite_' . $string . '_method', 0);
		}

		// Can we receive confirmations?
		if (!$auth->acl_get('u_receive_confirmation'))
		{
			$email_data['invite_confirm'] = 0;
		}

		// The CAPTCHA kicks in here
		if ($invite->config['invite_confirm_code'] && !$auth->acl_get('m_ignore_invitation_captcha'))
		{
			if (!class_exists('phpbb_captcha_factory'))
			{
				include($phpbb_root_path . 'includes/captcha/captcha_factory.' . $phpEx);
			}

			$captcha =& phpbb_captcha_factory::get_instance($config['captcha_plugin']);
			$captcha->init(CONFIRM_POST);
		}

		// Prevalidate the static data so we don't have to do it in the loop later
		if ($submit)
		{
			if (!check_form_key($form_key))
			{
				$error[] = 'FORM_INVALID';
			}

			// Check for character limits
			if (!$auth->acl_get('m_ignore_characters_limit'))
			{
				$check_ary = array(
					'subject' => array('string', false, $invite->config['subject_min_chars'], $invite->config['subject_max_chars']),
					'message' => array('string', false, $invite->config['message_min_chars'], $invite->config['message_max_chars']),
				);
				$error = validate_data($email_data, $check_ary);
			}

			$check_ary = array(
				'invite_real_name' => array('string', false, 1, 60),
			);
			$error = validate_data($email_data, $check_ary);

			// Visual Confirmation handling
			if ($invite->config['invite_confirm_code'] && !$auth->acl_get('m_ignore_invitation_captcha'))
			{
				$vc_response = $captcha->validate($email_data);
				if ($vc_response !== false)
				{
					$error[] = $vc_response;
				}
			}
		}

		// Send out multiple invitations
		for ($i = 0; $i < $recipient_count; $i++)
		{
			// Add index specific values to the data array
			$form_register_email = utf8_normalize_nfc(request_var('form_register_email_' . $i, '', true));
			$form_register_real_name = utf8_normalize_nfc(request_var('form_register_real_name_' . $i, '', true));
			$email_data['register_email_' . $i] = $form_register_email;
			$email_data['register_real_name_'. $i] = $form_register_real_name;

			// Add every e-mail address to the referring array in order to search for multiple entries later
			$email_ary[] = $form_register_email;

			// No need to loop through the submit part...
			if (sizeof($error))
			{
				continue;
			}

			// Do the job ...
			if ($submit)
			{
				$email_data['register_email'] = $form_register_email;
				$email_data['register_real_name'] = $form_register_real_name;

				// Fix language vars defined in ucp.php
				$email_data['email'] = $email_data['register_email'];

				// Validate index specific data
				$check_ary = array(
					'email' => array(
						array('string', false, 1, 60),
						array('email')),
					'register_real_name' => array('string', false, 1, 60),
				);
				$error = validate_data($email_data, $check_ary);

				// Fix language vars defined in ucp.php
				unset($email_data['email']);

				// That wouldn't make any sense...
				if ($email_data['register_email'] == $user->data['user_email'])
				{
					$error[] = $user->lang['INVITE_TO_YOUR_EMAIL'];
				}

				// Have our recipients received an invitation yet?
				$sql 		= 'SELECT COUNT(log_id) AS multiple_invite FROM ' . INVITE_LOG_TABLE . ' WHERE register_email = "' . $email_data['register_email'] . '"';
				$result 	= $db->sql_query($sql);
				$multiple	= (int) $db->sql_fetchfield('multiple_invite');

				if ($multiple && !$invite->config['invite_multiple'])
				{
					$error[] = $user->lang['INVITE_MULTIPLE'];
				}

				if (!$invite->config['invite_multiple'])
				{
					$count_values = array_count_values($email_ary);

					if ($multiple)
					{
						$error[] = $user->lang['INVITE_MULTIPLE'];
					}

					foreach ($count_values as $k => $v)
					{
						if ($v > 1)
						{
							$error[] = $user->lang['INVITE_SAME_RECIPIENT'];
							break;
						}
					}
				}

				if (!sizeof($error))
				{
					$send_message = $invite->message_handle($email_data, true, false);
					$sent = true;

					// Email successfully sent to friend? Only check on last loop
					if ($i == ($recipient_count - 1))
					{
						if ($send_message)
						{
							meta_refresh(2, append_sid("{$phpbb_root_path}index.$phpEx"));
							$message = $user->lang['EMAIL_SENT_SUCCESS'];
						}
						else
						{
							$message = '<span class="error">' . $user->lang['EMAIL_SENT_FAILURE'] . '</span>';
						}
						$message .=  '<br /><br />' . sprintf($user->lang['RETURN_INDEX'], '<a href="' . append_sid("{$phpbb_root_path}index.$phpEx") . '">', '</a>');
						trigger_error($message);
					}
				}
				else
				{
					// No need to highlight the correct recipient block if there's only one...
					if ($recipient_count > 1)
					{
						$template->assign_var('S_ERROR_RECIPIENT_INDEX', $i);
					}
				}
			}
			unset($email_data['register_email']);
			unset($email_data['register_real_name']);
		}
		// Replace "error" strings with their real, localised form
		$error = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$user->lang['\\1'])) ? \$user->lang['\\1'] : '\\1'", $error);

		if ($invite->config['invite_confirm_code'] && !$auth->acl_get('m_ignore_invitation_captcha'))
		{
			$s_hidden_fields = array_merge($s_hidden_fields, $captcha->get_hidden_fields());
		}
		$s_hidden_fields = build_hidden_fields($s_hidden_fields);
		$confirm_image = '';

		// Visual Confirmation - Show images
		if ($invite->config['invite_confirm_code'] && !$auth->acl_get('m_ignore_invitation_captcha'))
		{
			$template->assign_vars(array(
				'CAPTCHA_TEMPLATE'	=> $captcha->get_template(),
			));
		}

		$template->assign_vars(array(
			'ERROR'					=> (sizeof($error)) ? implode('<br />', array_unique($error)) : '',

			'FORM_LANGUAGE_SELECT'	=> language_select($email_data['invite_language']),
			'FORM_CONFIRM_IMG'		=> $confirm_image,
	
			'S_MAIL_LOW_PRIORITY'	=> MAIL_LOW_PRIORITY,
			'S_MAIL_NORMAL_PRIORITY'=> MAIL_NORMAL_PRIORITY,
			'S_MAIL_HIGH_PRIORITY'	=> MAIL_HIGH_PRIORITY,
			'S_VALUE_EMAIL'			=> EMAIL,
			'S_VALUE_PM'			=> PM,
			'S_DISABLE'				=> ($disable_form) ? true : false,
			'S_DISPLAY_PRIORITY'	=> ($auth->acl_get('u_change_invitation_priority') && $invite->config['invite_priority_flag'] == MAIL_LOW_PRIORITY + 1) ? true : false, // MAIL_LOW_PRIORITY + 1 equals optional
			'S_DISPLAY_ZEBRA'		=> ($auth->acl_get('u_add_invitation_friend') && $invite->config['zebra'] == OPTIONAL) ? true : false,
			'S_DISPLAY_LANGUAGE'	=> ($invite->config['invite_language_select'] == 'opt') ? true : false,
			'S_RECIPIENTS_LIMIT'	=> (!$auth->acl_get('m_ignore_recipients_limit') && $invite->config['multiple_recipients_max'] <= $recipient_count) ? true : (!$auth->acl_get('u_multiple_recipients')) ? true : false,
			'S_HIDDEN_FIELDS'		=> $s_hidden_fields,

			'U_ACTION'				=> $this->u_action,
		));

		// Repeat the recipient block as many times as desired
		for ($i = 0; $i < $recipient_count; $i++)
		{
			$template->assign_block_vars('recipient_row', array(
					'INDEX' 					=> $i,
					'FORM_REGISTER_EMAIL'		=> $email_data['register_email_' . $i],
					'FORM_REGISTER_REAL_NAME'	=> $email_data['register_real_name_' . $i],
				)
			);
		}

		// Display other message options
		foreach ($INVITE_MESSAGE_TYPE as $string => $int)
		{
			// Undefined index: invite
			if ($string == 'invite')
			{
				continue;
			}

			$template->assign_vars(array(
				'S_DISPLAY_' . strtoupper($string)				=> (!$invite->config[$string]) ? false : (($invite->config[$string] == OPTIONAL) ? true : false),
				'S_DISPLAY_' . strtoupper($string) . '_METHOD'	=> (!$invite->config[$string]) ? false : (($invite->config[$string . '_method'] == OPTIONAL) ? true : false),
			));
		}

		// Do not ask for confirmations if we don't have any permission
		if (!$auth->acl_get('u_receive_confirmation'))
		{
			$template->assign_vars(array(
				'S_DISPLAY_CONFIRM'			=> false,
				'S_DISPLAY_CONFIRM_METHOD'	=> false,
			));
		}

		// Assign already existing input
		foreach ($email_data as $k => $v)
		{
			$template->assign_vars(array(
				'FORM_' . strtoupper($k)	=> (isset($email_data[$k])) ? utf8_normalize_nfc(request_var($k, $v, true)) : '',
			));
		}

		$this->tpl_name = 'ucp_invite_' . $mode;
		$this->page_title = 'UCP_INVITE_' . strtoupper($mode);
	}
}

?>