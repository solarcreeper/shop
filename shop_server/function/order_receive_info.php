<?php
require_once("settings.php");
require_once("mysql.php");
require_once("send.php");
/*
 * @params original_order_no 		原始订单号
 * @params receive_date 			签收日期
 * @params memo 					备注
 * @params bill_info_no 			订单号
 */
function order_receive_info($original_order_no, $receive_date, $memo, $bill_info_no){
	$conn = mysql_open();
	$get_receive_info_sql = "select eshop_ent_code, eshop_ent_name from order_payment_info where original_order_no = '$original_order_no'";
	$get_receive_info_query = mysqli_query($conn, $get_receive_info_sql);
	$receive_info = mysqli_fetch_object($get_receive_info_query);
	$eshop_ent_code = $receive_info->eshop_ent_code;
	$eshop_ent_name = $receive_info->eshop_ent_name;
	$receive_status_code = "130";
	$msgId = md5(uniqid());
	$actionType = "1";
	$messageTime = date("Y-m-d H:s:i");
	$senderId = userCode;
	$receiverId = "CQITC";
	$userNo = userCode;
	$password = strtoupper(md5($msgId.userCode));

	$xml = "<DTC_Message>";
	$xml = $xml."<MessageHead>";
	$xml = $xml."<MessageType>"."ORDER_RECEIVE_INFO"."</MessageType>";
	$xml = $xml."<MessageId>".$msgId."</MessageId>";
	$xml = $xml."<ActionType>".$actionType."</ActionType>";
	$xml = $xml."<MessageTime>".$messageTime."</MessageTime>";
	$xml = $xml."<SenderId>".$senderId."</SenderId>";
	$xml = $xml."<ReceiverId>".$receiverId."</ReceiverId>";

	$xml = $xml."<SenderAddress />";
	$xml = $xml."<ReceiverAddress />";
	$xml = $xml."<PlatFormNo />";
	$xml = $xml."<CustomCode />";
	$xml = $xml."<SeqNo />";
	$xml = $xml."<Note />";

	$xml = $xml."<UserNo>".$userNo."</UserNo>";
	$xml = $xml."<Password>".$password."</Password>";
	$xml = $xml."</MessageHead>";

	$xml = $xml."<MessageBody><DTCFlow><ORDER_RECEIVE_INFO>";
	$xml = $xml."<ORDER_NO>".""."</ORDER_NO>";
	$xml = $xml."<ORIGINAL_ORDER_NO>".$original_order_no."</ORIGINAL_ORDER_NO>";
	$xml = $xml."<BILL_INFO_NO>".$bill_info_no."</BILL_INFO_NO>";
	$xml = $xml."<ESHOP_ENT_CODE>".$eshop_ent_code."</ESHOP_ENT_CODE>";
	$xml = $xml."<ESHOP_ENT_NAME>".$eshop_ent_name."</ESHOP_ENT_NAME>";
	// $xml = $xml."<LOGISTICS_ENT_CODE>".$logistics_ent_code."</LOGISTICS_ENT_CODE>";
	// $xml = $xml."<LOGISTICS_ENT_NAME>".$logistics_ent_name."</LOGISTICS_ENT_NAME>";
	$xml = $xml."<RECEIVE_STATUS_CODE>".$receive_status_code."</RECEIVE_STATUS_CODE>";
	$xml = $xml."<RECEIVE_DATE>".$receive_date."</RECEIVE_DATE>";
	$xml = $xml."<MEMO>".$memo."</MEMO>";
	$xml = $xml."</ORDER_RECEIVE_INFO></DTCFlow></MessageBody>";
	$xml = $xml."</DTC_Message>";

	$data = base64_encode($xml);
	$post_data = array();
	$post_data['data'] = $data;
	$result = send_post(qicUrl, $post_data);
	// $result = "True";
	// echo $result;
	//echo $xml;
	$flag = true;
	if($result == "True"){
		//事务开始
		mysqli_query($conn, "BEGIN");
		$delrecive= "delete from ciq_order_receive_info where original_order_no = '$original_order_no'";
		// echo $delrecive;
		$querydel = mysqli_query($conn, $delrecive);
		$sql = "insert into ciq_order_receive_info(original_order_no, bill_info_no, eshop_ent_code, eshop_ent_name, receive_status_code, receive_date, memo) 
		values('$original_order_no', '$bill_info_no', '$eshop_ent_code', '$eshop_ent_name', '$receive_status_code', '$receive_date', '$memo')";
		$query = mysqli_query($conn, $sql);
		// echo $sql;
		if($query){
			//事务提交
			mysqli_query($conn, "COMMIT");
		}else{
			//事务回滚
			mysqli_query($conn, "ROLLBACK");
			$flag = false;
		} 
	}else{
		$flag = false;
	}
	//事务结束
	mysqli_query($conn, "END"); 
	mysqli_close($conn);
	return $flag;
}
?>