<html>
        <head>
            <meta http-equiv="refresh" content="240" />
            <title> ANM </title>                                
         
        </head>
        
        <body>
        <div class ="main">
        <table style = "width:1300px;" cell spacing = "0" cell padding = "0">
        <tr><td colspan ="5" style="background-color:#CEF6D8;">        
        <h1><center> Monitoring Metrics </center></h1>
        <h3><center> Step-1 Select the Network Devices and Servers</center></h3>
        </td></tr>      
         
        <tr>
        <td colspan = "1">
        <a href='index.php'>HOME</td> 
            	    
            	    
            	   
            	    	
        <td style="height:600px;width:2000px;vertical-align:top;">
        <center><br>
        <form action = "m3n2.php" method = "POST">   
       <?php
       include "credentials.php";
         
         $db = mysql_connect("$host:$port",$user,$pwd)
          or die ("Unable to connect to the Database");
         $connect = (mysql_select_db($database,$db))
          or die ("Database could not be selected");
          
         
          
         $query = mysql_query("SELECT *FROM Network");
         $query1 = mysql_query("SELECT *FROM HTTP");
         echo "<br>Network Devices";
         echo "<table border=2>
                    <tr><td>S.No</td>
                        <td>IP</td>
                        <td>COMMUNITY</td>
                        <td>PORT</td></tr>";
        $i=1;
          while($row = mysql_fetch_array($query)):
          {
            $ID = $row['ID'];$IP = $row['IP'];$PORT = $row['PORT']; $COMMUNITY = $row['COMMUNITY'];
            $device = "$COMMUNITY-$IP-$PORT";
            echo "<tr><td>" . "$i" . "</td><td>" . "$IP" . "</td><td><input type ='checkbox' name='names[]' value=$device>$COMMUNITY" . "</td><td>" . "$PORT" . "</td></tr>";          
            
            $i++;
          }
          endwhile;
          echo "</table>";
          
          echo"<br>Servers";
          echo "<br><table border = 2>
                   <tr><td>S.No</td>
                   <td>IP</td>
                   <td>PORT</td></tr>";

          $j=1;
          while($get = mysql_fetch_array($query1)):
           {
              $IP = $get['IP']; $HTTPPORT = $get['HTTPPORT'];
              $server = "$IP-$HTTPPORT";
              echo "<tr><td>" . "$j" . "</td><td><input type = 'checkbox' name='server[]' value=$server>$IP" . "</td><td>" . "$HTTPPORT";
          $j++;
           }
           endwhile;

           echo "</table></br>";
          mysql_close($db);
                        
       
       ?>
       <input type = "submit" value = "Select interfaces">
       </table>
       </center>
        
        </table>
        </div>
        </body>
</html>        
