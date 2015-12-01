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
        <center> 
        <tr>
        <td colspan = "5" style="background-color:#CEF6D8;">
                    <?php
					
                        include "credentials.php";
                        					  
                        //connection to the database
                        $db = mysql_connect("$host:$port", $user, $pwd)
                        or die("Unable to connect to MySQL");
					  
					  
                        //select a database to work
                        $s = mysql_select_db("$database",$db)
                        or die("Could not select database");
					  
					  
                        $query= mysql_query("SELECT *FROM Sysuptime");
					  
                        //fetch results	
                        echo "<br><br>";					  
                        echo "<center><table border='1'>
                        <tr>
                        <td> S.No</td>
                        <td> IP </td>
                        <td> PORT</td>
                        <td> COMMUNITY</td>
			<td> STATUS </td>
                        </tr>";					       
						       
                        $n=1;
                        while ($row= mysql_fetch_array($query))
	                 {
                            $ID=$row['ID'];
			    echo "<tr><td>".$n.
	                    "</td><td>" . "<a href='display.php?ID=$ID'>" . $HOST=$row['HOST'] .							       
	                    "</td><td>" . $PORT= $row['PORT'] .
	                    "</td><td>" . $COMMUNITY= $row['COMMUNITY']  .
			    "</td>";
			    $COLOR=$row['COLOR'];
			    
			    switch($COLOR)
			    {
				case 0:
				echo "<td bgcolor = '#FFFFFF'></td>";
				#echo "<td>White</td>";				
				break;
				
				case 1:
				echo "<td bgcolor = '#FFEEEE'></td>";
				break;
			
				case 2:
				echo "<td bgcolor = '#FFE6E6'></td>";
				break;
			
				case 3:
				echo "<td bgcolor = '#FFDDDD'></td>";
				break;
			
				case 4:
				echo "<td bgcolor = '#FFD6D6'></td>";
				break;
			
				case 5:
				echo "<td bgcolor = '#FFCCCC'></td>";
				break;
			
				case 6:
				echo "<td bgcolor = '#FFC6C6'></td>";
				break;
			
				case 7:
				echo "<td bgcolor = '#FFBBBB'></td>";
				break;
			
				case 8:
				echo "<td bgcolor = '#FFB6B6'></td>";
				break;
			
				case 9:
				echo "<td bgcolor = '#FFAAAA'></td>";
				break;
			
				case 10:
				echo "<td bgcolor = '#FFA6A6'></td>";
				break;
			
				case 11:
				echo "<td bgcolor = '#FF9999'></td>";
				break;
			
				case 12:
				echo "<td bgcolor = '#FF9696'></td>";
				break;
			
				case 13:
				echo "<td bgcolor = '#FF8888'></td>";
				break;
			
				case 14:
				echo "<td bgcolor = '#FF8686'></td>";
				break;
			
				case 15:
				echo "<td bgcolor = '#FF7777'></td>";
				break;
			
				case 16:
				echo "<td bgcolor = '#FF7676'></td>";
				break;
			
				case 17:
				echo "<td bgcolor = '#FF6868'></td>";
				break;
			
				case 18:
				echo "<td bgcolor = '#FF6666'></td>";
				break;
			
				case 19:
				echo "<td bgcolor = '#FF5656'></td>";
				break;
			
				case 20:
				echo "<td bgcolor = '#FF5555'></td>";
				break;
			
				case 21:
				echo "<td bgcolor = '#F4646'></td>";
				break;
			
				case 22:
				echo "<td bgcolor = '#FF4444'></td>";
				break;
			
				case 23:
				echo "<td bgcolor = '#FF3636'></td>";
				break;
			
				case 24:
				echo "<td bgcolor = '#FF3333'></td>";
				break;
			
				case 25:
				echo "<td bgcolor = '#FF2626'></td>";
				break;
			
				case 26:
				echo "<td bgcolor = '#FF2222'></td>";
				break;
			
				case 27:
				echo "<td bgcolor = '#FF1616'></td>";
				break;
			
				case 28:
				echo "<td bgcolor = '#FF1111'></td>";
				break;
			
				case 29:
				echo "<td bgcolor = '#FF0606'></td>";
				break;
			
				case 30:
				echo "<td bgcolor = '#FF0000'></td>";    
			        break;
			    }
	                    $n++;
			    
	                 }
	    
	                echo "</table></center>";
				
                        //close the connection
	                mysql_close($db);
	                ?>
            	    	
        
        </table>
        </div>
        </body>
</html>        
