using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Text;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Xml;
using U1Api;

public partial class index : System.Web.UI.Page
{
    private string url = "http://113.204.136.28/KJClientReceiver/Data.aspx";

    private string webUrl;
    private string webKey;
    private string webSecert;
    private string startTime;
    private string endTime;

    protected void Page_Load(object sender, EventArgs e)
    {
        webUrl = TextBox1.Text.ToString();
        webKey = TextBox2.Text.ToString();
        webSecert = TextBox3.Text.ToString();
        startTime = TextBox4.Text.ToString();
        endTime = TextBox5.Text.ToString();
        CreateOrderStyle();
    }

    //直接添加500个单的框
    private void CreateOrderStyle()
    {
        for (int i = 0; i < 5; i++)
        {
            Label l = new Label();
            l.Text = "商品货号:";
            PlaceHolder1.Controls.Add(l);
            TextBox tb = new TextBox();
            tb.ID = i.ToString() + "_1";
            PlaceHolder1.Controls.Add(tb);

            l = new Label();
            l.Text = "业务类型:";
            PlaceHolder1.Controls.Add(l);
            DropDownList dd = new DropDownList();
            dd.Items.Add("直购进口");
            dd.Items.Add("网购报税进口");
            dd.ID = i.ToString() + "_2";
            PlaceHolder1.Controls.Add(dd);

            l = new Label();
            l.Text = "备案编号:";
            PlaceHolder1.Controls.Add(l);
            tb = new TextBox();
            tb.ID = i.ToString() + "_3";
            PlaceHolder1.Controls.Add(tb);

            l = new Label();
            l.Text = "收件人姓名:";
            PlaceHolder1.Controls.Add(l);
            tb = new TextBox();
            tb.ID = i.ToString() + "_4";
            PlaceHolder1.Controls.Add(tb);

            l = new Label();
            l.Text = "分拣线:";
            PlaceHolder1.Controls.Add(l);
            dd = new DropDownList();
            dd.Items.Add("寸滩空港");
            dd.Items.Add("重庆西永");
            dd.Items.Add("寸滩水港");
            dd.ID = i.ToString() + "_5";
            PlaceHolder1.Controls.Add(dd);

            l = new Label();
            l.Text = "起运国:";
            PlaceHolder1.Controls.Add(l);
            dd = new DropDownList();
            dd.Items.Add("中国");
            dd.Items.Add("美国");
            dd.ID = i.ToString() + "_6";
            PlaceHolder1.Controls.Add(dd);

            l = new Label();
            l.Text = "运输方式:";
            PlaceHolder1.Controls.Add(l);
            dd = new DropDownList();
            dd.Items.Add("空运");
            dd.Items.Add("水运");
            dd.ID = i.ToString() + "_7";
            PlaceHolder1.Controls.Add(dd);

            l = new Label();
            l.Text = "币值代码:";
            PlaceHolder1.Controls.Add(l);
            dd = new DropDownList();
            dd.Items.Add("人民币");
            dd.Items.Add("美元");
            dd.ID = i.ToString() + "_8";
            PlaceHolder1.Controls.Add(dd);

            //换行
            l = new Label();
            l.Text = "<br/>";
            PlaceHolder1.Controls.Add(l);
        }
    }

    protected void Button1_Click(object sender, EventArgs e)
    {
        if (webUrl == "" || webKey == "" || webSecert == "" || startTime == "" || endTime == "")
        {
            return;
        }
        //获取订单信息
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", webKey);//AppKey[必填]
        date.Add("orderId", "");//订单编号[可填]
        date.Add("orderNo", "");//网店订单号[可填]
        date.Add("orderStatus", "");//订单状态[可填][0：全部[默认] 1: 等待分配仓库 2: 已分配仓库 3: 等待仓库拣货 4: 订单发货中 5: 部分发货 6: 仓库已发货]
        date.Add("startTime", startTime);//订单开始时间[可填]
        date.Add("endTime", endTime);//订单结束时间[可填]
        date.Add("pageIndex", "1");//页数[可填]
        date.Add("pageSize", "10");//每页数量[可填][数量： 10、20、50]
        ///调用接口
        Client client = new Client(webUrl, "IOpenAPI.GetOrder", webKey, webSecert, "xml");
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            return;
        }
        if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
        {
            return;
        }
        #region ========== Xml返回 ===========
        StringReader Reader = new StringReader(sAPIResult);
        XmlDocument TempXml = new XmlDocument();
        TempXml.Load(Reader);
        string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
        string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");

