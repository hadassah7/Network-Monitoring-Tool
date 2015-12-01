<html>
        <head>
            <title> ANM </title>                                
         
        </head>
        
        <body>
        <div class ="main">
        <table style = "width:1300px;" cell spacing = "0" cell padding = "0">
        <tr><td colspan ="5" style="background-color:#CEF6D8;">        
        <h1><center> Add Network Device </center></h1>
        <h3><center>Step 2 - Select Interfaces to be monitored</center></h3>
        </td></tr>      
         
        <tr>
        <td colspan = "1">
        <a href='index.php'>HOME</td> 
            	    
            	    
            	   
            	    	
        <td style="height:600px;width:2000px;vertical-align:top;">
        <center><br>
        <form action = "a3n3.php" method = "POST">  
          <?php
        $IP = $_POST["IP"];
          $PORT = $_POST["PORT"];
          $COMMUNITY = $_POST["COMMUNITY"];
          
          $int = snmpwalk ("$IP:$PORT","$COMMUNITY",'1.3.6.1.2.1.2.2.1.1',100000,5);
          $device = "$COMMUNITY-$IP-$PORT";
          if($int){
          echo "The interfaces of the selected device $COMMUNITY, $IP and $PORT are:";
          echo "<br><table border = '1'>"; 
        foreach($int as $x){
        $i = explode(' ',$x);
        echo "<tr><td><input type = 'checkbox' name ='list[]' value = $i[1],$device> $i[1]</td></tr>";}
          }
        else {
          echo "<br>The device is down. Cannot add<br>";
        }
       ?>     
       </table><br>

       <input type ="submit" value = "Add Network Device">
              </center>
        
        </table>
        </div>
        </body>
</html>        
