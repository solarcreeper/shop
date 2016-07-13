<?php
require_once("./function/settings.php");
require_once("./function/check.php");
$token = clean_input($_GET['TOKEN']);
$username = clean_input($_GET['USERNAME']);
$check_result = check_token($username, $token);
//test data
// $check_result = ACCESS_ADMIN;
if($check_result == ACCESS_ADMIN){
	update_token($username, $token);
	// DB table to use
	$table = 'ciq_sku_info';

	// Table's primary key
	$primaryKey = 'ciq_sku_info_id';
	// Array of database columns which should be read and sent back to DataTables.
	// The `db` parameter represents the column name in the database, while the `dt`
	// parameter represents the DataTables column identifier. In this case simple
	// indexes
	$columns = array(
		array( 'db' => 'ciq_sku_info_id', 			'dt' => 'INDEX' ),
		array( 'db' => 'eshop_ent_code', 			'dt' => 'ESHOP_ENT_CODE' ),
		array( 'db' => 'eshop_ent_name', 			'dt' => 'ESHOP_ENT_NAME' ),
		array( 'db' => 'external_no', 				'dt' => 'EXTERNAL_NO' ),
		array( 'db' => 'sku',  						'dt' => 'SKU' ),
		array( 'db' => 'goods_name',   				'dt' => 'GOODS_NAME' ),
		array( 'db' => 'goods_spec',   				'dt' => 'GOODS_SPEC' ),
		array( 'db' => 'declare_unit',   			'dt' => 'DECLARE_UNIT' ),
		array( 'db' => 'post_tax_no',   			'dt' => 'POST_TAX_NO' ),
		array( 'db' => 'legal_unit',   				'dt' => 'LEGAL_UNIT' ),
		array( 'db' => 'conv_legal_unit_num',   	'dt' => 'CONV_LEGAL_UNIT_NUM' ),
		array( 'db' => 'hs_code',   				'dt' => 'HS_CODE' ),
		array( 'db' => 'in_area_unit',   			'dt' => 'IN_AREA_UNIT' ),
		array( 'db' => 'conv_in_area_unit_num',   	'dt' => 'CONV_IN_AREA_UNIT_NUM' ),
		array( 'db' => 'is_experiment_goods',   	'dt' => 'IS_EXPERIMENT_GOODS' ),
		array( 'db' => 'origin_country_code',   	'dt' => 'ORIGIN_COUNTRY_CODE' ),
		array( 'db' => 'is_cnca_por',   			'dt' => 'IS_CNCA_POR' ),
		array( 'db' => 'cnca_por_doc',   			'dt' => 'CNCA_POR_DOC' ),
		array( 'db' => 'origin_place_cert',   		'dt' => 'ORIGIN_PLACE_CERT' ),
		array( 'db' => 'test_report',   			'dt' => 'TEST_REPORT' ),
		array( 'db' => 'legal_ticket',   			'dt' => 'LEGAL_TICKET' ),
		array( 'db' => 'mark_exchange',   			'dt' => 'MARK_EXCHANGE' ),
		array( 'db' => 'check_org_code',   			'dt' => 'CHECK_ORG_CODE' ),
		array( 'db' => 'supplier_name',   			'dt' => 'SUPPLIER_NAME' ),
		array( 'db' => 'producer_name',   			'dt' => 'PRODUCER_NAME' ),
		array( 'db' => 'is_cnca_por_doc',   		'dt' => 'IS_CNCA_POR_DOC'),
		array( 'db' => 'is_origin_place_cert',   	'dt' => 'IS_ORIGIN_PLACE_CERT',   ),
		array( 'db' => 'is_test_peport',   			'dt' => 'IS_TEST_PEPORT' ),
		array( 'db' => 'is_legal_ticket',   		'dt' => 'IS_LEGAL_TICKET' ),
		array( 'db' => 'is_mark_exchange',   		'dt' => 'IS_MARK_EXCHANGE' ),
		array( 'db' => 'status_code',   			'dt' => 'STATUS_CODE' ),
		array( 'db' => 'op_date',   				'dt' => 'OP_DATE' ),
		array( 'db' => 'memo',   					'dt' => 'MEMO' ),
		array( 'db' => 'price',   					'dt' => 'PRICE' ),
		array( 'db' => 'picture',   				'dt' => 'PICTURE' ),
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