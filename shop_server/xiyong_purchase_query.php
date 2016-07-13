<?php
require_once("./function/settings.php");
require_once("./function/mysql.php");
require_once("./function/send.php");
require_once("./function/check.php");
$token = clean_input($_GET['TOKEN']);
$username = clean_input($_GET['USERNAME']);
$check_result = check_token($username, $token);
//testdata
// $check_result = ACCESS_ADMIN;
if($check_result == ACCESS_ADMIN){
	update_token($username, $token);
	// DB table to use
	$table = 'xiyong_purchase';

	// Table's primary key
	$primaryKey = 'purchase_id';
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
		array( 'db' => 'purchase_id', 			'dt' => 'INDEX' ),
		array( 'db' => 'f_account_no', 			'dt' => 'F_ACCOUNT_NO' ),
		array( 'db' => 'f_erp_order_bill_no', 	'dt' => 'F_ERP_ORDER_BILL_NO' ),
		array( 'db' => 'f_erp_bill_no', 		'dt' => 'F_ERP_BILL_NO' ),
		array( 'db' => 'f_cust_no',  			'dt' => 'F_CUST_NO' ),
		array( 'db' => 'f_biller_no',   		'dt' => 'F_BILLER_NO' ),
		array( 'db' => 'f_biller_p_no',   		'dt' => 'F_BILLER_P_NO' ),
		array( 'db' => 'f_checker_no',   		'dt' => 'F_CHECKER_NO' ),
		array( 'db' => 'f_bill_date',   		'dt' => 'F_BILL_DATE' ),
		array( 'db' => 'f_remark',   			'dt' => 'F_REMARK' ),
		array( 'db' => 'custname',   			'dt' => 'CUSTNAME' ),
		array( 'db' => 'linkman',   			'dt' => 'LINKMAN' ),
		array( 'db' => 'tel',   				'dt' => 'TEL' ),
		array( 'db' => 'deliver_no',   			'dt' => 'DELIVER_NO' ),
		array( 'db' => 'deliver_name',   		'dt' => 'DELIVER_NAME' ),
		array( 'db' => 'deliver_time',   		'dt' => 'DELIVER_TIME' ),
		array( 'db' => 'arrive_time',   		'dt' => 'ARRIVE_TIME' ),
		array( 'db' => 'qty',   				'dt' => 'QTY' ),
		array( 'db' => 'unit',   				'dt' => 'UNIT' ),
		array( 'db' => 'flag',   				'dt' => 'FLAG' ),
	);
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP
	 * server-side, there is no need to edit below this line.
	 */
	require( './function/ssp.class.php' );
	//echo $_GET;
	echo json_encode(
		SSP::simple( $_GET, $table, $primaryKey, $columns )
	);
}else{
	echo "{\"draw\":0,\"recordsTotal\":0,\"recordsFiltered\":0,\"data\":[], \"error_code\":\"".TOKEN_CHECK_FAILED."\", \"error_msg\": \"权限认证失败！\"}";
}
?>