<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 12/31/2009 0:51
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

define('NV_DEFINE_DEPOSITS',  $module_config[$module_name]['deposits']);//PHAN TRAM TAM UNG DAT COC
define('NV_DEFINE_DAY_RECEIVED',  1);//bien dinh nghia so ngay du kien nhan dc hang
define('NV_TABLE_AFFILIATE', $db_config['prefix'] . '_affiliate');

$array_select_status = array();
$array_select_status[0] = $lang_module['active_0'];
$array_select_status[1] = $lang_module['active_1'];

$array_select_type_return = array();
$array_select_type_return[1] = $lang_module['type_return_1'];
$array_select_type_return[2] = $lang_module['type_return_2'];

$array_select_custype = array();
$array_select_custype[0] = $lang_module['custype_0'];
$array_select_custype[1] = $lang_module['custype_1'];

$array_select_ordertype = array();
$array_select_ordertype[1] = $lang_module['ordertype_1'];
$array_select_ordertype[2] = $lang_module['ordertype_2'];

$array_defined_return_order = array();
$array_defined_return_order[1] = $module_config[$module_name]['percent_discount_1'];
$array_defined_return_order[2] = $module_config[$module_name]['percent_discount_2'];
$array_defined_return_order[3] = $module_config[$module_name]['percent_discount_3'];

$array_personal_sms = array(
    '[FULLNAME]' => $lang_module['content_note_fullname'],
    '[MOBILE]' => $lang_module['content_note_phone'],
    '[SHOP_MOBILE]' => $lang_module['content_note_shopphone'],
    '[EMAIL]' => $lang_module['content_note_email'],
    '[ADDRESS]' => $lang_module['content_note_address'],
    '[ALIAS]' => $lang_module['content_note_alias'],
    '[SITE_NAME]' => sprintf($lang_module['content_note_site_name'], $global_config['site_name']),
    '[SITE_DOMAIN]' => sprintf($lang_module['content_note_site_domain'], NV_MY_DOMAIN)
);

$array_agency = array(
    1 => array( 'key' => 1, 'act' => 'retail', 'title' => $lang_module['order_retail']),
    2 => array( 'key' => 2, 'act' => 'wholesale', 'title' => $lang_module['order_wholesale'])
);

$precode = 'SM%04s';//ma don dat hang

$array_discount = array();
$_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_discounts ORDER BY productid ASC, end_quantity DESC';
$array_tmp = $nv_Cache->db($_sql, 'id', $module_name);
foreach ($array_tmp as $tmp ){
    $array_discount[$tmp['productid']][] = $tmp;
}

$sql = "SELECT * FROM " . NV_TABLE_AFFILIATE  . "_agency WHERE status=1 ORDER BY weight";
$array_agency = $nv_Cache->db($sql, 'id', 'affiliate');
$sql = "SELECT * FROM " . NV_TABLE_AFFILIATE  . "_possiton WHERE status=1 ORDER BY weight";
$array_possiton = $nv_Cache->db($sql, 'id', 'affiliate');

$sql = "SELECT * FROM " . NV_PREFIXLANG . '_' . $module_data  . "_depot WHERE status=1 ORDER BY id";
$array_depot = $nv_Cache->db($sql, 'id', $module_name);


$_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_product ORDER BY weight ASC';
$array_product = $nv_Cache->db($_sql, 'id', $module_name);

/**
 * nv_get_price()
 *
 * @param mixed $price
 * @param mixed $percent_sale
 * @param mixed $number
 * @param mixed $per_pro
 * @return
 */

function nv_get_price_for_agency($price, $productid = 0, $number = 1, $per_pro = false )
{
    global $array_discount;

    $discount = 0;
    //chiet khau theo sl sp
    if ( isset($array_discount[$productid] ) && !empty($array_discount[$productid])) {
        foreach ($array_discount[$productid] as $_d) {
            if ($_d['begin_quantity'] <= $number and $_d['end_quantity'] >= $number) {
                $discount = $_d['percent'];
                break;
            }
        }
    }
    //$price_agency = floor( ($price - $price * $discount / 100)/1000 );
    $price_agency = ($price - $price * $discount / 100)/1000;
    if( $per_pro ){
        $price_agency = $price_agency * 1000 * $number;
    }else{
        $price_agency = $price_agency * 1000;
    }
    $return = $price_agency;// Giá nhap cho agency
    return $return;

}

/**
 * nv_get_discount_percent()
 * Lấy chiết khấu cho đơn hàng này
 * @param mixed $price
 * @param mixed $agencyid
 * @return
 */

