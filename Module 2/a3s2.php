<html>
        <head>
            <title> ANM </title>                                
         
        </head>
        
        <body>
        <div class ="main">
        <table style = "width:1300px;" cell spacing = "0" cell padding = "0">
        <tr><td colspan ="5" style="background-color:#CEF6D8;">        
        <h1><center> Adding Server </center></h1>
        </td></tr>      
         
        <tr>
        <td colspan = "1">
        <a href='index.php'>HOME</td> 
            	    
            	    
            	   
            	    	
        <td style="height:600px;width:2000px;vertical-align:top;">
        <center><br>   
       <?php
         $IP = $_POST['IP'];
         $HTTPPORT = $_POST['HTTPPORT'];
         
         include "credentials.php";
         $db = mysql_connect("$host:$port",$user,$pwd)
           or die ("Database could not be connected");
           
           $c = mysql_select_db($database,$db)
            or die ("Database could not be selected");
            $query = mysql_query("SELECT *FROM HTTP");
            
            while($row = mysql_fetch_array($query)):
          {
            if( $IP==$row['IP'] && $HTTPPORT==$row['HTTPPORT']){
              echo "<br><br>Server with same details already exists<br>";
              $i=1;           
            }
          }
          endwhile;
          mysql_close($db);
          
          if($i!=1)
           {
             $db = mysql_connect("$host:$port",$user,$pwd)
              or die ("Database could not be connected");
             $c = mysql_select_db($database,$db)
              or die ("Database could not be selected");
             $query2 = "INSERT INTO HTTP (IP,HTTPPORT) VALUES('$IP','$HTTPPORT')";
             if(!mysql_query($query2)){
              echo "<br><br> Error: " . mysql_error();
             }
             
              echo "<br><br> Added HTTP server to database";             
              mysql_close($db);             
           }      
       ?>
       </table>
       </center>
        
        </table>
        </div>
        </body>
</html>        
