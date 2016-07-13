package com.gwall.demo.ods;

import util.DemoBase;


/**
 * 库存查询demo
 * 
 * 库存推送会自动推到电商平台提供的URL地址上面.详情请查看接口文档pubSyncItemStockInfo
 * @author yk
 *
 */
public class DemoSyncStock extends DemoBase{
	
	private String serviceURL = "http://127.0.0.1:8090/ODS/ODSService";
	//private String serviceURL = "http://222.180.251.246:8090/ODS/ODSService";
	private String appkey = "Gappkey_standard_cq_test";
	private String service = "subSyncItemStockInfo";
	private String content = "{goodsId:'14351',skuId:'22750933',outerId:''}";	//至少一个参数
	
	public static void main(String argc[]){
		new DemoSyncStock().execute();
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
