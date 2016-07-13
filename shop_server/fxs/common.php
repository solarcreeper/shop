<?php
/** 
 *这是一个什么文件 
 * 
 *此文件程序用来做什么的（详细说明，可选。）。 
 * @author      刘鑫
 * @version		1.0	    
 * @since       1.0
 * 
 * @function change_goods_price 修改商品价格
 * 
 * 
 */  

define("MYSQL_PATH", "../function/mysql.php");
require_once(MYSQL_PATH);

/* find_user
 * 判断用户名是否存在
 * @param string $username 用户名
 * @return boolean         存在返回true，不存在返回
 */
function find_user($username){
	$link = mysql_open();
	$query = "select * from user where username='$username'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_assoc($result);
	if(count($row) > 0){
		return true;
	}else{
		return false;
	}
	mysqli_close($link);
}

function find_distributor($username){
	$link = mysql_open();
	$query = "select * from user where username='$username' and is_admin=0";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_assoc($result);
	if(count($row) > 0){
		return true;
	}else{
		return false;
	}
	mysqli_close($link);
}

/*
 * @param void
 * @return array[][5] 商品列表
 */
function get_goods_list(){
	$cols = 5;
	
	$data = array();
	$goods = array();
	$link = mysql_open();
	mysqli_query($link, "set names utf8");
	
	$query = "select sku, goods_name from ciq_sku_info;";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_assoc($result)){
		$goods[] = $row;
	}
	$query = "select sku, goods_name from common_sku_info;";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_assoc($result)){
		$goods[] = $row;
	}
	
	$row = array();
	for ($i=0; $i < count($goods); $i++) { 
		$row[] = "<input type='checkbox' name='goods_list[]' value='".$goods[$i]["sku"]."'/>".$goods[$i]['goods_name'];
		if((($i+1) % $cols == 0) && $i != count($goods)-1){
			$data[] = $row;
			$row = array();
		}
	}
	for ($i=0; $i < $cols; $i++) { 
		if(!isset($row[$i])){
			$row[$i] = " ";
		}
	}
	
	$data[] = $row;
	mysqli_close($link);
	return $data;
}

/*
 * @param string $sku 商品货号
 * @return string 商品名称
 */
function get_goods_info_by_sku($sku){
	$link = mysql_open();
	mysqli_query($link, "set names utf8");
	$goods = array();
	$goods_name = "";
	$goods_price = "";
	$query = "select goods_name, price from ciq_sku_info where sku = '$sku'";
	$result = mysqli_query($link, $query);
	if($row = mysqli_fetch_assoc($result)){
		$goods_name = $row["goods_name"];
		$goods_price = $row["price"];
	}else{
		$query = "select goods_name, price from common_sku_info where sku = '$sku'";
		$result = mysqli_query($link, $query);
		if($row = mysqli_fetch_assoc($result)){
			$goods_name = $row["goods_name"];
			$goods_price = $row["price"];
		}
	}
	$goods["goods_name"] = $goods_name;
	$goods["price"] = $goods_price;
	mysqli_close($link);
	return $goods;
}

function get_user_pro_price($username, $sku_id){
	$link = mysql_open();
	mysqli_query($link, "set names utf8");
	$query = "select price from user_product where username='$username' and sku_id='$sku_id'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_assoc($result);
	return $row['price'];
}

/*
 * 详情
 */
function get_curr_goods_list($username){
	$cols = 5;
	
	$data = array();
	$goods = array();
	
	$link = mysql_open();
	mysqli_query($link, "set names utf8");
	
	$query = "select sku_id, price from user_product where username='$username';";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_assoc($result)){
		$goods_temp = get_goods_info_by_sku($row["sku_id"]);
		$row["goods_name"] = $goods_temp["goods_name"];
		$goods[] = $row;
	}
	
	$row = array();
	for ($i=0; $i < count($goods); $i++) { 
		$row[] = "<span class='span_goods_name'>".$goods[$i]['goods_name']."</span>"."<img class='delete' src='images/delete_16px.png' alt='".$goods[$i]['sku_id']."' />";
		if((($i+1) % $cols == 0) && $i != count($goods)-1){
			$data[] = $row;
			$row = array();
		}
	}
	for ($i=0; $i < $cols; $i++) { 
		if(!isset($row[$i])){
			$row[$i] = " ";
		}
	}
	
	$data[] = $row;
	mysqli_close($link);
	return $data;
}

