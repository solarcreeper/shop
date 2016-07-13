<?php
require_once("../function/mysql.php");
require_once("../function/settings.php");
require_once("../function/get_bill.php");
require_once("../function/order_receive_info.php");
$key = XIYONG_KEY;
$secret = XIYONG_SECRET;
$tzh = XIYONGTZH;
$conn = mysql_open();
$get_bill_sql = "select original_order_no from order_payment_info where xiyong_deliver_place = '暂无数据'";
$get_bill_query = mysqli_query($conn, $get_bill_sql);
while($result = mysqli_fetch_object($get_bill_query)){
	$original_order_no = $result->original_order_no;
	$bill_no = $tzh.".".$original_order_no;
	$ret = get_bill($key, $secret, $bill_no);
	$delivery_no = $ret['delivery_no'];
	if($delivery_no != ""){
		$update_deliver_no_sql = "update order_payment_info set xiyong_deliver_place = '$delivery_no' where original_order_no = '$original_order_no'";
		$update_deliver_no_query = mysqli_query($conn, $update_deliver_no_sql);
		// 回填快递单号到海关系统
		$receve_time = $ret['receive_time'];
		$memo = $ret['state'];
		$receive_result = order_receive_info($original_order_no, $receve_time, $memo, $delivery_no);
		// var_dump($receive_result);
		//如果需要可以在这里写日志文件，输入结果
	}
}
mysqli_close($conn);
?>