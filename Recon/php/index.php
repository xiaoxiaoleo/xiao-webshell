<?php
header("content-Type: text/html; charset=gb2312");
/* 
+----------------------------------------------------------------------
|   **如果你看到了这里，说明你的服务器不支持PHP**
+----------------------------------------------------------------------
|   文件名： 废墟のPHP探针
+---------------------------------------------------------------------- 
|   Copyright  2003-2005 WapCity 版权所有并保留所有版权                  
+---------------------------------------------------------------------- 
|   本探针制作时参考了其他一些探针        
|   此向其作者表示感谢                      
+----------------------------------------------------------------------
|   作者： 废墟の复甦 < anerg@183.ha.cn > [ QQ:1616676 ]
+----------------------------------------------------------------------
*/
$version = "1.3.5";
$AD = '* 欢迎使用废墟のPHP探针，本程序公开源代码，你可以任意复制、传播和使用。<BR>
            &nbsp;&nbsp;你可以从我的网站 ( <A 
            href="http://wapcity.org.ru/" target=_blank>http://wapcity.org.ru/</A>), 或其他支持站点下载到本程序。<BR><a href=./blog/>点此进入我的BLOG</a>';
extract($_GET);extract($_POST);
function getmicrotime()
{ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
} 
$page_time_start=getmicrotime();
//脚本运行时间
function addTime()
{
	$time_start=getmicrotime();
	for($index=0;$index<=500000;$index++);
	{
		$count=1+1;
	}
	$time_end=getmicrotime();
	$time=$time_end-$time_start;
	$time=round($time*1000);
	$time="<font color=red>$time</font>";
	return($time);	
}//END FUNCTION
function sqrtTime()
{
	$test=pi();
	$time_start=getmicrotime();
	for($index=0;$index<=500000;$index++);
	{
		sqrt($test);
	}
	$time_end=getmicrotime();
	$time=$time_end-$time_start;
	$time=round($time*1000);
	$time="<font color=red>$time</font>";
	return($time);
}//END FUNCTION
function echo_info($str)
	{
	echo "<script>alert('$str')</script>";
	}
if ("mysql" == $conn)
{
	if(function_exists("mysql_close")==1)
	{
		$link = @mysql_connect($sql_host.":".$sql_port, $sql_login, $sql_password);
		if ($link) 
		{
			echo_info("帐号 $sql_login 连接到MySql数据库正常");
		} else
		{
			echo_info("无法连接到MySql数据库！");
		}
	}
	else
	{
		echo_info("服务器不支持MySQL数据库！");
	}
}//END IF
if ("psql" == $conn)
{
	if(function_exists("pg_connect")==1)
	{
		$conn_string = "host=$sql_host port=$sql_port dbname=$sql_dbname user=$sql_login password=$sql_password";
		$link = @pg_connect($conn_string);
		if ($link) 
		{
			echo_info("帐号 $sql_login 连接到PostgreSQL数据库正常");
		} else
		{
			echo_info("无法连接到PostgreSQL数据库！");
		}
	}
	else
	{
		echo_info("服务器不支持PostgreSQL数据库！");
	}
}//END IF
//服务器时间比较
$svr[] = "我的电脑 (P4/1.7G+256M+Win2k)";
//整数运算
$svr_atime[] = "404";
//浮点运算
$svr_stime[] = "398";

$svr[] = "chromehost.com (2004-5-14)";
$svr_atime[] = "324";
$svr_stime[] = "314";

$svr[] = "www.psychz.net (2004-5-14)";
$svr_atime[] = "160";
$svr_stime[] = "152";

$svr[] = "cun.jp (2004-5-14)";
$svr_atime[] = "733";
$svr_stime[] = "579";

$svr[] = "恩博在线 商务型(L)-200M (2004-5-14)";
$svr_atime[] = "554";
$svr_stime[] = "551";

//当前主机
$svr[] = "<font color=red>当前这台服务器</font>";
$svr_atime[] = addTime();
$svr_stime[] = sqrtTime();

if ("phpinfo" == $testinfo)
{
	phpinfo();
	exit;
}//END IF
function temp($temp)
{
	if($temp==1)
	{
	$s='<font color=green>支持<b>√</b></font>';
	}
	else
	{
	$s='<font color=red>不支持<b>×</b></font>';
	}
	return $s;
}
/*获取服务器信息*/
$info[] = $_SERVER['SERVER_NAME'];//主机名
$info[] = getenv(SERVER_ADDR); //服务器IP
$info[] = getenv(SERVER_PORT);//端口
$info[] = PHP_OS; //服务器操作系统
$info[] = $_SERVER['SERVER_SOFTWARE']; //web服务器版本
$info[] = PHP_VERSION;//php版本
$info[] = getenv("HTTP_ACCEPT_LANGUAGE"); //服务器语种
$info[] = zend_version();
$info[] = $_SERVER['DOCUMENT_ROOT']. "<br>".$_SERVER['$PATH_INFO']; //绝对路径
$info[] = intval(diskfreespace(".") / (1024 * 1024))."M"; //服务器空间大小
$info[] = date("n月j日H点i分s秒"); //服务器时间
$info[] = get_current_user(); //用户
$info[] = isset($_SERVER["SERVER_ADMIN"])?"<a href=\"mailto:$_SERVER[SERVER_ADMIN]\" title=发送邮件>$_SERVER[SERVER_ADMIN]</a>":"<a href=\"mailto:get_cfg_var(sendmail_from)\" title=发送邮件>get_cfg_var(sendmail_from)</a>"; //管理员邮箱
/*PHP基本特性*/
$dis_func = get_cfg_var("disable_functions");
$php[] = ereg("phpinfo",$dis_func)?"<font color=red>不支持<b>×</b></font>":"<font color=green>支持<b>√</b></font><a href=$PHP_SELF?testinfo=phpinfo title=点此查看PHPINFO细信息>点此查看PHPINFO细信息</a>";
$php[] = get_cfg_var("register_globals")==0?"<font color=red>不支持<b>×</b></font>":"<font color=green>支持<b>√</b></font>";
$php[] = get_cfg_var("memory_limit")?get_cfg_var("memory_limit"):"无"; //单个脚本运行时可占用的最大内存
$php[] = get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):"不允许上传附件";   //用PHP脚本上传文件大小限制
$php[] = get_cfg_var("disable_functions")?get_cfg_var("disable_functions"):"无"; //被屏蔽的函数
$php[] = get_cfg_var("post_max_size"); //post方法提交内容限制
$php[] = get_cfg_var("max_execution_time")."秒"; //脚本超时时间
$php[] = temp(get_cfg_var("display_errors")); 
/*常见组件*/   
$obj[] = temp(get_magic_quotes_gpc("smtp"));//SMTP
$obj[] = temp(get_cfg_var("safe_mode"));  //PHP安全模式(Safe_mode)
$obj[] = temp(get_magic_quotes_gpc("XML Support"));//XML 支持      
$obj[] = temp(get_magic_quotes_gpc("FTP support"));//FTP 支持
$obj[] = temp(get_cfg_var("allow_url_fopen"));//允许使用URL打开文件
$obj[] = temp(get_cfg_var("enable_dl"));//动态链接库
/*其他组件*/
$qobj[] = temp(function_exists("imap_close"));//IMAP电子邮件系统 
$qobj[] = temp(function_exists("JDToGregorian"));//历法
$qobj[] = temp(function_exists("gzclose")); //压缩文件支持(Zlib)
$qobj[] = temp(function_exists("session_start")); //Session支持
$qobj[] = temp(function_exists("fsockopen")); //Socket支持
$qobj[] = temp(function_exists("preg_match"));//PREL相容语法 PCRE
$qobj[] = temp(function_exists("imageline"));//图形处理 GD Library
$qobj[] = temp(function_exists("FDF_close"));//FDF表单资料格式
$qobj[] = temp(function_exists("iconv"));//ICONV
$qobj[] = temp(function_exists("snmpget"));//SNMP网络管理协议


