#
# $Id: mysql_41_schema.sql 5.0.1 2009-04-13 18:03:59GMT Bycoja $
#

# Table: 'phpbb_invite_config'
CREATE TABLE phpbb_invite_config (
	`config_name` varchar(255) binary NOT NULL default '',
	`config_value` varchar(255) binary NOT NULL default '',
	PRIMARY KEY  (`config_name`)
) CHARACTER SET `utf8` COLLATE `utf8_bin`;

# Table: 'phpbb_invite_message'
CREATE TABLE phpbb_invite_message (
	`language_iso` varchar(30) binary NOT NULL default '',
	`message_type` tinyint(1) unsigned NOT NULL default '0',
	`message` mediumtext NOT NULL
) CHARACTER SET `utf8` COLLATE `utf8_bin`;

# Table: 'phpbb_invite_log'
CREATE TABLE phpbb_invite_log (
	`log_id` mediumint(8) unsigned NOT NULL auto_increment,
	`invite_user_id` mediumint(8) unsigned NOT NULL default '0',
	`register_user_id` mediumint(8) unsigned NOT NULL default '0',
	`register_email` varchar(100) binary NOT NULL default '',
	`invite_confirm` tinyint(1) unsigned NOT NULL default '0',
	`invite_confirm_method` tinyint(1) unsigned NOT NULL default '0',
	`register_key_used` tinyint(1) unsigned NOT NULL default '0',
	`register_key` varchar(40) binary NOT NULL default '',
	`invite_session_ip` varchar(32) binary NOT NULL default '',
	`invite_time` int(11) unsigned NOT NULL default '0',
	`invite_zebra` tinyint(1) unsigned NOT NULL default '0',
	PRIMARY KEY  (`log_id`)
) CHARACTER SET `utf8` COLLATE `utf8_bin` AUTO_INCREMENT=1;