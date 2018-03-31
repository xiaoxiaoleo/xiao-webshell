<?PHP
//配置部分： 
//注意，如果您没有在后面的注释的地方加上管理员身份验证程序，
//请不要配置正确的数据库用户名和密码！
//采用默认配置运行，程序会给出表单你填写的。

$db_host="localhost";    //数据库服务器
$db_username="root";     //数据库用户名
$db_password="";         //数据库密码
$db_dbname="";          //选择的数据库

$_POST["frametopheight"]=90;  //FrameTop 的高

//版本
define("VERSION",3.9);

error_reporting(1);
@set_time_limit(30);

if(!isset($_POST[dosubmit])){
	$_POST["db_host"]=$db_host;
	$_POST["db_username"]=$db_username;
	$_POST["db_password"]=$db_password;
	$_POST["db_dbname"]=$db_dbname;
}

function num_bitunit($num){
  $bitunit=array(' B',' KB',' MB',' GB');
  for($key=0;$key<count($bitunit);$key++){
	if($num>=pow(2,10*$key)-1){ //1023B 会显示为 1KB
	  $num_bitunit_str=(ceil($num/pow(2,10*$key)*100)/100)." $bitunit[$key]";
	}
  }
  return $num_bitunit_str;
}


//frame 分开标题
if(!$_GET["framename"]){
	echo "<html>
	<head> <meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
	<title>faisunSQL自导入数据库备份程序 — Powerd By faisun</title>
	</head>
	<frameset rows='$_POST[frametopheight],*,0' frameborder='NO' border='0' framespacing='0' name='myframeset'>
		<frame src='$_SERVER[PHP_SELF]?action=topframe&framename=topframe' name='topFrame' scrolling='NO' noresize>
		<frame src='$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]&framename=main' name='mainFrame1'>
		<frame src='about:blank' name='mainFrame2'>  
	</frameset>
	<BODY></BODY>
	</html>";
	exit;
}

//css 样式定义
function csssetting(){
  return "<style type='text/css'>
	<!--
	body, td, input, a{
		color:#985b00;
		font-family: '宋体';
		font-size: 9pt;
	}
	body, td, a{
		line-height:180%; 
	}
	.tabletitle{
		color:#FFFFFF;
		background-color:#CC0000;
	}
	.tabledata, input{
		background-color:#FFD800;
	}
	input, .borderdiv {
		border:1px #CC0000 solid;
	}
	-->
	</style>";
}

//输出所有$_POST变量
function echoAllPostValues($var,$subkey=""){
	for(reset($var);list($key,$val)=each($var);){
		$varname=($subkey?"{$subkey}[$key]":"$key");
		if(is_array($val)) echoAllPostValues($val,"$varname");
		else echo "\t<input name=\"$varname\" value=\"".htmlspecialchars(stripslashes("$val"))."\" type=\"hidden\">\n";
	}
}

//各页相同的页面头
function fheader(){
	global $_SERVER,$_POST;
	echo "<html>
	<head> 
	<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
	<title>faisunSQL自导入数据库备份程序 — Powerd By faisun</title>
	".csssetting()."
	</head><body link='#0000FF' vlink='#0000FF' alink='#0000FF' bgcolor='#FFFFFF'>
	<center><script language='Javascript'>document.doshowmywin=1;</script>
	<form name='myform' method='post' action=''>\n";
	echoAllPostValues($_POST);
}

if($_POST["totalsize"]){
	$totalsize_chunk=num_bitunit($_POST["totalsize"]);
}

//各页相同的页面尾
function ffooter(){
	global $_POST;
	echo "<div id='pageendTag'></div>
	</form>
	<font color=red><B>请阅读《<a href='$_SERVER[PHP_SELF]?action=readme' target='_blank'><font color=red>说明文档</font></a>》</B></font><br>
	<br>
	<B>faisunSQL自导入数据库备份程序 V".VERSION."</B><br>
	使用问题或BUG报告请到 <a href='http://www.faisun.com/bbs/' target='_blank'>天窗社区</a> 讨论<br>
	本程序&copy;由 <a href='mailto:faisun@sina.com'>faisun</a> 设计 <a href='http://www.faisun.com' target='_blank'>天窗</a> 提供<br>
	免费程序 欢迎宣传、发布<br>
	</center>
	</body></html>
	<script language='Javascript'>
	function showmywin(){
		if(!document.doshowmywin) return;
		if(top.myframeset&&this.window.name=='mainFrame1'){
			top.myframeset.rows='$_POST[frametopheight],*,0';
		}
		if(top.myframeset&&this.window.name=='mainFrame2'){
			top.myframeset.rows='$_POST[frametopheight],0,*';
		}
	}
	showmywin();
	</script>";
}

//开始说明表格
function tabletext($ttext="",$twidth=400){
	return "<table width='$twidth' border='0' cellspacing='1' cellpadding='3' align=center><tr><td>$ttext</td></tr></table><br>\n";
}

//开始一个表格
function tablestart($ttitle="",$twidth=400){
	return "<table width='1' border='0' cellspacing='0' cellpadding='0' align=center class='tabletitle'>
	<tr><td class='tabletitle'><strong>&nbsp;$ttitle</strong></td></tr> <tr><td>
	<table width='$twidth' border='0' cellspacing='1' cellpadding='2' align=center>";
}

//插入数据到表格
function tabledata($data,$widths=""){
	$pdata=explode("|",$data);
	$pwidths=explode("|",$widths);
	$str="<tr class='tabledata'>\n";
	for(@reset($pdata);@list($key,$val)=@each($pdata);){
		$str.="\t<td style='padding-left:4px' ".(intval($pwidths[$key])?"width='$pwidths[$key]'":"")." nowrap>$pdata[$key]</td>\n";
	}
	$str.="</tr>\n";
	return $str;
}

//结束一个表格
function tableend(){
	return "</table></td></tr></table><BR>\n";
}

