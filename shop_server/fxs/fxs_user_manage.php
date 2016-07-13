<?php
	require_once("../function/mysql.php");
	require_once("common.php");
	$link = mysql_open();
	mysqli_query($link, "set names utf8");
	if(isset($_POST['func_type'])){
		$func_type = $_POST["func_type"];
	}else{
		$func_type = $_GET["func_type"];
	}
	$response = array();
	switch ($func_type) {
		case 'get_info':
			$data = array();
			$sql = "select user_id, username, real_name, email, mobile, address, discount from user where is_admin = 0";
			$result = mysqli_query($link, $sql);
			while($row_rst = mysqli_fetch_assoc($result)){
				$row = array();
				$row[] = $row_rst["user_id"];
				$row[] = $row_rst['username'];
				$row[] = $row_rst['real_name'];
				$row[] = $row_rst['email'];
				$row[] = $row_rst['mobile'];
				$row[] = $row_rst['address'];
				$row[] = $row_rst['discount'];
				$row[] = "<span class='get_goods_list'>详情</span>";
				$row[] = "<input type='button' value='修改'/> <input type='button' value='删除'/>";
				$data[] = $row;
			}
			$response["data"] = $data;
			break;
		case "change":
			$username = $_POST['col1'];
			$user_id = $_POST['col0'];
			$query = "select * from user where username='$username' and user_id!=$user_id";
			$result = mysqli_query($link, $query);
			if(mysqli_fetch_assoc($result)){
				$response["status"] = "find";
			}else{
				$real_name = $_POST['col2'];
				$email = $_POST['col3'];
				$mobile = $_POST['col4'];
				$address = $_POST['col5'];
				$discount = $_POST['col6'];
				
				$query = "update user set username='$username', real_name='$real_name', email='$email', mobile='$mobile', address='$address', discount=$discount where user_id=$user_id;";
				$result = mysqli_query($link, $query);
				
				if($result){
					$response['status'] = "success!";
				}else{
					$response['status'] = "fail!";
				}
			}
			break;
		case "delete":
			$username = $_POST['username'];
			$query = "delete from user where username='$username'";
			$result = mysqli_query($link, $query);
			if($result){
				$response['status'] = "success!";
			}else{
				$response['status'] = "fail!";
			}
			break;
		case "cancel":
			$user_id = $_POST['user_id'];
			$link = mysql_open();
			$query = "select * from user where user_id = $user_id";
			break;
		case "curr_goods_list":
			$curr_username = $_GET['curr_username'];
			$response["data"] = get_curr_goods_list($curr_username);
			break;
		case "delete_user_pro":
			$username = $_POST['username'];
			$sku = $_POST['sku'];
			$query = "delete from user_product where username='$username' and sku_id='$sku'";
			$result = mysqli_query($link, $query);
			if($result){
				$response['status'] = "success!";
			}else{
				$response['status'] = "fail!";
			}
			break;
		case "add_goods":
			$goods_name = $_POST['value'];
			$response["data"] = get_goods_by_goods_name($goods_name);
			break;
		case "btn_add_goods":
			$username = $_POST['username'];
			$sku_id = $_POST['sku_id'];
			$query = "insert into user_product(username, sku_id) values('$username', '$sku_id');";
			if(mysqli_query($link, $query)){
				$response["status"] = "success";
			}else{
				$response["status"] = "fail to insert";
			}
			break;
		case "change_price";
			$goods_price = $_POST["goods_price"];
			$sku = $_POST["sku"];
			$username = $_POST["username"];
			$success = change_goods_price($sku, $username, $goods_price);
			if($success){
				$response["status"] = "success";
			}else{
				$response["status"] = "fail";
			}
			break;
		case "get_goods_price":
			$username = $_POST['username'];
			$sku_id = $_POST['sku'];
			$response["price"] = get_user_pro_price($username, $sku_id);
			break;
		default:
				break;
	}
	mysqli_close($link);
	echo json_encode($response);
?>