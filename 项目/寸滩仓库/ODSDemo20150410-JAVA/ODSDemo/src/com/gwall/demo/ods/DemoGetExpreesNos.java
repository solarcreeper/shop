package com.gwall.demo.ods;

import util.DemoBase;


/**
 * ��ȡ��ݵ���
 * @author yk
 *
 */
public class DemoGetExpreesNos extends DemoBase{
	
	//private String serviceURL = "http://222.180.251.246:8090/ODS/ODSService";
	private String serviceURL = "http://127.0.0.1:8090/ODS/ODSService";
	//private String serviceURL = "http://222.180.251.78:8085/ODS/ODSService";
	//private String serviceURL = "http://172.17.21.195:8080/ODS/ODSService";
	private String appkey = "Gappkey_standard_cq_sjg";
	private String service = "subGetOrderExpress";
	private String content = "{expressNos:["
			+ "{\"orderCode\":\"TEST10002\",\"express\":\"EMS\",\"type\":1,s_name:'�ռ�������',"
			+ "s_phone:'123456',s_prov:'�㶫',s_city:'����',s_address:'�㶫ʡ�����и�����������·XXXX',bak1:'',bak2:'',"
			+ "items:["
				+ "{\"id\":\"DB1408270001\",\"name\":\"XXX��Ʒ1\",\"quantity\":2,\"weight\":200,\"size\":100,\"bak1\":\"\",\"bak2\":\"\"},"
				+ "{\"id\":\"DB1408270002\",\"name\":\"XXX��Ʒ2\",\"quantity\":3,\"weight\":200,\"size\":100,\"bak1\":\"\",\"bak2\":\"\"}"
				+ "]}"
			+ "]}";
	public static void main(String argc[]){
		new DemoGetExpreesNos().execute();
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
