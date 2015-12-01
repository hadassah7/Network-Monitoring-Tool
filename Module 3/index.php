
<html>
        <head>
            <meta http-equiv="refresh" content="240" />
            <title> ANM </title>                                
         
        </head>
        
        <body>
        <div class ="main">
        <table style = "width:1300px;" cell spacing = "0" cell padding = "0">
        <tr><td colspan ="5" style="background-color:#CEF6D8;">        
        <h1><center> Assignment 3 </center></h1>
        </td></tr>      
         
        <tr>
        <td colspan = "5">
                    <center> 
                    <form action = "2.php" method = "POST">        	
                    <?php
                    include "credentials.php";
                                        
                    $db = mysql_connect("$host:$port",$user,$pwd)
          or die ("Unable to connect to the Database");
         $connect = (mysql_select_db($database,$db))
          or die ("Database could not be selected");
          
         
          
         $query = mysql_query("SELECT *FROM TRAPS");
         echo "<br><table border=2>
                    <tr><td>S.No</td>
                        <td>FQDN of the Device</td>
                        <td>Status</td>
                        <td>Last Reported time</td></tr>";
        $i=1;
          while($row = mysql_fetch_array($query)):
          {
            $Message = $row['Message'];$Status = $row['PRESENT_S']; $time = $row['PRESENT_T'];
              if ($Status == 0)
              { $TRAP = "OK";}
              elseif($Status == 1)
              { $TRAP = "PROBLEM";}
              elseif($Status == 2)
              {$TRAP = "DANGER";}
              elseif($Status == 3)
              { $TRAP = "FAIL";}            
            echo "<tr><td>" . "$i" . "</td><td>" . "$Message" . "</td><td>" . "$TRAP" . "</td><td>" . "$time" . "</td></tr>";          
            
            $i++;
          }
          endwhile;
          echo "</table><br>";
          mysql_close($db);
                    
                    
                    
                    ?>
                    <table border = '2' width =1000 align=center cell padding= 10>
       <tr><th Colspan =2>Enter the following fields</th></tr>
       <tr><td> IP of the Device </td><td><input type="tinytext" name="IP" aria-describedby="number-format" required aria-required="true"></td></tr>
       <tr><td> PORT </td><td><input type="text" name="PORT" aria-describedby="number-format" required aria-required="true"></td></tr>
       <tr><td> COMMUNITY </td><td><input type="text" name="COMMUNITY" aria-describedby="number-format" required aria-required="true"></td></tr>
       <tr><td Colspan = '2' align="center"><input type ="submit" name ="formsubmit" value="Add Details"></td></tr></tr>
               	    </td></center></tr>
            	    	
        
        </table>
        </div>
        </body>
</html>        
