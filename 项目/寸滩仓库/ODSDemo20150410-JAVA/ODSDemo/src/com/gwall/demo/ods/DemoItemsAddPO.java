package com.gwall.demo.ods;

import util.DemoBase;


/**
 * 采购订单
 * @author yk
 *
 */
public class DemoItemsAddPO extends DemoBase{
	
	//private String serviceURL = "http://222.180.251.246:8090/ODS/ODSService";
	private String serviceURL = "http://127.0.0.1:8080/ODS/ODSService";
	//private String serviceURL = "http://222.180.251.78:8085/ODS/ODSService";
	//private String serviceURL = "http://172.17.21.195:8080/ODS/ODSService";
	private String appkey = "Gappkey_standard_cq_test";
	private String service = "subAddPoOrder";
	private String content = "{po:["
			+ "{\"soco\":\"1000211\",\"rema\":\"接口更新测试单据\",\"cgdt\":\"2015-01-05 11:22:33\",\"yjdt\":\"2015-01-05 11:22:33\","
			+ "\"gyid\":\"010027\",\"hzid\":\"37\",\"crid\":\"11\",\"crna\":\"22\",\"bak1\":\"\",\"bak2\":\"\","
			+ "poDetail:["
				+ "{\"soco\":\"1000211\",\"inco\":\"DB1408270001\",\"qty\":2,\"rmbdj\":200,\"wbdj\":100,\"bak1\":\"\",\"bak2\":\"\"},"
				+ "{\"soco\":\"1000211\",\"inco\":\"DB1408270002\",\"qty\":3,\"rmbdj\":200,\"wbdj\":100,\"bak1\":\"\",\"bak2\":\"\"}"
				+ "]}"
			+ "]}";
	public static void main(String argc[]){
		new DemoItemsAddPO().execute();
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
