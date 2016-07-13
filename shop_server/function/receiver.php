<?php
  require_once("./function/mysql.php");
  require_once("./xiyong_order.php");
  if(!is_null($_POST['data'])){
  	$data = base64_decode($_POST['data']);
    //test sql
    $conn = mysql_open();
    $sql = "insert into test(content) values('$data')";
    $query = mysqli_query($conn, $sql);
    mysqli_close($conn);

  	$xmlstr = <<<XML
	$data
XML;
  	analyse_xml($xmlstr);
  	
  }else{
  	echo "null";
  }


  /** 
   * @function analyse_xml
   * @desc 接受海关条码
   * @param xml $data 海关返回的数据 
   * @return string
   */
  function analyse_xml($data){
  	$xml = simplexml_load_string($data);
    $operate_type = $xml->MessageHead->MessageType;
    $operate_name_ask = $xml->MessageBody->DTCFlow->$operate_type->MESSAGE_TYPE;
    $operate_name_ret = $xml->MessageBody->DTCFlow->$operate_type;

  	$conn = mysql_open();
  	if($operate_type == "ORDER_BAR_CODE_FB"){
	  	$original_order_no = $xml->MessageBody->DTCFlow->ORDER_BAR_CODE_FB->ORIGINAL_ORDER_NO;
	  	$bar_code = $xml->MessageBody->DTCFlow->ORDER_BAR_CODE_FB->BAR_CODE;
	    if($bar_code != null){
      	  $sql = "update order_payment_info set bar_code = '$bar_code' where original_order_no = '$original_order_no'";
	      $query = mysqli_query($conn, $sql);
	      echo send_order_xiyong($original_order_no, $bar_code);
	    }
  	}
    if($operate_name_ask != ""){
    	switch ($operate_name_ask) {
	      case 'SKU_INFO':
	      	$sku = $xml->MessageBody->DTCFlow->$operate_type->WORK_NO;
	      	$op_date = $xml->MessageBody->DTCFlow->$operate_type->OP_DATE;
	      	$status_code = $xml->MessageBody->DTCFlow->$operate_type->SUCCESS;
	      	$memo = $xml->MessageBody->DTCFlow->$operate_type->MEMO;
	      	$sql = "update ciq_sku_info set status_code = '$status_code', op_date = '$op_date', memo = '$memo' where sku = '$sku'";
	        $query = mysqli_query($conn, $sql);
	        if(!$query){
	        	echo "false";	
	        }else{
	        	echo "true";
	        }
	        break;      
	      case 'ORDER_INFO':
	      	$original_order_no = $xml->MessageBody->DTCFlow->$operate_type->WORK_NO;
	      	$op_date = $xml->MessageBody->DTCFlow->$operate_type->OP_DATE;
	      	$status_code = $xml->MessageBody->DTCFlow->$operate_type->SUCCESS;
	      	$memo = $xml->MessageBody->DTCFlow->$operate_type->MEMO;
	      	$sql = "update order_payment_info set order_status_code = '$status_code', order_op_date = '$op_date', order_memo = '$memo' where original_order_no = '$original_order_no'";
	        $query = mysqli_query($conn, $sql);
	        if(!$query){
	        	echo "false";	
	        }else{
	        	echo "true";
	        }
	        break;
	      case 'PAYMENT_INFO':
	      	$original_order_no = $xml->MessageBody->DTCFlow->$operate_type->WORK_NO;
	      	$op_date = $xml->MessageBody->DTCFlow->$operate_type->OP_DATE;
	      	$status_code = $xml->MessageBody->DTCFlow->$operate_type->SUCCESS;
	      	$memo = $xml->MessageBody->DTCFlow->$operate_type->MEMO;
	      	$sql = "update order_payment_info set payment_status_code = '$status_code', payment_op_date = '$op_date', payment_memo = '$memo' where original_order_no = '$original_order_no'";
	        $query = mysqli_query($conn, $sql);
	        if(!$query){
	        	echo "false";	
	        }else{
	        	echo "true";
	        }
	        break;
	      case 'ORDER_RECEIVE':
	      	$original_order_no = $xml->MessageBody->DTCFlow->$operate_type->WORK_NO;
	      	$op_date = $xml->MessageBody->DTCFlow->$operate_type->OP_DATE;
	      	$status_code = $xml->MessageBody->DTCFlow->$operate_type->SUCCESS;
	      	$memo = $xml->MessageBody->DTCFlow->$operate_type->MEMO;
	      	$sql = "update ciq_order_receive_info set status_code = '$status_code', op_date = '$op_date', memo = '$memo' where original_order_no = '$original_order_no'";
	        $query = mysqli_query($conn, $sql);
	        if(!$query){
	        	echo "false";	
	        }else{
	        	echo "true";
	        }
	        break;   
	      default:

	        break;
	    }
    }else{
    	switch ($operate_name_ret) {
	      case 'SKU_INFO_FB':
	      	$sku = $xml->MessageBody->DTCFlow->$operate_type->SKU;
	      	$op_date = $xml->MessageBody->DTCFlow->$operate_type->OP_DATE;
	      	$status_code = $xml->MessageBody->DTCFlow->$operate_type->STATUS_CODE;
	      	$memo = $xml->MessageBody->DTCFlow->$operate_type->MEMO;
	      	$sql = "update ciq_sku_info set status_code = '$status_code', op_date = '$op_date', memo = '$memo' where sku = '$sku'";
	        $query = mysqli_query($conn, $sql);
	        if(!$query){
	        	echo "false";	
	        }else{
	        	echo "true";
	        }
	        break;      
	      case 'ORDER_INFO_FB':
	      	$original_order_no = $xml->MessageBody->DTCFlow->$operate_type->ORIGINAL_ORDER_NO;
	      	$op_date = $xml->MessageBody->DTCFlow->$operate_type->OP_DATE;
	      	$status_code = $xml->MessageBody->DTCFlow->$operate_type->STATUS_CODE;
	      	$memo = $xml->MessageBody->DTCFlow->$operate_type->MEMO;
	      	$sql = "update order_payment_info set order_status_code = '$status_code', order_op_date = '$op_date', order_memo = '$memo' where original_order_no = '$original_order_no'";
	        $query = mysqli_query($conn, $sql);
	        if(!$query){
	        	echo "false";	
	        }else{
	        	echo "true";
	        }
	        break;  
	      case 'PAYMENT_INFO_FB':
	      	$original_order_no = $xml->MessageBody->DTCFlow->$operate_type->PAYMENT_NO;
	      	$op_date = $xml->MessageBody->DTCFlow->$operate_type->OP_DATE;
	      	$status_code = $xml->MessageBody->DTCFlow->$operate_type->STATUS_CODE;
	      	$memo = $xml->MessageBody->DTCFlow->$operate_type->MEMO;
	      	$sql = "update order_payment_info set payment_status_code = '$status_code', payment_op_date = '$op_date', payment_memo = '$memo' where original_order_no = '$original_order_no'";
	        $query = mysqli_query($conn, $sql);
	        if(!$query){
	        	echo "false";	
	        }else{
	        	echo "true";
	        }
	        break;    
	      default:

	        break;
	    }
    }
  	mysqli_close($conn);
  }
?>