<!DOCTYPE html>

<html>
        <head>
                        <title> ANM </title>                                
         
        </head>
        
        <body>
        <div class ="main">
        <table style = "width:1300px;" cell spacing = "0" cell padding = "0">
        <tr><td colspan ="5" style="background-color:#CEF6D8;">        
        <h1><center> Assignment 1 </center></h1>
        </td></tr>      
         
        <tr>
        <td colspan = "1" style ="width:250px;vertical-align:top;">
           	
                    
            	    <a href="index.php">HOME</a> 
               	    
            	       	    </td>
            	    	
        <td style="height:600px;width:2000px;vertical-align:top;">
        <center><br>  
        <form action = "g2.php" method = "POST"> 
         <?php
         include "credentials.php";
         
         $db = mysql_connect("$host:$port",$user,$pwd)
          or die ("Unable to connect to the Database");
         $connect = (mysql_select_db($database,$db))
          or die ("Database could not be selected");
          
         $IP = $_GET['IP'];
         $PORT = $_GET['PORT'];
         $COMMUNITY = $_GET['COMMUNITY'];
          
         $query = mysql_query("SELECT *FROM Interfaces WHERE `IP` = '$IP' && `PORT` = '$PORT' && `COMMUNITY` = '$COMMUNITY'");
         echo "<table border=2>
                    <tr><td>IP</td>
                        <td>COMMUNITY</td>
                        <td>PORT</td></tr>";
         
         while($row = mysql_fetch_array($query)):
         {
             $Interfaces = $row[4];
             
             echo "<tr><td>" . "$IP" . "</td><td>" . "$COMMUNITY" . "</td><td>" . "$PORT" . "</td></tr>";
                                     
         }
         endwhile;
         echo "</table>";
                    
           echo "<table>";
         if ($Interfaces){
         echo "<br><br> Select the interface";
         $in = explode("-",$Interfaces);
         echo "<table border = '1'>";
         foreach ($in as $x )
         {
            echo "<tr><td><input type = 'radio' name ='interface' value = $x,$COMMUNITY,$IP,$PORT> $x</td></tr>";
         }         
         echo "</table><br>"; 
         }
 
         else {
          echo "<br>The interfaces are loopback interfaces <br>";
         }     
         mysql_close($database);
         ?>
         <input type="submit" value="View graph">
        </center>
        
        </table>
        </div>
        </body>
</html>        