//按钮样式
function fbutton($type="submit",$name="Submit",$value="确定",$script=""){
	$imagebg="faisunsql_files/buttonbg.gif";
	$height=17;
	$margin=5;
	$forecolor="#A15309";
	$alphacolor=($forecolor=="#123456"?"#654321":"#123456");
	echo "<label style='background:url($imagebg) 0 0;'><label style='width:$margin'></label>";
	echo "<input type='$type' name='$name' value='$value' style='background:$alphacolor;filter:chroma(color=$alphacolor);color:$forecolor;border:0;height:$height' onfocus='this.blur()' $script></label>";
	echo "<label style='background:url($imagebg) 100% 0;height:$height;width:$margin'></label>\n";
}

//topFrame
if($_GET["action"]=="topframe"&&$_GET["framename"]=="topframe"){
	fheader();
	echo "<center><a href='http://www.faisun.com' target='_blank'><img src='faisunsql_files/faisunsqllogo.gif' border=0 width=300 height=71></a></center>";
	ffooter();
	exit;
}

//说明文档
if($_GET["action"]=="readme"){
	fheader();
	echo tablestart("说明文档");
	echo tabledata(implode('',file("faisunsql_files/readme.htm")));
	echo tableend();
	ffooter();
	exit;
}

/* 
如果您在开头配置部分填写了正确的配置，
您可以在这里加上管理员身份验证，
并把下面声明常量的语句用在代码中：
define("IS_ADMIN","yes");  //用于检验是否加了管理员身份验证代码。
*/

