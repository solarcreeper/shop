<?php
require_once("settings.php");
require_once("mysql.php");
function send_order_xiyong($original_order_no,  $bar_code){
    $response = array();
    // echo $original_order_no;
    // echo $bar_code;
    $account = XIYONG_ACCOUNT;
    $url = XIYONG_URL_ADDRESS;
    $conn = mysql_open();
    $order_info_sql = "select xiyong_bill_type, xiyong_acount_no, xiyong_cust_no, xiyong_stock_in_no, xiyong_stock_out_no, 
                      xiyong_biller_no, xiyong_checker_no, xiyong_bill_date, xiyong_remark, xiyong_discharge_place, 
                      xiyong_deliver_place, receiver_name, xiyong_province, xiyong_province_code, xiyong_city,
                      xiyong_city_code, xiyong_area, xiyong_area_code, receiver_address, receiver_tel, 
                      xiyong_zip, xiyong_type, goods_fee, tax_fee, xiyong_bjflag, 
                      xiyong_bjamt from order_payment_info where original_order_no = '$original_order_no'";
    $order_info_query= mysqli_query($conn, $order_info_sql);

    $order_info = mysqli_fetch_object($order_info_query);

    $xiyong_bill_type = $order_info->xiyong_bill_type;
    $xiyong_acount_no = $order_info->xiyong_acount_no;
    $xiyong_cust_no = $order_info->xiyong_cust_no;
    $xiyong_stock_in_no = $order_info->xiyong_stock_in_no;
    $xiyong_stock_out_no = $order_info->xiyong_stock_out_no;

    $xiyong_biller_no = $order_info->xiyong_biller_no;
    $xiyong_checker_no = $order_info->xiyong_checker_no;
    $xiyong_bill_date = $order_info->xiyong_bill_date." ".date("h:i:s");
    $xiyong_remark = $order_info->xiyong_remark;
    $xiyong_discharge_place = $order_info->xiyong_discharge_place;

    $xiyong_deliver_place = $order_info->xiyong_deliver_place;
    $receiver_name = $order_info->receiver_name;
    $xiyong_province = $order_info->xiyong_province;
    $xiyong_province_code = $order_info->xiyong_province_code;
    $xiyong_city = $order_info->xiyong_city;

    $xiyong_city_code = $order_info->xiyong_city_code;
    $xiyong_area = $order_info->xiyong_area;
    $xiyong_area_code = $order_info->xiyong_area_code;
    $receiver_address = $order_info->receiver_address;
    $receiver_tel = $order_info->receiver_tel;

    $xiyong_zip = $order_info->xiyong_zip;  
    $xiyong_type = $order_info->xiyong_type;
    $goods_fee = $order_info->goods_fee;
    $tax_fee = $order_info->tax_fee;
    $xiyong_bjflag = $order_info->xiyong_bjflag;
    $xiyong_bjamt = $order_info->xiyong_bjamt;

    $xingyong_erp_order_bill_no = $original_order_no;
    $xiyong_erp_bill_bo = $xiyong_acount_no.".".$original_order_no;

    $order_detail_sql = "select sku, xiyong_f_unit, qty, price, xiyong_f_remark_detail
                        from order_goods_info where original_order_no = '$original_order_no'";
    $order_detail_query = mysqli_query($conn, $order_detail_sql);

    //接口参数拼接
    //1.拼接head
    $head = array();
    $head['fbilltype'] = "2";
    $head['faccountno'] = $xiyong_acount_no;
    $head['ferporderbillno'] = $xingyong_erp_order_bill_no;
    $head['ferpbillno'] = $xiyong_erp_bill_bo;
    $head['fcustno'] = $xiyong_cust_no;
    $head['fstockinno'] = "01";
    $head['fstockoutno'] = "";
    if($xiyong_biller_no == "") $xiyong_biller_no = "";
    $head['fbillerno'] = $xiyong_biller_no;
    if($xiyong_biller_p_no == "") $xiyong_biller_p_no = "";
    $head['fbillrepno'] = $xiyong_biller_p_no;
    if($xiyong_checker_no == "") $xiyong_checker_no = "";
    $head['fcheckerno'] = $xiyong_checker_no;
    $head['fbilldate'] = $xiyong_bill_date;
    if($xiyong_remark == "") $xiyong_remark = "";
    $head['fremark'] = $xiyong_remark;
    $head['fdischargeplace'] = $xiyong_discharge_place;
    $head['fdeliverplace'] = "";
    $head['fconsigneekey'] = $receiver_name;
    $head['fc_province'] = $xiyong_province_code;
    $head['fc_provincename'] = $xiyong_province;
    $head['fc_city'] = $xiyong_city_code;
    $head['fc_cityname'] = $xiyong_city;
    $head['fc_area'] = $xiyong_area_code;
    $head['fc_areaname'] = $xiyong_area;
    $head['fnotes'] = $receiver_address;
    $head['fc_zip'] = $xiyong_zip;
    $head['fc_contact1'] = $receiver_name;
    $head['fc_phone'] = $receiver_tel;
    $head['fhgbarcode'] = $bar_code;
    $head['ftype'] = $xiyong_type;
    $head['fmawb'] = $goods_fee;
    $head['fhwab'] = $tax_fee;
    $head['fbjflag'] = $xiyong_bjflag;
    $head['fbjamt'] = $xiyong_bjamt;
    //2.拼接detail
    $detail = array();
    $count = 0;
    while($product = mysqli_fetch_object($order_detail_query)){
        $famount = $product->qty * $product->price;
        $sku = $product->sku;
        //过滤普通商品
        $check_sku_sql = "select sku from ciq_sku_info where sku = '$sku'";
        $check_sku_query = mysqli_query($conn, $check_sku_sql);
        $result = mysqli_fetch_object($check_sku_query)->sku;
        if($result != ""){
            $product_p = array();
            $product_p['ficno'] = $xiyong_acount_no.".".$product->sku;
            $product_p['funit'] = $xiyong_acount_no.".".$product->xiyong_f_unit;
            $product_p['fqty'] = $product->qty;
            $product_p['fprice'] = $product->price;
            $product_p['famount'] = ''.$famount.'';
            $product_p['fremarkdtail'] = $product->xiyong_f_remark_detail;
            $detail['list'][$count] = $product_p;
            $count++;
        }
    }
    //3.拼接data
    $data = array();
    $data['head'] = $head;
    $data['detail'] = $detail;
    //4.拼接json
    $json_arr = array();
    $json_arr['action'] = "billfromerptowms";
    $json_arr['data'] = $data;

    // echo json_encode($json_arr, JSON_UNESCAPED_UNICODE);
    // post
    $key = "impltest";
    $method = "sendPutOrder";
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

    // var_dump($result_post);
    // echo $result_msg;

    //执行成功后
    // $result = "0";
    if($result == "0"){
        //更新订单发送状态
        $update_send_status_sql = "update order_payment_info set send_status = 2 where original_order_no = '$original_order_no'";
        $update_send_status_query = mysqli_query($conn, $update_send_status_sql);
        //更新库存
        $flag = true;
        while($product = mysqli_fetch_object($order_detail_query)){
            $sku = $product->sku;
            $update_stock_sql = "update stock set total_stock = total_stock - $qty, total_stock = total_stock - $qty where sku = '$sku'";
            $update_stock_query = mysqli_query($conn, $update_stock_sql);
            $flag = $flag & $update_stock_query;
        }
        if($flag){
            $response['error_code'] = SUCCESS;
            $response['error_msg'] = "SUCCESS";
        }else{
            $warning_sql = "update order_payment_info set send_status = 3 where original_order_no = '$original_order_no'";
            $warning_query = mysqli_query($conn, $warning_sql);
            $response['error_code'] = FAILED;
            $response['error_msg'] = "CAN NOT UPDATE STOCK";
        }
        
    }else{
        $update_send_status = "update order_payment_info set send_status = -2 where original_order_no = '$original_order_no'";
        $query_update_send_status = mysqli_query($conn, $update_send_status);
        $response['error_code'] = FAILED;
        $response['error_msg'] = "POST FAILED";
    }
    mysqli_close($conn);
    return json_encode($response);
}
?>