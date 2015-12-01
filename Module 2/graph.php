<html>
        <head>
            <meta http-equiv="refresh" content="240" />
            <title> ANM </title>                                
         
        </head>
        
        <body>
        <div class ="main">
        <table style = "width:1300px;" cell spacing = "0" cell padding = "0">
        <tr><td colspan ="5" style="background-color:#CEF6D8;">        
        <h1><center> Monitoring Network Devices and Servers </center></h1>
        <h3><center> Step-3 Graphs </center></h3>
        </td></tr>      
         
        <tr>
        <td colspan = "1">
        <a href='index.php'>HOME</td> 
            	    
            	    
            	   
            	    	
        <td style="height:600px;width:2000px;vertical-align:top;">
        <center><br>   
       <?php
    
#------------------------------Graphs for Network Devices-------------------------------- 
      $path = dirname(__FILE__); $time = time();
       
    $devicemetric = $_POST['devicemetric'];
     
       $z = 1;
       if($devicemetric)
        {
         echo "<br>The graph for the selected Network devices<br>";
         $rrdgraph = array("--slope-mode","--start","-1h",
                                           "--end","$time","--vertical-label","Bytes per sec");
         $sd = $_POST['network'];
         foreach ($devicemetric as $nmetric){

 $selint = array(); $totalint = array(); $seldev = array();
         for ($i=1; $i<$sd; $i++)
           {
             $vselint = $_POST["device$i"];
             $vseldev = $_POST["dev$i"];
             $vtotalint = $_POST["interface$i"];
             $ivselint = implode(',',$vselint);
             array_push($selint,$ivselint);
             array_push($totalint,$vtotalint);
             array_push($seldev,$vseldev);
           }
 
           for ($j=0; $j<count($seldev); $j++)
           {
              $defint = explode(',',$selint[$j]);
              $devname = "$seldev[$j]";
              $int = explode('-',$totalint[$j]);   
              $age = array();
	      $aggint = array_diff($int,$defint);
              
              foreach($defint as $sint)
               {
                     $color = str_pad( dechex ( mt_rand(0,0xFFFFFF) ),6,'0',STR_PAD_LEFT);
                     array_push($rrdgraph,"DEF:$nmetric$sint$j=$devname.rrd:$nmetric$sint:AVERAGE",
                                "LINE:$nmetric$sint$j#$color:$nmetric$sint-$devname",
                                "GPRINT:$nmetric$sint$j:LAST:Current $nmetric-$devname = %6.2lf %SBps");
                  $z++; 
               }
              

		$age = array();

                foreach($int as $tint)
                 {
                   if($tint == $int[0])
                    { $ai = "$nmetric" . "$tint" . "$j";}
                  else
                    { $ai = "$nmetric" . "$tint" . "$j" . ",+";}
                  array_push($age,$ai);
                 }
                 $age1 = join(',',$age);
                foreach( $aggint as $b)
                {
                   array_push($rrdgraph,"DEF:$nmetric" . "$b" . "$j=$devname.rrd:$nmetric" . "$b" . ":AVERAGE");
                   
                }
               $color = str_pad( dechex ( mt_rand(0,0xFFFFFF) ),6,'0',STR_PAD_LEFT);
               array_push($rrdgraph,"CDEF:$nmetric-$j=$age1",
                                "LINE:$nmetric-$j#$color:Aggregate $nmetric-$devname");
            $y++; 
                           
           }
}
          $ret= rrd_graph("$path/networkdevice.png",$rrdgraph);
           echo rrd_error();
           echo"<br><img src='view.php?name=networkdevice'/><br>";
 
        }        



#------------------------------Graphs for Servers----------------------------------------
       $path = dirname(__FILE__); $time = time(); 
       $servermetric = $_POST['servermetric'];
       $server = $_POST['server'];
       
       if ($servermetric)
        {
           print "<br>Graph for Selected Servers<br>";
           foreach($servermetric as $smet)
            {
              
               if($smet == "CPU")
                {
                  $namel = "CPU Usage (%)";
                  $nameg = "CPU Percentage";
                }
               elseif($smet == "R_S")
                {
                  $namel = "Requests/second";
                  $nameg = "Req/sec";
                }
               elseif($smet == "B_S")
                {
                  $namel = "Bytes/second";
                  $nameg = "B/sec";
                }
               elseif($smet == "B_R")
                {
                  $namel = "Bytes/request";
                  $nameg = "B/req";
                  
                }
               echo "<br>$name";
               $rrdgraph = array("--slope-mode", "--start","-1h",
                                        "--end","$time","--vertical-label","$namel");
               $an =1;
               foreach($server as $servername)
                {
                  $color = str_pad( dechex ( mt_rand(0,0xFFFFFF) ),6,'0',STR_PAD_LEFT);
                  array_push($rrdgraph,"DEF:$smet$an=$path/$servername.rrd:$smet:AVERAGE",
                                "LINE:$smet$an#$color:$namel-$servername",
				"GPRINT:$smet$an:LAST:Current $nameg = %6.2lf $nameg");
                $an++;
                }
               $ret= rrd_graph("$path/$smet.png",$rrdgraph);
               echo rrd_error();
               echo"<br><img src='view.php?name=$smet'/><br>";
            }
        }    

        
       ?>
       
       </table>
       </center>
        
        </table>
        </div>
        </body>
</html>        
