package com.gwall.demo.ods;

import util.DemoBase;


/**
 * 退货计划
 * @author yk
 *
 */
public class DemoItemsAddReturnPlan extends DemoBase{
	
	//private String serviceURL = "http://127.0.0.1:8080/ODS/ODSService";
	private String serviceURL = "http://222.180.251.246:8090/ODS/ODSService";
	//private String serviceURL = "http://222.180.251.78:8085/ODS/ODSService";
	//private String serviceURL = "http://172.17.21.195:8080/ODS/ODSService";
	private String appkey = "Gappkey_standard_cq_test";
	private String service = "subSaleReturnPlan";
	private String content = "{re:["
			+ "{\"biid\":\"12101\",\"soco\":\"PH201400005260\",\"rema\":\"接口更新测试单据\",\"crid\":\"11\",\"crna\":\"22\",\"bak1\":\"\",\"bak2\":\"\","
			+ "reDetail:["
				+ "{\"biid\":\"12101\",\"inco\":\"DB1409220007\",\"qty\":2,\"bak1\":\"\",\"bak2\":\"\"}"
				+ "]}"
			+ "]}";

	public static void main(String argc[]){
		new DemoItemsAddReturnPlan().execute();
	}
	
	@Override
	public String getEncrypt() {
		return "0";
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
