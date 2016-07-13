<?php
require_once("./function/settings.php");
require_once("./function/mysql.php");
require_once("./function/check.php");
require_once("./function/get_purchase.php");
$token = clean_input($_GET['TOKEN']);
$username = clean_input($_GET['USERNAME']);
$f_erp_bill_no = clean_input($_GET['F_ERP_BILL_NO']);
$response = array();
$check_result = check_token($username, $token);
//testdata
// $check_result = ACCESS_ADMIN;
if($check_result == ACCESS_ADMIN){
	update_token($username, $token);
	//检查是否能点击
	$conn = mysql_open();
	$check_flag_sql = "select flag from xiyong_purchase where f_erp_bill_no = '$f_erp_bill_no'";
	$check_flag_query = mysqli_query($conn, $check_flag_sql);
	$check_result = mysqli_fetch_object($check_flag_query)->flag;
	mysqli_close($conn);
	if($check_result == "0"){
		$key = XIYONG_KEY;
		$secret = XIYONG_SECRET;
		$tzh = XIYONGTZH;
		$result = get_purchase($key, $secret, $tzh, $f_erp_bill_no, "1");
		$response = $result;
	}	
	if($check_result == "-1"){
		$response['error_code'] = FAILED;
		$response['error_msg'] = "请等待入库再更新！";
	}
	if($check_result == "1"){
		$response['error_code'] = FAILED;
		$response['error_msg'] = "库存已更新！";
	}
}else{
	$response['error_code'] = TOKEN_CHECK_FAILED;
	$response['error_msg'] = "用户认证失败！";
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>