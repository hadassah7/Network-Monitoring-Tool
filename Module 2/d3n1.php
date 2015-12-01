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
        </td></tr>      
         
        <tr>
        <td colspan = "1">
        <a href='index.php'>HOME</td> 
            	    
            	    
            	   
            	    	
        <td style="height:600px;width:2000px;vertical-align:top;">
        <center><br>   
       <?php
       include "credentials.php";
       
       $ID = $_GET['ID'];
       $device = $_GET['device'];
       $path = dirname(__FILE__);
       $db = mysql_connect("$host:$port",$user,$pwd)
              or die ("Database could not be connected");
             $c = mysql_select_db($database,$db)
              or die ("Database could not be selected");
          
         
         $q1 = mysql_query("DELETE FROM Network WHERE `ID`='$ID'");
         
         if(!$q1){
           echo ("ERROR: " . mysql_error());
         }
         else{
         echo "Device is deleted";
         unlink("$path/$device.rrd");
         }
          mysql_close($db);
       
       ?>
       </center>
        
        </table>
        </div>
        </body>
</html>        
