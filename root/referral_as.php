<?php
/**
*
* @author Bycoja bycoja@web.de
* @package phpBB3
* @version $Id referral_as.php 0.7.0 2012-06-22 17:28:02GMT Bycoja $
* @copyright (c) 2008-2012 Bycoja
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	// Setup for ajax calls
	define('IN_PHPBB', true);

	$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
	$phpEx = substr(strrchr(__FILE__, '.'), 1);

	include($phpbb_root_path . 'common.' . $phpEx);

	// Start session management
	$user->session_begin();
	$auth->acl($user->data);
	$user->setup();
}

if (!class_exists('invite'))
{
	include($phpbb_root_path . 'includes/functions_invite.' . $phpEx);
}

// Handle ajax requests for usernames
if (isset($_REQUEST['ajax']))
{
	// This is the ajax input field
	$input 	= request_var('input', '', true); 
	$length = strlen($input);

	$invite	= new invite();
	$output = array();
	$count 	= 0;

	// Will not show more than the number of users specified here
	$limit 	= $invite->config['referral_as_limit'];

	if ($length)
	{
		// Do not include Bots, Crawlers, etc. (any user of type USER_IGNORE)
		$sql = 'SELECT username, user_id
				FROM ' . USERS_TABLE . '
				WHERE username_clean ' . $db->sql_like_expression($db->sql_escape(utf8_clean_string($input)) . $db->any_char) . '
					AND user_type != ' . USER_IGNORE . '
				ORDER BY username_clean ASC';
		$result = $db->sql_query_limit($sql, $limit);

		while ($row = $db->sql_fetchrow($result))
		{
			$output[] = array( "id"=>$row['user_id'] ,"value"=>htmlspecialchars($row['username']), "info"=>'' );
			$count++;
			
			if ($count == $limit)
			{
				break;
			}
		}
		$db->sql_freeresult($result);
	}

	// Build the output (either json or xml)
	header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header ("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header ("Pragma: no-cache"); // HTTP/1.0

	if (isset($_REQUEST['json']))
	{
		header("Content-Type: application/json");
	
		echo "{\"results\": [";
		$arr = array();
		for ($i=0;$i<count($output);$i++)
		{
			$arr[] = "{\"id\": \"".$output[$i]['id']."\", \"value\": \"".$output[$i]['value']."\", \"info\": \"".$output[$i]['info']."\"}";
		}
		echo implode(", ", $arr);
		echo "]}";
	}
	else
	{
		header("Content-Type: text/xml");

		echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?><results>";
		for ($i=0;$i<count($output);$i++)
		{
			echo "<rs id=\"".$output[$i]['id']."\" info=\"".$output[$i]['info']."\">".$output[$i]['value']."</rs>";
		}
		echo "</results>";
	}
}
?>