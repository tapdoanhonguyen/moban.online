<?php



/**

 * @Project NUKEVIET 4.x

 * @Author VINADES.,JSC (contact@vinades.vn)

 * @Copyright (C) 2017 VINADES.,JSC. All rights reserved

 * @License GNU/GPL version 2 or any later version

 * @Createdate 04/18/2017 09:47

 */

if (! defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$order_id = $nv_Request->get_int('order_id', 'post,get', 0);
$checkss = $nv_Request->get_string('checkss', 'post,get', 0);

$contents = "NO_" . $order_id;

if ($order_id > 0 and $checkss == md5($order_id . $global_config['sitekey'] . session_id())) {
    // Thong tin dat hang chi tiet
    $result = $db->query("SELECT * FROM " . NV_PREFIXLANG . "_" . $module_data . "_orders WHERE order_id=" . $order_id . ' AND status< 1');
    $data_order = $result->fetch();

    if( !empty( $data_order )){
        $exec = $db->exec("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_orders_id WHERE order_id=" . $order_id);
        $exec = $db->exec("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_message_queue WHERE order_id=" . $order_id);
        $exec = $db->exec("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_orders WHERE order_id=" . $order_id . " AND status < 1");
        if ($exec) {
            if ($exec) {
                $db->query("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_transaction WHERE order_id=" . $order_id);
                $contents = "OK_" . $order_id;
            }
        }
    }
}

$nv_Cache->delMod($module_name);

include NV_ROOTDIR . '/includes/header.php';
echo $contents;
include NV_ROOTDIR . '/includes/footer.php';