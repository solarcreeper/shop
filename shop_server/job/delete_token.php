<?php
require_once("../function/mysql.php");
$conn = mysql_open();
$sql = "delete from token where date_sub(NOW(), interval 40 minute) > update_time";
$query = mysqli_query($conn, $sql);
mysqli_close($conn);
?>