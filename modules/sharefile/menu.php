<?php

/**
 * @Project NUKEVIET 4.x
 * @Author EDUS.,JSC (thangbv@edus.vn)
 * @Copyright (C) 2014 EDUS.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 21-04-2011 11:17
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_categories ORDER BY parentid, weight ASC';
$result = $db->query( $sql );
While( $row = $result->fetch() )
{
	$array_item[$row['id']] = array(
		'parentid' => $row['parentid'],
		'groups_view' => $row['groups_view'],
		'key' => $row['id'],
		'title' => $row['title'],
		'alias' => $row['alias']
	);
}