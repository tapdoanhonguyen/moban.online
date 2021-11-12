<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2017 14:43
 */

if( ! defined( 'NV_IS_MOD_AFFILIATE' ) ) die( 'Stop!!!' );


$q = $nv_Request->get_title( 'term', 'get', '', 1 );
if( empty( $q ) ) return;

$db->sqlreset()->select( 'userid, username,first_name, last_name, birthday, email' )->from( NV_USERS_GLOBALTABLE )->where( 'userid !=' . $user_info['userid'] )->limit( 20 );

$sth = $db->prepare( $db->sql() );
$sth->bindValue( ':fullname', '%' . $q . '%', PDO::PARAM_STR );
$sth->bindValue( ':username', '%' . $q . '%', PDO::PARAM_STR );
$sth->bindValue( ':email', '%' . $q . '%', PDO::PARAM_STR );
$sth->execute();

$array_data = array();
while( list( $userid, $username, $first_name, $last_name, $birthday, $email ) = $sth->fetch( 3 ) )
{
    $fullname = nv_show_name_user( $first_name, $last_name, $username );
    $array_data[] = array(
        'key' => $userid,
        'value' => $username . ' - ' . $fullname . ' - ' . $email,
        'fullname' => $fullname,
        'birthday' => ( $birthday > 0 )? date('d/m/Y', $birthday) : '',
        'username' => $username,
        'email' => $email,
    );
}

header( 'Cache-Control: no-cache, must-revalidate' );
header( 'Content-type: application/json' );

ob_start( 'ob_gzhandler' );
echo json_encode( $array_data );
exit();