        //定义需要的变量
        string orderId = "", 
            name = "", 
            address = "", 
            phone = "", 
            cardNumber = "", 
            productId = "", 
            productStyle = "", 
            moneyType = "CNY", 
            productCount = "", 
            productNum = "", 
            totalCount = "", 
            shuikuan = "10.00";
        //还不确定的
        string customCode = "1231231231";
        string bizType = "I10";
        string eshopCode = "110";
        string eshopName = "high购";
        string arriCountry = "116";//日本
        string shipTool = "Y";
        string shuikuanjine = "0.01";

        if (ApiResultCode == "101")
        {
            XmlNodeList ApiResultApi_SelectOrderInfo = TempXml.SelectNodes("//Api_SelectOrderInfo");
            if (ApiResultApi_SelectOrderInfo[0].InnerXml != "")
            {
                #region 处理一条订单,循环处理多条
                for (int i = 0; i < ApiResultApi_SelectOrderInfo.Count; i++)
                {
                    XmlDocument OrderXml = new XmlDocument();
                    OrderXml.LoadXml("<tradeInfo>" + ApiResultApi_SelectOrderInfo[i].InnerXml + "</tradeInfo>");
                    #region ========== 订单信息 ==========
                    //获取海关需要的信息
                    //申报海关代码

                    //业务类型

                    //原始订单编号
                    orderId = Comm.get_Xml_Nodes(OrderXml, "//OrderId");//系统订单编号
                    //电商企业代码

                    //电商企业名称

                    //起运国

                    //运输方式

                    //收货人身份证号，姓名，地址，电话
                    name = Comm.get_Xml_Nodes(OrderXml, "//C_Name");//收件人姓名
                    address = Comm.get_Xml_Nodes(OrderXml, "//Address");//地址
                    phone = Comm.get_Xml_Nodes(OrderXml, "//MobiTel");//手机号码
                    cardNumber = Comm.get_Xml_Nodes(OrderXml, "//Card");//身份证号
                    //货款总额，税金总额

                    //分拣线ID

                    //以上为必填项，下面为选填
                    //毛重，代理企业代码，代理企业名称,运费，仓储企业代码，仓储企业名称，联营电商代码，联营电商名称

                    //订单明细，必填
                    //商品货号，规格型号，币制代码，商品单价，商品数量，商品总价，税款金额
                    productId = "";
                    productStyle = "";
                    moneyType = "";
                    productCount = "";
                    productNum = "";
                    totalCount = "";
                    shuikuan = "";
                    ///订单商品
                    XmlNodeList ApiResultProSpec = OrderXml.SelectNodes("//ProSpec");
                    if (ApiResultProSpec[0].InnerXml != "")
                    {
                        for (int j = 0; j < ApiResultProSpec.Count; j++)
                        {
                            XmlDocument ProSpecXml = new XmlDocument();
                            ProSpecXml.LoadXml("<tradeInfo>" + ApiResultProSpec[j].InnerXml + "</tradeInfo>");
                            productId = Comm.get_Xml_Nodes(ProSpecXml, "//proSku");//商品SKU
                            productCount = Comm.get_Xml_Nodes(ProSpecXml, "//proPrice");//商品价格
                            productNum = Comm.get_Xml_Nodes(ProSpecXml, "//proCount");//商品数量
                            string sProColorName = Comm.get_Xml_Nodes(ProSpecXml, "//ProColorName");//商品颜色
                            productStyle = Comm.get_Xml_Nodes(ProSpecXml, "//ProSizesName") + sProColorName;//商品规格
                        }
                    }
                    totalCount = (Convert.ToDouble(productCount) * Convert.ToInt32(productNum)).ToString(); 
                    #endregion
                    //显示在界面上
                    
                    //获取字符串进行拼凑
                    
                    //发送
                }
                #endregion
            }
        }
        #endregion
        #region 拼凑字符串
        //拼凑data
        StringBuilder data = new StringBuilder();
        string msg = "";
        data.Append("data=").Append("<DTC_Message><MessageHead><MessageType>ORDER_INFO</MessageType>");
        //消息ID
        string gd = Guid.NewGuid().ToString();
        msg = EncodeBase64(gd).ToUpper();
        data.Append("<MessageId>").Append(msg).Append("</MessageId>");
        //动作类型
        msg = EncodeBase64("1").ToUpper();
        data.Append("<ActionType>").Append(msg).Append("</ActionType>");
        //消息时间
        msg = EncodeBase64(DateTime.Now.ToString()).ToUpper();
        data.Append("<MessageTime>").Append(msg).Append("</MessageTime>");
        //发送者ID!!!!!!!!!!!!!!!!!!!!!!!!!
        msg = EncodeBase64("wo").ToUpper();
        data.Append("<SenderId>").Append(msg).Append("</SenderId>");
        //接受方
        msg = EncodeBase64("CQITC").ToUpper();
        data.Append("<ReceiverId>").Append(msg).Append("</ReceiverId>");
        //固定的
        data.Append("<SenderAddress /><ReceiverAddress /><PlatFormNo /><CustomCode /><SeqNo /><Note />");
        //发送方名称和密码
        msg = EncodeBase64("wo").ToUpper();
        data.Append("<UserNo>").Append(msg).Append("</UserNo>");
        msg = EncodeBase64("mima").ToUpper();
        data.Append("<Password>").Append(msg).Append("</Password>");
        //固定的
        data.Append("</MessageHead><MessageBody><DTCFlow><ORDER_HEAD>");
        //订单数据添加
        msg = EncodeBase64(customCode).ToUpper();
        data.Append("<CUSTOMS_CODE>").Append(msg).Append("</CUSTOMS_CODE>");