// 配置表单
if(!@mysql_connect($_POST[db_host],$_POST[db_username],$_POST[db_password])||!@mysql_select_db($_POST[db_dbname])){
	fheader();
	if(isset($_POST['finByte']) and isset($_POST['db_dbname'])){
		echo "连接数据库超时,请<a href='javascript:submitme();'>刷新重试</a>.<font id='timeescapepls'>10</font>秒后将自动重试.<BR>也可能是配置不对,请检查您的配置.<BR>";
		echo "
		<script language='JavaScript'>
		document.doshowmywin=0;
		retryTime=10;
		function timeescape(){
			if(!retryTime) return;
			timeescapepls.innerHTML=retryTime--;
		}setInterval('timeescape()',1000);
		function submitme(){
			for(i=myform.elements.length-1;i>=0;i--){if(myform.elements[i].name==\"action\")break;}
			myform.elements[i].value=\"databackup\";
			myform.submit();
		}
		setTimeout('submitme()',retryTime*1000);
		</script>";
	}
	else if(isset($_POST[dosubmit])){
		echo "<script language='JavaScript'>alert('连接数据库错误,请检查您的配置.');</script>";
	}
	echo tabletext("输入正确的配置以连接数据库。<br> 如果无法连接数据库，请联系您的主机管理员以获得正确配置值。");
	echo tablestart("请检查您的配置");
	echo tabledata("服务器主机：|<input name='db_host' value='$_POST[db_host]' type='text'>");
	echo tabledata("要导出的数据库：|<input name='db_dbname' value='$_POST[db_dbname]' type='text'>");
	echo tabledata("数据库用户名：|<input name='db_username' value='$_POST[db_username]' type='text'>");
	echo tabledata("数据库密码：|<input name='db_password' value='$_POST[db_password]' type='password'>");
	echo tableend();
	fbutton('submit','dosubmit','连接');
	fbutton('reset','doreset','重置');
	ffooter();
	exit;
}

if(!defined("IS_ADMIN") and !isset($_POST['db_dbname'])){die("您在程序开头部分填写了正确的配置，但没有加上任何管理员身份验证代码。为了安全，请不要配置正确的数据库用户名和密码！");}

//选择要备份的数据表
if (!isset($_POST['action'])){
	fheader();
	echo tabletext("以下列出的是该数据库中所有的数据表。<br>默认情况下全部导出，您也可以选择只导出其中一部分表。",500);
	echo tablestart("请选择要备份的数据表",500);
	echo tabledata("<strong>表名</strong>|<strong>注释</strong>|<strong>记录数</strong></td>|<strong>大小</strong></td>|<center><strong>反选</strong><input type='checkbox' name='checkbox' value='' onclick='selrev();'></center>","30%|30%|17%|17%|16%");
	$query=mysql_query("SHOW TABLE STATUS");
	while ($currow=mysql_fetch_array($query)){
		echo tabledata("$currow[Name]|$currow[Comment]|$currow[Rows]|".num_bitunit($currow[Data_length])."|<center><input name='table[$currow[Name]]' type='checkbox' value='yes' datalength='$currow[Data_length]' checked onclick='getsize()'></center>");
	}
	echo tabledata("<B>目前选择表的总大小：</B>|&nbsp;|&nbsp;|<input type=hidden name=totalsize value='0'><B><label id='totalsizetxt'></label></B>|<center><B>反选</B><input type='checkbox' name='checkbox' value='' onclick='selrev()'></center>");
	echo tableend();
	echo "<script language='JavaScript'>
	<!--
	  function selrev() {
		with(myform) {
			for(i=0;i<elements.length;i++) {
				thiselm = elements[i];
				if(thiselm.name.match(/table\[\w+\]/))
					thiselm.checked = !thiselm.checked;
			}
		}
		getsize();
	  }
	
	  function num_bitunit(num){
		 bitunit=new Array(' B',' KB',' MB',' GB');
		 for(key=0;key<bitunit.length;key++){
		   if(num>=Math.pow(2,10*key)-1){ //1023B 会显示为 1KB
			  num_bitunit_str=(Math.ceil(num/Math.pow(2,10*key)*100)/100)+' '+bitunit[key];
		   }	 
		 }
		 return num_bitunit_str;
	  }
	
	  function getsize(){
		ts=0;
		with(document.myform) {
			for(i=0;i<elements.length;i++) {
				thiselm = elements[i];
				if(thiselm.datalength&&thiselm.checked)
					ts += parseInt(thiselm.datalength);
			}
		totalsize.value=ts;
	
		totalsizetxt.innerHTML=num_bitunit(ts);
		
		}
	  }
	  getsize();
	-->
	</script>
	<input name='action' type='hidden' id='action' value='selecttype'>";
	fbutton('submit','dosubmit','下一步',"onclick=getsize()");
	fbutton('reset','doreset','重置',"onmouseup=setTimeout('getsize()',100)");
	ffooter();
}

//选择导出方式
if($_POST['action']=="selecttype"){
	fheader();
	intval($_POST["totalsize"])>1024*1024 ? $partsaveck="checked" : $downloadck="checked";
	echo tabletext("选择导出单文件还是多文件：<br>
					数据库太大的话，建议选择多文件导出方式。<br>
					系统会根据所要导出数据量的大小，给出推荐的默认值，<br>
					如果您无法判断您的数据量大小，按默认选定即可。",500);
	echo tablestart("请选择导出方式",500);
	echo tabledata("导出方式：|<br>
					<input name='back_type' value='download' type='radio' $downloadck>生成单个文件并下载 (备份的数据量较大时不建议使用)<br>
					<input name='back_type' value='partsave' type='radio' $partsaveck>分为多个文件并保存在服务器 <br><br>");
	echo tableend();
	echo "
	<script language='JavaScript'>
	function confirmit(){
		with(myform){
			if(back_type[0].checked && ".intval($_POST["totalsize"]).">1024*1024 && !confirm(\"您要导出的数据量比较多（{$totalsize_chunk}），建议选择多文件导出方式。\\n点击“确定”继续导出单文件，“取消”返回更改。\"))
				return false;
		}
		return true;
	}
	myform.onsubmit=new Function('return confirmit();');
	</script>
	<input name='action' type='hidden' id='action' value='selectoption'>";
	fbutton('submit','dosubmit','下一步');
	fbutton('reset','doreset','重置');
	ffooter();
}


if($_POST['action']=="selectoption"){
	if($_POST['back_type']=="partsave"){//多文件保存选项
		fheader();
		echo tabletext("您选择了多文件导出方式，总数据量 $totalsize_chunk 字节。<br><br>
						导出的文件将包括一个主文件和多个数据文件，都放在同一个目录下。<br>
						每个数据文件不宜过大，否则容易造成导出或导入超时；而设置得越小则导出的页数越多。<br>
						导入密码在数据库导入时和HTTP方式下载数据文件时使用，请务必牢记。",500);
		echo tablestart("保存选项：",500);
		echo tabledata("存放目录：|<input name='dir' value='{$_POST[db_dbname]}data' type='text' size=10>|相对本程序所在目录，必须有写入权限");
		echo tabledata("主文件名：|<input name='filename' value='sqlback' type='text' size=10>.php|不含扩展名！");
		echo tabledata("生成文件格式：|<input name='extension' value='php' type='radio' checked>.php <input name='extension' value='zip' type='radio'>.zip <input name='extension' value='gz' type='radio'>.gz |.zip .gz都是压缩文件,占空间少但易出错,<br>且安全性不好,易被别人下载");
		echo tabledata("每个数据文件大小：|<input name='filesize' value='100' type='text' size=10>|单位 KB，1 MB = 1024 KB");
		echo tabledata("导出一页时间间隔：|<input name='nextpgtimeout' value='0' type='text' size=10>|秒，若您的空间不支持频繁提交请设大一点");   
		echo tabledata("数据导入密码：|<input name='back_pass' value='' type='password' size=10>|导入和HTTP下载.php文件时必须输入此密码，");   
		echo tabledata("确认导入密码：|<input name='back_pass2' value='' type='password' size=10>|为了安全请不要设置太简单。");
		echo tableend();
		echo tablestart("导入默认配置（导入时仍可更改）：",500);
		echo tabledata("服务器：|<input name='back_host' value='$_POST[db_host]' type='text'>");
		echo tabledata("数据库：|<input name='back_dbname' value='$_POST[db_dbname]' type='text'>");  
		echo tabledata("该数据库不存在时自动创建：|<input name='back_autocreate' value=' checked ' type='checkbox' checked>");  
		echo tableend(); 
		echo "
		<script language='JavaScript'>
		function confirmit(){
			with(myform){
				if(back_pass.value==''||back_pass.value!=back_pass2.value){
					alert('导入密码不能为空且两次输入密码必须相同。');
					return false;
				}
			}
			return true;
		}
		myform.onsubmit=new Function('return confirmit();');
		</script>
		<input name='action' type='hidden' id='action' value='databackup'>";
		fbutton('submit','dosubmit','下一步');
		fbutton('reset','doreset','重置');
		ffooter();
	}

	if($_POST['back_type']=="download"){//单文件下载选项
		fheader();
		echo tabletext("您选择了单文件导出方式，总数据量 $totalsize_chunk 字节。<br><br>这一步设置数据导入时的默认参数：",500);
		echo tablestart("单文件导出-导入默认配置（导入时仍可更改）：",500);
		echo tabledata("服务器：|<input name='back_host' value='$_POST[db_host]' type='text'>");
		echo tabledata("数据库：|<input name='back_dbname' value='$_POST[db_dbname]' type='text'>");
		echo tabledata("生成文件格式：|<input name='extension' value='php' type='radio' checked>.php <input name='extension' value='zip' type='radio'>.zip <input name='extension' value='gz' type='radio'>.gz");
		echo tabledata("该数据库不存在时自动创建：|<input name='back_autocreate' value=' checked ' type='checkbox' checked>");
		echo tabledata("显示导入过程：|<input name='back_showlog' value=' checked ' type='checkbox'>");
		echo tableend();
		echo "<input name='action' type='hidden' id='action' value='databackup'>";
		fbutton('submit','dosubmit','导出');
		fbutton('reset','doreset','重置');
		ffooter();
	}
}

if($_POST['action']=="databackup"){

	function escape_string($str){
		$str=mysql_escape_string($str);
		$str=str_replace('\\\'','\'\'',$str);
		$str=str_replace("\\\\","\\\\\\\\",$str);
		$str=str_replace('$','\$',$str);
		return $str;
	}

	function sqldumptable($table,$part=0) {
		if($part) global $_POST,$lastcreate_temp,$tableid;
		$dumpstring = "";

		//structure
		if(($tableid==0 and $_POST[page]==1) or $tableid>$lastcreate_temp or $part==0){
			@mysql_query("SET SQL_QUOTE_SHOW_CREATE = 1");
			$query=mysql_query("SHOW CREATE TABLE `$table`");
			$row=mysql_fetch_row($query);
			$dumpstring.="create(\"$table\",\"".str_replace("\n","\\n",str_replace("\"","\\\"",$row[1]))."\");\n\n";
			if($tableid!=0 and $_POST[page]!=1 and $part) $_POST[lastcreate]++;
			$_POST[lastinsert]=0;
			dealdata($dumpstring);
		}
		mysql_free_result($query);

		//data
		$query = mysql_query("SELECT count(*) as count FROM `$table` ");
		$count = mysql_fetch_array($query);
		$query = mysql_query("SELECT * FROM `$table` limit $_POST[lastinsert],$count[count] ");
		$numfields = mysql_num_fields($query);
		while ($row = mysql_fetch_row($query)) {
			$dumpstring = "insert(\"$table\",\"";
			for ($i=0;$i<$numfields;$i++) {
				if (!isset($row[$i]) or is_null($row[$i])) {
					$row[$i] = "NULL";
				}else {
					$row[$i] = '\''.escape_string($row[$i]).'\'';
				}
			}
			$dumpstring .= implode(",",$row);
			$dumpstring .= "\");\n\n";

			if($part){ $_POST[lastinsert]++; }
			dealdata($dumpstring);
		}
		mysql_free_result($query);
	}

	function timeformat($time){
		return substr("0".floor($time/3600),-2).":".substr("0".floor(($time%3600)/60),-2).":".substr("0".floor($time%60),-2);
	}

	if($_POST[back_type]=="partsave"): ////////////////////////   Save Data ////////////////////////////

		if($_POST[extension]=="zip" or $_POST[extension]=="gz"){
			include("faisunsql_files/zipclass.php");
			if(@function_exists('gzcompress')){
				$fsqlzip=new PHPzip;
				$gzfimename="$_POST[dir]/$_POST[filename].$_POST[extension]";
			}
			else{ fheader();echo "<BR><BR><center>压缩文件格式需要系统支持。</center><BR><BR>";ffooter();exit; }
		}

		if(!$_POST[lastcreate]) $_POST[lastcreate]=0;
		if(!$_POST[lastinsert]) $_POST[lastinsert]=0;
		if(!$_POST[page]) $_POST[page]=0;
		$lastcreate_temp=$_POST[lastcreate];
		$tablearr=array();

		for(@reset($_POST[table]);count($_POST[table])&&@list($key,$val)=@each($_POST[table]);) {
			if ($val=="yes") {
				$tablearr[]=$key;
			}
		}

		if(!is_dir("$_POST[dir]") and !@mkdir("$_POST[dir]",0777)){
			fheader();echo "<BR><BR><center>目录'$_POST[dir]'不存在且不能自动创建！请检查目录权限（权限为 777 方可写文件）。</center><BR><BR>";ffooter();exit;
		}

		//是否有多余的文件
		$dfileNo=0;
		$open=opendir($_POST["dir"]);
		$delhtml="";
		while($afilename=readdir($open) and !$_POST[filedeled]){
			$checked="";
			if(preg_match("/^{$_POST[filename]}/ui",$afilename)){
				$checked="checked";
			}if(is_file("$_POST[dir]/$afilename")){
				$delhtml.=tabledata("$afilename|".date("Y-m-d",filectime("$_POST[dir]/$afilename"))."|".num_bitunit(filesize("$_POST[dir]/$afilename"))."|<center><input name='dfile[$dfileNo]' type='checkbox' value='$_POST[dir]/$afilename' $checked></center>");
				$dfileNo++;
			}
		}

		//多余文件处理
		if($dfileNo){
			$_POST[filedeled]=1;
			fheader();
			echo tabletext("'$_POST[dir]/'中以下文件已存在，它们可能被覆盖或成为额外的文件。<br>您可以有选择地删除它们或返回上一步重新设定：",500);
			echo tablestart("选择要删除的文件：",500);
			echo tabledata("<strong>文件名</strong>|<strong>修改日期</strong>|<strong>大小</strong>|<center><strong>反选</strong><input type='checkbox' name='checkbox' value='' onclick='selrev();'></center>","31%|32%|21%|16%");
			echo $delhtml;
			echo tableend();
			echo "
			<script language='JavaScript'>
			function selrev() {
				with(myform) {
					for(i=0;i<elements.length;i++) {
						thiselm = elements[i];
						if(thiselm.name.match(/dfile\[\w+\]/))	thiselm.checked = !thiselm.checked;
					}
				}
			}
			</script>";
			fbutton('submit','dosubmit','删除并继续');
			fbutton('reset','doreset','重置');
			fbutton('button','dogoback','返回修改','onclick=\'history.back();\'');
			ffooter();
			exit;
		}

		//删除多余文件
		if($_POST[filedeled]==1){
			for(@reset($_POST["dfile"]);@list($key,$val)=@each($_POST["dfile"]);){
				if($val) unlink($val);
			}
			unset($_POST["dfile"]);
		}
		$_POST[filedeled]=2;

		//开始导出前的预处理
		if($_POST[page]==0){
			//写入图片
			if(isset($fsqlzip)){
				/* 先写成临时文件 .tmp，全导出后，再改名为正式文件。
				   实际上， PHPzip 类每加入一个文件该压缩文件都是完整的。
				   这里这样做是为了防止浏览器后退引起的加入相同的文件。
				*/
				if(!$fsqlzip->startfile("$gzfimename.tmp")){
					fheader();echo "试图向目录'$_POST[dir]'写入压缩文件时发生错误，请检查目录权限！";ffooter();exit;
				}
				$fsqlzip->addfile(implode('',file("faisunsql_files/faisunsqllogo.gif")),"{$_POST[filename]}_faisunsqllogo.gif","$gzfimename.tmp");
			}else{
				if(!@copy("faisunsql_files/faisunsqllogo.gif","$_POST[dir]/{$_POST[filename]}_faisunsqllogo.gif")){
					fheader();echo "试图向目录'$_POST[dir]'写入LOGO图片时发生错误，请检查目录权限！";ffooter();exit;
				}
			}

			$_POST[page]=1;
			fheader();
			echo tablestart("目录权限正确");
			echo tabledata("<br>经测试，该目录可以写入文件，LOGO图片已成功写入。<br>下面开始导出数据并保存在服务器中。<br><br>");
			echo tableend();
			fbutton('submit','dosubmit','开始自动导出');
			ffooter();
			exit;
		}
		if(isset($fsqlzip)){
			clearstatcache();
			if(!file_exists("$gzfimename.tmp")){
				fheader();echo "导出为压缩文件已完成，若有需要，请重新导出。";ffooter();exit;
			}
		}
		//计算完成量
		$_POST[finByte]=0;
		$query=mysql_query("SHOW TABLE STATUS");
		for($i=0;$i<=$_POST[lastcreate];$i++){
			while($rows=mysql_fetch_array($query)){
				if($rows['Name']==$tablearr[$i]){
					$_POST[finByte]+=$rows['Data_length'];
					break;
				}
			}
		}
		$_POST[finByte]-=($rows['Rows']-$_POST[lastinsert])*$rows['Avg_row_length']; 
		if(!$_POST["StartTime"])$_POST["StartTime"]=time();

		function writefile($data,$method='a'){
			global $_POST,$fsqlzip;
			$file="$_POST[dir]/{$_POST[filename]}_pg{$_POST[page]}.php";
			if(isset($fsqlzip)){
				$fsqlzip->filedata .= $data;
			}else{
				$fp=fopen($file,"$method");
				flock($fp,2);
				fwrite($fp,$data);
			}
		}

		// 开始导出一页
		$data="<?\nif(!defined('VERSION')){echo \"<meta http-equiv=refresh content='0;URL={$_POST[filename]}.php'>\";exit;}\n";
		writefile("$data","w");

		$current_size=0;
		function dealdata($data){
			global $_POST,$current_size,$tablearr,$fsqlzip,$gzfimename;
			$current_size+=strlen($data);
			writefile($data);
			if($current_size>=intval($_POST["filesize"])*1024){
				$current_size=0;
				writefile("\n?".">");

				if(isset($fsqlzip)){
					$fsqlzip->addfile($fsqlzip->filedata,"{$_POST[filename]}_pg{$_POST[page]}.php","$gzfimename.tmp");
				}

				$_POST[page]=intval($_POST[page])+1;

				$finish=intval($_POST[finByte]/$_POST[totalsize]*100);

				fheader();
				echo tablestart("正在从数据库'$_POST[db_dbname]'中导出数据……",500);

				$str1="<br>-= 以下数据表处理完成 =- <div class='borderdiv' style='width:150px;height:100px;overflow:auto;' align=left>";

				for(reset($tablearr);list($key,$val)=each($tablearr);){
					if($key<$_POST[lastcreate]){
						$str1.="√ $val<BR>\n";
					}else if($key==$_POST[lastcreate]){
						$str1.="<a href='#' id='finisheditem'> </a></div>
						<br>-= 以下数据表正待处理 =- <div class='borderdiv' style='width:150px;height:100px;overflow:auto;' align=left>
						<font style='color:#FF0000'>→ $val</font><br>\n";
					}else{
						$str1.="· $val<br>\n";
					}
				}
				$str1.="</div><BR>";

				$str2=tablestart("导出状态",300);
				$str2.=tabledata("共有数据：|".num_bitunit($_POST[totalsize])."","100|200");
				$str2.=tabledata("现已导出：|".num_bitunit($_POST[finByte])."");
				$str2.=tabledata("每页导出：|".num_bitunit(intval($_POST[finByte]/$_POST[page]))."");
				$str2.=tabledata("导出时间间隔：|".floatval($_POST[nextpgtimeout])." 秒");
				$str2.=tabledata("每页生成数据文件|≥ ".num_bitunit($_POST["filesize"]*1024)."");
				$str2.=tabledata("已生成数据文件：|".($_POST[page]-1)." 个");
				$str2.=tabledata("正在自动进入：|<a href='javascript:myform.submit();'>第 $_POST[page] 页</a>");
				$str2.=tabledata("已用时：|".timeformat(time()-$_POST["StartTime"])."");
				$str2.=tabledata("已完成：|{$finish}% ");
				$str2.=tabledata("完成进度：|<table width=100% height=12  border=0 cellspacing=1 cellpadding=0 class='tabletitle' align=center><tr><td width='$finish%'><div></div></td><td width='".(100-$finish)."%'  class='tabledata'><div></div></td></tr></table>");
				$str2.=tableend();
				$str2.="<B><div id='postingTag'></div></B>";
				echo tabledata("$str1|$str2");
				echo tableend();
				ffooter();
				echo "<script language='Javascript'>
				function checkerror(frame){
					if(top.mainFrame1.location.href!=top.mainFrame2.location.href||(frame.document && !frame.document.all.postingTag && frame.document.all.pageendTag)){
						postingTag.innerHTML='faisunSQL:提交出现错误.正在自动<a href=\'javascript:myform.submit();\'>重新提交</a>...';
						myform.submit();
					}
				}
				if(top.myframeset&&this.window.name=='mainFrame1'){
					myform.target='mainFrame2';
					setInterval('checkerror(top.mainFrame2)',10000+1000*".floatval($_POST[nextpgtimeout]).");
				}
				if(top.myframeset&&this.window.name=='mainFrame2'){
					myform.target='mainFrame1';
					setInterval('checkerror(top.mainFrame1)',10000+1000*".floatval($_POST[nextpgtimeout]).");
				}
				setTimeout('myform.submit();',1000*".floatval("$_POST[nextpgtimeout]").");
				finisheditem.focus();
				document.body.onload=new Function('finisheditem.focus();');
				</script>";
				exit();
			}
		}

		//导出所有
		for($i=$_POST[lastcreate];$i<count($tablearr);$i++){
			$tableid=$i;
			sqldumptable($tablearr[$i],1);
		}

		//结束最后文件
		$data="echo '<center><BR><BR><BR><BR>完成。所有数据都已经导入数据库中。</center>'; exit; ?".">";

		writefile("$data");
		if(isset($fsqlzip)){
			$fsqlzip->addfile($fsqlzip->filedata,"{$_POST[filename]}_pg{$_POST[page]}.php","$gzfimename.tmp");
		}

		//引导文件内容
		$data='<?

		$usedumppass=1;  //导入数据时是否使用导入密码。如果您忘记了导入密码，请把值改为 0 。HTTP方式下载数据文件不能取消导入密码。

		define("VERSION",'.VERSION.');
		@set_time_limit(30);

		$md5pass="'.md5($_POST[back_pass]).'";

		if($_GET["action"]=="downphp"){
			if(!file_exists("$_GET[phpfile]")||$_GET["db_pass"]!=$md5pass) exit;
			header("Content-disposition: filename=$_GET[phpfile]");
			header("Content-type: unknown/unknown");
			readfile("$_GET[phpfile]");
			exit;
		}

		$_POST["frametopheight"]='.$_POST["frametopheight"].';
		if(!$_GET["framename"]){
			echo "<html>
			<head><meta http-equiv=\'Content-Type\' content=\'text/html; charset=gb2312\'>
			<title>faisunSQL自导入数据库备份程序 — Powerd By faisun</title>
			</head>
			<frameset rows=\'$_POST[frametopheight],*,0\' frameborder=\'NO\' border=\'0\' framespacing=\'0\' name=\'myframeset\'>
				<frame src=\'$_SERVER[PHP_SELF]?action=topframe&framename=topframe\' name=\'topFrame\' scrolling=\'NO\' noresize>
				<frame src=\'$_SERVER[PHP_SELF]?$_SERVER[QUERY_STRING]&framename=main\' name=\'mainFrame1\'>
				<frame src=\'about:blank\' name=\'mainFrame2\'>  
			</frameset>
			<BODY></BODY>
			</html>";
			exit;
		}
		if($_GET["framename"]=="topframe"&&$_GET["action"]=="topframe"){
			echo "<html><head>
			<title>faisunSQL</title></head><body>
			<center><a href=\'http://www.faisun.com\' target=\'_blank\'><img src=\''.$_POST[filename].'_faisunsqllogo.gif\' border=0 width=300 height=71></a></center>
			</body></html>";exit;
		}
		?'.'><html><head>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<title>faisunSQL 数据库自导入程序 — Powerd By faisun</title>'.csssetting().'</head>
		<body link="#0000FF" vlink="#0000FF" alink="#0000FF">
		<center>
		<font color=red>本文件由 faisun 编写的 <a href="http://www.faisun.com" target="_blank">faisunSQL自导入数据库备份程序 V'.VERSION.'</a> 生成</font><HR size=1>
		<script language="Javascript">
			document.doshowmywin=1;
			function showmywin(){
				if(!document.doshowmywin) return;
				if(top.myframeset&&this.window.name=="mainFrame1"){
					top.myframeset.rows="<?=$_POST[frametopheight];?>,*,0";
				}
				if(top.myframeset&&this.window.name=="mainFrame2"){
					top.myframeset.rows="<?=$_POST[frametopheight];?>,0,*";
				}
			}
			document.body.onload=showmywin;
		</script>
		<?
		$showmywin0=$_POST[loadpage]?"<script language=Javascript>document.doshowmywin=0;</script></body>":"";
		
		if($_GET["action"]=="downall"){
			echo "<form name=\"actionform\" method=\"post\" action=\"\">";
			if($_POST[db_pass]!=$md5pass and ($_POST[db_pass]=md5($_POST[db_pass]))!=$md5pass){
			?'.'>
		　　为了数据的安全,HTTP方式下载数据文件请输入正确的导入密码，导入密码在数据库导出时已创建。<BR>
		　　导入密码：<input name="db_pass" value="" type="password"> <input name="action" type="submit" value=" 确定 ">
			</form>
			<?
			exit;
		}
		if(!empty($_POST["deleteallfiles"])){
			for(reset($_POST["files"]);@list($key,$value)=@each($_POST["files"]);){
				if(@unlink($value)){
					echo "已删除： $value <br>";
				}else{
					echo "<b>删除失败： $value </b><br>";
				}
			}
			echo "<br>完成。";
			exit;
		}
		?'.'>
		以下是所有有关文件,如果您安装了FlashGet等软件,您可以点击右键并选择“Download All by FlashGet”下载。<br>
		下载完后您可以
		<input name="db_pass" value="<?=$_POST[db_pass];?'.'>" type="hidden">
		<input name="deleteallfiles" type="submit" value="删除所有文件" onclick="return confirm(\'删除以下所有备份文件，确定吗？\');">  
		
		<BR><BR>
		<?
		echo "<a href=\"'.$_POST[filename].'.php?action=downphp&phpfile='.$_POST[filename].'.php&db_pass=$_POST[db_pass]\">'.$_POST[filename].'.php</a><BR>
		<a href=\"'.$_POST[filename].'_faisunsqllogo.gif\">'.$_POST[filename].'_faisunsqllogo.gif</a><BR>
		<input type=\"hidden\" name=\"files[-1]\" value=\"'.$_POST[filename].'.php\">
		<input type=\"hidden\" name=\"files[0]\" value=\"'.$_POST[filename].'_faisunsqllogo.gif\">
		";
		$i=1;
		while(file_exists($afile="'.$_POST[filename].'_pg{$i}.php")){
			 echo "<a href=\"'.$_POST[filename].'.php?action=downphp&phpfile=$afile&db_pass=$_POST[db_pass]\">$afile</a><BR>
			 <input type=\"hidden\" name=\"files[$i]\" value=\"$afile\">
			 ";
			 $i++;
		}
		echo "</form></body></html>";
		exit;
		}

		if(!$_POST["action"] and !$_GET["action"]){
		?'.'>
		<form name="configform" method="post" action="">'.
		tablestart('备份信息一览').
		tabledata("共有数据量：|".num_bitunit($_POST[totalsize])."","50%|50%").
		tabledata("共有数据表：|".count($_POST[table])." 个").
		tabledata("每页生成数据文件|≥ ".num_bitunit($_POST["filesize"]*1024)."").
		tabledata("数据文件数：|".$_POST[page]." 页").
		tabledata("文件总数：|".($_POST[page]+2)." 个").
		tabledata("备份时间：|".date("Y-m-d H:i")."").
		tableend().
		tablestart('导入数据库配置').
		tabledata('服务器：|<input name="db_host" value="'.$_POST[back_host].'" type="text">',"50%|50%").
		tabledata('数据库：|<input name="db_dbname" value="'.$_POST[back_dbname].'" type="text">').
		tabledata('该数据库不存在时自动创建|<input name="db_autocreate" value="1" type="checkbox" '.$_POST[back_autocreate].'>').
		tabledata('用户名：|<input name="db_username" value="" type="text">').
		tabledata('密　码：|<input name="db_password" value="" type="password">').
		tabledata('导入一页时间间隔：|<input name="nextpgtimeout" value="'.floatval($_POST[nextpgtimeout]).'" type="text"> 秒').
		tabledata('导入密码：|<input name="db_pass" value="" type="password">').
		tableend().
		'<center><input name="action" type="submit" value=" 导入 "></center>
		</form>
		<center>
		<a href="'.$_POST[filename].'.php?action=downall" target="_blank">点击这里HTTP方式下载所有文件</a>.
		</center>
		<?
		exit;
		}
		if($_POST[usedumppass] and md5($_POST[db_pass])!=$md5pass) die("<div id=pageendTag></div>导入密码不正确！如果您忘记了导入密码，请把本源文件开头的 \$usedumppass 的值改为 0 。 $showmywin0");
		@mysql_connect($_POST[db_host],$_POST[db_username],$_POST[db_password]) or die("<div id=pageendTag></div><BR><BR><center>不能连接服务器或连接超时！请返回检查您的配置。</center> $showmywin0");
		if(!@mysql_select_db($_POST[db_dbname])){
			if(!$_POST[db_autocreate]){echo "<div id=pageendTag></div><BR><BR><center>数据库[{$_POST[db_dbname]}]不存在！请返回检查您的配置。</center> $showmywin0";exit;	}
			if(!mysql_query("CREATE DATABASE `$_POST[db_dbname]`")){echo "<div id=pageendTag></div><BR><BR><center>数据库[{$_POST[db_dbname]}]不存在且自动创建失败！请返回检查您的配置。</center> $showmywin0";exit;}
			mysql_select_db("$_POST[db_dbname]");
		}
		function query($sql){
		  if(!mysql_query($sql)){
			echo "<BR><BR><font color=red>MySQL语句错误！您可能发现了程序的BUG！<a href=\"mailto:faisun@sina.com\">请报告开发者。</a>
				 <BR>版本：V'.VERSION.'<BR>语句：<XMP>$sql</XMP>错误信息： ".mysql_error()." </font>" ;exit;}
		}
		function create($table,$sql){
			query("DROP TABLE IF EXISTS `$table`;");
			query($sql);
		}
		function insert($table,$data){
			query("REPLACE INTO `$table` VALUES ($data);");
		}
		
		$totalpage='.$_POST[page].';
		if(!$_POST[loadpage]){$_POST[loadpage]=1;}
		include("'.$_POST[filename].'_pg$_POST[loadpage].php");
		echo "<center><form name=myform method=\'post\' action=\'\'>";
		$_POST[loadpage]++;
		for(reset($_POST);list($key,$val)=each($_POST);){
			echo "<input name=\"$key\" value=\"".htmlspecialchars(stripslashes($val))."\" type=\"hidden\">\n";
		}
		echo "<BR><BR>正在导入数据到数据库\'$_POST[db_dbname]\'……<BR><BR>本页运行完成！ 正在自动进入<a href=\'javascript:myform.submit();\'>第 $_POST[loadpage] 页</a>，共 $totalpage 页……
		<BR><BR>(除非进程长久不动，否则请不要点击以上页码链接。)";
		?'.'>
		<BR><BR><B><div id="postingTag"></div></B>
		<script language="Javascript">
			function checkerror(frame){
				if(top.mainFrame1.location.href!=top.mainFrame2.location.href||(frame.document && !frame.document.all.postingTag && frame.document.all.pageendTag)){
					postingTag.innerHTML="faisunSQL:提交出现错误.正在自动<a href=\"javascript:myform.submit();\">重新提交</a>...";
					myform.submit();
				}
			}
		
			if(top.myframeset&&this.window.name=="mainFrame1"){
				myform.target="mainFrame2";
				setInterval("checkerror(top.mainFrame2)",10000+1000*<?=floatval($_POST[nextpgtimeout]);?>);
			}
			if(top.myframeset&&this.window.name=="mainFrame2"){
				myform.target="mainFrame1";
				setInterval("checkerror(top.mainFrame1)",10000+1000*<?=floatval($_POST[nextpgtimeout]);?>);
			}
			setTimeout("myform.submit();",1000*<?=floatval("$_POST[nextpgtimeout]");?>);
		</script>
		<div id="pageendTag"></div>
		</form></center>
		</body></html>
		';

		//写入引导文件
		if(isset($fsqlzip)){
			$fsqlzip->addfile($data,"$_POST[filename].php","$gzfimename.tmp");
			rename("$gzfimename.tmp","$gzfimename");
		}else{
			$file="$_POST[dir]/$_POST[filename].php";
			$fp=fopen($file,"w");
			flock($fp,2);
			fwrite($fp,$data);
			fclose($fp);
		}

		//提示导出完成
		fheader();
		if(isset($fsqlzip)){
			echo tabletext("<BR><BR>全部完成，用时 ".timeformat(time()-$_POST["StartTime"])." 。
			<BR><BR>数据库'$_POST[db_dbname]'已全部保存到文件夹'$_POST[dir]'中，共 ".intval($_POST[page])." 页，".(intval($_POST[page])+2)." 个文件。
			<BR><BR>这些文件已压缩为'$gzfimename',此文件格式易被别人下载,最好尽快删除.
			<BR><BR>将此压缩文件解压后,置于服务器可访问目录，并运行'$_POST[filename].php'即可将数据导入。
			<BR><BR>以FTP方式或<a href='$gzfimename' target='_blank'><H3>以HTTP方式下载所有文件</H3></a>
			<BR><BR>",500);
		}else{
			echo tabletext("<BR><BR>全部完成，用时 ".timeformat(time()-$_POST["StartTime"])." 。
			<BR><BR>数据库'$_POST[db_dbname]'已全部保存到文件夹'$_POST[dir]'中，共 ".intval($_POST[page])." 页，".(intval($_POST[page])+2)." 个文件。
			<BR><BR>将此文件夹置于服务器可访问目录，并运行'$_POST[filename].php'即可将数据导入。
			<BR><BR>以FTP方式或<a href='$_POST[dir]/{$_POST[filename]}.php?action=downall' target='_blank'><H3>以HTTP方式下载所有文件</H3></a>
			或在<a href='$_POST[dir]/{$_POST[filename]}.php' target='_blank'><H3>运行备份文件 {$_POST[filename]}.php </H3></a>时也会出现此链接。
			<BR><BR>",500);
		
		}
		echo "<div id='postingTag'></div>";
		ffooter();
		exit;

	elseif($_POST[back_type]=="download"): ////////////////////////   Sent Data ////////////////////////////

		$extension="";
		if($_POST[extension]=="zip" or $_POST[extension]=="gz"){
			if(@function_exists('gzencode')){ $extension=".$_POST[extension]"; }
			else{ fheader();echo "<BR><BR><center>压缩文件格式需要系统支持。</center><BR><BR>";ffooter();exit; }
		}

		$echo_string = '<?
		@set_time_limit(30);
		?'.'>
		<html><head> <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<title>faisunSQL 数据库自导入程序 — Powerd By faisun</title>'.csssetting().'</head>
		<body link="#0000FF" vlink="#0000FF" alink="#0000FF">
		<center>
		<font color=red>本文件由 faisun 编写的 <a href="http://www.faisun.com" target="_blank">faisunSQL自导入数据库备份程序 V'.VERSION.'</a> 生成</font><HR size=1>
		</center>
		<?
		if(!$_POST["action"]){
			?'.'>
			<form name="configform" method="post" action="">'.
			tablestart('备份信息一览').
			tabledata("共有数据量：|".num_bitunit($_POST[totalsize])."").
			tabledata("共有数据表：|".count($_POST[table])." 个").
			tabledata("备份时间：|".date("Y-m-d H:i")."").
			tableend().
			tablestart("导入数据库配置").
			tabledata('服务器：|<input name="db_host" value="'.$_POST[back_host].'" type="text">').
			tabledata('数据库：|<input name="db_dbname" value="'.$_POST[back_dbname].'" type="text">').
			tabledata('该数据库不存在时自动创建：|<input name="db_autocreate" value="1" type="checkbox" '.$_POST[back_autocreate].'>').
			tabledata('显示导入过程：|<input name="back_showlog" value="1" type="checkbox" '.$_POST[back_showlog].'>').
			tabledata('用户名：|<input name="db_username" value="" type="text">').
			tabledata('密　码：|<input name="db_password" value="" type="password">').
			tableend().
			'<center><input name="action" type="submit" value=" 导入 "></center>
			</form></body></html>
			<?
			exit;
		}

		@mysql_connect($_POST[db_host],$_POST[db_username],$_POST[db_password]) or die("<BR><BR><center>不能连接服务器或连接超时！请返回检查您的配置。</center>");
		if(!@mysql_select_db($_POST[db_dbname])){
			if(!$_POST[db_autocreate]){echo "<BR><BR><center>数据库 [{$_POST[db_dbname]}]不存在！请返回检查您的配置。</center>";exit;	}
			if(!mysql_query("CREATE DATABASE `$_POST[db_dbname]`")){echo "<BR><BR><center>数据库[{$_POST[db_dbname]}]不存在且自动创建失败！请返回检查您的配置。</center>";exit;}
			else if($_POST[back_showlog]) echo "<BR><BR>创建数据库 [{$_POST[db_dbname]}]...OK.";
			mysql_select_db("$_POST[db_dbname]");
		}
		function query($sql){
			if(!mysql_query($sql)) echo "<BR><font color=red>MySQL语句错误！您可能发现了程序的BUG！<a href=\"mailto:faisun@sina.com\">请报告开发者。</a>
										 <BR>版本：V'.VERSION.'<BR>语句：<XMP>$sql</XMP><BR>错误信息： ".mysql_error()." </font>" ;
		}
		function create($table,$sql){
			global $_POST,$firstinsert;
			if($_POST[back_showlog]){$firstinsert=1;echo "\n<BR><BR>创建数据表 [$table]...";}
			query("DROP TABLE IF EXISTS `$table`;");
			query($sql);
		}
		function insert($table,$data){
			global $_POST,$firstinsert;
			if($_POST[back_showlog] and $firstinsert){$firstinsert=0; echo "\n<BR>添加数据到数据表 [$table]...";}
			query("INSERT INTO `$table` VALUES ($data);");
		}
		';
		////// 开头部分结束 ////////

		function dealdata($data){
			global $echo_string;
			$echo_string .= "$data";
		}
		for(@reset($_POST[table]);@count($_POST[table])&&@list($key,$val)=@each($_POST[table]);) {
			if ($val=="yes") {
				sqldumptable($key,0);
			}
		}

		$echo_string .= "echo \"<BR><BR>完成。所有数据已成功导入到 [{\$_POST[db_dbname]}]。\"; ?"."></body></html>";

		if($extension){ $echo_string = gzencode($echo_string); }

		header("Content-disposition: filename=$_POST[db_dbname](".date("Ymj",time()).")_faisunsql.php{$extension}");
		header("Content-type: unknown/unknown");
		echo $echo_string;

		exit;
	endif;
}
?>