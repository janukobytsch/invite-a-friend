<?php
/**
*
* @package ucp
* @version $Id: ucp_profile.php 8479 2008-03-29 00:22:48Z naderman $
* @copyright (c) 2005 phpBB Group
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

		// Set some vars
		$invite		= new invite();

		$submit		= (!empty($_POST['submit'])) ? true : false;
		$error 		= array();
		$send_iaf	= true;

		// Authorised?
		if (!$invite->config['enable'])
		{
			trigger_error('IAF_DISABLED');
		}
		if (!$auth->acl_get('u_send_iaf'))
		{
		    trigger_error('NOT_AUTHORISED');
		}

		// Get data
		$data	= array(
			'email'			=> utf8_normalize_nfc(request_var('recipient', '', true)),
			'name'			=> utf8_normalize_nfc(request_var('name', '', true)),
			'subject'		=> utf8_normalize_nfc(request_var('subject', '', true)),
			'message'		=> utf8_normalize_nfc(request_var('message', '', true)),
			'confirm_email'	=> request_var('send_confirm', 0, true),
			'from'			=> $user->data['user_id'],
			'lang'			=> $user->data['user_lang'],
			'method'		=> NOTIFY_EMAIL,
			'key'			=> $invite->create_key(),
		);

		// Wait until we can send another email?
		$sql 		= 'SELECT COUNT(key_id) AS iaf_num FROM ' . INVITE_KEYS_TABLE . ' WHERE user_id = ' . $data['from'];
		$result 	= $db->sql_query($sql);
		$iaf_num	= (int) $db->sql_fetchfield('iaf_num');

		if ($iaf_num)
		{
			$sql 		= 'SELECT MAX(key_time) AS max_time FROM ' . INVITE_KEYS_TABLE . ' WHERE user_id = ' . $data['from'];
			$result 	= $db->sql_query($sql);
			$last_iaf	= (int) $db->sql_fetchfield('max_time');
			
			if ((time() - $last_iaf) < $invite->config['time'])
			{
				$error[] 	= $user->lang['WAIT_NEXT_IAF'];
				$send_iaf	= false;
			}
		}

		// Do the job ...
		if ($submit && $send_iaf)
		{
			$check_ary = array(
				'email'		=> array(
					array('string', false, 6, 60),
					array('email')),
				'name'		=> array('string', false, 1, 60),
				'subject'	=> array('string', false, $invite->config['min_subject'], $invite->config['max_subject']),
				'message'	=> array('string', false, $invite->config['min_message'], $invite->config['max_message']),
			);

			$error = validate_data($data, $check_ary);
			
			if($data['email'] == $user->data['user_email'])
			{
				$error[]	= $user->lang['EMAIL_EQ_EMAIL'];
			}
			
			// Already got invitation?
			$sql 		= 'SELECT COUNT(key_id) AS multi_num FROM ' . INVITE_KEYS_TABLE . ' WHERE to_email = "' . $data['email'] . '"';
			$result 	= $db->sql_query($sql);
			$multi_num	= (int) $db->sql_fetchfield('multi_num');
			
			if ($multi_num && !$invite->config['multi_email'])
			{
				$error[]	= $user->lang['ALREADY_INVITED'];
			}
			
			if (!sizeof($error))
			{
				$email_sent	= $invite->send_email($data);
				
				// Email successfully sent to friend?
				meta_refresh(1, append_sid("{$phpbb_root_path}index.$phpEx"));

				$message = ($email_sent) ? $user->lang['EMAIL_SENT_SUCCESS'] : $user->lang['EMAIL_SENT_FAILURE'];
				$message .=  '<br /><br />' . sprintf($user->lang['RETURN_INDEX'], '<a href="' . append_sid("{$phpbb_root_path}index.$phpEx") . '">', '</a>');
				trigger_error($message);
			}
			
			// Replace "error" strings with their real, localised form
			$error = preg_replace('#^([A-Z_]+)$#e', "(!empty(\$user->lang['\\1'])) ? \$user->lang['\\1'] : '\\1'", $error);
		}

		$template->assign_vars(array(
			// Display all errors: 'ERROR'		=> (sizeof($error)) ? implode('<br />', $error) : '',
			// We only display the first error in array so eveything is clearly arranged
			'ERROR'				=> (sizeof($error)) ? $error[0] : '',
			
			'RECIPIENT'			=> (isset($data['email'])) ? $data['email'] : '',
			'NAME'				=> (isset($data['name'])) ? $data['name'] : '',
			'SUBJECT'			=> (isset($data['subject'])) ? $data['subject'] : '',
			'MESSAGE'			=> (isset($data['message'])) ? $data['message'] : '',
			
			'S_DISABLE'			=> ($send_iaf) ? false : true,
			'S_SHOW_CONFIRM'	=> ($invite->config['confirm_email'] == 2) ? true : false,
		));

		// Set desired template
		$this->tpl_name = 'ucp_invite_' . $mode;
		$this->page_title = 'UCP_INVITE_' . strtoupper($mode);
	}   
} 

?>