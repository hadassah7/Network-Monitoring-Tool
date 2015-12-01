<?php

             
       include "credentials.php";
       $path = dirname(__FILE__);
       //connection to the database

       $db = mysql_connect("$host:$port",$user,$pwd)
       or die("Unable to connect to MySQL");
       
      //select a database to work with

      $s = mysql_select_db($database,$db)
      or die("Could not select database");

     //query
      $result = mysql_query('SELECT *FROM DEVICES',$db);
      $q1 = mysql_query('SELECT *FROM Interfaces',$db);
      $details = array();
     //fetch tha data from the database

     while ($row = mysql_fetch_array($q1))
        {
          $IP = $row['IP']; $PORT = $row['PORT']; $COMMUNITY = $row['COMMUNITY'];
          $list = "$COMMUNITY:$IP:$PORT";
          array_push($details,$list);
        }

     while ( $hyphen = mysql_fetch_array($result))
        {
            $IP = $hyphen['IP']; $PORT = $hyphen['PORT']; $COMMUNITY = $hyphen['COMMUNITY'];
            $dev = "$COMMUNITY:$IP:$PORT";
            if( in_array("$dev",$details))
             {
                echo "Device present\n";
             }
            else
             {
                $ifn = snmpwalk ("$IP:$PORT","$COMMUNITY",'1.3.6.1.2.1.2.2.1.1',100000,5);
                $n = array();
             
                foreach($ifn as $x)
                 {
                    $in = explode(' ',$x);
                    $first = snmpget("$IP:$PORT","$COMMUNITY","1.3.6.1.2.1.2.2.1.8.$in[1]",100000,5);
                    $i1 = explode(' ',$first);
                    $second = snmpget("$IP:$PORT","$COMMUNITY","1.3.6.1.2.1.2.2.1.5.$in[1]",100000,5);
 		    $i2 = explode(' ',$second);
                    $third = snmpget("$IP:$PORT","$COMMUNITY","1.3.6.1.2.1.2.2.1.3.$in[1]",100000,5);
 		    $i3 = explode(' ',$third);

                    if($i1[1]==1 && $i2[1]!=0 && $i3[1]!=24 && $i3[1]!=53)
                     {
                        array_push($n,"$in[1]");
                     }                 
                 } 
               $intlist = implode ('-',$n);
               mysql_query("INSERT INTO `Interfaces` (IP,PORT,COMMUNITY,Interfaces) VALUES ('$IP','$PORT','$COMMUNITY','$intlist')");
                    
             }
        }
       exec ("perl $path/bitrate.pl");
       
?>
