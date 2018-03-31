<?
////////////////////////////////////////////
//如果您看见这句话，说明您现在使用的服务器不支持PHP
////////////////////////////////////////////


//-----------------------------------------------------------------------------
//    C1G的PHP探针V2.0 Build 1201
//-----------------------------------------------------------------------------
//    Copyright(C) Chu Yiguo, C1G Studio, 2003. All rights reserved
//
//    C1G 工作室 www.C1Gstudio.com    技术支持 www.C1Gstudio.com
//-----------------------------------------------------------------------------
//    版权说明：
//    本程序为免费软件，你可以复制、传播和使用。
//    使用者须保留版权说明和著作权申明，不得刪除。
//-----------------------------------------------------------------------------
//    本程序使用方法：
//    首先你可以把下面的两个变量修改成你自已的，然后上传至服务器并且修改属性为755,
//    最后在浏览器中输入本文件地址就可以了。
//-----------------------------------------------------------------------------


// =================== 以下变量为用户选项,请更据你的具体情况设置 ====================

	$admessage = "这个探针是用来演示的<br>".
			   "<a href=http://www.cn-idc.com/down target=_blank>".
			   "点此下载PHP探针</a>";
// 如果这个探针你是用来演示的，你可以在上面变量中输入相关信息(会显示在页面底部,支持html)

	$defstyle = "sim"; 
// 上面的变量为设置默认的风格(sim=[灰色天空],yel=[粉色情人],sum=[清爽夏日])

// ============================================================================


error_reporting(E_CORE_ERROR);
set_time_limit(0);
header("Content-Type: text/html; charset=gb2312");

$mtime = explode(" ", microtime());
$starttime = $mtime[1] + $mtime[0];

if(!get_cfg_var("register_globals")){
	foreach($HTTP_GET_VARS as $key => $val){
		$$key = $val;
	}
	foreach($HTTP_POST_VARS as $key => $val){
		$$key = $val;
	}
}

if(!$style)$style = $defstyle; 

$PHP_SELF = $HTTP_SERVER_VARS[PHP_SELF] ? $HTTP_SERVER_VARS[PHP_SELF] : $HTTP_SERVER_VARS[SCRIPT_NAME];

$phpos = PHP_OS;
if($phpos=="BSD" || $phpos=="FreeBSD" || $phpos=="Linux" ||$phpos=="NetBSD" || $phpos=="OpenBSD" || $phpos=="Darwin"){
	$osinfo = uptime();
}else{
	$osinfo = "对不起".$phpos."系统不支持";
}

if(get_cfg_var("safemode")){
	$safemode = "是";
}else {
	$safemode = "否";
}

if (get_cfg_var("file_uploads") == "1"){
	$upsize = get_cfg_var("upload_max_filesize");
}else {
	$upsize = "不允许上传";
}

if (isset($_SERVER["SERVER_ADMIN"])){
	$adminmail = "<a href=\"mailto:".$_SERVER[SERVER_ADMIN]."\" title=发送邮件>".$_SERVER[SERVER_ADMIN]."</a>";
}else{
	$adminmail = "<a href=\"mailto:".get_cfg_var(sendmail_from)."\" title=发送邮件>".get_cfg_var(sendmail_from)."</a>";
}

$dis_func = get_cfg_var("disable_functions");
if ($dis_func == ""){
	$dis_func = "<font color=red><b>×</b></font>";
}else {
	$dis_func = str_replace(" ","<br>",$dis_func);
	$dis_func = str_replace(",","<br>",$dis_func);
}

if(ereg("phpinfo",$dis_func)){
	$phpinfo = "<font color=red><b>×</b><s>PHPINFO</s></font>";
}else{
	$phpinfo = "<font color=green><b>√</b></font><a href=$PHP_SELF?style=$style&testinfo=phpinfo#bottom title=点此查看PHPINFO细信息>PHPINFO</a>";
}


// -----------------------------------------------------------
function find_program ($program)
{
    $path = array('/bin', '/sbin', '/usr/bin', '/usr/sbin', '/usr/local/bin', '/usr/local/sbin');
    while ($this_path = current($path)) {
        if (is_executable("$this_path/$program")) {
        return "$this_path/$program";
    }
    next($path);
    }
    return;
}

