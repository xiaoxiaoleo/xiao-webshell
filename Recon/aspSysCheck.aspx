<%@ Page Language="JScript" ContentType="text/html" ResponseEncoding="gb2312" Debug="true" aspcompat="true" %>
<!--
<pre>
┌─ COCOON ASP.net 探针 ────────────────────┐
│                                                               │
│  感谢你使用 COCOON ASP.net 探针 v1.x                          │
│  本代码完全公开和免费，你可以任意复制、传播、修改和使用，     │
│  但不得公开发表代码 不得用做商业用途，不得向其他使用者收费。  │
│                                                               │
│  使用时，请保留此段信息，谢谢配合                             │
│                                                               │
│  作者：Sunrise_Chen @ Cocoon sTudio.                          │
│                                       2003/03/26              │
│                                                               │
└──────────────────────  ccopus.com ───┘
</per>
-->
<script language="JavaScript" runat="server">
	function getObjVer(objName){
		try{ var objTest = Server.CreateObject(objName);}
		catch(e){ if(e.number==-2147221005) return ""; else return "N/A" }
		try{ var sObjVer = objTest.Version; }
		catch(e){ return ""; }
		if(isNaN(parseInt(sObjVer))) return "";
		objTest = null;
		return sObjVer;
	}
</script>
<%
	Response.Expires = 0;
	Response.Buffer  = true;
	var tPageStartTime = new Date();
	var sTheFile, i, j, x, y;
	sTheFile = Request.ServerVariables("SCRIPT_NAME");
	var sObjName = Request.Form("sObjName")+"";
	
	var bShowDetail = false;
	if(Request.QueryString.ToString().indexOf("ServerDetail")>-1) bShowDetail = true;
	
	
	var arrObj = new Array(
		Array( "MSWC.AdRotator", "", 1 ),
		Array( "MSWC.BrowserType", "", 1 ),
		Array( "MSWC.NextLink", "", 1 ),
		Array( "MSWC.Tools", "", 1 ),
		Array( "MSWC.Status", "", 1 ),
		Array( "MSWC.Counters", "", 1 ),
		Array( "IISSample.ContentRotator", "", 1 ),
		Array( "IISSample.PageCounter", "", 1 ),
		Array( "MSWC.PermissionChecker", "", 1 ),
		Array( "WScript.Shell", "", 1 ),
		Array( "Scripting.FileSystemObject", "", 1 ),
		Array( "ADODB.Connection", "ActiveX Data Object [ADO]", 1 ),
		Array( "CDONTS.NewMail", "Collaboration Data Object [CDO]", 1 ),
		
		Array( "SoftArtisans.FileUp", "SA-FileUp 文件上传", 2 ),
		Array( "SoftArtisans.FileManager", "SA-FM 文件管理", 2 ),
		Array( "LyfUpload.UploadFile", "LyfUpload 文件上传", 2 ),
		Array( "Persits.Upload.1", "ASPUpload 文件上传", 2 ),
		Array( "w3.upload", "w3 upload 文件上传", 2 ),
		
		Array( "iismail.iismail.1", "IISemail", 3 ),
		Array( "JMail.SMTPMail", "w3 Jmail", 3 ),
		Array( "Persits.MailSender", "ASPemail", 3 ),
		Array( "SMTPsvg.Mailer", "ASPmail", 3 ),
		Array( "dkQmail.Qmail", "dkQmail", 3 ),
		Array( "SmtpMail.SmtpMail.1", "SMTPmail", 3 ),
		Array( "Geocel.Mailer", "Geocel", 3),
		
		Array( "SoftArtisans.ImageGen", "SA 的图像读写组件", 4),
		Array( "W3Image.Image", "Dimac 的图像读写组件", 4)
	);
	if(sObjName.length) arrObj[arrObj.length] = Array( sObjName, "", 99 );

%>
<HTML>
  
