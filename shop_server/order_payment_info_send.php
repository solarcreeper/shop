<?php
require_once("./function/settings.php");
require_once("./function/mysql.php");
require_once("./function/send.php");
require_once("./function/check.php");
$token = clean_input($_GET['TOKEN']);
$username = clean_input($_GET['USERNAME']);
$original_order_no = clean_input($_GET['ORIGINAL_ORDER_NO']);
$response = array();
$check_result = check_token($username, $token);
//testdata
// $check_result = ACCESS_ADMIN;
// $original_order_no = "1";

if( $check_result == ACCESS_ADMIN){
	//更新token时间
	update_token($username, $token);

	$conn = mysql_open();
	$info = "select customs_code, biz_type_code, eshop_ent_code, eshop_ent_name,
			desc_arri_country_code, ship_tool_code, receiver_id_no, receiver_name, receiver_address,
			receiver_tel, goods_fee, tax_fee, sortline_id, transport_fee,
			check_type, payment_id_no, payment_name, payment_tel, payment_ent_code,
			payment_ent_name, payment_no, pay_amount, pay_memo, send_status
			from order_payment_info where original_order_no = '$original_order_no'";
	// echo $info;
	$query_info = mysqli_query($conn, $info);
	$ciq_order = mysqli_fetch_object($query_info);

	$customs_code 			= $ciq_order->customs_code;
	$biz_type_code 			= $ciq_order->biz_type_code;
	$eshop_ent_code 		= $ciq_order->eshop_ent_code;
	$eshop_ent_name 		= $ciq_order->eshop_ent_name;
	$desc_arri_country_code = $ciq_order->desc_arri_country_code;
	$ship_tool_code 		= $ciq_order->ship_tool_code;
	$receiver_id_no 		= $ciq_order->receiver_id_no;
	$receiver_name 			= $ciq_order->receiver_name;
	$receiver_address 		= $ciq_order->receiver_address;
	$receiver_tel 			= $ciq_order->receiver_tel;
	$goods_fee 				= $ciq_order->goods_fee;
	$tax_fee 				= $ciq_order->tax_fee;
	$sortline_id 			= $ciq_order->sortline_id;
	$transport_fee 			= $ciq_order->transport_fee;
	$check_type 			= $ciq_order->check_type;
	$payment_id_no 			= $ciq_order->payment_id_no;
	$payment_name 			= $ciq_order->payment_name;
	$payment_tel 			= $ciq_order->payment_tel;
	$payment_ent_code 		= $ciq_order->payment_ent_code;
	$payment_ent_name 		= $ciq_order->payment_ent_name;
	$payment_no 			= $ciq_order->payment_no;
	$pay_amount 			= $ciq_order->pay_amount;
	$pay_memo 				= $ciq_order->pay_memo;
	$send_status 			= $ciq_order->send_status;
	if($send_status == 0){
		$order_detail_sql = "select sku, goods_spec, currency_code, price, qty, goods_fee, tax_fee 
						     from order_goods_info where original_order_no = '$original_order_no'";
		$order_detail_query = mysqli_query($conn, $order_detail_sql);

		$msgId = md5(uniqid());
		$actionType = "1";
		$messageTime = date("Y-m-d H:s:i");
		$senderId = userCode;
		$receiverId = "CQITC";
		$userNo = userCode;
		$password = strtoupper(md5($msgId.userCode));


		$order_xml = "<DTC_Message>";
		$order_xml = $order_xml."<MessageHead>";
		$order_xml = $order_xml."<MessageType>"."ORDER_INFO"."</MessageType>";
		$order_xml = $order_xml."<MessageId>".$msgId."</MessageId>";
		$order_xml = $order_xml."<ActionType>".$actionType."</ActionType>";
		$order_xml = $order_xml."<MessageTime>".$messageTime."</MessageTime>";
		$order_xml = $order_xml."<SenderId>".$senderId."</SenderId>";
		$order_xml = $order_xml."<ReceiverId>".$receiverId."</ReceiverId>";
		$order_xml = $order_xml."<SenderAddress></SenderAddress>";
		$order_xml = $order_xml."<ReceiverAddress></ReceiverAddress>";
		$order_xml = $order_xml."<PlatFormNo></PlatFormNo>";
		$order_xml = $order_xml."<CustomCode></CustomCode>";
		$order_xml = $order_xml."<SeqNo></SeqNo>";
		$order_xml = $order_xml."<Note></Note>";
		$order_xml = $order_xml."<UserNo>".$userNo."</UserNo>";
		$order_xml = $order_xml."<Password>".$password."</Password>";
		$order_xml = $order_xml."</MessageHead>";
		$order_xml = $order_xml."<MessageBody>";
		$order_xml = $order_xml."<DTCFlow>";
		$order_xml = $order_xml."<ORDER_HEAD>";
		$order_xml = $order_xml."<CUSTOMS_CODE>".$customs_code."</CUSTOMS_CODE>";
		$order_xml = $order_xml."<BIZ_TYPE_CODE>".$biz_type_code."</BIZ_TYPE_CODE>";
		$order_xml = $order_xml."<ORIGINAL_ORDER_NO>".$original_order_no."</ORIGINAL_ORDER_NO>";
		$order_xml = $order_xml."<ESHOP_ENT_CODE>".$eshop_ent_code."</ESHOP_ENT_CODE>";
		$order_xml = $order_xml."<ESHOP_ENT_NAME>".$eshop_ent_name."</ESHOP_ENT_NAME>";
		$order_xml = $order_xml."<DESP_ARRI_COUNTRY_CODE>".$desc_arri_country_code."</DESP_ARRI_COUNTRY_CODE>";
		$order_xml = $order_xml."<SHIP_TOOL_CODE>".$ship_tool_code."</SHIP_TOOL_CODE>";
		$order_xml = $order_xml."<RECEIVER_ID_NO>".$receiver_id_no."</RECEIVER_ID_NO>";
		$order_xml = $order_xml."<RECEIVER_NAME>".$receiver_name."</RECEIVER_NAME>";
		$order_xml = $order_xml."<RECEIVER_ADDRESS>".$receiver_address."</RECEIVER_ADDRESS>";
		$order_xml = $order_xml."<RECEIVER_TEL>".$receiver_tel."</RECEIVER_TEL>";
		$order_xml = $order_xml."<GOODS_FEE>".$goods_fee."</GOODS_FEE>";
		$order_xml = $order_xml."<TAX_FEE>".$tax_fee."</TAX_FEE>";
		$order_xml = $order_xml."<SORTLINE_ID>".$sortline_id."</SORTLINE_ID>";
		//添加商品
		while($product = mysqli_fetch_object($order_detail_query)){
			$sku = $product->sku;
			//过滤普通商品
			$check_sku_sql = "select sku from ciq_sku_info where sku = '$sku'";
			$check_sku_query = mysqli_query($conn, $check_sku_sql);
			$result = mysqli_fetch_object($check_sku_query)->sku;
			if($result != ""){
				$order_xml = $order_xml."<ORDER_DETAIL>";
				$order_xml = $order_xml."<SKU>".$product->sku."</SKU>";
				$order_xml = $order_xml."<GOODS_SPEC>".$product->goods_spec."</GOODS_SPEC>";
				$order_xml = $order_xml."<CURRENCY_CODE>".$product->currency_code."</CURRENCY_CODE>";
				$order_xml = $order_xml."<PRICE>".$product->price."</PRICE>";
				$order_xml = $order_xml."<QTY>".$product->qty."</QTY>";
				$order_xml = $order_xml."<GOODS_FEE>".$product->goods_fee."</GOODS_FEE>";
				$order_xml = $order_xml."<TAX_FEE>".$product->tax_fee."</TAX_FEE>";
				$order_xml = $order_xml."</ORDER_DETAIL>";
			}
		}

		$order_xml = $order_xml."</ORDER_HEAD>";
		$order_xml = $order_xml."</DTCFlow>";
		$order_xml = $order_xml."</MessageBody>";
		$order_xml = $order_xml."</DTC_Message>";

		$order_data = base64_encode($order_xml);
		$post_data = array();
		$post_data['data'] = $order_data;
		$result_order = send_post(qicUrl, $post_data);

		$payment_xml = "<DTC_Message>";
		$payment_xml = $payment_xml."<MessageHead>";
		$payment_xml = $payment_xml."<MessageType>"."PAYMENT_INFO"."</MessageType>";
		$payment_xml = $payment_xml."<MessageId>".$msgId."</MessageId>";
		$payment_xml = $payment_xml."<MessageTime>".$messageTime."</MessageTime>";
		$payment_xml = $payment_xml."<SenderId>".$senderId."</SenderId>";
		$payment_xml = $payment_xml."<ReceiverId>".$receiverId."</ReceiverId>";
		$payment_xml = $payment_xml."<SenderAddress></SenderAddress>";
		$payment_xml = $payment_xml."<ReceiverAddress></ReceiverAddress>";
		$payment_xml = $payment_xml."<PlatFormNo></PlatFormNo>";
		$payment_xml = $payment_xml."<CustomCode></CustomCode>";
		$payment_xml = $payment_xml."<SeqNo></SeqNo>";
		$payment_xml = $payment_xml."<Note></Note>";
		$payment_xml = $payment_xml."<UserNo>".$userNo."</UserNo>";
		$payment_xml = $payment_xml."<Password>".$password."</Password>";
		$payment_xml = $payment_xml."</MessageHead>";
		$payment_xml = $payment_xml."<MessageBody>";
		$payment_xml = $payment_xml."<DTCFlow>";
		$payment_xml = $payment_xml."<PAYMENT_INFO>";

		$payment_xml = $payment_xml."<CUSTOMS_CODE>".$customs_code."</CUSTOMS_CODE>";
		$payment_xml = $payment_xml."<BIZ_TYPE_CODE>".$biz_type_code."</BIZ_TYPE_CODE>";
		$payment_xml = $payment_xml."<ESHOP_ENT_CODE>".$eshop_ent_code."</ESHOP_ENT_CODE>";
		$payment_xml = $payment_xml."<ESHOP_ENT_NAME>".$eshop_ent_name."</ESHOP_ENT_NAME>";
		$payment_xml = $payment_xml."<PAYMENT_ENT_CODE>".$payment_ent_code."</PAYMENT_ENT_CODE>";
		$payment_xml = $payment_xml."<PAYMENT_ENT_NAME>".$payment_ent_name."</PAYMENT_ENT_NAME>";
		$payment_xml = $payment_xml."<PAYMENT_NO>".$payment_no."</PAYMENT_NO>";
		$payment_xml = $payment_xml."<ORIGINAL_ORDER_NO>".$original_order_no."</ORIGINAL_ORDER_NO>";
		$payment_xml = $payment_xml."<PAY_AMOUNT>".$pay_amount."</PAY_AMOUNT>";
		$payment_xml = $payment_xml."<GOODS_FEE>".$goods_fee."</GOODS_FEE>";
		$payment_xml = $payment_xml."<TAX_FEE>".$tax_fee."</TAX_FEE>";
		$payment_xml = $payment_xml."<CURRENCY_CODE>".$currency_code."</CURRENCY_CODE>";
		$payment_xml = $payment_xml."<MEMO>".$pay_memo."</MEMO>";

		$payment_xml = $payment_xml."</PAYMENT_INFO>";
		$payment_xml = $payment_xml."</DTCFlow>";
		$payment_xml = $payment_xml."</MessageBody>";
		$payment_xml = $payment_xml."</DTC_Message>";

		$payment_data = base64_encode($payment_xml);
		$post_data = array();
		$post_data['data'] = $payment_data;
		$result_payment = send_post(qicUrl, $post_data);
		
		// echo $payment_xml;
		// echo $order_xml;
		// echo $result_order.$result_payment;
		// $result_order = "True";
		// $result_payment = "True";

		if($result_order == "True" && $result_payment == "True"){
			//更新订单发送状态
			$update_send_status = "update order_payment_info set send_status = 1 where original_order_no = '$original_order_no'";
			$query_update_send_status = mysqli_query($conn, $update_send_status);
			$response['error_code'] = SUCCESS;
			$response['error_msg'] = "成功！";		
		}else{
			$update_send_status = "update order_payment_info set send_status = -1 where original_order_no = '$original_order_no'";
			$query_update_send_status = mysqli_query($conn, $update_send_status);
			if($result_order != "True"){
				$response['error_code'] = FAILED;
				$response['error_msg'] = "订单发送失败！";
			}else{
				$response['error_code'] = FAILED;
				$response['error_msg'] = "支付单发送失败！";
			}
			
		}
	}
	else{
		$response['error_code'] = FAILED;
		$response['error_msg'] = "该订单已处理！";
	}


	mysqli_close($conn);
}else{
	$response['error_code'] = TOKEN_CHECK_FAILED;
	$response['error_msg'] = "权限认证失败！";
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>