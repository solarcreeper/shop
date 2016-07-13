package com.gwall.demo.ods;

import util.DemoBase;


/**
 * ����ѯdemo
 * 
 * ������ͻ��Զ��Ƶ�����ƽ̨�ṩ��URL��ַ����.������鿴�ӿ��ĵ�pubSyncItemStockInfo
 * @author yk
 *
 */
public class DemoSyncStock extends DemoBase{
	
	private String serviceURL = "http://127.0.0.1:8090/ODS/ODSService";
	//private String serviceURL = "http://222.180.251.246:8090/ODS/ODSService";
	private String appkey = "Gappkey_standard_cq_test";
	private String service = "subSyncItemStockInfo";
	private String content = "{goodsId:'14351',skuId:'22750933',outerId:''}";	//����һ������
	
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
