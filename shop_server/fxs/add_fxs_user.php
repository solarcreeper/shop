<?php
	require_once("./../function/mysql.php");
	require_once("common.php");
	
	if(isset($_POST['func_type'])){
		$func_type = $_POST['func_type'];
	}else{
		$func_type = $_GET['func_type'];
	}
	$response = array();
	switch ($func_type) {
		case "add":
			$username = $_POST['username'];
			$password = $_POST['password'];
			$real_name = $_POST['real_name'];
			$email = $_POST['email'];
			$mobile = $_POST['mobile'];
			$address = $_POST['address'];
			$discount = number_format($_POST['discount'], 2);
			$discount = $discount / 100;
			$goods_list = $_POST['goods_list'];
			
			$link = mysql_open();
			
			$sql = "insert into user(username, password, real_name, email, mobile, address, discount, is_admin) 
			values('$username', '$password', '$real_name', '$email', '$mobile', '$address', $discount, 0);";
			$user_result = mysqli_query($link, $sql);
			
			if($user_result == true){
				for ($i=0; $i < count($goods_list); $i++){
					$goods_info = get_goods_info_by_sku($goods_list[$i]);
					$price = $goods_info['price'] * $discount;
					$query = "insert into user_product(username, sku_id, price) values('".$username."', '".$goods_list[$i]."', $price);";
					mysqli_query($link, $query);
				}
				if(mysqli_errno($link) == 0){
					$response['status'] = "success";
				}else{
					$response['status'] = "failure";
				}
			}else{
				$response['status'] = "fail to insert user";
			}
			mysqli_close($link);
			
			break;
		case "find_user":
			$username = $_POST['username'];
			$response['finded'] = find_user($username);
			break;
		case "goods_list":
			$response["data"] = get_goods_list();
			break;
		default:
			
			break;
	}
	echo json_encode($response);
	
?>