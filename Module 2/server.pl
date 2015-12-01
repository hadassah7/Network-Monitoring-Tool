#!/usr/bin/perl

use DBI;
use DBD::mysql;
use Net::SNMP;
use RRD::Simple();

use FindBin qw($Bin);

@t = split('/',$Bin);
pop(@t);
$t = join('/',@t);
         #--------connecting to database-------
open(FILE, "<$t/db.conf");

$name = <FILE>;
@name = split('"',$name);
$name = $name[1];
$port = <FILE>;
@port = split('"',$port);
$port = $port[1];
$db = <FILE>;
@db = split('"',$db);
$db = $db[1];
$usr = <FILE>;
@usr = split('"',$usr);
$usr = $usr[1];
$pwd = <FILE>;
@pwd = split('"',$pwd);
$pwd = $pwd[1];


$dbh = DBI -> connect ("dbi:mysql:$db:$name:$port","$usr","$pwd")
                           or die "connection error";
         $sql = "SELECT *FROM HTTP";
         $sth = $dbh -> prepare($sql);
         $sth -> execute
                 or die "SQL Error";

while(@row = $sth->fetchrow_array){
           $IP = $row[1];
           $HTTPPORT = $row[2];
           @cp=(); @cp1=(); @cp2=(); @cp3=(); @cp4=(); @rs1=(); @rs2=(); $c1; $c2; $c3; $c4; $rs; $bs; $br;            
           print "$IP\n";
                   
           system("curl http://$IP:$HTTPPORT/server-status > $Bin/metrics.txt");
           open(FILE,"<$Bin/metrics.txt");
           while(@lines = <FILE>)
            {
             @cp = split(' ',"$lines[17]");
             @cp1 = split('u',$cp[2]);
             $c1 = $cp1[1];
             print "$c1\n";
             @cp2 = split('s',$cp[3]);
             $c2 = $cp2[1];
             print "$c2\n";
             @cp3 = split('cu',$cp[4]);
             $c3 = $cp3[1];
             print "$c3\n";
             @cp4 = split('cs',$cp[5]);
             $c4 = $cp4[1];
             print "$c4\n";

             $CPU = $c1 + $c2 + $c3 + $c4;
             print "CPU Utilization for $IP-$HTTPPORT is $CPU\n";
 
             @rs1 = split('>',"$lines[18]");
             @rs2 = split(' ',$rs1[1]);
                        $rs = $rs2[0];
             print "Requests/second is $rs\n";

                        if ($rs2[4] eq "B/second")
                         { $bs = $rs2[3]; }
                       elsif ($rs2[4] eq "kB/second")
                         { $bs = $rs2[3]*1024; }
                        elsif ($rs2[4] eq "MB/second")
                         { $bs = $rs2[3]*1024*1024; }
                        elsif ($rs2[4] eq "GB/second")
                         { $bs = $rs2[3]*1024*1024*1024; }
           print "Bytes/second is $bs\n";                        

                       if ($rs2[7] eq "B/request</dt")
                         { $br = $rs2[6];} 
                       elsif ($rs2[7] eq "kB/request</dt")
                         { $br = $rs2[6]*1024;} 
                       elsif ($rs2[7] eq "MB/request</dt")
                         { $br = $rs2[6]*1024*1024;} 
                       elsif ($rs2[7] eq "GB/request</dt")
                         { $br = $rs2[6]*1024*1024*1024;} 
           print "Bytes/request is $br\n";             
                         
            # RRD creation
              if (!-e "$Bin/$IP-$HTTPPORT.rrd")
               {
               my $rrd = RRD::Simple -> new (file => "$Bin/$IP-$HTTPPORT.rrd");
 
                $rrd -> create("$Bin/$IP-$HTTPPORT.rrd",
                CPU => "GAUGE",
                R_S => "GAUGE",
                B_S => "GAUGE",
                B_R => "GAUGE");
               }
            #Updating rrd
               my $rrd = RRD::Simple -> new(file => "$Bin/$IP-$HTTPPORT.rrd");
               $rrd -> update("$Bin/$IP-$HTTPPORT.rrd",
                 CPU => $CPU,
                 R_S => $rs,
                 B_S => $bs,
                 B_R => $br);
              
            }
             
}

