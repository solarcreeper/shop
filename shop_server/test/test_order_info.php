<?php
require_once("./function/send.php");

$customs_code = "8000";
$biz_type_code = "I10";
$original_order_no = "130935133388722178";
$eshop_ent_code = "50122604E2";
$eshop_ent_name = "重庆诺森比亚进出口贸易公司";
$desp_arri_country_code = "142";

$ship_tool_code = "5";
$receiver_id_no = "50022119930612153X";
$receiver_name = "佟国";
$receiver_address = "福建省 福州市 台江区 六一中路249号 电子商务部";
$receiver_tel = "15909090909";
$goods_fee = "150";
$tax_fee = "0";
$sortline_id = "SORTLINE01";
$transport_fee = "0";
$check_type = "R";
$currency_code = "142";
$product = array();
$product['SKU'] = "50052602BEI000000022";
$product['GOODS_SPEC'] = "帆布鞋";
$product['CURRENCY_CODE'] = "142";
$product['PRICE'] = "150";
$product['QTY'] = "1";
$product['GOODS_FEES'] = "150";
$product['TAX_FEES'] = "15";
$product['FUNIT'] = "k";
$product['FQTY'] = "5";
$product['FPRICE'] = "5";
$product['FAMOUNT'] = "5";
$product['FWARENO'] = "";
$product['FPRODATE'] = "";
$product['FOUTDATE'] = "";
$product['FBLOCKNO'] = "";
$product['FREMARKDTAIL'] = "none";

$order_detail = array();
$order_detail[0] = $product;

$data['CUSTOMS_CODE'] = $customs_code;
$data['BIZ_TYPE_CODE'] = $biz_type_code;
$data['ORIGINAL_ORDER_NO'] = $original_order_no;
$data['ESHOP_ENT_CODE'] = $eshop_ent_code;
$data['ESHOP_ENT_NAME'] = $eshop_ent_name;
$data['DESP_ARRI_COUNTRY_CODE'] = $desp_arri_country_code;
$data['SHIP_TOOL_CODE'] = $ship_tool_code;
$data['RECEIVER_ID_NO'] = $receiver_id_no;
$data['RECEIVER_NAME'] = $receiver_name;
$data['RECEIVER_ADDRESS'] = $receiver_address;
$data['RECEIVER_TEL'] = $receiver_tel;
$data['GOODS_FEE'] = $goods_fee;
$data['TAX_FEE'] = $tax_fee;
$data['SORTLINE_ID'] = $sortline_id;
$data['TRANSPORT_FEE'] = $transport_fee;
$data['CHECK_TYPE'] = $check_type;
$data['ORDER_DETAIL'] = $order_detail;

$data['PAYMENT_ENT_CODE'] = $eshop_ent_code;
$data['PAYMENT_ENT_NAME'] = $eshop_ent_name;
$data['PAYMENT_NO'] = $original_order_no;
$data['PAY_AMOUNT'] = $goods_fee;
$data['CURRENCY_CODE'] = $currency_code;

$data['BAR_CODE'] = "201511240001";
$data['FACCOUNTNO'] = "001";
$data['FBILLTYPE'] = "2";
$data['FERPFROMOTH'] = "20151124";
$data['FCUSTNO'] = "20151124";
$data['FSTOCKINNO'] = "1124";
$data['FSTOCKOUTNO'] = "1124";
$data['FCHECKERNO'] = "20151124";
$data['FREMARK'] = "re";
$data['FDISCHARGEPLACE'] = "";
$data['FDELIVERPLACE'] = "";
$data['FC_PROVINCENAME'] = "四川省";
$data['FC_PROVINCE'] = "000011";
$data['FC_CITYNAME'] = "成都市";
$data['FC_CITY'] = "110011";
$data['FC_AREANAME'] = "双流县";
$data['FC_AREA'] = "111111";
$data['FC_ZIP'] = "6116223";
$data['FTYPE'] = "Y";
$data['FBJFLAG'] = "N";
$data['FBJAMT'] = "0";
$data['XIYONG_BILL_DATE'] = "2015-11-11";

$data['USERNAME'] = "yehongjiang";
$data['TOKEN'] = "qwertyuiop1234567890";
$url = "http://127.0.0.1:8080/shop_src/shop_server/order_payment_info.php";
echo send_post($url, $data);
// $url = "http://218.70.106.50:9007/transfer/test.php";
// $data['username'] = "yehongjiang";
// $result = send_post($url, $data);
// echo $result;
?>