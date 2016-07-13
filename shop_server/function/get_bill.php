<?php
require_once("../function/settings.php");
require_once("../function/send.php");
/*
 * @params key 		固定值，测试环境为test
 * @params secret 	数字签名密钥
 * @params bill_no 	账套号.订单号
 */
// $key = "test";
// $secret = "impltest";
// $tzh = "999";
// $bill_no = "999.201512110001";
// echo get_bill($key, $secret, $bill_no);

function get_bill($key, $secret, $bill_no){
	$requesttime = date("Y-m-d h:i:s");
	$sign = md5($bill_no.$secret.$requesttime);
	$data['key'] = $key;
	$data['method'] = "PutOrderType";
	$data['json'] = $bill_no;
	$data['requesttime'] = $requesttime;
	$data['sign'] = $sign;
	$url = XIYONG_URL_ADDRESS;
	$result_post = send_post($url, $data);
	// var_dump($result_post);
	$result_post = json_decode($result_post, true);
	$result = $result_post['Result'];
	$err_msg = json_decode(urldecode($result_post['ErrMessage']), true);
	// var_dump($err_msg);
	$msg = array();
	if($result == "0"){
		$delivery_no = $err_msg['Deliveryno'];
		$state = $err_msg['State'];
		$receive_time = $err_msg['Receivetime'];
		$msg['delivery_no'] = $delivery_no;
		$msg['state'] = $state;
		$msg['receive_time'] = $receive_time;
	}else{
		$msg['delivery_no'] = "";
		$msg['state'] = "";
		$msg['receive_time'] = "";
	}
	// var_dump($msg);
	return $msg;
}
?>