function execute_program ($program, $args = '')
{
    $buffer = '';
    $program = find_program($program);

    if (!$program) { return; }

    // see if we've gotten a |, if we have we need to do patch checking on the cmd
    if ($args) {
        $args_list = split(' ', $args);
        for ($i = 0; $i < count($args_list); $i++) {
            if ($args_list[$i] == '|') {
                $cmd = $args_list[$i+1];
                $new_cmd = find_program($cmd);
                $args = ereg_replace("\| $cmd", "| $new_cmd", $args);
            }
        }
    }
}
	    function grab_key ($key)
    {
        return execute_program('sysctl', "-n $key");
    }

	   function get_sys_ticks ()
    {
        $s = explode(' ', grab_key('kern.boottime'));
        $a = ereg_replace('{ ', '', $s[3]);
        $sys_ticks = time() - $a;
        return $sys_ticks;
    }
	    function uptime ()
    {
        if(PHP_OS=="Linux"){
		$fd = fopen('/proc/uptime', 'r');
        $ar_buf = split(' ', fgets($fd, 4096));
        fclose($fd);

        $sys_ticks = trim($ar_buf[0]);
		}else{
		$sys_ticks = get_sys_ticks();
		}

        $min   = $sys_ticks / 60;
        $hours = $min / 60;
        $days  = floor($hours / 24);
        $hours = floor($hours - ($days * 24));
        $min   = floor($min - ($days * 60 * 24) - ($hours * 60));

        if ($days != 0) {
            $result = "".$days."日";
        }

        if ($hours != 0) {
            $result .= "".$hours."小时";
        }
        $result .= "".$min."分钟";

        return "$result";

    }
// -----------------------------------------------------------
	function gettimeout(){
		GLOBAL $starttime;

		$mtime = explode(" ", microtime());
		$endtime = $mtime[1] + $mtime[0];
		$totaltime = ($endtime - $starttime);
		$totaltime = number_format($totaltime, 7);
		$debuginfo = "Processed in $totaltime second(s)";
		return $debuginfo;
	}


	function issupp($func_name,$func="function_exists")
	{
		if ($func($func_name)){
			$su = "<font color=green><b>√</b></font>";
		}else {
			$su = "<font color=red><b>x</b></font>";
		}
		return $su;
	}
	
	function int_test()
	{		
		$time_start=gettimeofday();
		for($index=0;$index<=3000000;$index++);
		{
			$count=1+1;
		}
		$time_end=gettimeofday();
		$time=($time_end["usec"]-$time_start["usec"])/1000000;
		$time=$time+$time_end["sec"]-$time_start["sec"];
		$time=round($time*1000)/1000;
		return($time);		
	}
	
	function float_test()
	{
		$test=pi();
		$time_start=gettimeofday();
		for($index=0;$index<=3000000;$index++);
		{
			sqrt($test);
		}
		$time_end=gettimeofday();
		$time=($time_end["usec"]-$time_start["usec"])/1000000;
		$time=$time+$time_end["sec"]-$time_start["sec"];
		$time=round($time*1000)/1000;
		return($time);
	}
	
	function io_test()
	{
		global $PHP_SELF;
		$fp=fopen(".$PHP_SELF","r");
		$time_start=gettimeofday();
		for($index=0;$index<10000;$index++)
		{
			fread($fp,10240);
			rewind($fp);
		}
		$time_end=gettimeofday();
		fclose($fp);
		$time=($time_end["usec"]-$time_start["usec"])/1000000;
		$time=$time+$time_end["sec"]-$time_start["sec"];
		$time=round($time*1000)/1000;
		return($time);
	}

	if ($test)
	{
		switch($test)
		{
			case "int":
				$vint	= int_test();
				break;
			case "float":
				$vfloat	= float_test();
				break;
			case "io":
				$vio	= io_test();
				break;
		}
	}

	function te_val($val){
			if($val){
				if($val == '0'){
					$vale = "小于0.001秒";
				}else{
					$vale = $val."秒";
				}
			}else{
				$vale = "未测试";
			}
	return $vale;
	}




