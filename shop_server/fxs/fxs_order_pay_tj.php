<?php
	$func_type = $_POST['func_type'];
	require_once("../function/mysql.php");
	require_once("common.php");
	$response = array();
	$data = array();
	$row = array();
	$link = mysql_open();
	
	switch ($func_type) {
		case 'get_data':
				$x_count = 13;
			
				$username = $_POST['username'];
				$interval_type = $_POST['interval_type'];
				
				for ($i=0; $i < count($username); $i++) { 
					$row["name"] = $username[$i];
					switch ($_POST['statistic_type']) {
						case '0':
							$row["data"] = get_total_fee_statistic_data($username[$i], $interval_type, $x_count);
							break;
						case '1':
							$row["data"] = get_total_orders_statistic_data($username[$i], $interval_type, $x_count);
							break;
					}
					$data[] = $row;
				}
				$response['status'] = "success";
				$response['data'] = $data;
				$response['x_axis'] = get_x_data($interval_type, $x_count);
			break;
		case "get_username":
			$username = $_POST['value'];
			$response["data"] = get_username($username);
			break;
		case "find_user":
			$username = $_POST['username'];
			$find = find_distributor($username);
			if($find){
				$response["status"] = "find";
			}
		default:
			
			break;
	}
	
	mysqli_close($link);
	echo json_encode($response);
	
?>