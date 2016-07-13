<?php
require_once("./function/settings.php");
require_once("./function/mysql.php");
require_once("./function/check.php");
$token = clean_input($_GET['TOKEN']);
$username = clean_input($_GET['USERNAME']);
$original_order_no = clean_input($_GET['ORIGINAL_ORDER_NO']);
$response = array();
$check_result = check_token($username, $token);
//test data
// echo $token."</br>".$username."</br>";

// $check_result = ACCESS_ADMIN;
// $username = "yehongjiang";
// $check_result = ACCESS_USER;
// $original_order_no = "130935133388722178";
if($check_result != ACCESS_DENAIL){
	//更新token时间
	update_token($username, $token);


	$conn = mysql_open();
	//事务开始
	mysqli_query($conn, "BEGIN");
	if($check_result == ACCESS_ADMIN){
		$delete_order_goods_sql = "delete from order_goods_info where original_order_no = '$original_order_no'";
		$delete_order_goods_query = mysqli_query($conn, $delete_order_goods_sql);
		$delete_order_sql = "delete from order_payment_info where original_order_no = '$original_order_no'";
		$delete_order_query = mysqli_query($conn, $delete_order_sql);
		if($delete_order_query && $delete_order_goods_query){
			//事务提交
			mysqli_query($conn, "COMMIT");
			$response['error_code'] = SUCCESS;
			$response['error_msg'] = "成功！";
		}else{
			//事务回滚
			mysqli_query($conn, "ROLLBACK");
			if(!$delete_order_query){
				$response['error_code'] = FAILED;
				$response['error_msg'] = "删除订单失败！";
			}else{
				$response['error_code'] = FAILED;
				$response['error_msg'] = "删除订单商品失败！";
			}
			
		}
	}
	else{
		$check_order_sql = "select original_order_no form order_goods_info where original_order_no = '$original_order_no' and owner = '$username'";
		$check_order_query = mysqli_query($conn, $check_order_sql);
		$check_order_result = mysqli_fetch_object($check_order_query)->original_order_no;
		if($check_order_result == $original_order_no){
			$delete_order_goods_sql = "delete from order_goods_info where original_order_no = '$original_order_no'";
			$delete_order_goods_query = mysqli_query($conn, $delete_order_goods_sql);
			$delete_order_sql = "delete from order_payment_info where original_order_no = '$original_order_no'";
			$delete_order_query = mysqli_query($conn, $delete_order_sql);
			if($delete_order_query && $delete_order_goods_query){
				//事务提交
				mysqli_query($conn, "COMMIT");
				$response['error_code'] = SUCCESS;
				$response['error_msg'] = "成功！";
			}else{
				//事务回滚
				mysqli_query($conn, "ROLLBACK");
				if(!$delete_order_query){
					$response['error_code'] = FAILED;
					$response['error_msg'] = "删除订单失败！";
				}else{
					$response['error_code'] = FAILED;
					$response['error_msg'] = "删除订单商品失败！";
				}
			}
		}else{
			$response['error_code'] = FAILED;
			$response['error_msg'] = "用户无删除此订单权限！";
		}
	}
	//事务结束
	mysqli_query($conn, "END");
	mysqli_close($conn);
}else{
	$response['error_code'] = TOKEN_CHECK_FAILED;
	$response['error_msg'] = "权限认证失败！";
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>