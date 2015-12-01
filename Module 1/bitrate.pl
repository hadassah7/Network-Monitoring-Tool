#! /usr/local/bin/perl

use DBI;
use Net::SNMP;
use RRD::Simple();
use Data::Dumper;
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
close(FILE);
$oidin = '1.3.6.1.2.1.2.2.1.10';
$oidout = '1.3.6.1.2.1.2.2.1.16';

         $dbh = DBI -> connect ("dbi:mysql:$db:$name:$port","$usr","$pwd")
                           or die "connection error";

         $sql = "SELECT *FROM Interfaces";
         $sth = $dbh -> prepare($sql);
         $sth -> execute
                 or die "SQL Error";
@DEVICES = ();
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
   
           @o = qw(); @split = qw();
           for($x=0;$x<@arrinf;$x++){
             $in = "$oidin" . ".$arrinf[$x]";
             #print "$in\n"; 
             $out = "$oidout" . ".$arrinf[$x]";
             push(@o,"$in","$out");
               }
$olen=scalar(@o);
     
if(@o<=$length)
{                      
           $result = $session->get_request(
                       -varbindlist => \@o,
                       -callback => [\&cb,$IP,$PORT,$COMMUNITY,$olen,@o]
                     ); 
}
else
{
	    $length = 40;
	    $st = 0;

	    for ($i=0; $i<scalar(@o)/$length; $i++){

            my $en = ($i == int(scalar(@o)/$length)) ? $#o : $st + $length - 1;
    	    @{$split[$i]} = @o[$st .. $en];
            $st += $length;
	    }

#	    print Dumper (@split);    
 foreach (@split)
 {
           $result = $session->get_request(
                       -varbindlist => \@{$_},
                       -callback => [\&cb,$IP,$PORT,$COMMUNITY,$olen,@{$_}]
                     ); 
 }
}       
            $rrd = RRD::Simple -> new (file => "$Bin/$COMMUNITY" . "_" . "$IP" . "_" . "$PORT.rrd");
            
            if(!-e "$Bin/$COMMUNITY" . "_" . "$IP" . "_" . "$PORT.rrd"){
            
                $rrd -> create("$Bin/$COMMUNITY" . "_" . "$IP" . "_" . "$PORT.rrd",input => "COUNTER",output => "COUNTER");
               
               print "@arrinf\n";                             
               foreach(@arrinf){
               $rrd -> add_source("input$_" => "COUNTER",);
               #print "Data source added input$_\n";
               $rrd -> add_source("output$_"=> "COUNTER",);
               #print "Data source added output$_\n";
               }
            }
push (@DEVICES,"$COMMUNITY" . "_" . "$IP" . "_" . "$PORT");
          }

            snmp_dispatcher();
          
          sub cb
          {
               print "In callback\n";
               ($session,$IP,$PORT,$COMMUNITY,$NumInt,@OID)=@_;
               #print "In session\n";
	if($NumInt==scalar(@OID))
	{	
               @names=(); %values=();
               $inc = 1;
               for($x=0;$x<@OID;$x++){
               #print "$x\n";
               #print "$o[$x]\n";
               @n = split(/\./,$OID[$x]);
               #print "@n\n";
               $in = pop(@n);
               #print "$in\n";
               $y = join('.',@n);
               #print "$y\n";
               if($y eq $oidin){
               $ibr = $session -> var_bind_list->{$OID[$x]};
               #print "Inoctet: $ibr for $IP\n";
               $values{"input" . "$in"} = "$ibr";
               }
               
               if($y eq $oidout){
               $obr = $session -> var_bind_list->{$OID[$x]};
               $values{"output" . "$in"} = "$obr";
               push(@names,"input$in","output$in");
               }
               
              #print "@names\n";
              if (scalar(@OID) == $inc){
              #print "In if loop to update\n";
              $rrd = RRD::Simple -> new (file => "$Bin/$COMMUNITY" . "_" . "$IP" . "_" . "$PORT.rrd");
               $rrd ->update("$Bin/$COMMUNITY" . "_" . "$IP" . "_" . "$PORT.rrd", map{($_ => $values{$_})}@names);
              print "RRD updated for $IP\n";
              }
              $inc++;
           }
	}
	else
	{
	       $ds = "$COMMUNITY" . "_" . "$IP" . "_" . "$PORT"."ds";
	       $val = "$COMMUNITY" . "_" . "$IP" . "_" . "$PORT"."values";
               $inc = 1;
               for($x=0;$x<@OID;$x++){
               @n = split(/\./,$OID[$x]);
               $in = pop(@n);
               $y = join('.',@n);
               if($y eq $oidin){
               $ibr = $session -> var_bind_list->{$OID[$x]};
               $$val{"input" . "$in"} = "$ibr";
               }
               
               if($y eq $oidout){
               $obr = $session -> var_bind_list->{$OID[$x]};
               $$val{"output" . "$in"} = "$obr";
               push(@$ds,"input$in","output$in");
               }
	    }
	         
    }
}

#print Dumper @DEVICES;

foreach $dev(@DEVICES)
{
$d = "$dev"."ds";
$v = "$dev"."values";
if(@$d && %$v)
{
$rrd = RRD::Simple -> new (file => "$Bin/$dev.rrd");
$rrd ->update("$Bin/$dev.rrd", map{($_ => $$v{$_})}@$d);
print "RRD updated for $dev\n";
}
}


