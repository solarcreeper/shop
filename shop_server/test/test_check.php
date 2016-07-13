<?php
require_once("./function/send.php");
require_once("../function/check.php");
require_once("../settings.php");

$username = "yehongjiang";
$token = "de374e1cb6fe2f68a5f94e904e05f4cd";
echo check_token($username, $token);
// if(check_token($username, $token) == ACCESS_ALLOW) echo 1;
// else echo 0;
// echo check_token($username, $token);
?>