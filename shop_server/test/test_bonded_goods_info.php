<?php
require_once("./function/send.php");

$eshop_ent_code = "50122604E2";
$eshop_ent_name = "诺森比亚进出口贸易公司";
$external_no = "";
$sku = "50052602BEI000000022";
$goods_name = "帆布鞋1";
$goods_spec = "Nutrilon 荷兰本土牛栏奶粉1段1";
$declare_unit = "个";
$post_tax_no = "06010200";
$legal_unit = "个";
$conv_legal_unit_num = "1";
$hs_code = "";
$in_area_unit = "";
$conv_in_area_unit_num = "";
$is_experiment_goods = "0";
$origin_country_code = "";
$is_cnca_por = "1";
$cnca_por_doc = "";
$origin_place_cert = "";
$test_peport = "";
$legal_ticket = "";
$mark_exchange = "";
$check_org_code = "";
$supplier_name = "";
$producer_name = "";
$is_cnca_por_doc = "0";	
$is_origin_place_cert = "0";
$is_test_peport = "0";
$is_legal_ticket = "0";
$is_mark_exchange = "0";
$price = "123";
$picture = "";
$data = array();
$data['ESHOP_ENT_CODE'] = $eshop_ent_code;
$data['ESHOP_ENT_NAME'] = $eshop_ent_name;
$data['EXTERNAL_NO'] = $external_no;
$data['SKU'] = $sku;
$data['GOODS_NAME'] = $goods_name;
$data['GOODS_SPEC'] = $goods_spec;
$data['DECLARE_UNIT'] = $declare_unit;
$data['POST_TAX_NO'] = $post_tax_no;
$data['LEGAL_UNIT'] = $legal_unit;
$data['CONV_LEGAL_UNIT_NUM'] = $conv_legal_unit_num;
$data['HS_CODE'] = $hs_code;
$data['IN_AREA_UNIT'] = $in_area_unit;
$data['CONV_IN_AREA_UNIT_NUM'] = $conv_in_area_unit_num;
$data['IS_EXPERIMENT_GOODS'] = $is_experiment_goods;
$data['ORIGIN_COUNTRY_CODE'] = $origin_country_code;
$data['IS_CNCA_POR'] = $is_cnca_por;
$data['CNCA_POR_DOC'] = $cnca_por_doc;
$data['ORIGIN_PLACE_CERT'] = $origin_place_cert;
$data['TEST_REPORT'] = $test_peport;
$data['LEGAL_TICKET'] = $legal_ticket;
$data['MARK_EXCHANGE'] = $mark_exchange;
$data['CHECK_ORG_CODE'] = $heck_org_code;
$data['SUPPLIER_NAME'] = $supplier_name;
$data['PRODUCER_NAME'] = $producer_name;
$data['IS_CNCA_POR_DOC'] = $is_cnca_por_doc;
$data['IS_ORIGIN_PLACE_CERT'] = $is_origin_place_cert;
$data['IS_TEST_REPORT'] = $is_test_peport;
$data['IS_LEGAL_TICKET'] = $is_legal_ticket;
$data['IS_MARK_EXCHANGE'] = $is_mark_exchange;
$data['PRICE'] = $price;
$data['PICTURE'] = $picture;
$data['TAX_RATE'] = "0.5";

$data['USERNAME'] = "TESTER";
$data['TOKEN'] = "qwertyuiop1234567890";
$url = "http://127.0.0.1:8080/shop_src/shop_server/bonded_goods_info.php";
$result = send_post($url, $data);
echo $result;
?>