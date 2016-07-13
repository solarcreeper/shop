/*
 * 1. 开发环境：Microsoft Visual Studio 2010
 * 2. 参数有区分大小写，请注意
 * 3. 技术讨论QQ群：99094221[ 验证码：u1city ] 有问题欢迎加入交流
 * 版权 又一城 所有 
 * Author: Linmc
 */
using System;
using System.Collections.Generic;
using System.Xml;
using System.IO;
using U1Api;

public partial class index : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {

    }

    /// <summary>
    /// 获取商品类别信息
    /// </summary>
    protected void btn_Get_Pro_Class_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; 
        lblMsg.Text = "商品类别处理结果：<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.GetProClass", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ===========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                XmlNodeList ApiResultApi_Pro_Class = TempXml.SelectNodes("//Api_Pro_Class");
                if (ApiResultApi_Pro_Class[0].InnerXml != "")
                {
                    for (int i = 0; i < ApiResultApi_Pro_Class.Count; i++)
                    {
                        XmlDocument ProXml = new XmlDocument();
                        ProXml.LoadXml("<tradeInfo>" + ApiResultApi_Pro_Class[i].InnerXml + "</tradeInfo>");
                        string sClassId = Comm.get_Xml_Nodes(ProXml, "//ClassId");//类别编号
                        string sClassName = Comm.get_Xml_Nodes(ProXml, "//ClassName");//类别名称
                        string sClass_N = Comm.get_Xml_Nodes(ProXml, "//Class_N");//1：大类 2：小类]
                        string sClass_N_Id = Comm.get_Xml_Nodes(ProXml, "//Class_N_Id");//大类ID，与ClassId对应，如果是大类Class_N_Id=ClassId
                        lblMsg.Text += "类别编号：" + sClassId + " 类别名称：" + sClassName + " 大类小类：" + sClass_N + " 大类编号：" + sClass_N_Id + "<br/>";
                    }
                }
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ===========
            string sApi_Code = Comm.get_JsonValueByName(sAPIResult, "Code");
            if (sApi_Code == "101")
            {
                string sApi_Result = Comm.get_JsonValueByName(sAPIResult, "Result");
                List<Dto_Pro_Class> listResult = new List<Dto_Pro_Class>();
                listResult = Newtonsoft.Json.JsonConvert.DeserializeObject<List<Dto_Pro_Class>>(sApi_Result);
                for (int i = 0; i < listResult.Count; i++)
                {
                    string sClassId = listResult[i].ClassId.ToString();
                    string sClassName = listResult[i].ClassName;
                    string sClass_N = listResult[i].Class_N;
                    string sClass_N_Id = listResult[i].Class_N_Id;
                    lblMsg.Text += " 类别编号：" + sClassId + " 类别名称：" + sClassName + " 大类小类：" + sClass_N + " 大类编号：" + sClass_N_Id + "<br/>";
                }
            }
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 获取商品信息[该方法限于网渠宝是4.3或4.3以后的版本]
    /// </summary>
    protected void btn_Get_Pro_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "商品信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("proNo", "DDA41854-Q");//商品货号[可填]
        date.Add("proClassCode", "");//商品类别[可填]
        date.Add("proSale", "0");//商品状态[可填] 0：销售中 1：下架 2：全部[默认]
        date.Add("startTime", "");//商品添加开始时间[可填]
        date.Add("endTime", "");//商品添加结束时间[可填]
        date.Add("pageIndex", "1");//页数[必填]
        date.Add("pageSize", "50");//每页数量[必填][数量：10、20、50]
        ///调用接口GetProducts
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.GetProducts", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ===========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                XmlNodeList ApiResultApi_ProductInfo = TempXml.SelectNodes("//Api_ProductInfo");
                if (ApiResultApi_ProductInfo[0].InnerXml != "")
                {
                    for (int i = 0; i < ApiResultApi_ProductInfo.Count; i++)
                    {
                        XmlDocument ProXml = new XmlDocument();
                        ProXml.LoadXml("<tradeInfo>" + ApiResultApi_ProductInfo[i].InnerXml + "</tradeInfo>");
                        #region ========== 商品信息 ==========
                        string sProTitle = Comm.get_Xml_Nodes(ProXml, "//ProTitle");//商品名称
                        string sProNo = Comm.get_Xml_Nodes(ProXml, "//ProNo");//商品货号
                        string sProBrand = Comm.get_Xml_Nodes(ProXml, "//ProBrand");//商品品牌
                        string sProClass = Comm.get_Xml_Nodes(ProXml, "//ProClass");//商品类别
                        string sProShux = Comm.get_Xml_Nodes(ProXml, "//ProShux");//商品属性
                        string sProWeight = Comm.get_Xml_Nodes(ProXml, "//ProWeight");//商品重量
                        string sProSimg = Comm.get_Xml_Nodes(ProXml, "//ProSimg");//商品图片
                        string sProRemark = Comm.get_Xml_Nodes(ProXml, "//ProRemark");//商品说明
                        string sProSale = "";//商品状态[0:销售中 1:下架 2:全部]
                        if (Comm.get_Xml_Nodes(ProXml, "//ProSale") == "0")
                            sProSale = "销售中";
                        else if (Comm.get_Xml_Nodes(ProXml, "//ProSale") == "1")
                            sProSale = "下架";
                        else if (Comm.get_Xml_Nodes(ProXml, "//ProSale") == "2")
                            sProSale = "全部";
                        string sProTagPrice = Comm.get_Xml_Nodes(ProXml, "//ProTagPrice");//市场价
                        string sProFxPrice = Comm.get_Xml_Nodes(ProXml, "//ProFxPrice");//分销价
                        string sProRetPrice = Comm.get_Xml_Nodes(ProXml, "//ProRetPrice");//网店销售价
                        string sProAddTime = Comm.get_Xml_Nodes(ProXml, "//ProAddTime");//商品创建时间
                        #endregion
                        lblMsg.Text += "商品名称：" + sProTitle + " 商品货号：" + sProNo + " 商品品牌：" + sProBrand + " 商品类别：" + sProClass + "商品属性：" + sProShux + " 商品重量：" + sProWeight + " 商品图片：" + sProSimg + " 商品说明：" + sProRemark + "商品状态：" + sProSale + " 市场价：" + sProTagPrice + " 分销价：" + sProFxPrice + " 网店销售价：" + sProRetPrice + " 商品创建时间：" + sProAddTime + "<br/><br/>";
                        XmlNodeList ApiResultProductSpec = ProXml.SelectNodes("//Api_ProductSkuInfo");
                        #region ========== 商品Sku信息 ==========
                        if (ApiResultProductSpec[0].InnerXml != "")
                        {
                            for (int j = 0; j < ApiResultProductSpec.Count; j++)
                            {
                                XmlDocument ProSKUXml = new XmlDocument();
                                ProSKUXml.LoadXml("<tradeInfo>" + ApiResultProductSpec[j].InnerXml + "</tradeInfo>");
                                string sProColorName = Comm.get_Xml_Nodes(ProSKUXml, "//ProColorName");//商品颜色
                                string sProSizesName = Comm.get_Xml_Nodes(ProSKUXml, "//ProSizesName");//商品规格
                                string sProSkuNo = Comm.get_Xml_Nodes(ProSKUXml, "//ProSkuNo");//商品SKu
                                string sWeight = Comm.get_Xml_Nodes(ProSKUXml, "//Weight");//商品重量
                                lblMsg.Text += "商品颜色：" + sProColorName + " 商品规格：" + sProSizesName + " 商品SKu：" + sProSkuNo + " 商品重量：" + sWeight + "<br/>";
                            }
                        }
                        #endregion
                        lblMsg.Text += "----------------------------------------------------------------<br/>";
                    }
                }
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 添加订单
    /// </summary>
    protected void btn_Set_Order_Info_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "订单信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("orderNo", "A00000008");//网店订单编号[必填]
        date.Add("userName", "123");//买家ID[可填]
        date.Add("uName", "123");//收件人姓名[必填]
        date.Add("province", "辽宁");//省份[必填]
        date.Add("city", "锦州市");//城市[必填]
        date.Add("district", "凌河区");//区域[必填]
        date.Add("address", "辽宁锦州市凌河区aaa");//地址[必填]
        date.Add("postcode", "123456");//邮编[必填]
        date.Add("mobiTel", "13912345432");//手机号码[可填][注：手机号码和电话号码至少填一项]
        date.Add("phone", "13912345432");//电话号码[可填][注：手机号码和电话号码至少填一项]
        date.Add("cRemark", "gggfgfgfgfgfgf");//买家留言[可填]
        date.Add("oRemark", "DHL");//卖家备注[可填]
        date.Add("oSumPrice", "250");//实付订单总金额[必填]
        date.Add("expFee", "20");//实付订单运费[可填][默认为0]
        date.Add("expCod", "0");//是否货到付款[必填][1：货到付款]
        date.Add("codFee", "0");//货到付款手续费[可填][默认为0]
        date.Add("expCodFee", "0");//货到付款代收运费[可填][默认为0]
        date.Add("payTime", "2015-04-20 09:44:44");
        
        Dto_Order_Pro_Info model = null;
        List<Dto_Order_Pro_Info> OrderProducts = new List<Dto_Order_Pro_Info>();
        //DataTable Order_Pro_Dt = null;//获取订单商品信息
        //foreach (DataRow dr in Order_Pro_Dt.Rows)
        //{
        model = new Dto_Order_Pro_Info();
        model.proNo = "20150420";//商品货号[必填]
        model.proTitle = "20150420";//商品标题[必填]
        model.proCount = "1";//商品数量[必填]
        model.proPrice = "120";//商品销售价格[必填]
        model.proSku = "2015042000239";//商品Sku[必填]
        OrderProducts.Add(model);

        //model = new Dto_Order_Pro_Info();
        //model.proNo = "571426815";//商品货号[必填]
        //model.proTitle = "361°夏季男子低帮吸汗新款硫化鞋正品男鞋运动鞋帆布鞋";//商品标题[必填]
        //model.proCount = "1";//商品数量[必填]
        //model.proPrice = "119";//商品销售价格[必填]
        //model.proSku = "57142681540002";//商品Sku[必填]//57142681541002 
        //OrderProducts.Add(model);
        //}
        date.Add("OrderPro", Newtonsoft.Json.JsonConvert.SerializeObject(OrderProducts));//订单商品信息
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.AddOrder", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml ==========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                string ApiResultOrderId = Comm.get_Xml_Nodes(TempXml, "//Result");
                lblMsg.Text += "订单编号：" + ApiResultOrderId + "<br/><br/>";
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 订单申请退款
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_AddOrderRefund_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "订单申请退款处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("orderNo", "A2015042000000003");//网店单号[必填]
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.AddOrderRefund", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ===========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                string ApiResultFlag = Comm.get_Xml_Nodes(TempXml, "//Result");
                lblMsg.Text += "订单操作状态：" + ApiResultFlag + "<br/><br/>";
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 取消订单
    /// </summary>
    protected void btn_Cancel_Order_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "取消订单处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("orderId", "2015032600002339");//订单单[必填]
        date.Add("cancelReason", "退款rr");//订单取消原因[必填]
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.CancelOrderState", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ===========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                string ApiResultFlag = Comm.get_Xml_Nodes(TempXml, "//Result");
                lblMsg.Text += "订单操作状态：" + ApiResultFlag + "<br/><br/>";
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 获得商品库存信息
    /// </summary>
    protected void btn_Get_Pro_Sku_Info_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "商品库存处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("proSkuNo", "W942118,W840006,W741003");//商品Sku[必填]
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.GetProductSkuInfo", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ===========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                string sProTitle = Comm.get_Xml_Nodes(TempXml, "//ProTitle");//商品标题
                string sProNo = Comm.get_Xml_Nodes(TempXml, "//ProNo");//商品货号
                string sProColorName = Comm.get_Xml_Nodes(TempXml, "//ProColorName");//颜色名称
                string sProSizesName = Comm.get_Xml_Nodes(TempXml, "//ProSizesName");//规格名称
                string sProSkuNo = Comm.get_Xml_Nodes(TempXml, "//ProSkuNo");//商品Sku
                string sProCount = Comm.get_Xml_Nodes(TempXml, "//ProCount");//商品数量
                lblMsg.Text += "商品标题：" + sProTitle + " 商品货号：" + sProNo + " 商品颜色：" + sProColorName + " 商品规格：" + sProSizesName + "商品Sku：" + sProSkuNo + " 商品数量：" + sProCount + "<br/>";
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            string ApiCode = Comm.get_JsonValueByName(sAPIResult, "Code");
            if (ApiCode == "101")
            {
                string ApiResult = Comm.get_JsonValueByName(sAPIResult, "Result");
                List<Dto_Pro_Sku_Info> listResult = new List<Dto_Pro_Sku_Info>();
                listResult = Newtonsoft.Json.JsonConvert.DeserializeObject<List<Dto_Pro_Sku_Info>>(ApiResult);
                for (int i = 0; i < listResult.Count; i++)
                {
                    string ProTitle = listResult[i].ProTitle.ToString();
                    string ProNo = listResult[i].ProNo.ToString();
                    string ProColorName = listResult[i].ProColorName.ToString();
                    string ProSizesName = listResult[i].ProSizesName.ToString();
                    string ProSkuNo = listResult[i].ProSkuNo.ToString();
                    string ProCount = listResult[i].ProCount.ToString();
                    lblMsg.Text += "商品名称：" + ProTitle + " ，商品货号：" + ProNo + " ，商品颜色：" + ProColorName + " ，商品规格:" + ProSizesName + " ，商品SKU：" + ProSkuNo + " ，商品可用库存：" + ProCount + "<br/>";
                }
            }
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 查询订单信息
    /// </summary>
    protected void btn_Select_OrderData_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "订单信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("orderId", "");//订单编号[可填]
        date.Add("orderNo", "");//网店订单号[可填]
        date.Add("orderStatus", "");//订单状态[可填][0：全部[默认] 1: 等待分配仓库 2: 已分配仓库 3: 等待仓库拣货 4: 订单发货中 5: 部分发货 6: 仓库已发货]
        date.Add("startTime", "2013-01-01 00:00:00");//订单开始时间[可填]
        date.Add("endTime", "2015-11-27 00:00:00");//订单结束时间[可填]
        date.Add("pageIndex", "1");//页数[可填]
        date.Add("pageSize", "20");//每页数量[可填][数量： 10、20、50]
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.GetOrder", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ===========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                XmlNodeList ApiResultApi_SelectOrderInfo = TempXml.SelectNodes("//Api_SelectOrderInfo");
                if (ApiResultApi_SelectOrderInfo[0].InnerXml != "")
                {
                    //    for (int i = 0; i < ApiResultApi_SelectOrderInfo.Count; i++)
                    //    {
                    //        string sOrder = "", sOrderPro = "", sOrderReceipt = "", sSaleAfter = "";
                    //        XmlDocument OrderXml = new XmlDocument();
                    //        OrderXml.LoadXml("<tradeInfo>" + ApiResultApi_SelectOrderInfo[i].InnerXml + "</tradeInfo>");
                    //        #region ========== 订单信息 ==========
                    //        string sOrderId = Comm.get_Xml_Nodes(OrderXml, "//OrderId");//系统订单编号
                    //        string sOrderNo = Comm.get_Xml_Nodes(OrderXml, "//OrderNo");//网店订单编号
                    //        string sFxsNo = Comm.get_Xml_Nodes(OrderXml, "//FxsNo");//分销商
                    //        string sProClass = Comm.get_Xml_Nodes(OrderXml, "//EShopName");//网店名称
                    //        string sC_UserName = Comm.get_Xml_Nodes(OrderXml, "//C_UserName");//买家ID
                    //        string sC_Name = Comm.get_Xml_Nodes(OrderXml, "//C_Name");//收件人姓名

                    //        string sC_Province = Comm.get_Xml_Nodes(OrderXml, "//Province");//省份
                    //        string sC_Address = Comm.get_Xml_Nodes(OrderXml, "//Address");//地址
                    //        string sC_MobiTel = Comm.get_Xml_Nodes(OrderXml, "//MobiTel");//手机号码
                    //        string sC_Phone = Comm.get_Xml_Nodes(OrderXml, "//Phone");//电话号码
                    //        string sC_PostCode = Comm.get_Xml_Nodes(OrderXml, "//PostCode");//邮政编号

                    //        string sC_Remark = Comm.get_Xml_Nodes(OrderXml, "//C_Remark");//买家留言
                    //        string sO_Remark = Comm.get_Xml_Nodes(OrderXml, "//O_Remark");//卖家备注
                    //        string sPro_Sum = Comm.get_Xml_Nodes(OrderXml, "//OrderSumPrice");//订单实付金额
                    //        string sExp_Fee = Comm.get_Xml_Nodes(OrderXml, "//Exp_Fee");//实付订单运费
                    //        string sExp_Name = Comm.get_Xml_Nodes(OrderXml, "//Exp_Name");//快递名称
                    //        string sExp_Cod = Comm.get_Xml_Nodes(OrderXml, "//Exp_Cod");//货到付款订单
                    //        string sCod_Fee = Comm.get_Xml_Nodes(OrderXml, "//Cod_Fee");//货到付款手续费
                    //        string sExp_Codfee = Comm.get_Xml_Nodes(OrderXml, "//Exp_Codfee");//货到付款代收运费
                    //        string sOrder_Flag = Comm.get_Xml_Nodes(OrderXml, "//Order_Flag");//订单状态
                    //        string sAddTime = Comm.get_Xml_Nodes(OrderXml, "//AddTime");//订单创建时间
                    //        ///订单发票
                    //        XmlNodeList ApiResultReceiptSpec = OrderXml.SelectNodes("//ReceiptSpec");
                    //        for (int j = 0; j < ApiResultReceiptSpec.Count; j++)
                    //        {
                    //            XmlDocument ReceiptSpecXml = new XmlDocument();
                    //            ReceiptSpecXml.LoadXml("<tradeInfo>" + ApiResultReceiptSpec[j].InnerXml + "</tradeInfo>");
                    //            string sReceiptType = Comm.get_Xml_Nodes(ReceiptSpecXml, "//ReceiptType");//发票类型
                    //            string sReceiptName = Comm.get_Xml_Nodes(ReceiptSpecXml, "//ReceiptName");//发票抬头
                    //            string sReceiptDetails = Comm.get_Xml_Nodes(ReceiptSpecXml, "//ReceiptDetails");//发票内容
                    //            sOrderReceipt += "发票类型：" + sReceiptType + " 发票抬头：" + sReceiptName + " 发票内容：" + sReceiptDetails + "<br/>";
                    //        }
                    //        ///订单商品
                    //        XmlNodeList ApiResultProSpec = OrderXml.SelectNodes("//ProSpec");
                    //        if (ApiResultProSpec[0].InnerXml != "")
                    //        {
                    //            for (int j = 0; j < ApiResultProSpec.Count; j++)
                    //            {
                    //                XmlDocument ProSpecXml = new XmlDocument();
                    //                ProSpecXml.LoadXml("<tradeInfo>" + ApiResultProSpec[j].InnerXml + "</tradeInfo>");
                    //                string sProTitle = Comm.get_Xml_Nodes(ProSpecXml, "//proTitle");//商品标题
                    //                string sProNo = Comm.get_Xml_Nodes(ProSpecXml, "//proNo");//商品货号
                    //                string sProSku = Comm.get_Xml_Nodes(ProSpecXml, "//proSku");//商品SKU
                    //                string sProPrice = Comm.get_Xml_Nodes(ProSpecXml, "//proPrice");//商品价格
                    //                string sProCount = Comm.get_Xml_Nodes(ProSpecXml, "//proCount");//商品数量
                    //                string sProColorName = Comm.get_Xml_Nodes(ProSpecXml, "//ProColorName");//商品颜色
                    //                string sProSizesName = Comm.get_Xml_Nodes(ProSpecXml, "//ProSizesName");//商品规格
                    //                sOrderPro += "商品标题：" + sProTitle + " 商品货号：" + sProNo + " 商品SKU：" + sProSku + " 商品价格：" + sProPrice + "商品数量：" + sProCount + " 商品颜色：" + sProColorName + " 商品规格：" + sProSizesName + "<br/><br/>";
                    //            }
                    //        }
                    //        ///出库单信息
                    //        XmlNodeList ApiResultSaleAfterSpec = OrderXml.SelectNodes("//SaleAfterSpec");
                    //        if (ApiResultSaleAfterSpec[0].InnerXml != "")
                    //        {
                    //            for (int j = 0; j < ApiResultSaleAfterSpec.Count; j++)
                    //            {
                    //                XmlDocument SaleAfterSpecXml = new XmlDocument();
                    //                SaleAfterSpecXml.LoadXml("<tradeInfo>" + ApiResultSaleAfterSpec[j].InnerXml + "</tradeInfo>");
                    //                string sBillNo = Comm.get_Xml_Nodes(SaleAfterSpecXml, "//BillNo");//出库单号
                    //                string sSkuNo = Comm.get_Xml_Nodes(SaleAfterSpecXml, "//SkuNo");//商品Sku
                    //                string sProCount = Comm.get_Xml_Nodes(SaleAfterSpecXml, "//ProCount");//商品数量
                    //                string sExpName = Comm.get_Xml_Nodes(SaleAfterSpecXml, "//ExpName");//快递名称
                    //                string sExpNum = Comm.get_Xml_Nodes(SaleAfterSpecXml, "//ExpNum");//快递单号
                    //                string sStatus = Comm.get_Xml_Nodes(SaleAfterSpecXml, "//Status");//出库单状态
                    //                sSaleAfter += "出库单号：" + sBillNo + " 商品Sku：" + sSkuNo + " 商品数量：" + sProCount + " 快递名称：" + sExpName + "快递单号：" + sExpNum + " 出库单状态：" + sStatus + "<br/><br/>";
                    //            }
                    //        }
                    //        #endregion
                    //        sOrder += "系统订单编号：" + sOrderId + " 网店订单编号：" + sOrderNo + " 分销商：" + sFxsNo + " 网店名称：" + sProClass + "买家ID：" + sC_UserName + " 收件人姓名：" + sC_Name + " 省份：" + sC_Province + "  地址：" + sC_Address + "  手机号码：" + sC_MobiTel + "  电话号码：" + sC_Phone + "  邮政编号：" + sC_PostCode + " 买家留言：" + sC_Remark + " 卖家备注：" + sO_Remark + "订单实付金额：" + sPro_Sum + " 实付订单运费：" + sExp_Fee + " 物流公司名称：" + sExp_Name + " 货到付款订单：" + sExp_Cod + " 货到付款手续费：" + sCod_Fee + " 货到付款代收运费：" + sExp_Codfee + " 订单状态：" + sOrder_Flag + " 订单创建时间：" + sAddTime + "<br/><br/>";
                    //        lblMsg.Text += sOrder + "<br/>" + sOrderPro + "<br/>" + sOrderReceipt + "<br/>" + sSaleAfter + "<br/>";
                    //        lblMsg.Text += "----------------------------------------------------------------<br/>";
                    //    }
                }
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }
    /// <summary>
    /// 查询订单发货信息
    /// </summary>
    protected void btn_Select_Order_Deliver_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "订单发货信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("orderId", "B2015071700003");//系统订单号[可填][注：订单号和网店订单号至少填一项]
        date.Add("orderNo", "");//网店订单号[可填][注：订单号和网店订单号至少填一项]
        date.Add("billCode", "");//出库单号[可填]
        date.Add("proSkuNo", "");//商品Sku[必填]
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.GetOrderDeliver", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ===========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                XmlNodeList ApiResultApi_SelectOrderDeliverInfo = TempXml.SelectNodes("//Api_SelectOrderDeliverInfo");
                if (ApiResultApi_SelectOrderDeliverInfo[0].InnerXml != "")
                {
                    for (int i = 0; i < ApiResultApi_SelectOrderDeliverInfo.Count; i++)
                    {
                        XmlDocument OrderDeliverInfoXml = new XmlDocument();
                        OrderDeliverInfoXml.LoadXml("<tradeInfo>" + ApiResultApi_SelectOrderDeliverInfo[i].InnerXml + "</tradeInfo>");
                        string sOrderId = Comm.get_Xml_Nodes(OrderDeliverInfoXml, "//OrderId");//系统订单编号
                        string sBillNo = Comm.get_Xml_Nodes(OrderDeliverInfoXml, "//BillNo");//系统出库单号
                        string sSkuNo = Comm.get_Xml_Nodes(OrderDeliverInfoXml, "//SkuNo");//商品Sku
                        string sProCount = Comm.get_Xml_Nodes(OrderDeliverInfoXml, "//ProCount");//商品数量
                        string sExpName = Comm.get_Xml_Nodes(OrderDeliverInfoXml, "//ExpName");//快递名称
                        string sExpNum = Comm.get_Xml_Nodes(OrderDeliverInfoXml, "//ExpNum");//快递编号
                        lblMsg.Text += "系统订单编号：" + sOrderId + " 系统出库单号：" + sBillNo + " 商品Sku：" + sSkuNo + " 商品数量：" + sProCount + "快递名称：" + sExpName + " 快递编号：" + sExpNum + "<br/><br/>";
                        lblMsg.Text += "----------------------------------------------------------------<br/>";
                    }
                }
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 添加售后记录
    /// </summary>
    protected void btn_AddExchangeOrderProduct_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "添加售后记录处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("orderId", "2015051300000077");//订单编号[必填]
        date.Add("outBillNo", "XSC2015051300002");//出库单号[必填]
        date.Add("duty", "1");//责任方[2：供应商 1：顾客][必填]
        date.Add("refundFreight", "0");//退给顾客的运费[可填]
        date.Add("exchangeReason", "顾客买错了");//退货/换货原因[必填]
        date.Add("exchangeType", "2");//退换货类型[1：退货  2：换货][必填]
        date.Add("exchangeSerial", "lin000003");//退换货申请单号[必填]
        Dto_Exchange_Pro_Info model = null;
        List<Dto_Exchange_Pro_Info> ExchangeProducts = new List<Dto_Exchange_Pro_Info>();
        //DataTable Exchange_Pro_Dt = null;//获得售后商品信息
        //foreach (DataRow dr in Exchange_Pro_Dt.Rows)
        //{
        model = new Dto_Exchange_Pro_Info();
        model.SkuCode = "101102203004B";//商品Sku[必填]
        model.ProductNumber = "1";//商品数量[必填]
        model.RefundAmount = "159";//退款金额[必填]
        ExchangeProducts.Add(model);
        //}
        date.Add("ExchangeProduct", Newtonsoft.Json.JsonConvert.SerializeObject(ExchangeProducts));//订单商品信息   
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.AddExchangeOrderProduct", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ==========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                string ApiResultBillNo = Comm.get_Xml_Nodes(TempXml, "//Result");
                lblMsg.Text += "退换货申请单号：" + ApiResultBillNo + "<br/><br/>";
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 售后快递信息
    /// </summary>
    protected void btn_Add_ExchangeOrderExpress_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "售后快递信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("billNo", "SHD2015051300009");//售后单号[必填]
        date.Add("expressCompanyName", "sf");//物流标签[必填](详细的物流标签请购物流标签.xml文件)
        date.Add("expressCode", "a0001");//快递单号[必填]
        date.Add("expressFreight", "30");//快递运费[必填]
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.ExchangeOrderExpress", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ==========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                string ApiResultResult = Comm.get_Xml_Nodes(TempXml, "//Result");
                lblMsg.Text += "售后快递操作状态：" + ApiResultResult + "<br/><br/>";
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 售后确认收货
    /// </summary>
    protected void btn_ExchangeOrderProductState_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "售后确认收货信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("billNo", "SHD2015051800002");//退换货申请单号[必填]
        date.Add("thProOk", "0");//问题类型[0：无其它问题，可以退换货 1：有问题，需要协商][必填]
        date.Add("thDuty", "1");//责任方[1：顾客，2：仓库，4：渠道商，5：快递][可填][Th_Pro_Ok值是0，责任方必填] 
        date.Add("thDutyPerson", ""); //责任方为仓库或渠道商时，传入：仓库责任人或渠道商责任人。暂时传空值，接口默认值为当前仓库端主管或渠道商主管。
        date.Add("thProRemark", "要要要");//备注[可填][thProOk值是1，商品问题描述必填]

        Dto_Submit_Exchange_Pro model = null;
        List<Dto_Submit_Exchange_Pro> OrderProducts = new List<Dto_Submit_Exchange_Pro>();
        //DataTable Order_Pro_Dt = null;//获取订单商品信息
        //foreach (DataRow dr in Order_Pro_Dt.Rows)
        //{
        model = new Dto_Submit_Exchange_Pro();
        model.SkuNo = "101102203004B";//商品Sku[必填]
        model.TProNum = "2";//商品数量[必填]
        OrderProducts.Add(model);
        //}
        date.Add("ExchangePro", Newtonsoft.Json.JsonConvert.SerializeObject(OrderProducts));//售后商品信息  
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.ExchangeOrderProductState", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ==========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                string ApiResultResult = Comm.get_Xml_Nodes(TempXml, "//Result");
                lblMsg.Text += "操作状态：" + ApiResultResult + "<br/><br/>";
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 取消售后记录
    /// </summary>
    protected void btn_CancelExchangeOrderProduct_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "售后取消信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("billNo", "XSC2014050500008");//退换货申请单号[必填]
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.CancelExchangeOrderProduct", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ==========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                string ApiResultResult = Comm.get_Xml_Nodes(TempXml, "//Result");
                lblMsg.Text += "取消状态：" + ApiResultResult + "<br/><br/>";
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 查询售后记录
    /// </summary>
    protected void btn_SelectExchangeOrderProduct_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "查询退换货申请信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("billNo", "");//售后单号[可填]
        date.Add("orderId", "");// 系统订单号[可填]
        date.Add("exchangeStatus", "30");//售后状态[可填][为空：默认全部 0: 已生成 10: 等待退货 20: 等待收货 30: 已结束]
        date.Add("startTime", "2015-01-23 18:34:36.000");//售后起始时间[必填]
        date.Add("endTime", "2015-05-23 18:34:36.000");//售后结束时间[必填]
        date.Add("pageIndex", "1");//页数[必填]
        date.Add("pageSize", "50");//每页条数[必填][数量： 10、20、50]
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.GetExchangeOrderProduct", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ===========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                XmlNodeList ApiResultApi_SelectExchangeInfo = TempXml.SelectNodes("//Api_SelectExchangeInfo");
                if (ApiResultApi_SelectExchangeInfo[0].InnerXml != "")
                {
                    for (int i = 0; i < ApiResultApi_SelectExchangeInfo.Count; i++)
                    {
                        string sExchangeInfo = "", sExchangePro = "";
                        XmlDocument ExchangeXml = new XmlDocument();
                        ExchangeXml.LoadXml("<tradeInfo>" + ApiResultApi_SelectExchangeInfo[i].InnerXml + "</tradeInfo>");
                        string sBillNo = Comm.get_Xml_Nodes(ExchangeXml, "//BillNo");//售后记录号
                        string sOrderId = Comm.get_Xml_Nodes(ExchangeXml, "//OrderId");//系统订单号
                        string sOutBillNo = Comm.get_Xml_Nodes(ExchangeXml, "//OutBillNo");//出库单号
                        string sThDuty = Comm.get_Xml_Nodes(ExchangeXml, "//ThDuty");//责任方
                        string sThRemark = Comm.get_Xml_Nodes(ExchangeXml, "//ThRemark");//售后原因
                        string sOrderTh = Comm.get_Xml_Nodes(ExchangeXml, "//OrderTh");//售后类型
                        string sTeShopExpPrice = Comm.get_Xml_Nodes(ExchangeXml, "//TeShopExpPrice");//退给顾客的运费
                        string sThExpName = Comm.get_Xml_Nodes(ExchangeXml, "//ThExpName");//寄回快递公司
                        string sThExpNum = Comm.get_Xml_Nodes(ExchangeXml, "//ThExpNum");//寄回快递单号
                        string sThExpPrice = Comm.get_Xml_Nodes(ExchangeXml, "//ThExpPrice");//寄回快递运费
                        string sReceiveRemark = Comm.get_Xml_Nodes(ExchangeXml, "//ReceiveRemark");//商品问题
                        string sStatus = Comm.get_Xml_Nodes(ExchangeXml, "//Status");//售后记录状态
                        string sThAudit = Comm.get_Xml_Nodes(ExchangeXml, "//ThAudit");//审核状态
                        string sCancelStatus = Comm.get_Xml_Nodes(ExchangeXml, "//CancelStatus");//取消状态
                        string sAddTime = Comm.get_Xml_Nodes(ExchangeXml, "//AddTime");//创建时间
                        string sReceiveTime = Comm.get_Xml_Nodes(ExchangeXml, "//ReceiveTime");//结束时间
                        sExchangeInfo += "售后记录号：" + sBillNo + " 系统订单号：" + sOrderId + " 出库单号：" + sOutBillNo + " 责任方：" + sThDuty + "售后原因：" + sThRemark + " 售后类型：" + sOrderTh + " 退给顾客的运费：" + sTeShopExpPrice + " 寄回快递公司：" + sThExpName + " 寄回快递单号：" + sThExpNum + " 寄回快递运费：" + sThExpPrice + " 商品问题：" + sReceiveRemark + " 售后记录状态：" + sStatus + " 审核状态：" + sThAudit + " 取消状态：" + sCancelStatus + " 创建时间：" + sAddTime + " 结束时间：" + sReceiveTime + "<br/><br/>";
                        #region ========== 售后商品 ==========
                        XmlNodeList ApiResultExchangeProSpec = ExchangeXml.SelectNodes("//ExchangeProSpec");
                        if (ApiResultExchangeProSpec[0].InnerXml != "")
                        {
                            for (int j = 0; j < ApiResultExchangeProSpec.Count; j++)
                            {
                                XmlDocument ExchangeProSpecXml = new XmlDocument();
                                ExchangeProSpecXml.LoadXml("<tradeInfo>" + ApiResultExchangeProSpec[j].InnerXml + "</tradeInfo>");
                                string sSkuNo = Comm.get_Xml_Nodes(ExchangeProSpecXml, "//SkuNo");//商品Sku
                                string sTProCount = Comm.get_Xml_Nodes(ExchangeProSpecXml, "//TProCount");//商品退换数量
                                string sTEshopPrice = Comm.get_Xml_Nodes(ExchangeProSpecXml, "//TEshopPrice");//商品退换金额
                                sExchangePro += "商品Sku：" + sSkuNo + " 商品退换数量：" + sTProCount + " 商品退换金额：" + sTEshopPrice + "<br/><br/>";
                            }
                        }
                        #endregion
                        lblMsg.Text += sExchangeInfo + "<br/>" + sExchangePro + "<br/>";
                        lblMsg.Text += "----------------------------------------------------------------<br/>";
                    }
                }
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 更新商品库存
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_Get_Pro_Sku_Num_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "更新商品库存信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("proSkuNo", "10002901080");//商品SKU[必填]
        date.Add("proNum", "0");//数量[必填]

        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.UpdateProductSkuNum", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== XML返回 ==========
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    protected void btn_UpdateProSkuInventory_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "更新商品库存信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("orderNo", "C0003");
        date.Add("oType", "1");////0：增量 1：减量
        date.Add("proSkuNo", "nilong002");//商品SKU[必填]
        date.Add("proNum", "12");//数量[必填]

        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.UpdateProSkuInventory", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== XML返回 ==========
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 获取采购出入库单[弃用1.0]
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_Get_Proc_Info_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "采购出入库单信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("flag", "1");////状态[0、所有[默认] 1、未提交（指已生成，未提交审核）2、未入库（指已提交审核，还未进行审核）3、已入库（指已审核入库）]
        date.Add("startTime", "2013-01-23 18:34:36.000");//采购出入库单起始时间[必填]
        date.Add("endTime", "2016-01-23 18:34:36.000");//采购出入库单结束时间[必填]
        date.Add("pageIndex", "1");//页数[必填]
        date.Add("pageSize", "50");//每页条数[必填][数量： 10、20、50]

        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.Get_Proc_List", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== XML返回 ==========
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }
    /// <summary>
    /// 获取供应商[仓库端]
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_GetSupplier_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "获取供应商信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]        

        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.GetSupplier", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== XML返回 ==========
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }
    /// <summary>
    /// 获取快递公司[仓库端]
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_Get_Express_List_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "获取快递公司信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]        

        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.Get_Express_List", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== XML返回 ==========
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }
    /// <summary>
    /// 出入库单提交[仓库端][弃用1.0]
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_Submit_Proc_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "出入库单提交信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("procNo", "CGR2015051300000019");//出入库单号[必填]

        Dto_Proc_Pro_Info model = null;
        List<Dto_Proc_Pro_Info> ProcProducts = new List<Dto_Proc_Pro_Info>();
        //DataTable Order_Pro_Dt = null;//获取订单商品信息
        //foreach (DataRow dr in Order_Pro_Dt.Rows)
        //{
        model = new Dto_Proc_Pro_Info();
        model.Pro_Title = "超级运动鞋2014";//商品标题
        model.Pro_No = "K912";//商品货号[必填]        
        model.Sku_No = "101102203004B";//商品SKU[必填]
        model.Pro_Color_Sizes = "颜色：天蓝色，规格：41";//商品颜色与规格
        model.Pro_Count = "500";//数量[必填]
        ProcProducts.Add(model);
        //}
        date.Add("ProcProduct", Newtonsoft.Json.JsonConvert.SerializeObject(ProcProducts));//订单商品信息     

        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.Submit_Proc", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== XML返回 ==========
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 查询出库单
    /// </summary>
    protected void btn_Get_SaleStock_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "查询出库单信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("billNo", "XSC2015071700026");//出库单号
        date.Add("status", "1");//状态[0：已生成；1：已出库；2：已取消 默认全部]
        date.Add("startTime", "2014-05-10 15:25:04");//开始时间[必填]
        date.Add("endTime", "2016-09-20 15:10:35");//结束时间[必填]
        date.Add("pageIndex", "1");//页数[必填]
        date.Add("pageSize", "50");//每页条数[必填][数量： 10、20、50]
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.GetSaleStock", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ===========
            StringReader Reader = new StringReader(sAPIResult);
            XmlDocument TempXml = new XmlDocument();
            TempXml.Load(Reader);
            string ApiResultMessage = Comm.get_Xml_Nodes(TempXml, "//Message");
            string ApiResultCode = Comm.get_Xml_Nodes(TempXml, "//Code");
            if (ApiResultCode == "101")
            {
                //XmlNodeList ApiResultApi_SelectOrderDeliverInfo = TempXml.SelectNodes("//Api_SelectOrderDeliverInfo");
                //if (ApiResultApi_SelectOrderDeliverInfo[0].InnerXml != "")
                //{
                //    for (int i = 0; i < ApiResultApi_SelectOrderDeliverInfo.Count; i++)
                //    {
                //        XmlDocument OrderDeliverInfoXml = new XmlDocument();
                //        OrderDeliverInfoXml.LoadXml("<tradeInfo>" + ApiResultApi_SelectOrderDeliverInfo[i].InnerXml + "</tradeInfo>");
                //        string sOrderId = Comm.get_Xml_Nodes(OrderDeliverInfoXml, "//OrderId");//系统订单编号
                //        string sBillNo = Comm.get_Xml_Nodes(OrderDeliverInfoXml, "//BillNo");//系统出库单号
                //        string sSkuNo = Comm.get_Xml_Nodes(OrderDeliverInfoXml, "//SkuNo");//商品Sku
                //        string sProCount = Comm.get_Xml_Nodes(OrderDeliverInfoXml, "//ProCount");//商品数量
                //        string sExpName = Comm.get_Xml_Nodes(OrderDeliverInfoXml, "//ExpName");//快递名称
                //        string sExpNum = Comm.get_Xml_Nodes(OrderDeliverInfoXml, "//ExpNum");//快递编号
                //        lblMsg.Text += "系统订单编号：" + sOrderId + " 系统出库单号：" + sBillNo + " 商品Sku：" + sSkuNo + " 商品数量：" + sProCount + "快递名称：" + sExpName + " 快递编号：" + sExpNum + "<br/><br/>";
                //        lblMsg.Text += "----------------------------------------------------------------<br/>";
                //    }
                //}
            }
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 出库单发货
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_SetSaleStockDeliver_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "出库单发货信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("billNo", "XSC2015051800405");//出库单号[必填]
        date.Add("expCode", "802542777564");//快递单号[必填]
        date.Add("expName", "YTO");//物流标签[必填] (详细的物流标签请购物流标签.xml文件)
        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.SetSaleStockDeliver", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== Xml返回 ===========

            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }
    
    /// <summary>
    /// 获取采购出入库单[弃用1.1]
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_Get_Proc_Data_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "采购出入库单信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("flag", "1");////状态[0、所有[默认] 1、未提交（指已生成，未提交审核）2、未入库（指已提交审核，还未进行审核）3、已入库（指已审核入库）]
        date.Add("submitFlag", "2");//提交状态[0、所有[默认] 1、未提交 2、已提交 3、已返回] 注意：当状态[flag]参数值为1时，该参数才有效
        date.Add("procType", "1");//1、采购入库 2、采购出库 3、其它入库 4、其它出库
        date.Add("startTime", "2013-01-23 18:34:36.000");//采购出入库单起始时间[必填]
        date.Add("endTime", "2016-01-23 18:34:36.000");//采购出入库单结束时间[必填]
        date.Add("pageIndex", "1");//页数[必填]
        date.Add("pageSize", "50");//每页条数[必填][数量： 10、20、50]

        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.Get_Proc_Data", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== XML返回 ==========
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }
    /// <summary>
    /// 提交采购出入库单[弃用1.1]
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_Submit_Proc_Data_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "出入库单提交信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("procNo", "CGR2015051200000020");//出入库单号[必填]

        Dto_Proc_Pro_Info model = null;
        List<Dto_Proc_Pro_Info> ProcProducts = new List<Dto_Proc_Pro_Info>();
        //DataTable Order_Pro_Dt = null;//获取订单商品信息
        //foreach (DataRow dr in Order_Pro_Dt.Rows)
        //{
        model = new Dto_Proc_Pro_Info();
        model.id = "24";
        model.Pro_Title = "斜挎包";//商品标题
        model.Pro_No = "1011123";//商品货号[必填]        
        model.Sku_No = "1011123030041";//商品SKU[必填]
        model.Pro_Color_Sizes = "颜色：黑，规格：均码";//商品颜色与规格
        model.Pro_Count = "5";//数量[必填]
        ProcProducts.Add(model);
        //}
        date.Add("ProcProduct", Newtonsoft.Json.JsonConvert.SerializeObject(ProcProducts));//订单商品信息     

        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.Submit_Proc_Data", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== XML返回 ==========
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }
    /// <summary>
    /// 获取采购入库单
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_Get_Proc_In_Data_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "获取采购入库单信息：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("flag", "1");////状态[0、所有[默认] 1、未提交（指已生成，未提交审核）2、未入库（指已提交审核，还未进行审核）3、已入库（指已审核入库）]
        date.Add("procType", "1");//1、采购入库 2、其它入库
        date.Add("startTime", "2013-01-23 18:34:36.000");//采购出入库单起始时间[必填]
        date.Add("endTime", "2016-01-23 18:34:36.000");//采购出入库单结束时间[必填]
        date.Add("pageIndex", "1");//页数[必填]
        date.Add("pageSize", "50");//每页条数[必填][数量： 10、20、50]

        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.Get_Proc_In_Data", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== XML返回 ==========
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }
    /// <summary>
    /// 提交采购入库单
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_Submit_Proc_In_Data_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "采购入库单提交信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("procNo", "CGR2015072100000020");//出入库单号[必填]

        Dto_Proc_Pro_Info model = null;
        List<Dto_Proc_Pro_Info> ProcProducts = new List<Dto_Proc_Pro_Info>();
        //DataTable Order_Pro_Dt = null;//获取订单商品信息
        //foreach (DataRow dr in Order_Pro_Dt.Rows)
        //{
        model = new Dto_Proc_Pro_Info();
        model.id = "3233";
        model.Pro_Title = "精品红富士";//商品标题
        model.Pro_No = "una714001";//商品货号[必填]        
        model.Sku_No = "una714001003001";//商品SKU[必填]
        model.Pro_Color_Sizes = "颜色：红色，规格：14";//商品颜色与规格
        model.Pro_Count = "12";//数量[必填]
        ProcProducts.Add(model);
        //}
        date.Add("ProcProduct", Newtonsoft.Json.JsonConvert.SerializeObject(ProcProducts));//订单商品信息     

        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.Submit_Proc_In_Data", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== XML返回 ==========
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }
    /// <summary>
    /// 获取采购出库单
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_Get_Proc_Out_Data_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "采购出库单信息：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("flag", "1");////状态[0、所有[默认] 1、未提交（指已生成，未提交审核）2、未入库（指已提交审核，还未进行审核）3、已入库（指已审核入库）]
        date.Add("procType", "1");//1、采购出库 2、其它出库
        date.Add("startTime", "2013-01-23 18:34:36.000");//采购出入库单起始时间[必填]
        date.Add("endTime", "2016-01-23 18:34:36.000");//采购出入库单结束时间[必填]
        date.Add("pageIndex", "1");//页数[必填]
        date.Add("pageSize", "50");//每页条数[必填][数量： 10、20、50]

        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.Get_Proc_Out_Data", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== XML返回 ==========
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }
    /// <summary>
    /// 提交采购出库单
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_Submit_Proc_Out_Data_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "采购出库单提交信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("procNo", "CGR2015051200000020");//出入库单号[必填]

        Dto_Proc_Pro_Info model = null;
        List<Dto_Proc_Pro_Info> ProcProducts = new List<Dto_Proc_Pro_Info>();
        //DataTable Order_Pro_Dt = null;//获取订单商品信息
        //foreach (DataRow dr in Order_Pro_Dt.Rows)
        //{
        model = new Dto_Proc_Pro_Info();
        model.id = "24";
        model.Pro_Title = "斜挎包";//商品标题
        model.Pro_No = "1011123";//商品货号[必填]        
        model.Sku_No = "1011123030041";//商品SKU[必填]
        model.Pro_Color_Sizes = "颜色：黑，规格：均码";//商品颜色与规格
        model.Pro_Count = "5";//数量[必填]
        ProcProducts.Add(model);
        //}
        date.Add("ProcProduct", Newtonsoft.Json.JsonConvert.SerializeObject(ProcProducts));//订单商品信息     

        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.Submit_Proc_Out_Data", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== XML返回 ==========
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }

    /// <summary>
    /// 批量更新商品库存信息[增量、减量]
    /// </summary>
    /// <param name="sender"></param>
    /// <param name="e"></param>
    protected void btn_BatchUpdateProSkuInventory_Click(object sender, EventArgs e)
    {
        txtMsg.Text = ""; lblMsg.Text = "更新商品库存信息处理结果：<br>-------------------------------------------------------------------------------<br><br>";
        ///接口参数
        Dictionary<string, string> date = new Dictionary<string, string>();
        date.Add("appKey", txtApiKey.Text);//AppKey[必填]
        date.Add("orderNo", "C007");

        Api_Inventory_ProSkuInfo model = null;
        List<Api_Inventory_ProSkuInfo> proSkuList = new List<Api_Inventory_ProSkuInfo>();
        model = new Api_Inventory_ProSkuInfo();
        model.OType = "1";//操作类型[0：增加(默认) 1：减少]
        model.ProNum = "12";
        model.SkuNo = "W540005";
        proSkuList.Add(model);

        //model = new Api_Inventory_ProSkuInfo();
        //model.OType = "1";//操作类型[0：增加(默认) 1：减少]
        //model.ProNum = "15";
        //model.SkuNo = "W741003";
        //proSkuList.Add(model);

        date.Add("proSku", Newtonsoft.Json.JsonConvert.SerializeObject(proSkuList));//批量库存更新商品信息

        ///调用接口
        Client client = new Client(txtApiUrl.Text, "IOpenAPI.BatchUpdateProSkuInventory", txtApiKey.Text, txtApiSerect.Text, ddlApiResultType.SelectedValue);
        ///获得接口返回值
        string sAPIResult = "";
        try
        {
            sAPIResult = client.Post(date);
        }
        catch (Exception ex)
        {
            txtMsg.Text = "第三方平台的Api_Url无效。" + ex;
            return;
        }
        if (ddlApiResultType.SelectedValue == "xml")
        {
            if (Comm.StrToInt(Comm.get_JsonValueByName(sAPIResult, "Code")) < 100)
            {
                txtMsg.Text = sAPIResult;
                return;
            }
            #region ========== XML返回 ==========
            #endregion
        }
        else
        {
            #region ========== Json返回 ==========
            #endregion
        }
        txtMsg.Text = sAPIResult;
    }
}