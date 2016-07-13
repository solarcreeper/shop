<?php
require_once("./function/send.php");

	$sku = "20121212";		
	$goods_name = "hahaha";	
	$goods_spec = "hahaha";
	$price = "111";
	$picture = "";
	$data['SKU'] = $sku;
	$data['GOODS_NAME'] = $goods_name;
	$data['GOODS_SPEC'] = $goods_spec;
	$data['PRICE'] = $price;
	$data['PICTURE'] = $picture;

$data['USERNAME'] = "TESTER";
$data['TOKEN'] = "qwertyuiop1234567890";
$url = "http://127.0.0.1:8080/shop_src/shop_server/ordinary_goods_info.php";
$result = send_post($url, $data);
echo $result;
?>