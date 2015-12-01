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
                          	
                    <?php
                    include "credentials.php";
                    $IP = $_POST['IP'];
                    $PORT = $_POST['PORT'];
                    $COMMUNITY = $_POST['COMMUNITY'];
                    
                    $db = mysql_connect("$host:$port",$user,$pwd)
          or die ("Unable to connect to the Database");
         $connect = (mysql_select_db($database,$db))
          or die ("Database could not be selected");
          
         $query1 = mysql_query("SELECT IP FROM `Fail` WHERE `ID`= '1'");
         $number = mysql_num_rows($query1);
          
         if ($number == 0){
         $query = "INSERT INTO `Fail` (`IP`,`PORT`,`COMMUNITY`) VALUES ('$IP','$PORT','$COMMUNITY')";
         mysql_query($query);
          echo "<br><br>Details added to send trap when Fail or Danger trap is received";
         }
         elseif ( $number == 1){
         $query = "UPDATE `Fail` SET 'IP'='$IP', 'PORT'='$PORT','COMMUNITY'='$COMMUNITY' WHERE `ID` = 1";
         mysql_query($query);
         echo "<br><br>Details modified to send trap when Fail or Danger trap is received";
         }
         
          mysql_close($db);
                    
                    
                    
                    ?>
                             	    	
        
        </table>
        </div>
        </body>
</html>        
