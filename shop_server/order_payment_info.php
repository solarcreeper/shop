<?php
require_once("./function/settings.php");
require_once("./function/mysql.php");
require_once("./function/send.php");
require_once("./function/check.php");
$token = clean_input($_POST['TOKEN']);
$username = clean_input($_POST['USERNAME']);
$is_import = clean_input($_GET['IS_IMPORT']);

$response = array();
// $check_result = check_token($username, $token);
// echo $check_result;
// $username = "yehongjiang";
// $check_result = ACCESS_ADMIN;
if( $check_result != ACCESS_DENAIL){
	//更新token时间
	update_token($username, $token);

	$customs_code = clean_input($_POST['CUSTOMS_CODE']);
	$biz_type_code = clean_input($_POST['BIZ_TYPE_CODE']);
	$original_order_no = clean_input($_POST['ORIGINAL_ORDER_NO']);
	$eshop_ent_code = clean_input($_POST['ESHOP_ENT_CODE']);
	$eshop_ent_name = clean_input($_POST['ESHOP_ENT_NAME']);
	$desp_arri_country_code = clean_input($_POST['DESP_ARRI_COUNTRY_CODE']);
	$ship_tool_code = clean_input($_POST['SHIP_TOOL_CODE']);
	$receiver_id_no = clean_input($_POST['RECEIVER_ID_NO']);
	$receiver_name = clean_input($_POST['RECEIVER_NAME']);
	$receiver_address = clean_input($_POST['RECEIVER_ADDRESS']);
	$receiver_tel = clean_input($_POST['RECEIVER_TEL']);
	$sortline_id = clean_input($_POST['SORTLINE_ID']);
	$transport_fee = clean_input($_POST['TRANSPORT_FEE']);
	$check_type = clean_input($_POST['CHECK_TYPE']);

	$payment_id_no = clean_input($_POST['PAYMENT_ID_NO']);
	$payment_name = clean_input($_POST['PAYMENT_NAME']);
	$payment_tel= clean_input($_POST['PAYMENT_TEL']);
	$payment_ent_code = clean_input($_POST['PAYMENT_ENT_CODE']);
	$payment_ent_name = clean_input($_POST['PAYMENT_ENT_NAME']);
	$payment_no = clean_input($_POST['PAYMENT_NO']);
	$pay_amount = clean_input($_POST['PAY_AMOUNT']);
	$pay_memo = clean_input($_POST['PAY_MEMO']);
	$currency_code = clean_input($_POST['CURRENCY_CODE']);

	$order_detail = clean_input($_POST['ORDER_DETAIL']);

	//保存西永仓库数据
    $xiyong_bill_type = clean_input($_POST['XIYONG_BILL_TYPE']);
	$xiyong_acount_no = clean_input($_POST['XIYONG_ACOUNT_NO']);
    $xiyong_cust_no =clean_input($_POST['XIYONG_FCUST_NO']);
 	$xiyong_stock_in_no =clean_input($_POST['XIYONG_STOCK_IN_NO']);
    $xiyong_stock_out_no =clean_input($_POST['XIYONG_STOCK_OUT_NO']);
    $xiyong_biller_no =clean_input($_POST['XIYONG_BILLER_NO']);
    $xiyong_checker_no =clean_input($_POST['XIYONG_CHECKER_NO']);
    $xiyong_bill_date = clean_input($_POST['XIYONG_BILL_DATE']);
    $xiyong_remark =clean_input($_POST['XIYONG_REMARK']);
    $xiyong_discharge_place =clean_input($_POST['XIYONG_DISCHARGE_PLACE']);
    $xiyong_deliver_place = clean_input($_POST['XIYONG_DELIVER_PLACE']);
    //省市县的编码
    $xiyong_province = clean_input($_POST['XIYONG_PROVINCE']);
    $xiyong_city = clean_input($_POST['XIYONG_CITY']);
    $xiyong_area = clean_input($_POST['FC_AREANAME']);
    $xiyong_province_code = clean_input($_POST['XIYONG_PROVINCE_CODE']);
    $xiyong_city_code = clean_input($_POST['XIYONG_CITY_CODE']);
    $xiyong_area_code = clean_input($_POST['XIYONG_AREA_CODE']);
    
    $xiyong_zip = clean_input($_POST['XIYONG_ZIP']);
    $xiyong_type = clean_input($_POST['XIYONG_TYPE']);
    $xiyong_bjflag = clean_input($_POST['XIYONG_BJFLAG']);
    $xiyong_bjamt = clean_input($_POST['XIYONG_BJAMT']);

	$conn = mysql_open();
	//事务开始
	mysqli_query($conn, "BEGIN");

	$delOrder = "delete from order_payment_info where original_order_no = '$original_order_no'";
	$queryDel = mysqli_query($conn, $delOrder);
	$delProduct = "delete from order_goods_info where original_order_no = '$original_order_no'";
	$queryDel1 = mysqli_query($conn, $delProduct); 

	$flag = true;
	$check_sku = true;
	$total_tax_fee = 0;
	$total_goods_fee = 0;
	foreach ($order_detail as $product) {
		$sku = $product['SKU'];
		if($sku != ""){
			$check_sku_sql1 = "select sku from ciq_sku_info where sku = '$sku'";
			$check_sku_query1 = mysqli_query($conn, $check_sku_sql1);
			$check_sku_result1 = mysqli_fetch_object($check_sku_query1)->sku;
			$check_sku_sql2 = "select sku from common_sku_info where sku = '$sku'";
			$check_sku_query2 = mysqli_query($conn, $check_sku_sql2);
			$check_sku_result2 = mysqli_fetch_object($check_sku_query2)->sku;
			if($check_sku_result1 == "" && $check_sku_result2 == ""){
				$check_sku = false;
			}else{
				//查询税率
				$tax_rate_sql = "select tax_rate from ciq_sku_info where sku = '$sku'";
				$tax_rate_query = mysqli_query($conn, $tax_rate_sql);
				$tax_rate = mysqli_fetch_object($tax_rate_query)->tax_rate;
				if($tax_rate == "") $tax_rate = 0;

				$goods_spec = $product['GOODS_SPEC'];
				$currency_code = $product['CURRENCY_CODE'];
				$price = $product['PRICE'];
				$qty = $product['QTY'];
				$goods_fee = $price * $qty;
				$tax_fee = $goods_fee * $tax_rate;
				//计算总税费&总价
				$total_tax_fee = $total_tax_fee + $tax_fee;
				$total_goods_fee = $total_goods_fee + $goods_fee;

				$xiyong_f_unit = $product['FUNIT'];
				$xiyong_f_remark_detail = $product['FREMARKDTAIL'];
				//避免前端因删除某个商品列表造成数组某个值为空时插入空数据
				$insertProduct = "insert into order_goods_info(original_order_no, sku, goods_spec, currency_code, price, qty, goods_fee,
				tax_fee, xiyong_f_unit, xiyong_f_remark_detail)
					values('$original_order_no', '$sku', '$goods_spec', '$currency_code', '$price', '$qty', '$goods_fee', 
				'$tax_fee', '$xiyong_f_unit', '$xiyong_f_remark_detail')";
				// echo $insertProduct;
				$queryProduct = mysqli_query($conn, $insertProduct);
				$flag = $flag & $queryProduct;
				if($is_import == "1"){
					$del_import_order_goods_sql = "delete from t_goods_data where sku = '$sku'";
					$del_import_order_goods_query = mysqli_query($conn, $del_import_order_goods_sql);
					$flag = $flag & $del_import_order_goods_query;
				}
			}
			
		}
	}

	//当税费小于50时免税
	if($total_tax_fee <= 50) $total_tax_fee = 0;
	if($xiyong_bjamt == "") $xiyong_bjamt = 'null';
	$inserOrder = "insert into order_payment_info(customs_code, biz_type_code, original_order_no, eshop_ent_code, eshop_ent_name, 
		desc_arri_country_code, ship_tool_code, receiver_id_no, receiver_name, receiver_address, 
		receiver_tel, goods_fee, tax_fee, sortline_id, transport_fee, check_type, 
		payment_id_no, payment_name, payment_tel, payment_ent_code, payment_ent_name, 
		payment_no, pay_amount, pay_memo, xiyong_bill_type, xiyong_acount_no,
		xiyong_cust_no, xiyong_stock_in_no, xiyong_stock_out_no, xiyong_biller_no, xiyong_checker_no, 
		xiyong_bill_date, xiyong_remark, xiyong_discharge_place, xiyong_deliver_place, xiyong_province, 
		xiyong_province_code, xiyong_city, xiyong_city_code, xiyong_area, xiyong_area_code, 
		xiyong_zip, xiyong_type, xiyong_bjflag, xiyong_bjamt, owner) 
			values('$customs_code', '$biz_type_code', '$original_order_no', '$eshop_ent_code', '$eshop_ent_name',
		'$desc_arri_country_code', '$ship_tool_code', '$receiver_id_no','$receiver_name', '$receiver_address', 
		'$receiver_tel', $total_goods_fee, $total_tax_fee, '$sortline_id', '$transport_fee', '$check_type',
		'$payment_id_no', '$payment_name', '$payment_tel', '$payment_ent_code', '$payment_ent_name',
		'$payment_no', '$pay_amount', '$pay_memo', '$xiyong_bill_type', '$xiyong_acount_no',
		'$xiyong_cust_no', '$xiyong_stock_in_no', '$xiyong_stock_out_no', '$xiyong_biller_no', '$xiyong_checker_no', 
		'$xiyong_bill_date', '$xiyong_remark', '$xiyong_discharge_place', '$xiyong_deliver_place', '$xiyong_province', 
		'$xiyong_province_code', '$xiyong_city', '$xiyong_city_code', '$xiyong_area', '$xiyong_area_code', 
		'$xiyong_zip', '$xiyong_type', '$xiyong_bjflag', $xiyong_bjamt, '$username')";
	$query = mysqli_query($conn, $inserOrder);
	// echo $inserOrder;
	$del_import_order_query = true;
	$not_imported = true;
	if($is_import == "1"){
		$check_imported_sql = "select original_order_no  from t_order_data where original_order_no = '$original_order_no'";
		$check_imported_query = mysqli_query($conn, $check_imported_sql);
		if(mysqli_num_rows($check_imported_query) == 0){
			$not_imported = false;
		}else{
			$del_import_order_sql = "delete from t_order_data where original_order_no = '$original_order_no'";
			// echo "del_import_order_query".$del_import_order_query."</br>";
			$del_import_order_query = mysqli_query($conn, $del_import_order_sql);
			$del_import_order_goods_sql = "delete from t_goods_data where original_order_no = '$original_order_no'";
			$del_import_order_query = $del_import_order_query & mysqli_query($conn, $del_import_order_goods_sql);
		}
	}
	if($check_sku && $query && $flag && $del_import_order_query && $not_imported){
		//冻结库存
		$flag_freeze = true;
		foreach ($order_detail as $product) {
			$sku = $product['SKU'];
			$qty = $product['QTY'];
			//避免前端因删除某个商品列表造成数组某个值为空时插入空数据；
			if($sku != ""){
				$freeze_sku_sql = "update stock set blocked_stock = blocked_stock + $qty, availble_stock = availble_stock - $qty where sku = '$sku'";
				$freeze_sku_query = mysqli_query($conn, $freeze_sku_sql);
				$flag = $flag & $freeze_sku_query;
			}
		}
		if($flag_freeze){
			//事务提交
			mysqli_query($conn, "COMMIT");
			$response['error_code'] = SUCCESS;
			$response['error_msg'] = "成功！";
		}else{
			//事务回滚
			mysqli_query($conn, "ROLLBACK");
			$response['error_code'] = FAILED;
			$response['error_msg'] = "冻结库存失败！";
		}
	}else{
		//事务回滚
		mysqli_query($conn, "ROLLBACK");
		if(!$check_sku){
			$response['error_code'] = FAILED;
			$response['error_msg'] = "订单商品未备案！";
		}
		else if(!$query){
			$response['error_code'] = FAILED;
			$response['error_msg'] = "订单存储失败！";
		}
		else if(!$flag){
			$response['error_code'] = FAILED;
			$response['error_msg'] = "订单商品存储失败！";
		}
		else if(!$del_import_order_query){
			$response['error_code'] = FAILED;
			$response['error_msg'] = "删除缓存失败！";
		}
		else if(!$not_imported){
			$response['error_code'] = FAILED;
			$response['error_msg'] = "订单已导入系统！";
		}else{
			$response['error_code'] = FAILED;
			$response['error_msg'] = "操作失败！";
		}
		
	}
	//事务结束
	mysqli_query($conn, "END");
	mysqli_close($conn);
}else{
	$response['error_code'] = TOKEN_CHECK_FAILED;
	$response['error_msg'] = "权限认证失败！";
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>