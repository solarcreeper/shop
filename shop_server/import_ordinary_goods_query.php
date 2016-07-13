<?php
require_once("./function/settings.php");
require_once("./function/check.php");
$token = clean_input($_GET['TOKEN']);
$username = clean_input($_GET['USERNAME']);
$is_excel = clean_input($_GET['IS_EXCEL']);
$check_result = check_token($username, $token);
//test data
// $check_result = ACCESS_ADMIN;
if($check_result == ACCESS_ADMIN){
	update_token($username, $token);
	// DB table to use
	$table = 't_item_data';

	// Table's primary key
	$primaryKey = 'id';
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
		array( 'db' => 'id', 			'dt' => 'INDEX' ),
		array( 'db' => 'sku', 			'dt' => 'SKU' ),
		array( 'db' => 'goods_name', 	'dt' => 'GOODS_NAME' ),
		array( 'db' => 'shop_price', 	'dt' => 'PRICE' ),
		array( 'db' => 'stock',  		'dt' => 'TOTAL_STOCK' ),
		array( 'db' => 'picture',   	'dt' => 'PICTURE' ),
	);
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP
	 * server-side, there is no need to edit below this line.
	 */
	require( './function/ssp.class.php' );
	//echo $_GET;
	if($is_excel == ""){
		echo "{\"draw\":0,\"recordsTotal\":0,\"recordsFiltered\":0,\"data\":[], \"error_code\":\"".FAILED."\", \"error_msg\": \"未知类型！\"}";
	}else{
		$index = "is_excel = ".$is_excel;
		echo json_encode(SSP::search_index( $_GET, $table, $primaryKey, $columns, null, $index));
	}
}else{
	echo "{\"draw\":0,\"recordsTotal\":0,\"recordsFiltered\":0,\"data\":[], \"error_code\":\"".TOKEN_CHECK_FAILED."\", \"error_msg\": \"权限认证失败！\"}";
}
?>