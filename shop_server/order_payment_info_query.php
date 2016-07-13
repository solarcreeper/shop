<?php
require_once("./function/settings.php");
require_once("./function/check.php");
$token = clean_input($_GET['TOKEN']);
$username = clean_input($_GET['USERNAME']);
$send_status = clean_input($_GET['SEND_STATUS']);
$check_result = check_token($username, $token);
// $check_result = 0;
// $send_status = "";
// $username = "yehongjiang";
// echo $username.":".$check_result;
if($check_result != ACCESS_DENAIL){
	//更新token时间
	update_token($username, $token);
	
	// DB table to use
	$table = 'order_payment_info';

	// Table's primary key
	$primaryKey = 'order_payment_info_id';
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(	
		array( 'db' => 'order_payment_info_id', 	'dt' => 'INDEX' ),
		array( 'db' => 'customs_code', 				'dt' => 'CUSTOMS_CODE' ),
		array( 'db' => 'biz_type_code', 			'dt' => 'BIZ_TYPE_CODE' ),
		array( 'db' => 'original_order_no', 		'dt' => 'ORIGINAL_ORDER_NO' ),
		array( 'db' => 'eshop_ent_code',  			'dt' => 'ESHOP_ENT_CODE' ),
		array( 'db' => 'eshop_ent_name',   			'dt' => 'ESHOP_ENT_NAME' ),
		array( 'db' => 'desc_arri_country_code',   	'dt' => 'DESC_ARRI_COUNTRY_CODE' ),
		array( 'db' => 'ship_tool_code',   			'dt' => 'SHIP_TOOL_CODE' ),
		array( 'db' => 'receiver_id_no',   			'dt' => 'RECEIVER_ID_NO' ),
		array( 'db' => 'receiver_name',   			'dt' => 'RECEIVER_NAME' ),
		array( 'db' => 'receiver_address',   		'dt' => 'RECEIVER_ADDRESS' ),
		array( 'db' => 'receiver_tel',   			'dt' => 'RECEIVER_TEL' ),
		array( 'db' => 'goods_fee',   				'dt' => 'GOODS_FEE' ),
		array( 'db' => 'tax_fee',  			 		'dt' => 'TAX_FEE' ),
		array( 'db' => 'sortline_id',   			'dt' => 'SORTLINE_ID' ),
		array( 'db' => 'transport_fee',   			'dt' => 'TRANSPORT_FEE' ),
		array( 'db' => 'order_status_code',   		'dt' => 'ORDER_STATUS_CODE' ),
		array( 'db' => 'order_op_date',   			'dt' => 'ORDER_OP_DATE' ),
		array( 'db' => 'order_memo',   				'dt' => 'ORDER_MEMO' ),
		array( 'db' => 'bar_code',   				'dt' => 'BAR_CODE' ),
		array( 'db' => 'payment_id_no',   			'dt' => 'PAYMENT_ID_NO' ),
		array( 'db' => 'payment_name',   			'dt' => 'PAYMENT_NAME' ),
		array( 'db' => 'payment_tel',   			'dt' => 'PAYMENT_TEL' ),
		array( 'db' => 'payment_ent_code',   		'dt' => 'PAYMENT_ENT_CODE' ),
		array( 'db' => 'payment_ent_name',   		'dt' => 'PAYMENT_ENT_NAME' ),
		array( 'db' => 'payment_no',   				'dt' => 'PAYMENT_NO' ),
		array( 'db' => 'pay_amount',   				'dt' => 'PAY_AMOUNT' ),
		array( 'db' => 'pay_memo',   				'dt' => 'PAY_MEMO' ),
		array( 'db' => 'payment_status_code',   	'dt' => 'PAYMENT_STATUS_CODE' ),
		array( 'db' => 'payment_op_date',   		'dt' => 'PAYMENT_OP_DATE' ),
		array( 'db' => 'payment_memo',   			'dt' => 'PAYMENT_MEMO' ),
		array( 'db' => 'xiyong_bill_type',   		'dt' => 'XIYONG_BILL_TYPE' ),
		array( 'db' => 'xiyong_acount_no',   		'dt' => 'XIYONG_ACOUNT_NO' ),
		array( 'db' => 'xiyong_cust_no',   			'dt' => 'XIYONG_CUST_NO' ),
		array( 'db' => 'xiyong_stock_in_no',   		'dt' => 'XIYONG_STOCK_IN_NO' ),
		array( 'db' => 'xiyong_stock_out_no',   	'dt' => 'XIYONG_STOCK_OUT_NO' ),
		array( 'db' => 'xiyong_biller_no',   		'dt' => 'XIYONG_BILLER_NO' ),
		array( 'db' => 'xiyong_checker_no',   		'dt' => 'XIYONG_CHECKER_NO' ),
		array( 'db' => 'xiyong_bill_date',   		'dt' => 'XIYONG_BILL_DATE' ),
		array( 'db' => 'xiyong_remark',   			'dt' => 'XIYONG_REMARK' ),
		array( 'db' => 'xiyong_discharge_place',   	'dt' => 'XIYONG_DISCHARGE_PLACE' ),
		array( 'db' => 'xiyong_deliver_place',   	'dt' => 'XIYONG_DELIVER_PLACE' ),
		array( 'db' => 'xiyong_province',   		'dt' => 'XIYONG_PROVINCE' ),
		array( 'db' => 'xiyong_province_code',   	'dt' => 'XIYONG_PROVINCE_CODE' ),
		array( 'db' => 'xiyong_city',   			'dt' => 'XIYONG_CITY' ),
		array( 'db' => 'xiyong_city_code',   		'dt' => 'XIYONG_CITY_CODE' ),
		array( 'db' => 'xiyong_area',   			'dt' => 'XIYONG_AREA' ),
		array( 'db' => 'xiyong_area_code',   		'dt' => 'XIYONG_AREA_CODE' ),
		array( 'db' => 'xiyong_zip',   				'dt' => 'XIYONG_ZIP' ),
		array( 'db' => 'xiyong_type',   			'dt' => 'XIYONG_TYPE' ),
		array( 'db' => 'xiyong_bjflag',   			'dt' => 'XIYONG_BJFLAG' ),
		array( 'db' => 'xiyong_bjamt',   			'dt' => 'XIYONG_BJAMT' ),
		array( 'db' => 'send_status',   			'dt' => 'SEND_STATUS' ),
	);
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP
	 * server-side, there is no need to edit below this line.
	 */
	require( './function/ssp.class.php' );
	if($check_result == ACCESS_ADMIN){
		if($send_status == ""){
		echo json_encode(SSP::simple( $_GET, $table, $primaryKey, $columns ));
		}else{
			$index = "send_status = ".$send_status;
			echo json_encode(SSP::search_index( $_GET, $table, $primaryKey, $columns, null, $index));
		}
	}else{
		if($send_status == ""){
		$index = "owner = '".$username."'";
		echo json_encode(SSP::search_index( $_GET, $table, $primaryKey, $columns, null, $index));
		}else{
			$index = "owner = '".$username."'"."and send_status = ".$send_status;
			echo json_encode(SSP::search_index( $_GET, $table, $primaryKey, $columns, null, $index));
		}
	}
}
else{
	echo "{\"draw\":0,\"recordsTotal\":0,\"recordsFiltered\":0,\"data\":[], \"error_code\":\"".TOKEN_CHECK_FAILED."\", \"error_msg\": \"权限认证失败！\"}";
}

?>