/*
 * 搜索下拉
 */
function get_goods_by_goods_name($goods_name){
	$link = mysql_open();
	mysqli_query($link, "set names utf8");
	
	$data = array();
	$goods = array();
	
	$query = "select sku, goods_name from ciq_sku_info where goods_name like '%$goods_name%';";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_assoc($result)){
		$goods["id"] = $row["sku"];
		$goods["name"] = $row["goods_name"];
		$data[] =  $goods;
	}
	$query = "select sku, goods_name from common_sku_info where goods_name like '%$goods_name%';";
	$result = mysqli_query($link, $query);
	while($row = mysqli_fetch_assoc($result)){
		$goods["id"] = $row["sku"];
		$goods["name"] = $row["goods_name"];
		$data[] =  $goods;
	}
	
	mysqli_close($link);
	return $data;
}

function get_username($username){
	$link = mysql_open();
	mysqli_query($link, "set names utf8");
	
	$data = array();
	$user = array();
	
	$query = "select user_id, username from user where username like '%$username%' and is_admin=0;";
	$result = mysqli_query($link, $query);
	while($row = @mysqli_fetch_assoc($result)){
		$user["id"] = $row["user_id"];
		$user["name"] = $row["username"];
		$data[] =  $user;
	}
	
	mysqli_close($link);
	return $data;
}

/*
 * @param string $username 用户名, int $interval_type 间隔类型 0-天 1-周 2-月 3-季 4-年, int $x_count 需要显示的数目
 * @return array[] 销售总额
 */
function get_total_fee_statistic_data($username, $interval_type, $x_count){
	$link = mysql_open();
	mysqli_query($link, "set names utf8");
	$data = array();
	date_default_timezone_set("PRC");
	
	$x_data = array();
	
	$start = "";
	$end = "";
	
	for ($i=0; $i < $x_count; $i++) {
		switch ($interval_type) {
			case 0:
				if($i == 0)
					$end = date("Y-m-d");
				$start = date("Y-m-d", strtotime("$end -1 day"));
				$end = $start;
				break;
			case 1:
				if($i == 0){
					$curr_week = date("w");
					if($curr_week == 0){
						$curr_week = 6;
					}else{
						$curr_week--;
					}
					$now = date("Y-m-d");
					$start = date("Y-m-d", strtotime("$now -$curr_week day"));
				}
				$end = date("Y-m-d", strtotime("$start -1 day"));
				$start = date("Y-m-d", strtotime("$end -6 day"));
				break;
			case 2:
				if($i == 0){
					$start = date("Y-m-01");
				}
				$end = date("Y-m-d", strtotime("$start -1 day"));
				$start = date("Y-m-01", strtotime("$end"));
				break;
			case 3:
				if($i == 0){
					$now_m = date("m");
					if($now_m < 4){
						$start = date("Y-01-01");
					}else if($now_m < 7){
						$start = date("Y-04-01");
					}else if($now_m < 10){
						$start = date("Y-07-01");
					}else{
						$start = date("Y-10-01");
					}
				}
				
				$end = date("Y-m-d", strtotime("$start -1 day"));
				$start = date("Y-m-01", strtotime("$end -2 month"));
				break;
			case 4:
				if($i == 0){
					$start = date("Y-01-01");
				}
				$end = date("Y-m-d", strtotime("$start -1 day"));
				$start = date("Y-01-01", strtotime($end));
				break;
		}

		$query = "select sum(goods_fee) as fee from order_payment_info where owner='$username' and xiyong_bill_date BETWEEN  '$start' and '$end'";
		$result = mysqli_query($link, $query);
		$fee = mysqli_fetch_assoc($result);
		if($fee == null){
			$data[] = 0;
		}else{
			$data[] = $fee["fee"];
		}
	}
	mysqli_close($link);
	return array_reverse($data);
} 

