package util;


import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;

public class HttpClient {

	private String method = null;
	
	public String getMethod() {
		if(method == null){
			return "POST";
		}
		return method;
	}
	public void setMethod(String method) {
		this.method = method;
	}
	/**
	 * 
	 * @param urlServices webService 服务地址
	 * @param method 服务参数
	 * @param param String
	 * @return
	 */
	public String pub(String serviceURL,String param)
	{
		URL url = null;
		HttpURLConnection connection = null;
		StringBuffer buffer = new StringBuffer();
		System.out.println("request:"+serviceURL+"?"+param);
		try {
			url = new URL(serviceURL);
			connection = (HttpURLConnection) url.openConnection();
			connection.setDoOutput(true);
			connection.setDoInput(true);
			connection.setUseCaches(false);
			connection.setRequestMethod(getMethod());
			connection.setRequestProperty("Content-Length",param.length()+"");
			
			OutputStream outputStream = connection.getOutputStream();
			outputStream.write(param.getBytes("UTF-8"));
			
			BufferedReader reader = new BufferedReader(new InputStreamReader(connection.getInputStream(), "UTF-8"));			
			String line = "";
			while ((line = reader.readLine()) != null) {
				buffer.append(line);
			}
			reader.close();
		} catch (IOException e) {
			e.printStackTrace();
		} finally {
			if (connection != null) {
				connection.disconnect();
			}
		}
		System.out.println("response:"+buffer.toString());
		return buffer.toString();
	}
}
