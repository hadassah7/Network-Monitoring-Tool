<html>
        <head>
            <meta http-equiv="refresh" content="240" />
            <title> ANM </title>                                
         
        </head>
        
        <body>
        <div class ="main">
        <table style = "width:1300px;" cell spacing = "0" cell padding = "0">
        <tr><td colspan ="5" style="background-color:#CEF6D8;">        
        <h1><center> Assignment 4 </center></h1>
        </td></tr>      
         
        <tr>
        <td colspan = "5" style="background-color:#CEF6D8;">
                    <?php
					
                        include "credentials.php";
					  
                        //connection to the database
                        $db = mysql_connect($host, $user, $pwd)
                        or die("Unable to connect to MySQL");
					  
					  
                        //select a database to work
                        $s = mysql_select_db("$database",$db)
                        or die("Could not select assign5");
					  
			$ID=$_GET['ID'];
			
                        $query= mysql_query("SELECT *FROM Sysuptime WHERE ID='$ID'");
			     		
			$row= mysql_fetch_array($query);
                        echo "<center><table border='1'>
                              <tr><td> HOST </td><td>" . $HOST=$row['HOST'] .
                              "</td></tr><tr><td> COMMUNITY </td><td>" . $COMMUNITY= $row['COMMUNITY'] .
                              "</td></tr><tr><td> Sysuptime </td><td>" . $Sysuptime=$row['Sysuptime'] .
                              "</td></tr><tr><td> Last Updated Time </td><td>" . $Time=$row['Time'] .
                              "</td></tr><tr><td> Total requests that are sent </td><td>" . $TotalRequests=$row['SentRequests'] .
			      "</td></tr><tr><td> Total requests that are missed </td><td>" . $MissedRequests=$row['MissedRequests'] .
                              "</td></tr>";
                              
                        echo "</table></center>";
			                       
	                mysql_close($db);
			  
                        
	                ?>
            	    	
        
        </table>
        </div>
        </body>
</html>        
