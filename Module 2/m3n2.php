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
        <h3><center> Step-2 Select Interfaces and Metrics</center></h3>
        </td></tr>      
         
        <tr>
        <td colspan = "1">
        <a href='index.php'>HOME</td> 
            	    
            	    
            	   
            	    	
        <td style="height:600px;width:2000px;vertical-align:top;">
        <center><br>
        <form action = "graph.php" method = "POST">   
       <?php
       include "credentials.php";
         
         $names = $_POST['names'];
         $server = $_POST['server'];         
         
         if($names){
         $z=1;
         foreach($names as $details)
         {
         $in=array();   
         $db = mysql_connect("$host:$port",$user,$pwd)
          or die ("Unable to connect to the Database");
         $connect = (mysql_select_db($database,$db))
          or die ("Database could not be selected");
           
          $ex = explode('-',$details);
          $COMMUNITY = $ex[0]; $IP = $ex[1]; $PORT = $ex[2];       
         $query = mysql_query("SELECT *FROM Network WHERE COMMUNITY ='$COMMUNITY' AND IP ='$IP' AND PORT = '$PORT'");
         
        
          while($row = mysql_fetch_array($query)):
          {
            $ID = $row['ID'];$IP = $row['IP'];$PORT = $row['PORT']; $COMMUNITY = $row['COMMUNITY']; $Interfaces = $row['Interfaces'];
            
           #echo "$COMMUNITY:$IP:$PORT"; 
            
          }
          endwhile;
          echo "Interfaces for $COMMUNITY are";
          
                  
          $x = explode('-',$Interfaces);
          array_push($in,$COMMUNITY,$IP,$PORT);
          $name = implode('-',$in);
          echo"<table border = 2><tr>";
          for($j=0; $j<count($x); $j++){
               $y = $x[$j];
            ?>
       <td><input type = 'checkbox' name="device<?php echo $z;?>[]" value = "<?php echo $y ;?>"><?php echo $y;?></td>
       <input type="hidden" name="dev<?php echo $z; ?>" value ="<?php echo $name;?>">
       <input type ="hidden" name ="interface<?php echo $z; ?>" value ="<?php echo $Interfaces;?>"> 
          <?php 
         }         
         echo "</table><br>";     
         mysql_close($database);
         $z++;
         }
       ?>
       <input type = 'hidden' name = 'network' value ="<?php echo $z; ?>"> 
<?php   
          mysql_close($db);
                        
       echo "<br>Metrics<br>";
       echo "<table border = 2>
              <tr><td><input type = 'checkbox' name = 'devicemetric[]' value = input>Inoctet Bitrate</td>
              <tr><td><input type = 'checkbox' name = 'devicemetric[]' value = output>Outoctet Bitrate</td></table>";

       }

       if($server){
       $serverselect = 1;
       echo "<br><table border = 2>
                 <tr><td Colspan = '2'>IP</td><td Colspan = '2'>HTTPPORT</td></tr>";
      
        foreach($server as $serdet)
        {
          $exp = explode('-',$serdet);
          $IP = $exp[0]; $HTTPPORT = $exp[1];
          $ser = "$IP-$HTTPPORT";       
         echo "<tr><td Colspan = '2'>$IP</td>" . "<td Colspan = '2'>$HTTPPORT</td></tr>";
         echo "<input type = 'hidden' name = 'server[]' value ='$ser'>";
        $serverselect++;
        }
        
       echo "<tr><td><input type = 'checkbox' name = 'servermetric[]' value=CPU>CPU Usage</td> <td><input type = 'checkbox' name = 'servermetric[]' value = R_S>Requests/second </td> <td><input type = 'checkbox' name = 'servermetric[]' value = B_S>Bytes/second </td> <td><input type = 'checkbox' name = 'servermetric[]' value = B_R>Bytes/request</td></tr>";
       echo "</table><br>";
        
       }
       ?>
       <br>
       <input type = "submit" value = "Monitor">
       </table>
       </center>
        
        </table>
        </div>
        </body>
</html>        
