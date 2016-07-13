<?php
require_once("./function/mysql.php");
require_once("./function/settings.php");
require_once("./function/check.php");
$response = array();
$check_result = check_token($username, $token);
//test data
$check_result = ACCESS_ADMIN;
if($check_result == ACCESS_ADMIN){
	//更新token时间
	update_token($username, $token);
	
	if(!is_null($_POST['username']) && !is_null($_POST['password'])){
	$username = clean_input($_POST['username']);
	$password = clean_input($_POST['password']);

	$conn = mysql_open();
	$sql = "select username from user where username = '$username'";
	$query = mysqli_query($conn, $sql);
	$result = mysqli_fetch_object($query)->username;
	if($username == $result){
		$response['error_code'] = USERNAME_EXIST;
		$response["error_msg"] = "USERNAME_EXIST";
	}else{
		$sql = "insert into user(username, password) values('$username', '$password')";
		$query = mysqli_query($conn, $sql);
		if($query){
			$response['error_code'] = SUCCESS;
			$response['error_msg'] = "成功！";
		}else{
			$response["error_code"] = REGISTER_FAILED;
			$response["error_msg"] = "注册失败！";
		}
	}
	mysqli_close($conn);
	}else{
		$response["error_code"] = REGISTER_FAILED;
		$response["error_msg"] = "注册失败！";
	}
}else{
	$response['error_code'] = TOKEN_CHECK_FAILED;
	$response['error_msg'] = "权限认证失败！";
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>