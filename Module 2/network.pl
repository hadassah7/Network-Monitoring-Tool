#! /usr/local/bin/perl

use DBI;
use Net::SNMP;
use RRD::Simple();
use FindBin qw($Bin);
use Data::Dumper;

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
close(FILE);
$oidin = '1.3.6.1.2.1.2.2.1.10';
$oidout = '1.3.6.1.2.1.2.2.1.16';

         $dbh = DBI -> connect ("dbi:mysql:$db:$name:$port","$usr","$pwd")
                           or die "connection error";

         $sql = "SELECT *FROM Network";
         $sth = $dbh -> prepare($sql);
         $sth -> execute
                 or die "SQL Error";

         #-------fetching data from database-----

        while ( @row = $sth -> fetchrow_array() )
        {
           $IP = $row[1];
           $PORT = $row[2];
           $COMMUNITY = $row[3];
           $inf = $row[4];
           @arrinf = split('-',$inf);
           #print "@arrinf\n";
           $z = "$arrinf[-1]";         
           print "$IP-$PORT-$COMMUNITY\n";
                   
           #----------Creating a session-------
      
          ($session,$error) = Net::SNMP -> session(
                                   -hostname => $IP,
                                   -port => $PORT,
                                   -community => $COMMUNITY,
                                   -timeout => 1,
                                   -retries => 0,
                                   -nonblocking => 0x1,
                                   -maxmsgsize => 65535,
                                   );
          print "session created\n";
          if(!defined($session))
            {
              print "Session not created for $IP \n";
              next;
            }      
   
           @o = qw();
           for($x=0;$x<@arrinf;$x++){
             $in = "$oidin" . ".$arrinf[$x]";
             $out = "$oidout" . ".$arrinf[$x]";
             push(@o,"$in","$out");
               }
           $result = $session->get_request(
                       -varbindlist => \@o,
                       -callback => [\&cb,$IP,$PORT,$COMMUNITY,@o]
                     );        
            $rrd = RRD::Simple -> new (file => "$Bin/$COMMUNITY-$IP-$PORT.rrd");
            
            if(!-e "$Bin/$COMMUNITY-$IP-$PORT.rrd"){
            
                $rrd -> create("$Bin/$COMMUNITY-$IP-$PORT.rrd",input => "COUNTER",output => "COUNTER");
               
               foreach(@arrinf){
               $rrd -> add_source("input$_" => "COUNTER",);
               $rrd -> add_source("output$_"=> "COUNTER",);
               }
            }
          }

            snmp_dispatcher();
          
          sub cb
          {
               print "In callback\n";
               ($session,$IP,$PORT,$COMMUNITY,@o)=@_;
               @names=(); %values=();
               $inc = 1;
               print "$inc\n";
               for($x=0;$x<scalar(@o);$x++){
               @n = split(/\./,$o[$x]);
               $in = pop(@n);
               $y = join('.',@n);
               print "$y\n";
               if($y eq $oidin){
                print "$o[$x]\n";
                $ibr = $session -> var_bind_list->{$o[$x]};
               $values{"input" . "$in"} = "$ibr";
               }
               print "$y\n";
               if($y eq $oidout){
               $obr = $session -> var_bind_list->{$o[$x]};
               $values{"output" . "$in"} = "$obr";
               push(@names,"input$in","output$in");
               }
              if (scalar(@o) == $inc){
              $rrd = RRD::Simple -> new (file => "$Bin/$COMMUNITY-$IP-$PORT.rrd");
               $rrd ->update("$Bin/$COMMUNITY-$IP-$PORT.rrd", map{($_ => $values{$_})}@names);
              print "RRD updated $IP\n";
              }
              $inc++;
           }
          
          }