function get_total_orders_statistic_data($username, $interval_type, $x_count){
	$link = mysql_open();
	mysqli_query($link, "set names utf8");
	$data = array();
	date_default_timezone_set("PRC");
	
	$x_data = array();
	
	$start = "";
	$end = "";
	
	for ($i=0; $i < $x_count; $i++) {
		switch ($interval_type) {
			case 0:
				if($i == 0)
					$end = date("Y-m-d");
				$start = date("Y-m-d", strtotime("$end -1 day"));
				$end = $start;
				break;
			case 1:
				if($i == 0){
					$curr_week = date("w");
					if($curr_week == 0){
						$curr_week = 6;
					}else{
						$curr_week--;
					}
					$now = date("Y-m-d");
					$start = date("Y-m-d", strtotime("$now -$curr_week day"));
				}
				$end = date("Y-m-d", strtotime("$start -1 day"));
				$start = date("Y-m-d", strtotime("$end -6 day"));
				break;
			case 2:
				if($i == 0){
					$start = date("Y-m-01");
				}
				$end = date("Y-m-d", strtotime("$start -1 day"));
				$start = date("Y-m-01", strtotime("$end"));
				break;
			case 3:
				if($i == 0){
					$now_m = date("m");
					if($now_m < 4){
						$start = date("Y-01-01");
					}else if($now_m < 7){
						$start = date("Y-04-01");
					}else if($now_m < 10){
						$start = date("Y-07-01");
					}else{
						$start = date("Y-10-01");
					}
				}
				
				$end = date("Y-m-d", strtotime("$start -1 day"));
				$start = date("Y-m-01", strtotime("$end -2 month"));
				break;
			case 4:
				if($i == 0){
					$start = date("Y-01-01");
				}
				$end = date("Y-m-d", strtotime("$start -1 day"));
				$start = date("Y-01-01", strtotime($end));
				break;
		}

		$query = "select count(*) as c from order_payment_info where owner='$username' and xiyong_bill_date BETWEEN  '$start' and '$end'";
		$result = mysqli_query($link, $query);
		$count = mysqli_fetch_assoc($result);
		if($count == null){
			$data[] = 0;
		}else{
			$data[] = $count["c"];
		}
	}
	mysqli_close($link);
	return array_reverse($data);
}

/*
 * 
 * 
 * 
 */
function get_x_data($interval_type, $x_count){
	date_default_timezone_set("PRC");
	
	$x_data = array();
	$start = "";
	$end = "";
	
	for ($i=0; $i < $x_count; $i++) {
		switch ($interval_type) {
			case 0:
				if($i == 0)
					$end = date("Y-m-d");
				$start = date("Y-m-d", strtotime("$end -1 day"));
				$end = $start;
				break;
			case 1:
				if($i == 0){
					$curr_week = date("w");
					if($curr_week == 0){
						$curr_week = 6;
					}else{
						$curr_week--;
					}
					$now = date("Y-m-d");
					$start = date("Y-m-d", strtotime("$now -$curr_week day"));
				}
				$end = date("Y-m-d", strtotime("$start -1 day"));
				$start = date("Y-m-d", strtotime("$end -6 day"));
				break;
			case 2:
				if($i == 0){
					$start = date("Y-m-01");
				}
				$end = date("Y-m-d", strtotime("$start -1 day"));
				$start = date("Y-m-01", strtotime("$end"));
				break;
			case 3:
				if($i == 0){
					$now_m = date("m");
					if($now_m < 4){
						$start = date("Y-01-01");
					}else if($now_m < 7){
						$start = date("Y-04-01");
					}else if($now_m < 10){
						$start = date("Y-07-01");
					}else{
						$start = date("Y-10-01");
					}
				}
				
				$end = date("Y-m-d", strtotime("$start -1 day"));
				$start = date("Y-m-01", strtotime("$end -2 month"));
				break;
			case 4:
				if($i == 0){
					$start = date("Y-01-01");
				}
				$end = date("Y-m-d", strtotime("$start -1 day"));
				$start = date("Y-01-01", strtotime($end));
				break;
		}
			$x_data[] = $start;
	}
	return array_reverse($x_data);
}

