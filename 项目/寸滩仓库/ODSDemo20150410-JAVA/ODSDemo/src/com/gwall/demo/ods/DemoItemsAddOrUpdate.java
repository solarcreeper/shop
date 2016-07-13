package com.gwall.demo.ods;

import java.io.IOException;
import java.io.UnsupportedEncodingException;

import sun.misc.BASE64Decoder;
import util.DemoBase;


/**
 * ��Ʒ���������demo
 * ��������WMS�������¼���;��������Ʒ����
 * @author yk
 *
 */
public class DemoItemsAddOrUpdate extends DemoBase{
	
	private String serviceURL = "http://222.180.251.246:8086/ODS/ODSService";
	//private String serviceURL = "http://222.180.251.78:8085/ODS/ODSService";
	//private String serviceURL = "http://172.17.21.195:8080/ODS/ODSService";
	private String appkey = "Gappkey_standard_cq_test";
	private String service = "subItemAddOrUpdate";
	//������Ʒ �޸���Ʒ
	private String content = "{\"itemList\":[{\"goodsId\":\"10001\",\"title\":\"��22Ʒ\",\"num\":\"10000\",\"price\":\"100.00\",\"desc\":\"��Ʒ����\",\"type\":\"fixed\",\"approveStatus\":\"onsale\"," +
			"\"skuList\":" +
			"[" +
				"{skuId:'12',outerId:'',fjm:'123',skuHgId:'222',ownerCode:'10001',ownerName:'������ڹ�Ӧ���������޹�˾',isbs:'true',hgxh:'11',hgzc:'22',skuSpecId:'��Ʒ���12',barcode:'22',price:889,created:'2014-08-09 21:33:22',status:'normal',type:'ȫ������'}" +
			"]}]}";
	private static String ss = "{\"itemList\":[{\"goodsId\":\"5703999 double adjus570999\",\"title\":\"Ƥ��;��ɫ:��ɫ �ߴ�:110 ���:ţƤ Ʒ��:������Ľ\",\"num\":\"0\",\"desc\":\"��ɫ:��ɫ �ߴ�:110 ���:ţƤ Ʒ��:������Ľ\",\"price\":\"1999.000000\",\"postFee\":\"0\",\"expessFee\":\"0\",\"emsFee\":\"0\",\"outerId\":\"\",\"listTime\":\"2014-08-27 10:49:17\",\"type\":\"fixed\",\"approveStatus\":\"onsale\",\"skuList\":[{\"skuId\":\"26571135\",\"skuHgId\":\"26571135\",\"isbs\":\"true\",\"hgzc\":\"H8012W000005\",\"hgxh\":\"329\",\"ownerCode\":\"10001\",\"ownerName\":\"������������������޹�˾\",\"skuSpecId\":\"\",\"outerId\":\"\",\"barcode\":\"26571135\",\"numlid\":\"0\",\"quanlity\":\"0\",\"price\":\"0\",\"status\":\"normal\",\"type\":\"ȫ������\"}]}]}";
	private String sss="{\"itemList\":[{\"goodsId\":\"FLGM0102\",\"title\":\"������Ľ10022���вʺ�Ů����ˮ100ml\",\"num\":\"0\",\"desc\":\"\"," +
			"\"price\":\"0\",\"postFee\":\"0\",\"expessFee\":\"0\",\"emsFee\":\"0\",\"outerId\":\"\",\"listTime\":\"2014-09-01 17:05:21\"," +
			"\"type\":\"fixed\",\"approveStatus\":\"onsale\",\"skuList\":[{\"skuId\":\"282332278621278\",\"skuHgId\":\"FLGM09011753\"," +
			"\"isbs\":\"true\",fjm:'test123123',\"hgzc\":\"12344\",\"hgxh\":\"204\",\"ownerCode\":\"test\",\"ownerName\":\"test\",\"skuSpecId\":\"\"," +
			"\"outerId\":\"\",\"barcode\":\"\",\"numlid\":\"0\",\"quanlity\":\"0\",\"price\":\"0\",\"status\":\"normal\"," +
			"\"type\":\"ȫ������\"}]}]}";
	private String ssss= "{\"itemList\":[{\"goodsId\":\"5012226047512\",\"title\":\"���� ����hero baby Ӥ���̷�5�� 700g\",\"num\":\"1\",\"desc\":\"���� ����hero baby Ӥ���̷�5�� 700g\",\"price\":\"178\",\"postFee\":\"0\",\"expessFee\":\"0\",\"emsFee\":\"0\",\"outerId\":\"\",\"listTime\":\"2015-01-20 10:49:17\",\"type\":\"fixed\",\"approveStatus\":\"onsale\",\"skuList\":[{\"skuId\":\"501226022422752121\",\"skuHgId\":\"570001\",\"isbs\":\"true\",\"hgzc\":\"H8012W000005\",\"hgxh\":\"329\",\"ownerCode\":\"570001\",\"ownerName\":\"������\",\"skuSpecId\":\"\",\"outerId\":\"\",\"barcode\":\"26571135\",\"numlid\":\"0\",\"quanlity\":\"0\",\"price\":\"0\",\"status\":\"normal\",\"type\":\"ȫ������\"}]}]}";

	public static void main(String argc[]){
		try {
			String s = new String(new BASE64Decoder().decodeBuffer(ss),"utf-8");
			System.out.print(s);
		} catch (UnsupportedEncodingException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		}
		new DemoItemsAddOrUpdate().execute();
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
		return sss;
	}

	@Override
	public String getServiceURL() {
		return serviceURL;
	}
}
