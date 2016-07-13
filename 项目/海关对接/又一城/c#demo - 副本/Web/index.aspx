<%@ Page Language="C#" AutoEventWireup="true" CodeFile="index.aspx.cs" Inherits="index" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
     <title>又一城--第三方平台开发[ 技术讨论QQ群：99094221 验证码：u1city ] http://www.u1city.net</title>
    <script type="text/javascript">
        function checkInput() {
            if (document.getElementById("txtApiKey").value == "") {
                alert("Api_Key不能为空！");
                document.getElementById("txtApiKey").focus();
                return false;
            }
            if (document.getElementById("txtApiSerect").value == "") {
                alert("Api_Serect不能为空！");
                document.getElementById("txtApiSerect").focus();
                return false;
            }
            if (document.getElementById("txtApiUrl").value == "") {
                alert("Api_Url不能为空！");
                document.getElementById("txtApiUrl").focus();
                return false;
            }
        }
    </script>
     <style type="text/css">
         #Button1
         {
             width: 129px;
             height: 32px;
         }
     </style>
</head>
<body>
    <form id="form1" runat="server">
   <div>
        <b>第三方平台参数：</b><br />
        <table width="700px" border="0" cellpadding="6" cellspacing="2">
            <tr>
                <td align="center" style="width: 80px;">
                    Api_Key:
                </td>
                <td align="left">
                    <asp:TextBox ID="txtApiKey" runat="server">U1CITYFXSTEST</asp:TextBox>
                </td>
                <td align="center" style="width: 80px;">
                    Api_Serect：
                </td>
                <td align="left">
                    <asp:TextBox ID="txtApiSerect" runat="server">U1CITYFXSTESTBBIOFKD</asp:TextBox>
                </td>
            </tr>
            <tr>
                <td align="center">
                    Api_Url：
                </td>
                <td align="left">
                    <asp:TextBox ID="txtApiUrl" runat="server" Width="300px">http://wqbopenapi.ushopn6.com/wqbnew/api.rest</asp:TextBox>
                </td>
                <td align="center">
                    返回类型：
                </td>
                <td align="left">
                    <asp:DropDownList ID="ddlApiResultType" runat="server">
                        <asp:ListItem>xml</asp:ListItem>
                        <asp:ListItem Selected="True">json</asp:ListItem>
                    </asp:DropDownList>
                </td>
            </tr>
        </table>
        <br />
        <b>第三方平台接口：</b><br />
        <br />
        商品接口：&nbsp;
        <asp:Button ID="btn_Get_Pro_Class" runat="server" Height="38px" OnClick="btn_Get_Pro_Class_Click"
            OnClientClick="return checkInput();" Text="获取商品类别" Width="120px" />        
        &nbsp;
        <asp:Button ID="btn_Get_Pro" runat="server" Height="38px" OnClick="btn_Get_Pro_Click"
            OnClientClick="return checkInput();" Text="获取商品信息" Width="120px" />
        &nbsp;
        <asp:Button ID="btn_Get_Pro_Sku_Info" runat="server" Height="38px" OnClick="btn_Get_Pro_Sku_Info_Click"
            OnClientClick="return checkInput();" Text="获取商品库存信息" Width="120px" />
        &nbsp;
        <asp:Button ID="btn_Get_Pro_Sku_Num" runat="server" Height="38px" OnClick="btn_Get_Pro_Sku_Num_Click"
            OnClientClick="return checkInput();" Text="更新商品库存" Width="120px" />
        &nbsp;&nbsp;
        <asp:Button ID="btn_UpdateProSkuInventory" runat="server" Height="38px" OnClick="btn_UpdateProSkuInventory_Click"
            OnClientClick="return checkInput();" Text="更新商品库存[增减]" Width="128px" />
        &nbsp;&nbsp;
        <asp:Button ID="btn_BatchUpdateProSkuInventory" runat="server" Height="38px" OnClick="btn_BatchUpdateProSkuInventory_Click"
            OnClientClick="return checkInput();" Text="批量更新商品库存[增减]" Width="156px" />
        <br />
        <br />
        订单接口：&nbsp;
        <asp:Button ID="btn_Set_Order_Info" runat="server" Height="38px" OnClick="btn_Set_Order_Info_Click"
            OnClientClick="return checkInput();" Text="添加订单" Width="120px" />
        &nbsp;
        <asp:Button ID="btn_Cancel_Order" runat="server" Height="38px" OnClick="btn_Cancel_Order_Click"
            OnClientClick="return checkInput();" Text="取消订单" Width="120px" />
        &nbsp;
        <asp:Button ID="btn_Select_OrderData" runat="server" Height="38px" 
            Text="查询订单信息" Width="120px"
            OnClientClick="return checkInput();" 
            OnClick="btn_Select_OrderData_Click" />
        &nbsp;
        <asp:Button ID="btn_Select_Order_Deliver" runat="server" Height="38px" Text="查询订单发货信息"
            OnClientClick="return checkInput();" Width="120px" OnClick="btn_Select_Order_Deliver_Click" />
        &nbsp;
        <asp:Button ID="btn_Get_SaleStock" runat="server" Height="38px" Text="查询出库单"
            OnClientClick="return checkInput();" Width="120px" 
            OnClick="btn_Get_SaleStock_Click" />
         &nbsp;
        <asp:Button ID="btn_SetSaleStockDeliver" runat="server" Height="38px" Text="出库单发货"
            OnClientClick="return checkInput();" Width="120px" 
            OnClick="btn_SetSaleStockDeliver_Click" />
        <br />
        <br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <asp:Button ID="btn_AddOrderRefund" runat="server" Height="38px" Text="订单申请退款"
            OnClientClick="return checkInput();" Width="120px" 
            onclick="btn_AddOrderRefund_Click" />
        <br />
        <br />
        售后接口：&nbsp;
        <asp:Button ID="btn_AddExchangeOrderProduct" runat="server" Height="38px" OnClick="btn_AddExchangeOrderProduct_Click"
            OnClientClick="return checkInput();" Text="添加售后记录" Width="120px" />
        &nbsp;
        <asp:Button ID="btn_SelectExchangeOrderProduct" runat="server" Height="38px" Text="查询售后信息"
            OnClientClick="return checkInput();" Width="120px" OnClick="btn_SelectExchangeOrderProduct_Click" />
        &nbsp;
        <asp:Button ID="btn_Add_ExchangeOrderExpress" runat="server" Height="38px" Text="售后快递信息"
            OnClientClick="return checkInput();" Width="120px" OnClick="btn_Add_ExchangeOrderExpress_Click" />
        &nbsp;
        <asp:Button ID="btn_CancelExchangeOrderProduct" runat="server" Height="38px" Text="取消售后记录"
            OnClientClick="return checkInput();" Width="120px" OnClick="btn_CancelExchangeOrderProduct_Click" />
        &nbsp;
        <asp:Button ID="btn_ExchangeOrderProductState" runat="server" Height="38px" Text="售后确认收货"
            OnClientClick="return checkInput();" Width="120px" OnClick="btn_ExchangeOrderProductState_Click" />
        <br />
        <br />
        进销存接口： 
        <asp:Button ID="btn_Get_Proc_Info" runat="server" Height="38px" OnClick="btn_Get_Proc_Info_Click"
            OnClientClick="return checkInput();" Text="获取采购出入库单" Width="129px" 
            ForeColor="#009933" />&nbsp;<asp:Button ID="btn_Submit_Proc" runat="server" 
            Height="38px" OnClick="btn_Submit_Proc_Click"
            OnClientClick="return checkInput();" Text="采购出入库单提交" Width="126px" 
            ForeColor="#009933" />
        &nbsp;<asp:Button ID="btn_Get_Proc_Data" runat="server" Height="38px" OnClick="btn_Get_Proc_Data_Click"
            OnClientClick="return checkInput();" Text="获取采购出入库单" Width="120px" 
            ForeColor="#009933" />&nbsp;
        <asp:Button ID="btn_Submit_Proc_Data" runat="server" Height="38px" OnClick="btn_Submit_Proc_Data_Click"
            OnClientClick="return checkInput();" Text="采购出入库单提交" Width="126px" 
            ForeColor="#009933" />
        &nbsp;<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <br />
