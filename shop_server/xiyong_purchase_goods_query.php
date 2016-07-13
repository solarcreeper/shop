<?php
require_once("./function/settings.php");
require_once("./function/mysql.php");
require_once("./function/send.php");
require_once("./function/check.php");
$token = clean_input($_GET['TOKEN']);
$username = clean_input($_GET['USERNAME']);
$f_erp_bill_no = clean_input($_GET['F_ERP_BILL_NO']);
$check_result = check_token($username, $token);
//testdata
// $check_result = ACCESS_ADMIN;
if($check_result == ACCESS_ADMIN){
	update_token($username, $token);
	// DB table to use
	$table = 'xiyong_purchase_product';

	// Table's primary key
	$primaryKey = 'product_id';

	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
		array( 'db' => 'product_id', 		'dt' => 'INDEX' ),
		array( 'db' => 'f_icno',   			'dt' => 'F_ICNO' ),
		array( 'db' => 'f_unit',   			'dt' => 'F_UNIT' ),
		array( 'db' => 'f_price',   		'dt' => 'F_PRICE' ),
		array( 'db' => 'f_qty',   			'dt' => 'F_QTY' ),
		array( 'db' => 'f_amount',   		'dt' => 'F_AMOUNT' ),
		array( 'db' => 'f_pro_date',   		'dt' => 'F_PRO_DATE' ),
		array( 'db' => 'f_out_date',   		'dt' => 'F_OUT_DATE' ),
		array( 'db' => 'f_block_no',   		'dt' => 'F_BLOCK_NO' ),
		array( 'db' => 'f_remark_dtail',   	'dt' => 'F_REMARK_DTAIL' ),
	);
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP
	 * server-side, there is no need to edit below this line.
	 */
	require( './function/ssp.class.php' );
	//echo $_GET;
	if($f_erp_bill_no != ""){
		$index = "f_erp_bill_no = '".$f_erp_bill_no."'";
		echo json_encode(SSP::search_index( $_GET, $table, $primaryKey, $columns, null, $index));
	}else{
		echo "{\"draw\":0,\"recordsTotal\":0,\"recordsFiltered\":0,\"data\":[]}";
	}
}else{
	echo "{\"draw\":0,\"recordsTotal\":0,\"recordsFiltered\":0,\"data\":[], \"error_code\":\"".TOKEN_CHECK_FAILED."\", \"error_msg\": \"权限认证失败！\"}";
}
?>