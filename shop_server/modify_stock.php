<?php
require_once("./function/settings.php");
require_once("./function/mysql.php");
require_once("./function/send.php");
require_once("./function/check.php");
$token = clean_input($_GET['TOKEN']);
$username = clean_input($_GET['USERNAME']);
$sku = clean_input($_GET['SKU']);
$total_stock = clean_input($_GET['TOTAL_STOCK']);
$availble_stock = clean_input($_GET['AVAILABLE_STOCK']);
$response = array();
$check_result = check_token($username, $token);
//testdata
// $check_result = ACCESS_ADMIN;
// $original_order_no = "1";

if( $check_result == ACCESS_ADMIN){
	//更新token时间
	update_token($username, $token);

	$conn = mysql_open();
	$update_stock_sql = "update stock set total_stock = $total_stock, availble_stock = $availble_stock where sku = '$sku'";
	// echo $update_stock_sql;
	$update_stock_query = mysqli_query($conn, $update_stock_sql);
	if($update_stock_query){
		$response['error_code'] = SUCCESS;
		$response['error_msg'] = "成功！";
	}else{
		$response['error_code'] = FAILED;
		$response['error_msg'] = "库存更新失败！";
	}
	mysqli_close($conn);
}else{
	$response['error_code'] = TOKEN_CHECK_FAILED;
	$response['error_msg'] = "权限认证失败！";
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>