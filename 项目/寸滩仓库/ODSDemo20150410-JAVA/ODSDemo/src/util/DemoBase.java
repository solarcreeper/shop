package util;

import java.io.IOException;
import java.io.UnsupportedEncodingException;

import sun.misc.BASE64Decoder;
import sun.misc.BASE64Encoder;


public abstract class DemoBase {
	//ODS�����ַ
	protected String serviceURL = "http://127.0.0.1:8080/ODS/ODSService";
	protected String appkey = "Gappkey_standard_cq_aigou";
	//�����ܴ�(��ʽ����,���������Ա����)
	protected String appSecret = "";
	//ִ�еķ���
	protected String service = "";
	//���ݸ�ʽ
	protected String format = "JSON";
	//������
	protected String content = "";
	//�Ƿ���� 0 ������,1 ����(Ĭ�� 0)
	protected String encrypt = "0";
	protected String secret = "";
	
	/**
	 * �����ַ
	 * @return
	 */
	public abstract String getServiceURL();
	
	/**
	 * ��Ӧ��APPKEY
	 * @return
	 */
	public abstract String getAppKey();
	
	/**
	 * ���νӿڵ��õķ�����ʲô,�����ĵ��в��Ҷ�Ӧ�ķ�����
	 * @param service
	 */
	public abstract String getService();
	
	/**
	 * �ӿڵĲ���,����ݵ��õķ���,���ĵ����ҵ���Ӧ���������json����
	 * @return
	 */
	public abstract String getContent();
	
	/**
	 * ����
	 * @return
	 */
	public abstract String getEncrypt();
	
	/**
	 * ִ�е��ýӿ�
	 */
	public void execute(){
		System.out.println("....��ʼ....");
		serviceURL = getServiceURL();
		System.out.println("�����ַ:"+serviceURL);
		appkey = getAppKey();
		System.out.println("appkey:"+appkey);
		service = getService();
		System.out.println("���÷���:"+service);
		//base64����
		String baseContent = null;		
		if("1".equals(getEncrypt())){
			System.out.println("���м���...");
			try {
				baseContent = new BASE64Encoder().encode(getContent().getBytes("UTF-8")).replaceAll("\n", "");
				System.out.println("���ܺ�����:"+baseContent);
			} catch (Exception e) {
				e.printStackTrace();
			}
		}else{
			System.out.println("������...");
			baseContent = getContent();
			System.out.println("����:"+baseContent);
		}
		//�������
		HttpClient client = new HttpClient();
		String param = "appkey="+appkey+"&service="+service+"&format="+format+"&encrypt="+getEncrypt()+"&content="+baseContent+"&secret="+secret;
		System.out.println("����:"+serviceURL);
		System.out.println("����:"+param);
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
		System.out.println("���ؽ��:"+result);
		System.out.println("....����....");
	}
}