<HEAD>
<META http-equiv="Content-Type" content="text/HTML; charset=gb2312">
<META http-equiv="Content-Type" content="text/HTML; charset=gb2312">
<META http-equiv="Expires" CONTENT="0">
<META http-equiv="Cache-Control" CONTENT="no-cache">
<META http-equiv="Pragma" CONTENT="no-cache">
<TITLE>COCOON ASP.net 探针</TITLE>
<STYLE type=text/css>
      BODY,tr {	FONT-SIZE: 9pt; FONT-FAMILY: "Arial", "Helvetica", "sans-serif" }
      a { COLOR: #000000; TEXT-DECORATION: none }
      a:hover { COLOR: #ff0000; TEXT-DECORATION: none }
      a.td1o2{ border:3px #333 double; padding-left:5px; padding-right:5px; }
      a.td2o2{ border:3px #333 double; padding-left:5px; padding-right: 5px; }
      .tbl1 {	BORDER-RIGHT: #3f5294 1px solid; BORDER-TOP: #3f5294 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: #3f5294 1px solid; BORDER-BOTTOM: #3f5294 1px solid }
      .td1 { BORDER-RIGHT: #ffffff 0px solid; BORDER-TOP: #ffffff 1px solid; BORDER-LEFT: #ffffff 1px solid; COLOR: #373737; BORDER-BOTTOM: #ffffff 0px solid; BACKGROUND-COLOR: #A1A9AE}
      .tbl1o1 { BACKGROUND-COLOR: #889197}
      .td1o1 { BORDER-RIGHT: #ffffff 0px solid; BORDER-TOP: #ffffff 1px solid; BORDER-LEFT: #ffffff 1px solid; BORDER-BOTTOM: #ffffff 0px solid; BACKGROUND-COLOR: #C3C3C3}
      .tr1 { BACKGROUND-COLOR: #576169}
      .td1o2 { BACKGROUND-COLOR: #EAEAEA}
      .tbl2 { BORDER: #50A0A0 1px solid; FONT-SIZE: 9pt; }
      .td2 { BORDER-RIGHT: #50A0A0 0px solid; BORDER-TOP: #ffffff 1px solid; BORDER-LEFT: #ffffff 1px solid; COLOR: #308080; BORDER-BOTTOM: #ffffff 0px solid; BACKGROUND-COLOR: #ADCDC2 }
      .tbl2o1 { BACKGROUND-COLOR: #50A0A0 }
      .td2o1 { BORDER-RIGHT: #ffffff 0px solid; BORDER-TOP: #ffffff 1px solid; BORDER-LEFT: #ffffff 1px solid; BORDER-BOTTOM: #ffffff 0px solid; BACKGROUND-COLOR: #CDEDE2;}
      .tr2 { BACKGROUND-COLOR: #50A0A0 }
      .td2o2 { BACKGROUND-COLOR: #DDFDF2 }
      .PicBar { background-color: #336699; border: 1px solid #000000; height: 12px;}
.td1o21 {BACKGROUND-COLOR: #EAEAEA}
</STYLE>
<SCRIPT language="JavaScript">
      var CCNS_program = "COCOON ASP.net Environment Probe";
      var CCNS_version = "1.0";
      document.title += CCNS_program + " v" + CCNS_version;
</SCRIPT>
<script language="JavaScript">
	window.onload = function(){document.readyState = 'complete';};	//For netscape!!!
	function showLoadingAnimation(sDivName,n){
		var a,o;
		var a = Array('-','\\','|','/');
		if(!(o=document.getElementById(sDivName))) return ;
		var i = (isNaN(n)?0:n%4);
		o.innerHTML = a[i];
		if(document.readyState=='complete') return ;
		setTimeout('showLoadingAnimation("'+sDivName+'",'+(i+1)+')',1000);
	}
</script>
<SCRIPT language="JavaScript">
		var sErrorMessage = "";
		function getObjByID(n) {
			//This function was re-written form DreamWeaver v4.01 by Sunrise_Chen.
			var p,i,x;
			var d=document; 
			if(!(x=d[n])&&d.all) x=d.all[n];
			for(i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
			for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=getObjByID(n,d.layers[i].document);
			if(!x && d.getElementById) x=d.getElementById(n); 
			return x;
		}
		
		function pageInit(){
			document.title = CCNS_program + " v" + CCNS_version ;
			if(!getObjByID("chkAspSupport")){
				oDiv = getObjByID("divAspSupport");
				if(oDiv){
					oDiv.style.display="none";
					oDiv.id="DisabledDiv";
				}
				oDiv = getObjByID("divNoASP");
				if(oDiv){
					oDiv.style.display="";
					oDiv.id="divServer";
				}
			}
			
			if(oDiv=getObjByID("divStatus")) oDiv.innerHTML = "<font color=blue style='border:solid 1px blue;padding-top:1px;padding-left:5px;padding-right:5px;'>更新信息</font> 感谢你使用COCOON ASP<sup>.net</sup>系统环境探针。 [点这里可以下载本探针]";
		}

		window.onerror = new Function("return true");
	</SCRIPT>
</HEAD>
  <BODY onError="return true;">
<table width="750" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="230" style="font-family:Verdana, Arial, Helvetica">
	  <p style="margin-top: 0; margin-bottom: -5;font-size:8pt"><strong>COCOON</strong>
	  <span style="width:155;text-align:right">
	  <font color="#666666">v <script language="JavaScript">document.write(CCNS_version)</script></font>
	  </span>
	  </p>
      <p style="margin-top: 0; margin-bottom: -8;"> &nbsp;<strong style="font-size:24pt">ASP<SUP><font size="2" style="font-size:15pt">.net</font></SUP> 
        探针</strong></p>
      <p style="margin-top: 1;">&nbsp;<font color="#333333" style="font-size:9pt"><u>Server/Client 
        Environment Probe</u></font></p></td>
    <td align="center"> <table style="width:480;height:60;text-align:left">
        <tr>
          <td id="divCcAd" style="border:solid 1px black;text-align:left;"> 
		  <!--
			<embed src="http://www.senye.com/image/1.swf" width="468" height="60"></embed>
			<a href='http://www.senye.net' target='_blank' style='color:#C60000'>
			　　　　　　→ 胜易网络（Senye.net）专业域名主机服务<br>　　　　　　　　→ 100MASP.NET空间送域名邮箱仅售350元<br>　　　　　　　　　　→ QQ：62736，Tel：0595-3114896 3286984(Fax)
			</a>
			-->
		  <center>
				* 欢迎使用COCOON ASP.net探针，本软件为免费软件，请勿用于商业用途。<br>
            　&nbsp;你可以从作者的网站(<a href="http://www.ccopus.com">www.ccopus.com</a>)或其他支持者的网站得到本软件。 
		  </center>
			</td>
        </tr>
      </table></td>
  </tr>
</table>

<table width="750" border="0" cellspacing="0" cellpadding="0" style="width:750;border:0px solid black;padding: 5px;padding-right:0px">
  <tr> 
    <td title="点这里查看COCOON ASP.NET探针的最新版本">
			<DIV id='divStatus' style='font-family:Verdana;cursor:hand;' onClick="window.open('http://www.ccopus.com/code/aspSysCheck.asp')">
				<strong style="font-size:16px;color:red">Loading...</strong>
			</DIV>
		</td>
    <td align="right" width="204"> <nobr> <a href="javascript:void(0);" class="td1o2" onFocus="this.blur();">※ 
      Server Side</a> &nbsp; <a href="javascript:void(0);" class="td2o2" onFocus="this.blur();">※ 
      Client Side</a> </nobr> </td>
    <td width="22" style="text-align:right"> <div class="tr1" id="divFlag" style="width:18;height:28;font-family:Times New Roman;font-size:18px;color:#ffffff;text-align:center;padding-top: 3px;">S</div></td>
  </tr>
</table>

<DIV id="divServerSide">

<DIV id="divAspSupport">
    <table width="750" border="0" cellpadding="1" cellspacing="1" class="tbl1">
      <tr> 
    <td class="tr1"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
            <td>&nbsp;<font color="#FFFFFF" face="webdings">8</font><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"> 
              <strong>服务器端基本信息 </strong>
			  <% if(!bShowDetail){ %>
			  <!--
				<a href="<%=sTheFile%>?ServerDetail" style="color:#ffffff">[ <u>更详细的信息</u> ]</a>
				-->
			  <% } %>
			  <strong>:::...</strong></font></td>
          <td align="right"><font color="#D2D8EC">服务器当前时间: <%=DateTime.Now%>&nbsp;&nbsp;</font></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#F8F9FC"> <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tbl1o1">
            <tr> 
              <td width="125" class="td1"><font color="#5C72BA">&nbsp;</font>项目</td>
              <td colspan="3" class="td1"><font color="#5C72BA">&nbsp;</font>值</td>
            </tr>
            <tr> 
              <td width="125" nowrap class="td1o1"> &nbsp;域名 / IP<br> <font color="#666666">&nbsp;Domain 
                Name</font></td>
              <td colspan="3" class="td1o2">&nbsp;<%=Request.ServerVariables("SERVER_NAME")%> 
                &nbsp;/ <%=Request.ServerVariables("LOCAL_ADDR")%> [ 端口:<%=Request.ServerVariables("SERVER_PORT")%> 
                ]</td>
            </tr>
            <tr> 
              <td width="125" nowrap class="td1o1"> &nbsp;服务器名<br> <font color="#666666">&nbsp;Machine 
                Name</font></td>
              <td width="230" class="td1o2">&nbsp;<%=Environment.MachineName%></td>
              <td width="125" nowrap class="td1o1">&nbsp;服务器网络域名<br>
                <font color="#666666">&nbsp;Domain Name</font></td>
              <td width="230" class="td1o2">&nbsp;<span class="td1o21"><%=Environment.UserDomainName.ToString()%></span></td>
            </tr>
            <tr> 
              <td width="125" nowrap class="td1o1"> &nbsp;操作系统<br> <font color="#666666">&nbsp;Operating 
                System</font></td>
              <td colspan="3" class="td1o2"> &nbsp;<%=Environment.OSVersion.ToString()%>&nbsp; </td>
            </tr>
            <tr> 
              <td width="125" nowrap class="td1o1">&nbsp;系统文件夹<br> <font color="#666666">&nbsp;System 
                Directory</font></td>
              <td class="td1o2">&nbsp;<%=Environment.SystemDirectory.ToString()%></td>
              <td nowrap class="td1o1">&nbsp;运行时长<br> 
                <font color="#666666">&nbsp;TickCount</font></td>
              <td class="td1o2">&nbsp;<%=Math.round(Environment.TickCount/600/60)/100%> 小时</td>
            </tr>
            <tr> 
              <td width="125" nowrap class="td1o1"> &nbsp;信息服务软件<br> <font color="#666666">&nbsp;Server 
                Software</font></td>
              <td colspan="3" class="td1o2">&nbsp;<%=Request.ServerVariables("SERVER_SOFTWARE")%> 
                ( .NET RTL 版本: <%=Environment.Version%> ) </td>
            </tr>
            <tr> 
              <td width="125" nowrap class="td1o1">&nbsp;当前用户<br>
                <font color="#666666">&nbsp;Current User</font></td>
              <td class="td1o2">&nbsp;<span class="td1o21"><%=Environment.UserName%></span></td>
              <td nowrap class="td1o1">&nbsp;当前文件夹<br> <font color="#666666">&nbsp;Current 
                Directory</font></td>
              <td class="td1o2">&nbsp;<%=Environment.CurrentDirectory.ToString()%></td>
            </tr>
            <tr> 
              <td width="125" nowrap class="td1o1">&nbsp;完整地址<br> <font color="#666666">&nbsp;URL 
                &amp; Path</font></td>
              <td colspan="3" class="td1o2">&nbsp; 
                <%
					var sHostName = Request.ServerVariables("HTTP_HOST")
					var sPostNo = Request.ServerVariables("SERVER_PORT ")
					var sUrl = Request.ServerVariables("URL")
					Response.Write("http://" + sHostName + (sPostNo=='80'?'':sPostNo) + sUrl)
				%>
                <br> &nbsp; <%=Request.ServerVariables("PATH_TRANSLATED")%> </td>
            </tr>
            <tr> 
              <td width="125" nowrap class="td1o1"> &nbsp;相对路径<br> <font color="#666666">&nbsp;Path 
                Info</font></td>
              <td class="td1o2"> <span style="width:230px;height:16px;overflow-y:auto;word-break:break-all"> 
                &nbsp;<%=Request.ServerVariables("PATH_INFO")%> </span> </td>
              <td nowrap class="td1o1"> &nbsp;物理路径<br> <font color="#666666">&nbsp;Physical 
                Path</font></td>
              <td class="td1o2"> <span style="width:230;height:18;overflow-y:auto;">	
                &nbsp;<%=Request.ServerVariables("APPL_PHYSICAL_PATH")%> </span> 
              </td>
            </tr>
            <tr> 
              <td width="125" nowrap class="td1o1"> &nbsp;脚本引擎<br> <font color="#666666">&nbsp;ScriptEngine</font></td>
              <td colspan="3" nowrap class="td1o2" id="divScriptEngine"> &nbsp;JScript 
                / <%=ScriptEngineMajorVersion() +"." + ScriptEngineMinorVersion() +"." + ScriptEngineBuildVersion() + " "%></td>
            </tr>
            <tr> 
              <td width="125" nowrap class="td1o1"> &nbsp;脚本超时<br> <font color="#666666">&nbsp;Script 
                Timeout</font></td>
              <td nowrap class="td1o2">&nbsp;<%=Server.ScriptTimeout%> 秒</td>
              <td nowrap class="td1o1">&nbsp;当前会话编号<br>
                <font color="#666666">&nbsp;Session ID</font></td>
              <td class="td1o2">&nbsp;<%=Session.SessionID%></td>
            </tr>
            <tr> 
              <td width="125" nowrap class="td1o1">&nbsp;本页命令行<br> <font color="#666666">&nbsp;Command Line</font></td>
              <td colspan="3" class="td1o2">&nbsp; <span style="width:590px;word-break:break-all"><%=Environment.CommandLine%></span> 
              </td>
            </tr>
            <tr> 
              <td nowrap class="td1o1"> &nbsp;服务器变量数<br>
                <font color="#666666">&nbsp;Application Count</font></td>
              <td nowrap class="td1o2">&nbsp;<%=Application.Contents.Count%></td>
              <td nowrap class="td1o1">&nbsp;会话变量数<br>
                <font color="#666666">&nbsp;Session Count</font></td>
              <td class="td1o2">&nbsp;<%=Session.Contents.Count%> </td>
            </tr>
          </table></td>
  </tr>
  <tr> 
    <td height="5" class="tr1"></td>
  </tr>
</table><br>
    <table width="750" border="0" cellpadding="1" cellspacing="1" class="tbl1">
      <tr> 
    <td class="tr1"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>&nbsp;<font color="#FFFFFF" face="webdings">8</font><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"> 
            <strong>服务器组件信息 :::...</strong></font></td>
          <td align="right"><font color="#D2D8EC">Coding by Sunrise_Chen.&nbsp;</font></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#F8F9FC"> <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tbl1o1">
            <tr> 
            <td width="80%" class="td1">&nbsp;组件名</td>  <td width="10%" align="center" class="td1">支持</td>
            <td width="10%" align="center" class="td1">版本</td>
        </tr>
        <%
			var iIndex, sObjName, sObjDetail, sObjType, iIndexCount, bShowUnSupport;
			var sObjVersion,bObjInstalled;
			iIndex = 0;
			iIndexCount = -1;
			bShowUnSupport = false;
			for(var i=0;;i++){
				if(i>=arrObj.length||iIndex!=arrObj[i][2]){
					if(iIndexCount==0&&iIndex<99){
						Response.Write(
							'<tr>\n'+
							'<td width="80%" bgcolor="#D5D5D5" style="color:#666666;" colspan="3"> &nbsp;<i>( 服务器暂不支持该类组件 )</i></td>\n'+
							'</tr>\n'
						);
					}
					if(i>=arrObj.length) break;
					iIndex=arrObj[i][2];
					iIndexCount=0;
					switch(iIndex){
						case 1: sObjType = "IIS自带组件"; break;
						case 2: sObjType = "常见的第三方文件上传和管理组件"; break;
						case 3: sObjType = "常见的第三方文件邮件发送组件"; break;
						case 4: sObjType = "常见的图像处理组件"; break;
						default: sObjType = "自定义组件"; break;
					}
					Response.Write(
						'<tr>\n'+
						'<td colspan="3" class="td1o1"> &nbsp;■<b> '+sObjType+'</b></td>\n'+
						'</tr>\n'
					);
        		} 
				sObjName = arrObj[i][0]
				sObjDetail = arrObj[i][1];
				bObjInstalled = true;
				sObjVersion = getObjVer(sObjName);
				if(sObjVersion=="N/A"){
					bObjInstalled = false;
					sObjVersion = "";
				}
				
				if(bObjInstalled||iIndex==99){
					iIndexCount++;
					Response.Write(
						'<tr>\n'+
						'<td width="80%" bgcolor="#D5D5D5">'+
						' &nbsp;' + sObjName + (sObjDetail?' <font color="#666666">( ' + sObjDetail + ' )</font>':'') + '\n' +
						'</td>\n'+
						'<td width="10%" align="center" class="td1o2">' + (bObjInstalled?"√":"×") + '</td>\n' +
						'<td width="10%" align="center" class="td1o2"><span style="width:100%;height:18;overflow-y:auto;">' + sObjVersion + '</span></td>\n' +
						'</tr>\n'
					);
				}
        	} 
		%>
            <tr> 
              <form method="post" action="<%=sTheFile%>">
                <td colspan="3" class="td1o2">&nbsp;检测其他组件 
                  <input name="sObjName" type="text" class="tbl1" id="sObjName" style="border:1px solid #999999;background-color:#eeeeee;width:400px"> 
              <input name="Submit" type="submit" value="提交" style="border:1px;background-color:#666666;color:#eeeeee;padding-top:1px;width:70px">
                </td>
          </form>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="5" class="tr1"></td>
  </tr>
</table>
<br>
  <% //if(bShowDetail){ %>
    <table width="750" border="0" cellpadding="1" cellspacing="1" class="tbl1">
      <tr> 
      <td class="tr1"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td>&nbsp;<font color="#FFFFFF" face="webdings">8</font><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"> 
              <strong>服务器端环境变量列表 :::...</strong></font></td>
            <td align="right"><font color="#D2D8EC">Coding by Sunrise_Chen.&nbsp;</font></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td bgcolor="#F8F9FC">
	    <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tbl1o1">
          <tr> 
            <td width="30%" class="td1"><font color="#5C72BA">&nbsp;</font>项目</td>
            <td class="td1"><font color="#5C72BA">&nbsp;</font>值</td>
          </tr>
		  <%
		  	try{
		  	var WshShell;
		  	WshShell = Server.CreateObject("WScript.Shell");
		  %>
		  <% for(x in WshShell.Environment){ %>
          <tr> 
            <td class="td1o1">&nbsp;<%=x.substr(0,x.indexOf("="))%>
            </td>
            <td class="td1o2" style="padding: 7px;"><%=x.substr(x.indexOf("=")+1)%></td>
          </tr>
		  <% } %>
		  <% }catch(e){}%>
		  <% for(x in Request.ServerVariables){ %>
          <tr> 
            <td class="td1o1">&nbsp;<%=x%>
            </td>
            <td class="td1o2" style="padding: 7px;"><%=Request.ServerVariables(x)%></td>
          </tr>
		  <% } %>
        </table></td>
    </tr>
    <tr> 
      <td height="5" class="tr1"></td>
    </tr>
  </table><br>
  <% //} %>
</DIV>

<table width="750" border="0" cellpadding="3" cellspacing="1" class="tbl1" id="divNoASP" style="display:none">
  <tr> 
    <td class="tr1"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td>&nbsp;<font color="#FFFFFF" face="webdings">8</font><font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif"> 
            <strong>其它信息 :::...</strong></font></td>
          <td align="right"><font color="#FFFAF7">Coding by Sunrise_Chen.&nbsp;</font></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#F8F9FC"> <table width="100%" border="0" cellpadding="3" cellspacing="1" class="tbl1o1">
        <tr> 
            <td width="60%" class="td1">&nbsp;信息描述</td>
        </tr>
        <tr> 
            <td width="60%" class="td1o1" id="divErrorMessage"></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td height="5" class="tr1"></td>
  </tr>
</table>

</DIV>

<!--测试是否支持服务器脚本-->
<%="<div id='chkAspSupport'></div>"%> 
<SCRIPT language="JavaScript">
	pageInit();
	if(!getObjByID("chkAspSupport"))
		sErrorMessage += "当前服务器不支持ASP.NET！<A HREF='aspSysCheck.asp'>是否启用COCOON ASP版探针</A>？<br>\n";
</SCRIPT>

<SCRIPT language="JavaScript">pageInit();</SCRIPT>
<SCRIPT id="divOperFrame"></SCRIPT>
<SCRIPT language="JavaScript">
	var i=1;
	var bOper = false;
	var timScript=setInterval("getScriptInfomation()",250);
	
	function getScriptInfomation(){
		var oDiv = getObjByID("divOperFrame");
		if(oDiv.readyState.toLowerCase()!='complete') return;
		switch(i){
		case 2 :
			oDiv.src="ccDotNetCheckvbPlugin.aspx";
			--i;
			break;
		case 1 :
			oDiv.src="ccDotNetCheckvbPlugin.aspx";
			--i
			break;
		case 0 :
			clearInterval(timScript);
			break;
		}
	}
</SCRIPT>
<div align="center" style="width:750px">
	<hr size="1">
  Copyright(C) <a href="mailto:sunrise@citiz.net">Sunrise_Chen</a> @ <a href="http://www.ccopus.com">COCOON 
  sTudio [ www.ccopus.com ]</a> . <br>
      本程序由Sunrise_Chen编写，转载时请保留这些信息.
	  <%="<br>本页面执行所需内存：<font color='#990000'><b>" + (Math.round(Environment.WorkingSet/1024/1024*100)/100).ToString() + "</b></FONT> KB."%>
	  <% var tPageEndTime = new Date(); %>
	  <%="执行时间：约 <font color='#990000'><b>"+((tPageEndTime-tPageStartTime)/1000)+"</b></font> 秒"%>
	  <script langauge="JavaScript" src="http://www.ccopus.com/_js/count_aspcheckdotnet.js"></script>
</div>
  </BODY>
</HTML>
