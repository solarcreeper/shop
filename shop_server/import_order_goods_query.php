<?php
require_once("./function/settings.php");
require_once("./function/check.php");
$token = clean_input($_GET['TOKEN']);
$username = clean_input($_GET['USERNAME']);
$original_order_no = clean_input($_GET['ORIGINAL_ORDER_NO']);
$check_result = check_token($username, $token);
//test data
// $original_order_no = "1";
// $check_result = ACCESS_ALLOW;
if($check_result != ACCESS_DENAIL){
	update_token($username, $token);
	// DB table to use
	$table = 't_goods_data';

	// Table's primary key
	$primaryKey = 'id';

	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
		array( 'db' => 'id', 	 'dt' => 'INDEX' ),
		array( 'db' => 'sku',   				 'dt' => 'SKU' ),
		array( 'db' => 'goods_spec',   			 'dt' => 'GOODS_SPEC' ),
		array( 'db' => 'price',   				 'dt' => 'PRICE' ),
		array( 'db' => 'qty',   				 'dt' => 'QTY' ),
	);
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP
	 * server-side, there is no need to edit below this line.
	 */
	require( './function/ssp.class.php' );
	//echo $_GET;
	if($original_order_no != ""){
		$original_order_no = "original_order_no = '".$original_order_no."'";
		echo json_encode(SSP::search_index( $_GET, $table, $primaryKey, $columns, null, $original_order_no));
	}else{
		echo "{\"draw\":0,\"recordsTotal\":0,\"recordsFiltered\":0,\"data\":[]}";
	}
}else{
	echo "{\"draw\":0,\"recordsTotal\":0,\"recordsFiltered\":0,\"data\":[], \"error_code\":\"".TOKEN_CHECK_FAILED."\", \"error_msg\": \"权限认证失败！\"}";
}

?>