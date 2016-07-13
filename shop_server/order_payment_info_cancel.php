<?php
require_once("./function/settings.php");
require_once("./function/mysql.php");
require_once("./function/send.php");
require_once("./function/check.php");
$token = clean_input($_GET['TOKEN']);
$username = clean_input($_GET['USERNAME']);
$original_order_no = clean_input($_GET['ORIGINAL_ORDER_NO']);
$response = array();
$check_result = check_token($username, $token);
//testdata
// $check_result = ACCESS_ADMIN;
// $original_order_no = "201512130001";

if( $check_result == ACCESS_ADMIN){
	//更新token时间
	update_token($username, $token);

	$conn = mysql_open();
	$cancel_order_sql = "update order_payment_info set send_status = -3 where original_order_no = '$original_order_no'";
	$cancel_order_query = mysqli_query($conn, $cancel_order_sql);
	if($cancel_order_sql){
		$response['error_code'] = SUCCESS;
		$response['error_msg'] = "成功！";
	}else{
		$response['error_code'] = FAILED;
		$response['error_msg'] = "取消失败！";	
	}
	mysqli_close($conn);
}else{
	$response['error_code'] = TOKEN_CHECK_FAILED;
	$response['error_msg'] = "权限认证失败！";
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>