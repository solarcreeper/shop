<?php
require_once("./function/settings.php");
require_once("./function/mysql.php");
require_once("./function/send.php");
require_once("./function/check.php");
$token = clean_input($_POST['TOKEN']);
$username = clean_input($_POST['USERNAME']);
$response = array();
$check_result = check_token($username, $token);

//testhead
// $check_result = ACCESS_ADMIN;
// echo $check_result;
if($check_result == ACCESS_ADMIN){
	$f_account_no 		 = clean_input($_POST["F_ACCOUNT_NO"]);
    $f_erp_order_bill_no = clean_input($_POST["F_ERP_ORDER_BILL_NO"]);
	
	//系统生成唯一采购订单号(账套号.采购订单号)
	$f_erp_bill_no 	= $f_account_no.".".uniqid();
	
	$f_cust_no 		= clean_input($_POST["F_CUST_NO"]);
	$f_biller_no 	= clean_input($_POST["F_BILLER_NO"]);
	$f_biller_p_no 	= clean_input($_POST["F_BILLER_P_NO"]);
	$f_checker_no 	= clean_input($_POST["F_CHECKER_NO"]);
	$f_bill_date 	= clean_input($_POST["F_BILL_DATE"]);
	$f_remark		= clean_input($_POST["F_REMARK"]);
	
	//商家的信息，前台给的  跟海关电商系统编号相同的处理方式
	$custname   	= clean_input($_POST['CUSTNAME']);
	$linkman 		= clean_input($_POST['LINKMAN']);
	$tel 			= clean_input($_POST['TEL']);
	
	//运输的相关信息
	$deliver_no 	= clean_input($_POST["DELIVER_NO"]);
	$deliver_name 	= clean_input($_POST["DELIVER_NAME"]);
	$deliver_time 	= clean_input($_POST["DELIVER_TIME"]);
	$arrive_time 	= clean_input($_POST["ARRIVE_TIME"]);
	
	$qty_all = 0;
	$unit = clean_input($_POST['UNIT']);

	
	//获取前台传的采购商品
	$pur_product=clean_input($_POST["PUR_DETAIL"]);
	// var_dump($pur_product);
	foreach ($pur_product as $product) {
		$qty_all = $qty_all + clean_input($product['F_QTY']);
	}

	//接口参数拼接
	//1.拼接head
	$head = array();
	$head['fbilltype'] = "采购通知单";
	$head['faccountno'] = $f_account_no;
	$head['ferporderbillno'] = $f_erp_order_bill_no;
	$head['ferpbillno'] = $f_erp_bill_no;
	$head['fcustno'] = $f_cust_no;
	$head['fstockinno'] = "01";
	$head['fstockoutno'] = "";
	$head['fbillerno'] = $f_biller_no;
	$head['fbillrepno'] = $f_biller_p_no;
	$head['fcheckerno'] = $f_checker_no;
	$head['fbilldate'] = $f_bill_date." ".date("h:i:s");
	$head['fremark'] = $f_remark;
	$head['custname'] = $custname;
	$head['linkman'] = $linkman;
	$head['tel'] = $tel;
	$head['deliverno'] = $deliver_no;
	$head['delivername'] = $deliver_name;
	$head['delivertime'] = $deliver_time;
	$head['arrivtime'] = $arrive_time;
	$head['qty'] = ''.$qty_all.'';
	$head['unit'] = $unit;
	//2.拼接detail
	$detail = array();
	$count = 0;
	foreach ($pur_product as $product) {
		$product_p = array();
		$product_p['ficno'] = $f_account_no.".".clean_input($product['F_ICNO']);
		$product_p['funit'] = clean_input($product['F_UNIT']);
		$product_p['fqty'] = clean_input($product['F_PRICE']);
		$product_p['fprice'] = clean_input($product['F_QTY']);
		$product_p['famount'] = clean_input($product['F_AMOUNT']);
		$product_p['fprodate'] = clean_input($product['F_PRO_DATE']);
		$product_p['foutdate'] = clean_input($product['F_OUT_DATE']);
		$product_p['fblockno'] = clean_input($product['F_BLOCK_NO']);
		$product_p['fremarkdtail'] = clean_input($product['F_REMARK_DTAIL']);
		$detail['list'][$count] = $product_p;
		$count++;
	}
	//3.拼接data
	$data = array();
	$data['head'] = $head;
	$data['detail'] = $detail;
	//4.拼接json
	$json_arr = array();
	$json_arr['action'] = "billfromerptowms";
	$json_arr['data'] = $data;

    //post
	$key = "impltest";
	$method = "sendInOrder";
	$json = json_encode($json_arr, JSON_UNESCAPED_UNICODE);
	$requesttime = date("Y-m-d h:i:s");
	$sign = md5($json.$key.$requesttime);
	$head['key'] = "test";
	$head['method'] = $method;
	$head['json'] = $json;
	$head['requesttime'] = $requesttime;
	$head['sign'] = $sign;
	$url = XIYONG_URL_ADDRESS;
	$result_post = send_post($url, $head);
	$result_arr = json_decode($result_post, true);
	$result = $result_arr['Result'];
	$result_msg = $result_arr['ErrMessage'];
	// echo $result_msg;
	//存储到本地数据库
	//存储采购单的外部数据
	if($result == "0"){
		$conn = mysql_open();
		//事务开始
		mysqli_query($conn, "BEGIN");
		if($deliver_time == "") $deliver_time = 'null';
		// else $deliver_time = "'".$deliver_time."'";
		if($arrive_time == "") $arrive_time = 'null';
		// else $arrive_time = "'".$arrive_time."'";
	    $insert_purchase_sql = "insert into xiyong_purchase(f_account_no,f_erp_order_bill_no,f_erp_bill_no,f_cust_no,
	    	f_biller_no,f_biller_p_no,f_checker_no,f_bill_date, f_remark,
		    custname, linkman, tel, deliver_no,deliver_name,
		    deliver_time,arrive_time,qty,unit)
			values('$f_account_no', '$f_erp_order_bill_no', '$f_erp_bill_no', '$f_cust_no',
	    	'$f_biller_no', '$f_biller_p_no', '$f_checker_no', '$f_bill_date', '$f_remark',
		    '$custname', '$linkman', '$tel', '$deliver_no', '$deliver_name',
		    $deliver_time, $arrive_time, '$qty_all', '$unit')";
		$insert_purchase_query = mysqli_query($conn, $insert_purchase_sql);
		// echo $insert_purchase_sql;
		$flag = true;
		//存储采购单里面的商品信息
		foreach ($pur_product as $product){
			$f_icno 	= clean_input($product['F_ICNO']);
			$f_unit 	= clean_input($product['F_UNIT']);
			$f_price 	= clean_input($product['F_PRICE']);
			$f_qty 		= clean_input($product['F_QTY']);
			$f_amount 	= clean_input($product['F_AMOUNT']);
			$f_pro_date = clean_input($product['F_PRO_DATE']);
			$f_out_date = clean_input($product['F_OUT_DATE']);
			$f_block_no = clean_input($product['F_BLOCK_NO']);
			$f_remark_dtail = clean_input($product['F_REMARK_DTAIL']);

			if($f_amount == "") $f_amount = 'null';
			if($f_pro_date == "") $f_pro_date = 'null';
			// else $f_pro_date = "'".$f_pro_date."'";
			if($f_out_date == "") $f_out_date = 'null';
			// else $f_out_date = "'".$f_out_date."'";
 			$insert_product_sql = "insert into xiyong_purchase_product(f_erp_bill_no,f_icno,f_unit,f_price,f_qty,
				f_amount,f_pro_date,f_out_date,f_block_no,f_remark_dtail)
				values('$f_erp_bill_no', '$f_icno', '$f_unit', $f_price, '$f_qty',
				$f_amount, $f_pro_date, $f_out_date, '$f_block_no', '$f_remark_dtail')";
			$insert_product_query = mysqli_query($conn, $insert_product_sql);
			// echo $insert_product_sql."</br>";
			$flag = $flag & $insert_product_query;
		}
		if($insert_purchase_query && $flag){
			//事务提交
			mysqli_query($conn, "COMMIT");
			$response['error_code'] = SUCCESS;
			$response['error_msg'] = "成功！";
		}else{
			//事务回滚
			mysqli_query($conn, "ROLLBACK");
			if(!$insert_purchase_query){
				$response['error_code'] = FAILED;
				$response['error_msg'] = "采购单数据有误，请验证数据！";
			}
			else if(!$flag){
				$response['error_code'] = FAILED;
				$response['error_msg'] = "采购单商品数据有误，请验证数据！";
			}else{
				$response['error_code'] = FAILED;
				$response['error_msg'] = "存储失败，请验证数据！";
			}
			
		}
		//事务结束
		mysqli_query($conn, "END");
		mysqli_close($conn);
	}else if($result == "1"){
		$response['error_code'] = FAILED;
		$response['error_msg'] = "发送失败，".$result_msg;
	}
	else{
		$response['error_code'] = FAILED;
		$response['error_msg'] = "发送失败，西永仓库不响应我~";
	}
}else{
    $response['error_code'] = TOKEN_CHECK_FAILED;
	$response['error_msg'] = "权限认证失败！";
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>