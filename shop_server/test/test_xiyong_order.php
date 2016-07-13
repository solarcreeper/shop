<?php
require_once("./function/send.php");
require_once("../function/xiyong_order.php");

$barcode = "201512070001";
$ORIGINAL_ORDER_NO = "201512110001";

echo send_order_xiyong($ORIGINAL_ORDER_NO, $barcode);
// $xml = "<DTC_Message><MessageHead><MessageType>ORDER_BAR_CODE_FB</MessageType><MessageId>e3641bee-7a22-4280-8684-81af3ca5ec17</MessageId><MessageTime>2014-07-04T09:02:27</MessageTime><SenderId>CQITC</SenderId><SenderAddress /><ReceiverId>50052602BE</ReceiverId><ReceiverAddress /><PlatFormNo /><CustomCode /><SeqNo>CQZY-I140704-0000001</SeqNo><Note /><UserNo /><Password /></MessageHead><MessageBody><DTCFlow><ORDER_BAR_CODE_FB><ORDER_NO>CQZY-I140704-0000001</ORDER_NO><ORIGINAL_ORDER_NO>130935133388722178</ORIGINAL_ORDER_NO><BAR_CODE>I1320140000000008932</BAR_CODE></ORDER_BAR_CODE_FB></DTCFlow></MessageBody></DTC_Message>";
// $xml_data = base64_encode($xml);

// $data['data'] = $xml_data;
// $url = "http://127.0.0.1:8080/shop_src/shop_server/receiver.php";
// echo send_post($url, $data);
?>