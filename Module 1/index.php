<html>
        <head>
            <meta http-equiv="refresh" content="240" />
            <title> ANM </title>                                
         
        </head>
        
        <body>
        <div class ="main">
        <table style = "width:1300px;" cell spacing = "0" cell padding = "0">
        <tr><td colspan ="5" style="background-color:#CEF6D8;">        
        <h1><center> Assignment 1 </center></h1>
        </td></tr>      
         
        <tr>
        <td colspan = "5">
         <center>                      	    	
        <?php
        
        include "credentials.php";
        
        $db = mysql_connect("$host:$port",$user,$pwd)
          or die ("Unable to connect to the Database");
         $connect = (mysql_select_db($database,$db))
          or die ("Database could not be selected");
          
         
          
         $query = mysql_query("SELECT *FROM DEVICES");
         echo "<br> Select from the list of devices";
         echo "<br><table border=2>
                    <tr><td>S.No</td>
                        <td>IP</td>
                        <td>COMMUNITY</td>
                        <td>PORT</td></tr>";
        $i=1;
          while($row = mysql_fetch_array($query)):
          {
            $IP = $row['IP'];$PORT = $row['PORT']; $COMMUNITY = $row['COMMUNITY'];
            
            echo "<tr><td>" . "$i" . "</td><td>" . "$IP" . "</td><td><a href ='in.php?IP=$IP&PORT=$PORT&COMMUNITY=$COMMUNITY'>" . "$COMMUNITY" . "</td><td>" . "$PORT" . "</td></tr>";          
            
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
