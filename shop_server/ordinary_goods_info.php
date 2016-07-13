<?php
require_once("./function/settings.php");
require_once("./function/mysql.php");
require_once("./function/send.php");
require_once("./function/check.php");
$token = clean_input($_POST['TOKEN']);
$username = clean_input($_POST['USERNAME']);
$total_stock = clean_input($_POST['TOTAL_STOCK']);
$is_import = clean_input($_GET['IS_IMPORT']);
$response = array();
$check_result = check_token($username, $token);
//test data
// echo $token."</br>".$username."</br>";

// $check_result = ACCESS_ADMIN;

if($check_result != ACCESS_DENAIL){
	//更新token时间
	update_token($username, $token);

	$sku = clean_input($_POST['SKU']);
	$goods_name = clean_input($_POST['GOODS_NAME']);
	$goods_spec = clean_input($_POST['GOODS_SPEC']);
	$price = clean_input($_POST['PRICE']);
	$picture = clean_input($_POST['PICTURE']);
	if($picture == "") $picture = "images/default_thumb.png";

	if($sku != ""){
		$conn = mysql_open();
		//事务开始
		mysqli_query($conn, "BEGIN");
		$sku_del_sql = "delete from common_sku_info where sku = '$sku'";
		$sku_del_query = mysqli_query($conn, $sku_del_sql);
		$insert_sku_sql = "insert into common_sku_info(sku, goods_name, goods_spec, price, picture)
							values('$sku', '$goods_name', '$goods_spec', $price, '$picture')";
		$insert_sku_query = mysqli_query($conn, $insert_sku_sql);
		$del_user_product_sql = "delete from user_product where sku_id = '$sku'";
		$del_user_product_query = mysqli_query($conn, $del_user_product_sql);
		$insert_user_product_sql = "insert into user_product(username, sku_id) values('$username', '$sku')";
		$insert_user_product_query = mysqli_query($conn, $insert_user_product_sql);
		$stock_del_sql = "delete from stock where sku = '$sku'";
		$stock_del_query = mysqli_query($conn, $stock_del_sql);
		$stock_insert_sql = "insert into stock(sku, total_stock, availble_stock, blocked_stock) 
							 values('$sku', $total_stock, $total_stock, 0)";
		$stock_insert_query = mysqli_query($conn, $stock_insert_sql);

		$del_import_query = true;
		if($is_import == "1"){
			$del_import_sql = "delete from t_item_data where sku = '$sku'";
			$del_import_query = mysqli_query($conn, $del_import_sql);
		}
		if($insert_sku_query && $insert_user_product_query && $stock_insert_query && $del_import_query){
			//事务提交
			mysqli_query($conn, "COMMIT");
			$response['error_code'] = SUCCESS;
			$response['error_msg'] = "成功！";
		}else{
			//事务回滚
			mysqli_query($conn, "ROLLBACK");
			if(!$insert_sku_query){
				$response['error_code'] = FAILED;
				$response['error_msg'] = "添加商品失败！";
			}
			else if(!$insert_user_product_query){
				$response['error_code'] = FAILED;
				$response['error_msg'] = "添加商品失败！";
			}
			else if(!$del_import_query){
				$response['error_code'] = FAILED;
				$response['error_msg'] = "删除缓存数据失败！";
			}else{
				$response['error_code'] = FAILED;
				$response['error_msg'] = "库存初始化失败！";
			}
		}
		//事务结束
		mysqli_query($conn, "END");
		mysqli_close($conn);
	}else{
			$response['error_code'] = FAILED;
			$response['error_msg'] = "商品SKU不能为空！";
	}
}else{
	$response['error_code'] = TOKEN_CHECK_FAILED;
	$response['error_msg'] = "权限认证失败！";
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>