/*数据库信息*/
$sql[] = temp(function_exists("mysql_close")); //mysql数据库
$sql[] = temp(function_exists("odbc_close")); //odbc数据库
$sql[] = temp(function_exists("ora_close")); //ora数据库
$sql[] = temp(function_exists("OCILogOff"));//Oracle 8 数据库
$sql[] = temp(function_exists("mssql_close"));//SQL Server数据库
$sql[] = temp(function_exists("msql_close"));//msql数据库
$sql[] = temp(function_exists("hw_close"));//Hyperwave数据库
$sql[] = temp(function_exists("dbase_close"));//dbase数据库
$sql[] = temp(function_exists("pg_connect"));//PostgreSQL数据库
$sql[] = temp(function_exists("filepro"));//firePro数据库
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>废墟のPHP探针V<?=$version?></title>
<STYLE type=text/css>
BODY {
	FONT-SIZE: 9pt; FONT-FAMILY: "Tahoma","Arial","Helvetica","sans-serif"
}
.input
{
	BORDER: #3f5294 1px solid;
	FONT-SIZE: 9pt;
	BACKGROUND-color: #f8f9fc
}
.sub
{
	BACKGROUND-COLOR: #5C72BA;
	BORDER: medium none;
	COLOR: #ffffff;
	HEIGHT: 18px;
	font-size: 9pt
}
TD {
	FONT-SIZE: 9pt; FONT-FAMILY: "Tahoma","Arial","Helvetica","sans-serif"
}
A {
	COLOR: #000000; TEXT-DECORATION: none
}
A:hover {
	COLOR: #ff0000; TEXT-DECORATION: none
}
A.td1o2 {
	BORDER-RIGHT: #333 3px double; PADDING-RIGHT: 5px; BORDER-TOP: #333 3px double; PADDING-LEFT: 5px; BORDER-LEFT: #333 3px double; BORDER-BOTTOM: #333 3px double
}
A.td2o2 {
	BORDER-RIGHT: #333 3px double; PADDING-RIGHT: 5px; BORDER-TOP: #333 3px double; PADDING-LEFT: 5px; BORDER-LEFT: #333 3px double; BORDER-BOTTOM: #333 3px double
}
.tbl1 {
	BORDER-RIGHT: #3f5294 1px solid; BORDER-TOP: #3f5294 1px solid; FONT-SIZE: 9pt; BORDER-LEFT: #3f5294 1px solid; BORDER-BOTTOM: #3f5294 1px solid
}
.td1 {
	BORDER-RIGHT: #ffffff 0px solid; BORDER-TOP: #ffffff 1px solid; BORDER-LEFT: #ffffff 1px solid; COLOR: #336699; BORDER-BOTTOM: #ffffff 0px solid; BACKGROUND-COLOR: #abb6dc
}
.tbl1o1 {
	BACKGROUND-COLOR: #8595cb
}
.td1o1 {
	BORDER-RIGHT: #ffffff 0px solid; BORDER-TOP: #ffffff 1px solid; BORDER-LEFT: #ffffff 1px solid; BORDER-BOTTOM: #ffffff 0px solid; BACKGROUND-COLOR: #e2e7f3
}
.tr1 {
	BACKGROUND-COLOR: #5c72ba
}
.td102a {
	COLOR: #5c72ba
}
.td1o22 {	BACKGROUND-COLOR: #f3f4fa
}
.font1 {
	color: #FFFFFF;
	font-family: Tahoma, Verdana, Arial;
	font-size: 9pt;
	font-weight: bold;
}
</STYLE>
</head>

