#
# $Id: mysql_40_schema.sql 5.0.1 2009-04-13 18:03:59GMT Bycoja $
#

# Table: 'phpbb_invite_config'
CREATE TABLE phpbb_invite_config (
	`config_name` VARCHAR(200) NOT NULL,
	`config_value` blob NOT NULL,
	PRIMARY KEY  (`config_name`)
);

# Table: 'phpbb_invite_log'
CREATE TABLE phpbb_invite_log (
	`log_id` mediumint(8) unsigned NOT NULL auto_increment,
	`invite_user_id` mediumint(8) unsigned NOT NULL default '0',
	`register_user_id` mediumint(8) unsigned NOT NULL default '0',
	`register_email` blob NOT NULL,
	`invite_confirm` tinyint(1) unsigned NOT NULL default '0',
	`invite_confirm_method` tinyint(1) unsigned NOT NULL default '0',
	`register_key_used` tinyint(1) unsigned NOT NULL default '0',
	`register_key` blob NOT NULL,
	`invite_session_ip` blob NOT NULL,
	`invite_time` int(11) unsigned NOT NULL default '0',
	`invite_zebra` tinyint(1) unsigned NOT NULL default '0',
	PRIMARY KEY  (`log_id`)
);