<?
//下载文件
$fdownload=$_GET['fdownload'];
if ($fdownload <> "" ){
// path & file name
$path_parts = pathinfo("$fdownload");
$entrypath=$path_parts["basename"];
$name = "$fdownload";
$fp = fopen($name, 'rb');
header("Content-Disposition: attachment; filename=$entrypath");
header("Content-Length: " . filesize($name));
fpassthru($fp);
exit;
}
?>