<?php

/**
 * @Project NUKEVIET 3.0
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2010 VINADES.,JSC. All rights reserved
 * @Createdate Thu, 14 Apr 2011 12:01:30 GMT
 */

if ( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS ".$db_config['prefix']."_".$lang."_".$module_data."_mien";
$sql_drop_module[] = "DROP TABLE IF EXISTS ".$db_config['prefix']."_".$lang."_".$module_data."_province";
$sql_drop_module[] = "DROP TABLE IF EXISTS ".$db_config['prefix']."_".$lang."_".$module_data."_district";

$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE ".$db_config['prefix']."_".$lang."_".$module_data."_mien (
id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
title varchar(250) NOT NULL DEFAULT '',
alias varchar(250) NOT NULL DEFAULT '',
weight smallint(4) unsigned NOT NULL DEFAULT '0',
status tinyint(1) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (id),
UNIQUE KEY alias (alias)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE ".$db_config['prefix']."_".$lang."_".$module_data."_province (
id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
code varchar(250) NOT NULL DEFAULT '',
idmien mediumint(8) unsigned NOT NULL DEFAULT '0',
title varchar(250) NOT NULL DEFAULT '',
alias varchar(250) NOT NULL DEFAULT '',
weight smallint(4) unsigned NOT NULL DEFAULT '0',
status tinyint(1) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (id),
UNIQUE KEY alias (alias),
UNIQUE KEY code (code)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE ".$db_config['prefix']."_".$lang."_".$module_data."_district (
id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
idprovince mediumint(8) unsigned NOT NULL DEFAULT '0',
title varchar(240) NOT NULL DEFAULT '',
alias varchar(240) NOT NULL DEFAULT '',
weight smallint(4) unsigned NOT NULL DEFAULT '0',
status tinyint(1) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (id),
UNIQUE KEY alias_idprovince (alias,idprovince)
) ENGINE=MyISAM";


$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_mien VALUES (1, 'Mi???n B???c', 'Mien-Bac',1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_mien VALUES (2, 'Mi???n Trung', 'Mien-Trung',3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_mien VALUES (3, 'Mi???n Nam', 'Mien-Nam',2, 1)";
//tinh thanh
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (1, 'HN', 1, 'H?? N???i', 'Ha-Noi', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (10, 'HCM', 3, 'TP.HCM', 'TPHCM', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (20, 'HP', 1, 'H???i Ph??ng', 'Hai-Phong', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (21, 'BG', 1, 'B???c Giang', 'Bac-Giang', 29, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (22, 'BK', 1, 'B???c K???n', 'Bac-Kan', 30, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (23, 'BN', 1, 'B???c Ninh', 'Bac-Ninh', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (24, 'CB', 1, 'Cao B???ng', 'Cao-Bang', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (25, 'DB', 1, '??i???n Bi??n', 'Dien-Bien', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (26, 'HAG', 1, 'H?? Giang', 'Ha-Giang', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (27, 'HNA', 1, 'H?? Nam', 'Ha-Nam', 9, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (28, 'HD', 1, 'H???i D????ng', 'Hai-Duong', 10, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (29, 'HB', 1, 'H??a B??nh', 'Hoa-Binh', 11, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (30, 'HY', 1, 'H??ng Y??n', 'Hung-Yen', 12, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (31, 'LC', 1, 'Lai Ch??u', 'Lai-Chau', 13, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (32, 'LS', 1, 'L???ng S??n', 'Lang-Son', 14, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (34, 'LCI', 1, 'L??o Cai', 'Lao-Cai', 15, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (35, 'ND', 1, 'Nam ?????nh', 'Nam-Dinh', 16, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (36, 'NB', 1, 'Ninh B??nh', 'Ninh-Binh', 17, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (37, 'PT', 1, 'Ph?? Th???', 'Phu-Tho', 18, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (38, 'QN', 1, 'Qu???ng Ninh', 'Quang-Ninh', 19, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (39, 'SL', 1, 'S??n La', 'Son-La', 20, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (40, 'TB', 1, 'Th??i B??nh', 'Thai-Binh', 21, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (41, 'THN', 1, 'Th??i Nguy??n', 'Thai-Nguyen', 22, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (42, 'TH', 1, 'Thanh H??a', 'Thanh-Hoa', 23, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (43, 'TQ', 1, 'Tuy??n Quang', 'Tuyen-Quang', 24, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (44, 'VP', 1, 'V??nh Ph??c', 'Vinh-Phuc', 25, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (45, 'YB', 1, 'Y??n B??i', 'Yen-Bai', 26, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (46, 'DNG', 2, '???? N???ng', 'Da-Nang', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (47, 'BDH', 2, 'B??nh ?????nh', 'Binh-Dinh', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (48, 'BP', 2, 'B??nh Ph?????c', 'Binh-Phuoc', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (49, 'BT', 2, 'B??nh Thu???n', 'Binh-Thuan', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (50, 'DLK', 2, '?????k L???k', 'Dak-Lak', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (51, 'DNO', 2, '?????k N??ng', 'Dak-Nong', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (52, 'GL', 2, 'Gia Lai', 'Gia-Lai', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (53, 'HTH', 2, 'H?? T??nh', 'Ha-Tinh', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (54, 'KH', 2, 'Kh??nh H??a', 'Khanh-Hoa', 9, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (55, 'KT', 2, 'Kon Tum', 'Kon-Tum', 10, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (56, 'LD', 2, 'L??m ?????ng', 'Lam-Dong', 11, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (57, 'NA', 2, 'Ngh??? An', 'Nghe-An', 12, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (58, 'NT', 2, 'Ninh Thu???n', 'Ninh-Thuan', 13, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (59, 'PY', 2, 'Ph?? Y??n', 'Phu-Yen', 14, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (60, 'QB', 2, 'Qu???ng B??nh', 'Quang-Binh', 15, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (61, 'QNM', 2, 'Qu???ng Nam', 'Quang-Nam', 16, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (62, 'QNI', 2, 'Qu???ng Ng??i', 'Quang-Ngai', 17, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (63, 'QT', 2, 'Qu???ng Tr???', 'Quang-Tri', 18, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (64, 'TTH', 2, 'Th???a Thi??n Hu???', 'Thua-Thien-Hue', 19, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (65, 'CT', 3, 'C???n Th??', 'Can-Tho', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (66, 'AG', 3, 'An Giang', 'An-Giang', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (67, 'BR-VT', 3, 'BR - V??ng T??u', 'BR-Vung-Tau', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (68, 'BL', 3, 'B???c Li??u', 'Bac-Lieu', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (69, 'BTR', 3, 'B???n Tre', 'Ben-Tre', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (70, 'BD', 3, 'B??nh D????ng', 'Binh-Duong', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (71, 'CM', 3, 'C?? Mau', 'Ca-Mau', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (72, 'DN', 3, '?????ng Nai', 'Dong-Nai', 9, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (73, 'DT', 3, '?????ng Th??p', 'Dong-Thap', 10, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (74, 'HG', 3, 'H???u Giang', 'Hau-Giang', 11, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (75, 'KG', 3, 'Ki??n Giang', 'Kien-Giang', 12, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (76, 'LA', 3, 'Long An', 'Long-An', 13, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (77, 'ST', 3, 'S??c Tr??ng', 'Soc-Trang', 14, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (78, 'TN', 3, 'T??y Ninh', 'Tay-Ninh', 15, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (79, 'TG', 3, 'Ti???n Giang', 'Tien-Giang', 16, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (80, 'TV', 3, 'Tr?? Vinh', 'Tra-Vinh', 17, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_province VALUES (81, 'VL', 3, 'V??nh Long', 'Vinh-Long', 18, 1)";

//quan huyen
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (3, 1, 'Thanh Xu??n', 'Q-Thanh-Xuan', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (4, 1, 'Ho??n Ki???m', 'Q-Hoan-Kiem', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (13, 10, 'Qu???n 1', 'Q-1', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (14, 10, 'Qu???n 2', 'Quan-2', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (15, 10, 'Qu???n 3', 'Quan-3', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (18, 10, 'Q. B??nh Th???nh', 'Q-Binh-Thanh', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (82, 1, 'Q. Ba ????nh', 'Q-Ba-Dinh', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (83, 1, 'Q. C???u Gi???y', 'Q-Cau-Giay', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (84, 1, 'Q. ?????ng ??a', 'Q-Dong-Da', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (85, 1, 'Q. H?? ????ng', 'Q-Ha-Dong', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (86, 1, 'Q. Hai B?? Tr??ng', 'Q-Hai-Ba-Trung', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (87, 1, 'Q. Ho??ng Mai', 'Q-Hoang-Mai', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (88, 1, 'Q. Long Bi??n', 'Q-Long-Bien', 9, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (89, 1, 'Q. T??y H???', 'Q-Tay-Ho', 10, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (90, 1, 'TX S??n T??y', 'TX-Son-Tay', 11, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (91, 1, 'H. Ba V??', 'H-Ba-Vi', 12, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (92, 1, 'H. Ch????ng M???', 'H-Chuong-My', 13, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (93, 1, 'H. ??an Ph?????ng', 'H-Dan-Phuong', 14, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (94, 1, 'H. ????ng Anh', 'H-Dong-Anh', 15, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (95, 1, 'H. Gia L??m', 'H-Gia-Lam', 16, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (96, 1, 'H. Ho??i ?????c', 'H-Hoai-Duc', 17, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (97, 1, 'H. M?? Linh', 'H-Me-Linh', 18, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (98, 1, 'H. M??? ?????c', 'H-My-Duc', 19, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (99, 1, 'H. Ph?? Xuy??n', 'H-Phu-Xuyen', 20, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (100, 1, 'H. Ph??c Th???', 'H-Phuc-Tho', 21, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (101, 1, 'H. Qu???c Oai', 'H-Quoc-Oai', 22, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (102, 1, 'H. S??c S??n', 'H-Soc-Son', 23, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (103, 1, 'H. Th???ch Th???t', 'H-Thach-That', 24, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (104, 1, 'H. Thanh Oai', 'H-Thanh-Oai', 25, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (105, 1, 'H. Thanh Tr??', 'H-Thanh-Tri', 26, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (106, 1, 'H. Th?????ng T??n', 'H-Thuong-Tin', 27, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (107, 1, 'H. T??? Li??m', 'H-Tu-Liem', 28, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (108, 1, 'H. ???ng H??a', 'H-Ung-Hoa', 29, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (109, 20, 'H. An D????ng', 'H-An-Duong', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (110, 20, 'H. An L??o', 'H-An-Lao', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (111, 20, 'H. ?????o B???ch Long V??', 'H-Dao-Bach-Long-Vi', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (112, 20, 'H. C??t H???i', 'H-Cat-Hai', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (113, 20, 'H. Ki???n Th???y', 'H-Kien-Thuy', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (114, 20, 'H. Thu??? Nguy??n', 'H-Thuy-Nguyen', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (115, 20, 'H. Ti??n L??ng', 'H-Tien-Lang', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (116, 20, 'H. V??nh B???o', 'H-Vinh-Bao', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (117, 20, 'Q. H???i An', 'Q-Hai-An', 9, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (118, 20, 'Q. H???ng B??ng', 'Q-Hong-Bang', 10, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (119, 20, 'Q. Ki???n An', 'Q-Kien-An', 11, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (120, 20, 'Q. L?? Ch??n', 'Q-Le-Chan', 12, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (121, 20, 'Q. Ng?? Quy???n', 'Q-Ngo-Quyen', 13, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (122, 20, 'TX  ????? S??n', 'TX-Do-Son', 14, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (123, 10, 'Qu???n 4', 'Quan-4', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (124, 10, 'Qu???n 5', 'Quan-5', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (125, 10, 'Qu???n 6', 'Quan-6', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (126, 10, 'Qu???n 7', 'Quan-7', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (127, 10, 'Qu???n 8', 'Quan-8', 9, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (128, 10, 'Qu???n 9', 'Quan-9', 10, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (129, 10, 'Qu???n 10', 'Quan-10', 11, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (130, 10, 'Qu???n 11', 'Quan-11', 12, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (131, 10, 'Qu???n 12', 'Quan-12', 13, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (132, 10, 'Q.  T??n B??nh', 'Q-Tan-Binh', 14, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (133, 10, 'Q. Ph?? Nhu???n', 'Q-Phu-Nhuan', 15, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (134, 10, 'Q. Th??? ?????c', 'Q-Thu-Duc', 16, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (135, 10, 'Q. G?? V???p', 'Q-Go-Vap', 17, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (136, 10, 'Q. B??nh T??n', 'Q-Binh-Tan', 18, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (137, 10, 'Q.  T??n Ph??', 'Q-Tan-Phu', 19, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (138, 10, 'H. Nh?? B??', 'H-Nha-Be', 20, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (139, 10, 'H. C???n Gi???', 'H-Can-Gio', 21, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (140, 10, 'H. H??c M??n', 'H-Hoc-Mon', 22, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (899, 67, 'TP. V??ng T??u', 'TP-Vung-Tau', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1197, 46, 'H???i Ch??u', 'Hai-Chau', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1198, 46, 'Thanh Kh??', 'Thanh-Khe', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1199, 46, 'S??n Tr??', 'Son-Tra', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1200, 46, 'Ng?? H??nh S??n', 'Ngu-Hanh-Son', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1201, 46, 'Li??n Chi???u', 'Lien-Chieu', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1202, 46, 'C???m L???', 'Cam-Le', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1203, 46, 'H??a Vang', 'Hoa-Vang', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1204, 46, '?????o Ho??ng Sa', 'Dao-Hoang-Sa', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1277, 21, 'TP. B???c Giang.', 'TP-Bac-Giang', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1278, 21, 'Y??n Th???', 'Yen-The', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1279, 21, 'T??n Y??n', 'Tan-Yen', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1280, 21, 'L???c Ng???n.', 'Luc-Ngan', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1281, 21, 'Hi???p Ho??.', 'Hiep-Hoa', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1282, 21, 'L???ng Giang', 'Lang-Giang', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1283, 21, 'S??n ?????ng', 'Son-Dong', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1284, 21, 'L???c Nam', 'Luc-Nam', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1285, 21, 'Vi???t Y??n', 'Viet-Yen', 9, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1286, 21, 'Y??n D??ng', 'Yen-Dung', 10, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1452, 22, 'TX B???c K???n', 'TX-Bac-Kan', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1453, 22, 'Ba B???', 'Ba-Be', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1454, 22, 'B???ch Th??ng', 'Bach-Thong', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1455, 22, 'Ch??? ?????n', 'Cho-Don', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1456, 22, 'Ch??? M???i', 'Cho-Moi', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1457, 22, 'Na R??', 'Na-Ri', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1458, 22, 'Ng??n S??n', 'Ngan-Son', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1459, 22, 'P??c N???m', 'Pac-Nam', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1567, 23, 'Tp. B???c Ninh', 'Tp-Bac-Ninh', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1568, 23, 'T??? S??n', 'Tu-Son', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1569, 23, 'Gia B??nh', 'Gia-Binh', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1570, 23, 'L????ng T??i', 'Luong-Tai', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1571, 23, 'Qu??? V??', 'Que-Vo', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1572, 23, 'Thu???n Th??nh', 'Thuan-Thanh', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1573, 23, 'Ti??n Du', 'Tien-Du', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1574, 23, 'Y??n Phong', 'Yen-Phong', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1686, 24, 'B???o L???c', 'Bao-Lac', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1687, 24, 'B???o L??m', 'Bao-Lam', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1688, 24, 'H??? Lang', 'Ha-Lang', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1689, 24, 'H?? Qu???ng', 'Ha-Quang', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1690, 24, 'H??a An', 'Hoa-An', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1691, 24, 'Nguy??n B??nh', 'Nguyen-Binh', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1692, 24, 'Ph???c H??a', 'Phuc-Hoa', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1693, 24, 'Qu???ng Uy??n', 'Quang-Uyen', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1694, 24, 'Th???ch An', 'Thach-An', 9, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1695, 24, 'Th??ng N??ng', 'Thong-Nong-1', 10, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1696, 24, 'Tr?? L??nh', 'Tra-Linh', 11, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1697, 24, 'Tr??ng Kh??nh', 'Trung-Khanh', 12, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1763, 67, 'Tx B?? R???a', 'Tx-Ba-Ria', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1764, 67, 'Long ??i???n', 'Long-Dien', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1765, 67, '?????t ?????', 'Dat-Do', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1766, 67, 'Ch??u ?????c', 'Chau-Duc', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1767, 67, 'T??n Th??nh', 'Tan-Thanh', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1768, 67, 'C??n ?????o', 'Con-Dao', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (1769, 67, 'Xuy??n M???c', 'Xuyen-Moc', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2132, 25, 'Tp. ??i???n Bi??n Ph???', 'Tp-Dien-Bien-Phu', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2133, 25, 'Tx.  M?????ng Lay', 'Tx-Muong-Lay', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2134, 25, '??i???n Bi??n', 'Dien-Bien', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2135, 25, '??i???n Bi??n ????ng', 'Dien-Bien-Dong', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2136, 25, 'M?????ng ???ng', 'Muong-Ang', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2137, 25, 'M?????ng Ch??', 'Muong-Cha', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2138, 25, 'M?????ng Nh??', 'Muong-Nhe', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2139, 25, 'T???a Ch??a', 'Tua-Chua', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2140, 25, 'Tu???n Gi??o', 'Tuan-Giao', 9, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2237, 26, 'Tp. H?? Giang', 'Tp-Ha-Giang', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2238, 26, 'B???c M??', 'Bac-Me', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2239, 26, 'B???c Quang', 'Bac-Quang', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2240, 26, '?????ng V??n', 'Dong-Van', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2241, 26, 'Ho??ng Su Ph??', 'Hoang-Su-Phi', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2242, 26, 'M??o V???c', 'Meo-Vac', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2243, 26, 'Qu???n B???', 'Quan-Ba', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2244, 26, 'Quang B??nh', 'Quang-Binh', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2245, 26, 'V??? Xuy??n', 'Vi-Xuyen', 9, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2246, 26, 'X??n M???n', 'Xin-Man', 10, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2247, 26, 'Y??n Minh', 'Yen-Minh', 11, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2403, 27, 'Tp. Ph??? L??', 'Tp-Phu-Ly', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2404, 27, 'B??nh L???c', 'Binh-Luc', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2405, 27, 'Duy Ti??n', 'Duy-Tien', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2406, 27, 'Kim B???ng', 'Kim-Bang', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2407, 27, 'L?? Nh??n', 'Ly-Nhan', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2408, 27, 'Thanh Li??m', 'Thanh-Liem', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2523, 28, 'Tp. H???i D????ng', 'Tp-Hai-Duong', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2524, 28, 'Ch?? Linh', 'Chi-Linh', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2525, 28, 'B??nh Giang', 'Binh-Giang', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2526, 28, 'C???m Gi??ng', 'Cam-Giang', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2527, 28, 'Gia L???c', 'Gia-Loc', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2528, 28, 'Kim Th??nh', 'Kim-Thanh', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2529, 28, 'Kinh M??n', 'Kinh-Mon', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2530, 28, 'Nam S??ch', 'Nam-Sach', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2531, 28, 'Ninh Giang', 'Ninh-Giang', 9, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2532, 28, 'Thanh H??', 'Thanh-Ha', 10, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2533, 28, 'Thanh Mi???n', 'Thanh-Mien', 11, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2534, 28, 'T??? K???', 'Tu-Ky', 12, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2775, 29, 'L????ng S??n', 'Luong-Son', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2776, 29, 'Cao Phong', 'Cao-Phong', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2777, 29, '???? B???c', 'Da-Bac', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2778, 29, 'Kim B??i', 'Kim-Boi', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2779, 29, 'K??? S??n', 'Ky-Son', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2780, 29, 'L???c S??n', 'Lac-Son', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2781, 29, 'L???c Th???y', 'Lac-Thuy', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2782, 29, 'Mai Ch??u', 'Mai-Chau', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2783, 29, 'T??n L???c', 'Tan-Lac', 9, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2784, 29, 'Y??n Th???y', 'Yen-Thuy', 10, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2826, 30, 'Tp.  H??ng Y??n', 'Tp-Hung-Yen', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2827, 30, '??n Thi', 'An-Thi', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2828, 30, 'Kho??i Ch??u', 'Khoai-Chau', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2829, 30, 'Kim ?????ng', 'Kim-Dong', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2830, 30, 'M??? H??o', 'My-Hao', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2831, 30, 'Ph?? C???', 'Phu-Cu', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2832, 30, 'Ti??n L???', 'Tien-Lu', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2833, 30, 'V??n Giang', 'Van-Giang', 8, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2834, 30, 'V??n L??m', 'Van-Lam', 9, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2835, 30, 'Y??n M???', 'Yen-My', 10, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2836, 31, 'Lai Ch??u', 'Lai-Chau', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2837, 31, 'M?????ng T??', 'Muong-Te', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2838, 31, 'Phong Th???', 'Phong-Tho', 3, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2839, 31, 'S??n H???', 'Sin-Ho', 4, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2840, 31, 'Tam ???????ng', 'Tam-Duong', 5, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2841, 31, 'Than Uy??n', 'Than-Uyen', 6, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2842, 31, 'T??n Uy??n', 'Tan-Uyen', 7, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2843, 32, 'Tr??ng ?????nh', 'Trang-Dinh', 1, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2844, 32, 'V??n L??ng', 'Van-Lang', 2, 1)";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_district VALUES (2845, 32, 'V??n Quan', 'Van-Quan', 3, 1)";