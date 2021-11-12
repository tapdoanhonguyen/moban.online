<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2018 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Fri, 12 Jan 2018 07:59:54 GMT
 */

if( ! defined( 'NV_IS_FILE_MODULES' ) ) die( 'Stop!!!' );

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data;
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . '_company';
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . '_producer';//nha san xuat
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . '_producttype';//loai tai san
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . '_department';//phong ban
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . '_unit';//don vi tai san
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . '_product';//san pham - tai san
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . '_inventory';//kiem ke tai san
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . '_inventory_users';//thành phâm giam gia kiem ke tai san
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . '_inventory_detail';//chi tiết kiem ke tai san

$sql_create_module = $sql_drop_module;
$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "(
  id smallint(4) NOT NULL AUTO_INCREMENT,
  companyid smallint(4) NOT NULL,
  code varchar(20) NOT NULL,
  first_name varchar(100) NOT NULL,
  last_name varchar(50) NOT NULL,
  gender tinyint(1) unsigned NOT NULL DEFAULT '1',
  birthday int(11) unsigned NOT NULL DEFAULT '0',
  phone varchar(20) NOT NULL,
  email varchar(100) NOT NULL,
  scmnd varchar(100) NOT NULL,
  ngaycap int(11) unsigned NOT NULL DEFAULT '0',
  noicap varchar(100) NOT NULL,
  address varchar(250) NOT NULL,
  image varchar(250) NOT NULL,
  worktype tinyint(1) unsigned NOT NULL DEFAULT '0',
  sobhxh varchar(100) NOT NULL COMMENT 'So xo bhxh',
  sohdld varchar(100) NOT NULL COMMENT 'Hop dong lao dong',
  ngaykyhopdong int(10) unsigned NOT NULL COMMENT 'Ngay ky hop dong',
  ngaynghiviec int(10) unsigned NOT NULL COMMENT 'Ngay nghi viec',
  biensoxe varchar(100) NOT NULL COMMENT 'Bien so xe',
  addtime int(10) unsigned NOT NULL,
  edittime int(10) unsigned NOT NULL DEFAULT '0',
  useradd mediumint(8) unsigned NOT NULL,
  status tinyint(1) unsigned NOT NULL DEFAULT '1',
  UNIQUE KEY code (code),
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_company (
 id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
 title varchar(250) NOT NULL,
 note text NOT NULL,
 PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_producer (
 id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
 title varchar(250) NOT NULL,
 note text NOT NULL,
 PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_producttype (
 id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
 title varchar(250) NOT NULL,
 note text NOT NULL,
 PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_department (
 id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
 userid int(10) NOT NULL COMMENT 'Người quản lý',
 title varchar(250) NOT NULL,
 note text NOT NULL,
 PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (
 id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
 title varchar(250) NOT NULL,
 note text NOT NULL,
 PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product (
 id int(10) unsigned NOT NULL AUTO_INCREMENT,
 producerid smallint(4) NOT NULL,
 departmentid smallint(4) NOT NULL COMMENT 'Đơn vị sử dụng',
 producttypeid smallint(4) NOT NULL COMMENT 'loai tai san',
 unitid smallint(4) NOT NULL COMMENT 'don vi tai san',
 room_use varchar(250) NOT NULL COMMENT 'Phòng sử dụng',
 code varchar(250) NOT NULL COMMENT 'Mã ID',
 title varchar(250) NOT NULL COMMENT 'Tên tài sản',
 time_in int(10) unsigned NOT NULL COMMENT 'Ngày mua tài sản',
 time_depreciation tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Thời gian khấu hao = tháng',
 price float unsigned NOT NULL COMMENT 'Tổng giá trị tài sản',
 amount int(10) unsigned NOT NULL COMMENT 'Số lượng',
 addtime int(10) unsigned NOT NULL COMMENT 'Ngày nhập',
 status tinyint(1) unsigned NOT NULL DEFAULT '1',
 PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_inventory (
 id int(10) unsigned NOT NULL AUTO_INCREMENT,
 departmentid smallint(4) NOT NULL,
 time_inventory int(10) unsigned NOT NULL COMMENT 'Ngày kiểm kê',
 addtime int(10) unsigned NOT NULL COMMENT 'Ngày nhập',
 PRIMARY KEY (id)
) ENGINE=MyISAM";

//thanh pham tham gia kiem ke
$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_inventory_users (
 iid int(10) unsigned NOT NULL AUTO_INCREMENT,
 userid int(10) NOT NULL COMMENT 'Userid',
 postion_name varchar(150) NOT NULL COMMENT 'Chức vụ',
 checked tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Xác nhận kiểm kê',
 time_checked int(10) unsigned NOT NULL COMMENT 'Ngày xác nhận',
 UNIQUE KEY userid (iid, userid)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_inventory_detail (
 iid int(10) NOT NULL COMMENT 'ID kiểm kê',
 pid int(10) unsigned NOT NULL COMMENT 'ID sản phẩm',
 price float unsigned NOT NULL COMMENT 'Giá trị tài sản thời điểm kiểm kê',
 amount int(10) unsigned NOT NULL COMMENT 'Số lượng kiểm kê',
 amount_broken int(10) unsigned NOT NULL COMMENT 'Số lượng hỏng',
 amount_redundant int(10) unsigned NOT NULL COMMENT 'Số lượng thừa',
 amount_missing int(10) unsigned NOT NULL COMMENT 'Số lượng thiếu',
 note varchar(250) NOT NULL COMMENT 'Ghi chú',
 UNIQUE KEY pid (iid, pid)
) ENGINE=MyISAM";


$sql_create_module[] = "INSERT INTO " .$db_config['prefix'] . "_" . $lang . "_" . $module_data . " (id, companyid, code, first_name, last_name, gender, birthday, phone, email, scmnd, ngaycap, noicap, address, image, worktype, sobhxh, sohdld, ngaykyhopdong, ngaynghiviec, biensoxe, addtime, edittime, useradd, status) VALUES
(1, 1, 'W0001', 'Đức', 'Bùi Đình', 1, 570385439, '0916618600', 'dinhduc@gmail.com', '113424534', 1418574239, 'HCM', 'HCM', 'hoidap24h_p6qyj3iw_1.jpg', 0, '454645645645', '645645', 1523723039, 0, '54F8 - 6212', 1525275495, 1526401087, 1, 1),
(2, 1, 'W0002', 'Hưng', 'Nguyễn Văn', 1, 579457439, '0912678600', 'hungnv@gmail.com', '', 0, '', '', '', 0, '', '', 0, 0, '65F8 - 6268', 1526397371, 1526401017, 1, 1)";

$sql_create_module[] = "INSERT INTO " .$db_config['prefix'] . "_" . $lang . "_" . $module_data . "_company (id, title, note) VALUES
(1, 'Chi nhánh Đắk Lắc', ''),
(2, 'Chi nhánh SG', '')";

$sql_create_module[] = "INSERT INTO " .$db_config['prefix'] . "_" . $lang . "_" . $module_data . "_department (id, userid, title, note) VALUES
(1, 1, 'HCNS', ''),
(2, 4, 'Phòng KD - HCM', 'Phòng KD'),
(3, 2, 'Phòng KD - Hà Nội', '')";

$sql_create_module[] = "INSERT INTO " .$db_config['prefix'] . "_" . $lang . "_" . $module_data . "_producer (id, title, note) VALUES
(5, 'Honda', 'công ty honda'),
(4, 'Toyota', '')";


$sql_create_module[] = "INSERT INTO " .$db_config['prefix'] . "_" . $lang . "_" . $module_data . "_product (id, producerid, departmentid, producttypeid, unitid, room_use, code, title, time_in, time_depreciation, price, amount, addtime, status) VALUES
(1, 5, 1, 2, 1, 'Phòng content', 'H120', 'Máy tính đồng bộ', 1525194000, 12, 5000000, 1, 1525189184, 1),
(2, 5, 1, 1, 1, 'Kinh doanh 1', '103', 'Điện thoại telesale', 1514739600, 12, 5000000, 10, 1525190006, 1),
(4, 5, 1, 2, 1, 'Khảo sát', '121', 'Xe máy công việc', 1431277200, 48, 50000000, 5, 1526397255, 1)";

$sql_create_module[] = "INSERT INTO " .$db_config['prefix'] . "_" . $lang . "_" . $module_data . "_producttype (id, title, note) VALUES
(1, 'Tài sản văn phòng', ''),
(2, 'Tài sản công trường', '')";

$sql_create_module[] = "INSERT INTO " .$db_config['prefix'] . "_" . $lang . "_" . $module_data . "_unit (id, title, note) VALUES
(1, 'Cái', ''),
(2, 'Chiếc', '')";

// Cau hinh dang bai ngoai trang
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'group_add_workforce', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'group_view_workforce', '')";
$sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', '" . $module_name . "', 'precode', '" . strtoupper(substr($module_name, 0, 1)) . '%04s' . "')";