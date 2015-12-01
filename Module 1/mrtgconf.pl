#! /usr/local/bin/perl

use DBI;
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
close (FILE);

$dbh = DBI -> connect ("dbi:mysql:$db","$usr","$pwd")
                           or die "connection error";
         $sql = "SELECT *FROM DEVICES";
         $sth = $dbh -> prepare($sql);
         $sth -> execute
                 or die "SQL Error";

         #-------fetching data from database-----

        while ( @row = $sth -> fetchrow_array )
        {
           $IP = $row[1];
           $PORT = $row[2];
           $COMMUNITY = $row[3];
           
         #-------creating a string-----
         $string = $COMMUNITY . "@" . "$IP:$PORT";
         print "$string\n";
         push (@data,$string);             
        }
        $devices = join(" ",@data);
        print "$devices\n";
        
        #---------making changes in apache2.conf----
        
        $find = "<Directory \"/var/www/mrtg/\">";
        $r = find("/etc/apache2/apache2.conf",$find);

        sub find {
             ($name,$find)=@_;
             open (READ, "<$name");
             while(<READ>)
              { 
                 if ($_ eq $find){
                   $n =1;
                    }
                 else{
                   $n = 10;
                       }
              }
        if ($n != 1){
             open (APPEND, ">>$file");
             print (APPEND " Alias /mrtg ");
             print (APPEND "/var/www/mrtg/\n");
             print (APPEND "<Directory ");
             print (APPEND "var/www/mrtg/>\n");
             print (APPEND "Options None\n");
             print (APPEND "Allowoverride None\n");
             print (APPEND "Require all granted\n");
             print (APPEND "<Directory>");
                 }
            close (APPEND);

     system "sudo service apache2 restart";
     system "sudo mkdir /var/www/mrtg";
     system "sudo mkdir /etc/mrtg";
     system "sudo cfgmaker --output=/etc/mrtg/mrtg.cfg $devices --global \" RunAsDaemon: Yes\" --global \" Interval: 5\" --global \"Options[_]:growright\"";
     system "rm /var/www/mrtg/*";
     system "sudo indexmaker --output=/var/www/mrtg/index.html /etc/mrtg/mrtg.cfg";
     system "sudo env LANG=C /usr/bin/mrtg /etc/mrtg/mrtg.cfg --logging /var/log/mrtg.log";
           }
        
        
