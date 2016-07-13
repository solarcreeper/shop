<?php
require_once("./function/send.php");

$data = array();
$data['username'] = "yehongjiang";
$data['password'] = "yehongjiang";

$url = "http://127.0.0.1:8080/shop_src/shop_server/login.php";
$result = send_post($url, $data);
echo $result;
?>