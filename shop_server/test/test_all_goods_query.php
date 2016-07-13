<?php
require_once("./function/send.php");

$data['USERNAME'] = "TESTER";
$data['TOKEN'] = "qwertyuiop1234567890";
$url = "http://127.0.0.1:8080/shop_src/shop_server/all_goods_info_query.php";
$result = send_post($url, $data);
echo $result;
?>