/**
 * change_goods_price
 * 修改商品价格
 * 
 * @author 刘鑫
 * @access public
 * @param string $sku 商品编号
 * @param string $username 分销商名称
 * @param string $goods_price 商品新价格
 * @since 1.0
 * @return boolean 成功true 失败false
 */
function change_goods_price($sku, $username, $goods_price){
	$link = mysql_open();
	mysqli_query($link, "set names utf8");
	$data = array();
	$query = "update user_product set price=$goods_price where username='$username' and sku_id='$sku'";
	$result = mysqli_query($link, $query);
	mysqli_close($link);
	return $result;
}

function export_order($username){
    ob_end_clean();
    header("Content-type: text/html; charset=utf-8");
    require_once 'Classes/PHPExcel.php';  
    require_once'Classes/PHPExcel/Writer/Excel2007.php';
    $objPHPExcel = new PHPExcel();
    
	$data = array();
	$data_row = array();
	
	$link = mysql_open();
	mysqli_query($link, "set names utf8");
	$query = "select * from order_payment_info where owner='$username'";
	$result = mysqli_query($link, $query);
	while ($row = mysqli_fetch_assoc($result)) {
		$original_order_no = $row['original_order_no'];
		$query = "select * from order_goods_info where original_order_no='$original_order_no';";
		$result_1 = mysqli_query($link, $query);
		for ($i=1; $row_1 = mysqli_fetch_assoc($result_1) ; $i++) {
			if($i == 1){
				$data_row[] = $row['original_order_no'];
				$data_row[] = $row['receiver_name'];
				$data_row[] = $row['xiyong_province'];
				$data_row[] = $row['xiyong_city'];
				$data_row[] = $row['xiyong_area'];
				$data_row[] = $row['receiver_address'];
				$data_row[] = $row['xiyong_zip'];
				$data_row[] = $row['receiver_tel'];
				$data_row[] = $row['receiver_id_no'];
				$data_row[] = $row['order_memo'];
				$data_row[] = $row['pay_memo'];
				$data_row[] = $row['xiyong_bill_date'];
				$data_row[] = $row['transport_fee'];
				$data_row[] = $row['pay_amount'];
				$data_row[] = $i;
				$data_row[] = $row_1['sku'];
				$goods_info = get_goods_info_by_sku($row_1['sku']);
				$data_row[] = $goods_info['goods_name'];
				$data_row[] = $row_1['goods_spec'];
				$data_row[] = $row_1['price'];
				$data_row[] = $row_1['qty'];
			}else{
				$data_row[] = '';
				$data_row[] = '';
				$data_row[] = '';
				$data_row[] = '';
				$data_row[] = '';
				$data_row[] = '';
				$data_row[] = '';
				$data_row[] = '';
				$data_row[] = '';
				$data_row[] = '';
				$data_row[] = '';
				$data_row[] = '';
				$data_row[] = '';
				$data_row[] = '';
				$data_row[] = $i;
				$data_row[] = $row_1['sku'];
				$goods_info = get_goods_info_by_sku($row_1['sku']);
				$data_row[] = $goods_info['goods_name'];
				$data_row[] = $row_1['goods_spec'];
				$data_row[] = $row_1['price'];
				$data_row[] = $row_1['qty'];
			}
			$data[] = $data_row;
			$data_row = array();
		}
	}
	mysqli_close($link);
	
	/*--------------设置表头信息------------------*/
	
	$objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', '原始订单号')
	            ->setCellValue('B1', '收货人姓名')
	            ->setCellValue('C1', '省份')
	            ->setCellValue('D1', '城市')
	            ->setCellValue('E1', '区县')
				->setCellValue('F1', '收货人地址')
				->setCellValue('G1', '邮编')
				->setCellValue('H1', '电话')
				->setCellValue('I1', '身份证号码')
				->setCellValue('J1', '备注')
				->setCellValue('K1', '支付备注')
				->setCellValue('L1', '下单时间')
				->setCellValue('M1', '运费')
				->setCellValue('N1', '商品总额')
				->setCellValue('O1', '多个商品排序')
				->setCellValue('P1', 'SKU')
				->setCellValue('Q1', '商品名称')
				->setCellValue('R1', '商品详情')
				->setCellValue('S1', '价格')
				->setCellValue('T1', '数量');
	
	for($y=ord('A');$y<= ord('T');$y++){
		$objPHPExcel->getActiveSheet()->getColumnDimension(chr($y))->setWidth(12);
		$objPHPExcel->getActiveSheet()->getStyle(chr($y))->getNumberFormat()
					->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
    }
	/*--------------开始从数据库提取信息插入Excel表中------------------*/
	for ($i=2; $i < count($data) + 2; $i++) {
		$j = 0;
	    $objPHPExcel->setActiveSheetIndex(0)
	    	        ->setCellValueExplicit("A".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("B".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("C".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("D".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("E".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("F".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("G".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("H".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("I".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("J".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("K".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("L".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("M".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("N".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("O".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("P".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("Q".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("R".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("S".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING)
	    	        ->setCellValueExplicit("T".$i, $data[$i-2][$j++], PHPExcel_Cell_DataType::TYPE_STRING);
	}
	/*--------------下面是设置其他信息------------------*/
	$objPHPExcel->getActiveSheet()->setTitle('order');      //设置sheet的名称
    $filename = "order.xls";
    $encoded_filename = urlencode($filename);//设置文件名为中文格式
	$objPHPExcel->setActiveSheetIndex(0);    //设置sheet的起始位置
	/*--------------定义输出位置------------------*/
	header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
    header("Content-Type:application/force-download");
    header("Content-Type:application/vnd.ms-execl");
    header("Content-Type:application/octet-stream");
    header("Content-Type:application/download");
    header('Content-Disposition:attachment;filename="' . $encoded_filename . '"');//设置文件的名称
    header("Content-Transfer-Encoding:binary");                        
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');//通过PHPExcel_IOFactory的写函数将上面数据写出来
	$objWriter->save('php://output');
    exit;     
}

/**
 * get_owner_and_fee_statistic
 * 活跃度分析-销售总额
 * 
 * @author 刘鑫
 * @access public
 * @param date $start 开始时间
 * @param date $end 结束时间
 * @param int $limit 显示数目
 * @param int $order_by 排序方式 0-升序 1-降序
 * @since 1.0
 * @return boolean 成功true 失败false
 */
function get_owner_and_fee_statistic($start, $end, $limit, $order_by){
	$order = $order_by == 0 ? "asc" : "desc";
	$link = mysql_open();
	mysqli_query($link, "set names utf8");
	$query = "select owner, sum(goods_fee) as fee from order_payment_info where xiyong_bill_date between '$start' and '$end' group by owner order by fee $order limit $limit";
	$result = mysqli_query($link, $query);
	$data = array();
	$series = array();
	$row = array();
	$owner = array();
	$fee = array();
	while($row = mysqli_fetch_assoc($result)){
		$owner[] = $row["owner"];
		$fee[] = $row["fee"];
	}
	$data["x_axis"] = $owner;
	
	$row["name"] = "分销商";
	$row["data"] = $fee;
	$series[] = $row;
	$data["series"] = $series;
	return $data;
}

/**
 * get_owner_and_fee_statistic
 * 活跃度分析-订单总数
 * 
 * @author 刘鑫
 * @access public
 * @param date $start 开始时间
 * @param date $end 结束时间
 * @param int $limit 显示数目
 * @param int $order_by 排序方式 0-升序 1-降序
 * @since 1.0
 * @return boolean 成功true 失败false
 */
function get_owner_and_orders_statistic($start, $end, $limit, $order_by){
	$order = $order_by == 0 ? "asc" : "desc";
	$link = mysql_open();
	mysqli_query($link, "set names utf8");
	$query = "select owner, count(goods_fee) as orders from order_payment_info where xiyong_bill_date between '$start' and '$end' group by owner order by orders $order limit $limit";
	$result = mysqli_query($link, $query);
	$data = array();
	$series = array();
	$row = array();
	$owner = array();
	$orders = array();
	while($row = mysqli_fetch_assoc($result)){
		$owner[] = $row["owner"];
		$orders[] = $row["orders"];
	}
	$data["x_axis"] = $owner;
	
	$row["name"] = "分销商";
	$row["data"] = $orders;
	$series[] = $row;
	$data["series"] = $series;
	return $data;
}

?>