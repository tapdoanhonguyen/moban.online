<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Mr.Thang <contact@vinades.vn>
 * @Copyright (C) 2010 - 2014 Mr.Thang. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 08 Apr 2012 00:00:00 GMT
 */

if( !defined( 'NV_IS_FILE_ADMIN' ) )
{
    die( 'Stop!!!' );
}

if( $nv_Request->isset_request('change_weight', 'post', 0) ){

    $id = $nv_Request->get_int('id', 'post', 0);

    $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_product WHERE id=' . $id;
    $id = $db->query($sql)->fetchColumn();
    if (empty($id)) {
        die('NO_' . $id);
    }

    $new_weight = $nv_Request->get_int('new_weight', 'post', 0);
    if (empty($new_weight)) {
        die('NO_' . $mod);
    }

    $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_product WHERE id!=' . $id . ' ORDER BY weight ASC';
    $result = $db->query($sql);

    $weight = 0;
    while ($row = $result->fetch()) {
        ++$weight;
        if ($weight == $new_weight) {
            ++$weight;
        }
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_product SET weight=' . $weight . ' WHERE id=' . $row['id'];
        $db->query($sql);
    }

    $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_product SET weight=' . $new_weight . ' WHERE id=' . $id;
    $db->query($sql);

    $nv_Cache->delMod($module_name);

    include NV_ROOTDIR . '/includes/header.php';
    echo 'OK_' . $id;
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}

elseif( $nv_Request->isset_request( 'delete_id', 'get' ) and $nv_Request->isset_request( 'delete_checkss', 'get' ) )
{
    //cho admin toi cao moi xoa dc
    if ( defined( 'NV_IS_GODADMIN' ) ) {
        $id = $nv_Request->get_int( 'delete_id', 'get' );
        $delete_checkss = $nv_Request->get_string( 'delete_checkss', 'get' );
        $sql = 'SELECT catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_product WHERE id=' . $id;
        list($catid_delete) = $db->query( $sql )->fetch(3);
        if( $id > 0 and $catid_delete > 0 and $delete_checkss == md5( $id . NV_CACHE_PREFIX . $client_info['session_id'] ) )
        {
            $db->query( 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_product  WHERE id = ' . $db->quote( $id ) );
            $sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_product ORDER BY weight ASC';
            $result = $db->query($sql);
            $weight = 0;
            while ($row = $result->fetch()) {
                ++$weight;
                $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_product SET weight=' . $weight . ' WHERE id=' . $row['id'];
                $db->query($sql);
            }

            $nv_Cache->delMod( $module_name );
            Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
            die();
        }
    }
}else if( $nv_Request->isset_request( 'deleteselect', 'post' ) )
{
    $contents = 'ERROR_DEL PERMISSON';
    //cho admin toi cao moi xoa dc
    if ( defined( 'NV_IS_GODADMIN' ) ) {
        $listid = $nv_Request->get_string('listid', 'post', '');
        $del_array = array_map('intval', explode(',', $listid));
        $sql = 'SELECT id, title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_product WHERE id IN (' . implode(',', $del_array) . ')';
        $result = $db->query($sql);
        $del_array = $no_del_array = array();
        $artitle = array();
        while (list($id, $title) = $result->fetch(3)) {
            $_sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_product WHERE id=' . $id;
            if ($db->exec($_sql)) {

                $contents = 'OK_' . $id . '_' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true);
            } else {

                $contents = 'ERR_' . $lang_module['error_del_content'];
            }
            $artitle[] = $title;
            $del_array[] = $id;
        }
        $count = sizeof($del_array);
        if (!empty($no_del_array)) {

            $contents = 'ERR_' . $lang_module['error_no_del_content_id'] . ': ' . implode(', ', $no_del_array);
        }
    }
    exit($contents);
}

$page_title = $lang_module['product_list'];
$sstatus = $nv_Request->get_int( 'sstatus', 'get', -1 );
$catid = $nv_Request->get_int( 'catid', 'get', 0 );
$per_page_old = $nv_Request->get_int( 'per_page', 'cookie', 50 );
$per_page = $nv_Request->get_int( 'per_page', 'get', $per_page_old );
$num_items = $nv_Request->get_int( 'num_items', 'get', 0 );

if( $per_page < 1 and $per_page > 500 )
{
    $per_page = 50;
}
if( $per_page_old != $per_page )
{
    $nv_Request->set_Cookie( 'per_page', $per_page, NV_LIVE_COOKIE_TIME );
}

