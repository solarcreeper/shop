package util;

import java.io.IOException;
import java.io.UnsupportedEncodingException;

import sun.misc.BASE64Decoder;
import sun.misc.BASE64Encoder;


public abstract class DemoBase {
	//ODS服务地址
	protected String serviceURL = "http://127.0.0.1:8080/ODS/ODSService";
	protected String appkey = "Gappkey_standard_cq_aigou";
	//加密密串(正式上线,需向相关人员申请)
	protected String appSecret = "";
	//执行的方法
	protected String service = "";
	//数据格式
	protected String format = "JSON";
	//数据体
	protected String content = "";
	//是否加密 0 不加密,1 加密(默认 0)
	protected String encrypt = "0";
	protected String secret = "";
	
	/**
	 * 服务地址
	 * @return
	 */
	public abstract String getServiceURL();
	
	/**
	 * 对应的APPKEY
	 * @return
	 */
	public abstract String getAppKey();
	
	/**
	 * 本次接口调用的服务是什么,请在文档中查找对应的服务名
	 * @param service
	 */
	public abstract String getService();
	
	/**
	 * 接口的参数,请根据调用的服务,再文档中找到对应的输入参数json对象
	 * @return
	 */
	public abstract String getContent();
	
	/**
	 * 编码
	 * @return
	 */
	public abstract String getEncrypt();
	
	/**
	 * 执行调用接口
	 */
	public void execute(){
		System.out.println("....开始....");
		serviceURL = getServiceURL();
		System.out.println("服务地址:"+serviceURL);
		appkey = getAppKey();
		System.out.println("appkey:"+appkey);
		service = getService();
		System.out.println("调用服务:"+service);
		//base64编码
		String baseContent = null;		
		if("1".equals(getEncrypt())){
			System.out.println("进行加密...");
			try {
				baseContent = new BASE64Encoder().encode(getContent().getBytes("UTF-8")).replaceAll("\n", "");
				System.out.println("加密后数据:"+baseContent);
			} catch (Exception e) {
				e.printStackTrace();
			}
		}else{
			System.out.println("不加密...");
			baseContent = getContent();
			System.out.println("数据:"+baseContent);
		}
		//请求服务
		HttpClient client = new HttpClient();
		String param = "appkey="+appkey+"&service="+service+"&format="+format+"&encrypt="+getEncrypt()+"&content="+baseContent+"&secret="+secret;
		System.out.println("服务:"+serviceURL);
		System.out.println("参数:"+param);
		String result = client.pub(serviceURL, param);
		if(result.indexOf(":")==-1 && result.indexOf("{")==-1 && result.indexOf("}")==-1){
			try {
				result = new String(new BASE64Decoder().decodeBuffer(result.replaceAll(" ", "+")),"UTF-8");
			} catch (UnsupportedEncodingException e) {
				e.printStackTrace();
			} catch (IOException e) {
				e.printStackTrace();
			}
		}
		System.out.println("返回结果:"+result);
		System.out.println("....结束....");
	}
}
