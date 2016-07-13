<?php
require_once("./function/mysql.php");
$conn = mysql_open();
$original_order_no = "1";
$order_detail_sql = "select sku, goods_spec, currency_code, price, qty, goods_fee, tax_fee 
						from order_goods_info where original_order_no = '$original_order_no'";
$order_detail_query = mysqli_query($conn, $order_detail_sql);
while($product = mysqli_fetch_object($order_detail_query)){
	var_dump($product);
}
mysqli_close($conn);
?>