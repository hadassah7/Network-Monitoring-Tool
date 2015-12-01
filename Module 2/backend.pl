#!/usr/bin/perl

use FindBin qw($Bin);
while(1){
$t1 = time();
do "$Bin/network.pl";
do "$Bin/server.pl";
$t2 = time();
sleep(60 -($t2-$t1));
}
