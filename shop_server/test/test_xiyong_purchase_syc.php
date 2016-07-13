<?php
require_once("./function/send.php");
$data['USERNAME'] = "yehongjiang";
$data['F_ERP_BILL_NO'] = "A0000051571";

$data['TOKEN'] = "de374e1cb6fe2f68a5f94e904e05f4cd";
$url = "http://127.0.0.1:8080/shop_src/shop_server/xiyong_purchase_sync.php";
echo send_post($url, $data);
?>