<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Mr.Thang (contact@vinades.vn)
 * @Copyright (C) 2014 Mr.Thang. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$page_title = $lang_module['config'];

$data = array();
if ($nv_Request->isset_request('savesetting', 'post')) {

    $data['road_use'] = $nv_Request->get_title('road_use', 'post', '');
    $data['civil_insurance_4'] = $nv_Request->get_title('civil_insurance_4', 'post', '');
    $data['civil_insurance_5'] = $nv_Request->get_title('civil_insurance_5', 'post', '');
    $data['civil_insurance_6'] = $nv_Request->get_title('civil_insurance_6', 'post', '');
    $data['civil_insurance_7'] = $nv_Request->get_title('civil_insurance_7', 'post', '');
    $data['registration'] = $nv_Request->get_title('registration', 'post', '');
    $data['road_use'] = floatval(preg_replace('/[^0-9\,]/', '', $data['road_use']));
    $data['civil_insurance_4'] = floatval(preg_replace('/[^0-9\,]/', '', $data['civil_insurance_4']));
    $data['civil_insurance_5'] = floatval(preg_replace('/[^0-9\,]/', '', $data['civil_insurance_5']));
    $data['civil_insurance_6'] = floatval(preg_replace('/[^0-9\,]/', '', $data['civil_insurance_6']));
    $data['civil_insurance_7'] = floatval(preg_replace('/[^0-9\,]/', '', $data['civil_insurance_7']));
    $data['registration'] = floatval(preg_replace('/[^0-9\,]/', '', $data['registration']));

    $sth = $db->prepare("UPDATE " . NV_CONFIG_GLOBALTABLE . " SET config_value = :config_value WHERE lang = '" . NV_LANG_DATA . "' AND module = :module_name AND config_name = :config_name");
    $sth->bindParam(':module_name', $module_name, PDO::PARAM_STR);
    foreach ($data as $config_name => $config_value) {
        $sth->bindParam(':config_name', $config_name, PDO::PARAM_STR);
        $sth->bindParam(':config_value', $config_value, PDO::PARAM_STR);
        $sth->execute();
    }
    
    nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['config'], "Config", $admin_info['userid']);
    $nv_Cache->delMod('settings');
    
    Header("Location: " . NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . '=' . $op);
    die();
}

$array_config = $module_config[$module_name];
$array_config['road_use'] = number_format( $array_config['road_use'], 0, ',', '.');
$array_config['civil_insurance_4'] = number_format( $array_config['civil_insurance_4'], 0, ',', '.');
$array_config['civil_insurance_5'] = number_format( $array_config['civil_insurance_5'], 0, ',', '.');
$array_config['civil_insurance_6'] = number_format( $array_config['civil_insurance_6'], 0, ',', '.');
$array_config['civil_insurance_7'] = number_format( $array_config['civil_insurance_7'], 0, ',', '.');
$array_config['registration'] = number_format( $array_config['registration'], 0, ',', '.');

$xtpl = new XTemplate($op . ".tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('DATA', $array_config);

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';