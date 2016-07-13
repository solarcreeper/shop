<?php
require_once("./function/settings.php");
require_once("./function/check.php");
$token = clean_input($_GET['TOKEN']);
$username = clean_input($_GET['USERNAME']);
$is_excel = clean_input($_GET['IS_EXCEL']);
$check_result = check_token($username, $token);
//test data
// $username = "TESTER";
// $check_result = ACCESS_ADMIN;
// $is_excel = "2";
if($check_result != ACCESS_DENAIL){
	update_token($username, $token);
	// DB table to use
	$table = 't_order_data';

	// Table's primary key
	$primaryKey = 'id';
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
		array( 'db' => 'id', 				'dt' => 'INDEX' ),
		array( 'db' => 'original_order_no', 'dt' => 'ORIGINAL_ORDER_NO' ),
		array( 'db' => 'receiver_name', 	'dt' => 'RECEIVER_NAME' ),
		array( 'db' => 'province_name', 	'dt' => 'XIYONG_PROVINCE' ),
		array( 'db' => 'city_name',  		'dt' => 'XIYONG_CITY' ),
		array( 'db' => 'area_name',   		'dt' => 'XIYONG_AREA' ),
		array( 'db' => 'receiver_address',  'dt' => 'RECEIVER_ADDRESS' ),
		array( 'db' => 'zip',   			'dt' => 'XIYONG_ZIP' ),
		array( 'db' => 'tel',   			'dt' => 'RECEIVER_TEL' ),
		array( 'db' => 'receiver_id_no',   	'dt' => 'RECEIVER_ID_NO' ),
		array( 'db' => 'remark',   			'dt' => 'ORDER_MEMO' ),
		array( 'db' => 'pay_note',   		'dt' => 'PAY_MEMO' ),
		array( 'db' => 'bill_date',   		'dt' => 'XIYONG_BILL_DATE' ),
		array( 'db' => 'transport_fee',   	'dt' => 'TRANSPORT_FEE' ),
		array( 'db' => 'goods_fee',   		'dt' => 'PAY_AMOUNT' ),
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
		$index = "is_excel = ".$is_excel." and username = '".$username."'";
		echo json_encode(SSP::search_index( $_GET, $table, $primaryKey, $columns, null, $index), JSON_UNESCAPED_UNICODE);
	}
	
}else{
	echo "{\"draw\":0,\"recordsTotal\":0,\"recordsFiltered\":0,\"data\":[], \"error_code\":\"".TOKEN_CHECK_FAILED."\", \"error_msg\": \"权限认证失败！\"}";
}
?>