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
		global $db, $user, $template, $cache;
		global $config, $phpbb_root_path, $phpEx;

		$user->add_lang(array('invite', 'ucp'));
		$user->add_lang('mods/info_acp_invite');
		
		include ($phpbb_root_path . 'includes/functions_user.' . $phpEx);
		include ($phpbb_root_path . 'includes/functions_invite.' . $phpEx);
		
		// Set general vars
		$invite		 		= new invite();
		$this->page_title	= 'ACP_INVITE_A_FRIEND';
		$this->tpl_name		= 'acp_invite';

		$action		= request_var('action', '');
		$submit		= (isset($_POST['submit']))  ? true : false;
		$message	= request_var('message', $invite->message, true);
		$error		= array();
		
		foreach ($invite->config as $k => $v)
		{
			$iaf_config[$k] = utf8_normalize_nfc(request_var($k, $v, true));
		}

		// ########### Remove this later!!!!!!######################################
		$cache_file = $phpbb_root_path . 'cache/ctpl_admin_acp_invite.html.' . $phpEx;
		
		if (file_exists($cache_file))
		{
			unlink($cache_file);
		}
		// ##############################################################
		
	
		if ($submit)
		{
			$check_ary = array(
				'time'			=> array('num', false, 1, 99999),
				'max_message'	=> array('num', false, 1, 9999),
				'max_subject'	=> array('num', false, 1, 999),
				'key_min_chars'	=> array('num', false, 1, 999),
				'key_max_chars'	=> array('num', false, 1, 999),
				'charset'		=> array('string', false, 1, 250),
			);
			
			$error = validate_data($iaf_config, $check_ary);
			
			if (empty($message))
			{
				$error[]	= $user->lang['ERROR_SETTINGS'];
			}
			
			if (!sizeof($error))
			{
				foreach ($iaf_config as $k => $v)
				{
					$invite->set_config($k, $iaf_config[$k]);
				}
				
				// Update message
				$invite->message_file($user->data['user_lang'], 'update', $message);
				
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
			'ERROR'		=> (sizeof($error)) ? $user->lang['ERROR_SETTINGS'] : '',
			
			'S_MESSAGE'	=> $message,
			'U_ACTION'	=> $this->u_action,
		));
	}
}
?>