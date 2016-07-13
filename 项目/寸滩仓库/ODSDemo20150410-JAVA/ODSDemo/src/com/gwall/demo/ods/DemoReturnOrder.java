package com.gwall.demo.ods;

import util.DemoBase;

/**
 * 销售退货demo
 * @author yk
 *
 */
public class DemoReturnOrder extends DemoBase{
	
	private String serviceURL = "http://127.0.0.1:8080/ODS/ODSService";
	//private String serviceURL = "http://222.180.251.78:8090/ODS/ODSService";
	//private String serviceURL = "http://172.17.21.199:8090/ODS/ODSService";
	private String appkey = "Gappkey_standard_cq_test";
	private String service = "subAddSaleReturnOrder";
	//oid是对应订单明细中的唯一编号.
	//orderCode:平台订单编号
	//goodsId:平台商品编码
	private String content = "{refundId:'w12',orderCode:'2110497700042394',oid:'211049770004239453538'," +
			"refundBarCode:'HG1001',goodsId:'8059736732',num:1," +
			"companyName:'顺风快递',expressNo:'SF10001',hasGoodReturn:'true',refundFee:20," +
			"created:'2014-08-17 16:27:21',reason:'不想要这个!'}";
	
	public static void main(String argc[]){
		new DemoReturnOrder().execute();
	}

	@Override
	public String getService() {
		return service;
	}

	@Override
	public String getEncrypt() {
		return "1";
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