<body>
<div align="center">
  <a name="top"></a>
  <TABLE cellSpacing=0 cellPadding=0 width=750 border=0>
    <TBODY>
      <TR align="left">
        <TD width=230 style="FONT-FAMILY: Verdana, Arial, Helvetica">
          <P 
      style="MARGIN-TOP: 0px; FONT-SIZE: 9pt; MARGIN-BOTTOM: -5px">废墟のPHP探针</P>
          <P style="MARGIN-TOP: 0px; MARGIN-BOTTOM: -8px">&nbsp;<STRONG style="FONT-SIZE: 24pt">PHP ENV</STRONG> <FONT color=#666666>v
		  <?=$version?>
          </FONT></P>
        <P style="MARGIN-TOP: 0px">&nbsp;<FONT style="FONT-SIZE: 9pt" 
      color=#333333><U>Server Environment Probe</U></FONT></P></TD>
        <TD>
          <TABLE 
      style="BORDER-RIGHT: black 1px solid; BORDER-TOP: black 1px solid; PADDING-LEFT: 10pt; BORDER-LEFT: black 1px solid; WIDTH: 480px; BORDER-BOTTOM: black 1px solid; HEIGHT: 60px; TEXT-ALIGN: left" 
      cellSpacing=0 cellPadding=0 border=0>
            <TBODY>
              <TR>
                <TD height=56><SPAN id=divCcAd name="divCcAd"><?=$AD?></SPAN></TD>
              </TR>
            </TBODY>
        </TABLE></TD>
      </TR>
    </TBODY>
  </TABLE>
  <table width="750" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="633" class="td102a"> 出现以下情况即表示您的空间不支持PHP： 1、访问本文件时提示下载。 2、访问本文件时看到类似“&lt;?php?&gt;”的文字。 </td>
      <td width="117" align="right"> <a href="<?=$_SERVER[PHP_SELF]?>">刷新 </a><a href="#bottom">底部↓ </a> </td>
    </tr>
  </table>
  <TABLE class=tbl1 cellSpacing=1 cellPadding=3 width=750 border=0 >
    <TBODY align="left">
      <TR>
        <TD class=tr1>
          <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
            <TBODY>
              <TR>
                <TD><FONT class="font1">■服务器的有关参数:::...</FONT></TD>
              </TR>
            </TBODY>
        </TABLE></TD>
      </TR>
      <TR>
        <TD bgColor=#f8f9fc>
          <TABLE class=tbl1o1 cellSpacing=1 cellPadding=3 width="100%" border=0>
            <TBODY>
              <TR>
                <TD class=td1 width=130>&nbsp;项目</TD>
                <TD class=td1 colSpan=3>&nbsp;值</TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;域名<BR>
                    <FONT color=#666666>&nbsp;Domain Name</FONT></TD>
                <TD class=td1o22 colSpan=3>&nbsp;<?=$info[0]?>&nbsp;&nbsp;-&nbsp;&nbsp;<?=$info[1]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;服务器端口<BR>
                    <FONT color=#666666>&nbsp;Server Port</FONT></TD>
                <TD class=td1o22 width=240>&nbsp;<?=$info[2]?></TD>
                <TD class=td1o1 width=130>&nbsp;服务器操作系统<BR>
                    <FONT color=#666666>&nbsp;Operating System</FONT></TD>
                <TD class=td1o22 width=240>&nbsp;<?=$info[3]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;WEB服务器版本<BR>
                    <FONT color=#666666>&nbsp;Web Server Version</FONT></TD>
                <TD class=td1o22 width=240>&nbsp;<?=$info[4]?></TD>
                <TD class=td1o1 noWrap width=130>&nbsp;PHP版本<BR>
                    <FONT color=#666666>&nbsp;PHP Version</FONT></TD>
                <TD class=td1o22 width=240>&nbsp;<?=$info[5]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;服务器语种<BR>
                    <FONT color=#666666>&nbsp;Server Language</FONT></TD>
                <TD class=td1o22 width=240>&nbsp;<?=$info[6]?></TD>
                <TD class=td1o1 width=130>&nbsp;ZEND版本<BR>
                    <FONT color=#666666>&nbsp;ZEND Version</FONT></TD>
                <TD class=td1o22 width=240>&nbsp;<?=$info[7]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 noWrap width=130>&nbsp;绝对路径<BR>
                    <FONT color=#666666>&nbsp;Full path</FONT></TD>
                <TD class=td1o22 noWrap width=240>&nbsp;<?=$info[8]?></TD>
                <TD class=td1o1 noWrap>&nbsp;服务器剩余空间<BR>
                    <FONT color=#666666>&nbsp;Disk Free Space</FONT></TD>
                <TD class=td1o22 width=240>&nbsp;<?=$info[9]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;服务器时间<BR>
                    <FONT color=#666666>&nbsp;Server Current Time</FONT></TD>
                <TD class=td1o22 colSpan=3>&nbsp;<?=$info[10]?></TD>
              </TR>
            </TBODY>
        </TABLE></TD>
      </TR>
      <TR>
        <TD class=tr1 height=5></TD>
      </TR>
    </TBODY>
  </TABLE>
  <br>  
  <TABLE class=tbl1 cellSpacing=1 cellPadding=3 width=750 border=0 >
    <TBODY align="left">
      <TR>
        <TD class=tr1>
          <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
            <TBODY>
              <TR>
                <TD><FONT class="font1">■PHP基本参数:::...</FONT></TD>
              </TR>
            </TBODY>
        </TABLE></TD>
      </TR>
      <TR>
        <TD bgColor=#f8f9fc>
          <TABLE class=tbl1o1 cellSpacing=1 cellPadding=3 width="100%" border=0>
            <TBODY>
              <TR>
                <TD class=td1 width=130>&nbsp;项目</TD>
                <TD class=td1>&nbsp;值</TD>
                <TD class=td1>&nbsp;项目</TD>
                <TD class=td1>&nbsp;值</TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;PHP信息PHPINFO<br>
                <FONT color=#666666>&nbsp;PHPINFO</FONT></TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$php[0]?></TD>
                <TD class=td1o1 width=130>&nbsp;自定义全局变量<br>
                <FONT color=#666666>&nbsp;register_globals </FONT></TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$php[1]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;脚本运行可占最大内存<br>
                <FONT color=#666666>&nbsp;memory_limit </FONT>                  <br></TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$php[2]?></TD>
                <TD class=td1o1 width=130>&nbsp;脚本上传文件大小限制<br>
                <FONT color=#666666>&nbsp;upload_max_filesize</FONT> </TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$php[3]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;被屏蔽的函数<br>
                <FONT color=#666666>&nbsp;disable_functions</FONT> </TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$php[4]?></TD>
                <TD class=td1o1 width=130>&nbsp;POST方法提交限制<br>
                <FONT color=#666666>&nbsp;post_max_size</FONT> </TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$php[5]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 noWrap width=130>&nbsp;脚本超时时间<br>
                <FONT color=#666666>&nbsp;max_execution_time</FONT> </TD>
                <TD class=td1o22 noWrap width=240>&nbsp;
                    <?=$php[6]?></TD>
                <TD class=td1o1 noWrap>&nbsp;显示错误信息<BR>
                    <FONT color=#666666>&nbsp;display_errors</FONT></TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$php[7]?></TD>
              </TR>
            </TBODY>
        </TABLE></TD>
      </TR>
      <TR>
        <TD class=tr1 height=5></TD>
      </TR>
    </TBODY>
  </TABLE>
  <br>
  <TABLE class=tbl1 cellSpacing=1 cellPadding=3 width=750 border=0 >
    <TBODY align="left">
      <TR>
        <TD class=tr1>
          <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
            <TBODY>
              <TR>
                <TD><FONT class="font1">■常见组件信息:::...</FONT></TD>
              </TR>
            </TBODY>
        </TABLE></TD>
      </TR>
      <TR>
        <TD bgColor=#f8f9fc>
          <TABLE class=tbl1o1 cellSpacing=1 cellPadding=3 width="100%" border=0>
            <TBODY>
              <TR>
                <TD class=td1 width=130>&nbsp;组件名称</TD>
                <TD class=td1>&nbsp;支持情况</TD>
				<TD class=td1>&nbsp;组件名称</TD>
                <TD class=td1>&nbsp;支持情况</TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;SMTP支持<br>
                    <FONT color=#666666>&nbsp;smtp</FONT></TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$obj[0]?></TD>
                <TD class=td1o1 width=130>&nbsp;PHP安全模式<br>
                    <FONT color=#666666>&nbsp;Safe_mode</FONT></TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$obj[1]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;XML 支持<br>
                    <FONT color=#666666>&nbsp;XML Support</FONT> <br></TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$obj[2]?></TD>
                <TD class=td1o1 width=130>&nbsp;FTP 支持<br>
                    <FONT color=#666666>&nbsp;FTP support</FONT> </TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$obj[3]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;允许使用URL打开文件<br>
                    <FONT color=#666666>&nbsp;allow_url_fopen</FONT> </TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$obj[4]?></TD>
                <TD class=td1o1 width=130>&nbsp;动态链接库支持<br>
                    <FONT color=#666666>&nbsp;enable_dl</FONT> </TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$obj[5]?></TD>
              </TR>
            </TBODY>
        </TABLE>
		</TD>
      </TR>
      <TR>
        <TD class=tr1 height=5></TD>
      </TR>
    </TBODY>
  </TABLE>
  <br>
  <TABLE class=tbl1 cellSpacing=1 cellPadding=3 width=750 border=0 >
    <TBODY align="left">
      <TR>
        <TD class=tr1>
          <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
            <TBODY>
              <TR>
                <TD><FONT class="font1">■其他组件信息:::...</FONT></TD>
              </TR>
            </TBODY>
        </TABLE></TD>
      </TR>
      <TR>
        <TD bgColor=#f8f9fc>
          <TABLE class=tbl1o1 cellSpacing=1 cellPadding=3 width="100%" border=0>
            <TBODY>
              <TR>
                <TD class=td1 width=130>&nbsp;组件名称</TD>
                <TD class=td1>&nbsp;支持情况</TD>
				<TD class=td1>&nbsp;组件名称</TD>
                <TD class=td1>&nbsp;支持情况</TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;IMAP电子邮件系统</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$qobj[0]?></TD>
                <TD class=td1o1 width=130>&nbsp;历法运算</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$qobj[1]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;压缩文件支持(Zlib)</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$qobj[2]?></TD>
                <TD class=td1o1 width=130>&nbsp;Session支持</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$qobj[3]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;Socket支持</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$qobj[4]?></TD>
                <TD class=td1o1 width=130>&nbsp;PREL相容语法 PCRE</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$qobj[5]?></TD>
              </TR>
			  <TR>
                <TD class=td1o1 width=130>&nbsp;图形处理 GD Library</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$qobj[6]?>
					<? 
					if(function_exists("imageline")==1 && function_exists("gd_info")==1) 
					{$gd=gd_info();echo "<br>&nbsp;&nbsp;版本:".$gd["GD Version"];} 
					?>
				</TD>
                <TD class=td1o1 width=130>&nbsp;FDF表单资料格式</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$qobj[7]?></TD>
              </TR>
			  <TR>
                <TD class=td1o1 width=130>&nbsp;Iconv编码转换</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$qobj[8]?></TD>
                <TD class=td1o1 width=130>&nbsp;SNMP网络管理协议</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$qobj[9]?></TD>
              </TR>
            </TBODY>
        </TABLE>
		</TD>
      </TR>
      <TR>
        <TD class=tr1 height=5></TD>
      </TR>
    </TBODY>
  </TABLE>
  <br>
  <TABLE class=tbl1 cellSpacing=1 cellPadding=3 width=750 border=0 >
    <TBODY align="left">
      <TR>
        <TD class=tr1>
          <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
            <TBODY>
              <TR>
                <TD><FONT class="font1">■数据库支持信息:::...</FONT></TD>
              </TR>
            </TBODY>
        </TABLE></TD>
      </TR>
      <TR>
        <TD bgColor=#f8f9fc>
          <TABLE class=tbl1o1 cellSpacing=1 cellPadding=3 width="100%" border=0>
            <TBODY>
              <TR>
                <TD class=td1 width=130>&nbsp;数据库</TD>
                <TD class=td1>&nbsp;支持情况</TD>
				<TD class=td1>&nbsp;数据库</TD>
                <TD class=td1>&nbsp;支持情况</TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;Mysql数据库</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$sql[0]?></TD>
                <TD class=td1o1 width=130>&nbsp;OBDC数据库</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$sql[1]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;Oracle数据库</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$sql[2]?></TD>
                <TD class=td1o1 width=130>&nbsp;Oracle 8 数据库</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$sql[3]?></TD>
              </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;SQL Server数据库</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$sql[4]?></TD>
                <TD class=td1o1 width=130>&nbsp;mSQL数据库</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$sql[5]?></TD>
              </TR>
			  <TR>
                <TD class=td1o1 width=130>&nbsp;Hyperwave数据库</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$sql[6]?></TD>
                <TD class=td1o1 width=130>&nbsp;dBase数据库</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$sql[7]?></TD>
              </TR>
			  <TR>
                <TD class=td1o1 width=130>&nbsp;PostgreSQL数据库</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$sql[8]?></TD>
                <TD class=td1o1 width=130>&nbsp;filePro数据库</TD>
                <TD class=td1o22 width=240>&nbsp;
                    <?=$sql[9]?></TD>
              </TR>
            </TBODY>
        </TABLE>
		</TD>
      </TR>
      <TR>
        <TD class=tr1 height=5></TD>
      </TR>
    </TBODY>
  </TABLE>
  <br>
  <TABLE class=tbl1 cellSpacing=1 cellPadding=3 width=750 border=0 >
    <TBODY align="left">
      <TR>
        <TD class=tr1>
          <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
            <TBODY>
              <TR>
                <TD><a name="objcheck"></a><FONT class="font1">■组件支持情况检测:::...</FONT></TD>
              </TR>
            </TBODY>
        </TABLE></TD>
      </TR>
      <TR>
        <TD bgColor=#f8f9fc>
          <TABLE class=tbl1o1 cellSpacing=1 cellPadding=3 width="100%" border=0>
            <TBODY>
              <TR>
                <TD class=td1>&nbsp;在下面的输入框中输入你要检测的组件的<a href=# title="?:variables_order:gpc_order:magic_quotes_gpc:asp_tags:session.save_path">ProgId或ClassId</a></TD>
              </TR>
			<FORM action=<?=$_SERVER[PHP_SELF]?>#objcheck method=post id=form1 name=form1>
				<tr height="18">
					<td height=30 class=td1o1>
					&nbsp;<input class=input type=text value="" name="classname" size=40>
					<input name="ft" value="check" type="hidden">
					<INPUT type=submit value=" 确 定 " class=sub id=submit1 name=submit1>
					<INPUT type=reset value=" 重 填 " class=sub id=reset1 name=reset1> 
					</td>
				</tr>
			</FORM>
			</TBODY>
			</TABLE>
			<?if($ft=='check'){ ?>
			<TABLE class=tbl1o1 cellSpacing=1 cellPadding=3 width="100%" border=0>
            <TBODY>
              <TR>
                <TD class=td1 width=130>&nbsp;查 询 参 数 名 称</TD>
                <TD class=td1>&nbsp;详情</TD>
				</TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;<?=$classname?></TD>
                <TD class=td1o22 width=240>&nbsp;请看下面的参数</TD>
                </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;Getenv方式</TD>
                <TD class=td1o22 width=240>&nbsp;<?=getenv("$classname")?></TD>
                </TR>
              <TR>
                <TD class=td1o1 width=130>&nbsp;Get_cfg_var方式</TD>
                <TD class=td1o22 width=240>&nbsp;<?=get_cfg_var("$classname")?></TD>
                </TR>
			  <TR>
                <TD class=td1o1 nowrap>&nbsp;Get_magic_quotes_gpc方式</TD>
                <TD class=td1o22 width=240>&nbsp;<?=get_magic_quotes_gpc("$classname")?></TD>
                </TR>
			  <TR>
                <TD class=td1o1 nowrap>&nbsp;Get_magic_quotes_runtime方式</TD>
                <TD class=td1o22 width=240>&nbsp;<?=get_magic_quotes_runtime("$classname")?></TD>
                </TR>
            </TBODY>
        </TABLE>
	<?;}?>
		</TD>
      </TR>
      <TR>
        <TD class=tr1 height=5></TD>
      </TR>
    </TBODY>
  </TABLE>
  <BR>
  <A name="function"></A>
  <TABLE class=tbl1 cellSpacing=1 cellPadding=3 width=750 border=0 >
    <TBODY align="left">
      <TR>
        <TD class=tr1>
          <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
            <TBODY>
              <TR>
                <TD></a><FONT class="font1">■函数支持情况检测:::...</FONT></TD>
              </TR>
            </TBODY>
        </TABLE></TD>
      </TR>
      <TR>
        <TD bgColor=#f8f9fc>
          <TABLE class=tbl1o1 cellSpacing=1 cellPadding=3 width="100%" border=0>
            <TBODY>
              <TR>
                <TD class=td1>&nbsp;在下面的输入框中输入你要检测是否可用的函数</TD>
              </TR>
			<FORM action=<?=$_SERVER[PHP_SELF]?>#function method=post id=form1 name=form1>
				<tr height="18">
					<td height=30 class=td1o1>
					&nbsp;<input class=input type=text value="" name="fname" size=40>
					<input name="fc" value="check" type="hidden">
					<INPUT type=submit value=" 确 定 " class=sub id=submit1 name=submit1>
					<INPUT type=reset value=" 重 填 " class=sub id=reset1 name=reset1> 
					</td>
				</tr>
				<?php
				if ("check" == $fc)
				 {
					 $ss=temp(function_exists($fname));
					 echo "
					 <tr>
						 <td class=td1o1>您检测的函数是<b> $fname </b>$ss</td>
					 </tr>
					 ";
				 }//END IF 
				?>
			</FORM>
			</TBODY>
			</TABLE>
		</TD>
      </TR>
      <TR>
        <TD class=tr1 height=5></TD>
      </TR>
    </TBODY>
  </TABLE>
  <br>
  <TABLE class=tbl1 cellSpacing=1 cellPadding=3 width=750 border=0 >
    <TBODY align="left">
      <TR>
        <TD class=tr1>
          <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
            <TBODY>
              <TR>
                <TD><FONT class="font1">■服务器性能测试:::...</FONT></TD>
              </TR>
            </TBODY>
        </TABLE></TD>
      </TR>
      <TR>
        <TD bgColor=#f8f9fc>
          <TABLE class=tbl1o1 cellSpacing=1 cellPadding=3 width="100%" border=0>
            <TBODY>
              <TR>
                <TD class=td1>&nbsp;整数运算能力，50万次“1＋1”的计算</TD>
                <TD class=td1 width=240>&nbsp;完成时间</TD>
              </TR>
			  <? for ($i = 0; $i < count($svr); $i++) { ?>			  
              <TR>
                <TD class=td1o1>&nbsp;<?=$svr[$i]?></TD>
                <TD class=td1o22>&nbsp;<?=$svr_atime[$i]?>毫秒</TD>
              </TR>
			 <? } ?>
			  <TR>
                <TD class=td1>&nbsp;浮点运算能力，50万次平方根的计算</TD>
                <TD class=td1 width=240>&nbsp;完成时间</TD>
              </TR>
			  <? for ($i = 0; $i < count($svr); $i++) { ?>
              <TR>
                <TD class=td1o1>&nbsp;<?=$svr[$i]?></TD>
                <TD class=td1o22>&nbsp;<?=$svr_stime[$i]?>毫秒</TD>
              </TR>
			  <? } ?>
            </TBODY>
        </TABLE>
		<TABLE class=tbl1o1 cellSpacing=1 cellPadding=3 width="100%" border=0>
		<tr>
			<td class=td1>
			特别提示:整数运算和浮点运算仅仅代表了服务器的运算能力,
			与你连接这台服务器的速度<font color="#FF0000">无关</font>。
			</td>
		</tr>
		</TABLE>
		</TD>
      </TR>
      <TR>
        <TD class=tr1 height=5></TD>
      </TR>
    </TBODY>
  </TABLE>
  <br>
  <TABLE class=tbl1 cellSpacing=1 cellPadding=3 width=750 border=0 >
    <TBODY align="left">
      <TR>
        <TD class=tr1>
          <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>            
			<TBODY>
              <TR>
                <TD><a name="objcheck"></a><FONT class="font1">■数据库连接测试:::...</FONT></TD>
              </TR>
            </TBODY>
        </TABLE></TD>
      </TR>
      <TR>
        <TD bgColor=#f8f9fc>
          <TABLE class=tbl1o1 cellSpacing=1 cellPadding=3 width="100%" border=0>
            <TBODY>
              <TR>
                <TD class=td1>&nbsp;MySQL数据库连接测试</a></TD>
              </TR>
				<FORM METHOD=POST ACTION="<?=$_SERVER[PHP_SELF]?>#bottom">
				<tr height="18">
					<td height=30 class=td1o1>
						<TABLE width=100%>
						<TR>
							<TD>
							&nbsp;地址: <input class=input type=text value="localhost" name="sql_host" size=10>
							&nbsp;端口: <input class=input type=text value="3306" name="sql_port" size=10>
							&nbsp;帐号: <input class=input type=text name="sql_login" size=10>
							&nbsp;密码: <input class=input type=text name="sql_password" size=10>
							&nbsp;<input name="conn" value="mysql" type="hidden">
						</TD><TD align=right>
							<INPUT type=submit value=" 确 定 " class=sub id=submit1 name=submit1>
							<INPUT type=reset value=" 重 填 " class=sub id=reset1 name=reset1>
						</TD>
						</TR>
						</TABLE>
					</td>
				</tr>
				</FORM>
				<TR>
                <TD class=td1>&nbsp;PostgreSQL数据库连接测试</a></TD>
				</TR>
				<FORM METHOD=POST ACTION="<?=$_SERVER[PHP_SELF]?>#bottom">
				<tr height="18">
					<td height=30 class=td1o1>
						<TABLE width=100%>
						<TR>
							<TD>
							&nbsp;地址: <input class=input type=text value="localhost" name="sql_host" size=10>
							&nbsp;端口: <input class=input type=text value="7890" name="sql_port" size=10>
							&nbsp;帐号: <input class=input type=text name="sql_login" size=10>
							&nbsp;密码: <input class=input type=text name="sql_password" size=10>
							&nbsp;数据库名:<input class=input type=text name="sql_dbname" size=10>
							&nbsp;
							</TD><TD align=right>
							<input name="conn" value="psql" type="hidden">
							<INPUT type=submit value=" 确 定 " class=sub id=submit1 name=submit1>
							<INPUT type=reset value=" 重 填 " class=sub id=reset1 name=reset1>
							</TD>
						</TR>
						</TABLE>
					</td>
				</tr>
				</FORM>
			</TBODY>
		  </TABLE>
		</TD>
      </TR>
      <TR>
        <TD class=tr1 height=5></TD>
      </TR>
    </TBODY>
  </TABLE>
  <BR>
  <TABLE class=tbl1 cellSpacing=1 cellPadding=3 width=750 border=0 >
    <TBODY align="left">
      <TR>
        <TD class=tr1>
          <TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
            <TBODY>
              <TR>
                <TD></a><FONT class="font1">■邮件发送支持情况检测:::...</FONT></TD>
              </TR>
            </TBODY>
        </TABLE></TD>
      </TR>
      <TR>
        <TD bgColor=#f8f9fc>
          <TABLE class=tbl1o1 cellSpacing=1 cellPadding=3 width="100%" border=0>
            <TBODY>
              <TR>
                <TD class=td1>&nbsp;在下面的输入框中输入一个邮件地址</TD>
              </TR>
			<FORM action=<?=$_SERVER[PHP_SELF]?>#bottom method=post id=form1 name=form1>
				<tr height="18">
					<td height=30 class=td1o1>
					<TABLE width=100%>
						<TR>
							<TD>
					&nbsp;<input class=input type=text value="@" name="toemail" size=40>
					</TD><TD align=right>
					<input name="mt" value="check" type="hidden">
					<INPUT type=submit value=" 确 定 " class=sub id=submit1 name=submit1>
					<INPUT type=reset value=" 重 填 " class=sub id=reset1 name=reset1> 
							</TD>
						</TR>
					</TABLE>
					</td>
				</tr>
				<?php
				if ("check" == $mt)
				 {
					 if (1 == function_exists("mail"))
					 {
						 if (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$toemail))
						 {
							 echo_info("请输入正确的E-mail地址！");
						 }//END if
						 else
						 {
							 $message="这是一封测试邮件！由 【废墟のPHP探针 v".$version."】 发出用于测试服务器的mail函数功能。\n欢迎使用废墟のPHP探针，本程序公开源代码，你可以任意复制、传播和使用。\n你可以从我的网站 ( http://wapcity.org.ru/ ), 或其他支持站点下载到本程序。";
							 @mail($toemail, "测试邮件", $message);
							 echo "
								<tr>
								<td class=td1o1>一封测试邮件已经发送到邮箱<b>$toemail</b></td>
								</tr>
								";
						 }
					 }//END IF;
					 else
					 {
						 echo_info("您的服务器不支持MAIL函数！");
					 }
				 }//END IF 
				?>
			</FORM>
			</TBODY>
			</TABLE>
		</TD>
      </TR>
      <TR>
        <TD class=tr1 height=5></TD>
      </TR>
    </TBODY>
  </TABLE>
  <table width=750>
  <tr>
  	<td></td>
  	<td align=right><a name="bottom"></a>
	<a href="<?=$_SERVER[PHP_SELF]?>">刷新 </a><a href="#top">顶部↑ </a> 
	</td>
  </tr>
  </table>
</div>
<center>
<?php
$page_time_end=getmicrotime(); 
$pageTime = round(($page_time_end-$page_time_start)*1000000)/1000;
echo "页面执行时间".$pageTime."毫秒";
?>
<br>
欢迎访问 <a href="http://wapcity.org.ru" target="_blank">http://wapcity.org.ru</a> <br>
本程序由废墟の复甦(<a href="mailto:anerg@183.ha.cn">anerg@183.ha.cn</a>)编写，转载时请保留这些信息
</center>
</body>
</html>