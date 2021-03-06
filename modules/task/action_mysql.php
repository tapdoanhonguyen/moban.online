<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.com)
 * @Copyright (C) 2018 mynukeviet. All rights reserved
 * @Createdate Sun, 14 Jan 2018 08:05:40 GMT
 */
if (!defined('NV_IS_FILE_MODULES')) die('Stop!!!');

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_econtent";
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_performer";

$result = $db->query("SHOW TABLE STATUS LIKE '" . $db_config['prefix'] . "\_" . $lang . "\_comment'");
$rows = $result->fetchAll();
if (sizeof($rows)) {
    $sql_drop_module[] = "DELETE FROM " . $db_config['prefix'] . "_" . $lang . "_comment WHERE module='" . $module_name . "'";
}

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "(
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(255) NOT NULL,
  performer varchar(255) NOT NULL COMMENT 'Người thực hiện',
  begintime int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Thời gian bắt đầu',
  exptime int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Thời gian hoàn thành',
  realtime int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Thời gian hoàn thành thực tế',
  description text COMMENT 'Mô tả công việc',
  useradd mediumint(8) unsigned NOT NULL COMMENT 'Người giao việc',
  addtime int(11) unsigned NOT NULL,
  edittime int(11) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) unsigned NOT NULL DEFAULT '0',
  priority tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Mức độ ưu tiên',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_performer(
  taskid int(11) unsigned NOT NULL,
  userid mediumint(8) unsigned NOT NULL COMMENT 'Người thực hiện',
  follow tinyint(1) unsigned NOT NULL DEFAULT '1',
  readed tinyint(1) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY taskid (taskid,userid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_econtent(
  action varchar(100) NOT NULL,
  econtent text NOT NULL,
  PRIMARY KEY (action)
) ENGINE=MyISAM";

$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_econtent (action, econtent) VALUES('newtask', 'Xin chào <strong>&#91;USER_WORKING&#93;</strong>!<br /> <br /> Bạn có công việc cần thực hiện được giao tại <strong>&#91;SITE_NAME&#93;</strong>. Dưới đây là thông tin chi tiết: <ul> <li><strong>Tiêu đề: </strong>&#91;TITLE&#93;</li> <li><strong>Người giao việc:</strong> &#91;USER_ADD&#93;</li> <li><strong>Thời gian bắt đầu:</strong> &#91;TIME_START&#93;</li> <li><strong>Thời gian hoàn thành:</strong> &#91;TIME_END&#93;</li> <li><strong>Trạng thái:</strong> &#91;STATUS&#93;</li> </ul> &#91;CONTENT&#93;<br /> <br /> Theo dõi và cập nhật tiến độ công việc tại &#91;TASK_URL&#93;')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_econtent (action, econtent) VALUES('cpltask', 'Xin chào <strong>&#91;USER_ADD&#93;</strong>!<br  /><br  />Công việc&nbsp;<strong>&#91;TITLE&#93;</strong> giao cho&nbsp;<strong>&#91;USER_WORKING&#93; </strong>đã hoàn thành.<br  />Dưới đây là thông tin chi tiết tại <strong>&#91;SITE_NAME&#93;</strong>:<ul><li><strong>Tiêu đề: </strong>&#91;TITLE&#93;</li><li><strong>Người giao việc:</strong> &#91;USER_ADD&#93;</li><li><strong>Người thực hiện</strong>: &#91;USER_WORKING&#93;</li><li><strong>Thời gian bắt đầu:</strong> &#91;TIME_START&#93;</li><li><strong>Thời gian hoàn thành:</strong> &#91;TIME_END&#93;</li><li><strong>Thời gian hoàn thành thực tế:</strong> &#91;TIME_REAL&#93;</li><li><strong>Trạng thái:</strong> &#91;STATUS&#93;</li></ul>&#91;CONTENT&#93;<br  /><br  />Theo dõi và cập nhật tiến độ công việc tại &#91;TASK_URL&#93;')";

$data = array();
$data['auto_postcomm'] = '1';
$data['allowed_comm'] = '6';
$data['view_comm'] = '6';
$data['setcomm'] = '4';
$data['activecomm'] = '1';
$data['emailcomm'] = '0';
$data['adminscomm'] = '';
$data['sortcomm'] = '0';
$data['captcha'] = '1';
$data['perpagecomm'] = '5';
$data['timeoutcomm'] = '360';
$data['allowattachcomm'] = '0';
$data['alloweditorcomm'] = '0';
$data['groups_manage'] = '1';
$data['groups_use'] = '';
$data['default_status'] = '0,1,2';
$data['allow_useradd'] = '1';

foreach ($data as $config_name => $config_value) {
    $sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', " . $db->quote($module_name) . ", " . $db->quote($config_name) . ", " . $db->quote($config_value) . ")";
}