        msg = EncodeBase64(bizType).ToUpper();
        data.Append("<BIZ_TYPE_CODE>").Append(msg).Append("</BIZ_TYPE_CODE>");

        msg = EncodeBase64(orderId).ToUpper();
        data.Append("<ORIGINAL_ORDER_NO>").Append(msg).Append("</ORIGINAL_ORDER_NO>");

        msg = EncodeBase64(eshopCode).ToUpper();
        data.Append("<ESHOP_ENT_CODE>").Append(msg).Append("</ESHOP_ENT_CODE>");

        msg = EncodeBase64(eshopName).ToUpper();
        data.Append("<ESHOP_ENT_NAME>").Append(msg).Append("</ESHOP_ENT_NAME>");

        msg = EncodeBase64(arriCountry).ToUpper();
        data.Append("<DESP_ARRI_COUNTRY_CODE>").Append(msg).Append("</DESP_ARRI_COUNTRY_CODE>");

        msg = EncodeBase64(shipTool).ToUpper();
        data.Append("<SHIP_TOOL_CODE>").Append(msg).Append("</SHIP_TOOL_CODE>");

        msg = EncodeBase64(cardNumber).ToUpper();
        data.Append("<RECEIVER_ID_NO>").Append(msg).Append("</RECEIVER_ID_NO>");

        msg = EncodeBase64(name).ToUpper();
        data.Append("<RECEIVER_NAME>").Append(msg).Append("</RECEIVER_NAME>");

        msg = EncodeBase64(address).ToUpper();
        data.Append("<RECEIVER_ADDRESS>").Append(msg).Append("</RECEIVER_ADDRESS>");

        msg = EncodeBase64(phone).ToUpper();
        data.Append("<RECEIVER_TEL>").Append(msg).Append("</RECEIVER_TEL>");

        msg = EncodeBase64(totalCount).ToUpper();
        data.Append("<GOODS_FEE>").Append(msg).Append("</GOODS_FEE>");

        msg = EncodeBase64(shuikuan).ToUpper();
        data.Append("<TAX_FEE>").Append(msg).Append("</TAX_FEE>");

        data.Append("<ORDER_DETAIL>");

        msg = EncodeBase64(productId).ToUpper();
        data.Append("<SKU>").Append(msg).Append("</SKU>");

        msg = EncodeBase64(productStyle).ToUpper();
        data.Append("<GOODS_SPEC>").Append(msg).Append("</GOODS_SPEC>");

        msg = EncodeBase64(moneyType).ToUpper();
        data.Append("<CURRENCY_CODE>").Append(msg).Append("</CURRENCY_CODE>");

        msg = EncodeBase64(productCount).ToUpper();
        data.Append("<PRICE>").Append(msg).Append("</PRICE>");

        msg = EncodeBase64(productNum).ToUpper();
        data.Append("<QTY>").Append(msg).Append("</QTY>");

