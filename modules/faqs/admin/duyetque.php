<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES., JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES ., JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Dec 3, 2010 11:33:22 AM
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$array_list_action = array( 'delete' => $lang_global['delete'], 'duyet' => $lang_module['duyet'] );
$listcat = nv_catList( 0 );
if( $nv_Request->get_int( 'listaction', 'post' ) )
{
	$listid = $nv_Request->get_title( 'listid', 'post', 0 );

	$nv_que = nv_questionList();

	$doaction = $nv_Request->get_title( 'do', 'post', 0 );

	if( $doaction == "delete" )
	{
		$query = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_question WHERE qid in (" . $listid . ")";
		if( $db->query( $query ) )
		{
			die( 'OK' );
		}
	}
	elseif( $doaction == "duyet" )
	{
		$arr_id = explode( ",", $listid );

		foreach( $arr_id as $id_i )
		{
			$db->query( "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_question SET status=1 WHERE qid=" . $id_i );
			//$db->query( "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_note SET mark=mark-" . $arr_config['mark_question'] . ",sendque=sendque+1 WHERE userid=" . $nv_que[$id_i]['userid'] );
		}
		die( 'OK' );
	}

}

//Delete link
if( $nv_Request->isset_request( 'del', 'post' ) )
{
	$id = $nv_Request->get_int( 'id', 'post', 0 );

	if( ! $id ) die( 'NO' );

	$query = "SELECT qid FROM " . NV_PREFIXLANG . "_" . $module_data . "_question WHERE qid=" . $id;
	$result = $db->query( $query );
	$numrows = $result->rowCount();

	if( $numrows > 0 )
	{
		$sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_question WHERE qid=" . $id;
		$db->query( $sql );
		$sql = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_answer WHERE qid=" . $id;
		$db->query( $sql );

	}
	die( 'OK' );

}

//Chinh trang thai
if( $nv_Request->isset_request( 'changesta', 'post' ) )
{
	if( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );

	$id = $nv_Request->get_int( 'id', 'post', 0 );
	$new = $nv_Request->get_int( 'new', 'post', 0 );

	if( empty( $id ) ) die( 'NO' );

	$query = "SELECT qid FROM " . NV_PREFIXLANG . "_" . $module_data . "_question WHERE qid=" . $id;

	$result = $db->query( $query );
	$numrows = $result->rowCount();
	if( $numrows == 0 ) die( 'NO' );
	$sql = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_question SET status=" . $new . " WHERE qid=" . $id;
	$db->query( $sql );

	$nv_Cache->delMod($module_name);

	die( 'OK' );
}

$page_title = $lang_module['list_order'];
//$cus_list = nv_cusList();
$sql = "FROM " . NV_PREFIXLANG . "_" . $module_data . "_question WHERE qid!=0 AND status = 0 ";
$base_url = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name;
$error = $code = '';
$from = $to = $status = 0;
$data_search = array(
	'keywords' => '',
	'from' => '',
	'to' => ''
);

if( $nv_Request->isset_request( "ok", "get" ) )
{
	$data_search['keywords'] = $nv_Request->get_string( 'keywords', 'get', '' );
	if( ! empty( $data_search['keywords'] ) )
	{
		$sql .= " AND cus_name like '%" . $data_search['keywords'] . "%' OR cus_email like '%" . $data_search['keywords'] . "%' OR title like '%" . $data_search['keywords'] . "%' OR question like '%" . $data_search['keywords'] . "%'";
		$base_url .= "&amp;keywords=" . $data_search['keywords'];
	}

	$data_search['from'] = $nv_Request->get_title( 'from', 'get,post', '' );
	unset( $m );
	if( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $data_search['from'], $m ) )
	{
		$data_search['from'] = mktime( 0, 0, 0, $m[2], $m[1], $m[3] );
	}
	else
	{
		$data_search['from'] = 0;
	}

	if( $data_search['from'] != 0 )
	{
		$sql .= " AND addtime >= " . $data_search['from'];
		$base_url .= "&amp;from =" . $data_search['from'];
	}

	$data_search['to'] = $nv_Request->get_title( 'to', 'get,post', '' );
	unset( $m );
	if( preg_match( "/^([0-9]{1,2})\.([0-9]{1,2})\.([0-9]{4})$/", $data_search['to'], $m ) )
	{
		$data_search['to'] = mktime( 23, 59, 59, $m[2], $m[1], $m[3] );
	}
	else
	{
		$data_search['to'] = 0;
	}
	if( $data_search['to'] != 0 )
	{
		$sql .= " AND addtime <= " . $data_search['to'];
		$base_url .= "&amp;to=" . $data_search['to'];
	}
}

$sql1 = "SELECT COUNT(*) " . $sql;

$result1 = $db->query( $sql1 );
$all_page = $result1->fetchColumn();

$sql .= " ORDER BY addtime DESC";

$page = $nv_Request->get_int( 'page', 'get', 0 );
$per_page = $arr_config['num_row_list'];

$sql2 = "SELECT * " . $sql . " LIMIT " . $page . ", " . $per_page;
$query2 = $db->query( $sql2 );

$array = array();
$i = 0;
while( $row = $query2->fetch() )
{
	$i = $i + 1;
	$array[$row['qid']] = array( //
		'qid' => $row['qid'], //
		'addtime' => nv_date( 'H:i d.m.Y', $row['addtime'] ), //
		'status' => $row['status'], //
		'title' => $row['title'], //
		'sort' => $i, //
		'cus_name' => $row['cus_name'], //
		'cus_email' => $row['cus_email'], //
		'detail_url' => NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=de&qid=" . $row['qid'] );
}

$generate_page = nv_generate_page( $base_url, $all_page, $per_page, $page );

$xtpl = new XTemplate( "duyetque.tpl", NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );

$xtpl->assign( 'TABLE_CAPTION', $lang_module['list_order'] );
$xtpl->assign( 'FORM_ACTION', NV_BASE_ADMINURL . "index.php?" );
$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );

$data_search['from'] = ! empty( $data_search['from'] ) ? nv_date( 'd.m.Y', $data_search['from'] ) : '';
$data_search['to'] = ! empty( $data_search['to'] ) ? nv_date( 'd.m.Y', $data_search['to'] ) : '';
$xtpl->assign( 'SEARCH', $data_search );

if( ! empty( $array ) )
{
	foreach( $array as $a )
	{
		foreach( $arr_status as $k => $v )
		{
			$v['selected'] = ( $k == $a['status'] ) ? 'selected="selected"' : '';
			$xtpl->assign( 'STATUS', $v );
			$xtpl->parse( 'main.loop.status' );
		}

		$xtpl->assign( 'ROW', $a );
		$xtpl->parse( 'main.loop' );
	}

}

if( ! empty( $generate_page ) )
{
	$xtpl->assign( 'GENERATE_PAGE', $generate_page );
	$xtpl->parse( 'main.generate_page' );
}

while( list( $catid_i, $title_i ) = each( $array_list_action ) )
{
	$xtpl->assign( 'key_action', $catid_i );
	$xtpl->assign( 'value_action', $title_i );
	$xtpl->parse( 'main.action' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include ( NV_ROOTDIR . "/includes/header.php" );
echo nv_admin_theme( $contents );
include ( NV_ROOTDIR . "/includes/footer.php" );