$q = $nv_Request->get_title( 'q', 'get', '' );
$q = str_replace( '+', ' ', $q );
$qhtml = nv_htmlspecialchars( $q );
$ordername = $nv_Request->get_string( 'ordername', 'get', 'weight' );
$order = $nv_Request->get_string( 'order', 'get', 'asc' ) == 'asc' ? 'asc' : 'desc';
$array_in_ordername = array(

    'title',
    'addtime',
    'status',
    'price_in',
    'price_retail',
    'price_wholesale',
    'weight');
$array_status_view = array(
    '-' => '---' . $lang_module['search_status'] . '---',
    '1' => $lang_module['status_1'],
    '0' => $lang_module['status_0']
);
$array_status_class = array(
    '1' => '',
    '0' => 'warning' );

$array_list_action = array(
    'delete' => $lang_global['delete'],
    'warehouse' => $lang_module['warehouse'],
    'tranfer' => $lang_module['tranfer'] );

if( $sstatus < 0 or $sstatus > 1 )
{
    $sstatus = -1;
}
if( !in_array( $ordername, array_keys( $array_in_ordername ) ) )
{
    $ordername = 'id';
}
$from = NV_PREFIXLANG . '_' . $module_data . '_product';

$where = array();
$page = $nv_Request->get_int( 'page', 'get', 1 );
$checkss = $nv_Request->get_string( 'checkss', 'get', '' );

if( $checkss == NV_CHECK_SESSION )
{
    if( $catid > 0 )
    {
        $where[] = " catid = " .$catid;
    }
    if( $sstatus != -1 )
    {
        $where[] = ' status = ' . $sstatus;
    }
    if( !empty( $q ) )
    {
        $where[] = "title LIKE '%" . $db_slave->dblikeescape( $qhtml ) . "%'";
    }
}
if( !empty( $where )){
    $db_slave->sqlreset()->select( 'COUNT(*)' )->from( $from )->where( implode(' AND ', $where) );
}else{
    $db_slave->sqlreset()->select( 'COUNT(*)' )->from( $from );
}


$_sql = $db_slave->sql();

$num_checkss = md5( $num_items . NV_CHECK_SESSION . $_sql );
if( $num_checkss != $nv_Request->get_string( 'num_checkss', 'get', '' ) )
{
    $num_items = $db_slave->query( $_sql )->fetchColumn();
    $num_checkss = md5( $num_items . NV_CHECK_SESSION . $_sql );
}

$base_url_mod = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;per_page=' . $per_page;
if( $catid )
{
    $base_url_mod .= '&amp;catid=' . $catid;
}

if( !empty( $q ) )
{
    $base_url_mod .= '&amp;q=' . $q . '&amp;checkss=' . $checkss;
}
$base_url_mod .= '&amp;num_items=' . $num_items . '&amp;num_checkss=' . $num_checkss;

for( $i = 0; $i <= 1; $i++ )
{
    $sl = ( $i == $sstatus ) ? ' selected="selected"' : '';
    $search_status[] = array(
        'key' => $i,
        'value' => $lang_module['status_' . $i],
        'selected' => $sl );
}

$i = 5;
$search_per_page = array();
while( $i <= 500 )
{
    $search_per_page[] = array( 'page' => $i, 'selected' => ( $i == $per_page ) ? ' selected="selected"' : '' );
    $i = $i + 5;
}

$order2 = ( $order == 'asc' ) ? 'desc' : 'asc';
$ord_sql = ' r.' . $ordername . ' ' . $order;

$base_url_status = $base_url_mod . '&amp;ordername=t1.status&amp;order=' . $order2 . '&amp;page=' . $page;
$base_url_name = $base_url_mod . '&amp;ordername=t1.title&amp;order=' . $order2 . '&amp;page=' . $page;
$base_url_addtime = $base_url_mod . '&amp;ordername=addtime&amp;order=' . $order2 . '&amp;page=' . $page;
$base_url_price_in = $base_url_mod . '&amp;ordername=t1.price_in&amp;order=' . $order2 . '&amp;page=' . $page;
$base_url_price_wholesale = $base_url_mod . '&amp;ordername=t1.price_wholesale&amp;order=' . $order2 . '&amp;page=' . $page;
$base_url_price_retail = $base_url_mod . '&amp;ordername=t1.price_retail&amp;order=' . $order2 . '&amp;page=' . $page;


$base_url = $base_url_mod . '&amp;sstatus=' . $sstatus . '&amp;ordername=' . $ordername . '&amp;order=' . $order;
$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page );


