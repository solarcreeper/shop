package com.gwall.demo.ods;

import util.DemoBase;


/**
 * 批次码查询
 * @author yk
 *
 */
public class DemoQueryBatchCodeInfo extends DemoBase{
	
	//http://127.0.0.1:8090/GwallServices/httpService
	//private String serviceURL = "http://127.0.0.1:8090/GwallServices/httpService";
	//private String serviceURL = "http://222.180.251.78:8085/ODS/ODSService";
	private String serviceURL = "http://222.180.251.246:8090/GwallServices/httpService";
	private String appkey = "test";
	private String service = "subBatchCodeInfo";
	private String content = "{pcms:'01C201408050001'}";	//多个用,分隔
	
	public static void main(String argc[]){
		new DemoQueryBatchCodeInfo().execute();
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
