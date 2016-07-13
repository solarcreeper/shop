<?php
require_once("./function/settings.php");
require_once("./function/check.php");
$token = clean_input($_GET['TOKEN']);
$username = clean_input($_GET['USERNAME']);
$check_result = check_token($username, $token);
//test data
// echo $token."</br>".$username;
// echo $check_result;
// $check_result = ACCESS_ADMIN;
if($check_result != ACCESS_DENAIL){
	update_token($username, $token);
	// DB table to use
	$table = 'sku_info_with_user_stock';

	// Table's primary key
	$primaryKey = 'sku';
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
		array( 'db' => 'sku',  				'dt' => 'SKU' ),
		array( 'db' => 'goods_name',   		'dt' => 'GOODS_NAME' ),
		array( 'db' => 'goods_spec',   		'dt' => 'GOODS_SPEC' ),
		array( 'db' => 'price',   			'dt' => 'PRICE' ),
		array( 'db' => 'picture',   		'dt' => 'PICTURE' ),
		array( 'db' => 'total_stock',   	'dt' => 'TOTAL_STOCK' ),
		array( 'db' => 'availble_stock',   	'dt' => 'AVAILABLE_STOCK' ),
		array( 'db' => 'user_price',   		'dt' => 'USER_PRICE' ),
	);
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP
	 * server-side, there is no need to edit below this line.
	 */
	require( './function/ssp.class.php' );
	//echo $_GET;
	$index = "username = '".$username."'";
	echo json_encode(SSP::search_index( $_GET, $table, $primaryKey, $columns, null, $index));
}else{
	echo "{\"draw\":0,\"recordsTotal\":0,\"recordsFiltered\":0,\"data\":[], \"error_code\":\"".TOKEN_CHECK_FAILED."\", \"error_msg\": \"权限认证失败！\"}";
}
?>