<?php
$path = stripslashes($_GET['path']);
$ok = chmod ($path , 0777);
if ($ok == true)
echo CHMOD OK , Permission editable file or directory. Permission to write;
?>