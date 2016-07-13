<?php
function mysql_open(){
    $mysql_serverName = "localhost";
    $mysql_userName   = "root";
    $mysql_password   = "00000000";
    $mysql_dbName     = "shop_db";

    //$conn = mysql_connect($mysql_serverName, $mysql_userName, $mysql_password);
    $conn = mysqli_connect($mysql_serverName, $mysql_userName, $mysql_password, $mysql_dbName, 3306);
    mysqli_set_charset($conn, 'utf-8');

    return $conn;
 }
?>