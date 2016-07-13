<?php
require_once("../function/mysql.php");
require_once("../function/settings.php");
require_once("../function/get_purchase.php");
$key = XIYONG_KEY;
$secret = XIYONG_SECRET;
$tzh = XIYONGTZH;
$conn = mysql_open();
$get_purchase_sql = "select f_erp_bill_no from xiyong_purchase where flag = -1";
$get_purchase_query = mysqli_query($conn, $get_purchase_sql);
while($result = mysqli_fetch_object($get_purchase_query)){
	$f_erp_bill_no = $result->f_erp_bill_no;
	$bill_no = $tzh.".".$f_erp_bill_no;
	get_purchase($key, $secret, $tzh, $f_erp_bill_no);
}
mysqli_close($conn);
?>