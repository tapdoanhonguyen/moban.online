<?php/** * @Project NUKEVIET 4.x * @Author VINADES.,JSC (contact@vinades.vn) * @Copyright (C) 2014 VINADES.,JSC. All rights reserved * @License GNU/GPL version 2 or any later version * @Createdate Thu, 19 Jun 2014 07:30:43 GMT */if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );$sql_drop_module = array();$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data;$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . '_code';$sql_create_module = $sql_drop_module;$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $module_data . " ( id mediumint(8) unsigned NOT NULL auto_increment, userid mediumint(8) unsigned NOT NULL, domain varchar(250) NOT NULL default '', title varchar(250) NOT NULL default '', mobile varchar(50) NOT NULL DEFAULT '', email varchar(50) NOT NULL DEFAULT '', image_site varchar(150) NOT NULL DEFAULT '', banner_site varchar(150) NOT NULL DEFAULT '', mobile_refer varchar(50) NOT NULL DEFAULT '', facebook varchar(250) NOT NULL DEFAULT '', zalo varchar(50) NOT NULL DEFAULT '', youtube varchar(250) NOT NULL DEFAULT '', instagram varchar(250) NOT NULL DEFAULT '', addtime int(10) unsigned NOT NULL DEFAULT 0, status tinyint(1) unsigned NOT NULL DEFAULT 0, PRIMARY KEY (id), UNIQUE KEY (domain)) ENGINE=MyISAM";$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $module_data . "_code ( id mediumint(8) unsigned NOT NULL auto_increment, mobile varchar(50) NOT NULL DEFAULT '', addtime int(10) unsigned NOT NULL DEFAULT 0, status tinyint(1) unsigned NOT NULL DEFAULT 0, code mediumint(8) NOT NULL DEFAULT 0, PRIMARY KEY (id), UNIQUE KEY (code)) ENGINE=MyISAM";$data = array();$data['sms_on'] = 1;$data['sms_type'] = 2;$data['apikey'] = '78248763261D926EC4C97DF882CB5C';$data['secretkey'] = '37425B96D3AE8A44955AD8428833C5';$data['email_notify'] = 'kid.apt@gmail.com';$data['brandname'] = 'CSKH-SPA';foreach ($data as $config_name => $config_value) {    $sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', " . $db->quote($module_name) . ", " . $db->quote($config_name) . ", " . $db->quote($config_value) . ")";}