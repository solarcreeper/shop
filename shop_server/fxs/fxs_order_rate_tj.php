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
				$statistic_type = $_POST["statistic_type"];
				$start = $_POST['start'];
				$end = $_POST['end'];
				$limit = $_POST["num"];
				$order_by = $_POST["order_by"];
				switch ($statistic_type) {
					case '0':
						$response = get_owner_and_fee_statistic($start, $end, $limit, $order_by);
						break;
					case '1':
						$response = get_owner_and_orders_statistic($start, $end, $limit, $order_by);
						break;
				}
			break;
	}
	
	mysqli_close($link);
	echo json_encode($response);
?>