function nv_get_discount_percent($price, $agencyid )
{
    global $array_discount;

    $discount = 0;
    //chiet khau theo sl sp
    if ( isset($array_discount[$productid] ) && !empty($array_discount[$productid])) {
        foreach ($array_discount[$productid] as $_d) {
            if ($_d['begin_quantity'] <= $number and $_d['end_quantity'] >= $number) {
                $discount = $_d['percent'];
                break;
            }
        }
    }
    //$price_agency = floor( ($price - $price * $discount / 100)/1000 );
    $price_agency = ($price - $price * $discount / 100)/1000;
    if( $per_pro ){
        $price_agency = $price_agency * 1000 * $number;
    }else{
        $price_agency = $price_agency * 1000;
    }
    $return = $price_agency;// Giá nhap cho agency
    return $return;

}

// Tru so luong trong kho $type = "-"
// Cong so luong trong kho $type = "+"
// $listid : danh sach cac id product
// $listnum : danh sach so luong tuong ung

/**
 * product_number_order()
 *
 * @param mixed $listid
 * @param mixed $listnum
 * @param string $type
 * @return
 */

function product_number_order($listid, $listnum, $type = '-')
{
    global $db, $module_data;
    foreach ($listid as $i => $id) {
        if ($id > 0) {
            if (empty($listnum[$i])) {
                $listnum[$i] = 0;
            }
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_product SET pnumber = pnumber ' . $type . ' ' . intval($listnum[$i]) . ' WHERE id =' . $id;
            $db->query($sql);
        }
    }
}

/**
 * GetGroupidInParentGroup($parentid, $subcatid)
 *
 * @param mixed $parentid
 * @param integer $subcatid
 * @param integer $checksub co lay tat ca cac con ben trong khong
 * @return
 */

function nvGetUseridInParent($parentid, $subcatid, $checksub = false, $ispossiton = true)
{
    global $array_list_id, $db;

    $array_list_id[$parentid] = $parentid;
    if( !empty( $subcatid )){
        $subcatid = explode(',', $subcatid );
        if (!empty($subcatid)) {
            foreach ($subcatid as $id) {
                $data_sub = $db->query('SELECT numsubcat, subcatid, possitonid FROM ' . NV_TABLE_AFFILIATE . '_users WHERE userid=' . $id )->fetch();
                if( $ispossiton and $data_sub['possitonid'] > 0 ){
                    $array_list_id[$id] = $id;
                }elseif( !$ispossiton ){
                    $array_list_id[$id] = $id;
                }
                if( $checksub == true){
                    if ($id > 0 and !empty( $data_sub ) and (( $ispossiton == true and $data_sub['possitonid'] > 0 ) or !$ispossiton) ) {
                        if ($data_sub['numsubcat'] == 0) {
                            $array_list_id[$id] = $id;
                        }else{
                            $array_list_id = nvGetUseridInParent($id, $data_sub['subcatid'], $checksub, $ispossiton );
                        }
                    }
                }
            }
        }
    }
    return array_unique($array_list_id);
}

/**
 * nvGetUseridCustomer()
 *
 * ham lay cac tai khoan khach hang le do tai khoan dang nhap gioi thieu

 * @return

 */

function nvGetUseridCustomer($userid = 0)

{

    global $user_info, $module_data, $db;



    $array_list_id = array();

    $userid = ( $userid == 0 )? $user_info['userid'] : $userid;

    if (isset( $user_info ) && $user_info['userid'] > 0 ) {

        $result = $db->query('SELECT customer_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_customer WHERE refer_userid=' . $userid );

        while ( list( $customer_id ) = $result->fetch(3)){

            $array_list_id[] = $customer_id;

        }

    }

    return $array_list_id;

}



