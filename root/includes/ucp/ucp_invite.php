<?php
/**
*
* @author Bycoja bycoja@web.de
* @package ucp
* @version $Id ucp_invite.php 0.7.0 2012-06-22 17:28:02GMT Bycoja $
* @copyright (c) 2008-2012 Bycoja
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
		$invite	= new invite();
		
		$user->add_lang(array('mods/info_acp_invite', 'acp/email'));

		switch ($mode)
		{
			case 'invite':

				$submit		= (isset($_POST['submit'])) ? true : false;
				$remove_rc	= (isset($_REQUEST['remove_rc'])) ? true : false;
				$add_rc		= (isset($_REQUEST['add_rc'])) ? true : false;

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
				$recipient_count	= ($recipient_count < 1) ? 1 : $recipient_count;
				$recipient_count	= ($invite->config['multiple_recipients_max'] <= $recipient_count) ? $invite->config['multiple_recipients_max'] : $recipient_count;

				$s_hidden_fields['rc']	= $recipient_count;

				add_form_key('ucp_invite');

				// Authorised?
				if (!$invite->config['enable'] || !$invite->config['enable_invitation'])
				{
					trigger_error('INVITE_DISABLED');
				}
				if (!$auth->acl_get('u_send_invite'))
				{
					trigger_error('NOT_AUTHORISED');
				}

				// Oops?
				if (!$config['email_enable'])
				{
					trigger_error('EMAIL_DISABLED');
				}

				// Queue?
				if ($user->data['user_invitations'])
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

				// Reached limit?
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

				// Unlimited invitations?
				if ($invite->config['enable_unlimited'])
				{
					$limit_enabled = false;
				}

				// Collect some statistical information
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
				
				// Requirements met?
				if ($user->data['user_posts'] < $invite->config['invite_required_posts'])
				{
					$error[] = sprintf($user->lang['TOO_FEW_POSTS'], $invite->config['invite_required_posts']);
					$disable_form = true;
				}

				// Set up the array containing the important information
				$email_data	= array(
					'message_type'			=> $INVITE_MESSAGE_TYPE['invite'],
					'method'				=> EMAIL,
					'method_user_id'		=> $user->data['user_id'],
					'invite_language'		=> ($invite->config['invite_language_select'] == 'opt') ? utf8_normalize_nfc(request_var('form_invite_language_select', $user->data['user_lang'], true)) : (($invite->config['invite_language_select'] == 'user') ? $user->data['user_lang'] : $invite->config['invite_language_select']),
					'priority'				=> ($invite->config['invite_priority_flag'] == MAIL_LOW_PRIORITY + 1) ? request_var('form_priority', 0) : $invite->config['invite_priority_flag'], // MAIL_LOW_PRIORITY + 1 equals optional
					'subject'				=> utf8_normalize_nfc(request_var('form_subject', '', true)),
					'message'				=> utf8_normalize_nfc(request_var('form_message', '', true)),
					'register_key'			=> $invite->generate_key(),
					'register_key_used'		=> 0,
					'register_user_id'		=> 0,
					'invite_user_id'		=> $user->data['user_id'],
					'invite_session_ip'		=> $user->data['session_ip'],
					'invite_time'			=> time(),
					'expiration_time'		=> time() + $invite->config['invite_expiration_time']*86400,
					'invite_zebra'			=> request_var('form_invite_zebra', 0),
					'confirm_code'			=> request_var('confirm_code', ''),
					'confirm_id'			=> request_var('confirm_id', ''),
				);

				// Additional email data concerning the templates
				foreach ($INVITE_MESSAGE_TYPE as $string => $int)
				{
					$email_data['invite_' . $string] = request_var('form_invite_' . $string, 0);
					$email_data['invite_' . $string . '_method'] = request_var('form_invite_' . $string . '_method', 0);
				}

				// The CAPTCHA kicks in here
				if ($invite->config['invite_confirm_code'])
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
					if (!check_form_key('ucp_invite'))
					{
						$error[] = 'FORM_INVALID';
					}

					$check_ary = array(
						'subject' => array('string', false, $invite->config['subject_min_chars'], $invite->config['subject_max_chars']),
						'message' => array('string', false, $invite->config['message_min_chars'], $invite->config['message_max_chars']),
					);
					$error = validate_data($email_data, $check_ary);

					// Visual Confirmation handling
					if ($invite->config['invite_confirm_code'])
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

						if ($multiple && $invite->config['invite_multiple'])
						{
							$error[] = $user->lang['INVITE_MULTIPLE'];
						}

						if ($invite->config['invite_multiple'])
						{
							$count_values = array_count_values($email_ary);

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

				if ($invite->config['invite_confirm_code'])
				{
					$s_hidden_fields = array_merge($s_hidden_fields, $captcha->get_hidden_fields());
				}
				$s_hidden_fields = build_hidden_fields($s_hidden_fields);
				$confirm_image = '';

				// Visual Confirmation - Show images
				if ($invite->config['invite_confirm_code'])
				{
					$template->assign_vars(array(
						'CAPTCHA_TEMPLATE'	=> $captcha->get_template(),
					));
				}

				$template->assign_vars(array(
					// Display all errors: 'ERROR'		=> (sizeof($error)) ? implode('<br />', $error) : '',
					'ERROR'						=> (sizeof($error)) ? $error[0] : '',

					'FORM_LANGUAGE_SELECT'		=> language_select($email_data['invite_language']),
					'FORM_CONFIRM_IMG'			=> $confirm_image,

					'S_ENABLE_POWERED_BY'		=> $invite->config['enable_powered_by'],
					'S_MAIL_LOW_PRIORITY'		=> MAIL_LOW_PRIORITY,
					'S_MAIL_NORMAL_PRIORITY'	=> MAIL_NORMAL_PRIORITY,
					'S_MAIL_HIGH_PRIORITY'		=> MAIL_HIGH_PRIORITY,
					'S_VALUE_EMAIL'				=> EMAIL,
					'S_VALUE_PM'				=> PM,
					'S_DISABLE'					=> ($disable_form) ? true : false,
					'S_DISPLAY_PRIORITY'		=> ($invite->config['invite_priority_flag'] == MAIL_LOW_PRIORITY + 1) ? true : false, // MAIL_LOW_PRIORITY + 1 equals optional
					'S_DISPLAY_ZEBRA'			=> ($invite->config['zebra'] == OPTIONAL) ? true : false,
					'S_DISPLAY_LANGUAGE'		=> ($invite->config['invite_language_select'] == 'opt') ? true : false,
					'S_RECIPIENTS_LIMIT'		=> ($invite->config['multiple_recipients_max'] <= $recipient_count) ? true : false,
					'S_CONFIRM_REFRESH'			=> true,
					'S_HIDDEN_FIELDS'			=> $s_hidden_fields,

					'U_ACTION'					=> $this->u_action,
				));

				// Repeat the recipient block as many times as desired
				for ($i = 0; $i < $recipient_count; $i++)
				{
					$template->assign_block_vars('recipient_row', array(
							'INDEX' => $i,

							'FORM_REGISTER_EMAIL'		=> $email_data['register_email_' . $i],
							'FORM_REGISTER_REAL_NAME'	=> $email_data['register_real_name_' . $i],
						)
					);
				}

				// Display other message options
				foreach ($INVITE_MESSAGE_TYPE as $string => $int)
				{
					// [Fix] Undefined index
					if ($string == 'invite' || $string == 'referral')
					{
						continue;
					}

					$template->assign_vars(array(
						'S_DISPLAY_' . strtoupper($string)				=> (!$invite->config[$string]) ? false : (($invite->config[$string] == OPTIONAL) ? true : false),
						'S_DISPLAY_' . strtoupper($string) . '_METHOD'	=> (!$invite->config[$string]) ? false : (($invite->config[$string . '_method'] == OPTIONAL) ? true : false),
					));
				}

				// Assign already existing input
				foreach ($email_data as $k => $v)
				{
					$template->assign_vars(array(
						'FORM_' . strtoupper($k)	=> (isset($email_data[$k])) ? utf8_normalize_nfc(request_var($k, $v, true)) : '',
					));
				}

			break;

			case 'statistics':

				//

			break;
		}

		$this->tpl_name = 'ucp_invite_' . $mode;
		$this->page_title = 'UCP_INVITE_' . strtoupper($mode);
	}
}

?>