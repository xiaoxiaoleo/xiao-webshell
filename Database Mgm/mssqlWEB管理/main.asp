<%
'BBSGOOD.COM版权所有
'本系统免费使用,如用于商业目的,请联系BBSGOOD.COM授权
'联系电话: 13606552007  QQ:38958768
%>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<script>
    function checkclick(msg){if(confirm(msg)){event.returnValue=true;}else{event.returnValue=false;}}
</script>
<style>
A:link   {color:#0000ff;font-style: normal; text-decoration: none; cursor: hand;}
A:visited   {color:#0000ff;font-style: normal; text-decoration: none;}
A:active    {color:#0000ff;font-style: normal; text-decoration: none;}
A:hover  {color:#0000ff;font-style:bold; text-decoration:underline;}
</style>
</head>
<body>
<%
dim i,rs,sql
if trim(request.Cookies("linkok"))="yes" then
    if not IsObject(conn) then
        LinkData
    end if
    Response.Write "<table border=""0"" width=""100%""><tr><td valign=""top"">"
    select case RequestNumSafe(request.QueryString("cz"))
    case 0
        %>
<font style="line-height:30px" size="2"><img src="images/glxttb.jpg" width="65" height="50"> <strong><font color="#FF6600">
        SQL Server数据库在线管理系统</font></strong><br /><font color="#666666">
        SQL Server Online Management(缩写SSOM)<br />
        由于微软默认提供的企业管理器,很多用户使用困难,有不少用户也没有安装这个软件.另外很多用户将数据库服务器的远程连接给关掉或者将数据库服务器安装在局域网内
        使得外部的使用管理有了不少的麻烦,SSOM系统可以安装在你的内部服务器上,这样外部用户直接用(local)连接就可以管理了
        在mysql服务器管理中,目前用phpmyadmin软件进行在线管理,而SQL Server(mssql)也需要类似这样一款在线管理工具,就这样由BBSGOOD团队开发的针对mssql管理的SSOM系统诞生了.
        <br><br>
        该系统可以在线管理已创建的SQL Server(mssql)数据库,目前主要功能如下:<br>
        连接你的SQL数据库,进行<br>
        1.建立,删除,修改数据表<br>
        2.建立,删除,修改每个表的字段操作<br>
        3.SQL语句执行容器,可以执行所有的SQL语句,包括存储过程,也可以检索、插入、更新、删除记录等操作<br>
        4.进行数据库的备份<br><br>
        目前该产品首次测试发布编码为中国大陆的GB2312编码<br><br>
        
        使用说明:<br>
        1.在数据库地址一栏中,输入你数据库服务器的IP地址,如果和本系统是同机的话,也可以用(local)来连接
          输入你的数据库名称,数据库访问的帐号和密码,点击登陆即可.<br>
        2.登陆后,点击左栏的数据库,即可管理数据库中所有的表,字段,记录等数据.<br>
        3.点击左栏的SQL语句,还可以运行sql脚本,你所需要的操作均可以完成,包括用select语句查询出记录.<br>
        4.点击左栏的数据库备份,就可以对你的数据库进行备份了,注意备份的路径是数据库服务器上面的路径.<br>
        <br>BBSGOOD.COM提供的产品</font></font>
        <%
    case 1
        set rsSchema=conn.openSchema(20) 
        rsSchema.movefirst 
        
        Response.Write "<form action=""main.asp?cz=4"" method=""post"">表名 <input type=""text"" name=""crtablename"" size=""15""> <input type=""submit"" value="" 建立新表 ""></form>"
        Response.Write "(库)"&Request.Cookies("dataname")&"->表 &nbsp;&nbsp;<a href=""main.asp?cz=1"">用户表</a> &nbsp;&nbsp;<a href=""main.asp?cz=1&alltable=1"">所有表</a><table border=""0"" width=""700""><tr bgcolor=""#eeeeee"" height=""25""><td>表名</td><td colspan=""4"">操作</td><td>表记录的SQL语句处理</td></tr>"
        Do Until rsSchema.EOF
            if request.QueryString("alltable")=1 then
                response.write "<tr><form action=""main.asp?cz=9&tablename2="&rsSchema("TABLE_NAME")&""" method=""post""><td><input type=""text"" name=""tablename"" value="""&rsSchema("TABLE_NAME")&""" size=""15""></td><td><input type=""submit"" value=""保存""></td></form><td><a href=""?cz=2&tablename="&rsSchema("TABLE_NAME")&""">设计表</a></td><td><a href=""?cz=3&tablename="&rsSchema("TABLE_NAME")&""">打开表</a></td><td><a onclick=checkclick('您确定要删除该表，包括里面的所有资料?') href=""?cz=6&tablename="&rsSchema("TABLE_NAME")&""">删除表</a></td><td><a href=""?cz=10&czsql=1&tablename="&rsSchema("TABLE_NAME")&""">记录查询</a>|<a href=""?cz=10&czsql=2&tablename="&rsSchema("TABLE_NAME")&""">插入</a>|<a href=""?cz=10&czsql=3&tablename="&rsSchema("TABLE_NAME")&""">更新</a>|<a href=""?cz=10&czsql=4&tablename="&rsSchema("TABLE_NAME")&""">删除</a></td></tr>"
                Response.Write "<tr><td height=""1"" bgcolor=""#555555"" colspan=""6""></td></tr>"
            else
                if rsSchema("TABLE_TYPE")="TABLE" then 
                    response.write "<tr><form action=""main.asp?cz=9&tablename2="&rsSchema("TABLE_NAME")&""" method=""post""><td><input type=""text"" name=""tablename"" value="""&rsSchema("TABLE_NAME")&""" size=""15""></td><td><input type=""submit"" value=""保存""></td></form><td><a href=""?cz=2&tablename="&rsSchema("TABLE_NAME")&""">设计表</a></td><td><a href=""?cz=3&tablename="&rsSchema("TABLE_NAME")&""">打开表</a></td><td><a onclick=checkclick('您确定要删除该表，包括里面的所有资料?') href=""?cz=6&tablename="&rsSchema("TABLE_NAME")&""">删除表</a></td><td><a href=""?cz=10&czsql=1&tablename="&rsSchema("TABLE_NAME")&""">记录查询</a>|<a href=""?cz=10&czsql=2&tablename="&rsSchema("TABLE_NAME")&""">插入</a>|<a href=""?cz=10&czsql=3&tablename="&rsSchema("TABLE_NAME")&""">更新</a>|<a href=""?cz=10&czsql=4&tablename="&rsSchema("TABLE_NAME")&""">删除</a></td></tr>"
                    Response.Write "<tr><td height=""1"" bgcolor=""#555555"" colspan=""6""></td></tr>"
                end if
            end if
            rsSchema.movenext
        Loop
        Response.Write "</table>"
        rsSchema.close
        set rsSchema=Nothing
    case 2
        dim fieldCount
        set rs=conn.execute("select * from ["&trim(request.QueryString("tablename"))&"]")
        fieldCount = rs.Fields.Count
        Response.Write "<form action=""main.asp?cz=5&tablename="&trim(request.QueryString("tablename"))&""" method=""post"" id=form1 name=form1>字段名 <input type=""text"" name=""crfield"" size=""15""> <select name=""fieldtype"">"
        Response.Write "<option value="""">字段类型</option>"
        Response.Write "<option value=""int"">int</option>"
        Response.Write "<option value=""bigint"">bigint</option>"
        Response.Write "<option value=""smallint"">smallint</option>"
        Response.Write "<option value=""varchar"">varchar</option>"
        Response.Write "<option value=""ntext"">ntext</option>"
        Response.Write "<option value=""float"">float</option>"
        Response.Write "<option value=""bit"">bit</option>"
        Response.Write "<option value=""nvarchar"">nvarchar</option>"
        Response.Write "<option value=""datetime"">datetime</option>"
        Response.Write "<option value=""image"">image</option>"
        Response.Write "<option value=""text"">text</option>"
        Response.Write "<option value=""nchar"">nchar</option>"
        Response.Write "<option value=""money"">money</option>"
        Response.Write "<option value=""smalldatetime"">smalldatetime</option>"
        Response.Write "<option value=""numeric"">numeric</option>"
        Response.Write "<option value=""varbinary"">varbinary</option>"
        Response.Write "<option value=""tinyint"">tinyint</option>"
        Response.Write "<option value=""timestamp"">timestamp</option>"
        Response.Write "<option value=""sql_variant"">sql_variant</option>"
        Response.Write "<option value=""real"">real</option>"
        
        Response.Write "</select> <input type=""submit"" value="" 新建字段 "" id=1 name=1></form>"
        Response.Write "<a href=""main.asp?cz=1"">(库)"&Request.Cookies("dataname")&"</a>->(设计表)"&trim(request.QueryString("tablename"))&"->共"&fieldCount&"个字段"
        Response.Write "<table border=""0"" width=""500"">"
        Response.Write "<tr align=""center"" bgcolor=""#eeeeee"" height=""30""><td>字段名称</td><td>字段类型</td><td>字段长度</td><td colspan=""2"">操作</td></tr>"
        For i=0 to fieldCount - 1
            Response.Write "<tr align=""center""><td><form action=""main.asp?cz=7&tablename="&trim(request.QueryString("tablename"))&""" method=""post"">"
            Response.Write "<input type=""text"" name=""fieldsname"" value="""&rs.Fields(i).Name&""" size=""10""><input type=""hidden"" name=""fieldsname2"" value="""&rs.Fields(i).Name&"""></td><td>"
            Response.Write "<select name=""fieldtype"">"
            select case rs.Fields(i).type
            case 3
                Response.Write "<option value=""int"">int</option>"
            case 5
                Response.Write "<option value=""float"">float</option>"
            case 11
                Response.Write "<option value=""bit"">bit</option>"
            case 20
                Response.Write "<option value=""bigint"">bigint</option>"
            case 130
                Response.Write "<option value=""nchar"">nchar</option>"
            case 200
                Response.Write "<option value=""varchar"">varchar</option>"
            case 202
                Response.Write "<option value=""nvarchar"">nvarchar</option>"
            case 203
                Response.Write "<option value=""ntext"">ntext</option>"
            case 205
                Response.Write "<option value=""image"">image</option>"
            case 135
                Response.Write "<option value=""datetime"">datetime</option>"
            case else
                Response.Write "<option value="""">"&rs.Fields(i).type&"</option>"
            end select
            Response.Write "<option value=""int"">int</option>"
            Response.Write "<option value=""bigint"">bigint</option>"
            Response.Write "<option value=""smallint"">smallint</option>"
            Response.Write "<option value=""varchar"">varchar</option>"
            Response.Write "<option value=""ntext"">ntext</option>"
            Response.Write "<option value=""float"">float</option>"
            Response.Write "<option value=""bit"">bit</option>"
            Response.Write "<option value=""nvarchar"">nvarchar</option>"
            Response.Write "<option value=""datetime"">datetime</option>"
            Response.Write "<option value=""image"">image</option>"
            Response.Write "<option value=""text"">text</option>"
            Response.Write "<option value=""nchar"">nchar</option>"
            Response.Write "<option value=""money"">money</option>"
            Response.Write "<option value=""smalldatetime"">smalldatetime</option>"
            Response.Write "<option value=""numeric"">numeric</option>"
            Response.Write "<option value=""varbinary"">varbinary</option>"
            Response.Write "<option value=""tinyint"">tinyint</option>"
            Response.Write "<option value=""timestamp"">timestamp</option>"
            Response.Write "<option value=""sql_variant"">sql_variant</option>"
            Response.Write "<option value=""real"">real</option>"            
            Response.Write "</select>"
            Response.Write "</td><td><input name=""fieldssize"" type=""text"" value="""&rs.Fields(i).DefinedSize&""" size=""10""></td><td><input type=""submit"" value=""保存""></td><td><a onclick=checkclick('您确定要删除该字段，包括里面的所有资料?') href=""main.asp?cz=8&tablename="&trim(request.QueryString("tablename"))&"&fieldsname="&rs.Fields(i).Name&""">删除</a></td></form></tr><tr><td height=""1"" bgcolor=""#555555"" colspan=""5""></td></tr>"
        Next
        Response.Write "</table>"
        rs.close
        set rs=nothing
    case 3
        Response.Write "<a href=""?cz=10&czsql=1&tablename="&trim(request.QueryString("tablename"))&""">表记录查询</a> | <a href=""?cz=10&czsql=2&tablename="&trim(request.QueryString("tablename"))&""">插入</a> | <a href=""?cz=10&czsql=3&tablename="&trim(request.QueryString("tablename"))&""">更新</a> | <a href=""?cz=10&czsql=4&tablename="&trim(request.QueryString("tablename"))&""">删除</a><br><br>"
        set rs=conn.execute("select top 50 * from ["&trim(request.QueryString("tablename"))&"]")
        fieldCount = rs.Fields.Count
        Response.Write "<a href=""main.asp?cz=1"">(库)"&Request.Cookies("dataname")&"</a>->(打开表)"&trim(request.QueryString("tablename"))&"->显示前50条记录<br>"
        Response.Write "<table border=""0""><tr align=""center"" bgcolor=""#eeeeee"" height=""30"">"
        For i=0 to fieldCount - 1
            Response.Write "<td>"&rs.Fields(i).Name&"</td>"
        Next
        Response.Write "</tr>"
        while not rs.eof
            Response.Write "<tr>"
            For i=0 to fieldCount - 1
                Response.Write "<td><TEXTAREA rows=""2"" cols=""20"">"
                if ISEMPTY(rs(i)) then
                    'Response.Write rs(i)
                else
                    Response.Write rs(i)
                end if
                Response.Write "</TEXTAREA></td>"
            Next
            Response.Write "</tr>"
            'Response.Write "<tr><td height=""1"" bgcolor=""#555555"" colspan=""5""></td></tr>"
            rs.movenext
        wend
        rs.close
        set rs=nothing
        Response.Write "</table>"
    case 4
        dim crtablename
        crtablename=trim(request.Form("crtablename"))
        crtable("CREATE TABLE ["&crtablename&"] (ID int IDENTITY (1,1) not null PRIMARY key)")
        Response.Write "新建的表默认创建有一个ID字段,属性是数字型,递增,加主键.<a href=""main.asp?cz=1"">返回</a>"
    case 5
        dim crfield
        tablename=trim(request.QueryString("tablename"))
        crfield=trim(request.Form("crfield"))
        fieldtype=trim(request.Form("fieldtype"))
        select case fieldtype
        case ""
            Response.Write "请选择字段类型"
        case "varchar"
            crtable("ALTER TABLE ["&tablename&"] ADD ["&crfield&"] varchar(255)")
        case else
            crtable("ALTER TABLE ["&tablename&"] ADD ["&crfield&"] "&fieldtype&"")
        end select
        Response.Write "<a href=""main.asp?cz=2&tablename="&tablename&""">返回</a>"
    case 6
        tablename=trim(request.QueryString("tablename"))
        crtable("DROP TABLE ["&tablename&"]")
        Response.Write "<a href=""main.asp?cz=1"">返回</a>"
    case 7
        dim fieldsname,fieldsname2,fieldssize,fieldar
        tablename=trim(request.QueryString("tablename"))
        fieldsname=trim(request.Form("fieldsname"))
        fieldsname2=trim(request.Form("fieldsname2")) '原表名
        fieldtype=trim(request.Form("fieldtype"))
        crtable("sp_rename '"&tablename&"."&fieldsname2&"','"&fieldsname&"','column';") '字段名修改
        
        fieldssize=trim(request.Form("fieldssize"))
        fieldar=""
        select case fieldtype
        case "varchar","nvarchar"
            fieldar="("&fieldssize&")"
        end select
        if fieldssize=0 then fieldar="" end if
        crtable("ALTER TABLE ["&tablename&"] ALTER COLUMN ["&fieldsname&"] "&fieldtype&""&fieldar&"") '字段类型处理
        Response.Write "<a href=""main.asp?cz=2&tablename="&tablename&""">返回</a>"
    case 8
        tablename=trim(request.QueryString("tablename"))
        fieldsname=trim(request.QueryString("fieldsname"))
        crtable("Alter table ["&tablename&"] drop column ["&fieldsname&"]")
        Response.Write "<a href=""main.asp?cz=2&tablename="&tablename&""">返回</a>"
    case 9
        dim tablename2
        tablename=trim(request.Form("tablename"))
        tablename2=trim(request.QueryString("tablename2"))
        crtable("EXEC sp_rename ["&tablename2&"],["&tablename&"]")
        Response.Write "<a href=""main.asp?cz=1"">返回</a>"
    case 10
        Response.Write "语句案例<br>"
        Response.Write "插入语句:<font color=""#2663e0"" style=""font-size: 10pt""> insert into 表名(字段1,字段2)values('内容1','内容2')</font><br>"
        Response.Write "更新语句:<font color=""#2663e0"" style=""font-size: 10pt""> update 表名 set 字段1='内容1',字段2='内容2' where 字段3='内容3'</font><br>"
        Response.Write "删除语句:<font color=""#2663e0"" style=""font-size: 10pt""> delete from 表名 where 字段='内容'</font><br>"
        Response.Write "查询语句:<font color=""#2663e0"" style=""font-size: 10pt""> select top 显示的记录数目 字段1,字段2 from 表名 where 字段1='内容1'</font><br>"
        
        tablename=trim(request.QueryString("tablename"))
        if tablename<>"" then
            dim czsql
            czsql=""
            select case request.QueryString("czsql")
            case 1
                czsql="SELECT TOP 10 * FROM ["&tablename&"]"
            case 2
                czsql="INSERT INTO ["&tablename&"] ( ) VALUES ( )"
            case 3
                czsql="UPDATE ["&tablename&"] SET"
            case 4
                czsql="DELETE FROM ["&tablename&"]"
            end select
        end if
        Response.Write "<form action=""main.asp?cz=11"" method=""post"">请输入一个SQL语句<br><TEXTAREA rows=""5"" cols=""50"" name=""sqlstr"">"&czsql&"</TEXTAREA><br><input type=""submit"" value=""立即执行""></form>"
        
        Response.Write "注意:<br>1.用select查询记录的时候加上top语句,因为如果记录有成千上万过多的话,就会出现延时,打不开等现象,加上top就可以限止显示多少条查询的结果.<br>2.该功能可用于所有的操作,包括存储过程"
    case 11
        if instr(1,trim(request.Form("sqlstr")),"select",1)>0 then
            On Error Resume Next
            set rs=conn.Execute(trim(request.Form("sqlstr")))
	        If Err Then
		        Response.write ""&Err.Description&"<br>"
            else
                Response.Write "执行:&nbsp;"&trim(request.Form("sqlstr"))&"&nbsp;&nbsp;成功<br>"
                Response.Write "<a href=""javascript:history.back(-1)"">返回</a>"
                fieldCount = rs.Fields.Count
                Response.Write "<table border=""0""><tr align=""center"" bgcolor=""#eeeeee"" height=""30"">"
                For i=0 to fieldCount - 1
                    Response.Write "<td>"&rs.Fields(i).Name&"</td>"
                Next
                Response.Write "</tr>"
                while not rs.eof
                    Response.Write "<tr>"
                    For i=0 to fieldCount - 1
                        Response.Write "<td><TEXTAREA rows=""2"" cols=""20"" id=textarea1 name=textarea1>"
                        if ISEMPTY(rs(i)) then
                           'Response.Write rs(i)
                        else
                            Response.Write rs(i)
                        end if
                        Response.Write "</TEXTAREA></td>"
                    Next
                    Response.Write "</tr>"
                   'Response.Write "<tr><td height=""1"" bgcolor=""#555555"" colspan=""5""></td></tr>"
                    rs.movenext
                wend
                rs.close
                set rs=nothing
                Response.Write "</table>"
	        end if
        else
            crtable(trim(request.Form("sqlstr")))
            Response.Write "<a href=""javascript:history.back(-1)"">返回</a>"
        end if
    case 12
    %>
      <table border="0"  cellspacing="0" cellpadding="5" height="1" width="90%" class="tableBorder">
      <form action="main.asp?cz=13" method="post">
      <tr><td>备份数据库</td></tr>
      <tr>
      <td height=25><b>注意：</b><br>过大的数据库备份有可能超时，建议在访问量少的时候操作<br><font color="#2663e0" style="font-size: 10pt">备份路径应该是你数据库服务器的路径</font></td>
      </tr>
      <tr>
      <td>备份数据库位置及文件名：<input type="text" size=35 name="dbpath" value="d:\<%=date()%>.bak">&nbsp;
      <input type="submit" value="开始备份" id=submit1 name=submit1></td>
      </tr>
      </table>
    <%
    case 13
        dbpath = trim(Request.Form("dbpath"))
        If dbpath <> "" Then
            dim fso,Files
            Set fso = CreateObject("Scripting.FileSystemObject")
            If fso.FileExists(dbPath) Then
                Response.Write "<br>该命名的备份数据库已经存在，请删除或更换备份文件名进行备份"
            Else
                Response.Write "<br><br>正在备份到'"&dbPath&"'，请稍候...&nbsp;备份时间按数据库大小决定<br><br>"
                Response.Flush
                dim srv,bak
                server.ScriptTimeout = 3600
                Set srv=Server.CreateObject("SQLDMO.SQLServer")
                srv.LoginTimeout = 3600
                srv.Connect trim(request.Cookies("ipdress")),trim(request.Cookies("username")), trim(request.Cookies("password"))
                Set bak = Server.CreateObject("SQLDMO.Backup")
                bak.Database=trim(request.Cookies("dataname"))
                bak.Devices=Files
                bak.Files=dbpath
                bak.SQLBackup srv
                if err.number>0 then
                    response.write err.number&"<font color=""red""><br>"
                    response.write err.description&"</font>"
                else
                    Response.Write "你的数据库已经备份成功"
                end if
            End If
        End If
    case 14
    %>
      <table border="0"  cellspacing="0" cellpadding="5" height="1" width="90%" class="tableBorder">
      <form action="main.asp?cz=15" method="post">
      <tr><td>还原数据库</td></tr>
      <tr>
      <td height=25><b>注意：</b><br>过大的数据库还原有可能超时，建议在访问量少的时候操作<br>还原路径应该是你数据库服务器的路径</td>
      </tr>
      <tr>
      <td>还原数据库位置及文件名：<input type="text" size=35 name="dbpath" value="d:\<%=date()%>.bak">&nbsp;
      <input type="submit" value="开始还原"></td>
      </tr>
      </table>
    <%
    case 15
        closedata
        dbpath = trim(Request.Form("dbpath"))
        If dbpath <> "" Then
            Set fso = CreateObject("Scripting.FileSystemObject")
            If not fso.FileExists(dbPath) Then
                Response.Write "<br>没有找到该数据库的备份文件,检查数据库路径或名称输入是否有误!(注意路径为数据库服务器的路径)"
            Else
                Response.Write "<br><br>正在从"&dbPath&"还原,请稍候...&nbsp;还原时间按数据库大小决定<br><br>"
                Response.Flush
                server.ScriptTimeout = 3600
                Set srv=Server.CreateObject("SQLDMO.SQLServer")
                srv.LoginTimeout = 3600
                srv.Connect trim(request.Cookies("ipdress")),trim(request.Cookies("username")), trim(request.Cookies("password"))
                Set bak = Server.CreateObject("SQLDMO.Restore")
                bak.Action=0
                bak.Database=trim(request.Cookies("dataname"))
                bak.Devices=Files
                bak.Files=dbpath
                bak.ReplaceDatabase=True
                bak.SQLRestore srv
                if err.number>0 then
                    response.write err.number&"<font color=""red""><br>"
                    response.write err.description&"</font>"
                else
                    Response.Write "你的数据库还原成功"
                end if
            End If
        End If
        Response.End
    end select
    Response.Write "</td></tr></table>"
    closedata
end if

'----------------------------------------------------
Function RequestNumSafe(qudata)
    If isNumeric(qudata) then
        if qudata="" then
            RequestNumSafe=0
        else
            RequestNumSafe=qudata
        end if
    else
        RequestNumSafe=0
    end if
End Function

Function RequestCStringSafe(cstring)
    If Instr(1,cstring,"%")>0 or Instr(1,cstring,"=")>0 or Instr(1,cstring,"&")>0 or Instr(1,cstring,"#")>0 or Instr(1,cstring,">")>0 or Instr(1,cstring,"<")>0 or Instr(1,cstring,"'")>0 or Instr(1,cstring,";")>0 or Instr(1,cstring,"　")>0 or Instr(1,cstring,"`")>0 or Instr(1,cstring,"*")>0 or Instr(1,cstring,",")>0 then
        RequestCStringSafe=""
    else
        RequestCStringSafe=cstring
    end if
End Function

Sub LinkData()
    Dim ConnStr
    ConnStr = "Provider = Sqloledb; User ID = " & trim(request.Cookies("username")) & "; Password = " & trim(request.Cookies("password")) & "; Initial Catalog = " & trim(request.Cookies("dataname")) & "; Data Source = " & trim(request.Cookies("ipdress")) & ";"
    On Error Resume Next
    Set conn = Server.CreateObject("ADODB.Connection")
    conn.open ConnStr
    If Err Then
	    err.Clear
	    Set Conn = Nothing
	    Response.Write "数据库连接出错，请检查连接字串。"
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

Function crtable(SqlCommand)
	On Error Resume Next
	Conn.Execute(SqlCommand)
	If Err Then
		Response.write ""&Err.Description&"<br>"
    else
        Response.Write "执行:&nbsp;"&SqlCommand&"&nbsp;&nbsp;成功<br>"
	end if
	Response.Flush
End Function
%>
</body>
</html>