//Tao tai khoan khach hang mua san pham
function createCustomer($chossentype, $customer_name, $customer_mail, $customer_phone, $customer_address, $agencyid, $userid_ref = 0 ){

    global $db, $module_data, $user_info, $lang_module, $crypt, $global_config, $module_config, $db_config;
    $userid_ref = ( $userid_ref == 0 )? $user_info['userid'] : $userid_ref;
    if( $chossentype == 3 ){
        $sql = 'SELECT customer_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_customer WHERE refer_userid=' . $userid_ref . ' AND fullname=' . $db->quote( $customer_name ) . ' AND phone=' . $db->quote( $customer_phone );
        list( $customer_id ) = $db->query( $sql )->fetch(3);//neu = 0 thi se tao tai khoan
        $customer_id  = intval( $customer_id );
        if( $customer_id == 0 ){

            $result = $db->query("SHOW TABLE STATUS WHERE Name='" . NV_PREFIXLANG . "_" . $module_data . "_customer'");
            $item = $result->fetch();
            $result->closeCursor();
            $precode = 'KH%02s';
            $customer_code = vsprintf($precode, $item['auto_increment']);
            $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_customer (refer_userid, code, fullname, address, phone, email, description, add_time, edit_time, custype, status) VALUES (:refer_userid, :code, :fullname, :address, :phone, :email, :description, :add_time, :edit_time, :custype, :status)';

            $data_insert = array();
            $data_insert['refer_userid'] = $userid_ref;
            $data_insert['code'] = $customer_code;
            $data_insert['fullname'] = $customer_name;
            $data_insert['address'] = $customer_address;
            $data_insert['phone'] = $customer_phone;
            $data_insert['email'] = $customer_mail;
            $data_insert['description'] = '';
            $data_insert['add_time'] = NV_CURRENTTIME;
            $data_insert['edit_time'] = NV_CURRENTTIME;
            $data_insert['custype'] = 0;
            $data_insert['status'] = 1;

            $customer_id = $db->insert_id( $sql, 'customer_id', $data_insert );
        }
    }
    else{
        //kiem tra xem he thong da  co tk nay chua
        $md5username = nv_md5safe($customer_phone);
        $stmt = $db->prepare('SELECT userid FROM ' . NV_USERS_GLOBALTABLE . ' WHERE md5username= :md5username');
        $stmt->bindParam(':md5username', $md5username, PDO::PARAM_STR);
        $stmt->execute();
        $query_error_username = $stmt->fetchColumn();
        $array_mess_error = array();
        if ($query_error_username) {
            $array_mess_error['order_phone'] = $lang_module['edit_error_username_exist'];
        }
        $customer_mail = ( !empty( $customer_mail ))? $customer_mail : $customer_phone .'@gmail.com';
        // Thực hiện câu truy vấn để kiểm tra email đã tồn tại chưa.
        $stmt = $db->prepare('SELECT userid FROM ' . NV_USERS_GLOBALTABLE . ' WHERE email= :email');
        $stmt->bindParam(':email', $customer_mail, PDO::PARAM_STR);
        $stmt->execute();
        $query_error_email = $stmt->fetchColumn();
        if ($query_error_email) {
            $array_mess_error['order_email'] = $lang_module['edit_error_email_exist'];
        }
        // Thực hiện câu truy vấn để kiểm tra email đã tồn tại trong nv4_users_reg  chưa.
        $stmt = $db->prepare('SELECT userid FROM ' . NV_USERS_GLOBALTABLE . '_reg WHERE email= :email');
        $stmt->bindParam(':email', $customer_mail, PDO::PARAM_STR);
        $stmt->execute();
        $query_error_email_reg = $stmt->fetchColumn();
        if ($query_error_email_reg) {
            $array_mess_error['order_email'] = $lang_module['edit_error_email_exist'];
        }
        $stmt = $db->prepare('SELECT userid FROM ' . NV_USERS_GLOBALTABLE . '_openid WHERE email= :email');
        $stmt->bindParam(':email', $customer_mail, PDO::PARAM_STR);
        $stmt->execute();
        $query_error_email_openid = $stmt->fetchColumn();
        if ($query_error_email_openid) {
            $array_mess_error['order_email'] = $lang_module['edit_error_email_exist'];
        }

        if( !empty( $array_mess_error )){
            return array('customer_id' => 0, 'mess_error' => $array_mess_error);
        }

        $_user['password'] = nvRandomString();
        $_user['username'] = $customer_phone;
        $_user['email'] = $customer_mail;
        $customer_name = explode(' ', $customer_name );
        $total_str = count( $customer_name );
        $_user['first_name'] = $customer_name[$total_str-1];
        unset( $customer_name[$total_str-1] );
        $_user['last_name'] = implode(' ', $customer_name );
        //tao tai khoan thanh vien tai module users
        $sql = "INSERT INTO " . NV_USERS_GLOBALTABLE . " (
        group_id, username, md5username, password, email, first_name, last_name, gender, birthday, sig, regdate,
        question, answer, passlostkey, view_mail,
        remember, in_groups, active, checknum, last_login, last_ip, last_agent, last_openid, idsite)
    VALUES (
        0,
        :username,
        :md5_username,
        :password,
        :email,
        :first_name,
        :last_name,
        :gender,
        0,
        :sig,
        " . NV_CURRENTTIME . ",
        :question,
        :answer,
        '',
         1,
         1,
         '', 1, '', 0, '', '', '', " . $global_config['idsite'] . "
    )";

        $data_insert = array();
        $data_insert['username'] = $_user['username'];
        $data_insert['md5_username'] = $md5username;
        $data_insert['password'] = $crypt->hash_password($_user['password'], $global_config['hashprefix']);
        $data_insert['email'] = $_user['email'];
        $data_insert['first_name'] = $_user['first_name'];
        $data_insert['last_name'] = $_user['last_name'];
        $data_insert['gender'] = 'N';
        $data_insert['sig'] = '';
        $data_insert['question'] = $lang_module['question_info_phone'];
        $data_insert['answer'] = $_user['username'];

        $customer_id = $db->insert_id($sql, 'userid', $data_insert);

        if ($customer_id > 0 ) {

            //tao tk he thong QL Affiliate

            $precode = $module_config['affiliate']['precode'];

            $row['code'] = vsprintf($precode, $customer_id);

            $row['precode'] = $row['code'] . '%01s';

            $weight = $db->query('SELECT max(weight) FROM ' . $db_config['prefix'] . '_affiliate_users WHERE parentid=' . $user_info['userid'])->fetchColumn();

            $weight = intval($weight) + 1;

            $subcatid = '';

            $stmt = $db->prepare("INSERT INTO " . $db_config['prefix'] . "_affiliate_users (userid, parentid, precode, code, mobile, salary_day, benefit, datatext, weight, sort, lev, possitonid, agencyid, numsubcat, subcatid, add_time, edit_time, status) VALUES

			(:userid, :parentid, :precode, :code, :mobile, :salary_day, :benefit, :datatext, :weight, '0', '0', :possitonid, :agencyid, '0', :subcatid, " . NV_CURRENTTIME . ", " . NV_CURRENTTIME . ", 1)");

            $stmt->bindValue(':salary_day', 0, PDO::PARAM_INT);

            $stmt->bindValue(':benefit', 0, PDO::PARAM_INT);

            $stmt->bindParam(':userid', $customer_id, PDO::PARAM_INT);

            $stmt->bindParam(':parentid', $user_info['userid'], PDO::PARAM_INT);

            $stmt->bindParam(':precode', $row['precode'], PDO::PARAM_STR);

            $stmt->bindParam(':code', $row['code'], PDO::PARAM_STR);

            $stmt->bindParam(':mobile', $_user['username'], PDO::PARAM_STR);

            $stmt->bindParam(':weight', $weight, PDO::PARAM_INT);

            $stmt->bindValue(':possitonid', 0, PDO::PARAM_INT);

            $stmt->bindParam(':agencyid', $agencyid, PDO::PARAM_INT);

            $stmt->bindParam(':subcatid', $subcatid, PDO::PARAM_STR);

            $stmt->bindValue(':datatext', '', PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount()) {
                nv_fix_users_order();
            }
            // Gửi mail thông báo

            if( !empty($_user['email'])){

                $full_name = nv_show_name_user($_user['first_name'], $_user['last_name'], $_user['username']);

                $subject = $lang_module['adduser_register'];

                $_url = NV_MY_DOMAIN . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=users', true);

                $message = sprintf($lang_module['adduser_register_info1'], $full_name, $global_config['site_name'], $_url, $_user['username'], $_user['password']);

                @nv_sendmail($global_config['site_email'], $_user['email'], $subject, $message);

            }
        }
    }

    return array('customer_id' => $customer_id, 'mess_error' => array());

}