&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; 
        <asp:Button ID="btn_Get_Proc_In_Data" runat="server" Height="38px" OnClick="btn_Get_Proc_In_Data_Click"
            OnClientClick="return checkInput();" Text="获取采购入库单" Width="120px" />&nbsp;&nbsp; 
        <asp:Button ID="btn_Submit_Proc_In_Data" runat="server" Height="38px" OnClick="btn_Submit_Proc_In_Data_Click"
            OnClientClick="return checkInput();" Text="提交采购入库单" Width="120px" />&nbsp;&nbsp; 
        <asp:Button ID="btn_Get_Proc_Out_Data" runat="server" Height="38px" OnClick="btn_Get_Proc_Out_Data_Click"
            OnClientClick="return checkInput();" Text="获取采购出库单" Width="120px" />&nbsp;&nbsp; 
        <asp:Button ID="btn_Submit_Proc_Out_Data" runat="server" Height="38px" OnClick="btn_Submit_Proc_Out_Data_Click"
            OnClientClick="return checkInput();" Text="提交采购出库单" Width="120px" />&nbsp;&nbsp;
        <asp:Button ID="btn_GetSupplier" runat="server" Height="38px" OnClick="btn_GetSupplier_Click"
            OnClientClick="return checkInput();" Text="获取供应商" Width="120px" />
        &nbsp;
        <asp:Button ID="btn_Get_Express_List" runat="server" Height="38px" OnClick="btn_Get_Express_List_Click"
            OnClientClick="return checkInput();" Text="获取快递公司" Width="120px" />
        <br />
        <br />
        <br />
        <b>第三方平台接口返回值：</b><br />
        <br />
        <asp:TextBox ID="txtMsg" runat="server" Height="200px" TextMode="MultiLine" Width="1000px"></asp:TextBox>
        <br />
        <br />
        <asp:Label ID="lblMsg" runat="server"></asp:Label>
        <br />
        <br />
    </div>
    </form>
</body>
</html>
