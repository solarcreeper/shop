
import java.io.BufferedReader;
import java.io.UnsupportedEncodingException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Arrays;
import java.util.HashMap;
import java.net.URLEncoder;
import java.util.Map;
import java.security.MessageDigest;

/**
 *   U1CityUtil.invoke()
 *   invoke(String pUrl,String pMethod, String pUser, String pSession, String pFormat,Map<String,String> data )
 *   例子查看: main()
 */
public class U1CityUtil
{

    public final static String METHOD_GET="GET";
    public final static String METHOD_PUT="PUT";
    public final static String METHOD_DELETE="DELETE";
    public final static String METHOD_POST="POST";
    private static final char[] HEX_DIGITS = { '0', '1', '2', '3', '4', '5',
            '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f' };

    public static HashMap<String,String> rest(String serviceUrl,String parameter,String restMethod){
        try {
            URL url= new URL(serviceUrl);
            HttpURLConnection con = (HttpURLConnection)url.openConnection();
            con.setRequestMethod(restMethod);
            con.setConnectTimeout(300000);
            con.addRequestProperty("Content-type","application/x-www-form-urlencoded;charset=UTF-8");
            con.setDoOutput(true);
            OutputStream os = con.getOutputStream();
            os.write(parameter.getBytes("UTF-8"));
            os.close();


            HashMap<String,String> result=new HashMap<String,String>();
            result.put("code",String.valueOf(con.getResponseCode()));
            result.put("msg",con.getResponseMessage());

            //读取返回信息
            InputStream inputStream = con.getInputStream();
            BufferedReader reader = new BufferedReader(new InputStreamReader(inputStream,"UTF-8"));
            String  strMessage;
            StringBuffer buffer=new StringBuffer();
            while ((strMessage = reader.readLine()) != null) {
                buffer.append(strMessage);
            }
            result.put("result",buffer.toString());
            return result;
        } catch ( Exception e ) {
            HashMap<String,String> result=new HashMap<String,String>();
            result.put("code","0");
            result.put("msg",e.getMessage());
            result.put("result","Failed,Pls Check your url to verify it right") ;
            return result;
        }
    }

    //字符串按字母升序排序
    public static String strAsc(String origin){
        StringBuffer result=new StringBuffer();
        //去掉空格、转化成小写、升序
        char [] originChars=origin.replace(" ","").toLowerCase().toCharArray();
        Arrays.sort(originChars);
        for(char s: originChars){
            result.append(s);
        }
        return result.toString();
    }

    //md5加密
    public static String strMd5(String origin){
        String result="";
        try{
            result= U1CityUtil.encodeByMD5(origin, "gb2312");
        }catch (Exception e){
            e.printStackTrace();
        }
        return result;
    }
	  /**
     * encode By MD5
     *
     * @param str
     * @param encode
     * @return String
     */
    public static String encodeByMD5(String str,String encode) {
        if (str == null) {
            return null;
        }
        try {
            MessageDigest messageDigest = MessageDigest.getInstance("MD5");
            messageDigest.update(str.getBytes(encode));
            return getFormattedText(messageDigest.digest());
        } catch (Exception e) {
            throw new RuntimeException(e);
        }

    }
    
	private static String getFormattedText(byte[] bytes) {
        int len = bytes.length;
        StringBuilder buf = new StringBuilder(len * 2);
        // 把密文转换成十六进制的字符串形式
        for (int j = 0; j < len; j++) { 			buf.append(HEX_DIGITS[(bytes[j] >> 4) & 0x0f]);
            buf.append(HEX_DIGITS[bytes[j] & 0x0f]);
        }
        return buf.toString();
    }

    public static   HashMap<String,String> invoke(String pUrl,String pMethod, String pUser, String pSession, String pFormat,Map<String,String> data ){
        StringBuilder pStr=new StringBuilder();
        pStr.append("user=").append(U1CityUtil.encodeURL(pUser,"gb2312"));
        pStr.append("&").append("method=").append(U1CityUtil.encodeURL(pMethod,"gb2312"));
        if(!isBlank(pFormat))
            pStr.append("&").append("format=").append(U1CityUtil.encodeURL(pFormat,"gb2312"));
        String str=pMethod+pSession;
        for(String key:data.keySet()){
            str=str+key+data.get(key);
            pStr.append("&").append(key).append("=").append(U1CityUtil.encodeURL(data.get(key),"gb2312"));
        }

        String token=strMd5(strAsc(str));
        pStr.append("&").append("token=").append(U1CityUtil.encodeURL(token,"gb2312"));
        return rest(pUrl,pStr.toString(),U1CityUtil.METHOD_POST);
    }

	 /**
     * 对url进行编码
     */
    public static String encodeURL(String url,String charset) {
        try {
            return URLEncoder.encode(url, charset).replace("+","%20");
        } catch (UnsupportedEncodingException e) {
            e.printStackTrace();
            return null;
        }
    }

	public static boolean isBlank(String str) {
        int strLen;
        if(str != null && (strLen = str.length()) != 0) {
            for(int i = 0; i < strLen; ++i) {
                if(!Character.isWhitespace(str.charAt(i))) {
                    return false;
                }
            }

            return true;
        } else {
            return true;
        }
    }

    public static void main(String[] args)
    {
        HashMap<String,String> data=new HashMap<String, String>();
        // data.put("startTime","2014-08-17");
        // data.put("billNo","");
        //data.put("expCode","DHL00023923");
        //  data.put("expName","DHL");
        //data.put("endTime","2014-08-19");
        //data.put("pageIndex","1");
        //data.put("pageSize","10");
        // data.put("orderId","2014060300001375");
        //data.put("cancelReason","Warehouse cancel");
        // data.put("proSkuNo","0404002");
        //  data.put("status","");
        // data.put("orderStatus","4");
        // data.put("proNum","61");
        //GetSaleStockData           //获取订单
        //UpdateProductSkuNum     更新库存
        //GetProductSkuInfo 获取库存
        //GetSaleStock     (新接口，获取订单)
        //SetSaleStockDeliver   //仓库发货
        //Get_Proc_List
        //Submit_Proc
        // GetSupplier
        //Get_Express_List    //获取物流商


        // test http://wqbopenapi.ushopn6.com/wqbnew/api.rest

        data.put("appKey","U1CITYCKTEST");
        HashMap<String,String> restJson=invoke("http://wqbopenapi.ushopn6.com/wqbnew/api.rest","IOpenAPI.Get_Express_List","U1CITYCKTEST","U1CITYCKTESTJJKIUNHB","json",data);
        System.out.println(restJson);
    }
}