<html>
        <head>
            <title> ANM </title>                                
         
        </head>
        
        <body>
        <div class ="main">
        <table style = "width:1300px;" cell spacing = "0" cell padding = "0">
        <tr><td colspan ="5" style="background-color:#CEF6D8;">        
        <h1><center> Adding Network Device</center></h1>
        </td></tr>      
         
        <tr>
        <td colspan = "1">
        <a href='index.php'>HOME</td> 
            	    
            	    
            	   
            	    	
        <td style="height:600px;width:2000px;vertical-align:top;">
        <center><br>
         
          <?php
        $list = $_POST["list"];
        $in = array();
        foreach ( $list as $x){
        $n = explode(',',$x);
        array_push($in,$n[0]);
        $device = $n[1];
        }          
        
        $in = implode('-',$in);
        $z = explode('-',$device);
        $COMMUNITY = $z[0];
        $IP = $z[1];
        $PORT = $z[2];
        
        include "credentials.php";
           
           //connection to the database
           
           $db = mysql_connect("$host:$port",$user,$pwd)
           or die ("Database could not be connected");
           
           $c = mysql_select_db($database,$db)
            or die ("Database could not be selected");
            $query = mysql_query("SELECT *FROM Network");
            
            while($row = mysql_fetch_array($query)):
          {
            if( $IP==$row['IP'] && $COMMUNITY==$row['COMMUNITY'] && $PORT==$row['PORT']){
              echo "<br><br>Device already exists<br>";
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
             $query2 = "INSERT INTO Network (IP,PORT,COMMUNITY,Interfaces) VALUES('$IP','$PORT','$COMMUNITY','$in')";
             if(!mysql_query($query2)){
              echo "<br><br> Error: " . mysql_error();
             }
             
              echo "<br><br> Added Network Device to database";             
              mysql_close($db);             
           }
       ?>
              </center>
        
        </table>
        </div>
        </body>
</html>        
