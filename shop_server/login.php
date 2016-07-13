<?php
require_once("function/mysql.php");
require_once("function/settings.php");
if(!is_null($_POST['username']) && !is_null($_POST['password'])){
	$response = array();
	$username = $_POST['username'];
	$password = $_POST['password'];
	$conn = mysql_open();
	$sql = "select * from user where username = '$username' and password='$password'";
	$result = mysqli_query($conn, $sql);
   	$row = mysqli_num_rows($result);
   	if($row > 0){
		$token = md5(uniqid());
		$sql = "insert into token(username, content, update_time) values('$username', '$token', NOW())";
		$query = mysqli_query($conn, $sql);
		$user_info_sql = "select is_admin, discount from user where username = '$username'";
		$user_info_query = mysqli_query($conn, $user_info_sql);
		$user_info = mysqli_fetch_object($user_info_query);
		if($query && $user_info_query){
			$response['error_code'] = SUCCESS;
			$response['error_msg'] = "成功！";
			$response['USERNAME'] = $username;
			$response['DISCOUNT'] = $user_info->discount;
			$response['IS_ADMIN'] = $user_info->is_admin;
			$response['TOKEN'] = $token;
			$response['status'] = 1;
		}
	    else{
			$response['error_code'] = TOKEN_CREATE_FAILED;
			$response['error_msg'] = "权限认证失败！";
			$response['status'] = 0;
		}
	}else{
		$response['error_code'] = FAILED;
		$response['error_msg'] = "登陆失败！";
	}
	mysqli_close($conn);
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
?>