        msg = EncodeBase64(totalCount).ToUpper();
        data.Append("<GOODS_FEE>").Append(msg).Append("</GOODS_FEE>");

        msg = EncodeBase64(shuikuanjine).ToUpper();
        data.Append("<TAX_FEE>").Append(msg).Append("</TAX_FEE>");

        //结尾
        data.Append("</ORDER_DETAIL></ORDER_HEAD></DTCFlow></MessageBody></DTC_Message>");
        #endregion
        //发送数据
        try
        {
            string s = "data=";
            s += EncodeBase64("<DTC_Message><MessageHead><MessageType>ORDER_INFO</MessageType><MessageId>" + gd.ToString() +"</MessageId><ActionType>1</ActionType><MessageTime>2014-07-21T13:06:51</MessageTime><SenderId>5005210033</SenderId><ReceiverId>CQITC</ReceiverId><SenderAddress /><ReceiverAddress /><PlatFormNo /><CustomCode /><SeqNo /><Note /><UserNo>5005210033</UserNo><Password>igetmall201455</Password></MessageHead><MessageBody><DTCFlow><ORDER_HEAD><CUSTOMS_CODE>8012</CUSTOMS_CODE><BIZ_TYPE_CODE>I20</BIZ_TYPE_CODE><ORIGINAL_ORDER_NO>2014070415535841</ORIGINAL_ORDER_NO><ESHOP_ENT_CODE>5005210033</ESHOP_ENT_CODE><ESHOP_ENT_NAME>重庆保税港区进出口商品贸易有限公司</ESHOP_ENT_NAME><DESP_ARRI_COUNTRY_CODE>324</DESP_ARRI_COUNTRY_CODE><SHIP_TOOL_CODE>Y</SHIP_TOOL_CODE><RECEIVER_ID_NO>500226198710271112</RECEIVER_ID_NO><RECEIVER_NAME>庄挺</RECEIVER_NAME><RECEIVER_ADDRESS>重庆重庆寸滩保税港区水港综合楼1604室</RECEIVER_ADDRESS><RECEIVER_TEL>13983892879</RECEIVER_TEL><GOODS_FEE>0.01</GOODS_FEE><TAX_FEE>0.00</TAX_FEE><GROSS_WEIGHT>0.6</GROSS_WEIGHT><PROXY_ENT_CODE /><PROXY_ENT_NAME /><ORDER_DETAIL><SKU>1147492340</SKU><GOODS_SPEC>带外壳的保温杯</GOODS_SPEC><CURRENCY_CODE>142</CURRENCY_CODE><PRICE>0.01</PRICE><QTY>1</QTY><GOODS_FEE>0.01</GOODS_FEE><TAX_FEE>0.001</TAX_FEE></ORDER_DETAIL></ORDER_HEAD></DTCFlow></MessageBody></DTC_Message>");

            string t = s;
            string resultStr = GetPostString(url, s);
        }
        catch (Exception ex)
        {
            return;
        }
    }

    //拼凑字符串
    public string HandlerString()
    {
        string str = "";
        return str;
    }

    //post数据
    public string GetPostString(string url, string data)
    {
        try
        {
            byte[] postBytes = Encoding.GetEncoding("utf-8").GetBytes(data);
            HttpWebRequest myRequest = (HttpWebRequest)WebRequest.Create(url);
            myRequest.Method = "POST";
            myRequest.ContentType = "text/xml";
            myRequest.ContentLength = postBytes.Length;
            myRequest.Proxy = null;
            Stream newStream = myRequest.GetRequestStream();
            newStream.Write(postBytes, 0, postBytes.Length);
            newStream.Close();
            // Get response
            HttpWebResponse myResponse = (HttpWebResponse)myRequest.GetResponse();
            using (StreamReader reader = new StreamReader(myResponse.GetResponseStream(), Encoding.GetEncoding("utf-8")))
            {
                string content = reader.ReadToEnd();
                return content;
            }
        }
        catch (System.Exception ex)
        {
            return ex.Message;
        }
    }

    //进行Base64算法加密
    public static string EncodeBase64(string source)
    {
        System.Text.Encoding encode = System.Text.Encoding.UTF8;
        byte[] bytedata = encode.GetBytes(source);
        string strPath = Convert.ToBase64String(bytedata, 0, bytedata.Length);
        strPath.Replace("+", "%2B");
        return strPath;
    }

}