$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'addproduct', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=addproduct' );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$xtpl->assign( 'Q', $qhtml );
$xtpl->assign( 'base_url_status', $base_url_status );
$xtpl->assign( 'base_url_name', $base_url_name );
$xtpl->assign( 'base_url_addtime', $base_url_addtime );
$xtpl->assign( 'base_url_price_in', $base_url_price_in );
$xtpl->assign( 'base_url_price_wholesale', $base_url_price_wholesale );
$xtpl->assign( 'base_url_price_retail', $base_url_price_retail );

$db_slave->select( '*' )->order( $ordername . ' ' . $order )->limit( $per_page )->offset( ( $page - 1 ) * $per_page );
$result = $db_slave->query( $db_slave->sql() );

//cua phan xuat nhap hang
$db->sqlreset()
    ->select('productid, quantity_in, quantity_out')
    ->from(NV_PREFIXLANG. '_' . $module_data . '_warehouse_logs')
    ->where('customerid=0');
$result_i = $db_slave->query( $db_slave->sql() );
$array_warehouse_logs = array();
while( $row = $result_i->fetch() )
{
    if( isset( $array_warehouse_logs[$row['productid']] )){
        $array_warehouse_logs[$row['productid']]['quantity_in'] += $row['quantity_in'];
        $array_warehouse_logs[$row['productid']]['quantity_out'] += $row['quantity_out'];
    }else{
        $array_warehouse_logs[$row['productid']]['quantity_in'] = $row['quantity_in'];
        $array_warehouse_logs[$row['productid']]['quantity_out'] = $row['quantity_out'];
    }
}

while( $row = $result->fetch() )
{
    for ($i = 1; $i <= $num_items; ++$i) {
        $xtpl->assign('WEIGHT', array(
            'w' => $i,
            'selected' => ($i == $row['weight']) ? ' selected="selected"' : ''
        ));
        $xtpl->parse('main.loop.weight');
    }
    $row['addtime'] = nv_date( 'H:i d/m/y', $row['addtime'] );
    $row['class'] = $array_status_class[$row['status']];
    $row['cattitle'] = $array_global_cat[$row['catid']]['title'];
    $row['status'] = $lang_module['status_' . $row['status']];
    $row['total_tonkho'] = 0;
    $row['pnumber'] = 0;
    if( isset( $array_warehouse_logs[$row['id']] )){
        $row['total_tonkho'] = $array_warehouse_logs[$row['id']]['quantity_in'] - $array_warehouse_logs[$row['id']]['quantity_out'];
        $row['pnumber'] = number_format( $array_warehouse_logs[$row['id']]['quantity_in'], 0, ',', '.');
    }

    $row['price_in'] = number_format( $row['price_in'], 0, ',', '.');
    $row['price_retail'] = number_format( $row['price_retail'], 0, ',', '.');
    $row['price_wholesale'] = number_format( $row['price_wholesale'], 0, ',', '.');

    $row['total_tonkho'] = number_format( $row['total_tonkho'], 0, ',', '.');

    $row['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=addproduct&id=' . $row['id'];
    $row['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $row['id'] . '&amp;delete_checkss=' . md5( $row['id'] . NV_CACHE_PREFIX . $client_info['session_id'] );
    $xtpl->assign( 'ROW', $row );

    $xtpl->parse( 'main.loop' );
}

foreach( $array_global_cat as $cat)
{
    $cat['selected'] = ( $cat['id'] == $catid )? ' selected=selected': '';
    $xtpl->assign( 'CAT_CONTENT', $cat );
    $xtpl->parse( 'main.cat_content' );
}

foreach( $search_per_page as $s_per_page )
{
    $xtpl->assign( 'SEARCH_PER_PAGE', $s_per_page );
    $xtpl->parse( 'main.s_per_page' );
}

foreach( $search_status as $status_view )
{
    $xtpl->assign( 'SEARCH_STATUS', $status_view );
    $xtpl->parse( 'main.search_status' );
}

while( list( $action_i, $title_i ) = each( $array_list_action ) )
{
    $action_assign = array( 'value' => $action_i, 'title' => $title_i );
    $xtpl->assign( 'ACTION', $action_assign );
    $xtpl->parse( 'main.action' );
}

if( !empty( $generate_page ) )
{
    $xtpl->assign( 'GENERATE_PAGE', $generate_page );
    $xtpl->parse( 'main.generate_page' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );


include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
