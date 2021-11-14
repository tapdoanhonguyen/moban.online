<?php

/**

 * @Project NUKEVIET 4.x

 * @Author Mr.Thang <contact@vinades.vn>

 * @Copyright (C) 2014 Mr.Thang. All rights reserved

 * @License GNU/GPL version 2 or any later version

 * @Createdate 2-9-2010 14:43

 */

if( !defined( 'NV_IS_FILE_ADMIN' ) )
{
    die( 'Stop!!!' );
}
$catid = $nv_Request->get_int( 'catid', 'get', 0 );
$rowcontent = array(
    'id' => '',
    'catid' => $catid,
    'productshopid' => 0,
    'unit' => 0,
    'title' => '',
    'alias' => '',
    'image' => '',
    'priceshow' => 0,
    'status' => 1 );
$page_title = $lang_module['product_add'];
$error = array();
$groups_list = nv_groups_list();
$currentpath = NV_UPLOADS_DIR . '/' . $module_upload . '/';
$rowcontent['id'] = $nv_Request->get_int( 'id', 'get,post', 0 );
if( $rowcontent['id'] > 0 )
{
    $rowcontent = $db->query( 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_product where id=' . $rowcontent['id'] )->fetch();
    if( !empty( $rowcontent['id'] ) )
    {
        $rowcontent['mode'] = 'edit';
    }
    $page_title = $lang_module['product_edit'];

    if( !empty( $rowcontent['image'] ) and !nv_is_url( $rowcontent['image'] ) and file_exists( NV_UPLOADS_REAL_DIR ) )
    {
        $rowcontent['image'] = NV_BASE_SITEURL . $currentpath . $rowcontent['image'];
    }
    $rowcontent['pnumber'] = number_format( $rowcontent['pnumber'], 0, ',', '.');
    $rowcontent['price_in'] = number_format( $rowcontent['price_in'], 0, ',', '.');
    $rowcontent['price_retail'] = number_format( $rowcontent['price_retail'], 0, ',', '.');
    $rowcontent['price_wholesale'] = number_format( $rowcontent['price_wholesale'], 0, ',', '.');
}

if( $nv_Request->get_int( 'save', 'post' ) == 1 )
{
    $rowcontent['catid'] = $nv_Request->get_int( 'catid', 'post', 0 );
    $rowcontent['productshopid'] = $nv_Request->get_int( 'productshopid', 'post', 0 );
    $rowcontent['unit'] = $nv_Request->get_int( 'unit', 'post', 0 );
    $rowcontent['code'] = nv_substr($nv_Request->get_title('code', 'post', '', 1), 0, 255);
    $rowcontent['priceshow'] = $nv_Request->get_int( 'priceshow', 'post', 0 );
    $rowcontent['status'] = $nv_Request->get_int( 'status', 'post', 0 );
    $rowcontent['title'] = $nv_Request->get_title( 'title', 'post', '', 1 );
    $rowcontent['alias'] = $nv_Request->get_title( 'alias', 'post', '', 1 );
    $rowcontent['image'] = $nv_Request->get_title( 'image', 'post', '' );
    $rowcontent['pnumber'] = $nv_Request->get_title( 'pnumber', 'post', 0);
    $rowcontent['pnumber'] = floatval(preg_replace('/[^0-9\,]/', '', $rowcontent['pnumber']));
    $rowcontent['price_in'] = $nv_Request->get_title( 'price_in', 'post', '' );
    $rowcontent['price_in'] = floatval(preg_replace('/[^0-9\,]/', '', $rowcontent['price_in']));
    $rowcontent['price_retail'] = $nv_Request->get_title( 'price_retail', 'post', '' );
    $rowcontent['price_retail'] = floatval(preg_replace('/[^0-9\,]/', '', $rowcontent['price_retail']));
    $rowcontent['price_wholesale'] = $nv_Request->get_title( 'price_wholesale', 'post', '' );
    $rowcontent['price_wholesale'] = floatval(preg_replace('/[^0-9\,]/', '', $rowcontent['price_wholesale']));


    if( empty( $rowcontent['alias'] ) )
    {
        $rowcontent['alias'] = $rowcontent['title'];
        $rowcontent['alias'] = strtolower( change_alias( $rowcontent['alias'] ) );
    }
    else
    {
        $rowcontent['alias'] = change_alias( $rowcontent['alias'] );
    }
    // Kiem tra ma san pham trung
    $error_product_code = false;
    if (!empty($rowcontent['product_code'])) {
        $stmt = $db->prepare('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE product_code= :product_code AND id!=' . $rowcontent['id']);
        $stmt->bindParam(':product_code', $rowcontent['code'], PDO::PARAM_STR);
        $stmt->execute();
        $id_err = $stmt->rowCount();
        $stmt = $db->prepare('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE product_code= :product_code');
        $stmt->bindParam(':product_code', $rowcontent['code'], PDO::PARAM_STR);
        $stmt->execute();
        if ($rowcontent['id'] == 0 and $stmt->rowCount()) {
            $error_product_code = true;
        } elseif ($id_err) {
            $error_product_code = true;
        }
    }

    if ($error_product_code) {
        $error = $lang_module['error_product_code'];
    }
    if( !$rowcontent['title']){
        $error[] = $lang_module['error_title_product'];
    }if ($rowcontent['catid'] == 0){
        $error[] = $lang_module['error_cat_product'];
    }if ($rowcontent['unit'] == 0){
        $error[] = $lang_module['error_unit_product'];
    }
    if( $rowcontent['price_retail'] < $rowcontent['price_wholesale'] ){
        $error[] = $lang_module['error_price_retail_with_price_wholesale'];
    }
    if( $rowcontent['productshopid'] ==0 ){
        $error[] = $lang_module['error_productshopid'];
    }
    if( empty( $error ) )
    {
        // Xu ly anh minh hoa
        if (!nv_is_url($rowcontent['image']) and is_file(NV_DOCUMENT_ROOT . $rowcontent['image'])) {
            $lu = strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/');
            $rowcontent['image'] = substr($rowcontent['image'], $lu);
        }
        else
        {
            $rowcontent['image'] = '';
        }

        if( $rowcontent['id'] == 0 )
        {
            $weight = $db->query('SELECT MAX(weight) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_product')->fetchColumn();
            $weight = intval($weight) + 1;

            $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_product (
                catid, productshopid, unit, pnumber, pnumberout, addtime, edittime, priceshow, status, code, title, alias, image, price_in, price_retail, price_wholesale, weight
            ) VALUES (
                 ' . intval( $rowcontent['catid'] ) . ',
                 ' . intval( $rowcontent['productshopid'] ) . ',
                 ' . intval( $rowcontent['unit'] ) . ',
                 0,0,
                 ' . NV_CURRENTTIME . ',
                 ' . NV_CURRENTTIME . ',
                 ' . intval( $rowcontent['priceshow'] ) . ',
                 ' . intval( $rowcontent['status'] ) . ',
                 :code,
                 :title,
                 :alias,
                 :image,
                 ' . floatval( $rowcontent['price_in'] ) . ',
                 ' . floatval( $rowcontent['price_retail'] ) . ',
                 ' . floatval( $rowcontent['price_wholesale'] ) . ',
                 ' . $weight . '
            )';

            $data_insert = array();
            $data_insert['code'] = $rowcontent['code'];
            $data_insert['title'] = $rowcontent['title'];
            $data_insert['alias'] = $rowcontent['alias'];
            $data_insert['image'] = $rowcontent['image'];
            $rowcontent['id'] = $db->insert_id( $sql, 'id', $data_insert );
            if( $rowcontent['id'] > 0 )
            {
                //nhap kho o cho khac
                /*
                //tao kho hang hoa cho tong cty - muc dich de thong ke tong so luong hang hoa da ban ra sau nay
                $price = $rowcontent['price_in'] * $rowcontent['pnumber'];
                nhapkhohanghoa( 0, $rowcontent['id'], $rowcontent['pnumber'], 0, $price, '+', 1 );
                */
                $db->query('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs( customerid, productid, quantity_in, quantity_gift_in, price_in, quantity_out, quantity_gift_out, price_out ) 
                VALUES ( 0, ' . $rowcontent['id'] . ', 0,0, 0, 0, 0, 0)');

                $nv_Cache->delMod( $module_name );
            }
            else
            {
                $error[] = $lang_module['errorsave'];
            }
        }
        else
        {
            try
            {
                $sth = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_product SET
                catid=' . intval( $rowcontent['catid'] ) . ',
                productshopid=' . intval( $rowcontent['productshopid'] ) . ',
                unit=' . $rowcontent['unit'] . ',
                edittime=' . NV_CURRENTTIME . ',
                priceshow=' . $rowcontent['priceshow'] . ',
                status=' . $rowcontent['status'] . ',
                code=:code,
                title=:title,
                alias=:alias,
                image=:image,
                price_in=' . intval( $rowcontent['price_in'] ) . ',
                price_retail=' . intval( $rowcontent['price_retail'] ) . ',
                price_wholesale=' . intval( $rowcontent['price_wholesale'] ) . '
                WHERE id =' . $rowcontent['id'] );

                $sth->bindParam( ':code', $rowcontent['code'], PDO::PARAM_STR );
                $sth->bindParam( ':title', $rowcontent['title'], PDO::PARAM_STR );
                $sth->bindParam( ':alias', $rowcontent['alias'], PDO::PARAM_STR );
                $sth->bindParam( ':image', $rowcontent['image'], PDO::PARAM_STR );

                if( $sth->execute() )
                {
                    //nhap kho de o cho khac
                    /*
                    $price = $rowcontent['price_in'] * $rowcontent['pnumber'];
                    nhapkhohanghoa( 0, $rowcontent['id'], $rowcontent['pnumber'], 0, $price, '+', 1 );
                    */
                    $nv_Cache->delMod( $module_name );
                }
                else
                {
                    $error[] = $lang_module['errorsave'];
                }
            }
            catch ( PDOException $Exception )
            {
                // Note The Typecast To An Integer!
                die( $Exception->getMessage() );
            }
        }
        if( empty( $error ) )
        {
            Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=product' );
            die();
        }
    }
}

if( !empty( $rowcontent['image'] ) and file_exists( NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $rowcontent['image'] ) )
{
    $rowcontent['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $rowcontent['image'];
}

if( empty( $array_global_cat ) )
{
    $redirect = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=cat';
    $contents = nv_theme_alert( $lang_module['note_cat_title'], $lang_module['note_cat_content'], 'warning', $redirect, $lang_module['categories'] );

    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme( $contents );
    include NV_ROOTDIR . '/includes/footer.php';
}
$contents = '';
$rowcontent['priceshow_ck'] = ( $rowcontent['priceshow'] == 1 )? ' checked=checked' : '';

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
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'module_name', $module_name );
foreach( $array_global_cat as $cat )
{
    $cat['sl'] = ( $cat['id'] == $rowcontent['catid'] ) ? ' selected="selected"' : '';
    $xtpl->assign( 'CATS', $cat );
    $xtpl->parse( 'main.select_cat' );
}

foreach( $array_shops_rows as $shops )
{
    $shops['sl'] = ( $shops['id'] == $rowcontent['productshopid'] ) ? ' selected="selected"' : '';
    $xtpl->assign( 'SHOPS', $shops );
    $xtpl->parse( 'main.select_productshopid' );
}

foreach( $array_units as $units )
{
    $units['sl'] = ( $units['id'] == $rowcontent['unit'] ) ? ' selected="selected"' : '';
    $xtpl->assign( 'UNITS', $units );
    $xtpl->parse( 'main.select_unit' );
}

$array_status = array( '0' => $lang_module['status_0'], '1' => $lang_module['status_1'] );
foreach( $array_status as $key => $_status )
{
    $sl = ( $key == $rowcontent['status'] ) ? ' selected="selected"' : '';
    $xtpl->assign( 'STATUS', array(
        'sl' => $sl,
        'key' => $key,
        'title' => $_status ) );
    $xtpl->parse( 'main.status' );
}
if( empty( $rowcontent['alias'] ) )
{
    $xtpl->parse( 'main.getalias' );
}
$xtpl->assign( 'UPLOADS_DIR', $currentpath );
$xtpl->parse( 'main' );
$contents .= $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';