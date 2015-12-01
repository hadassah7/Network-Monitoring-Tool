<html>
        <head>
            <meta http-equiv="refresh" content="240" />
            <title> ANM </title>                                
         
        </head>
        
        <body>
        <div class ="main">
        <table style = "width:1300px;" cell spacing = "0" cell padding = "0">
        <tr><td colspan ="5" style="background-color:#CEF6D8;">        
        <h1><center> Deleting Network Device</center></h1>
        <h2><center> Step -1 Click on the device to be deleted</center></h2>
        </td></tr>      
         
        <tr>
        <td colspan = "1">
        <a href='index.php'>HOME</td> 
            	    
            	    
            	   
            	    	
        <td style="height:600px;width:2000px;vertical-align:top;">
        <center><br>   
       <?php
       include "credentials.php";
       
       $db = mysql_connect("$host:$port",$user,$pwd)
              or die ("Database could not be connected");
             $c = mysql_select_db($database,$db)
              or die ("Database could not be selected");
          
         
          
         $q1 = mysql_query("SELECT *FROM Network");
         echo "<table border=1>
               <tr><td>S.No</td><td>IP</td><td>COMMUNITY</td><td>PORT</td>";
         $i=1;                
         while($row=mysql_fetch_array($q1)):
          {
            $ID = $row['ID']; $IP = $row['IP']; $PORT = $row['PORT']; $COMMUNITY = $row['COMMUNITY'];
            $device = "$COMMUNITY-$IP-$PORT";
            echo "<tr><td>" . $i . "</td><td>" . $row['IP'] . "</td><td>" . "<a href='d3n1.php?ID=$ID&device=$device'>" . $row['COMMUNITY'] . "</td><td>" . $row['PORT'] . "</td></tr>";
           $i++; 
          }
          endwhile;
          echo "</table>";
          mysql_close($db);
       
       ?>
       </center>
        
        </table>
        </div>
        </body>
</html>        