function nvRandomString() {

    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

    $pass = array(); //remember to declare $pass as an array

    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache

    for ($i = 0; $i < 8; $i++) {

        $n = rand(0, $alphaLength);

        $pass[] = $alphabet[$n];

    }

    return implode($pass); //turn the array into a string

}

/**

 * nv_fix_users_order()

 * module affiliate

 * @param integer $parentid

 * @param integer $order

 * @param integer $lev

 * @return

 */

function nv_fix_users_order($parentid = 0, $order = 0, $lev = 0)
{
    global $db, $db_config;

    $sql = 'SELECT userid, parentid FROM ' . $db_config['prefix'] . '_affiliate_users WHERE parentid=' . $parentid . ' ORDER BY weight ASC';
    $result = $db->query($sql);
    $array_cat_order = array();
    while ($row = $result->fetch()) {
        $array_cat_order[] = $row['userid'];
    }
    $result->closeCursor();
    $weight = 0;
    if ($parentid > 0) {
        ++$lev;
    } else {
        $lev = 0;
    }

    foreach ($array_cat_order as $catid_i) {
        ++$order;
        ++$weight;
        $sql = 'UPDATE ' . $db_config['prefix'] . '_affiliate_users SET weight=' . $weight . ', sort=' . $order . ', lev=' . $lev . ' WHERE userid=' . intval($catid_i);

        $db->query($sql);

        $order = nv_fix_users_order($catid_i, $order, $lev);

    }

    $numsubcat = $weight;

    if ($parentid > 0) {
        $sql = 'UPDATE ' . $db_config['prefix'] . '_affiliate_users SET numsubcat=' . $numsubcat;
        if ($numsubcat == 0) {
            $sql .= ",subcatid=''";
        } else {
            $sql .= ",subcatid='" . implode(',', $array_cat_order) . "'";
        }
        $sql .= ' WHERE userid=' . intval($parentid);
        $db->query($sql);
    }
    return $order;
}


