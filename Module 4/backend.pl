#! usr/local/bin/perl

use DBI;
use Net::SNMP;
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

#-------------connecting to database-------

  $dbh = DBI -> connect ("dbi:mysql:$db:$name:$port","$usr","$pwd")
                    or die "connection error";

while(1){
         $t1 = time();
         $sql = "SELECT *FROM DEVICES";
         $sth = $dbh -> prepare($sql);
         $sth -> execute()
         or die "SQL Error";
  $Sys='1.3.6.1.2.1.1.3.0';

#-----------fetching data from database

  while ( @device = $sth -> fetchrow_array)
  {      

         $HOST = $device[1];
         $PORT = $device[2];
         $COMMUNITY = $device[3];
 
         $qsys = "SELECT *FROM `Sysuptime` WHERE `HOST`='$HOST' AND `PORT`='$PORT' AND COMMUNITY='$COMMUNITY'";
         $query = $dbh -> prepare($qsys);
         $query -> execute();      
         $REQUESTS = '0';
         $MISSED = '0';
         $COLOR = '0';
         
         while( @sys = $query -> fetchrow_array)
          {
            $REQUIRED = "$COMMUNITY,PRESENT";
            $Sysuptime = "$sys[4]";
            $REQUESTS = "$sys[6]";
            $MISSED = "$sys[7]";
            $COLOR = "$sys[8]";
            print "Device Present in table $HOST,$PORT,$COMMUNITY\n";
          }
       
          if ( $REQUIRED ne "$COMMUNITY,PRESENT")
          {
            $qinsert = $dbh -> prepare ("INSERT INTO `Sysuptime` (HOST,PORT,COMMUNITY) VALUES ('$HOST', '$PORT', '$COMMUNITY')");
            $qinsert -> execute();               
            print "Device not present and is added $HOST,$PORT,$COMMUNITY\n";
	  }
        
         #----creating a session----

         ($session,$error) = Net::SNMP -> session(
                      -hostname => $HOST,
                      -port => $PORT,
                      -community => $COMMUNITY,
                      -timeout => 1,
                      -retries => 0,
                      -nonblocking => 0x1 );

         if(!defined($session)) 
          {
             print "Session not created for $HOST \n";
             next;
          }
         
         $result = $session->get_request(
                       -varbindlist => [$Sys],
                       -callback => [\&cb,$dbh,$HOST,$PORT,$COMMUNITY,$REQUESTS,$MISSED,$COLOR,$Sysuptime]
                       );
         if(!defined($result))
           {
           print "Failed to queue get request \n";
           }
        }

#------event loop----

   snmp_dispatcher();

#-------subroutine cb----

   sub cb
   {
         #-----Updating sysuptime---
           
           ($session,$dbh,$HOST,$PORT,$COMMUNITY,$REQUESTS,$MISSED,$COLOR,$Sysuptime)=@_;
             
         #-----Updating Time---
     
           ($sec,$min,$hour,$dom,$mon,$year,$dow,$doy,$istdst) = localtime(time);
           $year += 1900;
           $time = localtime;
           $REQUESTS = $REQUESTS +1;     
            
           if (!defined ($session -> var_bind_list))
           {
             $Sysuptime = $Sysuptime;
             $MISSED = $MISSED +1;
             $COLOR = $COLOR +1;
           }
           else
           {
              $Sysuptime = $session -> var_bind_list -> {$Sys};
              $COLOR = 0;
           }
       
           $upd = $dbh -> do ("UPDATE `Sysuptime` SET `PORT`='$PORT',`Sysuptime`='$Sysuptime',`Time`='$time',`SentRequests`='$REQUESTS',`MissedRequests`='$MISSED',`COLOR`='$COLOR' WHERE `HOST`='$HOST' AND `PORT`='$PORT' AND `COMMUNITY`='$COMMUNITY'");
           $upd -> execute();  
   }     
$t2 = time();   
sleep(30-($t2-$t1));
}


























