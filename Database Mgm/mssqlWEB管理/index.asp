<%
'BBSGOOD.COM版权所有
'本系统免费使用,如用于商业目的,请联系BBSGOOD.COM授权
'联系电话: 13606552007  QQ:38958768

if trim(request.QueryString("login"))="login" then
    Response.Cookies("ipdress")=trim(request.Form("ipdress"))
    Response.Cookies("dataname")=trim(request.Form("dataname"))
    Response.Cookies("username")=trim(request.Form("username"))
    Response.Cookies("password")=trim(request.Form("password"))
    LinkData
    if trim(request.Cookies("linkok"))="yes" then
        closedata
        Response.Redirect "frame.asp"
    end if
else
%>
<html>
<head>
<title>SQL Server数据库在线管理系统-BBSGOOD提供的产品</title>
<meta name="keywords" content="SQL Server数据库在线管理">
<meta name="description" content="SQL Server数据库在线管理系统-BBSGOOD提供的产品" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<style>
body {
	margin-top: 130px;
	background-image: url(images/bg.jpg);
	background-repeat: repeat-x;
}
body,td,th {
	font-family: 宋体;
	font-size: 12px;
	color: #333333;
}
</style>
</head>
<body>
<table width="601" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr style="line-height:25px">
    <td width="250" align="left" valign="top" style="padding-right:10px"><img src="images/wz.jpg" width="63" height="57" /><font color="#0099CC">SQL Server数据库在线管理系统<br />
      SQL Server Online Management(缩写SSOM)<br />
      该系统可以在线管理已创建的SQL Server(mssql)数据库,目前主要功能如下:<br />
      连接你的SQL数据库,进行<br />
      1.建立,删除,修改数据表<br />
      2.建立,删除,修改每个表的字段操作<br />
      3.SQL语句执行容器,可以执行所有的SQL语句,包括存储过程,也可以检索、插入、更新、删除记录等操作<br />
      4.进行数据库的备份&nbsp;&nbsp;&nbsp;<a href="help.asp" target="_blank"><font color="#0099CC">更多帮助</font></a></font></td>
    <td width="1" bgcolor="#dadada"></td>
    <td width="350" align="center" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="80" colspan="2"><strong><font color="#006699" size="3"><img src="images/gl.gif" width="50" height="50" />SQL Server数据库管理登陆</font></strong></td>
      </tr>
      <tr><form action="index.asp?login=login" method="post" id=form1 name=form1>
        <td width="40%" height="50" align="left" valign="middle">数据库地址</td>
        <td width="60%" height="50" align="left" valign="middle"><input name="ipdress" type="text" size="20" />
              <br />
              <font color="#999999">一般为IP地址</font></td>
      </tr>
      <tr>
        <td width="40%" height="40" align="left" valign="middle">数据库名称</td>
        <td width="60%" height="40" align="left" valign="middle"><input name="dataname" type="text" size="20" /></td>
      </tr>
      <tr>
        <td width="40%" height="40" align="left" valign="middle">访问的帐号</td>
        <td width="60%" height="40" align="left" valign="middle"><input name="username" type="text" size="20" /></td>
      </tr>
      <tr>
        <td width="40%" height="40" align="left" valign="middle">访问的密码</td>
        <td width="60%" height="40" align="left" valign="middle"><input name="password" type="password" size="20" /></td>
      </tr>
      <tr>
        <td height="40" align="left" valign="middle"></td>
        <td height="40" align="left" valign="middle"><input type="image" src="images/dl.gif" width="82" height="23" /></td>
      </tr>
    </table></td></form>
  </tr>
  <tr style="line-height:25px">
    <td height="130" colspan="3" align="center" valign="bottom" style="padding-right:10px"><a href="http://www.bbsgood.com" target="_blank"><font color="#333333">BBSGOOD.COM</font></a>提供的产品 SQL Server Online Management(缩写SSOM) v1.0bate </td>
  </tr>
</table>
</body>
</html>
<%
end if

Sub LinkData()
    Dim ConnStr
    ConnStr = "Provider = Sqloledb; User ID = " & trim(request.Cookies("username")) & "; Password = " & trim(request.Cookies("password")) & "; Initial Catalog = " & trim(request.Cookies("dataname")) & "; Data Source = " & trim(request.Cookies("ipdress")) & ";"
    On Error Resume Next
    Set conn = Server.CreateObject("ADODB.Connection")
    conn.open ConnStr
    If Err Then
	    err.Clear
	    Set Conn = Nothing
	    Response.Write "<script>alert('数据库连接出错，请检查连接的地址,数据库名称,帐号,密码是否正确。');history.back(-1);</script>"
	    Response.End
	else
	    Response.Cookies("linkok")="yes"
    End If
End Sub
Sub CloseData()
    if IsObject(conn) then
        conn.Close
        set conn=nothing
    end if
End Sub
%>