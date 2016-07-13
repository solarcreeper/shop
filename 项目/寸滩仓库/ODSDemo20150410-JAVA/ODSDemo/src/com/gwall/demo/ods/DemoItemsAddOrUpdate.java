package com.gwall.demo.ods;

import java.io.IOException;
import java.io.UnsupportedEncodingException;

import sun.misc.BASE64Decoder;
import util.DemoBase;


/**
 * 商品新增或更新demo
 * 必须先在WMS申请货主录入后;才能做商品新增
 * @author yk
 *
 */
public class DemoItemsAddOrUpdate extends DemoBase{
	
	private String serviceURL = "http://222.180.251.246:8086/ODS/ODSService";
	//private String serviceURL = "http://222.180.251.78:8085/ODS/ODSService";
	//private String serviceURL = "http://172.17.21.195:8080/ODS/ODSService";
	private String appkey = "Gappkey_standard_cq_test";
	private String service = "subItemAddOrUpdate";
	//新增商品 修改商品
	private String content = "{\"itemList\":[{\"goodsId\":\"10001\",\"title\":\"商22品\",\"num\":\"10000\",\"price\":\"100.00\",\"desc\":\"商品描述\",\"type\":\"fixed\",\"approveStatus\":\"onsale\"," +
			"\"skuList\":" +
			"[" +
				"{skuId:'12',outerId:'',fjm:'123',skuHgId:'222',ownerCode:'10001',ownerName:'重庆港腾供应链管理有限公司',isbs:'true',hgxh:'11',hgzc:'22',skuSpecId:'商品规格12',barcode:'22',price:889,created:'2014-08-09 21:33:22',status:'normal',type:'全量更新'}" +
			"]}]}";
	private static String ss = "{\"itemList\":[{\"goodsId\":\"5703999 double adjus570999\",\"title\":\"皮带;颜色:黑色 尺寸:110 规格:牛皮 品牌:菲拉格慕\",\"num\":\"0\",\"desc\":\"颜色:黑色 尺寸:110 规格:牛皮 品牌:菲拉格慕\",\"price\":\"1999.000000\",\"postFee\":\"0\",\"expessFee\":\"0\",\"emsFee\":\"0\",\"outerId\":\"\",\"listTime\":\"2014-08-27 10:49:17\",\"type\":\"fixed\",\"approveStatus\":\"onsale\",\"skuList\":[{\"skuId\":\"26571135\",\"skuHgId\":\"26571135\",\"isbs\":\"true\",\"hgzc\":\"H8012W000005\",\"hgxh\":\"329\",\"ownerCode\":\"10001\",\"ownerName\":\"重庆商社电子商务有限公司\",\"skuSpecId\":\"\",\"outerId\":\"\",\"barcode\":\"26571135\",\"numlid\":\"0\",\"quanlity\":\"0\",\"price\":\"0\",\"status\":\"normal\",\"type\":\"全量更新\"}]}]}";
	private String sss="{\"itemList\":[{\"goodsId\":\"FLGM0102\",\"title\":\"菲拉格慕10022梦中彩虹女仕香水100ml\",\"num\":\"0\",\"desc\":\"\"," +
			"\"price\":\"0\",\"postFee\":\"0\",\"expessFee\":\"0\",\"emsFee\":\"0\",\"outerId\":\"\",\"listTime\":\"2014-09-01 17:05:21\"," +
			"\"type\":\"fixed\",\"approveStatus\":\"onsale\",\"skuList\":[{\"skuId\":\"282332278621278\",\"skuHgId\":\"FLGM09011753\"," +
			"\"isbs\":\"true\",fjm:'test123123',\"hgzc\":\"12344\",\"hgxh\":\"204\",\"ownerCode\":\"test\",\"ownerName\":\"test\",\"skuSpecId\":\"\"," +
			"\"outerId\":\"\",\"barcode\":\"\",\"numlid\":\"0\",\"quanlity\":\"0\",\"price\":\"0\",\"status\":\"normal\"," +
			"\"type\":\"全量更新\"}]}]}";
	private String ssss= "{\"itemList\":[{\"goodsId\":\"5012226047512\",\"title\":\"荷兰 美素hero baby 婴儿奶粉5段 700g\",\"num\":\"1\",\"desc\":\"荷兰 美素hero baby 婴儿奶粉5段 700g\",\"price\":\"178\",\"postFee\":\"0\",\"expessFee\":\"0\",\"emsFee\":\"0\",\"outerId\":\"\",\"listTime\":\"2015-01-20 10:49:17\",\"type\":\"fixed\",\"approveStatus\":\"onsale\",\"skuList\":[{\"skuId\":\"501226022422752121\",\"skuHgId\":\"570001\",\"isbs\":\"true\",\"hgzc\":\"H8012W000005\",\"hgxh\":\"329\",\"ownerCode\":\"570001\",\"ownerName\":\"菲仕兰\",\"skuSpecId\":\"\",\"outerId\":\"\",\"barcode\":\"26571135\",\"numlid\":\"0\",\"quanlity\":\"0\",\"price\":\"0\",\"status\":\"normal\",\"type\":\"全量更新\"}]}]}";

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
