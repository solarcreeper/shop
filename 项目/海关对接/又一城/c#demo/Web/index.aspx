﻿<%@ Page Language="C#" AutoEventWireup="true" CodeFile="index.aspx.cs" Inherits="index" ValidateRequest="false"%>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
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
<br/>
        <asp:PlaceHolder ID="PlaceHolder1" runat="server"></asp:PlaceHolder>
       
    </div>
    </form>


    <form id="form2" action="http://113.204.136.28/KJClientReceiver/Data.aspx" method="post">
        <input type="text" name="data" id="data" value="PERUQ19NZXNzYWdlPjxNZXNzYWdlSGVhZD48TWVzc2FnZVR5cGU+T1JERVJfSU5GTzwvTWVzc2FnZVR5cGU+PE1lc3NhZ2VJZD5hMGNiY2IxMS1iN2I0LTRlNDItODRhMi03OGU1YjQwNGI2ZDY8L01lc3NhZ2VJZD48QWN0aW9uVHlwZT4xPC9BY3Rpb25UeXBlPjxNZXNzYWdlVGltZT4yMDE0LTA3LTIxVDEzOjA2OjUxPC9NZXNzYWdlVGltZT48U2VuZGVySWQ+NTAwNTIxMDAzMzwvU2VuZGVySWQ+PFJlY2VpdmVySWQ+Q1FJVEM8L1JlY2VpdmVySWQ+PFNlbmRlckFkZHJlc3MgLz48UmVjZWl2ZXJBZGRyZXNzIC8+PFBsYXRGb3JtTm8gLz48Q3VzdG9tQ29kZSAvPjxTZXFObyAvPjxOb3RlIC8+PFVzZXJObz41MDA1MjEwMDMzPC9Vc2VyTm8+PFBhc3N3b3JkPmlnZXRtYWxsMjAxNDU1PC9QYXNzd29yZD48L01lc3NhZ2VIZWFkPjxNZXNzYWdlQm9keT48RFRDRmxvdz48T1JERVJfSEVBRD48Q1VTVE9NU19DT0RFPjgwMTI8L0NVU1RPTVNfQ09ERT48QklaX1RZUEVfQ09ERT5JMjA8L0JJWl9UWVBFX0NPREU+PE9SSUdJTkFMX09SREVSX05PPjIwMTQwNzA0MTU1MzU4NDE8L09SSUdJTkFMX09SREVSX05PPjxFU0hPUF9FTlRfQ09ERT41MDA1MjEwMDMzPC9FU0hPUF9FTlRfQ09ERT48RVNIT1BfRU5UX05BTUU+6YeN5bqG5L+d56iO5riv5Yy66L+b5Ye65Y+j5ZWG5ZOB6LS45piT5pyJ6ZmQ5YWs5Y+4PC9FU0hPUF9FTlRfTkFNRT48REVTUF9BUlJJX0NPVU5UUllfQ09ERT4zMjQ8L0RFU1BfQVJSSV9DT1VOVFJZX0NPREU+PFNISVBfVE9PTF9DT0RFPlk8L1NISVBfVE9PTF9DT0RFPjxSRUNFSVZFUl9JRF9OTz41MDAyMjYxOTg3MTAyNzExMTI8L1JFQ0VJVkVSX0lEX05PPjxSRUNFSVZFUl9OQU1FPuW6hOaMujwvUkVDRUlWRVJfTkFNRT48UkVDRUlWRVJfQUREUkVTUz7ph43luobph43luoblr7jmu6nkv53nqI7muK/ljLrmsLTmuK/nu7zlkIjmpbwxNjA05a6kPC9SRUNFSVZFUl9BRERSRVNTPjxSRUNFSVZFUl9URUw+MTM5ODM4OTI4Nzk8L1JFQ0VJVkVSX1RFTD48R09PRFNfRkVFPjAuMDE8L0dPT0RTX0ZFRT48VEFYX0ZFRT4wLjAwPC9UQVhfRkVFPjxHUk9TU19XRUlHSFQ+MC42PC9HUk9TU19XRUlHSFQ+PFBST1hZX0VOVF9DT0RFIC8+PFBST1hZX0VOVF9OQU1FIC8+PE9SREVSX0RFVEFJTD48U0tVPjExNDc0OTIzNDA8L1NLVT48R09PRFNfU1BFQz7luKblpJblo7PnmoTkv53muKnmna88L0dPT0RTX1NQRUM+PENVUlJFTkNZX0NPREU+MTQyPC9DVVJSRU5DWV9DT0RFPjxQUklDRT4wLjAxPC9QUklDRT48UVRZPjE8L1FUWT48R09PRFNfRkVFPjAuMDE8L0dPT0RTX0ZFRT48VEFYX0ZFRT4wLjAwMTwvVEFYX0ZFRT48L09SREVSX0RFVEFJTD48L09SREVSX0hFQUQ+PC9EVENGbG93PjwvTWVzc2FnZUJvZHk+PC9EVENfTWVzc2FnZT4="/>
    <input type="submit" id="d" value="submit"/>    
    </form>
</body>
</html>