//kiem tra so luong hang trong kho cua NPP phia tren, Nhap vao IDcustomer cua nguoi nhap hang
function checkNumTotalInParentCustomer( $customerid, $depotid, $productid, $check_warehouse ){
    global $db, $module_data, $user_info;

    if( $check_warehouse == 0 ){
        list ($quantity_out, $quantity_in ) = $db->query('SELECT quantity_out, quantity_in FROM ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs WHERE customerid =' . $user_info['userid'] . ' AND productid=' . $productid . ' AND depotid=' . $depotid )->fetch(3);
    }else{
        list ($quantity_out, $quantity_in  ) = $db->query('SELECT quantity_out, quantity_in FROM ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs WHERE customerid =0 AND productid=' . $productid . ' AND depotid=' . $depotid )->fetch(3);
    }
    return $quantity_in - $quantity_out;

    return 0;
}


//kiem tra so luong hang trong kho cua NPP phia duoi, Nhap vao IDcustomer cua nguoi nhap hang
function checkNumTotalInBehideCustomer( $customerid, $productid ){
    global $db, $module_data;

    $customerid = intval($customerid);
    if( $customerid > 0){
        $sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs WHERE customerid=' . $customerid . ' AND productid=' .$productid;
        $check_exits = $db->query( $sql )->fetchColumn();
        if( $check_exits == 0 ) $userid_parent = 0;
        list ($quantity_out, $quantity_in ) = $db->query('SELECT quantity_out, quantity_in FROM ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs WHERE customerid =' . $customerid . ' AND productid=' . $productid )->fetch(3);
        return $quantity_in - $quantity_out;
    }
    return 0;
}

//tao kho hang cho thanh vien
function nvCreatWarehouse( $customerid, $title, $note )
{
    global $db, $module_data;

    $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse( customerid, title, note, addtime, price_discount_in, price_discount_out ) VALUES ( ' . $customerid . ', ' . $db->quote( $title ) . ', ' . $db->quote( $note ) . ', ' . NV_CURRENTTIME . ',0 ,0 )';
    return $db->query($sql);
}

//Ham cong chiet khau cho agency
//$type = 0 : chiet khau out, 1 chiet khau in
function add_discount_customer( $customerid, $total_price, $type = 0 ){

    global $db, $module_data;

    if( $type == 0 ){
        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse SET price_discount_out	= price_discount_out+' . $total_price . ' WHERE customerid =' . $customerid );
    }else{
        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse SET price_discount_in = price_discount_in+' . $total_price . ' WHERE customerid =' . $customerid );
    }
}

//Ham cong chiet khau cho agency
//$type = 0 : chiet khau out, 1 chiet khau in

function sub_discount_customer( $customerid, $total_price, $type = 0 ){

    global $db, $module_data;

    if( $type == 0 ){
        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse SET price_discount_out	= price_discount_out-' . $total_price . ' WHERE customerid =' . $customerid );
    }else{
        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse SET price_discount_in = price_discount_in-' . $total_price . ' WHERE customerid =' . $customerid );
    }
}

//Ham cong doanh thu theo thang cho thanh vien
function save_statistic_customer( $customerid, $total_price, $monthyear = '' ){
    global $db, $module_data;

    $monthyear = ($monthyear == '')? date('mY', NV_CURRENTTIME ) : $monthyear;
    $monthyear = intval( $monthyear );
    if ( $customerid > 0 and $total_price > 0 ) {
        $sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_statistic WHERE customer_id=' . $customerid . ' AND monthyear=' .$monthyear;
        $check_exits = $db->query( $sql )->fetchColumn();
        if( $check_exits == 0 ){
            $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_statistic( customer_id, monthyear, total_price ) 
            VALUES ( ' . $customerid . ', ' . $monthyear . ', ' . $total_price . ')';
            $db->query($sql);
        }
        else{
            $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_statistic SET total_price = total_price+' . $total_price . ' WHERE customer_id =' . $customerid . ' AND monthyear=' . $monthyear );
        }
    }
}

//Ham ghi lai thay doi ve kho hang sau khi tra hang
function save_warehouse_logs_customer( $quantity, $price, $customerid, $depotid, $productid, $type, $order_id ){
    global $db, $module_data;

    //quy trinh nguoc lai dat hang
    if( $type == '-'){
        //tru kho tuyen duoi
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs SET quantity_in = quantity_in-' . $quantity . ', price_out= price_out -' . $price . ' WHERE customerid =' . $customerid . ' AND productid=' . $productid . ' AND depotid=' . $depotid;
    }else{
        //hoan tra sl vao kho tuyen tren
        $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs SET quantity_out = quantity_out -' . $quantity . ', price_in= price_in -' . $price . ' WHERE customerid =' . $customerid . ' AND productid=' . $productid . ' AND depotid=' . $depotid;
    }

    $db->query($sql);

    save_warehouse_order_customer( $quantity, $price, $customerid, $depotid, $productid, $type, $order_id );
}

