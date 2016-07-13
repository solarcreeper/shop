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
	$key = XIYONG_KEY;
	$secret = XIYONG_SECRET;
	$tzh = XIYONGTZH;
	$result = get_purchase($key, $secret, $tzh, $f_erp_bill_no, "1");
	$response = $result;
}else{
	$response['error_code'] = TOKEN_CHECK_FAILED;
	$response['error_msg'] = "用户认证失败！";
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>