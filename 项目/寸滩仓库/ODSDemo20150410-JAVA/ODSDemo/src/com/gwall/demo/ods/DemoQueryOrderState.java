package com.gwall.demo.ods;

import util.DemoBase;


/**
 * 平台发起查询订单状态demo
 * @author yk
 *
 */
public class DemoQueryOrderState extends DemoBase{
	
	private String serviceURL = "http://222.180.251.246:8086/ODS/ODSService";
	//private String serviceURL = "http://222.180.251.78:8090/ODS/ODSService";
	//private String serviceURL = "http://172.17.21.199:8090/ODS/ODSService";
	private String appkey = "Gappkey_standard_cq_test";
	private String service = "subQueryOrderState"; 
	private String content = "{orderCode:'22222211212242',platFormName:'世纪秀',shopName:'世纪秀'}";
	
	public static void main(String argc[]){
		new DemoQueryOrderState().execute();
	}

	@Override
	public String getService() {
		return service;
	}
	
	@Override
	public String getEncrypt() {
		return "0";
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