//Ham ghi lai thay doi ve kho hang sau khi tra hang
function save_warehouse_order_customer( $quantity, $price, $customerid, $depotid, $productid, $type, $order_id ){
    global $db, $module_data;

    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_order WHERE customerid=' . $customerid . ' AND productid=' .$productid . ' AND depotid=' . $depotid . ' ORDER BY addtime DESC LIMIT 1';

    $data_warehouse_logs = $db->query( $sql )->fetch();

    //sau khi co hanh dong cong so luong vao kho
    $quantity_in = $quantity_out = $price_in = $price_out = $quantity_befor = $quantity_after = 0;
    if( $type == '+'){
        $quantity_befor = intval( $data_warehouse_logs['quantity_after'] );
        $quantity_after = $data_warehouse_logs['quantity_after'] + $quantity;
        $quantity_in = $quantity;
        $price_out = $price;
    }else{
        $quantity_befor = intval( $data_warehouse_logs['quantity_after'] );
        $quantity_after = $data_warehouse_logs['quantity_after'] - $quantity;
        $quantity_out = $quantity;
        $price_in = $price;
    }

    $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_order( customerid, depotid, productid, orderid, quantity_befor, quantity_in, price_in, quantity_after, quantity_out, price_out, addtime ) 
                VALUES ( :customerid, :depotid, :productid, :orderid, :quantity_befor, :quantity_in, :price_in, :quantity_after, :quantity_out, :price_out, :addtime )';
    $data_insert = array();
    $data_insert['customerid'] = $customerid;
    $data_insert['depotid'] = $depotid;
    $data_insert['productid'] = $productid;
    $data_insert['orderid'] = $order_id;
    $data_insert['quantity_befor'] = $quantity_befor;
    $data_insert['quantity_in'] = $quantity_in;
    $data_insert['price_in'] = $price_in;
    $data_insert['quantity_after'] = $quantity_after;
    $data_insert['quantity_out'] = $quantity_out;
    $data_insert['price_out'] = $price_out;
    $data_insert['addtime'] = NV_CURRENTTIME;
    return $db->insert_id($sql, '', $data_insert);
}

//Lay so luong san pham cac don hang dat truoc
function get_order_ordertype2( $customer_id, $date_from, $date_to ){
    global $db, $module_data;

    if( $customer_id > 0){
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_orders WHERE ordertype=2 AND user_id =' . $customer_id;
    }else{
        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_orders WHERE ordertype=2 AND showadmin=1';
    }
    $where = '';
    if( $date_from >0 && $date_to > 0 ){
        $where .= ' AND order_time >= ' . $date_from;
    }
    if( $date_to >0 ){
        $where .= ' AND order_time <= ' . $date_to;
    }
    $sql .= $where;

    $array_product_num = array();
    $result = $db->query($sql);
    while ( $row = $result->fetch()){

        $sql_i = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_orders_id WHERE order_id=' . $row['order_id'];
        $result_i = $db->query($sql_i);
        while ( $row_i = $result_i->fetch()){
            if( !isset( $array_product_num[$row_i['proid']] )){
                $array_product_num[$row_i['proid']]['require'] = $row_i['num'];
            }else{
                $array_product_num[$row_i['proid']]['require'] += $row_i['num'];
            }
        }
    }
    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs WHERE customerid =' . $customer_id;
    $result = $db->query($sql);
    while ( $row = $result->fetch()){
        if( !isset( $array_product_num[$row['productid']]['numreal'] )){
            $array_product_num[$row['productid']]['numreal'] = $row['quantity_in'] - $row['quantity_out'];
        }else{
            $array_product_num[$row['productid']]['numreal'] += $row['quantity_in'] - $row['quantity_out'];
        }

    }

    return $array_product_num;
}

