<html>
        <head>
            <meta http-equiv="refresh" content="240" />
            <title> ANM </title>                                
         
        </head>
        
        <body>
        <div class ="main">
        <table style = "width:1300px;" cell spacing = "0" cell padding = "0">
        <tr><td colspan ="5" style="background-color:#CEF6D8;">        
        <h1><center> Deleting Server </center></h1>
        <h3><center> Step-1 Click on the Server to Delete</center></h3>
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
          
         
          
         $q1 = mysql_query("SELECT *FROM HTTP");
         echo "<table border=1>
               <tr><td>S.No</td><td>IP</td><td>PORT</td>";
         $i=1;                
         while($row=mysql_fetch_array($q1)):
          {
            $ID = $row['ID']; $IP = $row['IP']; $PORT = $row['HTTPPORT'];
            $server = "$IP-$PORT";
            echo "<tr><td>" . $i . "</td><td>" ."<a href='d3s1.php?ID=$ID&server=$server'>" . $row['IP'] . "</td><td>" . $row['HTTPPORT'] . "</td></tr>";
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
