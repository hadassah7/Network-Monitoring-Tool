#!/usr/bin/perl

use DBI;
use Net::SNMP;
use DBD::mysql;
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


$path = "$Bin/trap.log";
$host = <STDIN>;
chomp($host);
$IP = <STDIN>;
chomp($IP);
 while(<STDIN>){
 chomp($_);
 push(@trap,$_);
  }
  
  $time = localtime();
  
  open(TRAP,">> $path");
  print(TRAP "@trap\n");
  foreach (@trap){
    print (TRAP "$_\n");
    @FQDN = split(' ',$_);
    if ($FQDN[0] eq "iso.3.6.1.4.1.41717.10.1"){
       $Message = $FQDN[1];
       print (TRAP "FQDN is $Message\n");
    }
    elsif ($FQDN[0] eq "iso.3.6.1.4.1.41717.10.2"){
       $Status = $FQDN[1];
       print (TRAP "Status is $Status\n");
    }
      
  }
  
  
  $dbh = DBI -> connect ("dbi:mysql:$db:$name:$port","$usr","$pwd")
                           or die "connection error";
         $sql = "SELECT *FROM `TRAPS` WHERE Message ='$Message'";
         $sth = $dbh -> prepare($sql);
         $sth -> execute
                 or die "SQL Error";
                 
  while(@row = $sth->fetchrow_array){
           $c = "PRESENT";
           $PREVIOUS_S = $row[3];
           $PREVIOUS_T = $row[5];
           $time = time();
       $update = $dbh ->prepare("UPDATE `TRAPS` SET `PREVIOUS_S` = '$PREVIOUS_S',`PREVIOUS_T`='$PREVIOUS_T',`PRESENT_S`='$Status',`PRESENT_T`='$time' WHERE `Message` ='$Message'");
        $update ->execute();
  }
   if(!defined $c){
            $time = time();
            $q = "INSERT INTO `TRAPS` (`Message`,`PRESENT_S`,`PRESENT_T`) VALUES('$Message','$Status','$time')";
         $sth = $dbh -> prepare($q);
         $sth -> execute();
   
   }
   
   if($Status == '3'){
      print (TRAP "Fail Trap\n");
    $dbh = DBI -> connect ("dbi:mysql:$db:$name:$port","$usr","$pwd")
                           or die "connection error";
  
      $l = "SELECT *FROM `Fail`";
         $sth = $dbh -> prepare($l);
         $sth -> execute();
         
         while(@row = $sth->fetchrow_array){
                print (TRAP "FAIL TRAP\n");
                $IP=$row[1];
                $PORT=$row[2];
                $COMMUNITY=$row[3];
                
                ($session,$error) = Net::SNMP-> session(
                                 -hostname => $IP,
                                 -port => $PORT,
                                 -community => $COMMUNITY,);
                                 
$l1 = "SELECT *FROM `TRAPS` WHERE `Message` = '$Message'";
$sth1 = $dbh -> prepare($l1);
$sth1 -> execute();

while(@row1 = $sth1 -> fetchrow_array){
 
    print (TRAP "IN WHILE\n");                                
                @fail = ("1.3.6.1.4.1.41717.20.1",OCTET_STRING,$Message);
                if($row1[5]){
                push(@fail,"1.3.6.1.4.1.41717.20.2",INTEGER,$row1[5]);}
                else{
                push(@fail,"1.3.6.1.4.1.41717.20.2",OCTET_STRING," ");}
                if($row1[2] || $row1[2]==0){
                push(@fail,"1.3.6.1.4.1.41717.20.3",INTEGER,$row1[2]);}
                else{
                push(@fail,"1.3.6.1.4.1.41717.20.3",OCTET_STRING," ");}
                if($row1[4]){
                push(@fail,"1.3.6.1.4.1.41717.20.4",INTEGER,$row1[4]);}
                else{
                push(@fail,"1.3.6.1.4.1.41717.20.4",OCTET_STRING," ");}
}                
                $fail = $session -> trap(
                                          -varbindlist =>\@fail,
                                          -specifictrap => 1,
                                          -enterprise => ".1.3.6.1.4.1.41717.10");                 
                
         }
   }
  
elsif ($Status == '2'){    

     $dbh = DBI -> connect ("dbi:mysql:$db:$name:$port","$usr","$pwd")
                           or die "connection error";
    
     $l = "SELECT *FROM `TRAPS` WHERE `PRESENT_S` = '2'";
     $sth1 = $dbh ->prepare($l);
     $sth1 -> execute();

@device; @danger; 
while (@row = $sth1 -> fetchrow_array){
  
      $Message = $row[1];
      $PREVIOUS_S = $row[2];
      $PREVIOUS_T = $row[4];
      $PRESENT_T = $row[5];

$details = "$Message-$PRESENT_T-$PREVIOUS_S-$PREVIOUS_T";
push (@device,$details);
print (TRAP "@device\n");
}

$count = @device;
$all = join("-",@device);
@alldanger = split("-",$all);
print (TRAP "@alldanger\n");
if ($count > 1) {
print (TRAP "count>1");
$dbh = DBI -> connect ("dbi:mysql:$db:$name:$port","$usr","$pwd")
                           or die "connection error";
$l = "SELECT *FROM `Fail`";
$sth1 = $dbh -> prepare($l);
$sth1 -> execute();

while(@row = $sth1->fetchrow_array){
                print (TRAP "FAIL TRAP\n");
                $IP=$row[1];
                $PORT=$row[2];
                $COMMUNITY=$row[3];
                
                ($session,$error) = Net::SNMP-> session(
                                 -hostname => $IP,
                                 -port => $PORT,
                                 -community => $COMMUNITY,);
  @danger = ();
    for($j=1; $j <= $count*4; $j++){
  
      push (@danger,"1.3.6.1.4.1.41717.30.$j",OCTET_STRING,"$alldanger[$j-1]");
      $j++;
      if ($alldanger[$j-1]){
      push (@danger,"1.3.6.1.4.1.41717.30.$j",INTEGER,"$alldanger[$j-1]");}
      else{
      push (@danger,"1.3.6.1.4.1.41717.30.$j",OCTET_STRING," ");
      }
      $j++;
      if ($alldanger[$j-1] || $alldanger[$j-1] == 0){
      push (@danger,"1.3.6.1.4.1.41717.30.$j",INTEGER,"$alldanger[$j-1]");}
      else{
      push (@danger,"1.3.6.1.4.1.41717.30.$j",OCTET_STRING," ");
      }
      $j++;
      if ($alldanger[$j-1]){
      push (@danger,"1.3.6.1.4.1.41717.30.$j",INTEGER,"$alldanger[$j-1]");}
      else{
      push (@danger,"1.3.6.1.4.1.41717.30.$j",OCTET_STRING," ");}
      }
          }
      }

     $danger = $session -> trap(
                                          -varbindlist =>\@danger,
                                          -specifictrap => 1,
                                          -enterprise => ".1.3.6.1.4.1.41717.10");                 
                        
}


