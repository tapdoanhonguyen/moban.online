<?php/** * @Project NUKEVIET 4.x * @Author VINADES.,JSC (contact@vinades.vn) * @Copyright (C) 2014 VINADES.,JSC. All rights reserved * @License GNU/GPL version 2 or any later version * @Createdate Thu, 19 Jun 2014 07:30:43 GMT */if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );$sql_drop_module = array();$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat";$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data;$sql_create_module = $sql_drop_module;$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat ( id mediumint(8) unsigned NOT NULL AUTO_INCREMENT, alias varchar(250) NOT NULL, title varchar(250) NOT NULL, weight smallint(4) unsigned NOT NULL DEFAULT '0', PRIMARY KEY (id), UNIQUE KEY alias (alias), KEY weight (weight)) ENGINE=MyISAM;";$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . " ( id mediumint(8) unsigned NOT NULL AUTO_INCREMENT, catid mediumint(8) unsigned NOT NULL, title varchar(250) NOT NULL, bodytext text NOT NULL, jobs varchar(250) NOT NULL, link varchar(250) NOT NULL, image varchar(250) DEFAULT '', status tinyint(1) unsigned NOT NULL DEFAULT '0', PRIMARY KEY (id), KEY catid (catid)) ENGINE=MyISAM;";