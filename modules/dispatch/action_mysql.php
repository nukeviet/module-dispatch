<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Tue, 19 Jul 2011 09:07:26 GMT
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_departments";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_type";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_signer";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_document";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_de_do";

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_departments (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 parentid mediumint(8) unsigned NOT NULL DEFAULT '0',
 alias varchar(250) NOT NULL,
 title varchar(250) NOT NULL,
 introduction mediumtext NOT NULL,
 head varchar(255) NOT NULL,
 addtime int(11) unsigned NOT NULL DEFAULT '0',
 weight smallint(4) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id),
 UNIQUE KEY alias (alias),
 KEY weight (weight)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 parentid mediumint(8) unsigned NOT NULL DEFAULT '0',
 alias varchar(250) NOT NULL,
 title varchar(250) NOT NULL,
 introduction mediumtext NOT NULL,
 addtime int(11) unsigned NOT NULL DEFAULT '0',
 weight smallint(4) unsigned NOT NULL DEFAULT '0',
 status tinyint(1) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id),
 UNIQUE KEY alias (alias),
 KEY weight (weight)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_type (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 parentid mediumint(8) unsigned NOT NULL DEFAULT '0',
 alias varchar(250) NOT NULL,
 title varchar(250) NOT NULL,
 weight smallint(4) unsigned NOT NULL DEFAULT '0',
 status tinyint(1) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id),
 UNIQUE KEY alias (alias),
 KEY weight (weight)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_signer (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 name varchar(255) NOT NULL,
 positions varchar(255) NOT NULL,
 weight smallint(4) unsigned NOT NULL DEFAULT '0',
 status tinyint(1) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id)
 ) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_document (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 type mediumint(8) unsigned NOT NULL DEFAULT '0',
 catid mediumint(8) unsigned NOT NULL DEFAULT '0',
 alias varchar(250) NOT NULL,
 title varchar(250) NOT NULL,
 code varchar(100) NOT NULL,
 content mediumtext NOT NULL,
 file varchar(255) NOT NULL,
 from_org varchar(255) NOT NULL,
 from_depid mediumint(8) unsigned NOT NULL DEFAULT '0',
 from_signer mediumint(8) unsigned NOT NULL DEFAULT '0',
 from_time int(11) unsigned NOT NULL DEFAULT '0',
 date_iss int(11) unsigned NOT NULL DEFAULT '0',
 date_first int(11) unsigned NOT NULL DEFAULT '0',
 date_die int(11) unsigned NOT NULL DEFAULT '0',
 to_org mediumtext NOT NULL,
 groups_view varchar(255) NOT NULL,
 status tinyint(1) unsigned NOT NULL DEFAULT '0',
 view int(11) unsigned NOT NULL DEFAULT '0',
 PRIMARY KEY (id),
 UNIQUE KEY alias (alias),
 KEY type (type),
 KEY catid (catid)
) ENGINE=MyISAM;";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_de_do (
 id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 doid mediumint(8) unsigned NOT NULL DEFAULT '0',
 deid mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
 ) ENGINE=MyISAM;";