//tao noi dung cham soc khach hang
function nvInsertSmsQueue( $order_id, $proid, $product_name, $booktime, $full_name, $email, $phone, $address, $day_received )
{
    global $db, $module_data;

    //lay kich ban cham soc dc kich hoat
    $data = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_scenario_header WHERE status=1 AND proid =' . $proid )->fetch();
    if( !empty( $data )){

        list( $customer['shop_mobile'] ) = $db->query('SELECT t1.mobile FROM ' . NV_TABLE_AFFILIATE . '_users t1, ' . NV_PREFIXLANG . '_' . $module_data . '_orders t2 WHERE t1.userid=t2.user_id AND t2.order_id =' . $order_id )->fetch(3);

        $customer['phone'] = $phone;
        $customer['phone'] = $phone;
        $customer['fullname'] = $full_name;
        $customer['email'] = $email;
        $customer['address'] = $address;
        $customer['gender'] = 2;

        $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_scenario_detail WHERE status=1 AND scenarioid =' . $data['id'];
        $result = $db->query($sql);
        while ( $row = $result->fetch()){

            $receiver = '';
            if( $row['sendtype'] == 1 || $row['sendtype'] == 3 ){
                $receiver = $phone;
            }elseif( $row['sendtype'] == 2 ){
                $receiver = $email;
            }
            //co nguoi nhan thi moi tao noi dung cham soc
            if( !empty( $receiver )){
                $title = nv_build_content_customer($row['sendtype'], $row['title'], $customer);
                $content = nv_build_content_customer($row['sendtype'], $row['content'], $customer);

                //neu mua hang nhan ngay thi chinh lai thoi gian gui sms ngay sau thoi diem mua hang 1h
                $timesend = 0;
                if( $day_received == 0 && $row['daysend'] == 0){
                    $timesend = $booktime + 3600;
                }
                else{
                    $timesend = $booktime + (( $day_received + $row['daysend']) * 86400 );
                }

                $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_message_queue( order_id, proid, sid, sid_detail, title, receiver, content, timesend, sendtype, active ) 
                VALUES (  ' . intval( $order_id ) . ', ' . intval( $proid ) . ', ' . intval( $data['id'] ) . ', ' . intval( $row['id'] ) . ', ' . $db->quote( $title ) . ', ' . $db->quote( $receiver ) . ', ' . $db->quote( $content ) . ', ' . $timesend . ', ' . intval( $row['sendtype'] ) . ', 1)';
                $db->query($sql);
            }
        }
    }
}


function nv_build_content_customer($sendtype, $content, $customer)
{
    global $global_config, $lang_module;

    //khong phai gui mail thi loai bo cac the html
    if( $sendtype != 2 ){
        $content = nv_unhtmlspecialchars($content);
    }
    // Thay the bien noi dung
    $array_replace = array(
        '[FULLNAME]' => !empty($customer['fullname']) ? $customer['fullname'] : $lang_module['customers'],
        '[MOBILE]' => $customer['phone'],
        '[SHOP_MOBILE]' => !empty( $customer['shop_mobile'] )? $customer['shop_mobile'] : $global_config['site_phone'],
        '[EMAIL]' => $customer['email'],
        '[ADDRESS]' => $customer['address'],
        '[ALIAS]' => $lang_module['alias_' . $customer['gender']],
        '[SITE_NAME]' => $global_config['site_name'],
        '[SITE_DOMAIN]' => NV_MY_DOMAIN
    );
    $html = '';
    foreach ($array_replace as $index => $value) {
        $html = str_replace($index, $value, $html);
        $content = str_replace($index, $value, $content);
    }
    return $content;
}

//tru hang cho thanh vien khi don hang bi xoa
function trukhohanghoa( $customerid, $depotid, $productid, $quantity, $quantity_gif, $price, $typeorder=3, $order_id ){
    global $db, $module_data;
    $customerid = intval($customerid);

    if ( $productid > 0 and ($quantity > 0 || $quantity_gif > 0) ) {
        //khach le se khong co kho hang
        if( $typeorder != 3 ){
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs SET quantity_in = quantity_in-' . $quantity . ', quantity_gift_in = quantity_gift_in-' . $quantity_gif . ', price_out= price_out-' . $price . ' WHERE customerid =' . $customerid . ' AND productid=' . $productid;

            $res = $db->query($sql);
            $db->exec("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_warehouse_order WHERE orderid=" . $order_id);
        }
        if( ($res or $typeorder == 3) && $customerid > 0){
            if( $typeorder != 3 ){
                $sql = 'SELECT parentid FROM ' . NV_TABLE_AFFILIATE . '_users WHERE userid=' . $customerid;
            }else{
                $sql = 'SELECT refer_userid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_customer WHERE customer_id=' . $customerid;
            }
            list( $userid_parent ) = $db->query( $sql )->fetch(3);//neu = 0 thi se tru tai kho tong cty
            $sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs WHERE customerid=' . $userid_parent . ' AND productid=' .$productid . ' AND depotid=' . $depotid;

            $check_exits = $db->query( $sql )->fetchColumn();
            if( $check_exits == 0 ) $userid_parent = 0;
            //cong lai so luong trong kho tong ben tren va cong tien cua khach hang nay
            $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs SET quantity_out = quantity_out-' . intval( $quantity ) . ',quantity_gift_out = quantity_gift_out-' . intval( $quantity_gif ) . ', price_in= price_in-' . $price . ' WHERE customerid =' . $userid_parent . ' AND productid=' . $productid . ' AND depotid=' . $depotid );
            $db->exec("DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_warehouse_order WHERE orderid=" . $order_id);
        }
    }
}


