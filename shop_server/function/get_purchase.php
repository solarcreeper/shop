<?php
require_once("settings.php");
require_once("mysql.php");
require_once("send.php");
/*
 * @params key 				固定值，测试环境为test
 * @params secret 			数字签名密钥
 * $params tzh				账套号
 * @params f_erp_bill_no 	采购单号
 */
// $key = "test";
// $secret = "impltest";
// $tzh = "999";
// $f_erp_bill_no = "A0000051571";
// var_dump( get_purchase($key, $secret, $tzh, $f_erp_bill_no));
// var_dump( get_purchase($key, $secret, $tzh, $f_erp_bill_no, "1"));

function get_purchase($key, $secret, $tzh, $f_erp_bill_no, $is_syc=null){
	$requesttime = date("Y-m-d h:i:s");
	$bill_no = $tzh.".".$f_erp_bill_no;
	$sign = md5($bill_no.$secret.$requesttime);
	$data['key'] = $key;
	$data['method'] = "InOrderType";
	$data['json'] = $bill_no;
	$data['requesttime'] = $requesttime;
	$data['sign'] = $sign;
	$url = XIYONG_URL_ADDRESS;
	$result_post = send_post($url, $data);
	// echo $result_post;
	$result_post = json_decode($result_post, true);
	$result = $result_post['Result'];
	$err_msg = json_decode(urldecode($result_post['ErrMessage']), true);
	// var_dump($err_msg);
	// echo $result;
	$response = array();
	if($result == "0"){
		$conn = mysql_open();
		if($is_syc == null){
			//更新数据库使按钮可点击
			$update_flag_sql = "update xiyong_purchase set flag = 0 where f_erp_bill_no = '$f_erp_bill_no'";
			$update_flag_query = mysqli_query($conn, $update_flag_sql);
			$response['error_code'] = SUCCESS;
			$response['error_msg'] = "成功！";
		}else{
			$check_flag_sql = "select flag from xiyong_purchase where f_erp_bill_no = '$f_erp_bill_no'";
			$check_flag_query = mysqli_query($conn, $check_flag_sql);
			$check_result = mysqli_fetch_object($check_flag_query)->flag;
			if($check_result == "0"){
				$detail = $err_msg['data']['detial']['list'];
				// var_dump($detail);
				//事务开始
				mysqli_query($conn, "BEGIN");
				$flag = true;
				foreach ($detail as $product) {
					$medicine_id = $product['medicine_id'];
					$index = strpos($medicine_id, ".") + 1;
					$sku = substr($medicine_id, $index );
					$qty = $product['m_sqty'];
					// echo $sku.":".$qty."</br>";
					$update_stock_sql = "update stock set total_stock = total_stock + '$qty', availble_stock = availble_stock + '$qty' where sku = '$sku'";
					$update_stock_query = mysqli_query($conn, $update_stock_sql);
					$flag = $flag & $update_stock_query;
				}
				$update_flag_sql1 = "update xiyong_purchase set flag = 1 where f_erp_bill_no = '$f_erp_bill_no'";
				$update_flag_query1 = mysqli_query($conn, $update_flag_sql1);
				if($flag && $update_flag_query1){
					//事务提交
					mysqli_query($conn, "COMMIT");
					$response['error_code'] = SUCCESS;
					$response['error_msg'] = "成功！";
				}else{
					//事务回滚
					mysqli_query($conn, "ROLLBACK");
					$response['error_code'] = FAILED;
					$response['error_msg'] = "库存更新失败！";
				}
				//事务结束
				mysqli_query($conn, "END"); 
			}
			if($check_result == "-1"){
				$response['error_code'] = FAILED;
				$response['error_msg'] = "采购单未入库！";
			}
			if($check_result == "1"){
				$response['error_code'] = FAILED;
				$response['error_msg'] = "库存已更新！";
			}
		}
		mysqli_close($conn);
	}
	else if($result == "1"){
		$response['error_code'] = FAILED;
		$response['error_msg'] = "订单未发送到仓库！";
	}else{
		$response['error_code'] = FAILED;
		$response['error_msg'] = "服务器拒绝访问！";
	}
	return $response;
}
?>