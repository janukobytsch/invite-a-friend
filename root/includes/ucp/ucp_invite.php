<?php
/** 
* @author Bycoja bycoja@web.de
*
* @package ucp
* @version $Id: ucp_invite.php 054 2009-11-28 14:41:59GMT Bycoja $
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
* ucp_invite
* Send invitations to friends
*
* @package ucp
*/
class ucp_invite
{
	var $u_action;

	function main($id, $mode)
	{
		global $config, $db, $user, $auth, $template, $phpbb_root_path, $phpEx;

		include($phpbb_root_path . 'includes/functions_invite.' . $phpEx);

		// General vars
		$invite				= new invite();
		$submit				= (isset($_POST['submit'])) ? true : false;
		$error 				= array();
		$queue				= false;
		
		$confirm_id			= request_var('confirm_id', '');
		$s_hidden_fields	= ($confirm_id) ? array('confirm_id' => $confirm_id) : array();

		// Authorised?
		if (!$invite->config['enable'])
		{
			trigger_error('INVITE_DISABLED');
		}
		if (!$auth->acl_get('u_send_invite'))
		{
		    trigger_error('NOT_AUTHORISED');
		}

		$email_data	= array(
			'message_type'			=> $INVITE_MESSAGE_TYPE['invite'],
			'method'				=> EMAIL,
			'method_user_id'		=> $user->data['user_id'],
			'invite_language'		=> ($invite->config['invite_language_select']) ? utf8_normalize_nfc(request_var('form_invite_language_select', $user->data['user_lang'], true)) : $user->data['user_lang'],
			
			'subject'				=> utf8_normalize_nfc(request_var('form_subject', '', true)),
			'message'				=> utf8_normalize_nfc(request_var('form_message', '', true)),
			'register_email'		=> utf8_normalize_nfc(request_var('form_register_email', '', true)),
			'register_real_name'	=> utf8_normalize_nfc(request_var('form_register_real_name', '', true)),
			'register_key'			=> $invite->create_key(),
			'register_key_used'		=> 0,
			'register_user_id'		=> 0,
			'invite_user_id'		=> $user->data['user_id'],
			'invite_session_ip'		=> $user->data['session_ip'],
			'invite_time'			=> time(),
			'invite_zebra'			=> request_var('form_invite_zebra', 0, true),
			
			// CAPTCHA
			'confirm_code'			=> request_var('confirm_code', ''),
			'confirm_id'			=> request_var('confirm_id', ''),
		);

		// Other message types
		foreach ($INVITE_MESSAGE_TYPE as $string => $int)
		{
			$email_data['invite_' . $string] = request_var('form_invite_' . $string, 0, true);
			$email_data['invite_' . $string . '_method'] = request_var('form_invite_' . $string . '_method', 0, true);
		}

		// Wait until we can send another email?
		$sql 			= 'SELECT COUNT(log_id) AS invite_num FROM ' . INVITE_LOG_TABLE . ' WHERE invite_user_id = ' . $user->data['user_id'];
		$result 		= $db->sql_query($sql);
		$invite_total	= (int) $db->sql_fetchfield('invite_num');
		$db->sql_freeresult();

		if ($invite_total)
		{
			$last_day		= time() - 86400;

			// Queue
			$sql 			= 'SELECT MAX(invite_time) AS max_time FROM ' . INVITE_LOG_TABLE . ' WHERE invite_user_id = ' . $user->data['user_id'];
			$result 		= $db->sql_query($sql);
			$last_invite	= (int) $db->sql_fetchfield('max_time');
			$db->sql_freeresult();

			if ((time() - $last_invite) < $invite->config['queue_time'])
			{
				$queue		= true;
				$error[] 	= $user->lang['QUEUE_QUEUE'];
			}

			// User topics
			$sql 			= 'SELECT COUNT(topic_id) AS user_topics FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . $user->data['user_id'];
			$result 		= $db->sql_query($sql);
			$user_topics	= (int) $db->sql_fetchfield('user_topics');
			$db->sql_freeresult();

			// Other limits
			$sql 			= 'SELECT COUNT(log_id) AS invite_num FROM ' . INVITE_LOG_TABLE . ' WHERE invite_user_id = ' . $user->data['user_id'] . ' AND invite_time >= ' . $last_day;
			$result 		= $db->sql_query($sql);
			$invite_day		= (int) $db->sql_fetchfield('invite_num');
			$db->sql_freeresult();

			$limit_ary		= array(
				'limit_invite_user'	=> $invite_total,
				'limit_invite_day'	=> $invite_day,
			);

			foreach ($limit_ary as $k => $v)
			{
				// Don't divide by zero
				$additional_invite_p = ($invite->config[$k . '_posts'] == 0) ? 0 : floor($user->data['user_posts'] / $invite->config[$k . '_posts']);
				$additional_invite_t = ($invite->config[$k . '_topics'] == 0) ? 0 : floor($user_topics / $invite->config[$k . '_topics']);

				if ($invite->config[$k] == 0 && $invite->config[$k . '_posts'] == 0)
				{
					continue;
				}

				if ($v >= $invite->config[$k] + $additional_invite_p + $additional_invite_t)
				{
					$queue		= true;
					$error[]	= $user->lang['QUEUE_' . strtoupper($k)];
				}
			}
		}

		// The CAPTCHA kicks in here. We can't help that the information gets lost on language change. 
		if ($invite->config['invite_confirm_code'])
		{
			if (!class_exists('phpbb_captcha_factory'))
			{
				include($phpbb_root_path . 'includes/captcha/captcha_factory.' . $phpEx);
			}

			$captcha =& phpbb_captcha_factory::get_instance($config['captcha_plugin']);
			$captcha->init(CONFIRM_POST);
		}

		// Do the job ...
		if ($submit && !$queue)
		{
			// Fix language vars defined in ucp.php
			$email_data['email'] = $email_data['register_email'];

			$check_ary = array(
				'email' => array(
					array('string', false, 0, 60),
					array('email')),
				'register_real_name'	=> array('string', false, 1, 60),
				'subject'				=> array('string', false, $invite->config['subject_min_chars'], $invite->config['subject_max_chars']),
				'message'				=> array('string', false, $invite->config['message_min_chars'], $invite->config['message_max_chars']),
			);

			$error = validate_data($email_data, $check_ary);

			// Fix language vars defined in ucp.php
			unset($email_data['email']);

			if ($email_data['register_email'] == $user->data['user_email'])
			{
				$error[] = $user->lang['INVITE_TO_YOUR_EMAIL'];
			}

			// Multiple invite?
			$sql 		= 'SELECT COUNT(log_id) AS multiple_invite FROM ' . INVITE_LOG_TABLE . ' WHERE register_email = "' . $email_data['register_email'] . '"';
			$result 	= $db->sql_query($sql);
			$multiple	= (int) $db->sql_fetchfield('multiple_invite');

			if ($multiple && !$invite->config['invite_multiple'])
			{
				$error[] = $user->lang['INVITE_MULTIPLE'];
			}

			// Visual Confirmation handling
			if ($invite->config['invite_confirm_code'])
			{
				$vc_response = $captcha->validate($email_data);
				if ($vc_response !== false)
				{
					$error[] = $vc_response;
				}
			}

			// Oops?
			if (!$config['email_enable'])
			{
				$error[] = $user->lang['EMAIL_DISABLED'];
			}

			if (!sizeof($error))
			{
				$send_message	= $invite->message_handle($email_data, true, false);

				// Email successfully sent to friend?
				meta_refresh(2, append_sid("{$phpbb_root_path}index.$phpEx"));

				$message = ($send_message) ? $user->lang['EMAIL_SENT_SUCCESS'] : $user->lang['EMAIL_SENT_FAILURE'];
				$message .=  '<br /><br />' . sprintf($user->lang['RETURN_INDEX'], '<a href="' . append_sid("{$phpbb_root_path}index.$phpEx") . '">', '</a>');
				trigger_error($message);
			}

			// Replace "error" strings with their real, localised form
			$error = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$user->lang['\\1'])) ? \$user->lang['\\1'] : '\\1'", $error);
		}

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
				'CAPTCHA_TEMPLATE'		=> $captcha->get_template(),
			));
		}

		$template->assign_vars(array(
			// Display all errors: 'ERROR'		=> (sizeof($error)) ? implode('<br />', $error) : '',
			'ERROR'					=> (sizeof($error)) ? $error[0] : '',

			'FORM_LANGUAGE_SELECT'	=> language_select($email_data['invite_language']),
			'FORM_CONFIRM_IMG'		=> $confirm_image,

			'S_VALUE_EMAIL'			=> EMAIL,
			'S_VALUE_PM'			=> PM,
			'S_CONFIRM_CODE'		=> ($queue) ? false : $invite->config['invite_confirm_code'],
			'S_DISABLE'				=> ($queue) ? true : false,

			'S_DISPLAY_ZEBRA'		=> ($invite->config['zebra'] == OPTIONAL) ? true : false,
			'S_DISPLAY_LANGUAGE'	=> ($invite->config['invite_language_select']) ? true : false,
			'S_HIDDEN_FIELDS'		=> $s_hidden_fields,
		));

		foreach ($email_data as $k => $v)
		{
			$template->assign_vars(array(
				'FORM_' . strtoupper($k)	=> (isset($email_data[$k])) ? utf8_normalize_nfc(request_var($k, $v, true)) : '',
			));
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
				'S_DISPLAY_' . strtoupper($string)				=> ($invite->config[$string] == OPTIONAL) ? true : false,
				'S_DISPLAY_' . strtoupper($string) . '_METHOD'	=> ($invite->config[$string . '_method'] == OPTIONAL) ? true : false,
			));
		}

		// Template
		$this->tpl_name = 'ucp_invite_' . $mode;
		$this->page_title = 'UCP_INVITE_' . strtoupper($mode);
	}
} 

?>