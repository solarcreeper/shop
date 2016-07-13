<?php
require_once("./function/send.php");

$f_account_no 		 = "91";
$f_erp_fromoth 		 = "";
$f_erp_order_bill_no = "";
$f_cust_no 			= "50122604E2"; 
$f_biller_no 		= "韩明魁"; 
$f_biller_p_no 		= "韩明魁"; 
$f_checker_no 		= "韩明魁"; 
$f_bill_date 		= "2015-12-6"; 
$f_remark			= "test"; 
$custmame   		= "重庆诺森比亚进出口贸易公司"; 
$linkman 			= "韩明魁"; 
$tel 				= "18523858712"; 
$deliver_no 		= ""; 
$deliver_name 		= ""; 
$deliver_time 		= ""; 
$arrive_time 		= ""; 
$data['F_ACCOUNT_NO'] = $f_account_no;
$data['F_ERP_FROMOTH'] = $f_erp_fromoth;
$data['F_ERP_ORDER_BILL_NO'] = $f_erp_order_bill_no;
$data['F_CUST_NO'] = $f_cust_no;
$data['F_BILLER_NO'] = $f_biller_no;
$data['F_BILLER_P_NO'] = $f_biller_p_no;
$data['F_CHECKER_NO'] = $f_checker_no;
$data['F_BILL_DATE'] = $f_bill_date;
$data['F_REMARK'] = $f_remark;
$data['CUSTNAME'] = $custmame;
$data['LINKMAN'] = $linkman;
$data['TEL'] = $tel;
$data['DELIVER_NO'] = $deliver_no;
$data['DELIVER_NAME'] = $deliver_name;
$data['DELIVER_TIME'] = $deliver_time;
$data['ARRIVE_TIME'] = $arrive_time;
$data['UNIT'] = "件";

$product['F_ICNO'] = "12345677";
$product['F_UNIT'] = "件";
$product['F_PRICE'] = "150";
$product['F_QTY'] = "10";
$product['F_AMOUNT'] = "1500";
$product['F_WARE_NO'] = "";
$product['F_PRO_DATE'] = "";
$product['F_OUT_DATE'] = "";
$product['F_BLOCK_NO'] = "";
$product['F_REMARK_DTAIL'] = "test";

$order_detail = array();
$order_detail[0] = $product;

$data['PUR_DETAIL'] = $order_detail;
$data['USERNAME'] = "TESTER";
$data['TOKEN'] = "qwertyuiop1234567890";
$url = "http://127.0.0.1:8080/shop_src/shop_server/xiyong_purchase.php";
echo send_post($url, $data);
?>