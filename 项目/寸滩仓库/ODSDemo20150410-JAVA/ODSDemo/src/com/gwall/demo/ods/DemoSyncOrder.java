package com.gwall.demo.ods;

import util.DemoBase;


/**
 * 同步订单demo
 * 取消订单,买家收货,新建订单
 * @author yk
 *
 */
public class DemoSyncOrder extends DemoBase{
	
	private String serviceURL = "http://127.0.0.1:8090/ODS/ODSService";
	//private String serviceURL = "http://222.180.251.246:8090/ODS/ODSService";
	//private String serviceURL = "http://172.17.21.195:8080/ODS/ODSService";
	private String appkey = "Gappkey_standard_cq_sjg";
	private String service = "subAddSaleOrder";
	/**
	 * WAIT_SELLER_SEND_GOODS等待发货  
	 * TRADE_FINISHED买家已签收  
	 * TRADE_CLOSED买家取消订单
	 */
	private String type = "WAIT_SELLER_SEND_GOODS";	
	private String biid = "TEST10001";
	private String content = "{\"saleOrderList\":[" +
				"{\"orderCode\":\""+biid+"\",\"hgBarcode\":\"2001\",\"printMsg\":\"打印22信息\"," +
				"\"orderTax\":\"100\",\"platFromName\":\"爱购网\",\"shopName\":\"爱购网\"," +
				"\"orderStatus\":" +				
				"\""+type+"\"," +	
				"\"type\":\"fixed\",logisticsNumber:'1179786754603',\"createDate\":\"2014-08-14 22:33:22\"," +
				"\"updateDate\":\"2014-08-14 22:33:22\",\"payTime\":\"2014-08-14 22:33:22\"," +
				"\"logisticsCompanyCode\":\"EMS\",\"logisticsCompanyName\":\"EMS快递\",\"postPrice\":4," +
				"\"isDeliveryPay\":\"false\",\"bunick\":\"zs001\",\"invoiceName\":\"\",\"invoiceType\":\"\"," +
				"\"invoiceContent\":\"\",\"sellersMessage\":\"\",\"buyerMessage\":\"\",\"merchantMessage\":\"\"," +
				"\"amountReceivable\":8888,\"actualPayment\":8888," +
				"\"receiver\":{" +
					"\"orderCode\":\""+biid+"\",\"name\":\"张三\",\"phone\":\"\",\"mobilePhone\":\"15818767908\"," +
					"\"address\":\"XX路88号127777\",\"province\":\"四川省\",\"city\":\"重庆市\",\"district\":\"江北区\"," +
					"\"zip\":\"123001\"" +
				"}," +
				"\"detail\":[" +
					"{\"orderCode\":\""+biid+"\",\"orderDetailCode\":\"101\",\"skuId\":\"1112111\",\"outerSkuId\":\"DB1409170002\",\"num\":1," +
					"\"title\":\"FFFF\",\"price\":889,\"payment\":889,\"discountPrice\":0,\"totalPrice\":889,\"adjustPrice\":0," +
					"\"divideOrderPrice\":0,\"billPrice\":889,\"partMjzDiscount\":0}" +
				"]}" +			
			"]}";
	
	
	
	public static void main(String argc[]){
		DemoSyncOrder dso = new DemoSyncOrder();
		dso.execute();
	}
	
	@Override
	public String getEncrypt() {
		return "1";
	}

	@Override
	public String getService() {
		return service;
	}

	@Override
	public String getAppKey() {
		return appkey;
	}

	@Override
	public String getContent() {
		return content;
	}

	@Override
	public String getServiceURL() {
		return serviceURL;
	}
}
