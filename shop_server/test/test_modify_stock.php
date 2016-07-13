<?php
require_once("./function/send.php");

$data['SKU'] = "52";
$data['TOTAL_STOCK'] = "10";
$data['AVAILBLE_STOCK'] = "10";
$data['USERNAME'] = "yehongjiang";
$data['ORIGINAL_ORDER_NO'] = "130935133388722181";
$data['TOKEN'] = "de374e1cb6fe2f68a5f94e904e05f4cd";
$url = "http://127.0.0.1:8080/shop_src/shop_server/modify_stock.php";
echo send_post($url, $data);
?>