/*
 *  $customerid_from Ma thanh vien chuyen hang
 *  $customerid_to ma thanh vien nhan hang
 *  $tranfer_from Ma kho hang cua thanh vien chuyen
 *  $tranfer_to ma kho hang cua thanh vien nhan hang
 *  $productid Ma san pham
 *  $quantity SL chuyen
 */

//luan chuyen hang hoa cho thanh vien
function luanchuyenhanghoa( $customerid_from, $customerid_to, $tranfer_from, $tranfer_to, $productid, $quantity ){

    global $db, $module_data;

    if ( $productid > 0 and $quantity > 0 ) {

        $sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs WHERE customerid=' . $customerid_to . ' AND productid=' . $productid . ' AND depotid=' . $tranfer_to;
        $check_exits = $db->query($sql)->fetchColumn();
        if ($check_exits == 0) {
            $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs( customerid, depotid, productid, quantity_in, quantity_gift_in, price_in, quantity_out, quantity_gift_out, price_out ) 
            VALUES ( ' . $customerid_to . ', ' . $tranfer_to . ', ' . $productid . ', ' . $quantity . ', 0, 0, 0, 0, 0)';

            $res = $db->query($sql);
        } else {
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs SET quantity_in = quantity_in+' . $quantity . ' WHERE customerid =' . $customerid_to . ' AND productid=' . $productid . ' AND depotid=' . $tranfer_to;
            $res = $db->query($sql);
        }
        if( $res ){
            save_warehouse_order_customer( $quantity, 0, $customerid_to, $tranfer_to, $productid, '+', 0 );

            //tru hang hoa o kho goc
            $sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs SET quantity_out = quantity_out+' . $quantity . ' WHERE customerid =' . $customerid_from . ' AND productid=' . $productid . ' AND depotid=' . $tranfer_from;
            $db->query($sql);
            save_warehouse_order_customer( $quantity, 0, $customerid_from, $tranfer_from, $productid, '-', 0 );
        }


    }
}


function convert_number_to_string( $number )
{
    $hyphen = ' ';
    $conjunction = '  ';
    $separator = ' ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = array(
        0 => 'không',
        1 => 'một',
        2 => 'hai',
        3 => 'ba',
        4 => 'bốn',
        5 => 'năm',
        6 => 'sáu',
        7 => 'bảy',
        8 => 'tám',
        9 => 'chín',
        10 => 'mười',
        11 => 'mười một',
        12 => 'mười hai',
        13 => 'mười ba',
        14 => 'mười bốn',
        15 => 'mười lăm',
        16 => 'mười sáu',
        17 => 'mười bảy',
        18 => 'mười tám',
        19 => 'mười chín',
        20 => 'hai mươi',
        30 => 'ba mươi',
        40 => 'bốn mươi',
        50 => 'năm mươi',
        60 => 'sáu mươi',
        70 => 'bảy mươi',
        80 => 'tám mươi',
        90 => 'chín mươi',
        100 => 'trăm',
        1000 => 'ngàn',
        1000000 => 'triệu',
        1000000000 => 'tỉ',
        1000000000000 => 'nghìn tỉ',
        1000000000000000 => 'ngàn triệu tỉ',
        1000000000000000000 => 'tỉ tỉ' );
    if( ! is_numeric( $number ) )
    {
        return false;
    }

    if( ( $number >= 0 && ( int )$number < 0 ) || ( int )$number < 0 - PHP_INT_MAX )
    {
        // overflow
        trigger_error( 'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING );
        return false;
    }

    if( $number < 0 )
    {
        return $negative . convert_number_to_string( abs( $number ) );
    }
    $string = $fraction = null;

    if( strpos( $number, '.' ) !== false )
    {
        list( $number, $fraction ) = explode( '.', $number );
    }

    switch( true )
    {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens = ( ( int )( $number / 10 ) ) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if( $units )
            {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if( $remainder )
            {
                $string .= $conjunction . convert_number_to_string( $remainder );
            }
            break;
        default:
            $baseUnit = pow( 1000, floor( log( $number, 1000 ) ) );
            $numBaseUnits = ( int )( $number / $baseUnit );
            $remainder = $number % $baseUnit;
            $string = convert_number_to_string( $numBaseUnits ) . ' ' . $dictionary[$baseUnit];
            if( $remainder )
            {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_string( $remainder );
            }
            break;
    }

    if( null !== $fraction && is_numeric( $fraction ) )
    {
        $string .= $decimal;
        $words = array();
        foreach( str_split( ( string )$fraction ) as $number )
        {
            $words[] = $dictionary[$number];
        }
        $string .= implode( ' ', $words );
    }

    return $string . '';
}