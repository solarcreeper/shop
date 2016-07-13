<?php
require_once("./function/settings.php");
require_once("./function/mysql.php");
require_once("./function/send.php");
require_once("./function/check.php");
$token = clean_input($_POST['TOKEN']);
$username = clean_input($_POST['USERNAME']);
$response = array();
$check_result = check_token($username, $token);
// echo $check_result;	
//test data
// $check_result = ACCESS_ADMIN;

if($check_result == ACCESS_ADMIN){
	//更新token时间
	update_token($username, $token);

	$eshop_ent_code = clean_input($_POST['ESHOP_ENT_CODE']);
	$eshop_ent_name = clean_input($_POST['ESHOP_ENT_NAME']);
	$external_no = clean_input($_POST['EXTERNAL_NO']);;
	$sku = clean_input($_POST['SKU']);
	$goods_name = clean_input($_POST['GOODS_NAME']);
	$goods_spec = clean_input($_POST['GOODS_SPEC']);
	$declare_unit = clean_input($_POST['DECLARE_UNIT']);
	$post_tax_no = clean_input($_POST['POST_TAX_NO']);
	$tax_rate	= clean_input($_POST['TAX_RATE']);
	$legal_unit = clean_input($_POST['LEGAL_UNIT']);
	$conv_legal_unit_num = clean_input($_POST['CONV_LEGAL_UNIT_NUM']);
	$hs_code = clean_input($_POST['HS_CODE']);
	$in_area_unit = clean_input($_POST['IN_AREA_UNIT']);
	$conv_in_area_unit_num = clean_input($_POST['CONV_IN_AREA_UNIT_NUM']);
	$is_experiment_goods = clean_input($_POST['IS_EXPERIMENT_GOODS']);
	$origin_country_code = clean_input($_POST['ORIGIN_COUNTRY_CODE']);
	$is_cnca_por = clean_input($_POST['IS_CNCA_POR']);
	$cnca_por_doc = clean_input($_POST['CNCA_POR_DOC']);
	$origin_place_cert = clean_input($_POST['ORIGIN_PLACE_CERT']);
	$test_report = clean_input($_POST['TEST_REPORT']);
	$legal_ticket = clean_input($_POST['LEGAL_TICKET']);
	$mark_exchange = clean_input($_POST['MARK_EXCHANGE']);
	$check_org_code = clean_input($_POST['CHECK_ORG_CODE']);
	$supplier_name = clean_input($_POST['SUPPLIER_NAME']);
	$producer_name = clean_input($_POST['PRODUCER_NAME']);
	$is_cnca_por_doc = clean_input($_POST['IS_CNCA_POR_DOC']);
	$is_origin_place_cert = clean_input($_POST['IS_ORIGIN_PLACE_CERT']);
	$is_test_peport = clean_input($_POST['IS_TEST_REPORT']);
	$is_legal_ticket = clean_input($_POST['IS_LEGAL_TICKET']);
	$is_mark_exchange = clean_input($_POST['IS_MARK_EXCHANGE']);

	$price = clean_input($_POST['PRICE']);
	$picture = clean_input($_POST['PICTURE']);
	if($picture == "") $picture = "images/default_thumb.png";
	$msgId = md5(uniqid());
	$actionType = "1";
	$messageTime = date("Y-m-d H:s:i");
	$senderId = userCode;
	$receiverId = "CQITC";
	$userNo = userCode;
	$password = strtoupper(md5($msgId.userCode));
	$xml = "<DTC_Message>";
	$xml = $xml."<MessageHead>";
	$xml = $xml."<MessageType>"."SKU_INFO"."</MessageType>";
	$xml = $xml."<MessageId>".$msgId."</MessageId>";
	$xml = $xml."<ActionType>".$actionType."</ActionType>";
	$xml = $xml."<MessageTime>".$messageTime."</MessageTime>";
	$xml = $xml."<SenderId>".$senderId."</SenderId>";
	$xml = $xml."<ReceiverId>".$receiverId."</ReceiverId>";
	$xml = $xml."<UserNo>".$userNo."</UserNo>";
	$xml = $xml."<Password>".$password."</Password>";
	$xml = $xml."</MessageHead>";
	$xml = $xml."<MessageBody><DTCFlow><SKU_INFO>";
	$xml = $xml."<ESHOP_ENT_CODE>".$eshop_ent_code."</ESHOP_ENT_CODE>";
	$xml = $xml."<ESHOP_ENT_NAME>".$eshop_ent_name."</ESHOP_ENT_NAME>";
	$xml = $xml."<SKU>".$sku."</SKU>";
	$xml = $xml."<GOODS_NAME>".$goods_name."</GOODS_NAME>";
	$xml = $xml."<GOODS_SPEC>".$goods_spec."</GOODS_SPEC>";
	$xml = $xml."<DECLARE_UNIT>".$declare_unit."</DECLARE_UNIT>";
	$xml = $xml."<POST_TAX_NO>".$post_tax_no."</POST_TAX_NO>";
	$xml = $xml."<LEGAL_UNIT>".$legal_ticket."</LEGAL_UNIT>";
	$xml = $xml."<CONV_LEGAL_UNIT_NUM>".$conv_legal_unit_num."</CONV_LEGAL_UNIT_NUM>";
	$xml = $xml."<HS_CODE>".$hs_code."</HS_CODE>";
	$xml = $xml."<IN_AREA_UNIT>".$in_area_unit."</IN_AREA_UNIT>";
	$xml = $xml."<CONV_IN_AREA_UNIT_NUM>".$conv_in_area_unit_num."</CONV_IN_AREA_UNIT_NUM>";
	$xml = $xml."<IS_EXPERIMENT_GOODS>".$is_experiment_goods."</IS_EXPERIMENT_GOODS>";
	$xml = $xml."<IS_CNCA_POR_DOC>".$is_cnca_por_doc."</IS_CNCA_POR_DOC>";
	$xml = $xml."<IS_ORIGIN_PLACE_CERT>".$is_origin_place_cert."</IS_ORIGIN_PLACE_CERT>";
	$xml = $xml."<IS_TEST_REPORT>".$is_test_peport."</IS_TEST_REPORT>";
	$xml = $xml."<IS_LEGAL_TICKET>".$is_legal_ticket."</IS_LEGAL_TICKET>";
	$xml = $xml."<IS_MARK_EXCHANGE>".$is_mark_exchange."</IS_MARK_EXCHANGE>";
	$xml = $xml."<CHECK_ORG_CODE>".$check_org_code."</CHECK_ORG_CODE>";
	$xml = $xml."</SKU_INFO></DTCFlow></MessageBody>";
	$xml = $xml."</DTC_Message>";

	$data = base64_encode($xml);
	$post_data = array();
	$post_data['data'] = $data;
	// $result = send_post(qicUrl, $post_data);
	$result = "True";
	// echo $result;
	//echo $xml;
	if($result == "True"){
		$conn = mysql_open();
		//事务开始
		mysqli_query($conn, "BEGIN");
		$del_sku_sql = "delete from ciq_sku_info where sku = '$sku'";
		$del_sku_sql_query = mysqli_query($conn, $del_sku_sql);
		$insert_sku_sql = "insert into ciq_sku_info(eshop_ent_code, eshop_ent_name, external_no, sku, goods_name, goods_spec,declare_unit, 
				post_tax_no, legal_unit, conv_legal_unit_num, hs_code, in_area_unit, 
				conv_in_area_unit_num, is_experiment_goods, origin_country_code, is_cnca_por, cnca_por_doc,
				origin_place_cert, test_report, legal_ticket, mark_exchange, check_org_code,
				supplier_name, producer_name, is_cnca_por_doc, is_origin_place_cert, is_test_peport,
				is_legal_ticket, is_mark_exchange, price, picture, tax_rate) 
				values('$eshop_ent_code', '$eshop_ent_name', '$external_no', '$sku', '$goods_name', '$goods_spec', '$declare_unit',
				'$post_tax_no', '$legal_unit', '$conv_legal_unit_num', '$hs_code', '$in_area_unit',
				'$conv_in_area_unit_num', $is_experiment_goods, '$origin_country_code', '$is_cnca_por', '$cnca_por_doc',
				'$origin_place_cert', '$test_report', '$legal_ticket', '$mark_exchange', '$check_org_code',
				'$supplier_name', '$producer_name', $is_cnca_por_doc, $is_origin_place_cert, $is_test_peport,
				$is_legal_ticket, $is_mark_exchange, $price, '$picture', $tax_rate)";
		// echo $insert_sku_sql;
		$insert_sku_query = mysqli_query($conn, $insert_sku_sql);
		if($insert_sku_query){
			//事务提交
			mysqli_query($conn, "COMMIT");
			$response['error_code'] = SUCCESS;
			$response['error_msg'] = "成功！";
		}else{
			//事务回滚
			mysqli_query($conn, "ROLLBACK");
			$response['error_code'] = FAILED;
			$response['error_msg'] = "数据存储失败！";
		}
		//事务结束
		mysqli_query($conn, "END"); 
		mysqli_close($conn);
	}else{
			$response['error_code'] = FAILED;
			$response['error_msg'] = "发送失败！";
	}
}else{
	$response['error_code'] = TOKEN_CHECK_FAILED;
	$response['error_msg'] = "权限认证失败！";
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>