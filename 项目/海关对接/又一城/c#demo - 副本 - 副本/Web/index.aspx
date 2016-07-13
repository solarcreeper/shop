<%@ Page Language="C#" AutoEventWireup="true" CodeFile="index.aspx.cs" Inherits="index" %>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1" runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
</head>
<body>
    <form id="form1" runat="server">
    <div>
        url:<asp:TextBox ID="TextBox1" runat="server">http://wqbopenapi.ushopn6.com/wqbnew/api.rest</asp:TextBox>
        key:<asp:TextBox ID="TextBox2" runat="server">U1CITYFXSTEST</asp:TextBox>
        secert:<asp:TextBox ID="TextBox3" runat="server">U1CITYFXSTESTBBIOFKD</asp:TextBox>
        开始时间：<asp:TextBox ID="TextBox4" runat="server">2013-01-01 00:00:00</asp:TextBox>
        结束时间：<asp:TextBox ID="TextBox5" runat="server">2015-11-27 00:00:00</asp:TextBox>
        开始时间和结束时间务必按照“2015-11-27 00:00:00”的格式填写！！！！
        <asp:Button ID="Button1" runat="server" Text="导入订单" OnClick="Button1_Click" />

        <asp:Label ID="Label1" runat="server" Text="Label"></asp:Label>
    </div>
    </form>
</body>
</html>
