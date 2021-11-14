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

$page_title = $lang_module['report_bonus_ctv'];
$table_name = NV_PREFIXLANG . "_" . $module_data . "_orders";

$checkss = $nv_Request->get_string('checkss', 'get', '');
$where = '';
$search = array();
if ($checkss == md5(session_id())) {

    $search['order_code'] = $nv_Request->get_title('order_code', 'get', '');
    $search['date_from'] = $nv_Request->get_title('from', 'get', '');
    $search['date_to'] = $nv_Request->get_title('to', 'get', '');
    $search['order_email'] = $nv_Request->get_title('order_email', 'get', '');
    $search['order_phone'] = $nv_Request->get_title('order_phone', 'get', '');
    $search['order_name'] = $nv_Request->get_title('order_name', 'get', '');
    $search['order_payment'] = $nv_Request->get_title('order_payment', 'get', '');
    $search['agencyid'] = $nv_Request->get_int('agencyid', 'get', 0);
    $search['producttype'] = $nv_Request->get_int('producttype', 'get', 0);

    if (! empty($search['order_code'])) {
        $where .= ' AND order_code like "%' . $search['order_code'] . '%"';
    }
    if (! empty($search['date_from'])) {
        if (! empty($search['date_from']) and preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $search['date_from'], $m)) {
            $search['date_from'] = mktime(0, 0, 0, $m[2], $m[1], $m[3]);
        } else {
            $search['date_from' ] = NV_CURRENTTIME;
        }
        $where .= ' AND order_time >= ' . $search['date_from'] . '';
    }

    if (! empty($search['date_to'])) {
        if (! empty($search['date_to']) and preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $search['date_to'], $m)) {
            $search['date_to'] = mktime(23, 59, 59, $m[2], $m[1], $m[3]);
        } else {
            $search['date_to' ] = NV_CURRENTTIME;
        }
        $where .= ' AND order_time <= ' . $search['date_to'] . '';
    }

    if (! empty($search['order_email'])) {
        $where .= ' AND order_email like "%' . $search['order_email'] . '%"';
    }
    if (! empty($search['order_phone'])) {
        $where .= ' AND order_phone like "%' . $search['order_phone'] . '%"';
    }
    if (! empty($search['order_name'])) {
        $where .= ' AND order_name like "%' . $search['order_name'] . '%"';
    }
    if ($search['order_payment'] != '-2') {
        $where .= ' AND status  = ' . $search['order_payment'];
    }

    if (! empty($search['producttype']) && $search['producttype'] != 0) {
        $producttype = $search['producttype'] - 1;
        $where .= ' AND producttype  = ' . $producttype;
    }

    if (! empty($search['agencyid']) && $search['agencyid'] != 0) {
        $where .= ' AND (customer_id  = ' . $search['agencyid'] . ' or user_id = ' . $search['agencyid'] . ')';
    }
}

$transaction_status = array(
    '2' => $lang_module['history_payment_check'],
    '4' => $lang_module['history_payment_yes'],
    '5' => $lang_module['history_order_ships'],
    '0' => $lang_module['history_payment_no']);

$search_months = array(
    array( 'key' => 1, 'value' => 31, 'title' => $lang_module['search_month_1']),
    array( 'key' => 2, 'value' => 29, 'title' => $lang_module['search_month_2']),
    array( 'key' => 3, 'value' => 31, 'title' => $lang_module['search_month_3']),
    array( 'key' => 4, 'value' => 30, 'title' => $lang_module['search_month_4']),
    array( 'key' => 5, 'value' => 31, 'title' => $lang_module['search_month_5']),
    array( 'key' => 6, 'value' => 30, 'title' => $lang_module['search_month_6']),
    array( 'key' => 7, 'value' => 31, 'title' => $lang_module['search_month_7']),
    array( 'key' => 8, 'value' => 31, 'title' => $lang_module['search_month_8']),
    array( 'key' => 9, 'value' => 30, 'title' => $lang_module['search_month_9']),
    array( 'key' => 10, 'value' => 31, 'title' => $lang_module['search_month_10']),
    array( 'key' => 11, 'value' => 30, 'title' => $lang_module['search_month_11']),
    array( 'key' => 12, 'value' => 31, 'title' => $lang_module['search_month_12'])
);

