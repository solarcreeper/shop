<?php
require_once("./function/send.php");

$data = array();
$data['ORDER_NO'] = "130935133388722178";
$data['ORIGINAL_ORDER_NO'] = "130935133388722178";
$data['BILL_INFO_NO'] = "130935133388722178";
$data['ESHOP_ENT_CODE'] = "50122604E2";
$data['ESHOP_ENT_NAME'] = "重庆诺森比亚进出口贸易公司";
$data['LOGISTICS_ENT_CODE'] = "50122604E2";
$data['LOGISTICS_ENT_NAME'] = "重庆诺森比亚进出口贸易公司";
$data['RECEIVE_STATUS_CODE'] = "13";
$data['RECEIVE_DATE'] = date("Y-m-d H:s:i");
$data['MEMO'] = "签收";
$data['username'] = "yehongjiang";
$data['token'] = "de374e1cb6fe21f68a5f94e904e05f4cd";

$url = "http://127.0.0.1:8080/shop_src/shop_server/order_receive_info.php";
$result = send_post($url, $data);
echo $result;
?>