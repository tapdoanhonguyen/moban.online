<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2017 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );


$q_search = $nv_Request->get_title( 'term', 'get', '', 1 );
if( empty( $q_search ) ) return;

$mod_name = $nv_Request->get_title( 'mod_name', 'get', '', 1 );
$mod_data = $site_mods[$mod_name]['module_data'];

require_once  NV_ROOTDIR . '/modules/' . $site_mods[$mod_name]['module_file'] . '/affiliate-product.php';

header( 'Cache-Control: no-cache, must-revalidate' );
header( 'Content-type: application/json' );

ob_start( 'ob_gzhandler' );
echo json_encode( $array_item );
exit();
