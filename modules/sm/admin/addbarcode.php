<?php
if( !defined( 'NV_IS_FILE_ADMIN' ) )
{
    die( 'Stop!!!' );
}
$id = $nv_Request->get_int( 'id', 'get,post', 0 );

if ($id <= 0) {
    Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=barcode');
    die();
}
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_barcode where id=' . $id;
$rowcontent = $db->query($sql)->fetch();
$page_title = "Sửa mã thẻ cào";
//print_r($rowcontent);die();
if( $nv_Request->get_int( 'save', 'post' ) == 1 )
{
    $rowcontent['bonus_point'] = $nv_Request->get_title( 'bonus_point', 'post', 0 );
    $rowcontent['bonus_gift'] = $nv_Request->get_title('bonus_gift', 'post', '');
    $rowcontent['status'] = $nv_Request->get_int( 'status', 'post', 0 );

    if( $rowcontent['bonus_point'] <= 0 ){
        $error[] = 'Điểm thưởng phải lớn hơn 0';
    }

    if( empty( $error ) ) {
        try {
            $sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_barcode SET
            status=' . $rowcontent['status'] . ', bonus_point=:bonus_point, bonus_gift=:bonus_gift
            WHERE id =' . $id);

            $sth->bindParam(':bonus_point', $rowcontent['bonus_point'], PDO::PARAM_STR);
            $sth->bindParam(':bonus_gift', $rowcontent['bonus_gift'], PDO::PARAM_STR);

            $sth->execute();
        } catch (PDOException $Exception) {
            die($Exception->getMessage());
        }
        if (empty($error)) {
            Header('Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=barcode');
            die();
        }
    }
}

$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'rowcontent', $rowcontent );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'MODULE_FILE', $module_file );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
if( !empty( $error ) )
{
    $xtpl->assign( 'ERROR', implode( '<br />', $error ) );
    $xtpl->parse( 'main.error' );
}
$array_status = array( '0' => 'Chưa sử dụng', '1' => 'Đã sử dụng' );
foreach( $array_status as $key => $_status )
{
    $sl = ( $key == $rowcontent['status'] ) ? ' selected="selected"' : '';
    $xtpl->assign( 'STATUS', array(
        'sl' => $sl,
        'key' => $key,
        'title' => $_status ) );
    $xtpl->parse( 'main.status' );
}
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'module_name', $module_name );

$xtpl->parse( 'main' );
$contents .= $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';