<?php/** * @Project NUKEVIET 4.x * @Author VINADES.,JSC (contact@vinades.vn) * @Copyright (C) 2017 VINADES.,JSC. All rights reserved * @License GNU/GPL version 2 or any later version * @Createdate 04/18/2017 09:47 */if( !defined( 'NV_IS_MOD_SM' ) ){    die( 'Stop!!!' );}$table_name = NV_PREFIXLANG . '_' . $module_data . '_orders';if( $nv_Request->isset_request( 'avaible', 'post')) {    $order_id = $nv_Request->get_int('order_id', 'get', 0);    $sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_orders WHERE status=-1 AND order_id=' . $order_id;    $data_order = $db->query($sql)->fetch();    if( !empty( $data_order )){        $result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_orders_id WHERE order_id=' . $order_id );        $array_product_order = array();        while ( $data =  $result->fetch()){            $array_product_order[] = $data;            $sql = 'SELECT quantity_in, quantity_gift_in, quantity_out, quantity_gift_out FROM ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs WHERE depotid=' . $data_order['depotid'] . ' AND customerid=' . $data_order['user_id'] . ' AND productid=' .$data['proid'];            $data_warehouse_logs = $db->query( $sql )->fetch();            $quantity_allow = ( $data_warehouse_logs['quantity_in'] + $data_warehouse_logs['quantity_gift_in'] ) - ( $data_warehouse_logs['quantity_out'] + $data_warehouse_logs['quantity_gift_out']);            if( $quantity_allow < $data['num'] ){                exit(sprintf($lang_module['error_number_product_book'], $array_product[$data['proid']]['title'], $quantity_allow, $data['num'] ));            }        }        foreach ( $array_product_order as $order_product){            //Khach le mua thi ghi vào bang cham soc khach hang            if( $data_order['chossentype'] == 3 ){                $day_received = ($data_order['order_shipcod'] == 1) ? NV_DEFINE_DAY_RECEIVED : 0;                $product_name = $array_product[$order_product['proid']]['title'];                nvInsertSmsQueue( $order_id, $order_product['id'], $product_name, NV_CURRENTTIME, $data_order['order_name'], $data_order['order_email'], $data_order['order_phone'], $data_order['order_address'], $day_received );            }            $order_product['price_total'] = $order_product['price'] * $order_product['num'];            //tru so luong trong kho tong ben tren va cong tien cua khach hang nay            $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_warehouse_logs SET quantity_out = quantity_out+' . $order_product['num'] . ', price_in= price_in +' . $order_product['price_total'] . ' WHERE customerid =' . $data_order['user_id'] . ' AND productid=' . $order_product['proid'] . ' AND depotid=' . $data_order['depotid'] );            //tru hang trong kho            save_warehouse_order_customer( $order_product['num'], $order_product['price_total'], $data_order['user_id'], $data_order['depotid'], $order_product['proid'], '-', $order_id );        }        $db->query('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_orders SET status = 0 WHERE order_id=' . $data_order['order_id'] );        exit('Xác nhận đơn hàng thành công!');    }}if( $nv_Request->isset_request( 'active_pay', 'get')){    $contents = $lang_module['order_submit_pay_error'];    $order_id = $nv_Request->get_int('order_id', 'get', 0);    $save = $nv_Request->get_title('save', 'post,get', '');    $action = $nv_Request->get_title('action', 'post,get', '');    $result = $db->query('SELECT * FROM ' . $table_name . ' WHERE order_id=' . $order_id);    $data_content = $result->fetch();        $payment_amount = $nv_Request->get_title('payment_amount', 'post,get', '');    $payment_amount = doubleval( str_replace(',', '', $payment_amount ) );        if (empty($data_content) or empty($action)) {        $contents = $lang_module['order_submit_pay_error'];    }    if ($save == 1) {        /* transaction_status: Trang thai giao dich:         -1 - Giao dich cho duyet         0 - Giao dich moi tao         1 - Chua thanh toan;         2 - Da thanh toan, dang bi tam giu;         3 - Giao dich bi huy;         4 - Giao dich da hoan thanh thanh cong (truong hop thanh toan ngay hoac thanh toan tam giu nhung nguoi mua da phe chuan)         */        if ($action == 'unpay') {            $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_transaction WHERE  order_id = ' . $order_id);            $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_orders SET status=0 WHERE order_id=" . $order_id);            nv_insert_logs(NV_LANG_DATA, $module_name, 'Drop payment product', "Order code: " . $data_content['order_code'], $admin_info['userid']);            $contents = $lang_module['order_submit_unpay_ok'];            $nv_Cache->delMod($module_name);        } elseif ($action == 'pay') {            $transaction_status = 4;            $payment_id = 0;            $payment_data = '';            $payment = '';            $userid = $user_info['userid'];            if( $data_content['status'] != 4 ){                //tru ton neu chua xac nhan                //kiem tra xem la co dong hay la npp                list( $shareholder ) = $db->query( 'SELECT shareholder FROM ' . NV_TABLE_AFFILIATE . '_users WHERE userid=' . $data_content['customer_id'] )->fetch(3);                //lay so luong trong don dat hang de kiem tra so luong                $result = $db->query('SELECT * FROM ' . $table_name . '_id WHERE order_id=' . $order_id);                $array_total_productid = array();                $array_number_productid = array();                while( $data_order = $result->fetch()){                    if( !isset( $array_total_productid[$data_order['proid']] )){                        $array_total_productid[$data_order['proid']] = $data_order['num'];                    }else{                        $array_total_productid[$data_order['proid']] += $data_order['num'];                    }                    if( !isset( $array_number_productid[$data_order['proid']]['num_com'] )){                        $array_number_productid[$data_order['proid']]['num_com'] = $data_order['num_com'];                    }else{                        $array_number_productid[$data_order['proid']]['num_com'] += $data_order['num_com'];                    }                    if( $data_order['isgift'] == 1 ){                        if( !isset( $array_number_productid[$data_order['proid']]['numgift'] )){                            $array_number_productid[$data_order['proid']]['numgift'] = $data_order['num'];                        }else{                            $array_number_productid[$data_order['proid']]['numgift'] += $data_order['num'];                        }                    }else{                        if( !isset( $array_number_productid[$data_order['proid']]['num'] )){                            $array_number_productid[$data_order['proid']]['num'] = $data_order['num'];                        }else{                            $array_number_productid[$data_order['proid']]['num'] += $data_order['num'];                        }                        $array_number_productid[$data_order['proid']]['price'] = $data_order['price'];                    }                }                //print_r($array_number_productid);die;                //kiem tra so luong trong kho truoc khi tru ton                $error = '';                foreach ( $array_total_productid as $proid => $number ){                    $check_warehouse = ( $data_content['depotid'] > 0 )? 1 : 0;                    $total_num_product = checkNumTotalInParentCustomer( $data_content['customer_id'], $data_content['depotid'], $proid, $check_warehouse );                    if( $total_num_product < $number ){                        $error = sprintf( $lang_module['number_in_warehouse_logs_error'], $array_product[$proid]['title'], $total_num_product );                    }                }                if( empty( $error )){                    //cap nhat hang hoa                    foreach ( $array_number_productid as $proid => $datanumber)                    {                        $price = $datanumber['price'] * $datanumber['num'];//gia theo sl dat                        $quantity = $datanumber['num'] + $datanumber['numgift'];//so luong bao gom ca sp tang                        nhapkhohanghoa( $data_content['customer_id'], $data_content['depotid'], $proid, $quantity, $price, '+', $data_content['chossentype'], $order_id, $datanumber['num_com'] );                    }                    $transaction_id = $db->insert_id("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_transaction (transaction_id, transaction_time, transaction_status, order_id, userid, payment, payment_id, payment_time, payment_amount, payment_data) VALUES (NULL, " . NV_CURRENTTIME . ", '" . $transaction_status . "', '" . $order_id . "', '" . $userid . "', '" . $payment . "', '" . $payment_id . "', " . NV_CURRENTTIME . ", '" . $payment_amount . "', '" . $payment_data . "')");                    if ($transaction_id > 0) {                        $db->query("UPDATE " . NV_PREFIXLANG  . "_" . $module_data . "_orders SET status=" . $transaction_status . ", price_payment=price_payment+" . $payment_amount . " WHERE order_id=" . $order_id);                        $db->query("UPDATE " . NV_TABLE_AFFILIATE . "_users SET haveorder=1 WHERE userid=" . $data_content['customer_id']);                        save_statistic_customer( $data_content['customer_id'], $data_content['order_total'] );                    }                    $contents = $lang_module['order_submit_pay_ok'];                }                else{                    $contents = $error;                }            }else{                $transaction_id = $db->insert_id("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_transaction (transaction_id, transaction_time, transaction_status, order_id, userid, payment, payment_id, payment_time, payment_amount, payment_data) VALUES (NULL, " . NV_CURRENTTIME . ", '" . $transaction_status . "', '" . $order_id . "', '" . $userid . "', '" . $payment . "', '" . $payment_id . "', " . NV_CURRENTTIME . ", '" . $payment_amount . "', '" . $payment_data . "')");                if ($transaction_id > 0) {                    $db->query("UPDATE " . NV_PREFIXLANG  . "_" . $module_data . "_orders SET status=" . $transaction_status . ", price_payment=price_payment+" . $payment_amount . " WHERE order_id=" . $order_id);                    $db->query("UPDATE " . NV_TABLE_AFFILIATE . "_users SET haveorder=1 WHERE userid=" . $data_content['customer_id']);                    save_statistic_customer( $data_content['customer_id'], $data_content['order_total'] );                }                $contents = $lang_module['order_submit_pay_ok'];            }            $nv_Cache->delMod($module_name);        }        elseif ($action == 'return') {            $transaction_status = 5;            $payment_id = 0;            $payment_amount = $nv_Request->get_int('money_return', 'get,post', 0);            $payment_data = '';            $payment = '';            $userid = $admin_info['userid'];            $transaction_id = $db->insert_id("INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_transaction (transaction_id, transaction_time, transaction_status, order_id, userid, payment, payment_id, payment_time, payment_amount, payment_data) VALUES (NULL, " . NV_CURRENTTIME . ", '" . $transaction_status . "', '" . $order_id . "', '" . $userid . "', '" . $payment . "', '" . $payment_id . "', " . NV_CURRENTTIME . ", '" . $payment_amount . "', '" . $payment_data . "')");            $contents = $lang_module['order_submit_return_ok'];            $nv_Cache->delMod($module_name);        }    }    die($contents);}$page_title = $lang_module['order_title'];$data_content = array();$order_id = $nv_Request->get_int('order_id', 'post,get', 0);$checkss = $nv_Request->get_string('checkss', 'get', '');if ($order_id > 0 and $checkss == md5($order_id . $global_config['sitekey'] . session_id())) {    $result = $db->query('SELECT * FROM ' . $table_name . ' WHERE order_id=' . $order_id);    $data_content = $result->fetch();}$save = $nv_Request->get_string('save', 'post', '');if (empty($data_content)) {    Header('Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=order');}if ($save == 1 and intval($data_content['transaction_status']) == - 1) {    $order_id = $nv_Request->get_int('order_id', 'post', 0);    $transaction_status = 0;    $payment_id = 0;    $payment_amount = 0;    $payment_data = '';    $payment = '';    $userid = $admin_info['userid'];    $db->query("UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_orders SET transaction_status=" . $transaction_status . " , transaction_id = 1 WHERE order_id=" . $order_id);    nv_insert_logs(NV_LANG_DATA, $module_name, 'log_process_product', "order_id " . $order_id, $admin_info['userid']);    $nv_Cache->delMod($module_name);    Header('Location: ' . NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=order');}$link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=';// Thong tin chi tiet mat hang trong don hang$listid = $isgift = $listnum = $listnumgif = $listprice = array();$result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_orders_id WHERE order_id='.$order_id );while ($row = $result->fetch()) {    $listid[] = $row['proid'];    $isgift[] = $row['isgift'];    $listnum[] = $row['num'];    $listnumgif[] = $row['numgif'];    $listprice[] = $row['price'];}$data_pro = array();$i = 0;$total = 0;foreach ($listid as $id) {    $sql = 'SELECT t1.*, t2.title AS unit_title FROM ' . NV_PREFIXLANG . '_' . $module_data . '_units AS t2, ' . NV_PREFIXLANG . '_' . $module_data . '_product AS t1 WHERE t1.unit=t2.id AND t1.id =' . $id . ' AND t1.status =1';    $result = $db->query($sql);    if ($result->rowCount()) {        $row = $result->fetch();        $row['product_price'] = number_format( $listprice[$i], 0, '.', ',');        $row['product_number'] = $listnum[$i];        $row['product_numbergif'] = $listnumgif[$i];        $price = $listprice[$i] * $listnum[$i];        $row['isgift'] = $isgift[$i];        $total += $price;        $row['product_price_total'] = number_format( $price, 0, '.', ',');        $data_pro[] = $row;        ++ $i;    }}if ($data_content['ordertype'] == 2 ) {    $lang_module['price_payment'] = $lang_module['price_book_plane'];}if( $data_content['status'] != 0 ){    $payment_amount = $data_content['order_total'] - $data_content['price_payment'];    }elseif( $data_content['status'] == 0 ){    $payment_amount = $data_content['order_total'];}$data_content['price_payment_fomart'] = number_format( $data_content['price_payment'], 0, '.', ',');$xtpl = new XTemplate('or_view.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);$xtpl->assign('LANG', $lang_module);$xtpl->assign('dateup', date('d-m-Y', $data_content['order_time']));$xtpl->assign('moment', date('H:i', $data_content['order_time']));$xtpl->assign('DATA', $data_content);$xtpl->assign('order_id', $data_content['order_id']);$xtpl->assign('payment_amount', number_format( $payment_amount, 0, '.', ','));$xtpl->assign('total', number_format( $total, 0, '.', ','));if( $data_content['price_payment'] > 0) {    $xtpl->parse('main.price_payment');    $total = $total - $data_content['price_payment'];}if( $data_content['saleoff'] > 0){    $total_sale =  $total - $data_content['saleoff'];    $xtpl->assign('total_sale', number_format( $data_content['saleoff'], 0, '.', ','));    $xtpl->assign('total_sale_price', number_format( $total_sale, 0, '.', ','));    $xtpl->parse('main.total_sale');}$total_gif = array_sum( $listnumgif );$stt = 1;foreach ($data_pro as $pdata) {    $pdata['stt'] = $stt++;    $pdata['isgift'] = ( $pdata['isgift'] == 1 )? $lang_module['product_gift'] : '';    $xtpl->assign('PDATA', $pdata);    if($total_gif > 0 ){        $xtpl->parse('main.loop.product_gift');    }    $xtpl->parse('main.loop');}if( $total_gif > 0){    $xtpl->parse('main.product_gift');}if (! empty($data_content['order_note'])) {    $xtpl->parse('main.order_note');}$a = 1;$array_transaction = array();$result = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_transaction WHERE order_id=' . $order_id . ' ORDER BY transaction_id DESC');if ($result->rowCount()) {    $array_payment = array();    while ($row = $result->fetch()) {        $row['a'] = $a ++;        $row['transaction_time'] = nv_date('H:i:s d/m/y', $row['transaction_time']);        $row['order_id'] = (! empty($row['order_id'])) ? $row['order_id'] : '';        $row['payment_time'] = (! empty($row['payment_time'])) ? nv_date('H:i:s d/m/y', $row['payment_time']) : '';        $row['payment_id'] = (! empty($row['payment_id'])) ? $row['payment_id'] : '';        if (! empty($row['payment_id'])) {            $array_payment[] = $row['payment_id'];        }        $row['payment_amount'] = number_format( $row['payment_amount'], 0, '.', ',');        if ($row['transaction_status'] == 4) {            $row['transaction'] = $lang_module['history_payment_yes'];        }  elseif ($row['transaction_status'] == 5) {            $row['transaction'] = $lang_module['history_payment_return'];        } elseif ($row['transaction_status'] == 3) {            $row['transaction'] = $lang_module['history_payment_cancel'];        } elseif ($row['transaction_status'] == 2) {            $row['transaction'] = $lang_module['history_payment_check'];        } elseif ($row['transaction_status'] == 1) {            $row['transaction'] = $lang_module['history_payment_send'];        } elseif ($row['transaction_status'] == 0) {            $row['transaction'] = $lang_module['history_payment_no'];        } elseif ($row['transaction_status'] == - 1) {            $row['transaction'] = $lang_module['history_payment_wait'];        } else {            $row['transaction'] = 'N/A';        }        if ($row['userid'] > 0) {            $username = $db->query('SELECT username FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid=' . $row['userid'])->fetchColumn();            $row['payment'] = $username;            $row['link_user'] = NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=users&' . NV_OP_VARIABLE . '=edit&userid=' . $row['userid'];        } elseif (isset($array_data_payment[$row['payment']])) {            $row['link_user'] = $array_data_payment[$row['payment']]['domain'];            $row['payment'] = $array_data_payment[$row['payment']]['paymentname'];        } else {            $row['link_user'] = '#';        }        $xtpl->assign('DATA_TRANS', $row);        $xtpl->parse('main.transaction.looptrans');    }    if (! empty($array_payment)) {        $xtpl->assign('LINK_CHECK_PAYMENT', NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&order_id=' . $order_id . '&checkpayment=' . md5($order_id . session_id() . $global_config['sitekey']));        $xtpl->parse('main.transaction.checkpayment');    }    $xtpl->parse('main.transaction');}if( $data_content['ordertype'] == 2 ){    $lang_module['history_payment_no'] = $lang_module['history_payment_no_plane'];}if( $data_content['ordertype'] == 2 ){    $lang_module['history_payment_no'] = $lang_module['history_payment_no_plane'];    $lang_module['history_payment_yes'] = $lang_module['history_payment_yes_plane'];}else{    $lang_module['history_payment_no'] = $lang_module['history_payment_no'];    $lang_module['history_payment_yes'] = $lang_module['history_payment_yes'];}if ($data_content['status'] == 4) {    $html_payment = $lang_module['history_payment_yes'];} elseif ($data_content['status'] == 5) {    $html_payment = $lang_module['history_order_ships'];}  elseif ($data_content['status'] == 3) {    $html_payment = $lang_module['history_payment_cancel'];} elseif ($data_content['status'] == 2) {    $html_payment = $lang_module['history_payment_check'];} elseif ($data_content['status'] == 1) {    $html_payment = $lang_module['history_payment_send'];} elseif ($data_content['status'] == 0) {    $html_payment = $lang_module['history_payment_no'];} elseif ($data_content['status'] == - 1) {    $html_payment = $lang_module['history_payment_wait'];} else {    $html_payment = 'N/A';}$xtpl->assign('payment', $html_payment);if ($data_content['status'] == - 1) {    $xtpl->parse('main.onsubmit');}$action_pay = '';$show_payment = 1;if ($data_content['status'] != '4' && $user_data_affiliate['agencyid'] > 0 && ( $data_content['chossentype'] != 3 && $data_content['user_id'] == $user_info['userid'] )) {    $action_pay = '&action=pay';    $xtpl->parse('main.onpay');    $show_payment = 0;}/*else {    $lang_module['order_submit_pay_comfix'] = $lang_module['order_submit_unpay_comfix'];    $xtpl->parse('main.unpay');    $action_pay = '&action=unpay';    $xtpl->parse('main.onreturn');} */if ( $show_payment == 1 && ($data_content['status'] < 4 || $data_content['price_payment'] < $data_content['order_total'])) {    $action_pay = '&action=pay';    $xtpl->parse('main.onpay');    if( $data_content['status'] == -1 ){        $xtpl->parse('main.active_order');        $action_pay = '&action=avaible';    }}$xtpl->assign('URL_ACTIVE_RETURN', NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&active_pay=1&order_id=' . $order_id . '&action=return');$xtpl->assign('LINK_PRINT', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=print&order_id=' . $data_content['order_id'] . '&checkss=' . md5($data_content['order_id'] . $global_config['sitekey'] . session_id()));$xtpl->assign('URL_ACTIVE_PAY', NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&active_pay=1&order_id=' . $order_id . $action_pay);$xtpl->assign('URL_BACK', NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=or_view&order_id=' . $order_id);$xtpl->assign('URL_AVAIBLE', NV_BASE_SITEURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&order_id=' . $order_id . $action_pay);$xtpl->parse('main');$contents = $xtpl->text('main');$set_active_op = 'order';include NV_ROOTDIR . '/includes/header.php';echo nv_site_theme($contents);include NV_ROOTDIR . '/includes/footer.php';