$xtpl = new XTemplate("rpt_bonus_ctv.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

$per_page = 20;
$page = $nv_Request->get_int('page', 'get', 1);
$base_url = NV_BASE_ADMINURL . "index.php?" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op;

$sql = 'SELECT t1.*, concat(t2.first_name, " ", t2.last_name) as partner, t2.username ';
$sql .= 'FROM (SELECT user_id, sum(order_total - saleoff) as sale';
$sql .= '		FROM nv4_vi_sm_orders ';
$sql .= '		WHERE user_id > 0 and producttype = 0 and chossentype != 3';
$sql .= $where;
$sql .= '		GROUP BY user_id) as t1 ';
$sql .= '	LEFT OUTER JOIN nv4_users t2 ON t1.user_id=t2.userid  ';

//die($db->sql());
$query = $db->query($sql);
$array_sum = array();
$array_sum['sum_sale'] = $array_sum['sum_bonus_sale'] = $array_sum['sum_bonus_direct'] = $array_sum['rpt_sum_bonus_indirect'] = $array_sum['rpt_sum_bonus_total'] = 0;
$num_items = 0;
//$data_label = array();
//$data_value = array();
//$data_bgcolor = array();
while ($row = $query->fetch()) {
    $num_items++;
    $sale = $row['sale'];
    $bonus_sale = nv_get_total_bonus_sales($sale);
    $bonus_direct = 0;
    $bonus_indirect = 0;
    $bonus_total = $bonus_sale + $bonus_direct + $bonus_indirect;

    if ($bonus_total > 0) {
        $proc = ceil(($bonus_total / 10000000) * 100);

        $xtpl->assign('SRC', NV_BASE_SITEURL . 'themes/default/images/statistics/bg2.gif');
        $xtpl->assign('WIDTH', $proc * 3);

        $xtpl->parse('main.data.row.img');
    }

    $array_sum['sum_sale'] = $array_sum['sum_sale'] + $sale;
    $array_sum['sum_bonus_sale'] = $array_sum['sum_bonus_sale'] + $bonus_sale;
    $array_sum['sum_bonus_direct'] = $array_sum['sum_bonus_direct'] + $bonus_direct;
    $array_sum['sum_bonus_indirect'] = $array_sum['sum_bonus_indirect'] + $bonus_indirect;
    $array_sum['sum_bonus_total'] = $array_sum['sum_bonus_total'] + $bonus_total;

    $row['sale'] = number_format( $sale, 0, '.', ',');
    $row['bonus_sale'] = number_format( $bonus_sale, 0, '.', ',');
    $row['bonus_direct'] = number_format( $bonus_direct, 0, '.', ',');
    $row['bonus_indirect'] = number_format( $bonus_indirect, 0, '.', ',');
    $row['bonus_total'] = number_format( $bonus_total, 0, '.', ',');

    $xtpl->assign('DATA', $row);
    $xtpl->parse('main.data.row');

    //$data_label[] = $row['partner'];
    //$data_value[] = $row['bonus_total'];
    //$data_bgcolor[] = 'rgb(' . rand(0,255) . ', '. rand(0,255) . ', ' . rand(0,255) . ')';


}

$data_label = array($lang_module['rpt_sum_bonus_sale'],$lang_module['rpt_sum_bonus_direct'],$lang_module['rpt_sum_bonus_indirect']);
$data_value = array($array_sum['sum_bonus_sale'],$array_sum['sum_bonus_direct'],$array_sum['sum_bonus_indirect']);
$data_bgcolor = array(
    'rgb(255, 99, 132)',
    'rgb(255, 159, 64)',
    'rgb(201, 203, 207)'
);

$xtpl->assign('DATA_LABEL', '"' . implode('", "', $data_label) . '"');
$xtpl->assign('DATA_BGCOLOR', '"' . implode('", "', $data_bgcolor) . '"');
$xtpl->assign('DATA_VALUE', implode(', ', $data_value));

$xtpl->parse('main.data.bonus');

$array_sum['num_items'] = number_format( $num_items, 0, '.', ',');
$array_sum['sum_sale'] = number_format( $array_sum['sum_sale'], 0, '.', ',');
$array_sum['sum_bonus_sale'] = number_format( $array_sum['sum_bonus_sale'], 0, '.', ',');
$array_sum['sum_bonus_direct'] = number_format( $array_sum['sum_bonus_direct'], 0, '.', ',');
$array_sum['sum_bonus_indirect'] = number_format( $array_sum['sum_bonus_indirect'], 0, '.', ',');
$array_sum['sum_bonus_total'] = number_format( $array_sum['sum_bonus_total'], 0, '.', ',');

$xtpl->assign('SUM', $array_sum);
$xtpl->assign('sql_show', base64_encode($db->sql()));
$xtpl->assign('PAGES', nv_generate_page($base_url, $num_items, $per_page, $page));
$xtpl->assign('num_items', $num_items);
$xtpl->parse('main.data');

foreach ($transaction_status as $key => $lang_status) {

    $xtpl->assign('TRAN_STATUS', array( 'key' => $key, 'title' => $lang_status, 'selected' => (isset($search['order_payment']) and $key == $search['order_payment']) ? 'selected="selected"' : '' ));
    $xtpl->parse('main.transaction_status');
}

foreach ($search_months as $month) {
    $xtpl->assign('SEARCH_MONTH', array( 'key' => $month['key'], 'value' => $month['value'], 'title' => $month['title'], 'selected' => ( !empty( $search['search_month'] ) && $month['key'] == $search['search_month']) ? 'selected="selected"' : '' ));
    $xtpl->parse('main.search_month');
}
foreach ( $array_select_producttype as $key => $producttype ){
    $sl = (! empty($search['producttype']) && $search['producttype'] == $key) ? ' selected=selected' : '';
    $xtpl->assign('PRODUCTTYPE', array('key' => $key, 'value' => $producttype, 'sl' => $sl));
    $xtpl->parse('main.producttype');
}

//he thong ctv, dl
$list_Agency = nvGetListCurrentAgency();
if( !empty($list_Agency )){
    //danh sach agency
    foreach ($list_Agency as $agency){
        $agency['sl'] = (! empty($search['agencyid']) && $search['agencyid'] == $agency['key']) ? ' selected=selected' : '';
        $xtpl->assign('AGENCY', $agency);
        $xtpl->parse('main.agency.loop');
    }
    $xtpl->parse('main.agency');
}

if (! empty($search['date_from'])) {
    $search['date_from'] = nv_date('d/m/Y', $search['date_from']);
}

if (! empty($search['date_to'])) {
    $search['date_to'] = nv_date('d/m/Y', $search['date_to']);
}

$xtpl->assign('CHECKSESS', md5(session_id()));
$xtpl->assign('SEARCH', $search);


$xtpl->parse('main');
$contents = $xtpl->text('main');


include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