if($style == "sim"){
	$skin[bdcolor]	= "#ffffff";	// 底色
	$skin[tdfont]	= "#666666";	// 表格里字体颜色
	$skin[tdborder] = "#cccccc";	// 边框颜色
	$skin[tdbg]		= "#fcfcfc";	// 表格里背景色
	$skin[flink]	= "#336699";	// 链接颜色
	$skin[fhove]	= "#b4c8d8";	// 访问时颜色
}elseif($style == "red"){
	$skin[bdcolor]	= "#FFCC99";	// 底色
	$skin[tdfont]	= "#333333";	// 表格里字体颜色
	$skin[tdborder] = "#FF6600";	// 边框颜色
	$skin[tdbg]		= "#FFAC84";	// 表格里背景色
	$skin[flink]	= "#FF3399";	// 链接颜色
	$skin[fhove]	= "#FF9999";	// 访问时颜色
}elseif($style == "blu"){
	$skin[bdcolor]	= "#DAFEEC";	// 底色
	$skin[tdfont]	= "#626262";	// 表格里字体颜色
	$skin[tdborder] = "#009900";	// 边框颜色
	$skin[tdbg]		= "#D1FCF9";	// 表格里背景色
	$skin[flink]	= "#33CC99";	// 链接颜色
	$skin[fhove]	= "#0099FF";	// 访问时颜色
}


$info[0]  = array("服务器时间",date("Y年m月d日 h:i:s",time()));
$info[1]  = array("服务器域名","<a href=\"http://$_SERVER[SERVER_NAME]\"  title=访问此域名 target=_blank>$_SERVER[SERVER_NAME]</a>");
$info[2]  = array("服务器IP地址",gethostbyname($_SERVER["SERVER_NAME"]));
$info[3]  = array("服务器操作系统",PHP_OS);
$info[4]  = array("服务器运行时间",$osinfo);
$info[5]  = array("服务器操作系统文字编码",$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
$info[6]  = array("服务器解译引擎",$_SERVER["SERVER_SOFTWARE"]);
$info[7]  = array("Web服务端口",$_SERVER["SERVER_PORT"]);
$info[8]  = array("PHP运行方式",strtoupper(php_sapi_name()));
$info[9]  = array("PHP版本",PHP_VERSION);
$info[10] = array("运行于安全模式",$safemode);
$info[11] = array("服务器管理员",$adminmail);
$info[12] = array("本文件路径",$_SERVER["PATH_TRANSLATED"]);

$info[13] = array("允许使用URL打开文件allow_url_fopen",issupp("allow_url_fopen","get_cfg_var"));
$info[14] = array("允许动态加载链接库enable_dl",issupp("enable_dl","get_cfg_var"));
$info[15] = array("显示错误信息display_errors",issupp("display_errors","get_cfg_var"));
$info[16] = array("自动定义全局变量register_globals",issupp("register_globals","get_cfg_var"));
$info[17] = array("程序最多允许使用内存量memory_limit",get_cfg_var("memory_limit"));
$info[18] = array("POST最大字节数post_max_size",get_cfg_var("post_max_size"));
$info[19] = array("允许最大上传文件upload_max_filesize",$upsize);
$info[20] = array("程序最长运行时间max_execution_time",get_cfg_var("max_execution_time")."秒");
$info[21] = array("被禁用的函数disable_functions",$dis_func);
$info[22] = array("PHP信息PHPINFO",$phpinfo);
$info[23] = array("目前还有空余空间diskfreespace",intval(diskfreespace(".") / (1024 * 1024)).'Mb');

$info[24] = array("拼写检查 ASpell Library",issupp("aspell_new"));
$info[25] = array("高精度数学运算 BCMath",issupp("bcadd"));
$info[26] = array("历法运算 Calendar",issupp("JDToGregorian"));
$info[27] = array("DBA数据库",issupp("dba_close"));
$info[28] = array("dBase数据库",issupp("dbase_close"));
$info[29] = array("DBM数据库",issupp("dbmclose"));
$info[30] = array("FDF表单资料格式 Forms Data Format",issupp("FDF_close"));
$info[31] = array("FilePro数据库",issupp("filepro"));
$info[32] = array("Hyperwave数据库",issupp("hw_close"));
$info[33] = array("图形处理 GD Library",issupp("imageline"));
$info[34] = array("IMAP电子邮件系统",issupp("imap_close"));
$info[35] = array("Informix数据库",issupp("ifx_close"));
$info[36] = array("InterBase数据库",issupp("ibase_close"));
$info[37] = array("LDAP目录协议",issupp("ldap_close"));
$info[38] = array("MCrypt加密处理",issupp("mcrypt_cbc"));
$info[39] = array("哈稀计算 MHash",issupp("mhash"));
$info[40] = array("mSQL数据库",issupp("msql_close"));
$info[41] = array("SQL Server数据库",issupp("mssql_close"));
$info[42] = array("MySQL数据库",issupp("mysql_close"));
$info[43] = array("SyBase数据库",issupp("sybase_close"));
$info[44] = array("Yellow Page系统",issupp("yp_match"));
$info[45] = array("Oracle数据库",issupp("ora_close"));
$info[46] = array("Oracle 8 数据库",issupp("OCILogOff"));
$info[47] = array("PREL相容语法 PCRE",issupp("preg_match"));
$info[48] = array("PDF文档支持",issupp("pdf_close"));
$info[49] = array("Postgre SQL数据库",issupp("pg_close"));
$info[50] = array("SNMP网络管理协议",issupp("snmpget"));
$info[51] = array("VMailMgr邮件处理",issupp("vm_adduser"));
$info[52] = array("WDDX支持(Web Distributed Data Exchange)",issupp("wddx_add_vars"));
$info[53] = array("压缩文件支持(Zlib)",issupp("gzclose"));
$info[54] = array("XML解析",issupp("xml_set_object"));
$info[55] = array("FTP",issupp("ftp_login"));
$info[56] = array("ODBC数据库连接",issupp("odbc_close"));
$info[57] = array("Session支持",issupp("session_start"));
$info[58] = array("Socket支持",issupp("fsockopen"));

?>
<!--┌─────────────────── C1G的PHP探针 ──────────────────────┐-->
<html>
<head>
<META NAME="author" CONTENT="www.c1gstudio.com"> 
<META NAME="DESCRIPTION" CONTENT="C1G的PHP探针"> 
<META NAME="Keywords" CONTENT="C1G,电影,设计,包包,php,mysql,图片,FLASH,music,mp3,音乐,在线,下载,软件,代码,程式,开发,工作室,studio,网站,主页">
<title>&nbsp;Explorer Internet Microsoft -/C1G的PHP探针\</title>
<style type="text/css">
 td		{font-size:8pt; color: <?=$skin[tdfont]?>;font-family:Verdana}
 INPUT		{BORDER-RIGHT: <?=$skin[tdborder]?> 1px solid; BORDER-TOP: <?=$skin[tdborder]?> 1px solid; BORDER-LEFT: <?=$skin[tdborder]?> 1px solid; COLOR: <?=$skin[tdfont]?>; BORDER-BOTTOM: <?=$skin[tdborder]?> 1px solid; BACKGROUND-COLOR: <?=$skin[bdcolor]?>} 
 BODY		{font-size:8pt; color: <?=$skin[tdfont]?>;font-family:Verdana; SCROLLBAR-FACE-COLOR: #ffffff; background color:<?=$skin[bdcolor]?>;cursor:SCROLLBAR-HIGHLIGHT-COLOR: #ffffff; SCROLLBAR-SHADOW-COLOR: #aaaaaa; SCROLLBAR-3DLIGHT-COLOR: #aaaaaa; SCROLLBAR-ARROW-COLOR: #dddddd; SCROLLBAR-TRACK-COLOR: #ffffff; SCROLLBAR-DARKSHADOW-COLOR: #ffffff }
 a:link		{text-decoration:none; color:<?=$skin[flink]?>} 
 a:visited	{text-decoration:none; color:<?=$skin[flink]?>} 
 a:active	{text-decoration:none; color:<?=$skin[flink]?>} 
 a:hover	{COLOR: <?=$skin[fhove]?>; }
 .tb		{BORDER-RIGHT: <?=$skin[tdborder]?> 1px solid; BORDER-TOP: <?=$skin[tdborder]?> 1px solid; BORDER-LEFT: <?=$skin[tdborder]?> 1px solid; BORDER-BOTTOM: <?=$skin[tdborder]?> 1px solid;background-color:<?=$skin[tdborder]?>}
 .tb0		{BORDER-RIGHT: <?=$skin[tdborder]?> 1px solid; BORDER-TOP: <?=$skin[tdborder]?> 1px solid; BORDER-LEFT: <?=$skin[tdborder]?> 1px solid; BORDER-BOTTOM: <?=$skin[tdborder]?> 1px solid;background-color:<?=$skin[tdbg]?>}
 .tb1		{background-color:<?=$skin[bdcolor]?>}
 </style>
</head>

<body topmargin=5 leftmargin=5>
<a name="top"></a>
<center>

<table width="700" height="10" border="0" cellpadding="0" cellspacing="1" >
<tr class=tb><td align=left>
 <table width="100%" height="10" border="0" cellpadding="2" cellspacing="1" bgcolor=<?=$skin[bdcolor]?>>
 <tr><Td>

  <table width="100%" height="10" border="0" cellpadding="2" cellspacing="1" bgcolor=<?=$skin[bdcolor]?>>
  <tr><Td width=230 >
  <div id=gosite style="CURSOR: hand;" onclick="window.open('http://www.c1gstudio.com')">
  <P style="MARGIN-TOP: 0px; FONT-SIZE: 8pt; MARGIN-BOTTOM: -5px">&nbsp;<STRONG>C1G de</STRONG></P><P style="MARGIN-TOP: 0px; MARGIN-BOTTOM: -8px">&nbsp;<STRONG style="FONT-SIZE: 24pt">PHP 探针</STRONG><FONT color=#666666>v2.0</FONT></P>
  </td><td align=right width=10 valign=top>
  <a href="<?=$PHP_SELF?>?style=sim" title="灰白风格"><font color=#cccccc>■</font></a>
  <a href="<?=$PHP_SELF?>?style=red" title="棕色风格"><font color=#FF9933>■</font></a>
  <a href="<?=$PHP_SELF?>?style=blu" title="浅绿风格"><font color=#66FFFF>■</font></a>
  </td><td class=tb0>
  <?=$admessage?>
  </td></tr>
  </table>
 </td></tr>
 <tr><td colspan=2>
  <table width="100%" height="10" border="0" cellpadding="2" cellspacing="1" >
  <tr><td width=40>广告:</td><td ><marquee width="100%" behavior="alternate" scrollamount="3"><a href="http://www.cn-idc.com" target=_blank><u>易联网络300M PHP+Mysql空间240元，稳定高速，7天试用</u></a></marquee>
</td><td width=80 align=right>	
  <a href="<?=$PHP_SELF?>?style=<?=$style?>" title="刷新本页">刷新</a>	
  <a href=#bottom title="前往底部">底部↓</a></td></tr>
  </table>
 </td></tr>
 </table>
</td></tr>
<tr class=tb><td align=left>

 <table width="100%" height="10" border="0" cellpadding="2" cellspacing="1" bgcolor=<?=$skin[tdborder]?>>
 <tr><Td class=tb1>
  <table width="100%" height="10" border="0" cellpadding="0" cellspacing="1" >
  <tr>
  <td width=100><a href=#server>服务器特性</a></td>
  <td width=100><a href=#php>PHP基本特性</a></td>
  <td width=100><a href=#basic>组件支持状况</a></td>
  <td width=100><a href=#define>自定义检测</a></td>
  <td width=100><a href=#power>服务器性能检测</a></td>
  <td width=100><?=$phpinfo?></td>
  </tr>
  </table>
 </td></tr>
 </table>

</td></tr>
<tr><td>
<?
for($a=0;$a<5;$a++){
	if($a == 0){
		$hp = array("server","服务器特性");
	}elseif($a == 1){
		$hp = array("php","PHP基本特性");
	}elseif($a == 2){
		$hp = array("basic","组件支持状况");
	}elseif($a == 3){
		$hp = array("define","自定义检测");
	}elseif($a == 4){
		$hp = array("power"," 服务器性能检测 ");
	}
?>

 <a name="<?=$hp[0]?>"></a>
 <table width="100%" height="10" border="0" cellpadding="0" cellspacing="1" >
 <tr><td>

  <table width="100%" height="10" border="0" cellpadding="4" cellspacing="0" >
   <tr><td class=tb0 width=100 align=center><?=$hp[1]?></td><td></td></tr>
  </table>

 </td></tr>
 <tr><td>

  <table width="100%" height="10" border="0" cellpadding="2" cellspacing="1" bgcolor=<?=$skin[tdborder]?>>
  <tr><Td class=tb1>
   <table width="100%" height="10" border="0" cellpadding="2" cellspacing="1" >
<?
if($a == 0){
	for($i=0;$i<=12;$i++){
		echo "<tr align=\"left\"><td width=\"30%\">".$info[$i][0]."</td><td width=\"70%\">".$info[$i][1]."</td></tr>\n";
	}
}elseif($a == 1){
	for($i=13;$i<=23;$i++){
		echo "<tr align=\"left\"><td width=\"70%\">".$info[$i][0]."</td><td width=\"30%\">".$info[$i][1]."</td></tr>\n";
	}
}elseif($a == 2){
	for($i=24;$i<=58;$i++){
		echo "<tr align=\"left\"><td width=\"70%\">".$info[$i][0]."</td><td width=\"30%\">".$info[$i][1]."</td></tr>\n";
	}

}elseif($a == 3){
?>
   <tr><td>

	<a name="<?=$hp[0]?>"></a>
	<table border=0 width=100% cellspacing=1 cellpadding=1>
	<tr ><td>请在下面的输入框中输入你要检测的参数的<a href=# title="例：variables_order:gpc_order:magic_quotes_gpc:asp_tags:session.save_path">ProgId或ClassId。</a> 
	</td></tr>
	<FORM action="<?=$PHP_SELF?>#define" method="post" name=form1>
	<input name="ft" value="check" type="hidden">
	<input name="style" value="<?=$style?>" type="hidden">
	<tr height=18><td align=center height=30>
	<input class=input type=text value="" name="classname" size=40>
	<INPUT type=submit value="确定" class=backc name=submit1>
	<INPUT type=reset value="重填" class=backc name=reset1> 
	</td></tr>
	</FORM>
	</table>

   </td></tr>
<?if($ft=='check'){?>
   <tr><td>

	<table border=0 width=100% cellspacing=2 cellpadding=1>
	<tr height=18 class=mytr align=center>
	<td width=70%>查 询 参 数 名 称</td>
	<td width=30%>详情</td>
	</tr>
	<TR  align=center height=18>
	<TD align=left>&nbsp;<?=$classname?><font color=#888888>&nbsp;</font></td>
	<td align=center>&nbsp;请看下面的参数</td></TR>
	<TR  align=center height=18><TD align=left>&nbsp;Getenv方式</td><td align=left>&nbsp;<?=getenv("$classname")?></td></TR>
	<TR  align=center height=18><TD align=left>&nbsp;Get_cfg_var方式</td><td align=left>&nbsp;<?=get_cfg_var("$classname")?></td></TR>
	<TR  align=center height=18><TD align=left>&nbsp;Get_magic_quotes_gpc方式</td><td align=left>&nbsp;<?=get_magic_quotes_gpc("$classname")?></td></TR>
	<TR  align=center height=18><TD align=left>&nbsp;Get_magic_quotes_runtime方式</td><td align=left>&nbsp;<?=get_magic_quotes_runtime("$classname")?></td></TR>
	</table>

   </td></tr>
<?
}

}elseif($a == 4){
?>
   <tr><td>
	<a name="<?=$hp[0]?>"></a>

	<table width="100%" border="0" cellspacing="2" cellpadding="1">
	<?
	for($j=0;$j<3;$j++){
		if($j == 0) {
			$do = "int";
			if($vfloat) $otval = "<input type=\"hidden\" name=\"vfloat\" value=\"$vfloat\">\n";
			if($vio) $otval .= "<input type=\"hidden\" name=\"vio\" value=\"$vio\">\n";
			$show = $vint ? "重新测试" : "测试";
			$pval = array("1.782秒","5.603秒","67.371秒","1.456秒",te_val($vint));
			$phead = "整数运算能力测试(1+1运算300万次)";
		 }elseif($j == 1){
			$do = "float";
			$otval = "";
			if($vint) $otval = "<input type=\"hidden\" name=\"vint\" value=\"$vint\">\n";
			if($vio) $otval .= "<input type=\"hidden\" name=\"vio\" value=\"$vio\">\n";
			$show = $vfloat ? "重新测试" : "测试";
			$pval = array("1.821秒","2.618秒","29.44秒","1.291秒",te_val($vfloat));
			$phead = "浮点运算能力测试(开平方300万次)";
		 }elseif($j == 2){
			$do = "io";
			$otval = "";
			if($vfloat) $otval = "<input type=\"hidden\" name=\"vfloat\" value=\"$vfloat\">\n";
			if($vint) $otval .= "<input type=\"hidden\" name=\"vint\" value=\"$vint\">\n";
			$show = $vio ? "重新测试" : "测试";
			$pval = array("0.073秒","0.128秒","0.332秒","0.092秒",te_val($vio));
			$phead = "数据I/O能力测试(读取10K文件10000次)";
		 }
	?>
	<tr class=myhead align="left"> 
	<td colspan="2" ><b><?=$phead?></b></td>
	</tr>
	<tr class=mytr align="left"> 
	<td width="70%" >C1G的电脑(6C/1.4G+128M+Win2000)</td>
	<td width="30%" ><?=$pval[0]?></td>
	</tr>
	<tr class=mytr align="left"> 
	<td width="70%" >zanadoo.com(C1.3G+256M+Linux)(2003/03/15 17:58)</td>
	<td width="30%" ><?=$pval[1]?></td>
	</tr>
	<tr class=mytr align="left"> 
	<td >51.net虎翼网A型(598MHz+SCSI)(2003/03/15 17:28)</td>
	<td ><?=$pval[2]?></td>
	</tr>
	<tr class=mytr align="left"> 
	<td >有个网络风PHP型(2003/03/15 17:36)</td>
	<td ><?=$pval[3]?></td>
	</tr>
	<tr class=mytr align="left">
	<form name="test<?=$j?>" method="post" action="<?=$PHP_SELF?>#power">
	<td>您正在使用的这台服务器 
	<?=$otval?>
	<input name="style" value="<?=$style?>" type="hidden">
	<input type="hidden" name="test" value="<?=$do?>">
	[<a href="javascript:test<?=$j?>.submit()"><?=$show?></a>]
	</td>
	<td ><?=$pval[4]?></td>
	</form>
	</tr>
	<?}?>
	</table>

   </td></tr>
   <?
   }
   ?>
   </table>
  </td></tr>
  </table>
 </td></tr>
 </table>
<?
}
?>
</td></tr>
<tr><td>
 <table width="100%" border="0" cellspacing="1" cellpadding="1">
 <tr>
 <td width=150><P style="MARGIN-TOP: 0px">&nbsp;<FONT style="FONT-SIZE: 7pt" color=#333333><U>Powered by C1G Studio</U></FONT></P></td>
 <td align=center><FONT style="FONT-SIZE: 7pt" color=#333333><?=gettimeout()?></FONT></td>
 <td align=right><a href=#top title="前往顶部">顶部↑</a></td>
 </tr>
 </table>
</td></tr>
</table>
</center>

<a name="bottom"></a>
</body>
</html>
<?
if($testinfo)phpinfo();
?>